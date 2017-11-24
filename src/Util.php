<?php

declare(strict_types=1);

namespace Ntzm\PhpCommentStyle;

final class Util
{
    public static function startsWith(string $haystack, string $needle): bool
    {
        return \strpos($haystack, $needle) === 0;
    }

    public static function endsWith(string $haystack, string $needle): bool
    {
        return \substr_compare($haystack, $needle, -\strlen($needle)) === 0;
    }
}
