<?php

declare(strict_types=1);

namespace Ntzm\PhpCommentStyle\Tokenizer;

use ArrayIterator;
use IteratorAggregate;

final class Tokens implements IteratorAggregate
{
    private $tokens;
    private $hasChanged = false;

    public function __construct(array $tokens)
    {
        $this->tokens = $tokens;
    }

    public function replace(int $index, $token): void
    {
        $this->hasChanged = true;
        $this->tokens[$index] = $token;
    }

    public function getComments(): array
    {
        return \array_filter($this->tokens, function ($token) {
            return $token[0] === T_COMMENT;
        });
    }

    public function toCode(): string
    {
        return \array_reduce($this->tokens, function (string $carry, $token) {
            return $carry.(\is_array($token) ? $token[1] : $token);
        }, '');
    }

    public function hasChanged(): bool
    {
        return $this->hasChanged;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->tokens);
    }
}
