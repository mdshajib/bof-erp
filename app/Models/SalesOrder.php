<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'generated_by', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Contact::class, 'contact_id', 'id');
    }

    public function sales_items()
    {
        return $this->hasMany(SalesItem::class);
    }
}
