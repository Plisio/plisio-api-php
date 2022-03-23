<?php

namespace PlisioPhpSdk\Common\Enum;

class OperationType
{
    public const CASH_OUT = 'cash_out';
    public const MASS_CASH_OUT = 'mass_cash_out';

    public static function asArray(): array
    {
        return [
            self::CASH_OUT,
            self::MASS_CASH_OUT
        ];
    }
}
