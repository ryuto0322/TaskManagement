<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;


Route::get('/', function () {
    return view('welcome');
});

//ダッシュボードアクセス
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function (){
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/tasks/history',[TaskController::class, 'history'])->name('tasks.history');
    //タスクルート

    Route::patch('tasks/{task}/complete',[TaskController::class, 'complete'])->name('tasks.complete');
    Route::get('/tasks/history',[TaskController::class, 'history'])->name('tasks.history');
    Route::get('/tasks/delete',[TaskController::class, 'delete'])->name('tasks.delete');
    Route::resource('tasks', TaskController::class);
    Route::post('tasks/{task}/move-up',[TaskController::class,'moveUp'])->name('tasks.moveUp');
    Route::post('tasks/{task}/move-down',[TaskController::class,'moveDown'])->name('tasks.moveDown');
    
});
require __DIR__.'/auth.php';
