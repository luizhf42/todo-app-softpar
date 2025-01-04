<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Return all todos
        return Todo::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'in:pending,in_progress,completed',
        ]);

        // Create a new todo
        $todo = Todo::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status ?? 'pending', // Default to 'pending'
        ]);

        return response()->json($todo, 201); // Return created todo with status code 201
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Find the todo by ID or return a 404 response
        $todo = Todo::findOrFail($id);
        return response()->json($todo);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Find the todo by ID or return a 404 response
        $todo = Todo::findOrFail($id);

        // Validate the request data
        $request->validate([
            'title' => 'string|max:255',
            'description' => 'string',
            'status' => 'in:pending,in_progress,completed',
            'completed_at' => 'nullable|date',
        ]);

        // Update the todo
        $todo->update($request->all());

        return response()->json($todo);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the todo by ID or return a 404 response
        $todo = Todo::findOrFail($id);

        // Delete the todo
        $todo->delete();

        return response()->noContent(); // Return 204 No Content
    }
}
