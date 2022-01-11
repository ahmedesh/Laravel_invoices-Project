<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

// خاص للاشعارات

class User extends Authenticatable
{
    use Notifiable;  // خاص للاشعارات
    use HasRoles;  // خاص بالصلاحيات

    protected $fillable = [
        'name' , 'email' , 'password' , 'roles_name', 'Status',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'roles_name' => 'array',   // عشان اليوزر ممكن يكون ادمن او ادمن ويوزر وهكذا يعني اكتر من حاجه مش حاجه وحده بس
    ];
}
