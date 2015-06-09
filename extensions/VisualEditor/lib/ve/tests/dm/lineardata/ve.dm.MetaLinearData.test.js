/*!
 * VisualEditor MetaLinearData tests.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

QUnit.module( 've.dm.MetaLinearData' );

/* Tests */

QUnit.test( 'basic usage', 6, function ( assert ) {
	var store = new ve.dm.IndexValueStore(),
		data = new ve.dm.MetaLinearData( store, ve.copy( ve.dm.example.withMetaMetaData ) );

	assert.strictEqual( data.getData(), data.data, 'getData: with no arguments returns data by reference' );
	assert.deepEqualWithDomElements( data.getData(), ve.dm.example.withMetaMetaData, 'getData: full array matches source data' );
	assert.deepEqualWithDomElements( data.getData( 0 ), data.data[0],
		'getData: get with one index returns array of meta elements at specified offset'
	);
	assert.deepEqualWithDomElements( data.getData( 11, 3 ), data.data[11][3],
		'getData: get with two indexes returns data at specified offset'
	);

	assert.strictEqual( data.getDataLength( 11 ), data.data[11].length, 'getDataLength: equal to array length at offset' );
	assert.strictEqual( data.getTotalDataLength(), 9, 'getTotalDataLength: equal to total number of meta items' );
} );
