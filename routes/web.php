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
use App\Http\Controllers\Admin\CustomerTransactionController;
use App\Http\Controllers\Admin\CariController;
use App\Http\Controllers\Admin\AuditController;
use App\Http\Controllers\Admin\MotorcycleSaleController;

Route::middleware('auth')->group(function () {
    Route::get('/admin', function () {
        $totalBalance = \App\Models\Customer::sum('balance');
        $motorcycleCount = \App\Models\Motorcycle::count();
        return view('admin.dashboard', compact('totalBalance', 'motorcycleCount'));
    });

    Route::get('/admin/how-to-use', function () {
        return view('admin.how-to-use');
    })->name('admin.how_to_use');

    // Audit Routes
    Route::get('admin/audits', [AuditController::class, 'index'])->name('admin.audits.index');

    Route::resource('admin/users', AccountController::class)->names('admin.users');
    Route::resource('admin/customers', CustomerController::class)->names('admin.customers');
    Route::resource('admin/maintenances', MaintenanceController::class)->names('admin.maintenances');
    Route::post('admin/maintenances/{maintenance}/complete', [MaintenanceController::class, 'complete'])->name('admin.maintenances.complete');

    // Cari Routes
    Route::get('admin/cari', [CariController::class, 'index'])->name('admin.cari.index');
    Route::get('admin/customers/{customer}/maintenances', [CustomerController::class, 'maintenances'])->name('admin.customers.maintenances');
    Route::post('admin/customers/{customer}/transactions', [CustomerTransactionController::class, 'store'])->name('admin.customers.transactions.store');
    Route::delete('admin/transactions/{transaction}', [CustomerTransactionController::class, 'destroy'])->name('admin.transactions.destroy');

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

    // Data Center Routes
    Route::get('admin/data-center', [\App\Http\Controllers\Admin\DataCenterController::class, 'index'])->name('admin.data_center.index');
    Route::resource('admin/brands', \App\Http\Controllers\Admin\BrandController::class)->names('admin.brands');
    Route::resource('admin/colors', \App\Http\Controllers\Admin\ColorController::class)->names('admin.colors');
    Route::resource('admin/motorcycle-models', \App\Http\Controllers\Admin\MotorcycleModelController::class)->names('admin.motorcycle-models');
    Route::resource('admin/motorcycles', \App\Http\Controllers\Admin\MotorcycleController::class)->names('admin.motorcycles');
    Route::resource('admin/motorcycle-sales', MotorcycleSaleController::class)->names('admin.motorcycle-sales'); // Added this line
    Route::get('admin/api/brands/{brand}/models', [\App\Http\Controllers\Admin\MotorcycleController::class, 'getModelsByBrand'])->name('admin.api.brands.models');
});
