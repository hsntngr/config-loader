<?php


namespace Hsntngr\Config;


use Hsntngr\Config\Loaders\BaseLoader;

class Config
{
    public static $instance;

    /**
     * @var array
     */
    protected $configs = [];

    /**
     * @var BaseLoader
     */
    protected $loader;

    public function __construct(BaseLoader $loader)
    {
        $this->loader = $loader;
    }

    public static function create(BaseLoader $loader)
    {
        if (self::$instance) {
            return self::$instance;
        } else {
            self::$instance = new static($loader);

            return self::$instance;
        }
    }

    public function getInstance()
    {
        return self::$instance;
    }

    public function setLoader(BaseLoader $loader)
    {
        $this->loader = $loader;
    }

    public function load($directory = null)
    {
       $this->configs = $this->loader->loadDir($directory);
    }

    public function loadFromFile($path): Config
    {
        $filename = pathinfo($path, PATHINFO_FILENAME);
        $this->configs[$filename] = $this->loader->load($path);

        return $this;
    }

    public function add($key, $value): bool
    {
        if ($this->hasDelimiter($key)) {
            $keys = explode(".", $key);

            $config = &$this->configs;

            foreach ($keys as $index => $_key) {
                if ($index == (count($keys) - 1)) {
                    $config[$_key] = $value;
                    return true;
                }

                if (array_key_exists($_key, $config)) {
                    $config = &$config[$_key];
                } else {
                    $config[$_key] = [];
                    $config = &$config[$_key];
                }
            }
        }

        $this->configs[$key] = $value;

        return true;
    }

    public function get($key)
    {
        # return if there is exact key
        if (array_key_exists($key, $this->configs)) {
            return $this->configs[$key];
        }

        # return null if any segment not specified
        if (!self::hasDelimiter($key)) {
            return;
        }

        $keys = explode(".", $key);

        $parent = array_shift($keys);

        // return null if no file key found
        if (!array_key_exists($parent, $this->configs)) {
            return;
        }

        $array = $this->configs[$parent];

        foreach ($keys as $_key) {
            if (is_array($array)) {
                if (array_key_exists($_key, $array)) {
                    $array = $array[$_key];
                } else {
                    return null;
                }
            } else {
                return $array;
            }
        }

        return $array;
    }

    protected function hasDelimiter($key)
    {
        return strpos($key, ".") !== false;
    }
}