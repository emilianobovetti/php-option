<?php

use EmilianoBovetti\PhpOption\Option;
use EmilianoBovetti\PhpOption\Some;
use EmilianoBovetti\PhpOption\None;

abstract class BaseTest extends PHPUnit_Framework_TestCase
{
    protected $none;

    protected $some;

    public function __construct()
    {
        $this->none = Option::none();
        $this->some = new Some(0);
    }
}
