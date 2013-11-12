# Wikia JavaScript Coding Conventions

This styleguide defines the JavaScript coding conventions at Wikia. While it is managed by the JavaScript Style Guide Team, it is here to serve the entire JavaScript developer community at Wikia. Therefore, if you would like to propose a change, simply create a pull request and tag [@wikia-frontenders](https://github.com/wikia-frontenders).

## Our Mission ##

> As a developer, I want a clear and well documented guide covering coding conventions, patterns and best practices for JavaScript development at Wikia along with tools to help me in making my code compliant.

## TOC

* [Tools](#tools)
* [Language Rules](#language-rules)
  * [Early returns](#early-returns)
  * [Semi-colons](#semi-colons)
  * [Function-declarations within blocks](#function-declarations-within-blocks)
  * [Try/catch blocks](#trycatch-blocks)
  * [Switch statements](#switch-statements)
  * [Delete Operator](#delete-operator)
  * [Modifying prototypes of built-in objects](#modifying-prototypes-of-built-in-objects)
* [Style Rules](#style-rules)
  * [White space guidelines](#whitespace-guidelines)
     * [Bad examples](#bad-examples)
     * [Good examples](#good-examples)
     * [Objects](#objects)
     * [Arrays and Function Calls](#arrays-and-function-calls)
     * [Multi-line Statements](#multi-line-statements)
     * [Chained Method Calls](#chained-method-calls)
  * [Prefixing jQuery objects](#prefixing-jquery-objects)
  * [Comments](#comments)
  * [Naming conventions](#naming-conventions)
     * [Variables](#variables)
     * [Folders](#folders)
     * [AMD Modules](#amd-modules)
     * [JS Files](#js-files)
* [Resources](#resources)
* [To Do](#to-do)

## Tools

Here at Wikia, we employ a few tools to make compliance with our coding conventions easier. These tools are detailed below.

### [JSHint](http://jshint.com)

Wikia uses JSHint to detect errors, prevent potential problems and enforce some of our coding conventions. Our rules are enforced globally in the root level [.jshintrc](https://github.com/Wikia/app/blob/dev/.jshintrc) file. Keep in mind that some extensions have JSHint guidelines of their own.

#### How to use JSHint

Running JSHint can be [performed in a variety of ways](http://jshint.com/install/) though we currently recommend using an editor plugin, if available, but it's also easy to run straight from the command line.

### [EditorConfig](http://editorconfig.org/)

Wikia uses EditorConfig to help enforce whitespace consistency across our repository. Our rules are enforced globally in the root level [.editorconfig](https://github.com/Wikia/app/blob/dev/.editorconfig) file.

#### How to use EditorConfig

Simply [download a plugin](http://editorconfig.org/#download) for your editor of choice. If your editor is not listed, you will need to configure your editor manually to conform to any of our guidelines. If this is the case, please consider opening an issue (https://github.com/editorconfig/editorconfig/issues) or contributing a plugin (http://editorconfig.org/#contributing) to the EditorConfig project. Don't forget to update when changes to the guidelines get rolled out.

## Language Rules

Language rules have an impact on functionality. They were chosen based on performance implications and their tendency to reduce bugs.

### Early returns

Avoid early returns, they make the flow of the code harder to follow.

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

### Semicolons

Always use semicolons at the end of every statement. Do not use more than one statement per line.

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

Do not declare functions within blocks such as loops and conditionals. This will often lead to unintended consequences.

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

### Try/catch blocks

Avoid using try/catch blocks in performance critical functions and inside loops.

```javascript
// bad
for ( var i = 0; i < 10; i++ ) {
    try {
        // some process
    } catch () {
        // some exception handing
    }
}

// better
try {
    // some process
} catch (e) {
    // some exception handing
}

for ( var i = 0; i < 10; i++ ) {
    // do something based on results of try/catch above
}
```

### Switch Statements

The usage of `switch` statements is generally discouraged, but can be useful when there are a large number of cases - especially when multiple cases can be handled by the same block, or fall-through logic (the `default` case) can be leveraged.

When using `switch` statements:
 - Use `break`, `return` or `throw` for each case other than `default`.
 - The `default` case should always be last.

```javascript
// bad
switch( foo ) {
    default:
        z();
    case 'bar':
    case 'foobar':
        x();
        break;
    case 'baz':
        y();
}

// good
switch( foo ) {
    case 'bar':
    case 'foobar':
        x();
        break;
    case 'baz':
        y();
        break;
    default:
        z();
}
```

### Delete Operator

Avoid using the delete operator. It is better to set the property to null or some other falsey value.

From Google's style guide:
> "In modern JavaScript engines, changing the number of properties on an object is much slower than reassigning the values. The delete keyword should be avoided except when it is necessary to remove a property from an object's iterated list of keys, or to change the result of if (key in obj)."

__Example:__
```javascript
var myObj = {
  hello: 'hi',
  goodBye: 'bye'
}

// bad
delete myObj.goodBye;

// good
myObj.goodBye = false; // or null or '' etc.
```

### Modifying prototypes of built-in objects

Modifying prototypes is heavily discouraged. For this reason, many JavaScript frameworks, such as jQuery, work on the assumption that no built in Object prototypes are modified.

From Google's style guide:
> "Modifying builtins like Object.prototype and Array.prototype are strictly forbidden. Modifying other builtins like Function.prototype is less dangerous but still leads to hard to debug issues in production and should be avoided."

## Style Rules

Style rules help us write easy to read, well documented, and consistant code.

### Whitespace guidelines

Our whitespace guidelines are based on the [jQuery Style Guide](http://contribute.jquery.org/style-guide/js/). We have copied them below so we can make changes to them as we see fit. In general, the jQuery style guide encourages liberal spacing for improved human readability. The minification process creates a file that is optimized for browsers to read and process.

- Indentation with tabs.
- No whitespace at the end of line or on blank lines.
- Lines should be no longer than 80 characters, and must not exceed 100 (counting tabs as 4 spaces).
- `if`/`else`/`for`/`while`/`try` always have braces and always go on multiple lines.
- Unary special-character operators (e.g., `!`, `++`) must not have space next to their operand.
- Any `,` and `;` must not have preceding space.
- Any `;` used as a statement terminator must be at the end of the line.
- Any `:` after a property name in an object definition must not have preceding space.
- The `?` and `:` in a ternary conditional must have space on both sides.
- No filler spaces in empty constructs (e.g., `{}`, `[]`, `fn()`)
- New line at the end of each file.
- If the entire file is wrapped in a closure, the function body is not indented.

#### Bad Examples

```js

// Bad
if(condition) doSomething();
while(!condition) iterating++;
for(var i=0;i<100;i++) object[array[i]] = someFn(i);

```

#### Good Examples

```js
var i = 0;

if ( condition ) {
	doSomething();
} else if ( otherCondition ) {
	somethingElse();
} else {
	otherThing();
}

while ( !condition ) {
	iterating++;
}

for ( ; i < 100; i++ ) {
	object[ array[ i ] ] = someFn( i );
}

try {
	// Expressions
} catch ( e ) {
	// Expressions
}
```

#### Objects

Object declarations can be made on a single line if they are short (remember the line length limits). When an object declaration is too long to fit on one line, there must be one property per line. Property names only need to be quoted if they are reserved words or contain special characters:

```js
// Bad
var map = { ready: 9,
	when: 4, 'you are': 15 };

// Good
var map = { ready: 9, when: 4, 'you are': 15 };

// Good as well
var map = {
	ready: 9,
	when: 4,
	'you are': 15
};
```

#### Arrays and Function Calls

Always include extra spaces around elements and arguments:

```js
array = [ '*' ];

array = [ a, b ];

foo( arg );

foo( 'string', object );

foo( options, object[ property ] );

foo( node, 'property', 2 );
```

Exceptions:

```js
// Function with a callback, object, or array as the sole argument:
// No space on either side of the argument
foo({
	a: 'alpha',
	b: 'beta'
});

// Function with a callback, object, or array as the first argument:
// No space before the first argument
foo(function() {
	// Do stuff
}, options );

// Function with a callback, object, or array as the last argument:
// No space after after the last argument
foo( data, function() {
	// Do stuff
});
```

#### Multi-line Statements

When a statement is too long to fit on one line, line breaks must occur after an operator.

```js
// Bad
var html = '<p>The sum of ' + a + ' and ' + b + ' plus ' + c
	+ ' is ' + (a + b + c);

// Good
var html = '<p>The sum of ' + a + ' and ' + b + ' plus ' + c +
	' is ' + (a + b + c);
```

Lines should be broken into logical groups if it improves readability, such as splitting each expression of a ternary operator onto its own line even if both will fit on a single line.

```js
var firstCondition( foo ) && secondCondition( bar ) ?
	doStuff( foo, bar ) :
	doOtherStuff( foo, bar );
```

When a conditional is too long to fit on one line, successive lines must be indented one extra level to distinguish them from the body.

```js
	if ( fistCondition() && secondCondition() &&
			thirdCondition() ) {
		doStuff();
	}
```

#### Chained Method Calls

When a chain of method calls is too long to fit on one line, there must be one call per line, with the first call on a separate line from the object the methods are called on. If the method changes the context, an extra level of indentation must be used.

```js
elements
	.addClass( 'foo' )
	.children()
		.html( 'hello' )
	.end()
	.appendTo( 'body' );
```

### Comments

Comment early and often! For comments inside functions, use inline comments. For comments about functions and documents, use [JSDoc](http://usejsdoc.org/) style block comments.

```javascript
/* @desc This function bakes cookies
 * @param {string} flavor The flavor of the cookie
 * @return {object} cookie The delicious cookie
 */
function makeCookies( flavor ) {
    // create the cookie
    var cookie = {
        type: flavor,
        tastiness: 'delicious'
    }

    // do more stuff annotated by inline comments ...

    return cookie;
}
```

We use JSDoc style comments above function declarations and at the top of files because they make code clear and easy to read, and we'd like to be able to generate JavaScript documentation at some point.

#### Required JSDoc Anotations (when applicable)

* @desc
* @param
* @return

#### Recommended JSDoc Anotations

* @author (at the top of a file)
* @see (for links to documentation)

### Naming conventions

#### Variables

Use lazyCamelCase for all variables with the exception of constructers, which should use UpperCamelCase. Declare all variables using one `var` keyword at the top of their scope context. Declaration and assignment on the same line are allowed.

```javascript
// bad
var foo;
var bar;
var falcor;

// good
var foo,
	bar,
	falcor;

// also acceptable
var foo = 'kyle',
	bar = 'wears',
	falcor = 'shorts';

// normal variable casing
var myVariable;

// variable casing for constructors
function MyConstructor() { ... }
```

##### Constants

Constants do not exist in JavaScript so do not use all caps to denote constants.

##### Acronyms

Avoid acronyms in variable names and be explicit in your variable naming. It should be clear to anyone reading your code what the variable does.

##### Obfuscation

Avoid minification through obfuscation and try to make your code more human readable. Let the minification process handle minifying for production use.

##### jQuery Objects

All variables referencing jQuery Objects, should be prefixed with a `$`.

```javascript
// $div is a jQuery object
var $div = $( 'div' );
```

#### AMD Modules

AMD modules should be all lowercase. If the code is exension-specific, namespace with the extension.

```javascript
define( 'myextension.mypage' ... )
```
If there is a folder structure within the extension's scripts directory, the module's namespace should match the folder structure.

For example, if the tree looks like this:

    |-- Search
    | |-- scripts
    | | |-- views
    | | | |-- suggestions.js
    | | | |-- form.js
    | | |-- models
    | | | |-- results.js

The module names for these files would be:

```javascript
define( 'search.views.suggestions' ... );
define( 'search.views.form' ... );
define( 'search.models.results' ... );
```

If the code is meant to be used site wide or by multiple different extensions, namespace with 'wikia'.

```javascript
define( 'wikia.mymodule' )
```

Hint: If it's in the modules folder, it should be namespace with 'wikia'.

#### Folders

For clarity and future-proofness, all javascript files should go into a 'scripts' folder and all stylesheet files should go into a 'styles' folder.  This is different from what we've done in the past, which was putting all scripts into a 'js' folder and all stylesheets into a 'css' folder.

All library files should go inside 'lib' folders. This will make it easier for JSHint to ignore library code.

#### Files

All re-usable JavaScript should be written as AMD modules. See the [above section](#amd-modules) for matching file names to module names.

## Resources

* [Google's JS Style Guide](http://google-styleguide.googlecode.com/svn/trunk/javascriptguide.xml)
* [jQuery's JS Style Gude](https://github.com/jquery/contribute.jquery.org/blob/master/pages/style-guide/js.md)
* [Douglas Crockford's Code Conventions for the JavaScript Programming Language](http://javascript.crockford.com/code.html)
* [AirBnb's JS Style Guide](https://github.com/airbnb/javascript)
* [JSLint](http://www.jslint.com/)

## TODO

* Add more pics!

![Wikia](http://i.imgur.com/tVxkjhG.gif)
