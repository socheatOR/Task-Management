<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TaskController extends Controller
{
    // Get all tasks
    public function index()
    {
        return response()->json(Task::orderBy('id', 'asc')->get());
    }

    // Store a new task
    public function store(Request $request)
    {
        // Validate the incoming request data
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'due_date' => 'required|date_format:d-m-Y', // Validate the due date format
                'completed' => 'nullable|boolean',
            ]);
       
            // Convert the incoming due_date to the correct format
            $dueDate = Carbon::createFromFormat('d-m-Y', $request->due_date)->format('Y-m-d');

            // Create the task
            $task = Task::create([
                'title' => $validatedData['title'],
                'description' => $validatedData['description'],
                'completed' => false,
                'due_date' => $dueDate, // Use the formatted due_date
            ]);
        
            return response()->json($task, 201);
        } catch (ValidationException $e) {
            Log::error('Validation failed', ['errors' => $e->errors()]);
            // Return validation errors as JSON response
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    // Get a single task
    public function show($id)
    {
        try {
            $task = Task::findOrFail($id);
            return response()->json($task);
        } catch (ModelNotFoundException $e) {
            return response()->json(['errors' => 'Task not found'], 404);
        }
    }

    // Update a task
    
    public function update(Request $request, $id)
    {
        // Find the task by its ID
        $task = Task::findOrFail($id);
        // Validate the incoming request data
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'due_date' => 'required|date_format:d-m-Y', // Validate the due date format
                'completed' => 'nullable|boolean',
            ]);
        
        
            // Convert the incoming due_date to the correct format
            $dueDate = Carbon::createFromFormat('d-m-Y', $request->due_date)->format('Y-m-d');
        
            // Update the task with the validated data
            $task->update([
                'title' => $validatedData['title'],
                'description' => $validatedData['description'],
                'due_date' => $dueDate, // Use the formatted due_date
                'completed' => $validatedData['completed'],
            ]);
        
            return response()->json($task, 200);
        } catch (ValidationException $e) {
            Log::error('Validation failed', ['errors' => $e->errors()]);
            // Return validation errors as JSON response
            return response()->json(['errors' => $e->errors()], 422);
        }
   
    }

    // Delete a task
    public function destroy($id)
    {
        try {
            $task = Task::findOrFail($id);
            $task->delete();
            return response()->json(['message' => 'Task deleted successfully.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['errors' => 'Task not found'], 404);
        }

    }
}
