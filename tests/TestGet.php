<?php

use EmilianoBovetti\PhpOption\Option;
use EmilianoBovetti\PhpOption\Some;

class TestGet extends BaseTest
{
    /**
     * @expectedException EmilianoBovetti\PhpOption\NoneValueException
     */
    public function testGetOnNone()
    {
        $this->none->get();
    }

    public function testGetOnSome()
    {
        $this->assertSame(0, Option::create(0)->get());
    }
}
