<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\PatientApiController;
use App\Http\Controllers\Api\NakesApiController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']); // Registrasi Pasien (alias)
Route::post('/register-pasien', [AuthController::class, 'registerPasien']); // Registrasi Pasien (legacy)

/*
|--------------------------------------------------------------------------
| Protected Routes (Sanctum)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // Auth & Profile
    Route::get('/user', [ProfileController::class, 'index']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/profile/update', [ProfileController::class, 'update']);
    Route::get('/profile', [ProfileController::class, 'profile']);

    // --- ADMIN API ---
    Route::prefix('admin')->group(function () {
        Route::get('/pending-users', [AdminController::class, 'getPendingUsers']);
        Route::post('/approve/{id}', [AdminController::class, 'approveUser']);
        Route::post('/reject/{id}', [AdminController::class, 'rejectUser']);
    });

    // --- FITUR PASIEN (MOBILE) ---
    Route::prefix('patient')->group(function () {
        Route::get('/dashboard', [PatientApiController::class, 'getDashboard']);

        // Alarm & Kepatuhan (FR-P03, FR-P05)
        Route::get('/alarms', [PatientApiController::class, 'getAlarms']);
        Route::post('/alarms', [PatientApiController::class, 'storeAlarm']);
        Route::post('/kepatuhan/track', [PatientApiController::class, 'trackKepatuhan']);

        // Diary Harian (FR-P04)
        Route::get('/diary', [PatientApiController::class, 'getDiary']);
        Route::post('/diary', [PatientApiController::class, 'storeDiary']);

        // Refill Obat (FR-P07)
        Route::get('/refill-history', [PatientApiController::class, 'getRefillHistory']);
        Route::post('/refill/request', [PatientApiController::class, 'requestRefill']);

        // Booking Konsultasi (FR-P08)
        Route::get('/nakes-schedules', [PatientApiController::class, 'getNakesSchedules']);
        Route::post('/booking', [PatientApiController::class, 'storeBooking']);
    });

    // --- FITUR NAKES (MOBILE) ---
    Route::prefix('nakes')->group(function () {
        // Monitoring Pasien (FR-T02)
        Route::get('/my-patients', [NakesApiController::class, 'getMyPatients']);
        Route::get('/patient/{id}/details', [NakesApiController::class, 'getPatientDetails']);

        // Konsultasi (FR-T03)
        Route::get('/consultations', [NakesApiController::class, 'getConsultations']);
        Route::post('/consultations/{id}/update-status', [NakesApiController::class, 'updateConsultationStatus']);
    });

    // --- FITUR UMUM ---
    Route::get('/edukasi', [PatientApiController::class, 'getEdukasi']);           // Modul Edukasi
    Route::get('/notifikasi', [PatientApiController::class, 'getNotifications']); // Notifikasi & Broadcast
});