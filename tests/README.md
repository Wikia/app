# Unit Tests

## Running PHP unit tests

Please note that **DevBoxSettings.php is not included** when unit tests are executed.

### Running a single tests

```
cd /usr/wikia/source/wiki/tests
ant -f build-wikia.xml -Dunittest=../extensions/wikia/AssetsManager/tests/AssetsManagerTest.php phpunit-single
```

### Running all tests

```
cd /usr/wikia/source/wiki/tests
ant -f build-wikia.xml php
```

This command will run all tests from ``tests`` subdirectories of:

* /includes/wikia
* /extensions/FBConnect
* /extensions/wikia

excluding the following groups: Infrastructure, Integration, Broken, Stub, Monitoring, Hack.

Test file needs to match ``*Test.php``.

## Running JS unit tests

```
cd /usr/wikia/source/wiki/tests
ant -f build-wikia.xml js
```

This command will run all tests from ``tests`` subdirectories of:

* /extensions/wikia
* /resources/wikia/modules

## Running extension unit tests

The following commands will run all unit tests from ``/extensions/wikia/Foo/tests`` directory:

```
cd /usr/wikia/source/wiki/tests
./js-extension Foo
```

```
cd /usr/wikia/source/wiki/tests
./php-extension Foo
```
