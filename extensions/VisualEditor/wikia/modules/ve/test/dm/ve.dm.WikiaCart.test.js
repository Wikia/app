/*!
 * VisualEditor DataModel WikiaCart tests.
 */

QUnit.module( 've.dm.WikiaCart' );

/* Tests */

QUnit.test( 've.dm.WikiaCart.addItems', function ( assert ) {
	var item1 = 'item1',
		item2 = 'item2',
		item3 = 'item3',
		items = [ item1, item2, item3 ],
		cartModel = new ve.dm.WikiaCart()

	cartModel.connect( this, { 
		'add': function( o ) {
			assert.deepEqual( o, items, 'Event "add" trigged with correct data' );
		},
		'remove': function( o ) {
			assert.deepEqual( o, items, 'Event "remove" trigged with correct data' );
		}
	} );
	cartModel.addItems( items );
	QUnit.expect(2);
} );


QUnit.test( 've.dm.WikiaCart.removeItems', function ( assert ) {
	var item1 = 'item1',
		item2 = 'item2',
		item3 = 'item3',
		items = [ item1, item2, item3 ],
		cartModel = new ve.dm.WikiaCart()

	cartModel.addItems( items );
	cartModel.connect( this, { 
		'add': function( o ) {
			ok( false )
		},
		'remove': function( o ) {
			assert.deepEqual( o, [ item1 ], 'Event "remove" trigged with correct data' );
		}
	} );
	cartModel.removeItems( [ item1 ] );
	QUnit.expect(1);
} );

QUnit.test( 've.dm.WikiaCart.clearItems', function ( assert ) {
	var item1 = 'item1',
		item2 = 'item2',
		item3 = 'item3',
		items = [ item1, item2, item3 ],
		cartModel = new ve.dm.WikiaCart()

	cartModel.addItems( items );
	cartModel.removeItems( [ item1 ] );
	cartModel.connect( this, { 
		'add': function( o ) {
			ok( false )
		},
		'remove': function( o ) {
			assert.deepEqual( o, [ item2, item3 ], 'Event "remove" trigged with correct data' );
		}
	} );
	cartModel.clearItems( [ item1 ] );
	QUnit.expect(1);
} );

