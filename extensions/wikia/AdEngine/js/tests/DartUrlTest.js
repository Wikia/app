/**
 * @test-framework QUnit
 * @test-require-asset extensions/wikia/AdEngine/js/DartUrl.js
 */

module('DartUrl');

test('constructor', function() {
	var domain = 'example.com',
		path = 'some/path',
		dartUrl = DartUrl(),
		url = dartUrl.urlBuilder(domain, path);

	equal(url.toString(), 'http://example.com/some/path;');
});

test('addParam single value', function() {
	var domain = 'example.com',
		path = 'some/path',
		dartUrl = DartUrl(),
		url = dartUrl.urlBuilder(domain, path);

	url.addParam('key', 'val');
	equal(url.toString(), 'http://example.com/some/path;key=val;');
});

test('addParam two params', function() {
	var domain = 'example.com',
		path = 'some/path',
		dartUrl = DartUrl(),
		url = dartUrl.urlBuilder(domain, path);

	url.addParam('key1', 'val1');
	url.addParam('key2', 'val2');
	equal(url.toString(), 'http://example.com/some/path;key1=val1;key2=val2;');
});

test('addParam falsy value', function() {
	var domain = 'example.com',
		path = 'some/path',
		dartUrl = DartUrl(),
		url = dartUrl.urlBuilder(domain, path),
		undef;

	url.addParam('key', false);
	equal(url.toString(), 'http://example.com/some/path;', 'false');

	url.addParam('key', undef);
	equal(url.toString(), 'http://example.com/some/path;', 'undef');

	url.addParam('key', 0);
	equal(url.toString(), 'http://example.com/some/path;', '0');

	url.addParam('key', '');
	equal(url.toString(), 'http://example.com/some/path;', 'empty string');

	url.addParam('key', []);
	equal(url.toString(), 'http://example.com/some/path;', 'empty array');
});

test('addParam more values packed in array', function() {
	var domain = 'example.com',
		path = 'some/path',
		dartUrl = DartUrl(),
		url = dartUrl.urlBuilder(domain, path),
		undef;

	url.addParam('key', ['val1', 'val2', 'val3']);
	equal(url.toString(), 'http://example.com/some/path;key=val1;key=val2;key=val3;');
});

test('addParam more values packed in array (more params)', function() {
	var domain = 'example.com',
		path = 'some/path',
		dartUrl = DartUrl(),
		url = dartUrl.urlBuilder(domain, path),
		undef;

	url.addParam('key1', ['val1', 'val2', 'val3']);
	url.addParam('key2', ['a', 'b', 'c']);
	equal(url.toString(), 'http://example.com/some/path;key1=val1;key1=val2;key1=val3;key2=a;key2=b;key2=c;');
});

test('addParam limit length', function() {
	var domain = 'example.com',
		path = 'some/path',
		dartUrl = DartUrl(),
		url = dartUrl.urlBuilder(domain, path),
		undef;

	url.addParam('0', '23456789plussomeextrachars', 10);
	equal(url.toString(), 'http://example.com/some/path;', 'single value, limit 10 (value removed)');

	url.addParam('0', '2345678', 10);
	equal(url.toString(), 'http://example.com/some/path;0=2345678;', 'single value, limit 10 (value kept)');

	url = dartUrl.urlBuilder(domain, path);
	url.addParam('0', ['234567890', 'anothervalue'], 10);
	equal(url.toString(), 'http://example.com/some/path;', 'two values, limit 10 (value removed)');

	url = dartUrl.urlBuilder(domain, path);
	url.addParam('0', ['234567', 'anothervalue'], 10);
	equal(url.toString(), 'http://example.com/some/path;0=234567;', 'two values, limit 10 (value kept)');

	url = dartUrl.urlBuilder(domain, path);
	url.addParam('0', ['abc', 'anothervalue', 'yetanotherone'], 10);
	equal(url.toString(), 'http://example.com/some/path;0=abc;', 'three values, limit 10, cut on ;');

	url = dartUrl.urlBuilder(domain, path);
	url.addParam('extralongkey', [
		'avalue', 'anothervalue', 'yetanotherone', 'andyetanotherone', 'anothervalue2',
		'avalue', 'anothervalue', 'yetanotherone', 'andyetanotherone', 'anothervalue2',
		'avalue', 'anothervalue', 'yetanotherone', 'andyetanotherone', 'anothervalue2',
		'avalue', 'anothervalue', 'yetanotherone', 'andyetanotherone', 'anothervalue2'
	], true);
	equal(url.toString(), 'http://example.com/some/path;' +
		'extralongkey=avalue;extralongkey=anothervalue;extralongkey=yetanotherone;extralongkey=andyetanotherone;extralongkey=anothervalue2;' +
		'extralongkey=avalue;extralongkey=anothervalue;extralongkey=yetanotherone;extralongkey=andyetanotherone;extralongkey=anothervalue2;' +
		'extralongkey=avalue;extralongkey=anothervalue;extralongkey=yetanotherone;extralongkey=andyetanotherone;extralongkey=anothervalue2;' +
		'extralongkey=avalue;extralongkey=anothervalue;extralongkey=yetanotherone;extralongkey=andyetanotherone;', 'lots values, limit default, cut on ;'
	);
});

test('addString regular', function() {
	var domain = 'example.com',
		path = 'some/path',
		dartUrl = DartUrl(),
		url = dartUrl.urlBuilder(domain, path);

	url.addString('key=val1;key=val2;key2=val3;key3=val4;');
	equal(url.toString(), 'http://example.com/some/path;key=val1;key=val2;key2=val3;key3=val4;');
});

test('addString with limit', function() {
	var domain = 'example.com',
		path = 'some/path',
		dartUrl = DartUrl(),
		url = dartUrl.urlBuilder(domain, path);

	url.addString('key=val1;key=val2;key2=val3;key3=val4;', true);
	equal(url.toString(), 'http://example.com/some/path;key=val1;key=val2;key2=val3;key3=val4;', 'default limit');

	url = dartUrl.urlBuilder(domain, path);


	url.addString('key=val1;key=val2;key2=val3;key3=val4;', 100);
	equal(url.toString(), 'http://example.com/some/path;key=val1;key=val2;key2=val3;key3=val4;', '100 limit');

	url = dartUrl.urlBuilder(domain, path);

	url.addString('key=val1;key=val2;key2=val3;key3=val4;', 20);
	equal(url.toString(), 'http://example.com/some/path;key=val1;key=val2;', '20 limit');

	url = dartUrl.urlBuilder(domain, path);

	url.addString('key=val1;key=val2;key2=val3;key3=val4;', 5);
	equal(url.toString(), 'http://example.com/some/path;', '5 limit (value removed)');
});
