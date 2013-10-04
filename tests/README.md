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

### Running all tests (including infrastructure tests)

Run all tests on a specific wiki (by providing database name):
```
cd /usr/wikia/source/wiki/tests
ant -f build-wikia.xml phpunit -Ddbname=muppet
```

## Running JS unit tests

```
cd /usr/wikia/source/wiki/tests
karma start karma/js-unit.config.js
```

For more info see
https://internal.wikia-inc.com/wiki/Unit_Testing/JS
