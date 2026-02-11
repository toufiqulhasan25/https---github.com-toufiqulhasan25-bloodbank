<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    protected $fillable = [
        'user_id',
        'hospital_id',
        'donor_name',
        'blood_group',
        'date',
        'time',
        'status',
        'note'
    ];

    // ডোনারের সাথে রিলেশন
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function hospital()
    {
        return $this->belongsTo(User::class, 'hospital_id');
    }
}