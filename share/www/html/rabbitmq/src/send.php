<?php

require_once __DIR__ . '/../vendor/autoload.php';

use \PhpAmqpLib\Connection\AMQPStreamConnection;
use  \PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection(
    'spider-01.rmq.cloudamqp.com',
    5672,
    'lqyzhpca',
    'sFwdWk6yBefv1gght3romCTpP5bkva_e',
    'lqyzhpca'
);

$channel = $connection->channel();
$channel->basic_qos(null, 1, null);

$channel->queue_declare('books', false, true, false, false);

$msg = new AMQPMessage(
    'Hello World!',
    ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]
);

for($i=0; $i<20; $i++) {
    $channel->basic_publish($msg, 'amq.topic', 'book.hello');
    usleep(100);
}

$channel->close();
$connection->close();
