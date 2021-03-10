<?php

namespace App\Http\Socket;

use App\Http\Controllers\Controller;
use App\Traits\HasTest;
use Illuminate\Http\Request;

class TestSocketController extends Controller
{
    use HasTest;

    public function __invoke()
    {
        return $this->testResponse([
            'socket' => $this->connect('35.192.205.161', 6001, 'dbs', 'dbs', 2000)
        ]) ;
    }

    protected function getData()
    {

    }

    protected function connect($ip, $port, $user, $pass, $id)
    {
        set_time_limit(0);
        $socket = @fsockopen($ip, $port);
        if ($socket != FALSE)
        {
            fputs($socket,$user.",".$pass.",".$id.chr(13));
        }
        return $socket;
    }
}
