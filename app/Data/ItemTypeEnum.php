<?php

namespace App\Data;

final class ItemTypeEnum
{
    const BUG = 'bug';

    const EQUIPMENT = 'equipment';

    const FISH = 'fish';

    const FOSSIL = 'fossil';

    const HOUSEWARE = 'houseware';

    const MISC = 'miscellaneous';

    const OTHER = 'other';

    const TOOL = 'tool';

    // const VILLAGER = 'villager';
    const WALL_MOUNTED = 'wallMounted';

    const WALLPAPER_RUGS_FLOORING = 'wallpaperRugsFlooring';

    public static function all(): array
    {
        return [
            self::BUG,
            self::EQUIPMENT,
            self::FISH,
            self::FOSSIL,
            self::HOUSEWARE,
            self::MISC,
            self::OTHER,
            self::TOOL,
            // self::VILLAGER,
            self::WALL_MOUNTED,
            self::WALLPAPER_RUGS_FLOORING,
        ];
    }

    public static function allFilenames(): array
    {
        return [
            self::BUG => self::BUG.'s',
            self::EQUIPMENT => self::EQUIPMENT.'s',
            self::FISH => 'fish',
            self::FOSSIL => self::FOSSIL.'s',
            self::HOUSEWARE => self::HOUSEWARE.'s',
            self::MISC => 'miscellaneous',
            self::OTHER => self::OTHER.'s',
            self::TOOL => self::TOOL.'s',
            // self::VILLAGER => self::VILLAGER.'s',
            self::WALL_MOUNTED => self::WALL_MOUNTED.'s',
            self::WALLPAPER_RUGS_FLOORING => 'wallpaperRugsFloorings',
        ];
    }
}
