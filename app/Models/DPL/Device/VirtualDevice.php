<?php

namespace App\Models\DPL\Device;

use App\Models\DPL\Sensor\VirtualSensor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VirtualDevice extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'grd_id',
        'name',
        'reportable_db',
        'reportable_table',
        'reportable_field',
        'reportable_value'
    ];

    public function sensors()
    {
        return $this->hasMany(VirtualSensor::class,'device_id','id');
    }
}
