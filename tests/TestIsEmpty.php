<?php

use EmilianoBovetti\PhpOption\Option;
use EmilianoBovetti\PhpOption\Some;

class TestIsEmpty extends BaseTest
{
    public function testIsEmptyOnSome()
    {
        $this->assertFalse($this->some->isEmpty());
    }

    public function testIsEmptyOnNone()
    {
        $this->assertTrue($this->none->isEmpty());
    }
}
