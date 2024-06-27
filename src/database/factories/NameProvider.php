<?php

namespace Database\Factories;

class NameProvider
{
    protected static $names = [
        'Yuki', 'Kenta', 'Momo', 'Yuta', 'Hana',
        'Sakura', 'Ren', 'Aoi', 'Tsubasa', 'Haruka'
    ];

    public static function getName($index)
    {
        return self::$names[$index];
    }
}
