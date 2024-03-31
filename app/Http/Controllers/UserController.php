<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function create()
    {
        return view('admin.component.createUser');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:1',
            'role' => 'required|in:Admin,Employee',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('dashboard')->with('success', 'User created successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->tasks()->detach();
        $user->delete();
        return redirect()->back()->with('success', 'Task deleted successfully.');
    }

}
