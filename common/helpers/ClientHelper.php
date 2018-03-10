<?php
namespace common\helpers;

class ClientHelper
{
    public $client;
    public $port = 9501;

    public function __construct($port = 9501)
    {
        $this->client = new \swoole_client(SWOOLE_SOCK_TCP);
        if ($port) {
            $this->port = $port;
        }
        $this->client->connect("127.0.0.1", $this->port);
    }

    public function callForReturn($data) //执行远程调用，有响应值
    {
        $this->client->send($data);

        return $this->client->recv();
    }

    public function call($data) //执行远程调用，无返回值
    {
        $this->client->send($data);
    }

    public function close()
    {
        $this->client->close();
    }
}