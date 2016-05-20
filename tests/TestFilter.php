<?php

use EmilianoBovetti\PhpOption\Option;
use EmilianoBovetti\PhpOption\Some;

class TestFilter extends BaseTest
{
    protected $falseFilter;

    protected $trueFilter;

    public function __construct()
    {
        parent::__construct();

        $this->falseFilter = function ($value) {
            return false;
        };

        $this->trueFilter = function ($value) {
            return true;
        };
    }

    public function testFalseFilterOnNone()
    {
        $this->assertSame($this->none, $this->none->filter($this->falseFilter));
    }

    public function testFalseFilterOnSome()
    {
        $this->assertSame($this->none, $this->some->filter($this->falseFilter));
    }

    public function testTrueFilterOnNone()
    {
        $this->assertSame($this->none, $this->none->filter($this->trueFilter));
    }

    public function testTrueFilterOnSome()
    {
        $this->assertSame($this->some, $this->some->filter($this->trueFilter));
    }
}
