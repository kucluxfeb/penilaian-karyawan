<?php

use App\Http\Controllers\Admin\DivisionController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('dashboard.admin');

Route::get('/divisions', [DivisionController::class, 'index'])->name('index.divisions');
Route::get('/division/create', [DivisionController::class, 'create'])->name('create.division');
Route::post('division/store', [DivisionController::class, 'store'])->name('store.division');
Route::get('/division/edit/{id}', [DivisionController::class, 'edit'])->name('edit.division');
Route::put('/division/{id}', [DivisionController::class, 'update'])->name('update.division');
Route::delete('/division/{id}', [DivisionController::class, 'destroy'])->name('destroy.division');

Route::get('/employees', [EmployeeController::class, 'index'])->name('index.employees');
Route::get('/employee/create', [EmployeeController::class, 'create'])->name('create.employee');
Route::post('employee/store', [EmployeeController::class, 'store'])->name('store.employee');
Route::get('/employee/edit/{id}', [EmployeeController::class, 'edit'])->name('edit.employee');
Route::put('/employee/{id}', [EmployeeController::class, 'update'])->name('update.employee');
Route::delete('/employee/{id}', [EmployeeController::class, 'destroy'])->name('destroy.employee');