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
        $socket = $this->connect('35.192.205.161', 6001, 'dbs', 'dbs', 2000);
        stream_set_timeout($socket, 2);

        return $this->testResponse([
            'socket' => fread($socket,1000),
        ]) ;
    }

    protected function getData($socket)
    {
            $ans = "";
            stream_set_timeout($socket, 2);
            $ans = fread($socket,5000);
            if (strlen($ans)!=0){
                return $ans;
            }
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
