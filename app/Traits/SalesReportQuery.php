<?php

namespace App\Traits;

use App\Services\SalesReportService;
use Exception;

trait SalesReportQuery
{
    public $category_id     = null;
    public $product_id      = null;
    public $start           = null;
    public $end             = null;
    public $processingData  = [];
    public $category_list   = [];
    public $product_list    = [];
    public $get_category_id = 0;
    public $get_product_id  = 0;

    public function intFilterOptionsData()
    {
        $this->categoryList();
        $this->productList();
    }
    private function categoryList()
    {
        try {
            $default_category[] = ['id'=>0, 'name'=>'All'];
            $this->category_list = (new SalesReportService())->getCategories();
            $this->category_list = array_merge($default_category, $this->category_list);
        } catch ( Exception $ex){
            return $ex->getMessage();
        }
    }

    private function productList()
    {
        try {
            $default_product[] = ['id'=>0, 'name'=>'All'];
            $this->product_list = (new SalesReportService())->getProducts($this->category_id);
            $this->product_list=array_merge($default_product, $this->product_list);
        } catch ( Exception $ex){
            return $ex->getMessage();
        }
    }

    private function getSalesData()
    {
        try {
            return (new SalesReportService())->getSalesData($this->start , $this->end, $this->category_id, $this->product_id);
        }catch ( Exception $ex){
            return $ex->getMessage();
        }
    }
}
