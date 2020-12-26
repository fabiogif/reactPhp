<?php

use React\EventLoop\Factory;

require_once 'vendor/autoload.php';

$loop = Factory::create();


$loop->addPeriodicTimer(1, function (){
    echo '1 Segundo'. PHP_EOL;
});
$loop->run();
