<?php

namespace App\Http\Controllers;

use App\Models\PurchaseItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function home()
    {
        if (auth::check()) {
            return redirect('/dashboard');
        } else {
            return redirect('/login');
        }
    }

    public function doLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->to('/login');

    }

    public function barcode()
    {
        $purchase_items = PurchaseItem::query()
            ->select('sku_id','price','quantity')
            ->where('purchase_order_id', 2)
            ->get();
        return view('livewire.purchase.barcode', compact('purchase_items'));
    }
}
