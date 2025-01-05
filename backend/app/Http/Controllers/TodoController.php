<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::all();
        return response()->json($todos);
    }

    public function show(Todo $todo)
    {
        return response()->json($todo);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:pending,in progress,completed'
        ]);

        $todo = new Todo($validated);

        // Set completed_at based on initial status
        $todo->completed_at = ($validated['status'] === 'completed')
            ? Carbon::now('America/Sao_Paulo')
            : null;

        $todo->save();

        return response()->json($todo, 201);
    }

    public function update(Request $request, Todo $todo)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'status' => 'sometimes|required|in:pending,in progress,completed'
        ]);

        // Handle completed_at based on status change
        if (isset($validated['status'])) {
            // If changing to completed, set timestamp
            if ($validated['status'] === 'completed') {
                $todo->completed_at = Carbon::now('America/Sao_Paulo');
            }
            // If changing from completed to any other status, clear timestamp
            else if ($todo->status === 'completed') {
                $todo->completed_at = null;
            }
        }

        $todo->fill($validated);
        $todo->save();

        return response()->json($todo);
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();
        return response()->json(null, 204);
    }
}