MockableDateTime
================

What is it
----------

MockableDateTime is a library written in PHP that allows developers to mock the dates in test environments.
There are sometimes in which you need to verify an action was executed with certain parameters, and of them is a date or a time (generally obtained with date() or time() built-in functions) and is very difficult to ensure it will have a certain value at the time of that verify execution. 
MockableDateTime solves this problem by giving the developer a way to obtain PHP's built-in \DateTime class in a way the value it returns can be mocked from unit tests without the need of injecting \DateTime as a dependency.  MockableDateTime was inspired in Joda DateTimeUtils from Java.

Installation
------------

#### Composer:

This project is published in packagist, so you just need to add it as a dependency in your composer.json:

```javascript
    "require": {
        // ...
        "mcustiel/mockable-datetime": "*"
    }
```

If you want to access directly to this repo, adding this to your composer.json should be enough:

```javascript  
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/mcustiel/mockable-datetime"
        }
    ],
    "require": {
        "mcustiel/mockable-datetime": "dev-master"
    }
}
```

Or just download the release and include it in your path.

How to use it?
--------------

### In your code

Everytime you need to get system's date just use MockableDateTime:

```php

use Mcustiel\Mockable\DateTime as MockableDateTime;

// ...
function savePersonInfoInDatabase(Person $person)
{
    PersonDbEntity $person = $this->converter->convert($person, PersonDbEntity::class);
    
    $date = new MockableDateTime();
    $person->setInsertedDate($date->toPhpDateTime());
    
    $this->dbClient->insert($person);
}
// ...
```

As you can see in the example, I'm not using PHP's \DateTime directly. Instead I have an instance of MockableDateTime and from it I obtain PHP's \DateTime.

Then you have to test this, and assert that insert method was called. For the example I'll use PHPUnit.

```php
use Mcustiel\Mockable\DateTimeUtils;

// ...

/**
 * @test
 */
function shouldCallInsertPersonWithCorrectData()
{
    DateTimeUtils::setCurrentTimestampFixed(
        (new \DateTime('2000-01-01 00:00:01'))->getTimestamp()
    );
    // Now all instances of MockableDateTime will always return "2000-01-01 00:00:01"
    
    Person $person = new Person('John', 'Doe');
    PersonDbEntity $expected = new PersonDbEntity('John', 'Doe');
    $expected->setInsertedDate(new \DateTime('2000-01-01 00:00:01'));    
    
    $this->dbClientMock->expects($this->once())
        ->method('insert')
        ->with($this->equalTo($expected));
    
    $this->unitUnderTest->savePersonInfoInDatabase($person);
}
// ...
```

That's it. For it to work the code and tests should be executed in the same environment (it won't work if you execute tests again a running instance of your webservice), but it should be enough for unit and some low level functional tests.

### DateTimeUtils methods:

##### void setCurrentTimestampFixed(int $timestamp)

This method makes all instances of MockableDateTime to always return the date and time specified by the timestamp.

##### void setCurrentTimestampOffset(int $timestamp)

This method makes all instances of MockableDateTime to always return a date and time with offset equal to the specified timestamp. The time starts to run from the moment of the instantiation of MockableDateTime. So if you set an offset equal to '2005-05-05 01:00:00' and sleep for 5 seconds, a new call will return '2005-05-05 01:00:05'.

##### void setCurrentTimestampSystem()

This method makes all instances of MockableDateTime to always return current system time (default behaviour).
