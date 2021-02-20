<?php

namespace App\Http\Test\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DPL\Device\VirtualDevice;
use App\Models\DPL\Sensor\VirtualSensor;
use App\Traits\HasTest;
use Illuminate\Http\Request;

class TestDeviceWithLastReportController extends Controller
{
    use HasTest;

    public function testData()
    {
        return $this->testResponse(
            VirtualDevice::with('sensors')->get()
        );
    }
}
