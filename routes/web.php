<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductMakeController;
use App\Http\Controllers\PurchaseMasterController;
use App\Http\Controllers\ReceiptsController;
use App\Http\Controllers\SalesMasterController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\SaleProductLicenseController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [AuthenticatedSessionController::class, 'create']);


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
    Route::resource('product-categories', ProductCategoryController::class);
    Route::resource('product-makes', ProductMakeController::class);
    Route::resource('accounts', AccountController::class);
    Route::resource('purchases', PurchaseMasterController::class);
    Route::resource('sales', SalesMasterController::class);
       
    // AJAX route for purchase detail modal
    Route::get('purchases/{purchase}/detail', [PaymentsController::class, 'getPurchaseDetailAndTransaction'])->middleware('auth');
    Route::get('sales/{purchase}/detail', [ReceiptsController::class, 'getSaleDetailAndTransaction'])->middleware('auth');
    // Payments management
    Route::get('payments', [PaymentsController::class, 'index'])->name('payments.index');
    Route::get('payment/{payment}', [PaymentsController::class, 'show'])->name('payments.show');
    Route::get('payments/{payment}/edit', [PaymentsController::class, 'edit'])->name('payments.edit');
    Route::put('payments/{payment}', [PaymentsController::class, 'update'])->name('payments.update');
    Route::post('payments/{payment}/delete', [PaymentsController::class, 'destroy'])->name('payments.destroy');
    Route::get('purchases/{purchase}/payment-form', [PaymentsController::class, 'paymentForm'])->name('purchases.paymentForm');
    Route::post('purchases/{purchase}/pay', [PaymentsController::class, 'storePayment'])->name('purchases.pay');
    // Receipts management
    Route::get('receipts', [ReceiptsController::class, 'index'])->name('receipts.index');
    Route::get('receipt/{receipt}', [ReceiptsController::class, 'show'])->name('receipts.show');
    Route::get('receipts/{receipt}/edit', [ReceiptsController::class, 'edit'])->name('receipts.edit');
    Route::put('receipts/{receipt}', [ReceiptsController::class, 'update'])->name('receipts.update');
    Route::post('receipts/{receipt}/delete', [ReceiptsController::class, 'destroy'])->name('receipts.destroy');
    Route::get('sales/{sale}/receipt-form', [ReceiptsController::class, 'receiptForm'])->name('sales.receiptForm');
    Route::post('sales/{sale}/receipt', [ReceiptsController::class, 'storeReceipt'])->name('sales.pay');

    Route::post('/sale-product-licenses', [SaleProductLicenseController::class, 'store'])->name('sale-product-licenses.store');
    Route::get('/sale-product-licenses/print/{sale_detail_id}', [SaleProductLicenseController::class, 'print'])->name('sale-product-licenses.print');
});

require __DIR__ . '/auth.php';
