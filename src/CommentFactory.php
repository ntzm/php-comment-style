<?php

declare(strict_types=1);

namespace Ntzm\PhpCommentStyle;

final class CommentFactory
{
    private $classifier;

    public function __construct(CommentClassifier $classifier)
    {
        $this->classifier = $classifier;
    }

    public function make(string $content): Comment
    {
        return new Comment($content, $this->classifier->classify($content));
    }
}
