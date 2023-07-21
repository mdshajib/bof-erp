<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\SalesItem;
use App\Models\Sku;
use Exception;
use Illuminate\Support\Facades\DB;

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
}
