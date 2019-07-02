<?php
/**
 * Created by PhpStorm.
 * User: yangxiushan
 * Date: 2019-05-28
 * Time: 18:02
 */

$config = [
    'list' => ['127.0.0.1:7000', '127.0.0.1:7001', '127.0.0.1:7002'],

];

$redis = new RedisCluster(null, $config['list']);
$arr = [
    3, 5, 6
];


$redis->hSet("moppet:user:info:888ccf736761fae303b203d4b20344b4", 'coin', 150);
$redis->hSet("moppet:user:info:888ccf736761fae303b203d4b20344b4", 'balance', 0.25);



