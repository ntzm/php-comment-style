<?php

declare(strict_types=1);

namespace Ntzm\Tests\PhpCommentStyle\Comment;

use Ntzm\PhpCommentStyle\Comment\Comment;
use Ntzm\PhpCommentStyle\Comment\CommentClassifier;
use Ntzm\PhpCommentStyle\Comment\CommentFixer;
use PHPUnit\Framework\TestCase;

final class CommentFixerTest extends TestCase
{
    /**
     * @param string $expected
     * @param string $input
     * @dataProvider provideFixCases
     */
    public function testFix(string $expected, string $input = null): void
    {
        $this->assertSame(
            $expected,
            (new CommentFixer())->fix($this->makeComment($input ?? $expected))->getContent()
        );
    }

    public function provideFixCases(): array
    {
        return [
            [
                '//',
            ],
            [
                "//\n",
            ],
            [
                '// foo bar',
                '//foo bar',
            ],
            [
                "// foo bar\n",
                "//foo bar\n",
            ],
            [
                '// foo bar',
            ],
            [
                "// foo bar\n",
            ],
            [
                '/* */',
            ],
            [
                '/**/',
            ],
            [
                '/* foo bar */',
                '/*foo bar*/',
            ],
            [
                '/* foo bar */',
                '/*foo bar */',
            ],
            [
                '/* foo bar */',
                '/* foo bar*/',
            ],
            [
                "/*\nfoo\n*/",
            ],
            [
                "/*\nfoo */",
                "/*\nfoo*/",
            ],
            [
                "/* foo\n*/",
                "/*foo\n*/",
            ],
            [
                '// 🍆🍆🍆',
            ],
            [
                '/* 🍆🍆🍆 */',
            ],
            [
                '// 🍆🍆🍆',
                '//🍆🍆🍆',
            ],
            [
                '/* 🍆🍆🍆 */',
                '/*🍆🍆🍆*/',
            ],
        ];
    }

    private function makeComment(string $content): Comment
    {
        return new Comment($content, (new CommentClassifier())->classify($content));
    }
}
