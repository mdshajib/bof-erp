<?php

namespace App\Services;

use Exception;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class ThermalPrintService
{
     public function print($order_id)
     {
        try
        {
            $order_data = (new OrderManagementService())->viewOrderDetails($order_id);

            $connector = new WindowsPrintConnector('RONGTA 80mm Series Printer');
            $printer = new Printer($connector);
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setTextSize(1, 1);
            $printer->text("Bangladesh Ordnance Factories\n\n");
            $printer->setTextSize(1, 1);
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $order_no = 'Order: ' . $order_data['order_info']['order_number'];
            $order_no   = str_pad($order_no , 28, " ");
            $date     = date('d/m/y', strtotime($order_data['order_info']['order_date']));
            $printer->text($order_no . $date);
            $printer->text("\n");
            $leftCol = 'Item';
            $centerCol = 'Qt x Price';
            $rightCol = 'Total';
            $printer->text($this->columnify($leftCol, $centerCol, $rightCol, 22, 10, 5, 4));
            foreach ($order_data['items'] as $item) {
                $leftCol   = $item['product'];
                $centerCol = $item['quantity'] .'x'. $item['unit_price'];
                $rightCol  = $item['gross_amount'];

                $printer->text($this->columnify($leftCol, $centerCol, $rightCol, 22, 10, 5, 4));
                $printer->text("\n");
            }
            $printer->text(str_pad("-", 47, "-") . "\n \n");
            $total = 'Total: '. $order_data['summary']['sub_total'];
            $total = str_pad($total , 13, " ");
            $discount = 'Discount: '. $order_data['summary']['total_discount'];
            $discount = str_pad($discount , 15, " ");
            $net_payable = 'Payable: '. $order_data['summary']['net_amount'];
            $net_payable = str_pad($net_payable , 15, " ");

            $printer->text("\n");

            $printer->text($total. $discount. $net_payable);
            $printer->text("\n");
            $printer->cut();
            $printer->close();
            return true;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
     }
}
