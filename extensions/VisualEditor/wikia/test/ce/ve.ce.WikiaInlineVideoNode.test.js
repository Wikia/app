/*!
 * VisualEditor ContentEditable WikiaInlineVideoNode tests.
 */

QUnit.module( 've.ce.WikiaInlineVideoNode', ve.wikiaTest.utils.disableDebugModeForTests() );

/* Tests */

QUnit.test( 'Build NodeView from HTMLDOM', function ( assert ) {
	ve.wikiaTest.utils.media.runHtmlDomToNodeViewTests(
		assert,
		'inline',
		'mw:Video',
		function( documentNode ) {
			return documentNode.getChildren()[0].getChildren()[0];
		}
	);
} );

QUnit.test( 'NodeView Transactions', function ( assert ) {
	ve.wikiaTest.utils.media.runNodeViewTransactionTests(
		assert,
		'inline',
		'mw:Video',
		function( documentNode ) {
			return documentNode.getChildren()[0].getChildren()[0];
		}
	);
} );