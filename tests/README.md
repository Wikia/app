# Unit Tests

## Running PHP unit tests

```
ant -f build-wikia.xml -Dphpunitexcludegroups=Infrastructure,Integration,Broken,Stub,Monitoring,Hack phpunit
```

This command will run all tests from ``tests`` subdirectories of:

* /includes/wikia
* /extensions/FBConnect
* /extensions/wikia

Test file needs to match ``*Test.php``.

## Running JS unit tests

```
ant -f build-wikia.xml js
```

This command will run all tests from ``tests`` subdirectories of:

* /extensions/wikia
* /resources/wikia/modules
