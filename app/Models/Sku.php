<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Sku extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['id', 'product_id','variation_id', 'purchase_order_id','quantity',
    'is_active','cogs_price','selling_price','created_at', 'updated_at', 'deleted_at'];

    protected $dates = ['deleted_at'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function purchase_item()
    {
        return $this->hasOne(PurchaseItem::class, 'sku_id' ,'id');
    }

    public function variation()
    {
        return $this->belongsTo(ProductVariation::class, 'variation_id', 'id');
    }

    public function stock()
    {
        return $this->hasOne(Stock::class, 'sku_id', 'id');
    }

}
