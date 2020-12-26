<?php

use  GuzzleHttp\Client;

require_once 'vendor/autoload.php';

$client = new Client();


$promessa1 = $client->get('http://0.0.0.0:9090/http-server.php');
$promessa2 = $client->get('http://0.0.0.0:9000/http-server.php');




echo 'Resporta 1' . $promessa1->getBody()->getContents();
echo 'Resporta 2' . $promessa2->getBody()->getContents();
