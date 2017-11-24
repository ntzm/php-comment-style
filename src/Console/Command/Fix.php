<?php

declare(strict_types=1);

namespace Ntzm\PhpCommentStyle\Console\Command;

use Ntzm\PhpCommentStyle\Comment\Comment;
use Ntzm\PhpCommentStyle\Comment\CommentClassifier;
use Ntzm\PhpCommentStyle\Comment\CommentFixer;
use Ntzm\PhpCommentStyle\Tokenizer\Tokens;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

final class Fix extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('fix')
            ->addArgument('path', InputArgument::IS_ARRAY | InputArgument::REQUIRED)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $classifier = new CommentClassifier();
        $fixer = new CommentFixer();

        $files = (new Finder())
            ->files()
            ->in($input->getArgument('path'))
            ->name('*.php')
        ;

        foreach ($files as $file) {
            $original = $file->getContents();
            $contents = $original;
            $tokens = new Tokens(\token_get_all($contents));

            foreach ($tokens as $index => $token) {
                if ($token[0] !== T_COMMENT) {
                    continue;
                }

                $old = new Comment($token[1], $classifier->classify($token[1]));
                $new = $fixer->fix($old);

                if ($old->getContent() === $new->getContent()) {
                    continue;
                }

                $tokens->replace($index, $new->getContent());
            }

            $code = $tokens->toCode();

            if ($original === $code) {
                continue;
            }

            \file_put_contents($file->getPathname(), $code);
        }
    }
}
