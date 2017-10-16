/*!
 * VisualEditor ContentEditable Node tests.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

QUnit.module( 've.ce.Node' );

/* Stubs */

ve.ce.NodeStub = function VeCeNodeStub( model ) {
	// Parent constructor
	ve.ce.Node.call( this, model );
};

OO.inheritClass( ve.ce.NodeStub, ve.ce.Node );

ve.ce.NodeStub.static.name = 'stub';

ve.ce.nodeFactory.register( ve.ce.NodeStub );

/* Tests */

QUnit.test( 'getModel', function ( assert ) {
	assert.expect( 1 );
	var model = new ve.dm.NodeStub(),
		view = new ve.ce.NodeStub( model );
	assert.strictEqual( view.getModel(), model, 'returns reference to model given to constructor' );
} );

QUnit.test( 'getParent', function ( assert ) {
	assert.expect( 1 );
	var a = new ve.ce.NodeStub( new ve.dm.NodeStub() );
	assert.strictEqual( a.getParent(), null, 'returns null if not attached' );
} );

QUnit.test( 'attach', function ( assert ) {
	assert.expect( 2 );
	var a = new ve.ce.NodeStub( new ve.dm.NodeStub() ),
		b = new ve.ce.NodeStub( new ve.dm.NodeStub() );
	a.on( 'attach', function ( parent ) {
		assert.strictEqual( parent, b, 'attach event is called with parent as first argument' );
	} );
	a.attach( b );
	assert.strictEqual( a.getParent(), b, 'parent is set to given object after attach' );
} );

QUnit.test( 'detach', function ( assert ) {
	assert.expect( 2 );
	var a = new ve.ce.NodeStub( new ve.dm.NodeStub() ),
		b = new ve.ce.NodeStub( new ve.dm.NodeStub() );
	a.attach( b );
	a.on( 'detach', function ( parent ) {
		assert.strictEqual( parent, b, 'detach event is called with parent as first argument' );
	} );
	a.detach();
	assert.strictEqual( a.getParent(), null, 'parent is set null after detach' );
} );
