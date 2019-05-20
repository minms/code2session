# Code2Session

## 功能  

微信或头条小程序/小游戏, 通过code换取openid. 


## 安装使用方法  
```
composer require minms/code2session
```

```
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
```