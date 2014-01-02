/*!
 * VisualEditor DataModel InternalList tests.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.dm.InternalList' );

/* Tests */

QUnit.test( 'getDocument', 1, function ( assert ) {
	var doc = ve.dm.example.createExampleDocument(),
		internalList = doc.getInternalList();
	assert.deepEqual( internalList.getDocument(), doc, 'Returns original document' );
} );

QUnit.test( 'queueItemHtml/getItemHtmlQueue', 5, function ( assert ) {
	var doc = ve.dm.example.createExampleDocument(),
		internalList = doc.getInternalList();
	assert.deepEqual(
		internalList.queueItemHtml( 'reference', 'foo', 'Bar' ),
		{ 'index': 0, 'isNew': true },
		'First queued item returns index 0 and is new'
	);
	assert.deepEqual(
		internalList.queueItemHtml( 'reference', 'foo', 'Baz' ),
		{ 'index': 0, 'isNew': false },
		'Duplicate key returns index 0 and is not new'
	);
	assert.deepEqual(
		internalList.queueItemHtml( 'reference', 'bar', 'Baz' ),
		{ 'index': 1, 'isNew': true },
		'Second queued item returns index 1 and is new'
	);

	// Queue up empty data
	internalList.queueItemHtml( 'reference', 'baz', '' );
	assert.deepEqual(
		internalList.queueItemHtml( 'reference', 'baz', 'Quux' ),
		{ 'index': 2, 'isNew': true },
		'Third queued item is new because existing data in queue was empty'
	);

	assert.deepEqual( internalList.getItemHtmlQueue(), ['Bar', 'Baz', 'Quux'], 'getItemHtmlQueue returns stored HTML items' );
} );

QUnit.test( 'convertToData', 2, function ( assert ) {
	var doc = ve.dm.example.createExampleDocument(),
		internalList = doc.getInternalList(),
		expectedData = [
			{ 'type': 'internalList' },
			{ 'type': 'internalItem' },
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			'B', 'a', 'r',
			{ 'type': '/paragraph' },
			{ 'type': '/internalItem' },
			{ 'type': 'internalItem' },
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			'B', 'a', 'z',
			{ 'type': '/paragraph' },
			{ 'type': '/internalItem' },
			{ 'type': '/internalList' }
		];

	// Mimic convert state setup (as done in ve.dm.Converter#getDataFromDom)
	// TODO: The test should not (directly) reference the global instance
	ve.dm.converter.doc = doc;
	ve.dm.converter.store = doc.getStore();
	ve.dm.converter.internalList = internalList;
	ve.dm.converter.contextStack = [];

	internalList.queueItemHtml( 'reference', 'foo', 'Bar' );
	internalList.queueItemHtml( 'reference', 'bar', 'Baz' );
	assert.deepEqual( internalList.convertToData( ve.dm.converter ), expectedData, 'Data matches' );
	assert.deepEqual( internalList.getItemHtmlQueue(), [], 'Items html is emptied after conversion' );
} );

QUnit.test( 'clone', 5, function ( assert ) {
	var internalListClone, internalListClone2,
		doc = ve.dm.example.createExampleDocument(),
		doc2 = ve.dm.example.createExampleDocument(),
		internalList = doc.getInternalList();

	internalList.getNextUniqueNumber(); // =0
	internalListClone = internalList.clone();
	internalList.getNextUniqueNumber(); // =1
	internalListClone2 = internalList.clone( doc2 );
	internalList.getNextUniqueNumber(); // =2

	assert.equal( internalListClone.getDocument(), internalList.getDocument(), 'Documents match' );
	assert.equal( internalListClone2.getDocument(), doc2, 'Cloning with document parameter' );

	assert.equal( internalList.getNextUniqueNumber(), 3, 'original internallist has nextUniqueNumber=3' );
	assert.equal( internalListClone.getNextUniqueNumber(), 1, 'first clone has nextUniqueNumber=1' );
	assert.equal( internalListClone2.getNextUniqueNumber(), 2, 'second clone has nextUniqueNumber=2' );
} );
