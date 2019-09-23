<?php

use EmilianoBovetti\PhpOption\Option;
use EmilianoBovetti\PhpOption\Some;

class TestGet extends BaseTest
{
    public function testGetOnNone()
    {
        $this->expectException(EmilianoBovetti\PhpOption\NoneValueException::class);
        $this->none->get();
    }

    public function testGetOnSome()
    {
        $this->assertSame(0, Option::create(0)->get());
    }
}
