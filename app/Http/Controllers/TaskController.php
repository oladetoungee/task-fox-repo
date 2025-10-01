<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with('categories')->get();
        return Inertia::render('tasks/Index', compact('tasks') );
    }

    public function create()
    {
        return Inertia::render('tasks/Create', [] );
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'categories' => 'nullable|array',
            'categories.*' => 'integer|exists:categories,id',
        ]);

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'status' => 'incomplete',
        ]);

        if ($request->categories) {
            $task->categories()->attach($request->categories);
        }

        return redirect()->route('tasks.index')->with('message', 'Task created successfully!');
    }

    public function view(Task $task)
    {
        return Inertia::render('tasks/View', [
            'task' => $task->load('categories')
        ]);
    }

    public function edit(Task $task)
    {
        return Inertia::render('tasks/Edit', [
            'task' => $task->load('categories')
        ]);
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'categories' => 'nullable|array',
            'categories.*' => 'integer|exists:categories,id',
            'status' => 'nullable|in:incomplete,complete',
        ]);

        $task->update($request->only(['title', 'description', 'due_date', 'status']));
        
        if ($request->has('categories')) {
            $task->categories()->sync($request->categories);
        }

        return redirect()->route('tasks.index')->with('message', 'Task updated successfully!');
    }

    public function delete(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('message', 'Task deleted successfully!');
    }
}
