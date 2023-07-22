<?php

namespace App\Services;

use App\Models\ProductVariation;
use App\Models\PurchaseItem;
use App\Models\PurchaseOrder;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PurchaseCreateService
{
    public function variationFind($variation_id)
    {
        try
        {
            $variation = ProductVariation::query()
                ->with([
                    'product:id,supplier_id',
                    'product.supplier:id,name'
                ])
                ->find($variation_id);

            if(! $variation){
                throw new Exception('Product not found.');
            }

            return $variation;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function storePurchaseOrder($order_payload)
    {
        DB::beginTransaction();
        try {
            $purchase_order                     = new PurchaseOrder();
            $purchase_order->outlet_id          = auth()->user()->outlet_id;
            $purchase_order->gross_amount       = $order_payload['order_summary']['sub_total'];
            $purchase_order->net_payment_amount = $order_payload['order_summary']['net_payment_amount'];
            $purchase_order->internal_comments  = $order_payload['internal_comments'];
            $purchase_order->order_date         = Carbon::now();
            $purchase_order->generated_by       = auth()->user()->id;

            $purchase_order->save();

            $this->storePurchaseOrderItems($order_payload, $purchase_order->id);
            DB::commit();
            return true;
        } catch(Exception $ex) {
            DB::rollBack();
            throw $ex;
        }
    }

    public function storePurchaseOrderItems($order_payload, $purchase_order_id)
    {
        try {
            foreach ($order_payload['items'] as $item){
                $order_item = [];
                $order_item['outlet_id']           = auth()->user()->outlet_id;
                $order_item['purchase_order_id']   = $purchase_order_id;
                $order_item['product_id']          = $item['product_id'];
                $order_item['variation_id']        = $item['variation_id'];
                $order_item['supplier_id']         = $item['supplier_id'];
                $order_item['quantity']            = $item['quantity'];
                $order_item['loan']                = $item['loan'] ?? 0;
                $order_item['cogs_price']          = $item['cogs_price'];
                $order_item['selling_price']       = $item['selling_price'];

                PurchaseItem::create($order_item);
            }

        } catch(Exception $ex)
        {
            throw $ex;
        }
    }
}
