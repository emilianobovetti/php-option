<?php

namespace EmilianoBovetti\PhpOption;

use Closure;
use Exception;

class Some extends Option
{
    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function filter(Closure $function)
    {
        return $function($this->value) ? $this : Option::$none;
    }

    public function map(Closure $function)
    {
        return Option::create($function($this->value));
    }

    public function each(Closure $function)
    {
        $function($this->value);

        return $this;
    }

    public function get()
    {
        return $this->value;
    }

    public function getOrElse($default)
    {
        return $this->value;
    }

    public function getOrThrow(Exception $e)
    {
        return $this->value;
    }

    public function getOrCall(Closure $function)
    {
        return $this->value;
    }

    public function orElse($default)
    {
        return $this;
    }

    public function isDefined()
    {
        return true;
    }

    public function isEmpty()
    {
        return false;
    }

    public function __toString()
    {
        return (string) $this->value;
    }

    private function getPropertyOrKey($name)
    {
        $value = null;

        if (is_array($this->value) && isset($this->value[$name])) {
            $value =  $this->value[$name];
        } else if (is_object($this->value) && isset($this->value->{$name})) {
            $value =  $this->value->{$name};
        }

        return $value;
    }

    public function __get($name)
    {
        return Option::create($this->getPropertyOrKey($name));
    }

    public function __isset($name)
    {
        return $this->getPropertyOrKey($name) !== null;
    }

    public function __call($name, $arguments)
    {
        $value = $this->getPropertyOrKey($name);

        if ($value === null && count($arguments) == 0) {
            throw new NoneValueException('Dynamic access to undefined property without parameters');
        }

        return $value === null ? self::filterMagicCallArgs($arguments) : $value;
    }

    public function __invoke($default = EmptyArg::class)
    {
        return $this->value;
    }
}
