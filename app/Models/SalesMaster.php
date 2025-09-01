<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesMaster extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_id',
        'transaction_date',
        'transaction_no',
        'gross_amount',
        'discount_percentage',
        'discount_amount',
        'tax_amount',
        'tax_percentage',
        'net_amount',
        'created_by',
        'updated_by',
    ];

    public function details()
    {
        return $this->hasMany(SalesDetail::class, 'sale_master_id');
    }

    public function customer()
    {
        return $this->belongsTo(Account::class, 'customer_id');
    }

    public function receipts()
    {
        return $this->hasMany(Transaction::class, 'sales_id');
    }
}
