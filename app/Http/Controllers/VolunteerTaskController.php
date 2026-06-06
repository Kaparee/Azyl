<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VolunteerTaskController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        
        $baseQuery = VolunteerTask::where('assigned_to', $userId);
        
        $completed = (clone $baseQuery)->where('status', 3)->count();
        $total = (clone $baseQuery)->count();
        $total = $total > 0 ? $total : 1;
        
        $urgentTasks = (clone $baseQuery)->where('status', 1)->orderBy('time')->take(2)->get();
        
        $tasksQuery = clone $baseQuery;
        if ($request->has('status') && $request->status !== null) {
            $tasksQuery->where('status', $request->status);
        }
        $tasks = $tasksQuery->orderBy('time')->paginate(10);
        
        $statusCounts = (clone $baseQuery)->selectRaw('status, count(*) as count')->groupBy('status')->pluck('count', 'status')->toArray();

        $volunteers = [];
        if (in_array(Auth::user()->role_id, [1, 2])) {
            $volunteers = \App\Models\User::where('role_id', 4)->get();
        }

        return view('volunteer-tasks.index', compact('tasks', 'urgentTasks', 'completed', 'total', 'statusCounts', 'volunteers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'assigned_to' => 'required|exists:users,id',
            'time' => 'required',
            'description' => 'nullable|string',
        ]);

        $validated['status'] = 1;
        $validated['date'] = now()->toDateString();

        \App\Models\VolunteerTask::create($validated);

        return back()->with('success', 'Zadanie zostało przypisane wolontariuszowi.');
    }

    public function update(Request $request, \App\Models\VolunteerTask $task)
    {
        $validated = $request->validate([
            'status' => 'required|integer|in:1,2,3',
        ]);

        $task->update(['status' => $validated['status']]);

        return back()->with('status', 'Zaktualizowano status zadania.');
    }
}
