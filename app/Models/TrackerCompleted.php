<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrackerCompleted extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "tracker_completed";

    protected $fillable = [
        'documentID',
        'trackerID',
        'sectionID',
        'officeID',
        'userID',
        'docType'
    ];

    public function Section() {
        return $this->hasOne(Sections::class, 'id', 'sectionID')->withTrashed();
    }
    public function Office() {
        return $this->hasOne(Offices::class, 'id', 'officeID')->withTrashed();
    }
    public function sectionstrack() {
        return $this->belongsTo(Sections::class, 'sectionID')->withTrashed();
    }
}
