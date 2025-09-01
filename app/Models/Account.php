<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'account_type',
        'email',
        'cnic',
        'mobile1',
        'mobile2',
        'whatsapp',
        'address',
    ];
}
