/*!
 * VisualEditor Node tests.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.Node' );

/* Stubs */

ve.NodeStub = function VeNodeStub() {
	// Parent constructor
	ve.Node.call( this );
};

ve.inheritClass( ve.NodeStub, ve.Node );

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
