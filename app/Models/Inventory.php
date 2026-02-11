<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'blood_group',
        'units', // আমরা কন্ট্রোলারেও এই নাম ব্যবহার করব
        'expiry_date'
    ];

    public function isExpired()
    {
        return \Carbon\Carbon::now()->greaterThan($this->expiry_date);
    }
}
