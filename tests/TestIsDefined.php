<?php

use EmilianoBovetti\PhpOption\Option;
use EmilianoBovetti\PhpOption\Some;

class TestIsDefined extends BaseTest
{
    public function testIsDefinedOnSome()
    {
        $this->assertTrue($this->some->isDefined());
    }

    public function testIsDefinedOnNone()
    {
        $this->assertFalse($this->none->isDefined());
    }
}
