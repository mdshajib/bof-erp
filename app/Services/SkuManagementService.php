<?php

namespace App\Services;

use App\Models\Sku;
use Exception;

class SkuManagementService
{
     public function paidLoanProduct($sku_id)
     {
        try
        {
            $sku = Sku::query()->find($sku_id);
            if(!$sku){
                throw new Exception('Sku Not found!');
            }
            $sku->loan_paid = 1;
            $sku->save();
            return true;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
     }
}
