<?php

declare(strict_types=1);

namespace Ntzm\Tests\PhpCommentStyle;

use Ntzm\PhpCommentStyle\Util;
use PHPUnit\Framework\TestCase;

final class UtilTest extends TestCase
{
    /**
     * @param bool   $result
     * @param string $haystack
     * @param string $needle
     * @dataProvider provideStartsWithCases
     */
    public function testStartsWith(bool $result, string $haystack, string $needle): void
    {
        $this->assertSame($result, Util::startsWith($haystack, $needle));
    }

    public function provideStartsWithCases(): array
    {
        return [
            [true, 'foo', 'foo'],
            [true, 'foobar', 'foo'],
            [true, ' foo', ' '],
            [true, ' foo', ' f'],
            [false, 'foo', 'bar'],
            [false, 'foo', ''],
        ];
    }

    /**
     * @param bool   $result
     * @param string $haystack
     * @param string $needle
     * @dataProvider provideEndsWithCases
     */
    public function testEndsWith(bool $result, string $haystack, string $needle): void
    {
        $this->assertSame($result, Util::endsWith($haystack, $needle));
    }

    public function provideEndsWithCases(): array
    {
        return [
            [true, 'foo', 'foo'],
            [true, 'foobar', 'bar'],
            [true, 'foo ', ' '],
            [true, 'foo ', 'o '],
            [false, 'foo', 'bar'],
            [false, 'foo', ''],
        ];
    }
}
