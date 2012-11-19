/**
 * VisualEditor data model Node tests.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.dm.Node' );

/* Stubs */

ve.dm.NodeStub = function VeDmNodeStub( length, attributes ) {
	// Parent constructor
	ve.dm.Node.call( this, 'stub', length, attributes );
};

ve.inheritClass( ve.dm.NodeStub, ve.dm.Node );

ve.dm.NodeStub.rules = {
	'isWrapped': true,
	'isContent': true,
	'canContainContent': false,
	'childNodeTypes': []
};

ve.dm.NodeStub.converters = null;

ve.dm.nodeFactory.register( 'stub', ve.dm.NodeStub );

/* Tests */

QUnit.test( 'canHaveChildren', 1, function ( assert ) {
	var node = new ve.dm.NodeStub();
	assert.equal( node.canHaveChildren(), false );
} );

QUnit.test( 'canHaveGrandchildren', 1, function ( assert ) {
	var node = new ve.dm.NodeStub();
	assert.equal( node.canHaveGrandchildren(), false );
} );

QUnit.test( 'getLength', 2, function ( assert ) {
	var node1 = new ve.dm.NodeStub(),
		node2 = new ve.dm.NodeStub( 1234 );
	assert.strictEqual( node1.getLength(), 0 );
	assert.strictEqual( node2.getLength(), 1234 );
} );

QUnit.test( 'getOuterLength', 2, function ( assert ) {
	var node1 = new ve.dm.NodeStub(),
		node2 = new ve.dm.NodeStub( 1234 );
	assert.strictEqual( node1.getOuterLength(), 2 );
	assert.strictEqual( node2.getOuterLength(), 1236 );
} );

QUnit.test( 'setLength', 2, function ( assert ) {
	var node = new ve.dm.NodeStub();
	node.setLength( 1234 );
	assert.strictEqual( node.getLength(), 1234 );
	assert.throws(
		function () {
			// Length can not be negative
			node.setLength( -1 );
		},
		Error,
		'throws exception if length is negative'
	);
} );

QUnit.test( 'adjustLength', 1, function ( assert ) {
	var node = new ve.dm.NodeStub( 1234 );
	node.adjustLength( 5678 );
	assert.strictEqual( node.getLength(), 6912 );
} );

QUnit.test( 'getAttribute', 2, function ( assert ) {
	var node = new ve.dm.NodeStub( 0, { 'a': 1, 'b': 2 } );
	assert.strictEqual( node.getAttribute( 'a' ), 1 );
	assert.strictEqual( node.getAttribute( 'b' ), 2 );
} );

QUnit.test( 'setRoot', 1, function ( assert ) {
	var node1 = new ve.dm.NodeStub(),
		node2 = new ve.dm.NodeStub();
	node1.setRoot( node2 );
	assert.strictEqual( node1.getRoot(), node2 );
} );

QUnit.test( 'attach', 2, function ( assert ) {
	var node1 = new ve.dm.NodeStub(),
		node2 = new ve.dm.NodeStub();
	node1.attach( node2 );
	assert.strictEqual( node1.getParent(), node2 );
	assert.strictEqual( node1.getRoot(), node2 );
} );

QUnit.test( 'detach', 2, function ( assert ) {
	var node1 = new ve.dm.NodeStub(),
		node2 = new ve.dm.NodeStub();
	node1.attach( node2 );
	node1.detach();
	assert.strictEqual( node1.getParent(), null );
	assert.strictEqual( node1.getRoot(), node1 );
} );

QUnit.test( 'canBeMergedWith', 4, function ( assert ) {
	var node1 = new ve.dm.LeafNodeStub(),
		node2 = new ve.dm.BranchNodeStub( [node1] ),
		node3 = new ve.dm.BranchNodeStub( [node2] ),
		node4 = new ve.dm.LeafNodeStub(),
		node5 = new ve.dm.BranchNodeStub( [node4] );

	assert.strictEqual( node3.canBeMergedWith( node5 ), true, 'same level, same type' );
	assert.strictEqual( node2.canBeMergedWith( node5 ), false, 'different level, same type' );
	assert.strictEqual( node2.canBeMergedWith( node1 ), false, 'different level, different type' );
	assert.strictEqual( node2.canBeMergedWith( node4 ), false, 'same level, different type' );
} );
