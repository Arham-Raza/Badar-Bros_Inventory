<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity',
        'status',
        'category_id',
        'make_id',
        'weapon_no',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function make()
    {
        return $this->belongsTo(ProductMake::class, 'make_id');
    }
}
