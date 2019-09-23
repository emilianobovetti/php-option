<?php

use EmilianoBovetti\PhpOption\Option;
use EmilianoBovetti\PhpOption\Some;

class TestGetOrThrow extends BaseTest
{
    public function testGetOrThrowOnSome()
    {
        $this->assertSame(0, Option::create(0)->getOrThrow(new RuntimeException));
    }

    public function testGetOrThrowOnNone()
    {
        $this->expectException(RuntimeException::class);
        $this->none->getOrThrow(new RuntimeException);
    }
}
