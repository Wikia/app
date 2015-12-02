SassService
===========

`SassService` provides [SASS](http://sass-lang.com/) parsing functionality.

## Parsers

Two kinds of parser are supported by this class:

* [libsass](http://sass-lang.com/libsass)-based [sassphp extension](https://github.com/sensational/sassphp)
* Ruby script spawned as an external process

## Installing sassphp

Follow [https://github.com/sensational/sassphp](sassphp instructions).

```
macbre@dev-macbre:~$ php -m | grep sass
sass
```

## How to use it?

**Do not use this class directly in your code**. Use `AssetsManager` instead.
