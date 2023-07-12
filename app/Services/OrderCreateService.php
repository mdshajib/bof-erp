<?php

namespace App\Services;

use App\Models\ProductVariation;
use App\Models\SalesItem;
use App\Models\SalesOrder;
use App\Models\Sku;
use App\Traits\StockAndTransaction;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class OrderCreateService
{
    use StockAndTransaction;

     public function skuFind($barcode)
     {
        try
        {
            $sku_with_item = Sku::query()
                ->select('id','variation_id','product_id','cogs_price','selling_price')
                ->with([
                    'variation:id,variation_name,low_quantity_alert',
                    'stock:sku_id,quantity'
                ])
                ->find($barcode);
            if(! $sku_with_item){
                throw new Exception('Barcode not found in SKU table. Might be need purchase!');
            }
            if( $sku_with_item->stock == null || $sku_with_item->stock?->quantity < 1){
                throw new Exception('Stock out this product!');
            }

            return $sku_with_item;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
     }

    public function productSuggestions($keyword)
    {
        return ProductVariation::query()
            ->select('id', 'product_id', 'variation_name')
//                ->with('product:id,title')
            ->Where('variation_name', 'like', '%'.$keyword.'%')
            ->limit(10)->get();
     }

    public function variationFind($variation_id)
    {
        try
        {
            $sku_with_item = Sku::query()
                ->select('id','variation_id','product_id','cogs_price','selling_price')
                ->with([
                    'variation:id,variation_name,low_quantity_alert',
                    'stock:sku_id,quantity'
                ])
                ->WhereHas('variation', function ($q) use ($variation_id) {
                    return $q->where('product_variations.id', $variation_id);
                })
//                ->whereHas('stock',function ($q) {
//                    return $q->where('stocks.quantity', '>', 0);
//                })
                ->first();

            if(! $sku_with_item){
                throw new Exception('Product not found in SKU table. Might be need purchase!');
            }
            if( $sku_with_item->stock == null || $sku_with_item->stock?->quantity < 1){
                throw new Exception('Stock out this product!');
            }

            return $sku_with_item;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function storeOrder($order_payload)
    {
        DB::beginTransaction();
        try {
            $sales_order                     = new SalesOrder();
            $sales_order->outlet_id          = $order_payload['outlet_id'];
            $sales_order->gross_amount       = $order_payload['order_summary']['sub_total'];
            $sales_order->discount_amount    = $order_payload['order_summary']['total_discount'];
            $sales_order->net_payment_amount = $order_payload['order_summary']['net_amount'];
            $sales_order->paid_amount        = $order_payload['paid_amount'];
            $sales_order->due_amount         = $order_payload['order_summary']['due'];
            $sales_order->tax_amount         = 0;
            $sales_order->payment_method     = $order_payload['payment_method'];
            $sales_order->internal_comments  = $order_payload['internal_comments'];
            $sales_order->order_notes        = $order_payload['order_note'];
            $sales_order->order_date         = Carbon::now();
            $sales_order->generated_by       = auth()->user()->id;
            $sales_order->is_paid            = $order_payload['order_summary']['due'] > 0 ? 0 : 1;

            $sales_order->save();

            $this->storeOrderItems($order_payload, $sales_order->id);
            DB::commit();
            return true;
        } catch(Exception $ex) {
            DB::rollBack();
            throw $ex;
        }
    }

    public function storeOrderItems($order_payload, $sales_order_id)
    {
        try {
            foreach ($order_payload['items'] as $item){
                $order_item = [];
                $order_item['outlet_id']           = $item['outlet_id'];
                $order_item['sales_order_id']      = $sales_order_id;
                $order_item['product_id']          = $item['product_id'];
                $order_item['variation_id']        = $item['variation_id'];
                $order_item['sku_id']              = $item['sku_id'];
                $order_item['unit_sales_price']    = $item['unit_price'];
                $order_item['quantity']            = $item['quantity'];
                $order_item['gross_amount']        = $item['gross_amount'];
                $order_item['applied_discount_id'] = $item['applied_discount_id'];
                $order_item['discount_amount']     = $item['discount'];
                $order_item['tax_amount']          = 0;
                $order_item['total_sales_price']   = $item['total_sales_price'];
                $order_item['note']                = null;

                SalesItem::create($order_item);
                $this->stockDecrement($item['sku_id'], $item['quantity']);
                $this->createTransaction( $item );

            }

        } catch(Exception $ex)
        {
            throw $ex;
        }
    }
}
