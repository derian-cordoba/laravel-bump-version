<?php

namespace BumpVersion\Enums;

enum BumpType: string
{
    case MAJOR = 'major';
    case MINOR = 'minor';
    case PATCH = 'patch';

    /**
     * Get the segment index for the bump type.
     *
     * @return int The segment index (0 for major, 1 for minor, 2 for patch).
     */
    public function segment(): int
    {
        return match ($this) {
            self::MAJOR => 0,
            self::MINOR => 1,
            self::PATCH => 2,
        };
    }
}
