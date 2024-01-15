<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\DashboardController;
use App\Models\Patient;

// Welcome Page
Route::get('/', function () {
    return view('welcome');
});

Route::get('/home',function(){
    return view('home');
});

Auth::routes(['verify' => true]);


// Authentication Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/hospitals', [HospitalController::class, 'index'])->name('hospital.index');
    Route::get('/hospitals/{hospital}', [HospitalController::class, 'show'])->name('hospital.show');
    Route::get('/hospitals/register', [HospitalController::class, 'register'])->name('hospital.register');
    Route::post('/hospitals', [HospitalController::class, 'store'])->name('hospital.store');
    Route::get('/hospitals/{hospital}/edit', [HospitalController::class, 'edit'])->name('hospital.edit');
    Route::put('/hospitals/{hospital}', [HospitalController::class, 'update'])->name('hospital.update');
    Route::delete('/hospitals/{hospital}', [HospitalController::class, 'destroy'])->name('hospital.destroy');


});

Route::middleware('auth','verified')->group(function(){
    Route::middleware(['auth', 'verified'])->group(function () {
        // Other Patient Routes
        Route::get('/patients/register', [PatientController::class, 'register'])->name('patients.register');
        Route::post('/patients/store', [PatientController::class, 'store'])->name('patients.store');
        Route::get('/patients/{patient}/edit', [PatientController::class, 'edit'])->name('patients.edit');
        Route::put('/patients/{patient}', [PatientController::class, 'update'])->name('patients.update');
        Route::delete('/patients/{patient}', [PatientController::class, 'destroy'])->name('patients.destroy');
        Route::get('/patients/{patient}', [PatientController::class, 'show'])->name('patients.show');
    });
});

// dashboard routes
Route::middleware('auth', 'verified')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/patients', [DashboardController::class, 'patientsIndex'])->name('dashboard.patients.index');
    Route::get('/dashboard/patients/get', [DashboardController::class, 'getPatients'])->name('dashboard.patients.get');
    Route::post('/dashboard/patients/store', [DashboardController::class, 'storePatient'])->name('dashboard.patients.store');
    Route::post('/dashboard/patients/update/{id}', [DashboardController::class, 'updatePatient'])->name('dashboard.patients.update');
    Route::delete('/dashboard/patients/destroy/{id}', [DashboardController::class, 'deletePatient'])->name('dashboard.patients.destroy');
});