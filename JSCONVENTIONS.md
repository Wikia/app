# Wikia JavaScript Coding Conventions

### [Language Rules](#language-rules)
* [Early returns](#early-returns)
* [Semi-colons](#semi-colons)
* [Function-declarations within blocks](#function-declarations-within-blocks)

### [Still to be defined](#still-to-be-defined)

### Language Rules
#### Early returns
Try to avoid early returns

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
Do not do this

## Style Rules

#### White space guidelines
We are using jQuery's guidelines: http://contribute.jquery.org/style-guide/js/

#### Prefixing jQuery objects
All variables referencing jQuery objects, should be prefixed with a $.

#### Comments
We use JSDoc style comments.

Example:
```javascript
var $div = $('div');
```

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

