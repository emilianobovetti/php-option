<?php

use EmilianoBovetti\PhpOption\Option;
use EmilianoBovetti\PhpOption\Some;

class TestGetOrElse extends BaseTest
{
    public function testGetOrElseOnSome()
    {
        $this->assertSame(0, Option::create(0)->getOrElse(1));
    }

    public function testGetOrElseOnNone()
    {
        $this->assertSame(0, $this->none->getOrElse(0));
    }

    public function testGetOrElseOnSomeWithCallback()
    {
        $this->assertSame(0, Option::create(0)->getOrElse(function () {
            throw new RuntimeException('getOrElse on some');
        }));
    }

    public function testGetOrElseOnNoneWithCallback()
    {
        $this->assertSame(0, $this->none->getOrElse(function () {
            return 0;
        }));
    }
}
