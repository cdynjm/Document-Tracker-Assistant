<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReturnedLogs extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'returned_logs';

    protected $fillable = [
        'documentID',
        'trackerID',
        'officeID',
        'userID',
        'remarks',
        'created_at',
        'updated_at'
    ];
}

