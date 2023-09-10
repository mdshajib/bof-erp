<?php

return [

    'printer_name' => env('PRINTER_NAME', 'RONGTA 80mm Series Printer'),
    'printer_ip'   => env('PRINTER_IP','192.168.1.87'),
    'printer_port' => env('PRINTER_PORT',9100),
    'connection_type' => env('PRINTER_CONNECTION','direct') // direct or network
];
