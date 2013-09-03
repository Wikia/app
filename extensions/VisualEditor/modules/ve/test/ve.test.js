/*!
 * VisualEditor Base method tests.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've' );

/* Tests */

// ve.createObject: Tested upstream (JavaScript)

// ve.inheritClass: Tested upstream (OOJS)

// ve.mixinClass: Tested upstream (OOJS)

QUnit.test( 'isMixedIn', 11, function ( assert ) {
	function Foo () {}
	function Bar () {}
	function Quux () {}

	ve.inheritClass( Quux, Foo );
	ve.mixinClass( Quux, Bar );

	var b = new Bar(),
		q = new Quux();

	assert.strictEqual( ve.isMixedIn( Foo, Function ), false, 'Direct native inheritance is not considered' );
	assert.strictEqual( ve.isMixedIn( Foo, Object ), false, 'Indirect native inheritance is not considered' );
	assert.strictEqual( ve.isMixedIn( Quux, Foo ), false, 've.inheritClass does not affect mixin status' );
	assert.strictEqual( ve.isMixedIn( Foo, Foo ), false, 'Foo does not mixin Foo' );
	assert.strictEqual( ve.isMixedIn( Bar, Foo ), false, 'Bar does not mixin Foo' );
	assert.strictEqual( ve.isMixedIn( Quux, Bar ), true, 'Quux has Bar mixed in' );
	assert.strictEqual( ve.isMixedIn( Bar, Quux ), false, 'Bar does not mixin Quux' );

	assert.strictEqual( ve.isMixedIn( q, Foo ), false, 've.inheritClass does not affect mixin status' );
	assert.strictEqual( ve.isMixedIn( b, Foo ), false, 'b does not mixin Foo' );
	assert.strictEqual( ve.isMixedIn( q, Bar ), true, 'q has Bar mixed in' );
	assert.strictEqual( ve.isMixedIn( b, Quux ), false, 'b does not mixin Quux' );
} );

// ve.cloneObject: Tested upstream (OOJS)

// ve.getObjectValues: Tested upstream (OOJS)

// ve.getObjectKeys: Tested upstream (JavaScript)

// ve.compare: Tested upstream (OOJS)

// ve.copy: Tested upstream (OOJS)

// ve.isPlainObject: Tested upstream (jQuery)

// ve.isEmptyObject: Tested upstream (jQuery)

// ve.isArray: Tested upstream (jQuery)

// ve.bind: Tested upstream (jQuery)

// ve.indexOf: Tested upstream (jQuery)

// ve.extendObject: Tested upstream (jQuery)

QUnit.test( 'getHash: Basic usage', 7, function ( assert ) {
	var tmp,
		cases = {},
		hash = '{"a":1,"b":1,"c":1}',
		customHash = '{"first":1,"last":1}';

	cases['a-z literal'] = {
		object: {
			a: 1,
			b: 1,
			c: 1
		},
		hash: hash
	};

	cases['z-a literal'] = {
		object: {
			c: 1,
			b: 1,
			a: 1
		},
		hash: hash
	};

	tmp = {};
	cases['a-z augmented'] = {
		object: tmp,
		hash: hash
	};
	tmp.a = 1;
	tmp.b = 1;
	tmp.c = 1;

	tmp = {};
	cases['z-a augmented'] = {
		object: tmp,
		hash: hash
	};
	tmp.c = 1;
	tmp.b = 1;
	tmp.a = 1;

	cases['custom hash'] = {
		object: {
			getHashObject: function () {
				return {
					'first': 1,
					'last': 1
				};
			}
		},
		hash: customHash
	};

	cases['custom hash reversed'] = {
		object: {
			getHashObject: function () {
				return {
					'last': 1,
					'first': 1
				};
			}
		},
		hash: customHash
	};

	$.each( cases, function ( key, val ) {
		assert.equal(
			ve.getHash( val.object ),
			val.hash,
			key + ': object has expected hash, regardless of "property order"'
		);
	} );

	// .. and that something completely different is in face different
	// (just incase getHash is broken and always returns the same)
	assert.notEqual(
		ve.getHash( { a: 2, b: 2 } ),
		hash,
		'A different object has a different hash'
	);
} );

QUnit.test( 'getHash: Complex usage', 3, function ( assert ) {
	var obj, hash, frame;

	obj = {
		a: 1,
		b: 1,
		c: 1,
		// Nested array
		d: ['x', 'y', 'z'],
		e: {
			a: 2,
			b: 2,
			c: 2
		}
	};

	assert.equal(
		ve.getHash( obj ),
		'{"a":1,"b":1,"c":1,"d":["x","y","z"],"e":{"a":2,"b":2,"c":2}}',
		'Object with nested array and nested object'
	);

	// Include a circular reference
	/*
	 * PhantomJS hangs when calling JSON.stringify with an object containing a
	 * circular reference (https://github.com/ariya/phantomjs/issues/11206).
	 * We know latest Chrome/Firefox and IE8+ support this. So, for the sake of
	 * having qunit/phantomjs work, lets disable this for now.
	obj.f = obj;

	assert.throws( function () {
		ve.getHash( obj );
	}, 'Throw exceptions for objects with cirular refences ' );
	*/

	function Foo() {
		this.a = 1;
		this.c = 3;
		this.b = 2;
	}

	hash = '{"a":1,"b":2,"c":3}';

	assert.equal(
		ve.getHash( new Foo() ),
		hash,
		// This was previously broken when we used .constructor === Object
		// ve.getHash.keySortReplacer, because although instances of Foo
		// do inherit from Object (( new Foo() ) instanceof Object === true),
		// direct comparison would return false.
		'Treat objects constructed by a function as well'
	);

	frame = document.createElement( 'frame' );
	frame.src = 'about:blank';
	$( '#qunit-fixture' ).append( frame );
	obj = new frame.contentWindow.Object();
	obj.c = 3;
	obj.b = 2;
	obj.a = 1;

	assert.equal(
		ve.getHash( obj ),
		hash,
		// This was previously broken when we used comparison with "Object" in
		// ve.getHash.keySortReplacer, because they are an instance of the other
		// window's "Object".
		'Treat objects constructed by a another window as well'
	);
} );

QUnit.test( 'getDomAttributes', 1, function ( assert ) {
	assert.deepEqual(
		ve.getDomAttributes( $( '<div foo="bar" baz quux=3></div>' ).get( 0 ) ),
		{ 'foo': 'bar', 'baz': '', 'quux': '3' },
		'getDomAttributes() returns object with correct attributes'
	);
} );

QUnit.test( 'setDomAttributes', 3, function ( assert ) {
	var element = document.createElement( 'div' );
	ve.setDomAttributes( element, { 'foo': 'bar', 'baz': '', 'quux': 3 } );
	assert.deepEqual(
		ve.getDomAttributes( element ),
		{ 'foo': 'bar', 'baz': '', 'quux': '3' },
		'setDomAttributes() sets attributes correctly'
	);
	ve.setDomAttributes( element, { 'foo': null, 'bar': 1, 'baz': undefined, 'quux': 5, 'whee': 'yay' } );
	assert.deepEqual(
		ve.getDomAttributes( element ),
		{ 'bar': '1', 'quux': '5', 'whee': 'yay' },
		'setDomAttributes() overwrites attributes, removes attributes, and sets new attributes'
	);
	ve.setDomAttributes( element, { 'onclick': 'alert(1);' }, ['foo', 'bar', 'baz', 'quux', 'whee'] );
	assert.ok( !element.hasAttribute( 'onclick' ), 'event attributes are blocked when sanitizing' );
} );

QUnit.test( 'getOpeningHtmlTag', 5, function ( assert ) {
	assert.deepEqual(
		ve.getOpeningHtmlTag( 'code', {} ),
		'<code>',
		'opening tag without attributes'
	);
	assert.deepEqual(
		ve.getOpeningHtmlTag( 'img', { 'src': 'foo' } ),
		'<img src="foo">',
		'opening tag with one attribute'
	);
	assert.deepEqual(
		ve.getOpeningHtmlTag( 'a', { 'href': 'foo', 'rel': 'bar' } ),
		'<a href="foo" rel="bar">',
		'tag with two attributes'
	);
	assert.deepEqual(
		ve.getOpeningHtmlTag( 'option', { 'selected': true, 'blah': false, 'value': 3 } ),
		'<option selected="selected" value="3">',
		'handling of booleans and numbers'
	);
	assert.deepEqual(
		ve.getOpeningHtmlTag( 'input', { 'placeholder': '<foo>&"bar"&\'baz\'' } ),
		'<input placeholder="&lt;foo&gt;&amp;&quot;bar&quot;&amp;&#039;baz&#039;">',
		'escaping of attribute values'
	);
} );

( function () {
	var plainObj, funcObj, arrObj;
	plainObj = {
		'foo': 3,
		'bar': {
			'baz': null,
			'quux': {
				'whee': 'yay'
			}
		}
	};
	funcObj = function abc( d ) { return d; };
	funcObj.foo = 3;
	funcObj.bar = {
		'baz': null,
		'quux': {
			'whee': 'yay'
		}
	};
	arrObj = ['a', 'b', 'c'];
	arrObj.foo = 3;
	arrObj.bar = {
		'baz': null,
		'quux': {
			'whee': 'yay'
		}
	};

	$.each( {
		'Object': plainObj,
		'Function': funcObj,
		'Array': arrObj
	}, function ( type, obj ) {

		QUnit.test( 'getProp( ' + type + ' )', 9, function ( assert ) {
			assert.deepEqual(
				ve.getProp( obj, 'foo' ),
				3,
				'single key'
			);
			assert.deepEqual(
				ve.getProp( obj, 'bar' ),
				{ 'baz': null, 'quux': { 'whee': 'yay' } },
				'single key, returns object'
			);
			assert.deepEqual(
				ve.getProp( obj, 'bar', 'baz' ),
				null,
				'two keys, returns null'
			);
			assert.deepEqual(
				ve.getProp( obj, 'bar', 'quux', 'whee' ),
				'yay',
				'three keys'
			);
			assert.deepEqual(
				ve.getProp( obj, 'x' ),
				undefined,
				'missing property returns undefined'
			);
			assert.deepEqual(
				ve.getProp( obj, 'foo', 'bar' ),
				undefined,
				'missing 2nd-level property returns undefined'
			);
			assert.deepEqual(
				ve.getProp( obj, 'foo', 'bar', 'baz', 'quux', 'whee' ),
				undefined,
				'multiple missing properties don\'t cause an error'
			);
			assert.deepEqual(
				ve.getProp( obj, 'bar', 'baz', 'quux' ),
				undefined,
				'accessing property of null returns undefined, doesn\'t cause an error'
			);
			assert.deepEqual(
				ve.getProp( obj, 'bar', 'baz', 'quux', 'whee', 'yay' ),
				undefined,
				'accessing multiple properties of null'
			);
		} );

		QUnit.test( 'setProp( ' + type + ' )' , 7, function ( assert ) {
			ve.setProp( obj, 'foo', 4 );
			assert.deepEqual( 4, obj.foo, 'setting an existing key with depth 1' );

			ve.setProp( obj, 'test', 'TEST' );
			assert.deepEqual( 'TEST', obj.test, 'setting a new key with depth 1' );

			ve.setProp( obj, 'bar', 'quux', 'whee', 'YAY' );
			assert.deepEqual( 'YAY', obj.bar.quux.whee, 'setting an existing key with depth 3' );

			ve.setProp( obj, 'bar', 'a', 'b', 'c' );
			assert.deepEqual( 'c', obj.bar.a.b, 'setting two new keys within an existing key' );

			ve.setProp( obj, 'a', 'b', 'c', 'd', 'e', 'f' );
			assert.deepEqual( 'f', obj.a.b.c.d.e, 'setting new keys with depth 5' );

			ve.setProp( obj, 'bar', 'baz', 'whee', 'wheee', 'wheeee' );
			assert.deepEqual( null, obj.bar.baz, 'descending into null fails silently' );

			ve.setProp( obj, 'foo', 'bar', 'baz', 5 );
			assert.deepEqual( undefined, obj.foo.bar, 'descending into a non-object fails silently' );
		} );
	} );

}() );

QUnit.test( 'batchSplice', 8, function ( assert ) {
	var actual = [ 'a', 'b', 'c', 'd', 'e' ], expected = actual.slice( 0 ), bigArr = [],
		actualRet, expectedRet, i;

	actualRet = ve.batchSplice( actual, 1, 1, [] );
	expectedRet = expected.splice( 1, 1 );
	assert.deepEqual( expectedRet, actualRet, 'removing 1 element (return value)' );
	assert.deepEqual( expected, actual, 'removing 1 element (array)' );

	actualRet = ve.batchSplice( actual, 3, 2, [ 'w', 'x', 'y', 'z' ] );
	expectedRet = expected.splice( 3, 2, 'w', 'x', 'y', 'z' );
	assert.deepEqual( expectedRet, actualRet, 'replacing 2 elements with 4 elements (return value)' );
	assert.deepEqual( expected, actual, 'replacing 2 elements with 4 elements (array)' );

	actualRet = ve.batchSplice( actual, 0, 0, [ 'f', 'o', 'o' ] );
	expectedRet = expected.splice( 0, 0, 'f', 'o', 'o' );
	assert.deepEqual( expectedRet, actualRet, 'inserting 3 elements (return value)' );
	assert.deepEqual( expected, actual, 'inserting 3 elements (array)' );

	for ( i = 0; i < 2100; i++ ) {
		bigArr[i] = i;
	}
	actualRet = ve.batchSplice( actual, 2, 3, bigArr );
	expectedRet = expected.splice.apply( expected, [2, 3].concat( bigArr.slice( 0, 1050 ) ) );
	expected.splice.apply( expected, [1052, 0].concat( bigArr.slice( 1050 ) ) );
	assert.deepEqual( expectedRet, actualRet, 'replacing 3 elements with 2100 elements (return value)' );
	assert.deepEqual( expected, actual, 'replacing 3 elements with 2100 elements (array)' );
} );

QUnit.test( 'createDocumentFromHtml', function ( assert ) {
	var key, doc, expectedHead, expectedBody,
		cases = [
			{
				'msg': 'simple document with doctype, head and body',
				'html': '<!doctype html><html><head><title>Foo</title></head><body><p>Bar</p></body></html>',
				'head': '<title>Foo</title>',
				'body': '<p>Bar</p>'
			},
			{
				'msg': 'simple document without doctype',
				'html': '<html><head><title>Foo</title></head><body><p>Bar</p></body></html>',
				'head': '<title>Foo</title>',
				'body': '<p>Bar</p>'
			},
			{
				'msg': 'document with missing closing tags and missing <html> tag',
				'html': '<!doctype html><head><title>Foo</title><base href="yay"><body><p>Bar<b>Baz',
				'head': '<title>Foo</title><base href="yay" />',
				'body': '<p>Bar<b>Baz</b></p>'
			},
			{
				'msg': 'empty string results in empty document',
				'html': '',
				'head': '',
				'body': ''
			}
		];
	QUnit.expect( cases.length*2 );
	for ( key in cases ) {
		doc = ve.createDocumentFromHtml( cases[key].html );
		expectedHead = $( '<head>' ).html( cases[key].head ).get( 0 );
		expectedBody = $( '<body>' ).html( cases[key].body ).get( 0 );
		assert.equalDomElement( $( 'head', doc ).get( 0 ), expectedHead, cases[key].msg + ' (head)' );
		assert.equalDomElement( $( 'body', doc ).get( 0 ), expectedBody, cases[key].msg + ' (body)' );
	}
} );

// ve.splitClusters: Tested upstream (UnicodeJS)

// TODO: ve.isUnattachedCombiningMark

// TODO: ve.getByteOffset

// TODO: ve.getCharacterOffset

QUnit.test( 'graphemeSafeSubstring', function ( assert ) {
	var i, text = '12\ud860\udee245\ud860\udee2789\ud860\udee2bc', cases = [
			{
				'msg': 'start and end inside multibyte',
				'start': 3,
				'end': 12,
				'expected': [ '\ud860\udee245\ud860\udee2789\ud860\udee2', '45\ud860\udee2789' ]
			},
			{
				'msg': 'start and end next to multibyte',
				'start': 4,
				'end': 11,
				'expected': [ '45\ud860\udee2789', '45\ud860\udee2789' ]
			},
			{
				'msg': 'complete string',
				'start': 0,
				'end': text.length,
				'expected': [ text, text ]
			},
			{
				'msg': 'collapsed selection inside multibyte',
				'start': 3,
				'end': 3,
				'expected': [ '\ud860\udee2', '' ]
			}
		];
	QUnit.expect( cases.length * 2 );
	for ( i = 0; i < cases.length; i++ ) {
		assert.equal(
			ve.graphemeSafeSubstring( text, cases[i].start, cases[i].end, true ),
			cases[i].expected[0],
			cases[i].msg + ' (outer)'
		);
		assert.equal(
			ve.graphemeSafeSubstring( text, cases[i].start, cases[i].end, false ),
			cases[i].expected[1],
			cases[i].msg + ' (inner)'
		);
	}
} );
