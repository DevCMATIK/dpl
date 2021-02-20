<?php

namespace App\Http\Test\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DPL\Device\VirtualDevice;
use App\Traits\HasTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestDevicesDataController extends Controller
{
    use HasTest;

    public function testData()
    {
        $device = VirtualDevice::first();

        return $this->testResponse([
            'virtual_device' => $device,
            'reports' => $this->getReports($device)
        ]);
    }

    protected function getReports($device)
    {
        return  DB::connection($device->reportable_db)
            ->table($device->reportable_table)
            ->where($device->reportable_field,$device->reportable_value)
            ->orderByDesc('id')
            ->take(10)
            ->get();
    }
}
