<?php

namespace Ntzm\PhpCommentStyle\Tokenizer;

use ArrayIterator;
use IteratorAggregate;

final class Tokens implements IteratorAggregate
{
    private $tokens;

    public function __construct(array $tokens)
    {
        $this->tokens = $tokens;
    }

    public function replace(int $index, $token): void
    {
        $this->tokens[$index] = $token;
    }

    public function toCode(): string
    {
        return array_reduce($this->tokens, function (string $carry, $token) {
            return $carry.(is_array($token) ? $token[1] : $token);
        }, '');
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->tokens);
    }
}
