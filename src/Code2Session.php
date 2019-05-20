<?php
/**
 * Created by PhpStorm.
 * User: minms
 * Date: 2019/3/8
 * Time: 13:39
 */

namespace Minms\Code2Session;

/**
 *
 * Class Code2Session
 * @package Minms\Code2Session
 */
class Code2Session
{
    /**
     * Manager instance
     *
     * @var static
     */
    private static $_instance = null;

    /**
     * The array of created "drivers"
     *
     * @var ProviderAbstract[]
     */
    protected $_drivers = [];

    /**
     * Configuration
     * @var Config|null
     */
    protected $_config = null;

    /**
     * Single instance
     *
     * @param array $config
     * @return static
     */
    public static function instance(array $config)
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new static($config);
        }

        return self::$_instance;
    }

    /**
     * Constructor
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->_config = new Config($config);
    }

    /**
     * Get a driver
     *
     * @param $driver
     * @return ProviderAbstract
     */
    public function driver($driver)
    {
        if (!isset($this->_drivers[$driver])) {
            $driverName = str_replace(' ', '', ucwords($driver));
            $provider = __NAMESPACE__ . '\\Providers\\' . $driverName . 'Provider';

            if (!class_exists($provider)) {
                throw new \InvalidArgumentException("Driver [$driver] not supported");
            }

            $this->_drivers[$driver] = new $provider(new Config($this->_config->get($driver)));
        }
        return $this->_drivers[$driver];
    }
}