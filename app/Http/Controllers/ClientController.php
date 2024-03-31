<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ClientController extends Controller
{
    public function index()
    {
        $tasks = auth()->user()->tasks;
        return view('clients.index', compact('tasks'));
    }


}
