<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'hospital_id', // এটি যোগ করুন
        'blood_group',
        'units',
        'expiry_date'
    ];

    public function isExpired()
    {
        return \Carbon\Carbon::now()->greaterThan($this->expiry_date);
    }
}
