<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/alltasks', function () {
    return Inertia::render('AllTasks');
})->middleware(['auth', 'verified'])->name('alltasks');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



// Route::middleware('auth')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::middleware('auth')->group(function () {
//     Route::get('/alltasks', [TaskController::class, 'alltasks']);
//     Route::get('/tasks', [TaskController::class, 'index']);
//     Route::post('/tasks', [TaskController::class, 'store']);
//     Route::put('/tasks/{task}', [TaskController::class, 'update']);
//     Route::delete('/tasks/{task}', [TaskController::class, 'destroy']);
//     Route::patch('/tasks/{task}/toggle', [TaskController::class, 'toggleCompletion']);
// });

require __DIR__.'/auth.php';
