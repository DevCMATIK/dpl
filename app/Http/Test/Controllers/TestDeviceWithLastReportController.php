<?php

namespace App\Http\Test\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DPL\Device\VirtualDevice;
use App\Models\DPL\Sensor\VirtualSensor;
use App\Traits\HasTest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TestDeviceWithLastReportController extends Controller
{
    use HasTest;

    public function testData()
    {
        return $this->testResponse(
            VirtualDevice::with('sensors')->get()->map(function($device){
                $date = $device->sensors->map(function($sensor){
                    return $sensor->last_report->created_at ?? null ;
                })->sortDesc()->first();
                return array_merge([
                    'grd_id' => $device->grd_id,
                    'state' => $this->resolveState($date),
                    'date' => $date ?? Carbon::now()->toDateTimeString(),
                ],$device->sensors->map(function($sensor){
                    return [
                        $sensor->address => $this->resolveConditional($sensor) ?? null
                    ];
                })->collapse()->toArray());
            })->toArray()
        );
    }

    protected function resolveState($date)
    {
        if($date === null ){
            return 0;
        } else {
            return (Carbon::now()->diffInMinutes(Carbon::parse($date)) > 5)?0:1;
        }
    }

    protected function resolveConditional($sensor)
    {
        $report_value = $sensor->last_report->value ?? 0;
        if($sensor->is_conditional === 1) {
            switch($sensor->option) {
                case 'equalTo' :
                    return ($report_value ?? 0 == $sensor->conditional) ? 1 : 0;
                    break;
                case 'greaterThan' :
                    return ($report_value  > $sensor->conditional) ? 1 : 0;
                    break;
                case 'lessThan' :
                    return ($report_value  < $sensor->conditional) ? 1 : 0;
                    break;
                case 'greaterOrEqual':
                    return ($report_value  >= $sensor->conditional) ? 1 : 0;
                    break;
                case 'lessOrEqual' :
                    return ($report_value  <= $sensor->conditional) ? 1 : 0;
                    break;
                default:
                    return ($report_value  != $sensor->conditional) ? 0 : 1;
                    break;
            }
        }

        return $report_value ?? null;
    }
}
