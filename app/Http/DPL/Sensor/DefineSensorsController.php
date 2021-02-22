<?php

namespace App\Http\DPL\Sensor;

use App\Http\Controllers\Controller;
use App\Models\DPL\Device\VirtualDevice;
use App\Models\DPL\Sensor\VirtualSensor;
use App\Traits\HasTest;
use Illuminate\Http\Request;

class DefineSensorsController extends Controller
{
    use HasTest;

    public function defineSensors()
    {
        foreach($this->getSensors() as $sensor)
        {
            VirtualSensor::updateOrCreate(
                [
                    'device_id' => $sensor['device_id'],
                    'address' => $sensor['address']
                ],
                [
                    'name' => $sensor['name'],
                    'reportable_field' => $sensor['reportable_field'],
                    'reportable_value' => $sensor['reportable_value']
                ]
            );
        }

        return $this->testResponse(VirtualSensor::with('device')->get());
    }

    protected function getSensors()
    {
        return array(
            [
                'device_id' => 1,
                'address' => 'an1',
                'name' => 'Nivel',
                'reportable_field' => 'variable',
                'reportable_value' => 'NivelPozo'
            ],
            [
                'device_id' => 1,
                'address' => 'an2',
                'name' => 'Caudal',
                'reportable_field' => 'variable',
                'reportable_value' => 'CaudalInstantaneo'
            ],
            [
                'device_id' => 1,
                'address' => 'an3',
                'name' => 'Aporte',
                'reportable_field' => 'variable',
                'reportable_value' => 'FlujoAcumulado'
            ],
            [
                'device_id' => 2,
                'address' => 'an1',
                'name' => 'Nivel',
                'reportable_field' => 'variable',
                'reportable_value' => 'NivelPozo'
            ],
            [
                'device_id' => 2,
                'address' => 'an2',
                'name' => 'Caudal',
                'reportable_field' => 'variable',
                'reportable_value' => 'CaudalInstantaneo'
            ],
            [
                'device_id' => 2,
                'address' => 'an3',
                'name' => 'Aporte',
                'reportable_field' => 'variable',
                'reportable_value' => 'FlujoAcumulado'
            ]

        );
    }
}
