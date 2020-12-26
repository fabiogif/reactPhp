<?php
use React\EventLoop\Factory;
use React\Stream\ReadableResourceStream;
use React\Stream\DuplexResourceStream;

require_once  'vendor/autoload.php';
$loop = Factory::create();

$streamList = [
    new DuplexResourceStream(stream_socket_client('tcp://localhost:8000'), $loop),
    new ReadableResourceStream(stream_socket_client('tcp://localhost:8001'), $loop),
    new ReadableResourceStream(fopen('arquivo.txt', 'r'), $loop),
    new ReadableResourceStream(fopen('arquivo2.txt', 'r'), $loop)
];

$streamList[0]->write('GET /http-server.php HTTP/1.1' . "\r\n\r\n");


foreach ($streamList as $readableStream){
    $readableStream->on('data', function (string $data){
        echo $data. PHP_EOL;
    });
}



$loop->run();

