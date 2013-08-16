/*!
 * VisualEditor DataModel TextNode tests.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.dm.TextNode' );

/* Tests */

QUnit.test( 'getOuterLength', 2, function ( assert ) {
	var node1 = new ve.dm.TextNode(),
		node2 = new ve.dm.TextNode( 1234 );

	assert.strictEqual( node1.getOuterLength(), 0 );
	assert.strictEqual( node2.getOuterLength(), 1234 );
} );
