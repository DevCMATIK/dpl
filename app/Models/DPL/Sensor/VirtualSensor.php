<?php

namespace App\Models\DPL\Sensor;

use App\Models\DPL\Device\VirtualDevice;
use App\Traits\HasTest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VirtualSensor extends Model
{
    use HasFactory,HasTest;

    public $timestamps = false;

    protected $fillable = [
        'device_id',
        'address',
        'name',
        'reportable_field',
        'reportable_value',
        'is_conditional',
        'optional',
        'conditional',
        'places'
    ];

    protected $appends = ['last_report'];

    public function device()
    {
        return $this->belongsTo(VirtualDevice::class,'device_id','id');
    }

    public function getLastReportAttribute()
    {
        return  DB::connection($this->device->reportable_db)
            ->table($this->device->reportable_table)
            ->where($this->device->reportable_field,$this->device->reportable_value)
            ->where($this->reportable_field,$this->reportable_value)
            ->orderByDesc('id')
            ->first();
    }
}
