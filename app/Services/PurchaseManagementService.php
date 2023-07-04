<?php

namespace App\Services;

use App\Models\ProductVariation;
use App\Models\PurchaseItem;
use Exception;
use Illuminate\Support\Facades\Storage;
use Mpdf\Mpdf;

class PurchaseManagementService
{

     public function printPurchaseProductsBarcode($purchase_order_id): string
     {
        try
        {
            $purchase_items = PurchaseItem::query()
                ->select('sku_id','price','quantity')
                ->where('purchase_order_id', $purchase_order_id)
                ->addSelect([
                    'variation_name' => ProductVariation::select('variation_name')->whereColumn('purchase_items.variation_id','product_variations.id')
                ])
                ->get();

            $pdf_data  = view('livewire.purchase.barcode', compact('purchase_items'))
                ->render();
            //return $pdf_data;
            $file_dir = 'barcodes/'.$this->makePDF($pdf_data,$purchase_order_id);
            $url      = Storage::disk('local')->url($file_dir);

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
    private function makePDF( $pdf_data, $purchase_order_id,$header = null, $footer = null)
    {
        $file_name         = 'barcodes-'.$purchase_order_id.'.pdf';
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

        $file_dir = 'public'.DIRECTORY_SEPARATOR.'barcodes'.DIRECTORY_SEPARATOR;

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
