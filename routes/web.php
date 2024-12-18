<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\HomologationController;
use App\Http\Controllers\HomologationEquipmentController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('home');
    } else {
        return redirect('login');
    }
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () { 
    Route::get('home', [EquipmentController::class, 'index'])->name('home');
    Route::get('/equipments', [EquipmentController::class, 'index'])->name('equipments.index');
    Route::post('/equipments', [EquipmentController::class, 'store'])->name('equipments.store');
    Route::get('equipments/{equipment}', [EquipmentController::class, 'show'])->name('equipments.show');
    Route::put('equipments/{equipment}', [EquipmentController::class, 'update'])->name('equipments.update');
    Route::delete('equipments/{equipment}', [EquipmentController::class, 'destroy'])->name('equipments.destroy');

    Route::get('homologations', [HomologationController::class, 'index'])->name('homologations.index');
    Route::post('homologations', [HomologationController::class, 'store'])->name('homologations.store');
    Route::get('homologations/{homologation}', [HomologationController::class, 'show'])->name('homologations.show');
    Route::get('homologations/absent/{homologationequipment}', [HomologationEquipmentController::class, 'markAbsent'])->name('homologations.absent');
    //Route::post('homologations/qrcode', [HomologationEquipmentController::class, 'readQRCode'])->name('homologations.qrcode');
    Route::post('read-qrcode', [HomologationEquipmentController::class, 'readQRCode'])->name('read-qrcode');
    Route::get('reports', [EquipmentController::class, 'reports'])->name('reports.index');
    Route::get('/report/inventory', [EquipmentController::class, 'equipamentosfiltrados'])->name('report.inventory');
    Route::get('/report/inventory/pdf', [EquipmentController::class, 'exportPdf'])->name('report.inventory.pdf');

});

Route::group(['middleware' => 'auth'], function () { 
    Route::resource('products', 'ProductController'); 
});