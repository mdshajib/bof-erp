<?php

namespace App\Services;

use App\Models\ProductVariation;
use App\Models\PurchaseItem;
use App\Models\PurchaseOrder;
use App\Models\Sku;
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
//                $sku = $this->generateSKU($purchase_order_id, $item['variation_id']);
//                $this->storeSKU($purchase_order_id, $sku, $item);

                $order_item['outlet_id']           = auth()->user()->outlet_id;
                $order_item['purchase_order_id']   = $purchase_order_id;
                $order_item['product_id']          = $item['product_id'];
                $order_item['variation_id']        = $item['variation_id'];
                $order_item['quantity']            = $item['quantity'];
                $order_item['cogs_price']          = $item['cogs_price'];
                $order_item['selling_price']       = $item['selling_price'];

                PurchaseItem::create($order_item);
            }

        } catch(Exception $ex)
        {
            throw $ex;
        }
    }

    private function generateSKU($purchase_order_id, $variation_id) : string
    {
//        return (string) Str::uuid();
        return 'PR'.$purchase_order_id.$variation_id.time();
    }

    private function storeSKU($purchase_order_id, $sku, $item)
    {
        $sku_data['id']                = $sku;
        $sku_data['product_id']        = $item['product_id'];
        $sku_data['variation_id']      = $item['variation_id'];
        $sku_data['purchase_order_id'] = $purchase_order_id;
        $sku_data['quantity']          = $item['quantity'];
        return Sku::create($sku_data);
    }
}
