<?php

namespace App\Models\ERM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'grd_id',
        'status',
        'date',
        'i1', 'i2', 'i3', 'i4', 'i5',
        'o1', 'o2', 'o3', 'o4', 'o5',
        'p1', 'p2', 'p3', 'p4', 'p5',
        'an1', 'an2', 'an3', 'an4', 'an5',
    ];
}
