<?php

namespace App\Models\Inventia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalReport extends Model
{
    use HasFactory;

    protected $connection= 'sopraval';

    protected $table = 'sopraval.external_reports';

    public function scopeFilter($query,$field,$value)
    {
        return $query->where($field,$value);
    }
}
