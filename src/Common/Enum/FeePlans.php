<?php

namespace PlisioPhpSdk\Common\Enum;

class FeePlans
{
    public const NORMAL = 'normal';
    public const PRIORITY = 'priority';

    public static function asArray(): array
    {
        return [
            self::NORMAL,
            self::PRIORITY
        ];
    }
}
