<?php

use App\Http\Controllers\Api\AppointmentApiController;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\BlogApiController;
use App\Http\Controllers\Api\ClinicApiController;
use App\Http\Controllers\Api\DoctorProfileApiController;
use App\Http\Controllers\Api\EducationApiController;
use App\Http\Controllers\Api\PortfolioSectionApiController;
use App\Http\Controllers\Api\PrescriptionApiController;
use App\Http\Controllers\Api\ReviewApiController;
use App\Http\Controllers\Api\RoleApiController;
use App\Http\Controllers\Api\ScheduleApiController;
use App\Http\Controllers\Api\ServiceApiController;
use App\Http\Controllers\Api\TranslationApiController;
use Illuminate\Support\Facades\Route;

Route::post('/admin/login', [AuthApiController::class, 'login']);
Route::get('/portfolio', [DoctorProfileApiController::class, 'index']);

Route::post('/translations/lookup', [TranslationApiController::class, 'lookup'])->name('api.translations.lookup');

Route::middleware('web')->group(function () {
    Route::post('/admin/logout', [AuthApiController::class, 'logout']);
    Route::get('/admin/dashboard', [AuthApiController::class, 'dashboard']);

    Route::get('/admin/profile', [DoctorProfileApiController::class, 'show']);
    Route::put('/admin/profile', [DoctorProfileApiController::class, 'update']);

    Route::apiResource('/admin/sections', PortfolioSectionApiController::class);
    Route::apiResource('/admin/services', ServiceApiController::class);
    Route::apiResource('/admin/education', EducationApiController::class);
    Route::apiResource('/admin/blogs', BlogApiController::class);
    Route::apiResource('/admin/clinics', ClinicApiController::class);
    Route::apiResource('/admin/schedules', ScheduleApiController::class);
    Route::apiResource('/admin/reviews', ReviewApiController::class);
    Route::apiResource('/admin/appointments', AppointmentApiController::class)->except(['store']);
    Route::apiResource('/admin/prescriptions', PrescriptionApiController::class);
    Route::apiResource('/admin/roles', RoleApiController::class);
});
