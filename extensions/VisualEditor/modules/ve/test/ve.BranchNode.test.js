/*!
 * VisualEditor BranchNode tests.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.BranchNode' );

/* Stubs */

ve.BranchNodeStub = function VeBranchNodeStub( children ) {
	ve.BranchNode.call( this, children );
};

ve.inheritClass( ve.BranchNodeStub, ve.Node );
ve.mixinClass( ve.BranchNodeStub, ve.BranchNode );

/* Tests */

QUnit.test( 'getChildren', 2, function ( assert ) {
	var node1 = new ve.BranchNodeStub(),
		node2 = new ve.BranchNodeStub( [node1] );
	assert.deepEqual( node1.getChildren(), [] );
	assert.deepEqual( node2.getChildren(), [node1] );
} );

QUnit.test( 'indexOf', 4, function ( assert ) {
	var node1 = new ve.BranchNodeStub(),
		node2 = new ve.BranchNodeStub(),
		node3 = new ve.BranchNodeStub(),
		node4 = new ve.BranchNodeStub( [node1, node2, node3] );
	assert.strictEqual( node4.indexOf( null ), -1 );
	assert.strictEqual( node4.indexOf( node1 ), 0 );
	assert.strictEqual( node4.indexOf( node2 ), 1 );
	assert.strictEqual( node4.indexOf( node3 ), 2 );
} );
