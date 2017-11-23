<?php

declare(strict_types=1);

use Ntzm\PhpCommentStyle\Comment;
use PHPUnit\Framework\TestCase;

final class CommentTest extends TestCase
{
    public function testGetContent(): void
    {
        $comment = new Comment('// foo', Comment::TYPE_SINGLE_LINE);

        $this->assertSame('// foo', $comment->getContent());
    }

    public function testGetType(): void
    {
        $comment = new Comment('// foo', Comment::TYPE_SINGLE_LINE);

        $this->assertSame(Comment::TYPE_SINGLE_LINE, $comment->getType());

        $comment = new Comment('/* foo */', Comment::TYPE_MULTI_LINE);

        $this->assertSame(Comment::TYPE_MULTI_LINE, $comment->getType());
    }

    public function testIsType(): void
    {
        $comment = new Comment('// foo', Comment::TYPE_SINGLE_LINE);

        $this->assertTrue($comment->isType(Comment::TYPE_SINGLE_LINE));
        $this->assertFalse($comment->isType(Comment::TYPE_MULTI_LINE));

        $comment = new Comment('/* foo */', Comment::TYPE_MULTI_LINE);

        $this->assertTrue($comment->isType(Comment::TYPE_MULTI_LINE));
        $this->assertFalse($comment->isType(Comment::TYPE_SINGLE_LINE));
    }

    public function testIsTypeInvalid()
    {
        $comment = new Comment('// foo', Comment::TYPE_SINGLE_LINE);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid type');

        $comment->isType(100);
    }

    public function testNewInvalidType()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid type');

        new Comment('// foo', 100);
    }
}
