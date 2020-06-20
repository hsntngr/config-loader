<?php

if (!function_exists("config")) {
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