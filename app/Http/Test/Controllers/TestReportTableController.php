<?php

namespace App\Http\Test\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DPL\Device\VirtualDevice;
use App\Models\ERM\Report;
use App\Traits\HasTest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;

class TestReportTableController extends Controller
{
    use HasTest;

    public function testInsertion()
    {
        foreach($this->toInsertData() as $data)
        {
            Report::updateOrCreate([$data['grd_id']],$data);
        }
        return $this->testResponse(Report::get());
    }

    public function toInsertData()
    {
        return VirtualDevice::with('sensors')->get()->map(function($device){
            return array_merge([
                'grd_id' => $device->grd_id,
                'state' => 1,
                'date' => Carbon::now()->toDateTimeString(),
            ],$device->sensors->map(function($sensor){
                return [
                    $sensor->address => $this->resolveConditional($sensor) ?? null
                ];
            })->collapse()->toArray());
        })->toArray();

    }

    protected function resolveConditional($sensor)
    {
        if($sensor->is_conditional === 1) {
            switch($sensor->option) {
                case 'equalTo' :
                    return ($sensor->last_report_value == $sensor->conditional) ? 1 : 0;
                    break;
                case 'greaterThan' :
                    return ($sensor->last_report_value > $sensor->conditional) ? 1 : 0;
                    break;
                case 'lessThan' :
                    return ($sensor->last_report_value < $sensor->conditional) ? 1 : 0;
                    break;
                case 'greaterOrEqual':
                    return ($sensor->last_report_value >= $sensor->conditional) ? 1 : 0;
                    break;
                case 'lessOrEqual' :
                    return ($sensor->last_report_value <= $sensor->conditional) ? 1 : 0;
                    break;
                default:
                    return ($sensor->last_report_value != $sensor->conditional) ? 0 : 1;
                    break;
            }
        }

        return $sensor->last_report->value ?? null;
    }
}
