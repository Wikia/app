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

QUnit.test( 'getType', 1, function ( assert ) {
	var node = new ve.NodeStub();
	assert.strictEqual( node.getType(), 'stub' );
} );

QUnit.test( 'getParent', 1, function ( assert ) {
	var node = new ve.NodeStub();
	assert.strictEqual( node.getParent(), null );
} );

QUnit.test( 'getRoot', 1, function ( assert ) {
	var node = new ve.NodeStub();
	assert.strictEqual( node.getRoot(), null );
} );
