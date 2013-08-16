/*!
 * VisualEditor DataModel LeafNode tests.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.dm.LeafNode' );

/* Stubs */

ve.dm.LeafNodeStub = function VeDmLeafNodeStub( length, element ) {
	// Parent constructor
	ve.dm.LeafNode.call( this, length, element );
};

ve.inheritClass( ve.dm.LeafNodeStub, ve.dm.LeafNode );

ve.dm.LeafNodeStub.static.name = 'leaf-stub';

ve.dm.LeafNodeStub.static.matchTagNames = [];

ve.dm.nodeFactory.register( ve.dm.LeafNodeStub );

/* Tests */

QUnit.test( 'canHaveChildren', 1, function ( assert ) {
	var node = new ve.dm.LeafNodeStub();
	assert.equal( node.canHaveChildren(), false );
} );

QUnit.test( 'canHaveChildrenNotContent', 1, function ( assert ) {
	var node = new ve.dm.LeafNodeStub();
	assert.equal( node.canHaveChildrenNotContent(), false );
} );

QUnit.test( 'getAnnotations', 3, function ( assert ) {
	var element = { 'type': 'leaf-stub' },
		node = new ve.dm.LeafNodeStub( 0, element );
	assert.deepEqual( node.getAnnotations(), [], 'undefined .annotations returns empty set' );
	assert.equal( element.annotations, undefined, 'no .annotations property added' );
	element.annotations = [0];
	assert.deepEqual( node.getAnnotations(), [0] , 'annotations retrieve indexes when set' );
} );
