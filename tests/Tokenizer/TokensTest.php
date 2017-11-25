<?php

declare(strict_types=1);

namespace Ntzm\Tests\PhpCommentStyle\Tokenizer;

use Ntzm\PhpCommentStyle\Tokenizer\Tokens;
use PHPUnit\Framework\TestCase;

final class TokensTest extends TestCase
{
    public function testHasChanged(): void
    {
        $tokens = new Tokens(\token_get_all('<?php echo 1;'));

        $this->assertFalse($tokens->hasChanged());

        $tokens->replace(1, 'print');

        $this->assertTrue($tokens->hasChanged());
    }

    public function testGetCode(): void
    {
        $tokens = new Tokens(\token_get_all('<?php echo 1;'));

        $this->assertSame('<?php echo 1;', $tokens->toCode());

        $tokens->replace(1, 'print');

        $this->assertSame('<?php print 1;', $tokens->toCode());
    }
}
