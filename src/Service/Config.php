<?php

namespace Genesis\MicroFramework\Service;

class Config
{
    private static $config;

    public static function setFile(string $filePath)
    {
        self::$config = require $filePath;
    }

    public static function set(string $name, $config)
    {
        self::$config[$name] = $config;
    }

    public static function get(string $name, $exception = null)
    {
        if (! isset(self::$config[$name])) {
            if (!$exception) {
                $exception = "Unable to find config with name '$name'.";
            }
            throw new Exception($exception);
        }

        return self::$config[$name];
    }

    public static function getOptional(string $name, $default = null)
    {
        return self::$config[$name] ?? $default;
    }
}