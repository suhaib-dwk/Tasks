<?php

namespace App\Http\Controllers;

use App\Exports\TasksExport;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with('users')->get();
        $users = User::where('role', 'Employee')->get();
        return view('admin.dashboard', compact('tasks', 'users'));
    }

    public function create()
    {
        $users = User::where('role', 'Employee')->get();
        return view('admin.component.createTask', compact('users'));
    }

    public function store(TaskRequest $request)
    {
        $validatedData = $request->validated();

        $task = Task::create($validatedData);
        $task->users()->attach($request->user_id);

        return redirect()->route('dashboard')->with('success', 'Task added successfully!');
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->users()->detach();
        $task->delete();
        return redirect()->back()->with('success', 'Task deleted successfully.');
    }

    public function update(TaskRequest $request, $id)
    {
        $task = Task::findOrFail($id);
        $validatedData = $request->validated();

        $task->update($validatedData);
        $task->users()->sync($request->user_ids);

        return redirect()->back()->with('success', 'Task updated successfully.');
    }

    public function submitTask(Request $request)
{
    $request->validate([
        'task_id' => 'required|exists:tasks,id',
    ]);

    $user = auth()->user();

    $task = Task::find($request->task_id);

    $user->tasks()->updateExistingPivot($task, ['submit' => 1]);

    return response()->json(['message' => 'Task submitted successfully']);
}

    public function exportToExcel()
    {
        return Excel::download(new TasksExport, 'tasks.xlsx');
    }
}
