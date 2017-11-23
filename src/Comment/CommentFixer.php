<?php

declare(strict_types=1);

namespace Ntzm\PhpCommentStyle\Comment;

final class CommentFixer
{
    public function fix(Comment $comment): Comment
    {
        if ($comment->isType(Comment::TYPE_SINGLE_LINE)) {
            return new Comment(
                $this->fixSingleLine($comment->getContent()),
                $comment->getType()
            );
        }

        if ($comment->isType(Comment::TYPE_MULTI_LINE)) {
            return new Comment(
                $this->fixMultiLine($comment->getContent()),
                $comment->getType()
            );
        }
    }

    private function fixSingleLine(string $comment): string
    {
        // Single line comments can end in newlines
        if (\rtrim($comment) === '//') {
            return $comment;
        }

        if (\ctype_space($comment[2])) {
            return $comment;
        }

        return $this->insertSpaceAt($comment, 2);
    }

    private function fixMultiLine(string $comment): string
    {
        if ($comment === '/**/') {
            return $comment;
        }

        if (!\ctype_space($comment[2])) {
            $comment = $this->insertSpaceAt($comment, 2);
        }

        if (!\ctype_space($comment[-3])) {
            $comment = $this->insertSpaceAt($comment, -2);
        }

        return $comment;
    }

    private function insertSpaceAt(string $comment, int $index): string
    {
        return \substr_replace($comment, ' ', $index, 0);
    }
}
