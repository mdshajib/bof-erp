<?php

namespace App\Services;

use App\Models\ProductVariation;
use App\Models\SalesOrder;
use App\Models\Sku;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class OrderCreateService
{
    /**
     * Function details
     */
     public function skuFind($barcode)
     {
        try
        {
            $sku_with_item = Sku::query()
                ->with([
                    'variation:id,variation_name,cogs_price,selling_price,low_quantity_alert',
                    'stock:sku_id,quantity'
                ])
                ->find($barcode);
            if(! $sku_with_item){
                throw new Exception('Barcode not found!');
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
                ->with([
                    'variation:id,variation_name,cogs_price,selling_price,low_quantity_alert',
                    'stock:sku_id,quantity'
                ])
                ->WhereHas('variation', function ($q) use ($variation_id) {
                    return $q->where('product_variations.id', $variation_id);
                })
                ->whereHas('stock',function ($q) {
                    return $q->where('stocks.quantity', '>', 0);
                })->first();
            if(! $sku_with_item){
                throw new Exception('Barcode not found!');
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
            $sales_order->outlet_id          = auth()->user()->outlet_id;
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
            DB::commit();

            return true;
        } catch(Exception $ex) {
            throw $ex;
        }
    }
}
