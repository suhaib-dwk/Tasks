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
        $tasks = Task::all();
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

        Task::create($validatedData);

        return redirect()->route('dashboard')->with('success', 'Task added successfully!');
    }



    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return redirect()->back()->with('success', 'Task deleted successfully.');
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->update($request->all());
        return redirect()->back()->with('success', 'Task updated successfully.');
    }
    public function exportToExcel()
    {
        return Excel::download(new TasksExport, 'tasks.xlsx');
    }
}
