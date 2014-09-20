module( 'mediawiki', QUnit.newMwEnvironment() );

test( '-- Initial check', function() {
	expect(8);

	ok( window.jQuery, 'jQuery defined' );
	ok( window.$, '$j defined' );
	ok( window.$j, '$j defined' );
	strictEqual( window.$, window.jQuery, '$ alias to jQuery' );
	strictEqual( window.$j, window.jQuery, '$j alias to jQuery' );

	ok( window.mediaWiki, 'mediaWiki defined' );
	ok( window.mw, 'mw defined' );
	strictEqual( window.mw, window.mediaWiki, 'mw alias to mediaWiki' );
});

test( 'mw.Map', function() {
	expect(17);

	ok( mw.Map, 'mw.Map defined' );

	var	conf = new mw.Map(),
		// Dummy variables
		funky = function() {},
		arry = [],
		nummy = 7;

	// Tests for input validation
	strictEqual( conf.get( 'inexistantKey' ), null, 'Map.get returns null if selection was a string and the key was not found' );
	strictEqual( conf.set( 'myKey', 'myValue' ), true, 'Map.set returns boolean true if a value was set for a valid key string' );
	strictEqual( conf.set( funky, 'Funky' ), false, 'Map.set returns boolean false if key was invalid (Function)' );
	strictEqual( conf.set( arry, 'Arry' ), false, 'Map.set returns boolean false if key was invalid (Array)' );
	strictEqual( conf.set( nummy, 'Nummy' ), false, 'Map.set returns boolean false if key was invalid (Number)' );
	equal( conf.get( 'myKey' ), 'myValue', 'Map.get returns a single value value correctly' );
	strictEqual( conf.get( nummy ), null, 'Map.get ruturns null if selection was invalid (Number)' );
	strictEqual( conf.get( funky ), null, 'Map.get ruturns null if selection was invalid (Function)' );

	// Multiple values at once
	var someValues = {
		'foo': 'bar',
		'lorem': 'ipsum',
		'MediaWiki': true
	};
	strictEqual( conf.set( someValues ), true, 'Map.set returns boolean true if multiple values were set by passing an object' );
	deepEqual( conf.get( ['foo', 'lorem'] ), {
		'foo': 'bar',
		'lorem': 'ipsum'
	}, 'Map.get returns multiple values correctly as an object' );

	deepEqual( conf.get( ['foo', 'notExist'] ), {
		'foo': 'bar',
		'notExist': null
	}, 'Map.get return includes keys that were not found as null values' );

	strictEqual( conf.exists( 'foo' ), true, 'Map.exists returns boolean true if a key exists' );
	strictEqual( conf.exists( 'notExist' ), false, 'Map.exists returns boolean false if a key does not exists' );

	// Interacting with globals and accessing the values object
	strictEqual( conf.get(), conf.values, 'Map.get returns the entire values object by reference (if called without arguments)' );

	conf.set( 'globalMapChecker', 'Hi' );

	ok( false === 'globalMapChecker' in window, 'new mw.Map did not store its values in the global window object by default' );

	var globalConf = new mw.Map( true );
	globalConf.set( 'anotherGlobalMapChecker', 'Hello' );

	ok( 'anotherGlobalMapChecker' in window, 'new mw.Map( true ) did store its values in the global window object' );

	// Whitelist this global variable for QUnit's 'noglobal' mode
	if ( QUnit.config.noglobals ) {
		QUnit.config.pollution.push( 'anotherGlobalMapChecker' );
	}
});

test( 'mw.config', function() {
	expect(1);

	ok( mw.config instanceof mw.Map, 'mw.config instance of mw.Map' );
});

test( 'mw.message & mw.messages', function( assert ) {
	var goodbye, hello, specialCharactersPageName = '"Who" wants to be a millionaire & live on \'Exotic Island\'?';

	expect(100);

	mw.messages.set( 'other-message', 'Other Message' );
	mw.messages.set( 'mediawiki-test-pagetriage-del-talk-page-notify-summary', 'Notifying author of deletion nomination for [[$1]]' );
	mw.messages.set( 'gender-plural-msg', '{{GENDER:$1|he|she|they}} {{PLURAL:$2|is|are}} awesome' );
	mw.messages.set( 'grammar-msg', 'Przeszukaj {{GRAMMAR:grammar_case_foo|{{SITENAME}}}}' );
	mw.messages.set( 'formatnum-msg', '{{formatnum:$1}}' );
	mw.messages.set( 'int-msg', 'Some {{int:other-message}}' );
	mw.messages.set( 'mediawiki-test-version-entrypoints-index-php', '[https://www.mediawiki.org/wiki/Manual:index.php index.php]' );
	mw.messages.set( 'external-link-replace', 'Foo [$1 bar]' );

	// Convenience method for asserting the same result for multiple formats
	function assertMultipleFormats( messageArguments, formats, expectedResult, assertMessage ) {
		var len = formats.length, format, i;
		for ( i = 0; i < len; i++ ) {
			format = formats[i];
			assert.equal( mw.message.apply( null, messageArguments )[format](), expectedResult, assertMessage + ' when format is ' + format );
		}
	}

	assert.ok( mw.messages, 'messages defined' );
	assert.ok( mw.messages instanceof mw.Map, 'mw.messages instance of mw.Map' );
	assert.ok( mw.messages.set( 'hello', 'Hello <b>awesome</b> world' ), 'mw.messages.set: Register' );

	hello = mw.message( 'hello' );

	// https://bugzilla.wikimedia.org/show_bug.cgi?id=44459
	assert.equal( hello.format, 'text', 'Message property "format" defaults to "text"' );

	assert.strictEqual( hello.map, mw.messages, 'Message property "map" defaults to the global instance in mw.messages' );
	assert.equal( hello.key, 'hello', 'Message property "key" (currect key)' );
	assert.deepEqual( hello.parameters, [], 'Message property "parameters" defaults to an empty array' );

	// Todo
	assert.ok( hello.params, 'Message prototype "params"' );

	hello.format = 'plain';
	assert.equal( hello.toString(), 'Hello <b>awesome</b> world', 'Message.toString returns the message as a string with the current "format"' );

	assert.equal( hello.escaped(), 'Hello &lt;b&gt;awesome&lt;/b&gt; world', 'Message.escaped returns the escaped message' );
	assert.equal( hello.format, 'escaped', 'Message.escaped correctly updated the "format" property' );

	assert.ok( mw.messages.set( 'multiple-curly-brace', '"{{SITENAME}}" is the home of {{int:other-message}}' ), 'mw.messages.set: Register' );
	assertMultipleFormats( ['multiple-curly-brace'], ['text', 'parse'], '"' + mw.config.get( 'wgSiteName') + '" is the home of Other Message', 'Curly brace format works correctly' );
	assert.equal( mw.message( 'multiple-curly-brace' ).plain(), mw.messages.get( 'multiple-curly-brace' ), 'Plain format works correctly for curly brace message' );
	assert.equal( mw.message( 'multiple-curly-brace' ).escaped(), mw.html.escape( '"' + mw.config.get( 'wgSiteName') + '" is the home of Other Message' ), 'Escaped format works correctly for curly brace message' );

	assert.ok( mw.messages.set( 'multiple-square-brackets-and-ampersand', 'Visit the [[Project:Community portal|community portal]] & [[Project:Help desk|help desk]]' ), 'mw.messages.set: Register' );
	assertMultipleFormats( ['multiple-square-brackets-and-ampersand'], ['plain', 'text'], mw.messages.get( 'multiple-square-brackets-and-ampersand' ), 'Square bracket message is not processed' );
	assert.equal( mw.message( 'multiple-square-brackets-and-ampersand' ).escaped(), 'Visit the [[Project:Community portal|community portal]] &amp; [[Project:Help desk|help desk]]', 'Escaped format works correctly for square bracket message' );
	assert.htmlEqual( mw.message( 'multiple-square-brackets-and-ampersand' ).parse(), 'Visit the ' +
		'<a title="Project:Community portal" href="/wiki/Project:Community_portal">community portal</a>' +
		' &amp; <a title="Project:Help desk" href="/wiki/Project:Help_desk">help desk</a>', 'Internal links work with parse' );

	assertMultipleFormats( ['mediawiki-test-version-entrypoints-index-php'], ['plain', 'text', 'escaped'], mw.messages.get( 'mediawiki-test-version-entrypoints-index-php' ), 'External link markup is unprocessed' );
	assert.htmlEqual( mw.message( 'mediawiki-test-version-entrypoints-index-php' ).parse(), '<a href="https://www.mediawiki.org/wiki/Manual:index.php">index.php</a>', 'External link works correctly in parse mode' );

	assertMultipleFormats( ['external-link-replace', 'http://example.org/?x=y&z'], ['plain', 'text'], 'Foo [http://example.org/?x=y&z bar]', 'Parameters are substituted but external link is not processed' );
	assert.equal( mw.message( 'external-link-replace', 'http://example.org/?x=y&z' ).escaped(), 'Foo [http://example.org/?x=y&amp;z bar]', 'In escaped mode, parameters are substituted and ampersand is escaped, but external link is not processed' );
	assert.htmlEqual( mw.message( 'external-link-replace', 'http://example.org/?x=y&z' ).parse(), 'Foo <a href="http://example.org/?x=y&amp;z">bar</a>', 'External link with replacement works in parse mode without double-escaping' );

	hello.parse();
	assert.equal( hello.format, 'parse', 'Message.parse correctly updated the "format" property' );

	hello.plain();
	assert.equal( hello.format, 'plain', 'Message.plain correctly updated the "format" property' );

	hello.text();
	assert.equal( hello.format, 'text', 'Message.text correctly updated the "format" property' );

	assert.strictEqual( hello.exists(), true, 'Message.exists returns true for existing messages' );

	goodbye = mw.message( 'goodbye' );
	assert.strictEqual( goodbye.exists(), false, 'Message.exists returns false for nonexistent messages' );

	assertMultipleFormats( ['goodbye'], ['plain', 'text'], '<goodbye>', 'Message.toString returns <key> if key does not exist' );
	// bug 30684
	assertMultipleFormats( ['goodbye'], ['parse', 'escaped'], '&lt;goodbye&gt;', 'Message.toString returns properly escaped &lt;key&gt; if key does not exist' );

	assert.ok( mw.messages.set( 'plural-test-msg', 'There {{PLURAL:$1|is|are}} $1 {{PLURAL:$1|result|results}}' ), 'mw.messages.set: Register' );
	assertMultipleFormats( ['plural-test-msg', 6], ['text', 'parse', 'escaped'], 'There are 6 results', 'plural get resolved' );
	assert.equal( mw.message( 'plural-test-msg', 6 ).plain(), 'There {{PLURAL:6|is|are}} 6 {{PLURAL:6|result|results}}', 'Parameter is substituted but plural is not resolved in plain' );

	assert.ok( mw.messages.set( 'plural-test-msg-explicit', 'There {{plural:$1|is one car|are $1 cars|0=are no cars|12=are a dozen cars}}' ), 'mw.messages.set: Register message with explicit plural forms' );
	assertMultipleFormats( ['plural-test-msg-explicit', 12], ['text', 'parse', 'escaped'], 'There are a dozen cars', 'explicit plural get resolved' );

	assert.ok( mw.messages.set( 'plural-test-msg-explicit-beginning', 'Basket has {{plural:$1|0=no eggs|12=a dozen eggs|6=half a dozen eggs|one egg|$1 eggs}}' ), 'mw.messages.set: Register message with explicit plural forms' );
	assertMultipleFormats( ['plural-test-msg-explicit-beginning', 1], ['text', 'parse', 'escaped'], 'Basket has one egg', 'explicit plural given at beginning get resolved for singular' );
	assertMultipleFormats( ['plural-test-msg-explicit-beginning', 4], ['text', 'parse', 'escaped'], 'Basket has 4 eggs', 'explicit plural given at beginning get resolved for plural' );
	assertMultipleFormats( ['plural-test-msg-explicit-beginning', 6], ['text', 'parse', 'escaped'], 'Basket has half a dozen eggs', 'explicit plural given at beginning get resolved for 6' );
	assertMultipleFormats( ['plural-test-msg-explicit-beginning', 0], ['text', 'parse', 'escaped'], 'Basket has no eggs', 'explicit plural given at beginning get resolved for 0' );

	assertMultipleFormats( ['mediawiki-test-pagetriage-del-talk-page-notify-summary'], ['plain', 'text'], mw.messages.get( 'mediawiki-test-pagetriage-del-talk-page-notify-summary' ), 'Double square brackets with no parameters unchanged' );

	assertMultipleFormats( ['mediawiki-test-pagetriage-del-talk-page-notify-summary', specialCharactersPageName], ['plain', 'text'], 'Notifying author of deletion nomination for [[' + specialCharactersPageName + ']]', 'Double square brackets with one parameter' );

	assert.equal( mw.message( 'mediawiki-test-pagetriage-del-talk-page-notify-summary', specialCharactersPageName ).escaped(), 'Notifying author of deletion nomination for [[' + mw.html.escape( specialCharactersPageName ) + ']]', 'Double square brackets with one parameter, when escaped' );

	assert.ok( mw.messages.set( 'mediawiki-test-categorytree-collapse-bullet', '[<b>−</b>]' ), 'mw.messages.set: Register' );
	assert.equal( mw.message( 'mediawiki-test-categorytree-collapse-bullet' ).plain(), mw.messages.get( 'mediawiki-test-categorytree-collapse-bullet' ), 'Single square brackets unchanged in plain mode' );

	assert.ok( mw.messages.set( 'mediawiki-test-wikieditor-toolbar-help-content-signature-result', '<a href=\'#\' title=\'{{#special:mypage}}\'>Username</a> (<a href=\'#\' title=\'{{#special:mytalk}}\'>talk</a>)' ), 'mw.messages.set: Register' );
	assert.equal( mw.message( 'mediawiki-test-wikieditor-toolbar-help-content-signature-result' ).plain(), mw.messages.get( 'mediawiki-test-wikieditor-toolbar-help-content-signature-result' ), 'HTML message with curly braces is not changed in plain mode' );

	assertMultipleFormats( ['gender-plural-msg', 'male', 1], ['text', 'parse', 'escaped'], 'he is awesome', 'Gender and plural are resolved' );
	assert.equal( mw.message( 'gender-plural-msg', 'male', 1 ).plain(), '{{GENDER:male|he|she|they}} {{PLURAL:1|is|are}} awesome', 'Parameters are substituted, but gender and plural are not resolved in plain mode' );

	assert.equal( mw.message( 'grammar-msg' ).plain(), mw.messages.get( 'grammar-msg' ), 'Grammar is not resolved in plain mode' );
	assertMultipleFormats( ['grammar-msg'], ['text', 'parse'], 'Przeszukaj ' + mw.config.get( 'wgSiteName' ), 'Grammar is resolved' );
	assert.equal( mw.message( 'grammar-msg' ).escaped(), 'Przeszukaj ' + mw.html.escape( mw.config.get( 'wgSiteName' ) ), 'Grammar is resolved in escaped mode' );

	assertMultipleFormats( ['formatnum-msg', '987654321.654321'], ['text', 'parse', 'escaped'], '987,654,321.654', 'formatnum is resolved' );
	assert.equal( mw.message( 'formatnum-msg' ).plain(), mw.messages.get( 'formatnum-msg' ), 'formatnum is not resolved in plain mode' );

	assertMultipleFormats( ['int-msg'], ['text', 'parse', 'escaped'], 'Some Other Message', 'int is resolved' );
	assert.equal( mw.message( 'int-msg' ).plain(), mw.messages.get( 'int-msg' ), 'int is not resolved in plain mode' );

	assert.ok( mw.messages.set( 'mediawiki-italics-msg', '<i>Very</i> important' ),	'mw.messages.set: Register' );
	assertMultipleFormats( ['mediawiki-italics-msg'], ['plain', 'text', 'parse'], mw.messages.get( 'mediawiki-italics-msg' ), 'Simple italics unchanged' );
	assert.htmlEqual(
		mw.message( 'mediawiki-italics-msg' ).escaped(),
		'&lt;i&gt;Very&lt;/i&gt; important',
		'Italics are escaped in	escaped mode'
	);

	assert.ok( mw.messages.set( 'mediawiki-italics-with-link', 'An <i>italicized [[link|wiki-link]]</i>' ), 'mw.messages.set: Register' );
	assertMultipleFormats( ['mediawiki-italics-with-link'], ['plain', 'text'], mw.messages.get( 'mediawiki-italics-with-link' ), 'Italics with link unchanged' );
	assert.htmlEqual(
		mw.message( 'mediawiki-italics-with-link' ).escaped(),
		'An &lt;i&gt;italicized [[link|wiki-link]]&lt;/i&gt;',
		'Italics and link unchanged except for escaping in escaped mode'
	);
	assert.htmlEqual(
		mw.message( 'mediawiki-italics-with-link' ).parse(),
		'An <i>italicized <a title="link" href="' + mw.util.getUrl( 'link' ) + '">wiki-link</i>',
		'Italics with link inside in parse mode'
	);

	assert.ok( mw.messages.set( 'mediawiki-script-msg', '<script  >alert( "Who put this script here?" );</script>' ), 'mw.messages.set: Register' );
	assertMultipleFormats( ['mediawiki-script-msg'], ['plain', 'text'], mw.messages.get( 'mediawiki-script-msg' ), 'Script unchanged' );
	assert.htmlEqual(
		mw.message( 'mediawiki-script-msg' ).escaped(),
		'&lt;script  &gt;alert( "Who put this script here?" );&lt;/script&gt;',
		'Script escaped when using escaped format'
	);
	assert.htmlEqual(
		mw.message( 'mediawiki-script-msg' ).parse(),
		'&lt;script  &gt;alert( "Who put this script here?" );&lt;/script&gt;',
		'Script escaped when using parse format'
	);
});

test( 'mw.msg', function() {
	expect(11);

	ok( mw.messages.set( 'hello', 'Hello <b>awesome</b> world' ), 'mw.messages.set: Register' );
	equal( mw.msg( 'hello' ), 'Hello <b>awesome</b> world', 'Gets message with default options (existing message)' );
	equal( mw.msg( 'goodbye' ), '<goodbye>', 'Gets message with default options (nonexistent message)' );

	ok( mw.messages.set( 'plural-item' , 'Found $1 {{PLURAL:$1|item|items}}' ) );
	equal( mw.msg( 'plural-item', 5 ), 'Found 5 items', 'Apply plural for count 5' );
	equal( mw.msg( 'plural-item', 0 ), 'Found 0 items', 'Apply plural for count 0' );
	equal( mw.msg( 'plural-item', 1 ), 'Found 1 item', 'Apply plural for count 1' );

	ok( mw.messages.set('gender-plural-msg' , '{{GENDER:$1|he|she|they}} {{PLURAL:$2|is|are}} awesome' ) );
	equal( mw.msg( 'gender-plural-msg', 'male', 1 ), 'he is awesome', 'Gender test for male, plural count 1' );
	equal( mw.msg( 'gender-plural-msg', 'female', '1' ), 'she is awesome', 'Gender test for female, plural count 1' );
	equal( mw.msg( 'gender-plural-msg', 'unknown', 10 ), 'they are awesome', 'Gender test for neutral, plural count 10' );

});

test( 'mw.loader', function() {
	expect(1);

	// Asynchronous ahead
	stop();

	mw.loader.implement( 'is.awesome', [QUnit.fixurl( mw.config.get( 'wgScriptPath' ) + '/tests/qunit/data/defineTestCallback.js' )], {}, {} );

	mw.loader.using( 'is.awesome', function() {

		// /sample/awesome.js declares the "mw.loader.testCallback" function
		// which contains a call to start() and ok()
		mw.loader.testCallback();
		mw.loader.testCallback = undefined;

	}, function() {
		start();
		ok( false, 'Error callback fired while implementing "is.awesome" module' );
	});

});

test( 'mw.loader.bug29107' , function() {
	expect(2);

	// Message doesn't exist already
	ok( !mw.messages.exists( 'bug29107' ) );

	// Async! Failure in this test may lead to neither the success nor error callbacks getting called.
	// Due to QUnit's timeout feauture we won't hang here forever if this happends.
	stop();

	mw.loader.implement( 'bug29107.messages-only', [], {}, {'bug29107': 'loaded'} );
	mw.loader.using( 'bug29107.messages-only', function() {
		start();
		ok( mw.messages.exists( 'bug29107' ), 'Bug 29107: messages-only module should implement ok' );
	}, function() {
		start();
		ok( false, 'Error callback fired while implementing "bug29107.messages-only" module' );
	});
});

test( 'mw.loader.bug30825', function() {
	// This bug was actually already fixed in 1.18 and later when discovered in 1.17.
	// Test is for regressions!

	expect(2);

	// Forge an URL to the test callback script
	var target = QUnit.fixurl(
		mw.config.get( 'wgServer' ) + mw.config.get( 'wgScriptPath' ) + '/tests/qunit/data/qunitOkCall.js'
	);

	// Confirm that mw.loader.load() works with protocol-relative URLs
	target = target.replace( /https?:/, '' );

	equal( target.substr( 0, 2 ), '//',
		'URL must be relative to test relative URLs!'
	);

	// Async!
	stop();
	mw.loader.load( target );
});

test( 'mw.html', function() {
	expect(11);

	raises( function(){
		mw.html.escape();
	}, TypeError, 'html.escape throws a TypeError if argument given is not a string' );

	equal( mw.html.escape( '<mw awesome="awesome" value=\'test\' />' ),
		'&lt;mw awesome=&quot;awesome&quot; value=&#039;test&#039; /&gt;', 'html.escape escapes html snippet' );

	equal( mw.html.element(),
		'<undefined/>', 'html.element Always return a valid html string (even without arguments)' );

	equal( mw.html.element( 'div' ), '<div/>', 'html.element DIV (simple)' );

	equal(
		mw.html.element(
			'div', {
				id: 'foobar'
			}
		),
		'<div id="foobar"/>',
		'html.element DIV (attribs)' );

	equal( mw.html.element( 'p', null, 12 ), '<p>12</p>', 'Numbers are valid content and should be casted to a string' );

	equal( mw.html.element( 'p', { title: 12 }, '' ), '<p title="12"></p>', 'Numbers are valid attribute values' );

	equal(
		mw.html.element(
			'option', {
				selected: true
			}, 'Foo'
		),
		'<option selected="selected">Foo</option>',
		'Attributes may have boolean values. True copies the attribute name to the value.'
	);

	equal(
		mw.html.element(
			'option', {
				value: 'foo',
				selected: false
			}, 'Foo'
		),
		'<option value="foo">Foo</option>',
		'Attributes may have boolean values. False keeps the attribute from output.'
	);

	equal( mw.html.element( 'div',
			null, 'a' ),
		'<div>a</div>',
		'html.element DIV (content)' );

	equal( mw.html.element( 'a',
			{ href: 'http://mediawiki.org/w/index.php?title=RL&action=history' }, 'a' ),
		'<a href="http://mediawiki.org/w/index.php?title=RL&amp;action=history">a</a>',
		'html.element DIV (attribs + content)' );

});
