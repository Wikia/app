/*!
 * VisualEditor LinearData tests.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.dm.LinearData' );

/* Tests */

QUnit.test( 'basic usage', 7, function ( assert ) {
	var store = new ve.dm.IndexValueStore(),
		data = new ve.dm.LinearData( store, ve.copy( ve.dm.example.data ) );

	assert.equal( data.getData(), data.data, 'getData: with no arguments returns data by reference' );
	assert.deepEqual( data.getData(), ve.dm.example.data, 'getData: full array matches source data' );
	assert.equal( data.getData( 10 ), data.data[10], 'getData: data at offset 10 is same as array[10]' );
	assert.equal( data.getData( -1 ), data.data[-1], 'getData: data at -1 is undefined' );

	data.setData( 1, 'x' );
	assert.equal( data.data[1], 'x', 'setData: data set at offset 1 changed' );
	assert.equal( data.getLength(), data.data.length, 'getLength: equal to array length' );
	assert.equal( data.getStore(), store, 'getStore: equal to original store by reference' );
} );

QUnit.test( 'slice(Object)/splice(Object)/batchSplice', 12, function ( assert ) {
	var dataSlice, expectedDataSlice,
		dataSplice, expectedDataSplice,
		store = new ve.dm.IndexValueStore(),
		data = new ve.dm.LinearData( store, ve.copy( ve.dm.example.data ) ),
		expectedData = ve.copy( ve.dm.example.data );

	assert.deepEqual( data.slice( 7, 22 ), expectedData.slice( 7, 22 ),
		'slice: result matches slice'
	);
	assert.deepEqual( data.getData(), expectedData,
		'slice: arrays match after slice'
	);
	dataSlice = data.sliceObject( 10, 12 );
	expectedDataSlice = new ve.dm.LinearData( store,
		expectedData.slice( 10, 12 )
	);
	assert.deepEqual( dataSlice.getData(), expectedDataSlice.getData(),
		'slice: matches data built with Array.slice'
	);
	assert.equal( dataSlice.getStore(), data.getStore(),
		'slice: store equal by reference to original object'
	);

	// reset data
	data = new ve.dm.LinearData( store, ve.copy( ve.dm.example.data ) );
	expectedData = ve.copy( ve.dm.example.data );

	assert.deepEqual( data.splice( 1, 3, 'x', 'y', 'z' ), expectedData.splice( 1, 3, 'x', 'y', 'z' ),
		'splice: result matches splice'
	);
	assert.deepEqual( data.getData(), expectedData,
		'splice: arrays match after splice'
	);
	dataSplice = data.spliceObject( 7, 3, 'x' );
	expectedDataSplice = new ve.dm.LinearData( store,
		expectedData.splice( 7, 3, 'x' )
	);
	assert.deepEqual( dataSplice.getData(), expectedDataSplice.getData(),
		'splice: matches data built with Array.splice'
	);
	assert.equal( dataSplice.getStore(), data.getStore(),
		'splice: store equal by reference to original object'
	);

	// reset data
	data = new ve.dm.LinearData( store, ve.copy( ve.dm.example.data ) );
	expectedData = ve.copy( ve.dm.example.data );

	assert.deepEqual(
		data.batchSplice( 1, 3, ['x', 'y', 'z'] ),
		ve.batchSplice( expectedData, 1, 3, ['x', 'y', 'z'] ),
		'batchSplice: result matches ve.batchSplice'
	);
	assert.deepEqual( data.getData(), expectedData, 'batchSplice: array matches after batch splice' );

	dataSplice = data.batchSpliceObject( 7, 3, 'x' );
	expectedDataSplice = new ve.dm.LinearData( store,
		ve.batchSplice( expectedData, 7, 3, 'x' )
	);
	assert.deepEqual( dataSplice.getData(), expectedDataSplice.getData(),
		'batchSplice: matches data built with ve.batchSplice'
	);
	assert.equal( dataSplice.getStore(), data.getStore(),
		'batchSplice: store equal by reference to original object'
	);

} );
