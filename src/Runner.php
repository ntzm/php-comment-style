<?php

declare(strict_types=1);

namespace Ntzm\PhpCommentStyle;

use Ntzm\PhpCommentStyle\Comment\Comment;
use Ntzm\PhpCommentStyle\Comment\CommentClassifier;
use Ntzm\PhpCommentStyle\Comment\CommentFixer;
use Ntzm\PhpCommentStyle\Tokenizer\Tokens;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

final class Runner
{
    private $classifier;
    private $fixer;

    public function __construct(CommentClassifier $classifier, CommentFixer $fixer)
    {
        $this->classifier = $classifier;
        $this->fixer = $fixer;
    }

    public function fix(Finder $files): array
    {
        $fixedFiles = [];

        foreach ($files as $file) {
            if ($this->fixFile($file)) {
                $fixedFiles[] = $file;
            }
        }

        return $fixedFiles;
    }

    private function fixFile(SplFileInfo $file): bool
    {
        $tokens = new Tokens(\token_get_all($file->getContents()));

        foreach ($tokens as $index => $token) {
            if ($token[0] !== T_COMMENT) {
                continue;
            }

            $old = new Comment($token[1], $this->classifier->classify($token[1]));
            $new = $this->fixer->fix($old);

            if ($old->getContent() === $new->getContent()) {
                continue;
            }

            $tokens->replace($index, $new->getContent());
        }

        if (!$tokens->hasChanged()) {
            return false;
        }

        \file_put_contents($file->getPathname(), $tokens->toCode());

        return true;
    }
}
