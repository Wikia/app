/**
 * This is an example of JS code full on antipatterns
 * and other things you should avoid in JavaScript
 */

function foo() {
	bar = 12;

	return
	{
		retVal: bar
	}
}

function theFunction() {
	var foo = 1;
	return foo;

	// unreachable code
	foo++;
	return foo;
}

console.log(bar);

var obj = new Object(),
	arr = new Array(),
	collection = {
		abc: true,
		foo: false,
	}

alert(collection);

var a = new Function(),
	b = setTimeout('foo', 100),
	c = setInterval('foo', 500);