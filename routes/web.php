<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Dashboard;
use \App\Http\Livewire\Profile;
use App\Http\Livewire\Users\ManageUser;
use App\Http\Livewire\Category\ManageCategory;
use App\Http\Livewire\Product\AddProduct;
use App\Http\Livewire\Product\ManageProduct;
use App\Http\Livewire\Product\UpdateProduct;
use App\Http\Livewire\Order\CreateOrder;
use App\Http\Livewire\Order\ManageOrder;
use App\Http\Livewire\Order\UnpaidOrders;
use App\Http\Livewire\Inventory\Stockin;
use App\Http\Livewire\Inventory\ManageStock;
use App\Http\Livewire\Supplier\ManageSupplier;
use App\Http\Livewire\Purchase\CreatePurchaseOrder;
use App\Http\Livewire\Purchase\ManagePurchase;
use App\Http\Livewire\Purchase\OpenPurchaseOrders;
use App\Http\Livewire\Purchase\ConfirmedPurchaseOrders;
use App\Http\Livewire\Purchase\UpdatePurchaseOrder;
use App\Http\Livewire\Purchase\PurchaseOrderView;
use \App\Http\Livewire\Inventory\TransactionList;
use \App\Http\Livewire\Reports\SalesReport;
use \App\Http\Livewire\NewPos\Pos;
use \App\Http\Livewire\CRM\SpecialContact;
use \App\Http\Livewire\CRM\NormalContact;
use \App\Http\Livewire\Supplier\LoanProducts;

Route::get('/', [HomeController::class, 'home']);

Route::get('/login', Login::class)->name('login');

// Reset Password Routes
Route::view('/forgot-password', 'auth.forgot-password')->name('password.request');
Route::post('/forgot-password', [ResetPasswordController::class, 'emailVerify'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'resetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'updatePassword'])->name('password.update');

Route::group(['middleware'=> ['auth']], function () {
    Route::post('/logout', [HomeController::class, 'doLogout'])->name('logout');
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/profile', Profile::class)->name('profile');
    Route::get('/users', ManageUser::class)->name('user.manage');
    Route::get('/categories', ManageCategory::class)->name('manage.category');

    // Contact routes
    Route::get('crm/special-contact', SpecialContact::class)->name('crm.special');
    Route::get('crm/contact', NormalContact::class)->name('crm.contact');
//    Products Routes
    Route::get('products/create', AddProduct::class)->name('product.create');
    Route::get('products', ManageProduct::class)->name('product.manage');
    Route::get('products/{product_id}/edit', UpdateProduct::class)->name('product.edit');

//    Orders Routes
    Route::get('orders/create', CreateOrder::class)->name('order.create');
    Route::get('orders', ManageOrder::class)->name('order.manage');
    Route::get('orders/unpaid', UnpaidOrders::class)->name('order.unpaid');

    Route::get('purchases', ManagePurchase::class)->name('purchase.manage');
    Route::get('purchases/create', CreatePurchaseOrder::class)->name('purchase.create');
    Route::get('purchases/open', OpenPurchaseOrders::class)->name('purchase.open');
    Route::get('purchases/confirmed', ConfirmedPurchaseOrders::class)->name('purchase.confirmed');
    Route::get('purchases/{purchase_id}', PurchaseOrderView::class)->name('purchase.view');
    Route::get('purchases/{purchase_id}/edit', UpdatePurchaseOrder::class)->name('purchase.edit');
//    Inventory Routes
    Route::get('/inventory', ManageStock::class)->name('inventory.manage');
    Route::get('/inventory/stockin', Stockin::class)->name('inventory.stockin');
    Route::get('/inventory/transactions', TransactionList::class)->name('inventory.transactions');

    // Supplier Routes
    Route::get('/suppliers', ManageSupplier::class)->name('supplier.manage');
    Route::get('/loan-products', LoanProducts::class)->name('loan.products');

    // reports Routes
    Route::get('/reports/sales', SalesReport::class)->name('reports.sales');

    // New Pos
    Route::get('/pos', Pos::class)->name('pos');


});

