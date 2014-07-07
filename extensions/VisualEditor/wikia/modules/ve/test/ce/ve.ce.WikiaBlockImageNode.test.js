/*!
 * VisualEditor ContentEditable WikiaBlockImageNode tests.
 */

QUnit.module( 've.ce.WikiaBlockImageNode', ve.wikiaTest.utils.disableDebugModeForTests() );

/* Tests */

QUnit.test( 'Build NodeView from HTMLDOM', function ( assert ) {
	ve.wikiaTest.utils.media.runHtmlDomToNodeViewTests(
		assert,
		'block',
		'mw:Image',
		function( documentNode ) {
			return documentNode.getChildren()[0];
		}
	);
} );

QUnit.test( 'NodeView Transactions', function ( assert ) {
	ve.wikiaTest.utils.media.runNodeViewTransactionTests(
		assert,
		'block',
		'mw:Image',
		function( documentNode ) {
			return documentNode.getChildren()[0];
		}
	);
} );