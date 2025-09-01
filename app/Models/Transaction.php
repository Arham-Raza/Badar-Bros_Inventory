<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'purchase_id',
        'sales_id',
        'account_id',
        'counterparty_id',
        'amount',
        'transaction_date',
        'transaction_no',
        'type',
        'payment_term',
        'cheque_no',
        'cheque_date',
        'po_no',
        'po_date',
        'online_transfer_date',
        'note',
        'created_by',
        'updated_by',
    ];

    public function purchase()
    {
        return $this->belongsTo(PurchaseMaster::class, 'purchase_id');
    }

    public function sale()
    {
        return $this->belongsTo(SalesMaster::class, 'sales_id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function counterparty()
    {
        return $this->belongsTo(Account::class, 'counterparty_id');
    }
}
