# Wikia JavaScript Coding Conventions

## TOC
* [Language Rules](#language-rules)
  * [Early returns](#early-returns)
  * [Semi-colons](#semi-colons)
  * [Function-declarations within blocks](#function-declarations-within-blocks)
* [Style Rules](#style-rules)
  * [White space guidelines](#white-space-guidelines)
  * [Prefixing jQuery objects](#prefixing-jquery-objects)
  * [Comments](#comments)
* [Still to be defined](#still-to-be-defined)

## Language Rules
### Early returns
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

### Semi-colons
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

### Try/catch blocks
Avoid using try/catch blocks in performance critical functions and inside loops.

## Style Rules

### White space guidelines
We are basing our white space rules off of jQuery's, which can be found [here](http://contribute.jquery.org/style-guide/js/). The are copied below so we can make changes to them as we see fit. 

In general, the jQuery style guide encourages liberal spacing for improved human readability. The minification process creates a file that is optimized for browsers to read and process.

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

##### Bad Examples

```js

// Bad
if(condition) doSomething();
while(!condition) iterating++;
for(var i=0;i<100;i++) object[array[i]] = someFn(i);

```

##### Good Examples

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


##### Objects

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


##### Arrays and Function Calls

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


##### Multi-line Statements

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


##### Chained Method Calls

When a chain of method calls is too long to fit on one line, there must be one call per line, with the first call on a separate line from the object the methods are called on. If the method changes the context, an extra level of indentation must be used.

```js
elements
	.addClass( 'foo' )
	.children()
		.html( 'hello' )
	.end()
	.appendTo( 'body' );
```



### Prefixing jQuery objects
All variables referencing jQuery objects, should be prefixed with a $.

```javascript
// $div is a jQuery object
var $div = $( 'div' );
```


### Comments
Comment early and often!

For comments inside functions, use inline comments.  For comments about functions and documents, use JSDoc style block comments. 

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

We use JSDoc style comments above function declarations and at the top of files because they make code clear and easy to read, and we'd like to be able to generate JSDocs at some point.  For examples of syntax you can check out  [these examples](http://usejsdoc.org/#JSDoc_Examples).

##### Required JSDoc Anotations (when applicable)
* @desc
* @param
* @return

##### Recommended JSDoc Anotations 
* @author (at the top of a file)
* @see (for links to documentation)

## Still to be defined
* Error handling and custom exception handling (handle this later)
* Delete Operator
  * Try to avoid using the delete operator
  * Doesn't actually clean up memory
  * Changing the shape of objects is bad for performance
  * Better to set the property to null or false
  * From google: "In modern JavaScript engines, changing the number of properties on an object is much slower than reassigning the values. The delete keyword should be avoided except when it is necessary to remove a property from an object's iterated list of keys, or to change the result of if (key in obj)."
* Modifying prototypes of built-in objects
  * Avoid doing 
  * jQuery code assumes no built in object prototypes are modified
  * Modifying builtins like Object.prototype and Array.prototype are strictly forbidden. Modifying other builtins like Function.prototype is less dangerous but still leads to hard to debug issues in production and should be avoided.
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

