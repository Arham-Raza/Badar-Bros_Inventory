<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseMaster extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'vendor_id',
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
        return $this->hasMany(PurchaseDetail::class, 'purchase_master_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Account::class, 'vendor_id');
    }

    public function payments()
    {
        return $this->hasMany(Transaction::class, 'purchase_id');
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
}
