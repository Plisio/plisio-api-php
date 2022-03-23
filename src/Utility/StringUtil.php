<?php

namespace PlisioPhpSdk\Utility;

class StringUtil
{
    public static function snakeToCamel(string $snakeString): string
    {
        $camel = implode('', array_map(static function ($piece) {
            return empty($piece) ? '_' : ucfirst(strtolower($piece));
        }, explode('_', $snakeString)));

        return lcfirst($camel);
    }

    public static function camelToSnake(string $camelString): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $camelString));
    }

    public static function getClassShortName(string $class): string
    {
        return basename(str_replace('\\', '/', $class));
    }
}
