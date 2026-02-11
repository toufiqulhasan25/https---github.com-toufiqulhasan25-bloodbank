<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BloodRequest extends Model
{
    // ডাটাবেসের কলামগুলোর নাম এখানে থাকতে হবে
    protected $fillable = [
        'hospital_id', 
        'patient_name', 
        'blood_group', 
        'bags_needed', 
        'phone', 
        'location', 
        'reason', 
        'is_read', // <--- এই লাইনটি অবশ্যই থাকতে হবে
        'status'
    ];

    /**
     * এই রিকোয়েস্টটি কোন হাসপাতালের তা জানার জন্য রিলেশন।
     */
    public function hospital()
    {
        return $this->belongsTo(User::class, 'hospital_id');
    }
}