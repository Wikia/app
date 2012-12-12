/**
 * VisualEditor data model LeafNode tests.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.dm.LeafNode' );

/* Stubs */

ve.dm.LeafNodeStub = function VeDmLeafNodeStub() {
	// Parent constructor
	ve.dm.LeafNode.call( this, 'leaf-stub' );
};

ve.inheritClass( ve.dm.LeafNodeStub, ve.dm.LeafNode );

ve.dm.LeafNodeStub.rules = {
	'isWrapped': true,
	'isContent': true,
	'canContainContent': false,
	'childNodeTypes': []
};

ve.dm.LeafNodeStub.converters = null;
ve.dm.nodeFactory.register( 'leaf-stub', ve.dm.LeafNodeStub );

/* Tests */

QUnit.test( 'canHaveChildren', 1, function ( assert ) {
	var node = new ve.dm.LeafNodeStub();
	assert.equal( node.canHaveChildren(), false );
} );

QUnit.test( 'canHaveGrandchildren', 1, function ( assert ) {
	var node = new ve.dm.LeafNodeStub();
	assert.equal( node.canHaveGrandchildren(), false );
} );
