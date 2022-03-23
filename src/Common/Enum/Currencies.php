<?php

namespace PlisioPhpSdk\Common\Enum;

class Currencies
{
    public const TBTC = 'TBTC';
    public const ETH = 'ETH';
    public const BTC = 'BTC';
    public const LTC = 'LTC';
    public const DASH = 'DASH';
    public const TZEC = 'TZEC';
    public const DOGE = 'DOGE';
    public const BCH = 'BCH';
    public const XMR = 'XMR';
    public const USDT = 'USDT';

    public static function asArray(): array
    {
        return [
            self::ETH,
            self::BTC,
            self::LTC,
            self::DASH,
            self::TZEC,
            self::DOGE,
            self::BCH,
            self::XMR,
            self::USDT,
            self::TBTC
        ];
    }
}
