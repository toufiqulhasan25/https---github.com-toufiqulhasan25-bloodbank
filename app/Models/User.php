<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     * Akhon student/teacher bad diye eita sobar jonno kora hoyeche.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',        // manager, hospital, donor
        'blood_group', // Shobar jonno
        'phone',       // Shobar jonno
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}