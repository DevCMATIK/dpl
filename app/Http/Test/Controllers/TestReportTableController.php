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
        dd($this->toInsertData());
        return $this->testResponse($this->toInsertData());
        foreach($this->toInsertData() as $data)
        {
            Report::updateOrCreate([$data['grd_id']],[
                'status' => $data['status'],
                'date' => $data['date'],
                'i1' => $data['i1'],
                'i2'=> $data['i2'],
                'i3'=> $data['i3'],
                'i4'=> $data['i4'],
                'i5'=> $data['i5'],
                'o1'=> $data['o1'],
                'o2'=> $data['o2'],
                'o3'=> $data['o3'],
                'o4'=> $data['o4'],
                'o5'=> $data['o5'],
                'p1'=> $data['p1'],
                'p2'=> $data['p2'],
                'p3'=> $data['p3'],
                'p4'=> $data['p4'],
                'p5'=> $data['p5'],
                'p6'=> $data['p6'],
                'p7'=> $data['p7'],
                'p8'=> $data['p8'],
                'p9'=> $data['p9'],
                'p10'=> $data['p10'],
                'p11'=> $data['p11'],
                'p12'=> $data['p12'],
                'p13'=> $data['p13'],
                'p14'=> $data['p14'],
                'p15'=> $data['p15'],
                'p16'=> $data['p16'],
                'p17'=> $data['p17'],
                'p18'=> $data['p18'],
                'p19'=> $data['p19'],
                'p20'=> $data['p20'],
                'p21'=> $data['p21'],
                'p22'=> $data['p22'],
                'p23'=> $data['p23'],
                'p24'=> $data['p24'],
                'p25'=> $data['p25'],
                'an1'=> $data['an1'],
                'an2'=> $data['an2'],
                'an3'=> $data['an3'],
                'an4'=> $data['an4'],
                'an5'=> $data['an5'],
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
