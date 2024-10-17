<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VoiceflowAnalyticsController;
use App\Http\Controllers\VoiceflowDocumentController;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::middleware(['auth', 'verified'])->group(function () {
    // Route to render the analytics page
    Route::get('/analytics', function () {
        return Inertia::render('Voiceflow/Analytics');
    })->name('analytics');

    // API-like routes to get analytics data
    Route::post('/analytics/data', [VoiceflowAnalyticsController::class, 'getAnalyticsData'])
    ->name('analytics.data');


    Route::get('/documents', function () {
        return Inertia::render('Voiceflow/Documents');
    })->name('documents');
    
    Route::post('/documents/list', [VoiceflowDocumentController::class, 'getDocuments']);
    Route::post('/documents/upload', [VoiceflowDocumentController::class, 'uploadDocument']);
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
