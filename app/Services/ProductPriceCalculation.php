<?php

namespace App\Services;

use Exception;

class ProductPriceCalculation
{
     public function makePrice($cogs_price)
     {
        try
        {
            $percentage = 0;
            if($cogs_price < 1){
                return 0;
            }

            if($cogs_price <= 1000){
                $percentage = ($cogs_price * 25) / 100;
            }
            else if($cogs_price <= 2000){
                $percentage = ($cogs_price * 20) / 100;
            }
            else if($cogs_price > 2000 ){
                $percentage = ($cogs_price * 15) / 100;
            }
            return ($cogs_price + $percentage);
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
     }
}
