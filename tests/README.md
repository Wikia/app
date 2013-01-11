# Unit Tests

## Running PHP unit tests

```
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
ant -f build-wikia.xml js
```

This command will run all tests from ``tests`` subdirectories of:

* /extensions/wikia
* /resources/wikia/modules
