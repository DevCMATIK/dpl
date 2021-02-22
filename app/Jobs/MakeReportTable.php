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
            $date = $device->sensors->map(function($sensor){
                return $sensor->last_report->created_at ?? null ;
            })->sortDesc()->first();
            return array_merge([
                'grd_id' => $device->grd_id,
                'state' => $this->resolveState($date),
                'date' => $date,
            ],$device->sensors->map(function($sensor){
                return [
                    $sensor->address => $this->resolveConditional($sensor) ?? null
                ];
            })->collapse()->toArray());
        })->toArray();

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
        if($sensor->is_conditional === 1) {
            switch($sensor->option) {
                case 'equalTo' :
                    return ($sensor->last_report->value == $sensor->conditional) ? 1 : 0;
                    break;
                case 'greaterThan' :
                    return ($sensor->last_report->value > $sensor->conditional) ? 1 : 0;
                    break;
                case 'lessThan' :
                    return ($sensor->last_report->value < $sensor->conditional) ? 1 : 0;
                    break;
                case 'greaterOrEqual':
                    return ($sensor->last_report->value >= $sensor->conditional) ? 1 : 0;
                    break;
                case 'lessOrEqual' :
                    return ($sensor->last_report->value <= $sensor->conditional) ? 1 : 0;
                    break;
                default:
                    return ($sensor->last_report->value != $sensor->conditional) ? 0 : 1;
                    break;
            }
        }

        return $sensor->last_report->value ?? null;
    }
}
