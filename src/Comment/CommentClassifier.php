<?php

declare(strict_types=1);

namespace Ntzm\PhpCommentStyle\Comment;

use Ntzm\PhpCommentStyle\Util;

final class CommentClassifier
{
    public function classify(string $comment): int
    {
        if (Util::startsWith($comment, '//')) {
            return Comment::TYPE_SINGLE_LINE;
        }

        if (Util::startsWith($comment, '/*')) {
            return Comment::TYPE_MULTI_LINE;
        }

        throw new InvalidCommentException(
            "Comment [$comment] is not a valid comment"
        );
    }
}
