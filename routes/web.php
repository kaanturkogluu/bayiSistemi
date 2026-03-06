<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\MaintenanceController;
use App\Http\Controllers\Admin\SettingController;

Route::middleware('auth')->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    });

    Route::resource('admin/users', AccountController::class)->names('admin.users');
    Route::resource('admin/customers', CustomerController::class)->names('admin.customers');
    Route::resource('admin/maintenances', MaintenanceController::class)->names('admin.maintenances');

    // Invoice Settings Routes
    Route::get('admin/settings/invoice', [SettingController::class, 'invoice'])->name('admin.settings.invoice');
    Route::put('admin/settings/invoice', [SettingController::class, 'updateInvoice'])->name('admin.settings.invoice.update');

    // Usta (Technician) Routes
    Route::prefix('admin/usta')->name('admin.usta.')->group(function () {
        Route::get('maintenances', [\App\Http\Controllers\Admin\UstaMaintenanceController::class, 'index'])->name('maintenances');
        Route::get('maintenances/{maintenance}', [\App\Http\Controllers\Admin\UstaMaintenanceController::class, 'show'])->name('maintenances.show');
        Route::post('parts/{part}/toggle', [\App\Http\Controllers\Admin\UstaMaintenanceController::class, 'togglePart'])->name('parts.toggle');
        Route::post('maintenances/{maintenance}/complete', [\App\Http\Controllers\Admin\UstaMaintenanceController::class, 'complete'])->name('maintenances.complete');
    });
});
