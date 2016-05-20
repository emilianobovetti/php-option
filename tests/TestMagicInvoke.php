<?php

use EmilianoBovetti\PhpOption\Option;
use EmilianoBovetti\PhpOption\Some;

class TestMagicInvoke extends BaseTest
{
    public function testMagicInvokeOnNone()
    {
        $option = $this->none;

        $this->assertSame(null, $option(null));
    }

    public function testMagicInvokeOnSome()
    {
        $option = Option::create(0);

        $this->assertSame(0, $option(1));
    }

    /**
     * @expectedException EmilianoBovetti\PhpOption\NoneValueException
     */
    public function testMagicInvokeOnNoneWithoutParameter()
    {
        $option = $this->none;
        $option();
    }

    public function testMagicInvokeOnSomeWithoutParameter()
    {
        $option = Option::create(0);

        $this->assertSame(0, $option());
    }
}
