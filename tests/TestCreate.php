<?php

use EmilianoBovetti\PhpOption\Option;
use EmilianoBovetti\PhpOption\Some;

class TestCreate extends BaseTest
{
    public function testCreateFromNone()
    {
        $this->assertSame($this->none, Option::create($this->none));
    }

    public function testCreateFromSome()
    {
        $this->assertSame($this->some, Option::create($this->some));
    }

    public function testCreateNone()
    {
        $this->assertSame($this->none, Option::create(null));
    }

    public function testCreateNoneWithCustomEmptyValue()
    {
        $this->assertSame($this->none, Option::create(0, 0));
    }

    public function testCreateNoneWithCustomEmptyCallback()
    {
        $option = Option::create(0, function ($value) {
            return $value === 0;
        });

        $this->assertSame($this->none, $option);
    }

    public function testCreateSome()
    {
        $this->assertSame(0, Option::create(0)->get());
    }

    public function testCreateSomeWithCustomEmptyValue()
    {
        $this->assertSame(null, Option::create(null, 0)->get());
    }

    public function testCreateSomeWithCustomEmptyCallback()
    {
        $option = Option::create(null, function ($value) {
            return $value === 0;
        });

        $this->assertSame(null, $option->get());
    }

    public function testCreateSomeFromCallback()
    {
        $option = Option::create(function () {
            return 0;
        });

        $this->assertSame(0, $option->get());
    }

    public function testCreateNoneFromCallback()
    {
        $option = Option::create(function () {
            return null;
        });

        $this->assertSame($this->none, $option);
    }

    public function testCreateSomeFromCallbackWithCustomEmptyValue()
    {
        $option = Option::create(function () {
            return null;
        }, 0);

        $this->assertSame(null, $option->get());
    }

    public function testCreateNoneFromCallbackWithCustomEmptyValue()
    {
        $option = Option::create(function () {
            return 0;
        }, 0);

        $this->assertSame($this->none, $option);
    }

    public function testCreateSomeFromCallbackWithCustomEmptyCallback()
    {
        $option = Option::create(function () {
            return null;
        }, function ($value) {
            return $value === 0;
        });

        $this->assertSame(null, $option->get());
    }

    public function testCreateNoneFromCallbackWithCustomEmptyCallback()
    {
        $option = Option::create(function () {
            return 0;
        }, function ($value) {
            return $value === 0;
        });

        $this->assertSame($this->none, $option);
    }
}
