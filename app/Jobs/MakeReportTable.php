<?php

namespace App\Jobs;

use App\Models\DPL\Device\VirtualDevice;
use App\Models\ERM\Report;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class MakeReportTable implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::table('reports')->truncate();
        Report::insert($this->toInsertData());
    }

    protected function toInsertData()
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
