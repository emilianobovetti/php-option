<?php

use EmilianoBovetti\PhpOption\Option;
use EmilianoBovetti\PhpOption\Some;
use EmilianoBovetti\PhpOption\None;

abstract class BaseTest extends PHPUnit\Framework\TestCase
{
    public function setUp(): void
    {
        $this->none = Option::none();
        $this->some = new Some(0);
    }
}
