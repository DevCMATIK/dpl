<?php

namespace App\Http\Test\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DPL\Device\VirtualDevice;
use App\Models\DPL\Sensor\VirtualSensor;
use App\Traits\HasTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestSensorsDataController extends Controller
{
    use HasTest;

    public function testData()
    {
        $sensor = VirtualSensor::with('device')->first();

        return $this->testResponse([
            'virtual_sensor' => $sensor,
            'reports' => $this->getReports($sensor)
        ]);
    }

    protected function getReports($sensor)
    {
        return  DB::connection($sensor->device->reportable_db)
            ->table($sensor->device->reportable_table)
            ->where($sensor->device->reportable_field,$sensor->device->reportable_value)
            ->where($sensor->reportable_field,$sensor->reportable_value)
            ->orderByDesc('id')
            ->take(10)
            ->get();
    }
}
