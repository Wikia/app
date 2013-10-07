/*!
 * VisualEditor initialization tests.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.init.Platform', {
	setup: function () {
		this.platform = ve.init.platform;

		// Clone and deference instance
		ve.init.platform = ve.cloneObject( ve.init.platform );

		// Reset internal properties needed to keep tests atomic
		ve.init.platform.parsedMessages = {};

		// Platform specific properties
		// TODO: Perhaps this warrants a clearMessages() method?
		if ( ve.init.sa && ve.init.platform instanceof ve.init.sa.Platform ) {
			ve.init.platform.messages = {};
		} else if ( ve.init.mw && ve.init.platform instanceof ve.init.mw.Platform ) {
			/*global mw */
			this.mwMessagesValues = ve.copy( mw.messages.values );
		}
	},
	teardown: function () {
		ve.init.platform = this.platform;
		if ( ve.init.mw && ve.init.platform instanceof ve.init.mw.Platform ) {
			/*global mw */
			mw.messages.values = this.mwMessagesValues;
		}
	}
} );

QUnit.test( 'messages', 4, function ( assert ) {
	var platform = ve.init.platform;

	assert.strictEqual(
		platform.getMessage( 'foo' ),
		'<foo>',
		'return bracket-wrapped key as fallback'
	);

	platform.addMessages( {
		foo: 'Foo & Bar <quux action="followed">by</quux>!',
		bacon: 'Bacon <&> Ipsum: $1'
	} );

	assert.strictEqual(
		platform.getMessage( 'foo' ),
		'Foo & Bar <quux action="followed">by</quux>!',
		'return plain message'
	);

	assert.strictEqual(
		platform.getMessage( 'bacon', 10 ),
		'Bacon <&> Ipsum: 10',
		'return plain message with $# replacements'
	);

	assert.strictEqual(
		platform.getMessage( 'quux' ),
		'<quux>',
		'return bracket-wrapped key as fallback (after set up)'
	);
} );

QUnit.test( 'parsedMessage', 3, function ( assert ) {
	var platform = ve.init.platform;

	assert.strictEqual(
		platform.getParsedMessage( 'foo' ),
		'&lt;foo&gt;',
		'return html escaped brackets in wrapped-key fallback'
	);

	platform.addMessages( {
		foo: 'Foo & Bar <quux action="followed">by</quux>!',
		bacon: 'Bacon <&> Ipsum: $1'
	} );

	platform.addParsedMessages( {
		foo: 'Foo <quux>&lt;html&gt;</quux>'
	} );

	assert.strictEqual(
		platform.getParsedMessage( 'foo' ),
		'Foo <quux>&lt;html&gt;</quux>',
		'prefer value from parsedMessage store'
	);

	assert.strictEqual(
		platform.getParsedMessage( 'bacon', 10 ),
		'Bacon &lt;&amp;&gt; Ipsum: $1',
		'fall back to html-escaped version of plain message, no $# replacements'
	);
} );
