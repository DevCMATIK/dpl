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
            Report::updateOrCreate([$data['grd_id']],[
                'state' => $data['state'] ?? null,
                'date' => $data['date'],
                'i1' => $data['i1'] ?? null,
                'i2'=> $data['i2'] ?? null,
                'i3'=> $data['i3'] ?? null,
                'i4'=> $data['i4'] ?? null,
                'i5'=> $data['i5'] ?? null,
                'o1'=> $data['o1'] ?? null,
                'o2'=> $data['o2'] ?? null,
                'o3'=> $data['o3'] ?? null,
                'o4'=> $data['o4'] ?? null,
                'o5'=> $data['o5'] ?? null,
                'p1'=> $data['p1'] ?? null,
                'p2'=> $data['p2'] ?? null,
                'p3'=> $data['p3'] ?? null,
                'p4'=> $data['p4'] ?? null,
                'p5'=> $data['p5'] ?? null,
                'p6'=> $data['p6'] ?? null,
                'p7'=> $data['p7'] ?? null,
                'p8'=> $data['p8'] ?? null,
                'p9'=> $data['p9'] ?? null,
                'p10'=> $data['p10'] ?? null,
                'p11'=> $data['p11'] ?? null,
                'p12'=> $data['p12'] ?? null,
                'p13'=> $data['p13'] ?? null,
                'p14'=> $data['p14'] ?? null,
                'p15'=> $data['p15'] ?? null,
                'p16'=> $data['p16'] ?? null,
                'p17'=> $data['p17'] ?? null,
                'p18'=> $data['p18'] ?? null,
                'p19'=> $data['p19'] ?? null,
                'p20'=> $data['p20'] ?? null,
                'p21'=> $data['p21'] ?? null,
                'p22'=> $data['p22'] ?? null,
                'p23'=> $data['p23'] ?? null,
                'p24'=> $data['p24'] ?? null,
                'p25'=> $data['p25'] ?? null,
                'an1'=> $data['an1'] ?? null,
                'an2'=> $data['an2'] ?? null,
                'an3'=> $data['an3'] ?? null,
                'an4'=> $data['an4'] ?? null,
                'an5'=> $data['an5'] ?? null,
            ]);
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
