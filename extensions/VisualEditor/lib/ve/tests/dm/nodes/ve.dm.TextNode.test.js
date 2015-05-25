/*!
 * VisualEditor DataModel TextNode tests.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

QUnit.module( 've.dm.TextNode' );

/* Tests */

QUnit.test( 'getOuterLength', 2, function ( assert ) {
	var node1 = new ve.dm.TextNode(),
		node2 = new ve.dm.TextNode();

	node2.setLength( 1234 );

	assert.strictEqual( node1.getOuterLength(), 0 );
	assert.strictEqual( node2.getOuterLength(), 1234 );
} );
