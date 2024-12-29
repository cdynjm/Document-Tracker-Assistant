<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sections extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "sections";

    protected $fillable = [
        'officeID',
        'section'
    ];

    public function Office() {
        return $this->hasOne(Offices::class, 'id', 'officeID')->withTrashed();
     }
}
