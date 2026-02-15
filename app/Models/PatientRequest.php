<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientRequest extends Model
{
    use HasFactory;

    // Mass Assignment এর জন্য এই ফিল্ডগুলো অবশ্যই থাকতে হবে
    protected $fillable = [
        'user_id',
        'hospital_id',
        'blood_group',
        'bags',
        'patient_name',
        'contact_number',
        'status'
    ];

    // রিলেশনশিপ: এই রিকোয়েস্টটি কোন ইউজার পাঠিয়েছে
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // রিলেশনশিপ: এই রিকোয়েস্টটি কোন হাসপাতালে পাঠানো হয়েছে
    public function hospital()
    {
        return $this->belongsTo(User::class, 'hospital_id');
    }
}