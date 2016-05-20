<?php

use EmilianoBovetti\PhpOption\Option;
use EmilianoBovetti\PhpOption\Some;

class TestOrElse extends BaseTest
{
    public function testOrElseOnSome()
    {
        $this->assertSame($this->some, $this->some->orElse(0));
    }

    public function testOrElseOnNone()
    {
        $this->assertSame(0, $this->none->orElse(0)->get());
    }

    public function testOrElseOnSomeWithCallback()
    {
        $option = Option::create(0)->orElse(function () {
            throw new RuntimeException('orElse on some');
        });

        $this->assertSame(0, $option->get());
    }

    public function testOrElseOnNoneWithCallback()
    {
        $option = $this->none->orElse(function () {
            return 0;
        });

        $this->assertSame(0, $option->get());
    }
}
