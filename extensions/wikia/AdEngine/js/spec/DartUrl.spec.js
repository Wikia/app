describe('DartUrl', function(){
	it('constructor', function() {
		var domain = 'example.com',
			path = 'some/path',
			dartUrl = modules['ext.wikia.adEngine.dartUrl'](),
			url = dartUrl.urlBuilder(domain, path);

		expect(url.toString()).toBe('http://example.com/some/path;');
	});

	it('addParam single value', function() {
		var domain = 'example.com',
			path = 'some/path',
			dartUrl = modules['ext.wikia.adEngine.dartUrl'](),
			url = dartUrl.urlBuilder(domain, path);

		url.addParam('key', 'val');
		expect(url.toString()).toBe('http://example.com/some/path;key=val;');
	});

	it('addParam escaping value', function() {
		var domain = 'example.com',
			path = 'some/path',
			dartUrl = modules['ext.wikia.adEngine.dartUrl'](),
			url = dartUrl.urlBuilder(domain, path);

		url.addParam('key', '\'&#,');
		expect(url.toString()).toBe('http://example.com/some/path;key=\'%26%23%2C;');
	});

	it('addParam two params', function() {
		var domain = 'example.com',
			path = 'some/path',
			dartUrl = modules['ext.wikia.adEngine.dartUrl'](),
			url = dartUrl.urlBuilder(domain, path);

		url.addParam('key1', 'val1');
		url.addParam('key2', 'val2');
		expect(url.toString()).toBe('http://example.com/some/path;key1=val1;key2=val2;');
	});

	it('addParam falsy value', function() {
		var domain = 'example.com',
			path = 'some/path',
			dartUrl = modules['ext.wikia.adEngine.dartUrl'](),
			url = dartUrl.urlBuilder(domain, path),
			undef;

		url.addParam('key', false);
		expect(url.toString()).toBe('http://example.com/some/path;', 'false');

		url.addParam('key', undef);
		expect(url.toString()).toBe('http://example.com/some/path;', 'undef');

		url.addParam('key', 0);
		expect(url.toString()).toBe('http://example.com/some/path;', '0');

		url.addParam('key', '');
		expect(url.toString()).toBe('http://example.com/some/path;', 'empty string');

		url.addParam('key', []);
		expect(url.toString()).toBe('http://example.com/some/path;', 'empty array');
	});

	it('addParam more values packed in array', function() {
		var domain = 'example.com',
			path = 'some/path',
			dartUrl = modules['ext.wikia.adEngine.dartUrl'](),
			url = dartUrl.urlBuilder(domain, path),
			undef;

		url.addParam('key', ['val1', 'val2', 'val3']);
		expect(url.toString()).toBe('http://example.com/some/path;key=val1;key=val2;key=val3;');
	});

	it('addParam more values packed in array (more params)', function() {
		var domain = 'example.com',
			path = 'some/path',
			dartUrl = modules['ext.wikia.adEngine.dartUrl'](),
			url = dartUrl.urlBuilder(domain, path),
			undef;

		url.addParam('key1', ['val1', 'val2', 'val3']);
		url.addParam('key2', ['a', 'b', 'c']);
		expect(url.toString()).toBe('http://example.com/some/path;key1=val1;key1=val2;key1=val3;key2=a;key2=b;key2=c;');
	});

	it('addParam limit length', function() {
		var domain = 'example.com',
			path = 'some/path',
			dartUrl = modules['ext.wikia.adEngine.dartUrl'](),
			url = dartUrl.urlBuilder(domain, path),
			undef;

		url.addParam('0', '23456789plussomeextrachars', 10);
		expect(url.toString()).toBe('http://example.com/some/path;', 'single value, limit 10 (value removed)');

		url.addParam('0', '2345678', 10);
		expect(url.toString()).toBe('http://example.com/some/path;0=2345678;', 'single value, limit 10 (value kept)');

		url = dartUrl.urlBuilder(domain, path);
		url.addParam('0', ['234567890', 'anothervalue'], 10);
		expect(url.toString()).toBe('http://example.com/some/path;', 'two values, limit 10 (value removed)');

		url = dartUrl.urlBuilder(domain, path);
		url.addParam('0', ['234567', 'anothervalue'], 10);
		expect(url.toString()).toBe('http://example.com/some/path;0=234567;', 'two values, limit 10 (value kept)');

		url = dartUrl.urlBuilder(domain, path);
		url.addParam('0', ['abc', 'anothervalue', 'yetanotherone'], 10);
		expect(url.toString()).toBe('http://example.com/some/path;0=abc;', 'three values, limit 10, cut on ;');

		url = dartUrl.urlBuilder(domain, path);
		url.addParam('extralongkey', [
			'avalue', 'anothervalue', 'yetanotherone', 'andyetanotherone', 'anothervalue2',
			'avalue', 'anothervalue', 'yetanotherone', 'andyetanotherone', 'anothervalue2',
			'avalue', 'anothervalue', 'yetanotherone', 'andyetanotherone', 'anothervalue2',
			'avalue', 'anothervalue', 'yetanotherone', 'andyetanotherone', 'anothervalue2'
		], true);
		expect(url.toString()).toBe('http://example.com/some/path;' +
			'extralongkey=avalue;extralongkey=anothervalue;extralongkey=yetanotherone;extralongkey=andyetanotherone;extralongkey=anothervalue2;' +
			'extralongkey=avalue;extralongkey=anothervalue;extralongkey=yetanotherone;extralongkey=andyetanotherone;extralongkey=anothervalue2;' +
			'extralongkey=avalue;extralongkey=anothervalue;extralongkey=yetanotherone;extralongkey=andyetanotherone;extralongkey=anothervalue2;' +
			'extralongkey=avalue;extralongkey=anothervalue;extralongkey=yetanotherone;extralongkey=andyetanotherone;', 'lots values, limit default, cut on ;'
		);
	});

	it('addString regular', function() {
		var domain = 'example.com',
			path = 'some/path',
			dartUrl = modules['ext.wikia.adEngine.dartUrl'](),
			url = dartUrl.urlBuilder(domain, path);

		url.addString('key=val1;key=val2;key2=val3;key3=val4;');
		expect(url.toString()).toBe('http://example.com/some/path;key=val1;key=val2;key2=val3;key3=val4;');
	});

	it('addString with limit', function() {
		var domain = 'example.com',
			path = 'some/path',
			dartUrl = modules['ext.wikia.adEngine.dartUrl'](),
			url = dartUrl.urlBuilder(domain, path);

		url.addString('key=val1;key=val2;key2=val3;key3=val4;', true);
		expect(url.toString()).toBe('http://example.com/some/path;key=val1;key=val2;key2=val3;key3=val4;', 'default limit');

		url = dartUrl.urlBuilder(domain, path);


		url.addString('key=val1;key=val2;key2=val3;key3=val4;', 100);
		expect(url.toString()).toBe('http://example.com/some/path;key=val1;key=val2;key2=val3;key3=val4;', '100 limit');

		url = dartUrl.urlBuilder(domain, path);

		url.addString('key=val1;key=val2;key2=val3;key3=val4;', 20);
		expect(url.toString()).toBe('http://example.com/some/path;key=val1;key=val2;', '20 limit');

		url = dartUrl.urlBuilder(domain, path);

		url.addString('key=val1;key=val2;key2=val3;key3=val4;', 5);
		expect(url.toString()).toBe('http://example.com/some/path;', '5 limit (value removed)');
	});
});
