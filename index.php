<?php 
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare('hello', false, false, false, false);

for($i= 0; $i<100; $i++){
    sleep(4);
    $id = uniqid();
    $msg = new AMQPMessage('Hello World! '.$id);
    $channel->basic_publish($msg, '', 'hello');

    echo " [x] Sent 'Hello World! $id'\n";
}

$channel->close();
$connection->close();

?>