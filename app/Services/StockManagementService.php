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
     public function findProductBySku($sku, $stock_type = 'add')
     {
         DB::beginTransaction();
        try
        {
            $is_adjust = 0;  $item = []; $message = null;
            $sku = Sku::query()
                ->select('id','product_id','variation_id','purchase_order_id','quantity')
                ->with(['stock:sku_id,product_id,variation_id,quantity'])
                ->find($sku);
            if(! $sku){
                throw new Exception("Barcode not found!!");
            }

            if($stock_type === 'add') {
                $this->stockIncrement($sku->id, $sku->quantity);
                $message = 'Product stock added.';
            }
            else if($stock_type === 'adjust_plus'){
                $this->stockIncrement($sku->id, $sku->quantity);
                $is_adjust = 1;
                $message = 'Product adjust plus added.';
            }
            else if($stock_type === 'adjust_minus'){
                $this->stockDecrement($sku->id, $sku->quantity);
                $message = 'Product adjust minus added.';
                $is_adjust = 1;
            }

            $item['sku']          = $sku->id;
            $item['product_id']   = $sku->product_id;
            $item['variation_id'] = $sku->variation_id;
            $item['quantity']     = $sku->quantity;

            $this->createTransaction( $item, 'in', $is_adjust);

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
}
