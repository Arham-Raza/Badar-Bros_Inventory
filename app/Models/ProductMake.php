<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductMake extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'status',
        'created_by',
        'updated_by',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'make_id');
    }
}
