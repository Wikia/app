/*!
 * VisualEditor DataModel LeafNode tests.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

QUnit.module( 've.dm.LeafNode' );

/* Stubs */

ve.dm.LeafNodeStub = function VeDmLeafNodeStub() {
	// Parent constructor
	ve.dm.LeafNode.apply( this, arguments );
};

OO.inheritClass( ve.dm.LeafNodeStub, ve.dm.LeafNode );

ve.dm.LeafNodeStub.static.name = 'leaf-stub';

ve.dm.LeafNodeStub.static.matchTagNames = [];

ve.dm.nodeFactory.register( ve.dm.LeafNodeStub );

/* Tests */

QUnit.test( 'canHaveChildren', function ( assert ) {
	assert.expect( 1 );
	var node = new ve.dm.LeafNodeStub();
	assert.strictEqual( node.canHaveChildren(), false );
} );

QUnit.test( 'canHaveChildrenNotContent', function ( assert ) {
	assert.expect( 1 );
	var node = new ve.dm.LeafNodeStub();
	assert.strictEqual( node.canHaveChildrenNotContent(), false );
} );

QUnit.test( 'getAnnotations', function ( assert ) {
	assert.expect( 3 );
	var element = { type: 'leaf-stub' },
		node = new ve.dm.LeafNodeStub( element );
	assert.deepEqual( node.getAnnotations(), [], 'undefined .annotations returns empty set' );
	assert.strictEqual( element.annotations, undefined, 'no .annotations property added' );
	element.annotations = [0];
	assert.deepEqual( node.getAnnotations(), [0], 'annotations retrieve indexes when set' );
} );
