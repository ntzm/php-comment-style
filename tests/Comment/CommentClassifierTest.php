<?php

declare(strict_types=1);

namespace Ntzm\Tests\PhpCommentStyle\Comment;

use Ntzm\PhpCommentStyle\Comment\Comment;
use Ntzm\PhpCommentStyle\Comment\CommentClassifier;
use Ntzm\PhpCommentStyle\Comment\InvalidCommentException;
use PHPUnit\Framework\TestCase;

final class CommentClassifierTest extends TestCase
{
    /**
     * @param string $input
     * @dataProvider provideClassifySingleLineCases
     */
    public function testClassifySingleLine(string $input): void
    {
        $this->assertSame(
            Comment::TYPE_SINGLE_LINE,
            (new CommentClassifier())->classify($input)
        );
    }

    public function provideClassifySingleLineCases(): array
    {
        return [
            ['//'],
            ['//foo'],
            ['// foo'],
            ['//    foo bar'],
            ['///'],
            ['/////'],
        ];
    }

    /**
     * @param string $input
     * @dataProvider provideClassifyMultiLineCases
     */
    public function testClassifyMultiLine(string $input): void
    {
        $this->assertSame(
            Comment::TYPE_MULTI_LINE,
            (new CommentClassifier())->classify($input)
        );
    }

    public function provideClassifyMultiLineCases(): array
    {
        return [
            ['/* */'],
            ['/*foo*/'],
            ['/* foo */'],
            ['/*   foo*/'],
            ['/*foo    */'],
            ['/*    */'],
            ['/*'],
            ['/*   '],
        ];
    }

    /**
     * @param string $input
     * @dataProvider provideInvalidCases
     */
    public function testInvalid(string $input): void
    {
        $this->expectException(InvalidCommentException::class);
        $this->expectExceptionMessage("Comment [$input] is not a valid comment");

        (new CommentClassifier())->classify($input);
    }

    public function provideInvalidCases(): array
    {
        return [
            ['foo'],
            [''],
            [' // foo'],
            [' /* foo bar */'],
            ['/ foo'],
            ['* foo */'],
        ];
    }
}
