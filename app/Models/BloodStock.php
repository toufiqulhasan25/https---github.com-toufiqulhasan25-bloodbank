<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BloodStock extends Model
{
    protected $fillable = ['user_id', 'blood_group', 'bags'];

    // এই স্টকটি কোন হাসপাতালের তা চেনার জন্য রিলেশন
    public function hospital()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}