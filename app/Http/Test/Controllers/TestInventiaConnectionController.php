<?php

namespace App\Http\Test\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Inventia\ExternalReport;
use App\Traits\HasTest;
use Illuminate\Http\Request;

class TestInventiaConnectionController extends Controller
{
    use HasTest;

    public function testConnection()
    {
        return $this->testResponse(ExternalReport::take(10)->get());
    }
}
