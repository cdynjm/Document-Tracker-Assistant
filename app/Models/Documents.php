<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Documents extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "documents";

    protected $fillable = [
        'qrcode',
        'docType',
        'file',
        'trackerID',
        'officeID',
        'userID',
        'remarks',
        'status',
        'pending',
        'download',
        'merged',
        'batchID'
    ];

    public function type() {
        return $this->hasOne(DocumentType::class, 'id', 'docType')->withTrashed();
    }

    public function Office() {
        return $this->hasOne(Offices::class, 'id', 'officeID')->withTrashed();
    }

    public function User() {
        return $this->hasOne(User::class, 'id', 'userID')->withTrashed();
    }
}
