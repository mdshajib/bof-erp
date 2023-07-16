<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\SalesItem;
use App\Models\Sku;
use Exception;
use Illuminate\Support\Facades\DB;

class SalesReportService
{
     public function getCategories()
     {
        try
        {
            return Category::select('id', 'name')->get()->toArray();
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
     }
     public function getProducts($get_category_id = null)
     {
        try
        {
            return Product::select('id', 'name')
                ->when($get_category_id, fn ($q, $category_id) => $q->where('category_id', $category_id))
                ->get()
                ->toArray();
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
     }

    public function getSalesData($start, $end, $category_id = null, $product_id = null)
    {
        try {
            return SalesItem::query()
                ->selectRaw('sku_id,SUM(quantity) as quantity,SUM(total_sales_price) as total_sales_price')
                ->whereBetween('created_at', [$start.' 00:00:00', $end.' 23:59:59'])
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
