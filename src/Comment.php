<?php

declare(strict_types=1);

namespace Ntzm\PhpCommentStyle;

final class Comment
{
    public const TYPE_SINGLE_LINE = 1;
    public const TYPE_MULTI_LINE = 2;

    private $content;
    private $type;

    public function __construct(string $content, int $type)
    {
        $this->content = $content;
        $this->type = $type;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function isType(int $type): bool
    {
        return $this->type === $type;
    }
}
