<?php

namespace App\Services;

use Exception;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class ThermalPrintService
{
     public function print($order_id)
     {
        try
        {
            $connection_type   = config('bof.connection_type');
            if($connection_type == 'direct'){
                return $this->DirectPrint($order_id);
            }else{
                return $this->networkPrint($order_id);
            }
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
     }

    public function DirectPrint($order_id)
    {
        try
        {
            $order_data = (new OrderManagementService())->viewOrderDetails($order_id);
            $printer_name = config('bof.printer_name');
            $connector = new WindowsPrintConnector($printer_name);
            $printer = new Printer($connector);
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setTextSize(1, 1);
            $printer->text("Bangladesh Ordnance Factories\n\n");
            $printer->setTextSize(1, 1);
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $order_no = 'Order: ' . $order_data['order_info']['order_number'];
            $order_no   = str_pad($order_no , 37, " ");
            $date     = date('d/m/y', strtotime($order_data['order_info']['order_date']));
            $printer->text($order_no . $date);
            $printer->text("\n \n");
            $leftCol = 'Item';
            $centerCol = 'Qt x Price';
            $rightCol = 'Total';
            $printer->text($this->columnify($leftCol, $centerCol, $rightCol, 22, 10, 5, 4));
            $printer->text(str_pad("-", 47, "-"));
            $printer->text("\n");
            foreach ($order_data['items'] as $item) {
                $leftCol   = $item['product'];
                $centerCol = $item['quantity'] .'x'. $item['unit_price'];
                $rightCol  = $item['gross_amount'];

                $printer->text($this->columnify($leftCol, $centerCol, $rightCol, 22, 10, 5, 4));
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
            $printer->text("\n\n");
            $paid = 'Paid : '.$order_data['order_info']['paid_amount'];
            $due  = 'Due: '. $order_data['summary']['net_amount'] - $order_data['order_info']['paid_amount'];
            $paid = str_pad($paid , 13, " ");
            $due  = str_pad($due , 15, " ");
            $printer->text($paid. $due);
            $printer->text("\n\n");
            $printer->setTextSize(1, 1);
            $printer->text("Developed By SCSS");
            $printer->text("\n\n");
            $printer->cut();
            $printer->close();
            return true;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function networkPrint($order_id)
    {
        try
        {
            $order_data = (new OrderManagementService())->viewOrderDetails($order_id);

            $printerIp   = config('bof.printer_ip');
            $printerPort = config('bof.printer_port');
            $connector   = new NetworkPrintConnector($printerIp, $printerPort);
            $printer     = new Printer($connector);

            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setTextSize(1, 1);
            $printer->text("Bangladesh Ordnance Factories\n\n");
            $printer->setTextSize(1, 1);
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $order_no = 'Order: ' . $order_data['order_info']['order_number'];
            $order_no   = str_pad($order_no , 37, " ");
            $date     = date('d/m/y', strtotime($order_data['order_info']['order_date']));
            $printer->text($order_no . $date);
            $printer->text("\n \n");
            $leftCol = 'Item';
            $centerCol = 'Qt x Price';
            $rightCol = 'Total';
            $printer->text($this->columnify($leftCol, $centerCol, $rightCol, 22, 10, 5, 4));
            $printer->text(str_pad("-", 47, "-"));
            $printer->text("\n");
            foreach ($order_data['items'] as $item) {
                $leftCol   = $item['product'];
                $centerCol = $item['quantity'] .'x'. $item['unit_price'];
                $rightCol  = $item['gross_amount'];

                $printer->text($this->columnify($leftCol, $centerCol, $rightCol, 22, 10, 5, 4));
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
            $printer->text("\n\n");
            $paid = 'Paid : '.$order_data['order_info']['paid_amount'];
            $due  = 'Due: '. $order_data['summary']['net_amount'] - $order_data['order_info']['paid_amount'];
            $paid = str_pad($paid , 13, " ");
            $due  = str_pad($due , 15, " ");
            $printer->text($paid. $due);
            $printer->text("\n\n");
            $printer->setTextSize(1, 1);
            $printer->text("Developed By SCSS");
            $printer->text("\n\n");
            $printer->cut();
            $printer->close();
            return true;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    private function columnify($leftCol, $centerCol, $rightCol, $leftWidth, $centerWidth, $rightWidth, $space = 4)
    {
        $leftWrapped   = wordwrap($leftCol, $leftWidth, "\n", true);
        $centerWrapped = wordwrap($centerCol, $centerWidth, "\n", true);
        $rightWrapped  = wordwrap($rightCol, $rightWidth, "\n", true);

        $leftLines   = explode("\n", $leftWrapped);
        $centerLines = explode("\n", $centerWrapped);
        $rightLines  = explode("\n", $rightWrapped);
        $allLines = array();
        for ($i = 0; $i < max(count($leftLines),count($centerLines), count($rightLines)); $i ++) {
            $leftPart   = str_pad($leftLines[$i] ?? "", $leftWidth, " ");
            $centerPart = str_pad($centerLines[$i] ?? "", $centerWidth, " ");
            $rightPart  = str_pad($rightLines[$i] ?? "", $rightWidth, " ");
            $allLines[] = $leftPart . str_repeat(" ", $space) . $centerPart . str_repeat(" ", $space). $rightPart;
        }
        return implode("\n", $allLines) . "\n";
    }
}
