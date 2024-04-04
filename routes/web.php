<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Route::middleware('admin')->group(function () {
//     Route::get('/dashboard', function () {
//         return view('admin.dashboard');
//     });
// });

Route::middleware('admin')->group(function () {
    Route::get('/dashboard', [TaskController::class, 'index'])->name('dashboard');
    Route::delete('/task/{id}', [TaskController::class, 'destroy'])->name('task.destroy');
    Route::patch('/task/{id}', [TaskController::class, 'update'])->name('task.update');
    Route::get('/admin/component/create-task', [TaskController::class, 'create'])
        ->name('admin.component.createTask');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');

    Route::get('/admin/component/create-user', [UserController::class, 'create'])
        ->name('admin.component.createUser');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::post('/submit-task', [TaskController::class, 'submitTask'])->name('submit.task');
    Route::get('/check-submission/{taskId}', [TaskController::class, 'checkSubmission']);
    Route::get('/search/tasks', [TaskController::class, 'search'])->name('search.tasks');
    Route::get('/task/{id}', [TaskController::class, 'show'])->name('task.show');


    Route::get('/export/tasks/excel', [TaskController::class, 'exportToExcel'])->name('export.tasks.excel');
});

Route::middleware('employee')->group(function () {
    Route::get('/home', [ClientController::class, 'index'])->name('home');
});
