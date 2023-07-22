<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\SalesItem;
use App\Models\Sku;
use Exception;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Illuminate\Support\Facades\Storage;

class SalesReportService
{
     public function getProducts()
     {
        try
        {
            return Product::select('id', 'title')
                ->get()
                ->toArray();
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
     }

    public function getVariations($product_id = null)
    {
        try
        {
            return ProductVariation::select('id', 'variation_name')
                ->when($product_id, fn ($q) => $q->where('product_id', $product_id))
                ->get()
                ->toArray();
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function getSalesData($dates, $product_id = null, $variation_id = null)
    {
        try {
            $date   = explode(' to ', $dates);
            $start  = date('Y-m-d', strtotime($date[0])).' 00:00:00';
            $end    = date('Y-m-d', strtotime(end($date))).' 23:59:59';
            return SalesItem::query()
                ->selectRaw('sku_id,SUM(quantity) as quantity,SUM(total_sales_price) as total_sales_price')
                ->whereBetween('created_at', [$start, $end])
//                ->when($category_id, fn ($q) => $q->where('category_id', $category_id))
                ->when($product_id, fn ($q) => $q->where('product_id', $product_id))
                ->orderBy('total_sales_price', 'DESC')
                ->groupBy('sku_id')
                ->addSelect([
                    'variation_name' => ProductVariation::select('variation_name')->whereColumn('product_variations.id','sales_items.variation_id'),
                    'cogs_price' => Sku::select('cogs_price')->whereColumn('skus.id', 'sales_items.sku_id'),
                    'selling_price' => Sku::select('selling_price')->whereColumn('skus.id', 'sales_items.sku_id')
                ])
                ->get();

        } catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function excelDownload($dates, $product_id = null, $variation_id = null)
    {
        try {
            $sales_data = $this->getSalesData($dates, $product_id, $variation_id);

            $spreadsheet = new Spreadsheet();
            $sheet       = $spreadsheet->getActiveSheet();
            $styleGlobal = [
                'font' => [
                    'size' => 16,
                    'bold' => true,
                ],
            ];

            $allBorder = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE,
                        'color'       => ['argb' => '000000'],
                    ],
                ],
            ];
            $spreadsheet->getDefaultStyle()->getFont()->setSize(14);
            $sheet->getStyle('A1:H1')->applyFromArray($styleGlobal);
            $sheet->getColumnDimension('A')->setWidth(20);
            $sheet->getColumnDimension('B')->setWidth(30);
            $sheet->getColumnDimension('C')->setWidth(25);
            $sheet->getColumnDimension('D')->setWidth(15);
            $sheet->getColumnDimension('E')->setWidth(18);
            $sheet->getColumnDimension('F')->setWidth(18);
            $sheet->getColumnDimension('G')->setWidth(16);
//            $sheet->getColumnDimension('H')->setWidth(16);

            $sheet->setCellValue('A1', 'Sku');
            $sheet->setCellValue('B1', 'Product');
//            $sheet->setCellValue('C1', 'Supplier');
            $sheet->setCellValue('C1', 'Quantity');
            $sheet->setCellValue('D1', 'COGS Price');
            $sheet->setCellValue('E1', 'Selling Price');
            $sheet->setCellValue('F1', 'Profit');
            $sheet->setCellValue('G1', 'Loss');

            $sheet->getStyle('A')->getNumberFormat()
                ->setFormatCode('#');

            $sheet->getStyle('A:H')->getAlignment()->setHorizontal('left');

            $row                 = 2;
            $total_quantity      = 0;
            $total_cogs_price    = 0;
            $total_selling_price = 0;
            $total_profit        = 0;
            $total_loss          = 0;

            foreach ($sales_data as $item){

                $profit = 0; $loss  = 0;
                $total_cogs        = $item->cogs_price * $item->quantity;
                $total_sales_price = $item->total_sales_price;

                $total_cogs_price    += $total_cogs;
                $total_selling_price += $total_sales_price;
                $total_quantity      += $item->quantity;

                if($total_cogs > $total_sales_price){
                    $loss = $total_cogs - $total_sales_price;
                    $total_loss += $loss;
                }else{
                    $profit = $total_sales_price - $total_cogs;
                    $total_profit += $profit;
                }

                $sheet->setCellValue('A'. $row, $item->sku_id );
                $sheet->setCellValue('B'. $row, $item->variation_name);
                $sheet->setCellValue('C'. $row, $item->quantity );
                $sheet->setCellValue('D'. $row, $item->cogs_price * $item->quantity );
                $sheet->setCellValue('E'. $row, $item->total_sales_price );
                $sheet->setCellValue('F'. $row, $profit);
                $sheet->setCellValue('G'. $row, $loss) ;

                $row ++;
            }

            $row ++;
            $sheet->getStyle('A'. $row .':H' . $row)->applyFromArray($styleGlobal);
            $sheet->setCellValue('B'. $row, 'Total');
            $sheet->setCellValue('C'. $row, $total_quantity );
            $sheet->setCellValue('D'. $row, $total_cogs_price );
            $sheet->setCellValue('E'. $row, $total_selling_price );
            $sheet->setCellValue('F'. $row,  $total_profit);
            $sheet->setCellValue('G'. $row, $total_loss) ;

            $fileName = date('Y_m_d').'_sales_report.xlsx';
            $file_dir = 'public'.DIRECTORY_SEPARATOR.'excels'.DIRECTORY_SEPARATOR.$fileName;

            $headers = [
                'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition: attachment; filename="'.urlencode($fileName).'"',
            ];

            $writer  = IOFactory::createWriter($spreadsheet, 'Xlsx');
            ob_start();
            $writer->save('php://output');
            $content = ob_get_contents();
            ob_end_clean();
            Storage::disk('local')->put($file_dir, $content);
            return Storage::download($file_dir, $fileName, $headers);

        } catch(Exception $ex)
        {
            throw $ex;
        }
    }
}
