<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sale_master_id',
        'product_id',
        'rate',
        'quantity',
        'amount',
        'created_by',
        'updated_by',
    ];

    public function master()
    {
        return $this->belongsTo(SalesMaster::class, 'sale_master_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
