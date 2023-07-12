<?php

namespace App\Services;

use App\Models\PurchaseOrder;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class PurchaseUpdateService
{

     public function purchaseOrder($purchase_id)
     {
        try
        {
            $purchase_order = PurchaseOrder::query()
                ->with([
                    'purchase_items',
                    'purchase_items.variation:id,variation_name',
                    'purchase_items.product:id,supplier_id',
                    'purchase_items.product.supplier:id,name',
                ])
                ->find($purchase_id);
            if(!$purchase_order){
                throw new Exception('Purchase Order data not found!!');
            }
            $order_info['internal_comments'] = $purchase_order->internal_comments;
            $row_section = [];
            $order_summary['sub_total']      = 0;
            $loop =1;
            foreach ($purchase_order->purchase_items as $key => $item){

                $item_row = [
                    'id'                  => 0,
                    'product'             => $item->variation?->variation_name,
                    'product_id'          => $item->product_id,
                    'supplier'            => $item->product?->supplier?->name,
                    'variation_id'        => $item->variation_id,
                    'quantity'            => $item->quantity,
                    'selling_price'       => $item->selling_price,
                    'cogs_price'          => $item->cogs_price,
                    'gross_amount'        => $item->cogs_price *  $item->quantity,
                ];
                $row_section[]      = $item_row;

                $order_summary['sub_total']      += $item_row['gross_amount'];
                $loop ++;
            }

            $order_data['order_info'] = $order_info;
            $order_data['items']      = $row_section;
            $order_data['summary']    = $order_summary;
            return $order_data;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
     }

    public function purchaseUpdate($purchase_id, $order_payload)
    {
        DB::beginTransaction();
        try {
            $purchase_order                     = PurchaseOrder::find($purchase_id);
            $purchase_order->price_updated      = $order_payload['amount_confirmed'];
            $purchase_order->gross_amount       = $order_payload['order_summary']['sub_total'];
            $purchase_order->net_payment_amount = $order_payload['order_summary']['net_payment_amount'];
            $purchase_order->internal_comments  = $order_payload['internal_comments'];

            $purchase_order->save();
//            dd($order_payload, $purchase_order);

//            $this->storePurchaseOrderItems($order_payload, $purchase_order->id);
            DB::commit();
            return true;
        } catch(Exception $ex) {
            DB::rollBack();
            throw $ex;
        }
    }
}
