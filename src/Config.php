<?php
/**
 * Created by PhpStorm.
 * User: minms
 * Date: 2019/3/8
 * Time: 13:49
 */

namespace Minms\Code2Session;

use InvalidArgumentException;

class Config
{
    /**
     * @var array
     */
    private $_options = [];

    /**
     * Attributes constructor
     * @param $options
     */
    public function __construct($options)
    {
        $this->_options = $options;
    }

    /**
     * Get an item from constructor options
     *
     * @param $key
     * @param null $default
     * @return array|mixed|null
     */
    public function get($key, $default = null)
    {
        $options = $this->_options;
        if (is_null($key)) {
            return $options;
        }
        if (isset($options[$key])) {
            return $options[$key];
        }
        foreach (explode('.', $key) as $segment) {
            if (!is_array($options) || !array_key_exists($segment, $options)) {
                return $default;
            }
            $options = $options[$segment];
        }
        return $options;
    }

    /**
     * Set an option to a given value
     *
     * @param $key
     * @param $value
     * @return array|mixed
     */
    public function set($key, $value)
    {
        if (is_null($key)) {
            throw new InvalidArgumentException('Invalid param key');
        }
        $keys = explode('.', $key);
        $options = &$this->_options;
        while (count($keys) > 1) {
            $key = array_shift($keys);
            if (!isset($options[$key]) || !is_array($options[$key])) {
                $options[$key] = [];
            }
            $options = &$options[$key];
        }
        $options[array_shift($keys)] = $value;
        return $options;
    }

    /**
     * check exists
     *
     * @param $key
     * @return bool
     */
    public function has($key)
    {
        return (bool)$this->get($key);
    }
}