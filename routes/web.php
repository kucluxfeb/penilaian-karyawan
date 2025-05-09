<?php

use App\Http\Controllers\Admin\DivisionController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\JournalController;
use App\Http\Controllers\Assessment\AssessmentController;
use App\Http\Controllers\Assessment\CriteriaController;
use App\Http\Controllers\Assessment\SubCriteriaController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('dashboard.admin');
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard.admin');

Route::get('/login', [AuthController::class, 'showLogin'])->name('view.login');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegister'])->name('view.register');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::middleware(['auth', CheckRole::class.':Admin'])->group(function () {
    Route::get('/divisions', [DivisionController::class, 'index'])->name('index.divisions');
    Route::get('/division/create', [DivisionController::class, 'create'])->name('create.division');
    Route::post('division/store', [DivisionController::class, 'store'])->name('store.division');
    Route::get('/division/edit/{id}', [DivisionController::class, 'edit'])->name('edit.division');
    Route::put('/division/{id}', [DivisionController::class, 'update'])->name('update.division');
    Route::delete('/division/{id}', [DivisionController::class, 'destroy'])->name('destroy.division');
});

Route::middleware(['auth', CheckRole::class.':Admin,Karyawan'])->group(function () {
    Route::get('/employees', [EmployeeController::class, 'index'])->name('index.employees');
    Route::get('/employee/create', [EmployeeController::class, 'create'])->name('create.employee');
    Route::post('employee/store', [EmployeeController::class, 'store'])->name('store.employee');
    Route::get('/employee/edit/{id}', [EmployeeController::class, 'edit'])->name('edit.employee');
    Route::put('/employee/{id}', [EmployeeController::class, 'update'])->name('update.employee');
    Route::delete('/employee/{id}', [EmployeeController::class, 'destroy'])->name('destroy.employee');
});

Route::middleware(['auth', CheckRole::class.':Admin,Tim Penilai'])->group(function () {
    Route::get('/criterias', [CriteriaController::class, 'index'])->name('index.criterias');
    Route::get('/criteria/create', [CriteriaController::class, 'create'])->name('create.criteria');
    Route::post('criteria/store', [CriteriaController::class, 'store'])->name('store.criteria');
    Route::get('/criteria/edit/{id}', [CriteriaController::class, 'edit'])->name('edit.criteria');
    Route::put('/criteria/{id}', [CriteriaController::class, 'update'])->name('update.criteria');
    Route::delete('/criteria/{id}', [CriteriaController::class, 'destroy'])->name('destroy.criteria');

    Route::get('/sub-criteria/{criteria}', [SubCriteriaController::class, 'index'])->name('index.subCriterias');
    Route::get('/sub-criteria/create/{criteria}', [SubCriteriaController::class, 'create'])->name('create.subCriteria');
    Route::post('sub-criteria/store', [SubCriteriaController::class, 'store'])->name('store.subCriteria');
    Route::get('/sub-criteria/edit/{id}', [SubCriteriaController::class, 'edit'])->name('edit.subCriteria');
    Route::put('/sub-criteria/{id}', [SubCriteriaController::class, 'update'])->name('update.subCriteria');
    Route::delete('/sub-criteria/{id}', [SubCriteriaController::class, 'destroy'])->name('destroy.subCriteria');
});

Route::middleware(['auth', CheckRole::class.':Admin,Karyawan,Tim Penilai'])->group(function () {
    Route::get('/journals', [JournalController::class, 'index'])->name('index.journals');
    Route::get('/journal/create', [JournalController::class, 'create'])->name('create.journal');
    Route::post('journal/store', [JournalController::class, 'store'])->name('store.journal');
    Route::get('/journal/edit/{id}', [JournalController::class, 'edit'])->name('edit.journal');
    Route::put('/journal/{id}', [JournalController::class, 'update'])->name('update.journal');
    Route::delete('/journal/{id}', [JournalController::class, 'destroy'])->name('destroy.journal');
});

Route::middleware(['auth', CheckRole::class.':Admin,Tim Penilai,Kepala Sekolah'])->group(function () {
    Route::get('/assessments', [AssessmentController::class, 'index'])->name('index.assessments');
    Route::post('/assessment/store', [AssessmentController::class, 'store'])->name('store.assessment');
    Route::get('/assessment/result', [AssessmentController::class, 'result'])->name('result.assessment');
    Route::get('/result/export/{format}', [AssessmentController::class, 'export'])->name('export.assessment');
});