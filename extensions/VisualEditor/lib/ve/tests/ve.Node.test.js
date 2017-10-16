/*!
 * VisualEditor Node tests.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

QUnit.module( 've.Node' );

/* Stubs */

ve.NodeStub = function VeNodeStub() {
	// Parent constructor
	ve.Node.call( this );
};

OO.inheritClass( ve.NodeStub, ve.Node );

ve.NodeStub.static.name = 'stub';

/* Tests */

QUnit.test( 'getType', function ( assert ) {
	assert.expect( 1 );
	var node = new ve.NodeStub();
	assert.strictEqual( node.getType(), 'stub' );
} );

QUnit.test( 'getParent', function ( assert ) {
	assert.expect( 1 );
	var node = new ve.NodeStub();
	assert.strictEqual( node.getParent(), null );
} );

QUnit.test( 'getRoot', function ( assert ) {
	assert.expect( 1 );
	var node = new ve.NodeStub();
	assert.strictEqual( node.getRoot(), null );
} );
