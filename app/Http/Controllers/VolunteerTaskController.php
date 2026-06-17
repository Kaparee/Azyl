<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\RespondsWithWebOrJson;
use App\Models\User;
use App\Models\VolunteerTask;
use App\Support\DatePresenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VolunteerTaskController extends Controller
{
    use RespondsWithWebOrJson;
    /**
     * Lista zadań — admin/pracownik widzi wszystkie, wolontariusz tylko swoje przypisane.
     */
    public function index(Request $request)
    {
        $userId = Auth::id();
        $userRole = Auth::user()->role_id;

        if (in_array($userRole, [1, 2, 3])) {
            $baseQuery = VolunteerTask::query();
        } else {
            $baseQuery = VolunteerTask::where('assigned_to', $userId);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $baseQuery->where(function ($q) use ($search) {
                $q->where('title', 'like', '%'.$search.'%')
                    ->orWhere('description', 'like', '%'.$search.'%');
            });
        }

        // Klonujemy query — każda statystyka ma własne filtry bez psucia bazowego zapytania.
        $completed = (clone $baseQuery)->where('status', 3)->count();
        $total = (clone $baseQuery)->count();
        $total = $total > 0 ? $total : 1; // unikamy dzielenia przez zero w procentach

        $urgentTasks = (clone $baseQuery)->where('is_urgent', true)->where('status', '!=', 3)->orderBy('time')->take(2)->get();
        $urgentTasks->each(function ($task) {
            $task->setAttribute('time_formatted', DatePresenter::formatTime($task->time));
        });

        $tasksQuery = clone $baseQuery;
        if ($request->has('status') && $request->status !== null && $request->status !== '') {
            $tasksQuery->where('status', $request->status);
        }
        $tasks = $tasksQuery->with('assignedUser')
            ->orderByDesc('is_urgent')
            ->orderBy('status', 'asc')
            ->orderBy('time', 'asc')
            ->get();
        $tasks->each(function ($task) {
            $task->setAttribute('time_formatted', DatePresenter::formatTime($task->time));
        });

        $statusCounts = (clone $baseQuery)->selectRaw('status, count(*) as count')->groupBy('status')->pluck('count', 'status')->toArray();

        $allTasks = (clone $baseQuery)->get();

        $volunteers = [];
        if (in_array($userRole, [1, 2, 3])) {
            $volunteers = User::where('role_id', 4)->get();
        }

        $todayFormatted = DatePresenter::todayPolish();
        $canAssignTasks = in_array($userRole, [1, 2, 3]);

        return view('volunteer-tasks.index', compact('tasks', 'urgentTasks', 'completed', 'total', 'statusCounts', 'volunteers', 'allTasks', 'todayFormatted', 'canAssignTasks'));
    }

    /** Nowe zadanie domyślnie „do zrobienia” na dziś — formularz nie pyta o datę ani status. */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'assigned_to' => 'required|exists:users,id',
            'time' => 'required',
            'description' => 'nullable|string',
            'is_urgent' => 'sometimes|boolean',
        ]);

        $validated['status'] = 1;
        $validated['date'] = now()->toDateString();
        $validated['is_urgent'] = $request->boolean('is_urgent');

        $task = VolunteerTask::create($validated);

        return $this->jsonOrRedirect(
            $request,
            'Zadanie zostało przypisane wolontariuszowi.',
            ['task' => $task],
            201,
            null,
            'success'
        );
    }

    /**
     * Dwa tryby: pełna edycja (formularz) albo szybka zmiana statusu z listy.
     */
    public function update(Request $request, VolunteerTask $task)
    {
        if ($request->has('title')) {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'assigned_to' => 'required|exists:users,id',
                'time' => 'required',
                'description' => 'nullable|string',
                'status' => 'required|integer|in:1,2,3',
                'is_urgent' => 'sometimes|boolean',
            ]);

            $validated['is_urgent'] = $request->boolean('is_urgent');
            return $this->jsonOrRedirect(
                $request,
                'Zadanie zaktualizowano pomyślnie.',
                ['task' => $task],
                200,
                null,
                'success'
            );
        }

        $validated = $request->validate([
            'status' => 'required|integer|in:1,2,3',
        ]);
        $task->update(['status' => $validated['status']]);

        return $this->jsonOrRedirect(
            $request,
            'Zaktualizowano status zadania.',
            ['task' => $task],
            200,
            null,
            'success'
        );
    }

    /** Usunięcie z listy — historia zadań nie jest archiwizowana, bo to panel operacyjny, nie raport. */
    public function destroy(VolunteerTask $task)
    {
        $task->delete();

        return $this->jsonOrRedirect(
            request(),
            'Usunięto zadanie.',
            [],
            200,
            null,
            'success'
        );
    }
}
