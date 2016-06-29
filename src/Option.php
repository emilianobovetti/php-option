<?php

namespace EmilianoBovetti\PhpOption;

use Closure;
use Exception;

abstract class Option
{
    /**
     * A None instance.
     *
     * @var None
     */
    protected static $none;

    /**
     * Initialize Option class.
     * Called after class declaration.
     *
     * @return void
     */
    public static function init()
    {
        self::$none = new None;
    }

    /**
     * Get a None instance.
     * Since None class is stateless, it's useless
     * create different instances.
     *
     * @return None
     */
    public static function none()
    {
        return self::$none;
    }

    /**
     * Get a Some instance.
     *
     * @return Some
     */
    public static function some($value)
    {
        return new Some($value);
    }

    /**
     * Create new Option object.
     *
     * By default it creates a None if $value is null,
     * Some($value) otherwise.
     *
     *  $value can be:
     * 1. another Option
     * 2. a callback
     * 3. any other PHP value
     *
     *  $empty parameter is used to determine if $value
     * is empty or not and it can be:
     * 1. a callback - which is called with $value
     *  as parameter: if it returns a falsy value a None is created
     * 2. any other PHP value - which is strictly compared to $value:
     *  if they are equals a None is created.
     *
     * @param mixed $value
     * @param mixed $empty Optional.
     * @return Option
     */
    public static function create($value, $empty = null)
    {
        // Option is a callable class!
        $value = ( ! $value instanceof self) && is_callable($value) ? $value() : $value;

        if (is_callable($empty)) {
            $option = $empty($value) ? self::$none : new Some($value);
        } else if ($value === $empty) {
            $option = self::$none;
        } else if ($value instanceof self) {
            $option = $value;
        } else {
            $option = new Some($value);
        }

        return $option;
    }

    /**
     * If the Option is a Some and the given $function returns
     * false on its value, return None.
     * Return Option itself otherwise.
     *
     * @param Closure $function
     * @return Option
     */
    abstract public function filter(Closure $function);

    /**
     * If the Option is a Some return another Option wrapping
     * the result of $function applied to Option's value.
     * Return a None otherwise.
     *
     * @param Closure $function
     * @return Option
     */
    abstract public function map(Closure $function);

    /**
     * Apply given $function to the Option's value if
     * is non-empty, does nothing otherwise.
     * Return Option itself.
     *
     * @param Closure $function
     * @return Option
     */
    abstract public function each(Closure $function);

    /**
     * Get the value of the Option.
     *
     * @throws NoneValueException If the Option is a None.
     * @return mixed
     */
    abstract public function get();

    /**
     * If the Option is a Some return its value,
     * return $default otherwise.
     *
     *  $default can be:
     * 1. a callback - which is called and its result
     *  returned if the Option is a None.
     * 2. any other PHP value - which is returned
     *  in case the Option is a None.
     *
     * @param mixed $default
     * @return mixed
     */
    abstract public function getOrElse($default);

    /**
     * Get the value of the Option.
     *
     * @throws Exception $e If the Option is a None.
     * @param Exception $e
     * @return mixed
     */
    abstract public function getOrThrow(Exception $e);

    /**
     * If the Option is a Some return its value,
     * return the value that yields $function otherwise.
     *
     * @param Closure $function
     * @return mixed
     */
    abstract public function getOrCall(Closure $function);

    /**
     * If the Option is a Some return the Option itself,
     * return an Option wrapping $default otherwise.
     *
     *  $default can be:
     * 1. a callback - which is called and a new Option
     *  wrapping its result is returned if the Option is a None.
     * 2. any other PHP value - which is wrapped in
     *  a new Option and returned in case the Option is a None.
     *
     * @param mixed $default
     * @return mixed
     */
    abstract public function orElse($default);

    /**
     * True if the Option *is not* a None.
     *
     * @return bool
     */
    abstract public function isDefined();

    /**
     * True if the Option *is* a None.
     *
     * @return bool
     */
    abstract public function isEmpty();

    /**
     * toString magic method.
     *
     * Return the Option's value casted to string
     * or the empty string if the Option is a None.
     *
     * @return string
     */
    abstract public function __toString();

    /**
     * get magic method.
     *
     * If the Option is a Some which contains an
     * array or an object, it looks for the given
     * key or property. If it exists and is not null
     * return an Option wrapping this value.
     * In any other case return a None.
     *
     * E.g.
     *
     * <code>
     *  $array = [ 'defined' => [ 'key' => 0 ] ];
     *  $option = Option::create($array);
     *  $option->defined->key->get(); // 0
     *
     *  Option::create(null)->undefined->key; // None
     * </code>
     *
     * @param string $name Key or property name.
     * @return Option
     */
    abstract public function __get($name);

    /**
     * isset magic method.
     *
     * If the Option is a Some containing an array
     * or an object with the given key or property
     * and its value is not null, return true.
     * In any other case return false.
     *
     * E.g.
     *
     * <code>
     *  $array = [ 'defined' => [ 'key' => 0 ] ];
     *  isset(Option::create($array)->defined->key); // true
     *
     *  isset(Option::create(null)->undefined->key); // false
     * </code>
     *
     * @param string $name Key or property name.
     * @return bool
     */
    abstract public function __isset($name);

    /**
     * invoke magic method.
     *
     * Make the Option callable.
     * Return the Option's value if is non-empty,
     * $default otherwise.
     *
     *  $default can be:
     * 1. a callback - which is called and its result
     *  returned if the Option is a None.
     * 2. any other PHP value - which is returned
     *  in case the Option is a None.
     *
     * <code>
     *  $option = Option::create(0);
     *  $option(1); // 0
     *  $option();  // 0
     *
     *  $option = Option::none();
     *  $option(1); // 1
     *  $option();  // NoneValueException
     * </code>
     *
     * @throws NoneValueException If None without argument is called.
     * @param string $default
     * @return mixed
     */
    abstract public function __invoke($default = null);
}

Option::init();
