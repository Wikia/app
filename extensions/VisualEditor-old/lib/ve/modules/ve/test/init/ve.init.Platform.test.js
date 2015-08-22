/*!
 * VisualEditor initialization tests.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.init.Platform' );

QUnit.asyncTest( 'messages', 4, function ( assert ) {
	var platform = ve.init.platform;

	platform.getInitializedPromise().done( function () {
		QUnit.start();
		assert.ok(
			/^<?platformtest-foo\>?$/.test( platform.getMessage( 'platformtest-foo' ) ),
			'return plain key as fallback, possibly wrapped in brackets'
		);

		platform.addMessages( {
			'platformtest-foo': 'Foo & Bar <quux action="followed">by</quux>!',
			'platformtest-bacon': 'Bacon <&> Ipsum: $1'
		} );

		assert.strictEqual(
			platform.getMessage( 'platformtest-foo' ),
			'Foo & Bar <quux action="followed">by</quux>!',
			'return plain message'
		);

		assert.strictEqual(
			platform.getMessage( 'platformtest-bacon', 10 ),
			'Bacon <&> Ipsum: 10',
			'return plain message with $# replacements'
		);

		assert.ok(
			/^<?platformtest-quux\>?$/.test( platform.getMessage( 'platformtest-quux' ) ),
			'return plain key as fallback, possibly wrapped in brackets (after set up)'
		);
	} );
} );

QUnit.asyncTest( 'parsedMessage', 3, function ( assert ) {
	var platform = ve.init.platform;

	platform.getInitializedPromise().done( function () {
		QUnit.start();
		assert.ok(
			/^(&lt;)?platformtest-quux(&gt;)?$/.test( platform.getParsedMessage( 'platformtest-quux' ) ),
			'any brackets in fallbacks are HTML-escaped'
		);

		platform.addMessages( {
			'platformtest-foo': 'Foo & Bar <quux action="followed">by</quux>!',
			'platformtest-bacon': 'Bacon <&> Ipsum: $1'
		} );

		platform.addParsedMessages( {
			'platformtest-foo': 'Foo <quux>&lt;html&gt;</quux>'
		} );

		assert.strictEqual(
			platform.getParsedMessage( 'platformtest-foo' ),
			'Foo <quux>&lt;html&gt;</quux>',
			'prefer value from parsedMessage store'
		);

		assert.strictEqual(
			platform.getParsedMessage( 'platformtest-bacon', 10 ),
			'Bacon &lt;&amp;&gt; Ipsum: $1',
			'fall back to html-escaped version of plain message, no $# replacements'
		);
	} );
} );
