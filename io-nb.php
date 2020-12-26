<?php

$streamList = [
       // stream_socket_client('tcp://0.0.0:8080'),
        fopen('arquivo.txt', 'r'),
        fopen('arquivo2.txt', 'r'),
    ];

foreach ($streamList as $stream){
    stream_set_blocking($stream, false);
}

do{
    $copyReadStream = $streamList;
    $numeroDeStreams = stream_select($copyReadStream, $write, $except, 0,0);

    if($numeroDeStreams === 0){
        continue;
    }

    foreach ($copyReadStream as $key => $stream){
        echo fgets($stream);
        unset($streamList[$key]);
    }

} while(!empty($streamList));

echo 'Li todos os streams '. PHP_EOL;

