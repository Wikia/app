/*!
 * VisualEditor ContentEditable LeafNode tests.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

QUnit.module( 've.ce.LeafNode' );

/* Stubs */

ve.ce.LeafNodeStub = function VeCeLeafNodeStub( model ) {
	// Parent constructor
	ve.ce.LeafNode.call( this, model );
};

OO.inheritClass( ve.ce.LeafNodeStub, ve.ce.LeafNode );

ve.ce.LeafNodeStub.static.name = 'leaf-stub';

ve.ce.nodeFactory.register( ve.ce.LeafNodeStub );

/* Tests */

QUnit.test( 'splitOnEnter', function ( assert ) {
	assert.expect( 1 );
	var node = new ve.ce.LeafNodeStub( new ve.dm.LeafNodeStub() );
	assert.strictEqual( node.splitOnEnter(), false );
} );

QUnit.test( 'canHaveChildren', function ( assert ) {
	assert.expect( 1 );
	var node = new ve.ce.LeafNodeStub( new ve.dm.LeafNodeStub() );
	assert.strictEqual( node.canHaveChildren(), false );
} );

QUnit.test( 'canHaveChildrenNotContent', function ( assert ) {
	assert.expect( 1 );
	var node = new ve.ce.LeafNodeStub( new ve.dm.LeafNodeStub() );
	assert.strictEqual( node.canHaveChildrenNotContent(), false );
} );
