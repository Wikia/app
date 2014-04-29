# Unit Tests

## Running PHP unit tests

Please note that **DevBoxSettings.php is not included** when unit tests are executed.

### Running a single tests

```
cd /usr/wikia/source/wiki/tests
ant -f build-wikia.xml -Dunittest=../extensions/wikia/AssetsManager/tests/AssetsManagerTest.php phpunit-single
```

### Running all tests

New way:
```
cd /usr/wikia/source/wiki/tests
./php-all
```

Old way:
```
cd /usr/wikia/source/wiki/tests
ant -f build-wikia.xml php
```

These commands will run all tests from ``tests`` subdirectories of:

* /includes/wikia
* /extensions/FBConnect
* /extensions/wikia

excluding the following groups: Infrastructure, Integration, Broken, Stub, Monitoring, Hack.

Test file needs to match ``*Test.php`` and the class in the file should extend ``WikiaBaseTest``

### Running only fast test suite

In ```tests``` directory type in ```./php-fast```

**Updating threshold for testsAnnotator**

This number can be found in app/includes/wikia/tests/core/WikiaTestSpeedAnnotator.class.php

**Running testsAnnotator**

To enable testsAnnotator you need to set environment variable to ```1``` and then run full tests suite.
````
ANNOTATE_TEST_SPEED=1 ./php-all
````

**Running unit tests on local machine**

We've run phpunit tests locally only on linux machines, requirements:
* php 5.4+
* phpunit http://phpunit.de/
* modified test_helpers - https://github.com/Wikia/php-test-helpers
* runkit http://php.net/manual/en/book.runkit.php
* config ( https://github.com/Wikia/config ) repo cloned into /usr/wikia/source/config

**Getting slow tests list**
In ```tests``` directory type in ```./php-slow-list```

This script will list all slow test cases with execution time.
Second list include list of class with count of slow tests cases.

### Running all tests (including infrastructure tests)

Run all tests on a specific wiki (by providing database name):
```
cd /usr/wikia/source/wiki/tests
ant -f build-wikia.xml phpunit -Ddbname=muppet
```

## Running JS unit tests

```
cd /usr/wikia/source/wiki/tests
karma start karma/js-unit.conf.js
```

For more info see
https://internal.wikia-inc.com/wiki/Unit_Testing/JS
