<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReceivedLogs extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'received_logs';

    protected $fillable = [
        'documentID',
        'officeID',
        'sectionID',
        'userID',
        'username',
        'usernameID',
        'pending',
        'created_at',
        'updated_at'
    ];

    public function User() {
        return $this->hasOne(User::class, 'id', 'userID')->withTrashed();
    }
    public function UsernameID() {
        return $this->hasOne(User::class, 'id', 'usernameID')->withTrashed();
    }
    public function Username() {
        return $this->hasOne(User::class, 'id', 'username')->withTrashed();
    }
    public function Office() {
        return $this->hasOne(Sections::class, 'id', 'officeID')->withTrashed();
    }
    public function Document() {
        return $this->hasOne(Documents::class, 'id', 'documentID')->withTrashed();
    }
    public function Section() {
        return $this->hasOne(Sections::class, 'id', 'sectionID')->withTrashed();
    }
}
