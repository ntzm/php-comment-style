<?php

declare(strict_types=1);

namespace Ntzm\Tests\PhpCommentStyle;

use Ntzm\PhpCommentStyle\Comment\CommentClassifier;
use Ntzm\PhpCommentStyle\Comment\CommentFixer;
use Ntzm\PhpCommentStyle\Runner;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Finder\Finder;

final class RunnerTest extends TestCase
{
    public function testFix(): void
    {
        $runner = new Runner(
            new CommentClassifier(),
            new CommentFixer()
        );

        $file = __DIR__.'/data/a.php';

        $input = <<<'EOD'
<?php
foreach ($a as $b) {
    //foo
}

/*bar*/
EOD;

        $expected = <<<'EOD'
<?php
foreach ($a as $b) {
    // foo
}

/* bar */
EOD;

        \file_put_contents($file, $input);

        $finder = (new Finder())->in(__DIR__.'/data');

        $runner->fix($finder);

        $this->assertStringEqualsFile($file, $expected);

        \unlink($file);
    }
}
