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

    /**
     * Config constructor.
     * @param BaseLoader $loader
     */
    public function __construct(BaseLoader $loader = null)
    {
        $this->loader = $loader;
    }

    /**
     * Creates Config instance
     * @param BaseLoader $loader
     * @return static
     */
    public static function create(BaseLoader $loader = null)
    {
        return self::$instance
            ? self::$instance
            : self::$instance = new static($loader);
    }

    /**
     * Retrieve Config instance
     *
     * @return Config
     */
    public function getInstance(): Config
    {
        return self::$instance;
    }

    /**
     * Set loader to load configuration files
     *
     * @param BaseLoader $loader
     */
    public function setLoader(BaseLoader $loader)
    {
        $this->loader = $loader;
    }

    /**
     * Load configurations
     *
     * @param null $directory
     * @throws Exceptions\DirectoryNotDefined
     */
    public function load($directory = null)
    {
        $this->configs = $this->loader->loadDir($directory);
    }

    /**
     * Load configurations from single file
     *
     * @param $path
     * @return Config
     */
    public function loadFromFile(string $path): Config
    {
        $filename = pathinfo($path, PATHINFO_FILENAME);
        $this->configs[$filename] = $this->loader->load($path);

        return $this;
    }

    /**
     * Set configuration at runtime
     *
     * @param string $key
     * @param $value
     * @return bool
     */
    public function set(string $key, $value): void
    {
        if ($this->hasDelimiter($key)) {
            $keys = explode(".", $key);

            $config = &$this->configs;

            foreach ($keys as $index => $_key) {
                if ($index == (count($keys) - 1)) {
                    $config[$_key] = $value;
                    return;
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
    }

    /**
     * Get specific configuration
     *
     * @param $key
     * @return mixed|void
     */
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
                    return;
                }
            } else {
                return $array;
            }
        }

        return $array;
    }

    /**
     * Check if nested key
     *
     * @param $key
     * @return bool
     */
    protected function hasDelimiter($key)
    {
        return strpos($key, ".") !== false;
    }
}