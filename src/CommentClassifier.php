<?php

declare(strict_types=1);

namespace Ntzm\PhpCommentStyle;

final class CommentClassifier
{
    public function classify(string $comment): int
    {
        if ($this->startsWith($comment, '//')) {
            return Comment::TYPE_SINGLE_LINE;
        }

        if (
            $comment !== '/*/' &&
            $this->startsWith($comment, '/*') &&
            $this->endsWith($comment, '*/')
        ) {
            return Comment::TYPE_MULTI_LINE;
        }

        throw new InvalidCommentException("Comment [$comment] is not a valid comment");
    }

    private function startsWith(string $haystack, string $needle): bool
    {
        return \strpos($haystack, $needle) === 0;
    }

    private function endsWith(string $haystack, string $needle): bool
    {
        return \substr_compare($haystack, $needle, -\strlen($needle)) === 0;
    }
}
