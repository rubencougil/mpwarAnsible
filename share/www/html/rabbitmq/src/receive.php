<?php

require_once __DIR__ . '/../vendor/autoload.php';

use \PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection(
    'spider-01.rmq.cloudamqp.com',
    5672,
    'lqyzhpca',
    'sFwdWk6yBefv1gght3romCTpP5bkva_e',
    'lqyzhpca'
);

$channel = $connection->channel();
$channel->queue_declare('books', false, true, false, false);
$channel->basic_qos(null, 1, null);

$callback = function($msg) use ($channel) {
    echo " [x] Received ", $msg->body, "\n";
    sleep(0);
    $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
    echo "done: " . $msg->delivery_info['delivery_tag'];
};

$channel->basic_consume('books', '', false, false, false, false, $callback);

while(count($channel->callbacks)) {
    $channel->wait();
}