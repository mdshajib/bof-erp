<?php

namespace App\Services;

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
                ->where('purchase_order_id', $purchase_order_id)
                ->get();
            $pdf_data  = view('livewire.purchase.barcode', compact('purchase_items'))
                ->render();
            //return $pdf_data;
            $file_dir = 'barcodes/'.$this->makePDF($pdf_data);
            $url      = Storage::disk('public')->url($file_dir);

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
    private function makePDF( $pdf_data, $header = null, $footer = null)
    {
        $file_name         = 'barcodes.pdf';
        $defaultConfig     = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs          = $defaultConfig['fontDir'];
        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        $fontData          = $defaultFontConfig['fontdata'];
        $font_dir          = 'public'.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'fonts';
        $config = [
            'mode'          => '',
            'format'        => [157, 222],
            'margin_left'   => 0,
            'margin_right'  => 0,
            'margin_top'    => 16,
            'margin_bottom' => 12,
            'margin_footer' => 9,
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

        $files     =  Storage::disk('public')->allFiles($file_dir);
        // Delete Files
        Storage::disk('public')->delete($files);
        $file_dir .= $file_name;
        ob_start();
        $mpdf->Output($file_name, 'I');
        $content = ob_get_contents();
        ob_end_clean();
        Storage::disk('public')->put($file_dir, $content);

        return $file_name;
//        return $mpdf->Output($file_name, $dest);
    }
}
