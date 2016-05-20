PhpOption
=========

Tired of `Trying to get property of non-object`?

This is a porting of the [option type](https://en.wikipedia.org/wiki/Option_type) in PHP.

## Creating Options

You can create options through constructors (e.g. `new Some(0)`, `new None`) or using facade methods of the *Option* class.

`Option::none()` returns an instance of the None class. Since this class is stateless there is no need to create a new object every time that a None is needed.

`Option::create($value, $empty = null)` returns an Option object. By default it returns a None if the `$value` is `null`, or a `new Some($value)` otherwise.

You can change this behavior passing the `$empty` parameter.
E.g. `Option::create(0, 0) === Option::none()`

If another option is passed to the create method, the option itself is returned.

If the `$value` is callable then the value that it yields is used.

If `$empty` is callable then it's applied to `$value` and a None is returned if it yields a falsy value.

## Using Options

With a convenient syntax you can use *PhpOption* to get properties from objects and keys from arrays while handling `null`s.

```PHP
// $user object contains a reference to addres
// which contains a reference to city,
// but the user, the address and the city
// can be null
$city = isset($user->address->city) ? $user->address->city : 'Unknown';

// this line makes the same thing
$city = Option::create($user)->address->city->getOrElse('Unknown');
```

`Option`s also offer a lot of flexibility.

```PHP
// we can change this
if (isset($user->address->city)) {
    $city = $user->address->city;
    $result = $city === 'rome' ? 'home' : $city;
} else {
    $result = 'city unknown';
}

// with a little more compact solution
$result = Option::create($user)->address->city
    ->map(function ($city) { return $city === 'rome' ? 'home' : $city; })
    ->getOrElse('city unknown');
```

Wait, but I have an array!

```PHP
// no problem, objects and arrays are treated identically
$user = [ 'defined' => [ 'key' => 0 ] ];

$key = Option::create($user)->defined->key->get(); // $key is 0

$user = null;

$key = Option::create($user)->undefined->key->getOrElse(0); // $key is 0 again
```

Okay, what if I have some resource intensive functions?

```PHP
// use callbacks for lazy-evaluation
Option::create($user)->some->property
    ->orElse(function () { return $this->heavyLoad(); })
    ->orElse(function () { return $this->someFallback(); })
    ->getOrElse(function () { return $this->lastChance(); });
```

If `$user->some->property` exists and is not null, no methods get called.
If the first callback gets called and returns a non-null value, the following functions aren't executed, and so on...

## Option methods

### `filter(Closure $function)`
If the Option is a Some and the given `$function` returns false on its value, filter method returns None.
Returns the Option itself otherwise.

### `map(Closure $function)`
If the Option is a Some returns another Option wrapping the result of `$function` applied to Option's value.
Returns a None otherwise.

### `each(Closure $function)`
Applies given `$function` to the Option's value if is non-empty, does nothing otherwise.
Returns Option itself.

### `get()`
Gets the value of the Option or throws `NoneValueException` if the Option is a None.

### `getOrElse(mixed $default)`
If the Option is a Some returns its value, returns `$default` otherwise.

`$default` can be:
1. a callback - which is called and its result returned if the Option is a None.
2. any other PHP value - which is returned in case the Option is a None.

### `getOrThrow(Exception $e)`
Gets the value of the Option or throws `$e` if the Option is a None.

### `getOrCall(Closure $function)`
If the Option is a Some returns its value, returns the value that yields `$function` otherwise.

### `orElse(mixed $default)`
Acts like `getOrElse`, but returns an Option instead of its value.

### `isDefined()` and `isEmpty()`
The first one returns true if the Option is not a None, the second one returns true if it is.

## Dynamic methods

### `__toString()`
A None gets casted to an empty string, while a non-empty Option returns the `(string)` cast of its value.

### `__get(string $name)`
If the Option is a Some which contains an array or an object, it looks for the given key or property.
If it exists and is not `null`, returns an Option wrapping this value.
In any other case returns a None.

### `__isset(string $name)`
Check if the given key or property exists in the Option's value.

E.g.
```PHP
$array = [ 'defined' => [ 'key' => 0 ] ];
isset(Option::create($array)->defined->key); // true

isset(Option::create(null)->undefined->key); // false
```

### `__invoke(mixed $default)`
Makes the Option callable.
This is a shortcut for `get()` and `getOrElse()` methods.

E.g.
```PHP
$option = Option::create(0);
$option(1); // 0
$option();  // 0

$option = Option::none();
$option(1); // 1
$option();  // NoneValueException
```

Like getOrElse method `$default` can be a callback or any other PHP value.
