<?php

use Ds\Set;
use Ratchet\ConnectionInterface;
use Ratchet\Http\HttpServer;
use Ratchet\RFC6455\Messaging\MessageInterface;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\WebSocket\MessageComponentInterface;


require_once 'vendor/autoload.php';


$chatComponent = new class implements MessageComponentInterface{

    private Set $connetions;

    public function __construct()
    {
        $this->connetions = new Set();
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->connetions->add($conn);
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->connetions->remove($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo 'Erro: '. $e->getTraceAsString();
    }

    public function onMessage(ConnectionInterface $from, MessageInterface $msg)
    {
            /** @var ConnectionInterface $connetion */
            foreach ($this->connetions as $connetion){
                    if($connetion !== $from){
                        $connetion->send((string) $msg);
                    }
            }
    }
};


$server = IoServer::factory(
    new HttpServer(
        new WsServer($chatComponent)
    ),
    8002
);

$server->run();