<?php

use EmilianoBovetti\PhpOption\Option;
use EmilianoBovetti\PhpOption\Some;

class TestGetOrCall extends BaseTest
{
    public function testTestGetOrCallOnSome()
    {
        $value = Option::create(0)->getOrCall(function () {
            return 1;
        });

        $this->assertSame(0, $value);
    }

    public function testTestGetOrCallOnNone()
    {
        $value = $this->none->getOrCall(function () {
            return 0;
        });

        $this->assertSame(0, $value);
    }
}
