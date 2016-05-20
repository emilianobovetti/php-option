<?php

use EmilianoBovetti\PhpOption\Option;
use EmilianoBovetti\PhpOption\Some;

class TestMagicCall extends BaseTest
{
    public function testMagicCallOnSome()
    {
        $this->assertSame(0, $this->some->undefined->property(0));
    }

    public function testMagicCallOnNone()
    {
        $this->assertSame(0, $this->none->undefined->property(0));
    }

    public function testMagicCallOnObjectWithProperty()
    {
        $object = new stdClass;
        $object->defined = new stdClass;
        $object->defined->property = 0;

        $this->assertSame(0, Option::create($object)->defined->property(1));
    }

    public function testMagicCallOnArrayWithKey()
    {
        $array = [ 'defined' => [ 'key' => 0 ] ];

        $this->assertSame(0, Option::create($array)->defined->key(1));
    }

    public function testMagicCallOnObjectWithoutProperty()
    {
        $object = new stdClass;
        $object->defined = new stdClass;
        $object->defined->property = 0;

        $this->assertSame(0, Option::create($object)->undefined->property(0));
    }

    public function testMagicCallOnArrayWithoutKey()
    {
        $array = [ 'defined' => [ 'key' => 0 ] ];

        $this->assertSame(0, Option::create($array)->undefined->key(0));
    }

    public function testMagicCallWithNull()
    {
        $this->assertSame(null, $this->some->undefined->property(null));
    }

    public function testMagicCallWithManyNull()
    {
        $this->assertSame(null, $this->some->undefined->property(null, null));
    }

    public function testMagicCallWithNullAndValue()
    {
        $this->assertSame(0, $this->some->undefined->property(null, 0));
    }

    /**
     * @expectedException EmilianoBovetti\PhpOption\NoneValueException
     */
    public function testMagicCallOnNoneWithoutParameters()
    {
        $this->assertSame(0, $this->none->undefined->property());
    }

    /**
     * @expectedException EmilianoBovetti\PhpOption\NoneValueException
     */
    public function testMagicCallOnSomeWithoutParameters()
    {
        $this->assertSame(0, $this->some->undefined->property());
    }
}
