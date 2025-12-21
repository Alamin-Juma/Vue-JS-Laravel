<?php

declare(strict_types=1);

use App\Http\Controllers\Api\CommissionReportController;
use App\Http\Controllers\Api\TopDistributorsController;
use App\Http\Controllers\FormSubmissionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| These routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group.
|
*/

// Form Submission endpoints (public)
Route::post('/register', [FormSubmissionController::class, 'store'])
    ->name('form.register');

Route::prefix('v1')->group(function () {
    // Commission Report endpoints
    Route::prefix('reports')->group(function () {
        Route::get('/commission', [CommissionReportController::class, 'index'])
            ->name('reports.commission.index');
        
        Route::get('/commission/orders/{invoice}/items', [CommissionReportController::class, 'orderItems'])
            ->name('reports.commission.order-items');

        Route::get('/top-distributors', [TopDistributorsController::class, 'index'])
            ->name('reports.top-distributors.index');
    });

    // Form Submissions admin endpoints
    Route::get('/form-submissions', [FormSubmissionController::class, 'index'])
        ->name('form.submissions.index');
});
