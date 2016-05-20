<?php

use EmilianoBovetti\PhpOption\Option;
use EmilianoBovetti\PhpOption\Some;

class TestMagicToString extends BaseTest
{
    public function testMagicToStringOnSome()
    {
        $this->assertSame('0', (string) Option::create(0));
    }

    public function testMagicToStringOnNone()
    {
        $this->assertSame('', (string) $this->none);
    }
}
