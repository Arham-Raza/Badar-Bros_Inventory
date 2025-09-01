<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchasePayment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'purchase_id',
        'amount',
        'payment_date',
        'note',
    ];

    public function purchase()
    {
        return $this->belongsTo(PurchaseMaster::class, 'purchase_id');
    }
}
