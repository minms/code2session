<?php
/**
 * Created by PhpStorm.
 * User: minms
 * Date: 2019/3/8
 * Time: 14:03
 */

namespace Minms\Code2Session;


abstract class ProviderAbstract
{
    /**
     * @var Config|null
     */
    private $_config = null;

    public function __construct(Config $config)
    {
        $this->_config = $config;
    }

    /**
     * @return Config|null
     */
    protected function getConfig()
    {
        return $this->_config;
    }

    abstract public function session(string $code, $params = []);

    /**
     * 发送请求
     * @param $url
     * @param null $body
     * @param string $method
     * @param bool $json
     * @return mixed
     */
    protected function request($url, $body = null, $method = 'GET', $json = true)
    {
        //初始化
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 0);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //忽略https证书
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

        if (strtoupper($method) === 'POST') {
            //设置post方式提交
            curl_setopt($curl, CURLOPT_POST, 1);
            //设置post数据
            curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        }
        //执行命令
        $data = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        //返回获得的数据

        return $json ? json_decode($data, true) : $data;
    }

    /**
     * 生成带参数的URL链接
     * @param $url
     * @param $params
     * @return string
     */
    protected function buildUrl($url, $params)
    {
        return $url . (strpos($url, '?') !== false ? '&' : '?') . http_build_query($params);
    }
}