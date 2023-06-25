<?php

namespace App\Services;

use App\Models\SalesOrder;
use Exception;

class OrderManagementService
{
    public function viewOrderDetails($order_id)
    {
        try{
            $sales_order    = SalesOrder::query()
                ->select('id','order_number','internal_comments','order_notes','order_date','is_paid','paid_amount')
                ->with([
                    'sales_items:sales_order_id,variation_id,unit_sales_price,quantity,gross_amount,discount_amount,total_discount_amount,total_sales_price',
                    'sales_items.variation:id,variation_name',
                    'customer:id, name, phone'
                ])
                ->findOrFail($order_id);
            if(!$sales_order){
                throw new Exception('Order data not found!!');
            }
            $order_info['order_number']      = $sales_order->order_number;
            $order_info['internal_comments'] = $sales_order->internal_comments;
            $order_info['order_notes']       = $sales_order->order_notes;
            $order_info['order_date']        = $sales_order->order_date;
            $order_info['paid_amount']       = $sales_order->paid_amount;
            $order_info['is_paid']           = $sales_order->is_paid;
            $order_info['customer_name']     = $sales_order->customer?->name;
            $order_info['customer_phone']    = $sales_order->customer?->phone;

            $loop = 1;
            $row_section = [];
            $order_summary['sub_total']      = 0;
            $order_summary['total_discount'] = 0;

            foreach ($sales_order->sales_items as $key => $item){

                $item_row = [
                    'id'                  => $loop,
                    'product'             => $item->variation?->variation_name,
                    'quantity'            => $item->quantity,
                    'unit_price'          => $item->unit_sales_price,
                    'discount'            => $item->discount_amount,
                    'total_discount'      => $item->total_discount_amount,
                    'gross_amount'        => $item->gross_amount,
                    'total_sales_price'   => $item->total_sales_price,
                ];
                $row_section[]      = $item_row;

                $order_summary['sub_total']      += $item->gross_amount;
                $order_summary['total_discount'] += $item->total_discount_amount;
                $loop ++;
            }



                $order_summary['net_amount']     = $order_summary['sub_total']  - $order_summary['total_discount'];
                $order_summary['due']            = $order_summary['sub_total'] - $sales_order->paid_amount;


            $order_data['order_info'] = $order_info;
            $order_data['items']      = $row_section;
            $order_data['summary']    = $order_summary;

            return $order_data;

        } catch(Exception $ex) {
            throw $ex;
        }
    }
}
