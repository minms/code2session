<?php
/**
 * Created by PhpStorm.
 * User: minms
 * Date: 2019/3/8
 * Time: 15:11
 */

spl_autoload_register(function ($class) {
    $class = str_replace('Minms\\Code2Session\\', 'src/', $class);
    $class = str_replace('\\', '/', $class);
    $path = __DIR__ . '/../' . $class . '.php';

    if (file_exists(realpath($path))) {
        require_once $path;
    }
});


use Minms\Code2Session\Code2Session;

$code = '';
$config = [
    'wechat' => [
        'appid' => '',
        'secret' => '',
    ],
    'toutiao' => [
        'appid' => '',
        'secret' => '',
    ]
];

$instance = Code2Session::instance($config);
$result = $instance->driver('wechat')->session($code);

var_dump($result);