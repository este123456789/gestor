<?php

namespace App\Http\Controllers;

use App\Models\Task;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    //
    public function alltasks(Request $request)
    {
        $tasks = Task::where('user_id', auth()->id())
            ->when($request->completed, function ($query) use ($request) {
                return $query->where('completed', $request->completed);
            })
            ->where(function ($query) use ($request) {
                if ($request->has('search')) {
                    $query->where('title', 'like', '%' . $request->search . '%')
                        ->orWhere('description', 'like', '%' . $request->search . '%');
                }
            })
            ->paginate(10);

            return view('alltasks', $tasks);
    }
    public function index(Request $request)
    {
        // $tasks = Task::where('user_id', auth()->id())
        //     ->when($request->completed, function ($query) use ($request) {
        //         return $query->where('completed', $request->completed);
        //     })
        //     ->where(function ($query) use ($request) {
        //         if ($request->has('search')) {
        //             $query->where('title', 'like', '%' . $request->search . '%')
        //                 ->orWhere('description', 'like', '%' . $request->search . '%');
        //         }
        //     })
        //     ->paginate(10);
        $tasks = Task::all();

        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date',
        ]);





        $task = Task::create([
            'user_id' => 1,
            // 'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
        ]);


        return response()->json($task, 201);
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date',
        ]);

        $task->update($request->all());

        return response()->json($task);
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        return response()->json(null, 204);
    }

    public function toggleCompletion(Task $task)
    {
        $task->completed = !$task->completed;
        $task->save();

        return response()->json($task);
    }
}
