<?php

declare(strict_types=1);

namespace Ntzm\PhpCommentStyle\Console\Command;

use Ntzm\PhpCommentStyle\Comment;
use Ntzm\PhpCommentStyle\CommentClassifier;
use Ntzm\PhpCommentStyle\CommentFixer;
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
            $tokens = \token_get_all($contents);

            foreach ($tokens as $token) {
                if ($token[0] === T_COMMENT) {
                    $old = new Comment($token[1], $classifier->classify($token[1]));
                    $new = $fixer->fix($old);

                    if ($old->getContent() === $new->getContent()) {
                        continue;
                    }

                    $pos = \strpos($contents, $old->getContent());
                    $contents = \substr_replace($contents, $new->getContent(), $pos, \strlen($old->getContent()));
                }
            }

            if ($original === $contents) {
                continue;
            }

            \file_put_contents($file->getPathname(), $contents);
        }
    }
}
