<?php

namespace App\Services;

use App\Models\ProductVariation;
use App\Models\PurchaseItem;
use App\Models\PurchaseOrder;
use App\Models\Sku;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Mpdf\Mpdf;

class PurchaseManagementService
{

     public function printPurchaseProductsBarcode($purchase_order_id): string
     {
        try
        {
            $purchase_items = Sku::query()
                ->select('id','variation_id','selling_price','quantity')
                ->addSelect([
                    'variation_name' => ProductVariation::select('variation_name')->whereColumn('skus.variation_id','product_variations.id')
                ])
                ->where('purchase_order_id', $purchase_order_id)
                ->get();

            $pdf_data  = view('livewire.purchase.barcode', compact('purchase_items'))->render();
            //return $pdf_data;
            $file_dir   = 'public'.DIRECTORY_SEPARATOR.'barcodes'.DIRECTORY_SEPARATOR;
            $file_name  = 'barcodes-'.$purchase_order_id.'.pdf';
            $file_dir   = 'barcodes/'.$this->makePDF($pdf_data, $file_name, $file_dir);
            $url        = Storage::disk('local')->url($file_dir);

            return $url;
        }
        catch(Exception $ex)
        {
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

    public function viewOrderDetails($purchase_order_id)
    {
        try{
            $purchase_order    = PurchaseOrder::query()
                ->select('id','purchase_number','internal_comments','order_date','gross_amount')
                ->with([
                    'purchase_items:purchase_order_id,product_id,variation_id,selling_price,quantity,cogs_price',
                    'purchase_items.variation:id,variation_name',
                    'purchase_items.product:id,supplier_id',
                    'purchase_items.product.supplier:id,name'
                ])
                ->findOrFail($purchase_order_id);

            if(!$purchase_order){
                throw new Exception('Order data not found!!');
            }
            $order_info['purchase_number']   = $purchase_order->purchase_number;
            $order_info['internal_comments'] = $purchase_order->internal_comments;
            $order_info['order_date']        = $purchase_order->order_date;

            $loop = 1;
            $row_section = [];
            $order_summary['sub_total']      = 0;

            foreach ($purchase_order->purchase_items as $key => $item){

                $item_row = [
                    'id'                => $loop,
                    'product'           => $item->variation?->variation_name,
                    'quantity'          => $item->quantity,
                    'cogs_price'        => $item->cogs_price,
                    'selling_price'     => $item->selling_price,
                    'supplier'          => $item->product?->supplier?->name,
                    'gross_amount'      => $item->cogs_price * $item->quantity,
                ];
                $row_section[]      = $item_row;

                $order_summary['sub_total']      += $item_row['gross_amount'];
                $loop ++;
                $item_row = [];
            }


            $order_data['order_info'] = $order_info;
            $order_data['items']      = $row_section;
            $order_data['summary']    = $order_summary;

            return $order_data;

        } catch(Exception $ex) {
            throw $ex;
        }
    }

    public function purchaseConfirm($purchase_id)
    {
        try {
            $status = PurchaseOrder::where([
                'id' => $purchase_id, 'is_print' => 1, 'price_updated' => 1
            ])->update(['is_confirmed' => 1]);
            if(!$status){
                throw new Exception('Might be purchase not printed and price updated.');
            }
            return true;
        } catch(Exception $ex) {
            throw $ex;
        }
    }

    public function purchaseMarkAsOpen($purchase_id)
    {
        try {
            $status = PurchaseOrder::where([
                'id' => $purchase_id, 'is_print' => 1, 'price_updated' => 1
            ])->update(['is_confirmed' => 0, 'is_print' => 0, 'price_updated' => 0]);
            if(!$status){
                throw new Exception('Might be purchase not printed and price updated.');
            }
            return true;
        } catch(Exception $ex) {
            throw $ex;
        }
    }

    public function purchasePrint($purchase_id)
    {
        try {
            $purchase_order = PurchaseOrder::query()->with([
                'purchase_items:purchase_order_id,product_id,variation_id,quantity',
                'purchase_items.variation:id,variation_name',
                'purchase_items.product:id,supplier_id',
                'purchase_items.product.supplier:id,name'
            ])->find($purchase_id);

            if(!$purchase_order){
                throw new Exception('Might be purchase not printed and price updated.');
            }

            $purchase_order->is_print = 1;
            $purchase_order->save();

            $pdf_data  = view('livewire.purchase.print-purchase', compact('purchase_order'))->render();
            //return $pdf_data;
            $file_dir   = 'public'.DIRECTORY_SEPARATOR.'purchases'.DIRECTORY_SEPARATOR;
            $file_name  = 'print-'.$purchase_id.'.pdf';
            $file_dir   = 'purchases/'.$this->makePDF($pdf_data, $file_name, $file_dir);
            $url        = Storage::disk('local')->url($file_dir);

            return $url;

        } catch(Exception $ex) {
            throw $ex;
        }
    }

    public function barcodeGenerate($purchase_id)
    {

        try {
            DB::beginTransaction();
            $purchase_items = PurchaseItem::query()
                ->select('product_id','variation_id','quantity','cogs_price','selling_price')
                ->where('purchase_order_id', $purchase_id)->get();
            if(! count($purchase_items) >0){
                throw new Exception('Purchase id not found.');
            }
            foreach ($purchase_items as $item){

                $sku = $this->generateSKU($purchase_id, $item->variation_id);
                $sku_item = [];
                $sku_item['id']                  = $sku;
                $sku_item['purchase_order_id']   = $purchase_id;
                $sku_item['product_id']          = $item->product_id;
                $sku_item['variation_id']        = $item->variation_id;
                $sku_item['quantity']            = $item->quantity;
                $sku_item['cogs_price']          = $item->cogs_price;
                $sku_item['selling_price']       = $item->selling_price;

                Sku::updateOrCreate(['id' => $sku], $sku_item);
            }
            PurchaseOrder::where('id', $purchase_id)->update(['barcode_print' => 1]);
            DB::commit();
            return true;

        } catch(Exception $ex)
        {
            DB::rollBack();
            throw $ex;
        }
    }

    public function purchaseDelete($purchase_id)
    {
        try {
            DB::beginTransaction();
            $purchase = PurchaseOrder::find($purchase_id);
            $purchase->delete();
            DB::commit();
            return true;
        } catch(Exception $ex)
        {
            DB::rollBack();
            throw $ex;
        }
    }

    private function generateSKU($purchase_order_id, $variation_id) : string
    {
//        return (string) Str::uuid();
//        return 'PR'.$purchase_order_id.$variation_id.time();
        return $purchase_order_id.$variation_id.time();
    }
}
