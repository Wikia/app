/**
 * VisualEditor content editable LeafNode tests.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.ce.LeafNode' );

/* Stubs */

ve.ce.LeafNodeStub = function VeCeLeafNodeStub( model ) {
	// Parent constructor
	ve.ce.LeafNode.call( this, 'leaf-stub', model );
};

ve.inheritClass( ve.ce.LeafNodeStub, ve.ce.LeafNode );

ve.ce.LeafNodeStub.rules = {
	'canBeSplit': false
};

ve.ce.nodeFactory.register( 'leaf-stub', ve.ce.LeafNodeStub );

/* Tests */

QUnit.test( 'canBeSplit', 1, function ( assert ) {
	var node = new ve.ce.LeafNodeStub( new ve.dm.LeafNodeStub() );
	assert.equal( node.canBeSplit(), false );
} );

QUnit.test( 'canHaveChildren', 1, function ( assert ) {
	var node = new ve.ce.LeafNodeStub( new ve.dm.LeafNodeStub() );
	assert.equal( node.canHaveChildren(), false );
} );

QUnit.test( 'canHaveGrandchildren', 1, function ( assert ) {
	var node = new ve.ce.LeafNodeStub( new ve.dm.LeafNodeStub() );
	assert.equal( node.canHaveGrandchildren(), false );
} );
