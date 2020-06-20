<?php

if (!function_exists("config")) {
    /**
     * Get or Set Configuration
     * Retrieve Config instance
     *
     * @param string|null $key
     * @param null $value
     * @return mixed
     */
    function config(string $key = null, $value = null)
    {
        $config = \Reactor\Components\Config\Config::getInstance();

        if ($key && $value) {
            return $config->add($key, $value);
        }

        if ($key) {
            return $config->get($key);
        }

        return $config;
    }
}