<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Logs extends Model
{
    use HasFactory, SoftDeletes;

    protected $table ="logs";

    protected $fillable = [
        'documentID',
        'trackerID',
        'officeID',
        'sectionID',
        'userID',
        'created_at',
        'updated_at'
    ];

    public function documents()
    {
        return $this->belongsTo(Documents::class, 'documentID');
    }
}
