<?php

namespace App\Services;

use App\Models\Sku;
use App\Models\Stock;
use App\Traits\StockAndTransaction;
use Exception;
use Illuminate\Support\Facades\DB;

class StockManagementService
{
    use StockAndTransaction;
     public function findProductBySku($barcode, $stock_type = 'add')
     {
         DB::beginTransaction();
        try
        {
            $is_adjust = 0;  $item = []; $message = null;
            $sku = Sku::query()
                ->select('id','product_id','variation_id','purchase_order_id','quantity')
                ->with(['stock:sku_id,product_id,variation_id,quantity'])
                ->find($barcode);
            if(! $sku){
                throw new Exception("Barcode not found!!");
            }

            $item['outlet_id']    = auth()->user()->outlet_id;
            $item['sku_id']       = $sku->id;
            $item['product_id']   = $sku->product_id;
            $item['variation_id'] = $sku->variation_id;
            $item['quantity']     = $sku->quantity;

            if($sku->stock == null){
                $this->createStock($item);
            }
            else {
                $type = 'in';
                if ($stock_type === 'add') {
                    if($sku->stock?->sku_id == $barcode){
                        throw new Exception("Already stock added with this barcode!!");
                    }
                    $this->stockIncrement($sku->id, $sku->quantity);
                    $message = 'Product stock added.';
                } else if ($stock_type === 'adjust_plus') {
                    $this->stockIncrement($sku->id, $sku->quantity);
                    $is_adjust = 1;
                    $message = 'Product adjust plus added.';
                } else if ($stock_type === 'adjust_minus') {
                    $this->stockDecrement($sku->id, $sku->quantity);
                    $message = 'Product adjust minus added.';
                    $type = 'out';
                    $is_adjust = 1;
                }
            }

            $this->createTransaction( $item, $type, $is_adjust);

            DB::commit();

            return $message;
        }
        catch(Exception $ex)
        {
            DB::rollBack();
            throw $ex;
        }
     }

    public function todaysTransaction()
    {
        return $this->todayTransactions();
    }

    public function stockPlus($barcode, $quantity = 0)
    {
        DB::beginTransaction();
        try{
            $sku = Sku::query()
                ->select('id','product_id','variation_id','purchase_order_id','quantity')
                ->with(['stock:sku_id,product_id,variation_id,quantity'])
                ->find($barcode);
            if(! $sku){
                throw new Exception("Barcode not found!!");
            }
            $item['outlet_id']    = auth()->user()->outlet_id;
            $item['sku_id']       = $sku->id;
            $item['product_id']   = $sku->product_id;
            $item['variation_id'] = $sku->variation_id;
            $item['quantity']     = $sku->quantity;

            if($sku->stock == null){
                $this->createStock($item);
            }else{
                $this->stockIncrement($sku->id, $quantity);
            }
            $this->createTransaction( $item, 'in', 1);

            DB::commit();
            return 'Product adjust plus added.';
        }
        catch(Exception $ex)
        {
            DB::rollBack();
            throw $ex;
        }
    }

    public function stockMinus($barcode, $quantity = 0)
    {
        DB::beginTransaction();
        try{
            $sku = Sku::query()
                ->select('id','product_id','variation_id','purchase_order_id','quantity')
                ->with(['stock:sku_id,product_id,variation_id,quantity'])
                ->find($barcode);
            if(! $sku){
                throw new Exception("Barcode not found!!");
            }
            if($sku->stock == null){
                throw new Exception("Stock not found!!");
            }
            if($sku->stock?->quantity < 1){
                throw new Exception("Out of stock!!");
            }
            $item['outlet_id']    = auth()->user()->outlet_id;
            $item['sku_id']       = $sku->id;
            $item['product_id']   = $sku->product_id;
            $item['variation_id'] = $sku->variation_id;
            $item['quantity']     = $sku->quantity;

            $this->stockDecrement($sku->id, $quantity);
            $this->createTransaction( $item, 'out', 1);

            DB::commit();
            return 'Product adjust minus added.';
        }
        catch(Exception $ex)
        {
            DB::rollBack();
            throw $ex;
        }
    }
}
