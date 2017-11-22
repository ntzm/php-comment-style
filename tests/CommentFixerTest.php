<?php

use Ntzm\PhpCommentStyle\CommentClassifier;
use Ntzm\PhpCommentStyle\CommentFactory;
use Ntzm\PhpCommentStyle\CommentFixer;
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
            (new CommentFixer())->fix((new CommentFactory(new CommentClassifier()))->make($input ?? $expected))->getContent()
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
}
