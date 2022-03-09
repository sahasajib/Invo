<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\SettingsController;
use App\Models\User;
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
Route::get('/',function(){
    return view('welcome');
});
//backend
Route::prefix('/')->middleware(['auth'])->group(function(){

    Route::get('dashboard', function () {
        // Get current user
        $user = User::find(Auth::user()->id);
        // return response
        return view('dashboard')->with([
            'user'              => $user,
            'pending_tasks'     => $user->tasks->where('status', 'pending'),
            'unpaid_invoices'   => $user->invoices->where('status', 'unpaid'),
            'paid_invoices'   => $user->invoices->where('status', 'paid'),
        ]);
    })->name('dashboard');

    //Client Route
    Route::resource('/client',ClientController::class);
    //Task route
    Route::resource('/task',TaskController::class);
    Route::put('task/{task}/complete',[TaskController::class,'markAsComplete'])->name('markAsComplete');
    //invoice route
    Route::prefix('invoices')->group(function(){
    Route::get('/', [InvoiceController::class , 'index'])->name('invoice.index');
    Route::get('create', [InvoiceController::class , 'create'])->name('invoice.create');
    Route::put('{invoice}/update', [InvoiceController::class , 'update'])->name('invoice.update');
    Route::delete('{invoice}/delete', [InvoiceController::class , 'destroy'])->name('invoice.destroy');
    Route::get('invoice', [InvoiceController::class , 'invoice'])->name('invoice');
    Route::get('email/send/{invoice:invoice_id}', [InvoiceController::class , 'sendEmail'])->name('invoice.sendEmail');
  });
    //settings
    Route::get('settings',[SettingsController::class , 'index'])->name('settings.index');
    Route::put('settings/update',[SettingsController::class , 'update'])->name('settings.update');
});


require __DIR__.'/auth.php';
