<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'officeID',
        'sectionID',
        'name',
        'email',
        'password',
        'role',
        'special'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Check if the user is online
     *
     * @return bool
     */
    public function isOnline()
    {
        return Cache::has('user-online-' . $this->id);
    }

    /**
     * Mark the user as online
     *
     * @return void
     */
    public function markAsOnline()
    {
        Cache::put('user-online-' . $this->id, true, now()->addMinutes(5));
    }

    public function Office() {
       return $this->hasOne(Offices::class, 'id', 'officeID')->withTrashed();
    }

    public function Section() {
        return $this->hasOne(Sections::class, 'id', 'sectionID')->withTrashed();
    }
}