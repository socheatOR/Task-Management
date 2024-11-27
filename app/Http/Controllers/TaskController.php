<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Carbon\Carbon;

class TaskController extends Controller
{
    // Get all tasks
    public function index()
    {
        return response()->json(Task::all());
    }

    // Store a new task
    public function store(Request $request)
    {
        // Convert the incoming due_date to the correct format
        $dueDate = Carbon::createFromFormat('d-m-Y', $request->due_date)->format('Y-m-d');
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'completed' => 'nullable|boolean',
        ]);
         // Create the task
        $task = Task::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'due_date' => $dueDate, // Use the formatted due_date
            'completed' => $validatedData['completed'],
        ]);
      

        return response()->json($task, 201);
    }

    // Get a single task
    public function show(Task $task)
    {
        return response()->json($task);
    }

    // Update a task
    
    public function update(Request $request, $id)
    {
            // Find the task by its ID
            $task = Task::findOrFail($id);
        
            // Convert the incoming due_date to the correct format
            $dueDate = Carbon::createFromFormat('d-m-Y', $request->due_date)->format('Y-m-d');
        
            // Validate the request
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'due_date' => 'required|date',
                'completed' => 'required|boolean',
            ]);
        
            // Update the task with the validated data
            $task->update([
                'title' => $validatedData['title'],
                'description' => $validatedData['description'],
                'due_date' => $dueDate, // Use the formatted due_date
                'completed' => $validatedData['completed'],
            ]);
        
            return response()->json($task, 200);
   
    }

    // Delete a task
    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json(['message' => 'Task deleted successfully.']);
    }
}
