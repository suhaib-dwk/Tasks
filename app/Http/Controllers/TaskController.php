<?php

namespace App\Http\Controllers;

use App\Exports\TasksExport;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = Task::with('users');

        if ($request->has('query')) {
            $query = $request->input('query');
            $tasks->where('title', 'like', '%' . $query . '%');
        }

        $tasks = $tasks->latest()->paginate(6);

        $users = User::where('role', 'Employee')->paginate(5);

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

        $validatedData['start_date'] = Carbon::createFromFormat('Y-m-d', $validatedData['start_date']);
        $validatedData['end_date'] = Carbon::createFromFormat('Y-m-d', $validatedData['end_date']);

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

        // Sync the assigned users
        $task->users()->sync($request->input('user_ids', []));

        return redirect()->back()->with('success', 'Task updated successfully.');
    }

    public function checkSubmission($taskId)
    {
        $task = Task::find($taskId);
        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        // Assuming you have a submitted field in your tasks table
        $submitted = $task->submitted;

        return response()->json(['submitted' => $submitted]);
    }

    public function show($id)
    {
        $task = Task::findOrFail($id);
        $users = $task->users;
        return view('admin.component.viewTaskModal', compact('task', 'users'));
    }


    public function submitTask(Request $request)
{
    $request->validate([
        'task_id' => 'required|exists:tasks,id',
    ]);

    $user = auth()->user();
    $task = Task::find($request->task_id);

    $user->tasks()->syncWithoutDetaching([$task->id => ['submit' => 1, 'submitted_at' => Carbon::now()]]);

    $totalUsers = $task->users->count();
    $submittedUsers = $task->users()->wherePivot('submit', 1)->count();

    if ($submittedUsers == 0) {
        $task->status = 'Open';
    } elseif ($submittedUsers == $totalUsers) {
        $task->status = 'Closed';
    } else {
        $task->status = 'Pending';
    }

    $task->save();

    return response()->json(['message' => 'Task submitted successfully']);
}

    public function search(Request $request)
{
    $request->validate([
        'query' => 'required|string',
    ]);

    try {
        $tasks = Task::where('title', 'like', '%' . $request->input('query') . '%')->get();

        return view('admin.component.taskSearchResults', ['tasks' => $tasks]);
    } catch (\Exception $e) {


        return view('errors.generic', ['message' => 'An unexpected error occurred. Please try again later.']);
    }
}


    public function exportToExcel()
    {
        return Excel::download(new TasksExport, 'tasks.xlsx');
    }
}
