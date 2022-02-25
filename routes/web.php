<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//frontend

//backend
Route::prefix('/')->middleware(['auth'])->group(function(){

    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    //Client Route
    Route::resource('/client',ClientController::class);
    //Task by client
    Route::get('client/{client:username}',[ClientController::class,'searchTaskByClient'])->name('searchTaskByClient');
    //Task route
    Route::resource('/task',TaskController::class);
    Route::put('task/{task}/complete',[TaskController::class,'markAsComplete'])->name('markAsComplete');
    //invoice route
    Route::prefix('invoices')->group(function(){
    Route::get('/', [InvoiceController::class , 'index'])->name('invoice.index');
    Route::get('create', [InvoiceController::class , 'create'])->name('invoice.create');
    Route::put('{invoice}/update', [InvoiceController::class , 'update'])->name('invoice.update');
    Route::delete('{invoice}/delete', [InvoiceController::class , 'destroy'])->name('invoice.destroy');
    Route::get('preview', [InvoiceController::class , 'preview'])->name('preview.invoice');
    Route::get('generate', [InvoiceController::class , 'generate'])->name('invoice.generate');
    Route::get('email/send/{invoice:invoice_id}', [InvoiceController::class , 'sendEmail'])->name('invoice.sendEmail');
  });
});


require __DIR__.'/auth.php';
