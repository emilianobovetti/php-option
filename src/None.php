<?php

namespace EmilianoBovetti\PhpOption;

use Closure;
use Exception;

class None extends Option
{
    public function filter(Closure $function)
    {
        return $this;
    }

    public function map(Closure $function)
    {
        return $this;
    }

    public function each(Closure $function)
    {
        return $this;
    }

    public function get()
    {
        throw new NoneValueException('Trying to get value of None');
    }

    public function getOrElse($default)
    {
        return ( ! $default instanceof Option) && is_callable($default) ? $default() : $default;
    }

    public function getOrThrow(Exception $e)
    {
        throw $e;
    }

    public function getOrCall(Closure $function)
    {
        return $function();
    }

    public function orElse($default)
    {
        return Option::create($this->getOrElse($default));
    }

    public function isDefined()
    {
        return false;
    }

    public function isEmpty()
    {
        return true;
    }

    public function __toString()
    {
        return '';
    }

    public function __get($name)
    {
        return $this;
    }

    public function __isset($name)
    {
        return false;
    }

    public function __call($name, $arguments)
    {
        if (count($arguments) == 0) {
            throw new NoneValueException('Dynamic access to undefined property without parameters');
        }

        return self::filterMagicCallArgs($arguments);
    }

    public function __invoke($default = EmptyArg::class)
    {
        if ($default === EmptyArg::class) {
            throw new NoneValueException('None invoked without parameter');
        }

        return $this->getOrElse($default);
    }
}
