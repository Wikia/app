/*!
 * VisualEditor DataModel WikiaCart tests.
 */

QUnit.module( 've.dm.WikiaCart' );

QUnit.module( 've.dm.WikiaCart', {
	setup: function () {
		this.cartModel = new ve.dm.WikiaCart();
		this.item1 = 'item1';
		this.item2 = 'item2';
		this.item3 = 'item3';
		this.items = [ this.item1, this.item2, this.item3 ];
	}
} );

/* Tests */

QUnit.test( 'addItems', function ( assert ) {
	this.cartModel.connect( this, {
		'add': function ( o ) {
			assert.deepEqual( o, this.items, 'Event "add" trigged with correct data' );
		},
		'remove': function ( o ) {
			assert.deepEqual( o, this.items, 'Event "remove" trigged with correct data' );
		}
	} );
	this.cartModel.addItems( this.items );
	assert.deepEqual( this.cartModel.getItems(), this.items );
	QUnit.expect( 3 );
} );

QUnit.test( 'removeItems', function ( assert ) {
	this.cartModel.addItems( this.items );
	this.cartModel.connect( this, {
		'add': function () {
			assert.ok( false );
		},
		'remove': function ( o ) {
			assert.deepEqual( o, [ this.item1 ], 'Event "remove" trigged with correct data' );
		}
	} );
	this.cartModel.removeItems( [ this.item1 ] );
	assert.deepEqual( this.cartModel.getItems(), [ this.item2, this.item3 ] );
	QUnit.expect( 2 );
} );

QUnit.test( 'clearItems', function ( assert ) {
	this.cartModel.addItems( this.items );
	this.cartModel.removeItems( [ this.item1 ] );
	this.cartModel.connect( this, {
		'add': function () {
			assert.ok( false );
		},
		'remove': function ( o ) {
			assert.deepEqual( o, [ this.item2, this.item3 ], 'Event "remove" trigged with correct data' );
		}
	} );
	this.cartModel.clearItems( [ this.item1 ] );
	assert.deepEqual( this.cartModel.getItems(), [] );
	QUnit.expect( 2 );
} );
