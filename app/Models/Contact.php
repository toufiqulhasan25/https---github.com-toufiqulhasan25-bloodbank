<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    // নিচের এই অংশটুকু যোগ করুন
    protected $fillable = [
        'name',
        'contact_info',
        'message',
    ];
}