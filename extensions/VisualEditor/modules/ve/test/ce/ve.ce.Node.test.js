/*!
 * VisualEditor ContentEditable Node tests.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.ce.Node' );

/* Stubs */

ve.ce.NodeStub = function VeCeNodeStub( model ) {
	// Parent constructor
	ve.ce.Node.call( this, model );
};

ve.inheritClass( ve.ce.NodeStub, ve.ce.Node );

ve.ce.NodeStub.static.name = 'stub';

ve.ce.nodeFactory.register( ve.ce.NodeStub );

/* Tests */

QUnit.test( 'getModel', 1, function ( assert ) {
	var model = new ve.dm.NodeStub( 'stub', 0 ),
		view = new ve.ce.NodeStub( model );
	assert.strictEqual( view.getModel(), model, 'returns reference to model given to constructor' );
} );

QUnit.test( 'getParent', 1, function ( assert ) {
	var a = new ve.ce.NodeStub( new ve.dm.NodeStub( 'stub', 0 ) );
	assert.strictEqual( a.getParent(), null, 'returns null if not attached' );
} );

QUnit.test( 'attach', 2, function ( assert ) {
	var a = new ve.ce.NodeStub( new ve.dm.NodeStub( 'stub', 0 ) ),
		b = new ve.ce.NodeStub( new ve.dm.NodeStub( 'stub', 0 ) );
	a.on( 'attach', function ( parent ) {
		assert.strictEqual( parent, b, 'attach event is called with parent as first argument' );
	} );
	a.attach( b );
	assert.strictEqual( a.getParent(), b, 'parent is set to given object after attach' );
} );

QUnit.test( 'detach', 2, function ( assert ) {
	var a = new ve.ce.NodeStub( new ve.dm.NodeStub( 'stub', 0 ) ),
		b = new ve.ce.NodeStub( new ve.dm.NodeStub( 'stub', 0 ) );
	a.attach( b );
	a.on( 'detach', function ( parent ) {
		assert.strictEqual( parent, b, 'detach event is called with parent as first argument' );
	} );
	a.detach();
	assert.strictEqual( a.getParent(), null, 'parent is set null after detach' );
} );
