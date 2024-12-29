<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecentLogs extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "system_logs";

    protected $fillable = [
        'name',
        'email',
        'phone',
        'browser',
        'device',
        'platform',
        'ip_address'
    ];
}
