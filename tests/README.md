Unit Tests
==========

Tests build jobs are defined in the Makefile. Helper shell script are provided.

## Running PHP unit tests

> Please note that **DevBoxSettings.php is not included** when unit tests are executed

### Running a single test

```
make phpunit-single test=../extensions/wikia/AssetsManager/tests/AssetsManagerTest.php
```

### Running all tests for a given extension

```
./php-extension FooExtension
```

will run all tests (except of ``@group Broken``) from ``/extensions/wikia/FooExtension``.

Adding additional parameter ``-c`` will make it generate a coverage report, HTML saved in ``/coverage`` path.

```
./php-extension -c FooExtension
```

### Running all tests for a given group or groups

```
./php-group MediaFeatures
```

will run all tests marked as ``@group MediaFeatures``.  Any number of groups can be added, e.g.:

```
./php-group MediaFeatures UsingDB
```

### Running all unit tests

```
./php-all
```

These commands will run all tests (unit, infrastructure and integration) from ``tests`` subdirectories of:

* /includes/wikia
* /extensions/wikia

excluding the following groups: ``Broken, Stub, Monitoring, Hack``.

Test file needs to match ``*Test.php`` and the class in the file should extend ``WikiaBaseTest``

### Running only fast test suite

In ```tests``` directory type in ```./php-fast```

## Running JS unit & integration tests

Before running the tests install node dependencies in project root level
```
npm install
```

Run all javascript tests in ```tests``` directory

Single run of both unit and integration tests
```
./js-all
```

Single run of unit tests
```
make karma-unit
```

Single run of integration tests
```
make karma-integration
```

For more info see [docs on internal](https://internal.wikia-inc.com/wiki/Unit_Testing/JS)
