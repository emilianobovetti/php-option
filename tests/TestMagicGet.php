<?php

use EmilianoBovetti\PhpOption\Option;
use EmilianoBovetti\PhpOption\Some;

class TestMagicGet extends BaseTest
{
    public function testMagicGetOnSome()
    {
        $this->assertSame($this->none, $this->some->undefined->property);
    }

    public function testMagicGetOnNone()
    {
        $this->assertSame($this->none, $this->none->undefined->property);
    }

    public function testMagicGetOnObjectWithProperty()
    {
        $object = new stdClass;
        $object->defined = new stdClass;
        $object->defined->property = 0;

        $this->assertSame(0, Option::create($object)->defined->property->get());
    }

    public function testMagicGetOnArrayWithKey()
    {
        $array = [ 'defined' => [ 'key' => 0 ] ];

        $this->assertSame(0, Option::create($array)->defined->key->get());
    }

    public function testMagicGetOnObjectWithoutProperty()
    {
        $object = new stdClass;
        $object->defined = new stdClass;
        $object->defined->property = 0;

        $this->assertSame($this->none, Option::create($object)->undefined->property);
    }

    public function testMagicGetOnArrayWithoutKey()
    {
        $array = [ 'defined' => [ 'key' => 0 ] ];

        $this->assertSame($this->none, Option::create($array)->undefined->key);
    }
}
