<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataAnalytics extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "data_analytics";

    protected $fillable = [
        'logID',
        'sectionID',
        'received',
        'forward_return',
    ];

    public function Section() {
        return $this->hasOne(Sections::class, 'id', 'sectionID')->withTrashed();
    }

}
