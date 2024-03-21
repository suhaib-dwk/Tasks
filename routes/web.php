<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);


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
    Route::get('/export/tasks/excel', [TaskController::class, 'exportToExcel'])->name('export.tasks.excel');
});
