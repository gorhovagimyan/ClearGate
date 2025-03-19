<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    public function index()
    {
        try {
            $tasks = Task::where('user_id', auth()->id())->latest()->get();
            
            return Inertia::render('Tasks', [
                'tasks' => $tasks
            ]);
        } catch (\Exception $e) {
            Log::error('Error in TaskController@index: ' . $e->getMessage());
            return Inertia::render('Tasks', [
                'tasks' => [],
                'error' => 'An error occurred while loading tasks.'
            ]);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'attachment' => 'nullable|file|max:2048',
                'status' => 'required|string|in:pending,in_progress,completed'
            ]);
            
            $task = new Task();
            $task->title = $validated['title'];
            $task->content = $validated['content'];
            $task->status = $validated['status'];
            $task->user_id = auth()->id();
            
            if ($request->hasFile('attachment')) {
                $path = $request->file('attachment')->store('attachments', 'public');
                $task->attachment = $path;
            }
            
            $task->save();
            
            return back();
        } catch (\Exception $e) {
            Log::error('Error in TaskController@store: ' . $e->getMessage());
            return back()->withErrors(['error' => 'An error occurred while creating the task.']);
        }
    }

    public function update(Request $request, Task $task)
    {
        try {
            // Check if the task belongs to the authenticated user
            if ($task->user_id !== auth()->id()) {
                return back()->withErrors(['error' => 'You are not authorized to update this task.']);
            }
            
            // Check if the task is already completed
            if ($task->status === 'completed') {
                return back()->withErrors(['error' => 'Completed tasks cannot be modified.']);
            }
            
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'attachment' => 'nullable|file|max:2048',
                'status' => 'required|string|in:pending,in_progress,completed'
            ]);
            
            $task->title = $validated['title'];
            $task->content = $validated['content'];
            $task->status = $validated['status'];
            
            if ($request->hasFile('attachment')) {
                $path = $request->file('attachment')->store('attachments', 'public');
                $task->attachment = $path;
            }
            
            $task->save();
            return redirect()->back()->with('success', 'Task updated successfully');
        } catch (\Exception $e) {
            Log::error('Error in TaskController@update: ' . $e->getMessage());
            return back()->withErrors(['error' => 'An error occurred while updating the task.']);
        }
    }

    public function destroy(Task $task)
    {
        try {
            // Check if the task belongs to the authenticated user
            if ($task->user_id !== auth()->id()) {
                return back()->withErrors(['error' => 'You are not authorized to delete this task.']);
            }
            
            $task->delete();
            
            return  redirect()->back()->with('success', 'Task updated successfully');;
        } catch (\Exception $e) {
            Log::error('Error in TaskController@destroy: ' . $e->getMessage());
            return back()->withErrors(['error' => 'An error occurred while deleting the task.']);
        }
    }

    public function updateStatus(Request $request, Task $task)
    {
        try {
            // Check if the task belongs to the authenticated user
            if ($task->user_id !== auth()->id()) {
                return back()->withErrors(['error' => 'You are not authorized to update this task.']);
            }
            
            // Check if the task is already completed
            if ($task->status === 'completed') {
                return back()->withErrors(['error' => 'Completed tasks cannot be modified.']);
            }
            
            $validated = $request->validate([
                'status' => 'required|string|in:pending,in_progress,completed'
            ]);
            
            $task->status = $validated['status'];
            $task->save();
            
            return back();
        } catch (\Exception $e) {
            Log::error('Error in TaskController@updateStatus: ' . $e->getMessage());
            return back()->withErrors(['error' => 'An error occurred while updating the task status.']);
        }
    }
} 