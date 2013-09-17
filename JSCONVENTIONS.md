# Wikia JavaScript Coding Conventions

## TOC
* [Language Rules](#language-rules)
  * [Early returns](#early-returns)
  * [Semi-colons](#semi-colons)
  * [Function-declarations within blocks](#function-declarations-within-blocks)
* [Style Rules](#style-rules)
  * [White space guidelines](#white-space-guidelines)
  * [Prefixing jQuery objects](#prefixing-jquery-objects)
* [Still to be defined](#still-to-be-defined)

## Language Rules
#### Early returns
Try to avoid early returns.  It makes the code easier to read. 
```javascript
// not best practice
function() {
    if ( someBool ) {
        return true;
    }
    return false;
}

// better
function() {
    var myBool = false;
    if ( someBool ) {
        myBool = true;
    }
    return myBool;
}
```

#### Semi-colons
Always use semicolons at the end of every simple statement.  No more than one statement per line.
```javascript
// bad:
var x = y
myFunc()

// also bad:
var x = y; myFunc();

// good:
var x = y;
myFunc();
```

### Function declarations within blocks
Don't declare functions within blocks like loops and conditionals as this will often lead to unintended consequences. 
```javascript
// bad: 
if ( someBool ) {
    function myFunc() {
        // code 
    }
}

// also bad:
while ( condition ) {
    function myFunc() {
        // code
    }
}
```

## Style Rules

#### White space guidelines
We are using jQuery's guidelines: http://contribute.jquery.org/style-guide/js/

#### Prefixing jQuery objects
All variables referencing jQuery objects, should be prefixed with a $.

```javascript
// $div is a jQuery object
var $div = $('div');
```


#### Comments
We use JSDoc style comments.

### Still to be defined
* Error handling and custom exception handling
* Delete Operator
* Modifying prototypes of built-in objects
* White space (we want to transcribe jQuery's conventions as much as possible so we can tweak them on our end)
* Structure
* Commenting
* Naming Conventions
	* vars
	* modules
	* folders
	* files
	* constants
	* casing
* Directory Structure
* AMD

