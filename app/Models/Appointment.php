<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'donor_name',
        'blood_group',
        'date',
        'time',
        'status'
    ];
}

