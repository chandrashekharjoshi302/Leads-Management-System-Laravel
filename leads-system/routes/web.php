<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LeadController;
use App\Http\Controllers\DashboardController;

Auth::routes();




Route::middleware(['auth'])->group(function () {


    Route::get('/home', function () {
        return redirect()->route('dashboard');
    });

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/leads', [LeadController::class, 'index'])->name('leads.index');
    Route::get('/leads/create', [LeadController::class, 'create'])->name('leads.create');
    Route::post('/leads/store', [LeadController::class, 'store'])->name('leads.store');
    Route::get('/leads/{id}/edit', [LeadController::class, 'edit'])->name('leads.edit');
    Route::post('/leads/{id}/update', [LeadController::class, 'update'])->name('leads.update');
    Route::get('/leads/{id}/delete', [LeadController::class, 'destroy'])->name('leads.delete');

    Route::get('/leads/export', [LeadController::class, 'export'])->name('leads.export');
});
