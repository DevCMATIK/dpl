<?php

namespace App\Http\DPL\Device;

use App\Http\Controllers\Controller;
use App\Models\DPL\Device\VirtualDevice;
use App\Traits\HasTest;
use Illuminate\Http\Request;

class DefineDevicesController extends Controller
{
    use HasTest;

    public function defineDevices()
    {
        foreach($this->getDevices() as $device) {
            VirtualDevice::updateOrCreate(
                [
                    'grd_id' => $device['grd_id']
                ] ,
                [
                    'name' => $device['name'],
                    'reportable_db' => $device['reportable_db'],
                    'reportable_table' => $device['reportable_table'],
                    'reportable_field' => $device['reportable_field'],
                    'reportable_value' => $device['reportable_value'],
                ]);
        }

        return $this->testResponse(VirtualDevice::get());
    }

    protected function getDevices()
    {
        return array(
            [
                'grd_id' => 3500,
                'name' => 'Pozo 1 ejemplo',
                'reportable_db' => 'sopraval',
                'reportable_table' => 'external_reports',
                'reportable_field' => 'code',
                'reportable_value' => 'O_0504_1115',
            ],
            [
                'grd_id' => 3501,
                'name' => 'Pozo 2 ejemplo',
                'reportable_db' => 'sopraval',
                'reportable_table' => 'external_reports',
                'reportable_field' => 'code',
                'reportable_value' => 'OB_999_9999',
            ],
            [
                'grd_id' => 3502,
                'name' => 'Pozo 3 ejemplo',
                'reportable_db' => 'sopraval',
                'reportable_table' => 'external_reports',
                'reportable_field' => 'code',
                'reportable_value' => 'OB_888_8888',
            ]
        );
    }
}
