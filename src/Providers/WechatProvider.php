<?php
/**
 * Created by PhpStorm.
 * User: minms
 * Date: 2019/3/8
 * Time: 13:40
 */

namespace Minms\Code2Session\Providers;

use Minms\Code2Session\ProviderAbstract;

class WechatProvider extends ProviderAbstract
{
    protected $url = 'https://api.weixin.qq.com/sns/jscode2session';

    public function session(string $code, $params = [])
    {
        $params = (array)$params;
        $params['appid'] = $this->getConfig()->get('appid');
        $params['secret'] = $this->getConfig()->get('secret');
        $params['js_code'] = $code;
        $params['grant_type'] = 'authorization_code';

        $res = $this->request(
            $this->buildUrl($this->url, $params)
        );

        if (empty($res) || !isset($res['openid'])) throw new \Error('请求数据失败');

        return [
            'openid' => $res['openid'],
            'session_key' => $res['session_key'],
            'unionid' => isset($res['unionid']) ? $res['unionid'] : null,
        ];
    }
}