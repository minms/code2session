<?php
/**
 * Created by PhpStorm.
 * User: minms
 * Date: 2019/3/8
 * Time: 14:46
 */

namespace Minms\Code2Session\Providers;


use Minms\Code2Session\ProviderAbstract;

class ToutiaoProvider extends ProviderAbstract
{
    protected $url = 'https://developer.toutiao.com/api/apps/jscode2session';

    public function session(string $code, $params = [])
    {
        $params = (array)$params;
        $params['appid'] = $this->getConfig()->get('appid');
        $params['secret'] = $this->getConfig()->get('secret');
        $params['code'] = $code;

        $res = $this->request(
            $this->buildUrl($this->url, $params)
        );

        if (empty($res)) throw new \Error('请求数据失败');
        if (isset($res['error']) && $res['error'] > 0) throw new \Exception($res['message']);

        return [
            'session_key' => $res['session_key'],
            'openid' => $res['openid'],
            'anonymous_openid' => isset($res['anonymous_openid']) ? $res['anonymous_openid'] : null,
        ];
    }
}