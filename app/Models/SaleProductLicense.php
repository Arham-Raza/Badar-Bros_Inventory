<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleProductLicense extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sale_detail_id',
        'license_name',
        'license_no',
        'license_issue_date',
        'valid_upto',
        'issued_by',
        'cnic_no',
        'contact_no',
        'weapon_type',
        'weapon_no',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function saleDetail()
    {
        return $this->belongsTo(SalesDetail::class, 'sale_detail_id');
    }
}
