<?php

use EmilianoBovetti\PhpOption\Option;
use EmilianoBovetti\PhpOption\Some;

class TestMagicIsset extends BaseTest
{
    public function testMagicIssetOnSome()
    {
        $this->assertFalse(isset($this->some->undefined->property));
    }

    public function testMagicIssetOnNone()
    {
        $this->assertFalse(isset($this->none->undefined->property));
    }

    public function testMagicIssetOnObjectWithProperty()
    {
        $object = new stdClass;
        $object->defined = new stdClass;
        $object->defined->property = 0;

        $this->assertTrue(isset(Option::create($object)->defined->property));
    }

    public function testMagicIssetOnArrayWithKey()
    {
        $array = [ 'defined' => [ 'key' => 0 ] ];

        $this->assertTrue(isset(Option::create($array)->defined->key));
    }

    public function testMagicIssetOnObjectWithoutProperty()
    {
        $object = new stdClass;
        $object->defined = new stdClass;
        $object->defined->property = 0;

        $this->assertFalse(isset(Option::create($object)->undefined->property));
    }

    public function testMagicIssetOnArrayWithoutKey()
    {
        $array = [ 'defined' => [ 'key' => 0 ] ];

        $this->assertFalse(isset(Option::create($array)->undefined->key));
    }
}
