<?php

namespace Database\Factories;

class NameProvider
{
    protected static $names = [
        'Yuki', 'Kenta', 'Momo', 'Yuta', 'Hana',
        'Sakura', 'Ren', 'Aoi', 'Tsubasa', 'Haruka',
        'Riku', 'Sora', 'Hikari', 'Natsu', 'Kai'
    ];

    public static function getName($index)
    {
        $index = $index % count(self::$names);
        return self::$names[$index];
    }
}
