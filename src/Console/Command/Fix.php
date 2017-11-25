<?php

declare(strict_types=1);

namespace Ntzm\PhpCommentStyle\Console\Command;

use Ntzm\PhpCommentStyle\Comment\CommentClassifier;
use Ntzm\PhpCommentStyle\Comment\CommentFixer;
use Ntzm\PhpCommentStyle\Runner;
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
        $runner = new Runner(
            new CommentClassifier(),
            new CommentFixer()
        );

        $files = (new Finder())
            ->files()
            ->in($input->getArgument('path'))
            ->name('*.php')
        ;

        $fixedFiles = $runner->fix($files);

        foreach ($fixedFiles as $file) {
            $output->writeln("Fixed comments in {$file->getRelativePathname()}");
        }
    }
}
