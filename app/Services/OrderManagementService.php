<?php

namespace App\Services;

use App\Models\SalesOrder;
use Exception;
use Illuminate\Support\Facades\Storage;
use Mpdf\Mpdf;

class OrderManagementService
{
    public function viewOrderDetails($order_id)
    {
        try{
            $sales_order    = SalesOrder::query()
                ->select('id','order_number','internal_comments','contact_id','order_notes','order_date','is_paid','paid_amount')
                ->with([
                    'sales_items:sales_order_id,variation_id,unit_sales_price,cogs_price,quantity,gross_amount,discount_amount,total_discount_amount,total_sales_price',
                    'sales_items.variation:id,variation_name',
                    'customer:id,name,phone'
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
                    'cogs_price'          => $item->cogs_price,
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

    public function getOrderDetails($order_id)
    {
        try{
            $sales_order    = SalesOrder::query()
                ->select('id','order_number','internal_comments','contact_id','order_notes','is_paid','paid_amount','payment_method')
                ->with([
                    'sales_items:id,sales_order_id,variation_id,sku_id,unit_sales_price,cogs_price,quantity,gross_amount,discount_amount,total_discount_amount,total_sales_price',
                    'sales_items.variation:id,variation_name',
                    'sales_items.sku:id,selling_price,cogs_price',
                    'sales_items.sku.stock:sku_id,quantity',
                    'customer:id,name,phone'
                ])
                ->findOrFail($order_id);
            if(!$sales_order){
                throw new Exception('Order data not found!!');
            }
            $order_info['order_number']      = $sales_order->order_number;
            $order_info['internal_comments'] = $sales_order->internal_comments;
            $order_info['order_notes']       = $sales_order->order_notes;
            $order_info['paid_amount']       = $sales_order->paid_amount;
            $order_info['payment_method']    = $sales_order->payment_method;
            $order_info['is_paid']           = $sales_order->is_paid;
            $order_info['customer_name']     = $sales_order->customer?->name;
            $order_info['customer_phone']    = $sales_order->customer?->phone;

            $row_section = [];
            $order_summary['sub_total']      = 0;
            $order_summary['total_discount'] = 0;

            foreach ($sales_order->sales_items as $key => $item){
//                dd($item);
                $item_row = [
                    'id'                  => $item->id,
                    'outlet_id'           => $item->outlet_id,
                    'product'             => $item->variation->variation_name,
                    'product_id'          => $item->product_id,
                    'variation_id'        => $item->variation_id,
                    'supplier_id'         => $item->supplier_id,
                    'sku_id'              => $item->sku_id,
                    'quantity'            => $item->quantity,
                    'stock'               => $item->sku?->stock->quantity,
                    'cogs_price'          => $item->sku?->cogs_price,
                    'selling_price'       => $item->sku?->selling_price,
                    'unit_price'          => $item->unit_sales_price,
                    'discount'            => $item->discount_amount,
                    'applied_discount_id' => $item->applied_discount_id,
                    'total_discount'      => $item->total_discount_amount,
                    'gross_amount'        => $item->gross_amount,
                    'total_sales_price'   => $item->total_sales_price,
                ];

                $row_section[]      = $item_row;

                $order_summary['sub_total']      += $item->gross_amount;
                $order_summary['total_discount'] += $item->total_discount_amount;
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

    public function invoicePrint($order_id)
    {
        try {
            $sales_order = SalesOrder::query()
                ->with([
                    'sales_items:sales_order_id,variation_id,quantity,unit_sales_price,total_sales_price',
                    'sales_items.variation:id,variation_name',
                    'customer:id,name,phone'
                ])->find($order_id);

            if(!$sales_order){
                throw new Exception('Order not found!!');
            }

            $pdf_data  = view('livewire.order.invoice', compact('sales_order'))->render();
            //return $pdf_data;
            $file_dir   = 'public'.DIRECTORY_SEPARATOR.'invoices'.DIRECTORY_SEPARATOR;
            $file_name  = 'invoice-'.$order_id.'.pdf';
            $file_dir   = 'invoices/'.$this->makePDF($pdf_data, $file_name, $file_dir);
            $url        = Storage::disk('local')->url($file_dir);

            return $url;

        } catch(Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Make mPDF.
     *
     * @param string $pdf_data      HTML format of pdf content
     * @param string $file_name     Name of pdf file
     * @param string $header        string
     * @param string $dest          View/download file
     * @return pdf output
     */
    private function makePDF( $pdf_data, $file_name, $file_dir, $header = null, $footer = null)
    {

        $defaultConfig     = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs          = $defaultConfig['fontDir'];
        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        $fontData          = $defaultFontConfig['fontdata'];
        $font_dir          = 'public'.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'fonts';
        $config = [
            'mode'          => '',
            'format'        => [210,297],
            'margin_left'   => 5,
            'margin_right'  => 5,
            'margin_top'    => 5,
            'margin_bottom' => 10,
            'margin_footer' => 5,
            'fontDir'       => array_merge($fontDirs, [
                base_path($font_dir),
            ]),
            'fontdata' => $fontData + [
                    'futurapt' => [
                        'R' => 'FuturaPT-Book.ttf',
                    ],
                ],
            'default_font' => 'futurapt',
        ];

        $mpdf                      = new mPDF($config);
        $mpdf->ignore_invalid_utf8 = true;
        $mpdf->showImageErrors     = true;

        if (! empty($header)) {
            $mpdf->SetHTMLHeader($header);
        }
        if (! empty($footer)) {
            $mpdf->SetHTMLFooter($footer);
        } else {
            $mpdf->setFooter('{PAGENO} / {nb}');
        }
        $mpdf->WriteHTML($pdf_data);

        $files     =  Storage::disk('local')->allFiles($file_dir);
        // Delete Files
        Storage::disk('local')->delete($files);
        $file_dir .= $file_name;
        ob_start();
        $mpdf->Output($file_name, 'I');
        $content = ob_get_contents();
        ob_end_clean();
        Storage::disk('local')->put($file_dir, $content);

        return $file_name;

    }
}
