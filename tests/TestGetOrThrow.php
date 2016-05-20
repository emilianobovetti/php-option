<?php

use EmilianoBovetti\PhpOption\Option;
use EmilianoBovetti\PhpOption\Some;

class TestGetOrThrow extends BaseTest
{
    public function testGetOrThrowOnSome()
    {
        $this->assertSame(0, Option::create(0)->getOrThrow(new RuntimeException));
    }

    /**
     * @expectedException RuntimeException
     */
    public function testGetOrThrowOnNone()
    {
        $this->none->getOrThrow(new RuntimeException);
    }
}
