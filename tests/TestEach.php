<?php

use EmilianoBovetti\PhpOption\Option;
use EmilianoBovetti\PhpOption\Some;

class TestEach extends BaseTest
{
    public function testEachOnNone()
    {
        $option = $this->none->each(function ($value) {
            throw new RuntimeException('each on none');
        });

        $this->assertSame($this->none, $option);
    }

    public function testEachOnSome()
    {
        $option = Option::create(0)->each(function ($value) {
            $this->assertSame(0, $value);
        });
    }
}
