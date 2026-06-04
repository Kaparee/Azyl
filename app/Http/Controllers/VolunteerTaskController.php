<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VolunteerTaskController extends Controller
{
    public function index(Request $request)
    {
        return view('volunteer-tasks.index');
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
