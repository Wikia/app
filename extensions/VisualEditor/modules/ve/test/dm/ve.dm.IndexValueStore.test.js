/*!
 * VisualEditor IndexValueStore tests.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.dm.IndexValueStore' );

/* Tests */

QUnit.test( 'index(es)/indexOfHash', 12, function ( assert ) {
	var index, indexes,
		object1 = { 'a': 1, 'b': 2 },
		object2 = { 'c': 3, 'd': 4 },
		store = new ve.dm.IndexValueStore();

	index = store.index( object1 );
	assert.equal( index, 0, 'First object stores in 0' );
	index = store.index( object1 );
	assert.equal( index, 0, 'First object re-stores in 0' );
	index = store.index( object2 );
	assert.equal( index, 1, 'Second object stores in 1' );
	assert.deepEqual( store.value( 0 ), object1, '0th item is first object' );

	index = store.index( object2, 'custom hash string' );
	assert.equal( index, 2, 'Second object with custom hash stores in 2' );
	index = store.index( object1, 'custom hash string' );
	assert.equal( index, 2, 'Using the same custom hash with a different object returns index 2 again' );
	assert.deepEqual( store.value( 2 ), object2, 'Second object was not overwritten' );

	index = store.index( object1, 'custom hash string', true );
	assert.deepEqual( store.value( index ), object1, 'Second object is overwritten when overwrite flag is set' );

	assert.equal( store.indexOfHash( 'custom hash string' ), 2, 'Index of custom hash is 2' );
	assert.equal( store.indexOfHash( 'unused hash string' ), null, 'Index of unused hash is null' );

	store = new ve.dm.IndexValueStore();

	indexes = store.indexes( [ object1, object2 ] );
	assert.deepEqual( indexes, [ 0, 1 ], 'Store two objects in 0,1' );

	store = new ve.dm.IndexValueStore();

	index = store.index( 'String to store' );
	assert.equal( store.value( 0 ), 'String to store', 'Strings are stored as strings, not objects' );

} );

QUnit.test( 'value(s)', 5, function ( assert ) {
	var object1 = { 'a': 1, 'b': 2 },
		object2 = { 'c': 3, 'd': 4 },
		store = new ve.dm.IndexValueStore();

	store.index( object1 );
	store.index( object2 );
	assert.deepEqual( store.value( 0 ), object1, 'Value 0 is first stored object' );
	assert.deepEqual( store.value( 1 ), object2, 'Value 1 is second stored object' );
	assert.equal( store.value( 2 ), undefined, 'Value 2 is undefined' );
	assert.deepEqual( store.values( [1, 0] ), [ object2, object1 ], 'Values [1, 0] are second and first object' );
	object1.a = 3;
	assert.deepEqual( store.value( 0 ), { 'a': 1, 'b': 2 }, 'Value 0 is still first stored object after original has been modified' );
} );


