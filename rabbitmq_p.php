<?php
$config = [
    'host' => '127.0.0.1',
    'vhost' => '/',
    'port' => 5672,
    'login' => 'guest',
    'password' => 'guest',
];

//连接broker
$connection = new AMQPConnection($config);
if (!$connection->connect()) {
    echo "Cannot connect to the broker" . PHP_EOL;
    exit;
}

//在连接内创建一个通道
$channel = new AMQPChannel($connection);

//创建一个交换机
$exchange = new AMQPExchange($channel);

//消息的路由键，要和消费者端一致
$routingKey = 'key_1';

//交换机名称，要和消费者端一致
$exchangeName = 'exchange_1';
$exchange->setName($exchangeName);

//设置交换机类型为 直连交换机
$exchange->setType(AMQP_EX_TYPE_DIRECT);

//设置交换机持久
$exchange->setFlags(AMQP_DURABLE);

//声明交换机
$exchange->declareExchange();

for ($i = 1; $i <= 100; $i++) {
    //消息内容
    $msg = array(
        'data'  => 'message_'.$i,
        'hello' => 'world',
    );

    //发送消息到交换机，并返回发送结果
    //delivery_model:2 声明消息持久，持久的队列+持久的消息在RabbitMQ重启后才不会丢失
    echo "Send Message:" . $exchange->publish(json_encode($msg), $routingKey, AMQP_NOPARAM, ['delivery_mode'=>2]) . PHP_EOL;
}