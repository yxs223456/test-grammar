
<?php
//class RSA
//{
//    private $pubKey = null;
//    private $priKey = null;
//
//    /**
//     * RSA constructor.
//     * @param string $public_key_file 公钥文件 （验签和加密时传入）
//     * @param string $private_key_file 私钥文件 （签名和解密时传入）
//     */
//    public function __construct($public_key_file = '', $private_key_file = '')
//    {
//        $this->_getPublicKey($public_key_file);
//        $this->_getPrivateKey($private_key_file);
//
//    }
//
//    private function _getPublicKey($file)
//    {
//        $key_content = $this->_readFile($file);
//        if ($key_content) {
//            $this->pubKey = openssl_get_publickey($key_content);
//        }
//    }
//
//    private function _getPrivateKey($file)
//    {
//        $key_content = $this->_readFile($file);
//        if ($key_content) {
//            $this->priKey = openssl_get_privatekey($key_content);
//        }
//    }
//
//    private function _readFile($file)
//    {
//        if (!file_exists($file)) {
//            $this->_error("The file {$file} is not exists");
//        }
//
//        return file_get_contents($file);
//    }
//
//    /**
//     * 检测填充类型
//     * 加密只支持 PKCS1_PADDING
//     * 解密支持 PKCS1_PADDING 和 NO_PADDING
//     *
//     * @param $padding int 填充模式
//     * @param $type string 加密en/解密de
//     * @return bool
//     */
//    private function _checkPadding($padding, $type)
//    {
//        if ($type == 'en') {
//            switch ($padding) {
//                case OPENSSL_PKCS1_PADDING:
//                    $ret = true;
//                    break;
//                default:
//                    $ret = false;
//            }
//        } else {
//            switch ($padding) {
//                case OPENSSL_PKCS1_PADDING:
//                case OPENSSL_NO_PADDING:
//                    $ret = true;
//                    break;
//                default:
//                    $ret = false;
//            }
//        }
//
//        return $ret;
//    }
//
//    private function _encode($data, $code)
//    {
//        switch (strtolower($code)) {
//            case 'base64':
//                $data = base64_encode('' . $data);
//                break;
//            case 'hex':
//                $data = bin2hex($data);
//                break;
//            case 'bin':
//            default:
//        }
//
//        return $data;
//    }
//
//    private function _decode($data, $code)
//    {
//        switch (strtolower($code)) {
//            case 'base64':
//                $data = base64_decode($data);
//                break;
//            case 'hex':
//                $data = $this->_hex2bin($data);
//                break;
//            case 'bin':
//            default:
//        }
//
//        return $data;
//    }
//
//    private function _hex2bin($hex = false)
//    {
//        $ret = $hex !== false && preg_match('/^[0-9a-fA-F]+$/i', $hex) ? pack("H*", $hex) : false;
//        return $ret;
//    }
//
//    private function _error($msg)
//    {
//        die('RSA Error:' . $msg);
//    }
//
//    /**
//     * 生成签名
//     *
//     * @param $data string 签名材料
//     * @param string $code string 签名编码（base64/hex/bin）
//     * @return bool|string 签名值
//     */
//    public function sign($data, $code = 'base64')
//    {
//        $ret = false;
//        if (openssl_sign($data, $ret, $this->priKey)) {
//            $ret = $this->_encode($ret, $code);
//        }
//
//        return $ret;
//    }
//
//    /**
//     *验证签名
//     *
//     * @param $data string 签名材料
//     * @param $sign string 签名值
//     * @param string $code 签名编码(base64/hex/bin)
//     * @return bool
//     */
//    public function verify($data, $sign, $code = 'base64')
//    {
//        $ret = false;
//        $sign = $this->_decode($sign, $code);
//        if ($sign !== false) {
//            switch (openssl_verify($data, $sign, $this->pubKey)) {
//                case 1:
//                    $ret = true;
//                    break;
//                case 0:
//                case -1:
//                default:
//                    $ret = false;
//            }
//        }
//
//        return $ret;
//    }
//
//    /**
//     * 加密
//     *
//     * @param $data string 明文
//     * @param string $code 密文编码(base64/hex/bin)
//     * @param int $padding 填充方式（貌似php有bug，所以目前仅支持OPENSSL_PKCS1_PADDING）
//     * @return bool|string 密文
//     */
//    public function encrypt($data, $code = 'base64', $padding = OPENSSL_PKCS1_PADDING)
//    {
//        $ret = false;
//        if (!$this->_checkPadding($padding, 'en')) {
//            $this->_error('padding error');
//        }
//        if (openssl_public_encrypt($data, $result, $this->pubKey, $padding)) {
//            $ret = $this->_encode($result, $code);
//        }
//
//        return $ret;
//    }
//
//    /**
//     * 解密
//     *
//     * @param $data string 密文
//     * @param string $code 密文编码 （base64/hex/bin）
//     * @param int $padding 填充方式（OPENSSL_PKCS1_PADDING / OPENSSL_NO_PADDING）
//     * @param bool $rev 是否翻转明文（When passing Microsoft CryptoAPI-generated RSA cyphertext, revert the bytes in the block）
//     * @return bool|string 明文
//     */
//    public function decrypt($data, $code = 'base64', $padding = OPENSSL_PKCS1_PADDING, $rev = false)
//    {
//        $ret = false;
//        if (!$this->_checkPadding($padding, 'de')) {
//            $this->_error('padding error');
//        }
//        $data = $this->_decode($data, $code);
//        if ($data !== false) {
//            if (openssl_private_decrypt($data, $result, $this->priKey, $padding)) {
//                $ret = $rev ? rtrim(strrev($result), "\0") : '' . $result;
//            }
//        }
//
//        return $ret;
//    }
//}
//
//$public_key_file = './ras_public_key.pem';
//$private_key_file = './ras_private_key.pem';
//$rsa = new RSA($public_key_file, $private_key_file);
//
//$rst = array(
//    'ret' => 200,
//    'code' => 1,
//    'data' => array(1, 2, 3, 4, 5, 6),
//    'msg' => "success",
//);
//$ex = json_encode($rst);
//
////加密
//$ret_e = $rsa->encrypt($ex);
//
////解密
//$ret_d = $rsa->decrypt($ret_e);
//
//$a = 'test';
//
//$x = $rsa->sign($a);
//
//$y = $rsa->verify($a, $x);
//var_dump($x, $y);

$config = [
    'host' => '127.0.0.1',
    'vhost' => '/',
    'port' => 5672,
    'login' => 'guest',
    'password' => 'guest'
];

try {
    //连接broker
    $connection = new AMQPConnection($config);

    if (!$connection->connect()) {
        echo "Cannot connect to the broker";
        die();
    }

//在连接内创建一个通道
    $channel = new AMQPChannel($connection);

//创建一个交换机
    $exchange = new AMQPExchange($channel);

//声明路由键
    $routingKey = 'key_1';

//声明交换机名称
    $exchangeName = 'exchange_1';

//设置交换机名称
    $exchange->setName($exchangeName);

//设置交换机类型
    $exchange->setType(AMQP_EX_TYPE_DIRECT);

//设置交换机持久
    $exchange->setFlags(AMQP_DURABLE);

//声明交换机
    $exchange->declareExchange();

//创建一个消息队列
    $queue = new AMQPQueue($channel);

//设置队列名称
    $queue->setName('queue_1');

//设置队列持久
    $queue->setFlags(AMQP_DURABLE);

//声明消息队列
    $queue->declareQueue();

//交换机和队列通过 路由键 绑定
    $queue->bind($exchange->getName(), $routingKey);

//接收消息并进行处理的回调方法
    function receive($envelope, $queue) {
        //消息内容
        $msg = $envelope->getBody() . PHP_EOL;
        //显示确认，队列收到消息者显示确认后，会删除该消息
        $queue->ack($envelope->getDeliveryTag());
        var_dump($msg);
        if ($msg) {
            sleep(1);
        }
    }

//设置消息队列消费者回调方法，并进行阻塞
    $queue->consume("receive");
} catch (Throwable $e) {
    var_dump($e->getFile());
    var_dump($e->getLine());
    var_dump($e->getMessage());
}
