<?php

namespace App\Traits;

trait HasTest
{
    public function getExecutionTime()
    {
        return [
            'time_in_seconds' => (microtime(true) - LARAVEL_START)
        ];
    }

    public function testResponse($results)
    {
        return response()->json(array_merge(['results' => $results],$this->getExecutionTime()));
    }

    public function getModelFromTable($table)
    {
        foreach( get_declared_classes() as $class ) {
            if( is_subclass_of( $class, 'Illuminate\Database\Eloquent\Model' ) ) {
                $model = new $class;
                if ($model->getTable() === $table)
                    return $class;
            }
        }

        return false;
    }
}
