<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VolunteerTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VolunteerTaskController extends Controller
{
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

        $completed = (clone $baseQuery)->where('status', 3)->count();
        $total = (clone $baseQuery)->count();
        $total = $total > 0 ? $total : 1;

        $urgentTasks = (clone $baseQuery)->where('is_urgent', true)->where('status', '!=', 3)->orderBy('time')->take(2)->get();

        $tasksQuery = clone $baseQuery;
        if ($request->has('status') && $request->status !== null && $request->status !== '') {
            $tasksQuery->where('status', $request->status);
        }
        $tasks = $tasksQuery->with('assignedUser')
            ->orderByDesc('is_urgent')
            ->orderBy('status', 'asc')
            ->orderBy('time', 'asc')
            ->get();

        $statusCounts = (clone $baseQuery)->selectRaw('status, count(*) as count')->groupBy('status')->pluck('count', 'status')->toArray();

        $allTasks = (clone $baseQuery)->get();

        $volunteers = [];
        if (in_array($userRole, [1, 2, 3])) {
            $volunteers = User::where('role_id', 4)->get();
        }

        return view('volunteer-tasks.index', compact('tasks', 'urgentTasks', 'completed', 'total', 'statusCounts', 'volunteers', 'allTasks'));
    }

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

        VolunteerTask::create($validated);

        return back()->with('success', 'Zadanie zostało przypisane wolontariuszowi.');
    }

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
            $task->update($validated);

            return back()->with('success', 'Zadanie zaktualizowano pomyślnie.');
        }

        $validated = $request->validate([
            'status' => 'required|integer|in:1,2,3',
        ]);
        $task->update(['status' => $validated['status']]);

        return back()->with('success', 'Zaktualizowano status zadania.');
    }

    public function destroy(VolunteerTask $task)
    {
        $task->delete();

        return back()->with('success', 'Usunięto zadanie.');
    }
}
