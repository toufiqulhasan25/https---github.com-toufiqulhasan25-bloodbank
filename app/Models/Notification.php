<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['user_id', 'sender_name', 'message', 'is_read'];

// ইউজারের সাথে রিলেশন (ঐচ্ছিক কিন্তু ভালো)
public function user() {
    return $this->belongsTo(User::class);
}
}
