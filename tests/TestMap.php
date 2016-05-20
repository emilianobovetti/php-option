<?php

use EmilianoBovetti\PhpOption\Option;
use EmilianoBovetti\PhpOption\Some;

class TestMap extends BaseTest
{
    protected $mapIdentity;

    protected $mapIdentityOption;

    public function __construct()
    {
        parent::__construct();

        $this->mapIdentity = function ($value) {
            return $value;
        };

        $this->mapIdentityOption = function ($value) {
            return Option::create($value);
        };
    }

    public function testIdentityOnNone()
    {
        $this->assertSame($this->none, $this->none->map($this->mapIdentity));
    }

    public function testIdentityOnSome()
    {
        $this->assertSame($this->some->get(), $this->some->map($this->mapIdentity)->get());
    }

    public function testIdentityOptionOnNone()
    {
        $this->assertSame($this->none, $this->none->map($this->mapIdentityOption));
    }

    public function testIdentityOptionOnSome()
    {
        $this->assertSame($this->some->get(), $this->some->map($this->mapIdentityOption)->get());
    }
}
