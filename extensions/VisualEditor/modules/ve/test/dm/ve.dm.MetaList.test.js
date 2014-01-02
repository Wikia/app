/*!
 * VisualEditor MetaList tests.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.dm.MetaList' );

/* Tests */

function assertItemsMatchMetadata( assert, metadata, list, msg, full ) {
	var i, j, k = 0, items = list.getAllItems();
	for ( i in metadata.getData() ) {
		if ( ve.isArray( metadata.getData( i ) ) ) {
			for ( j = 0; j < metadata.getData( i ).length; j++ ) {
				assert.strictEqual( items[k].getOffset(), Number( i ), msg + ' (' + k + ': offset (' + i + ', ' + j + '))' );
				assert.strictEqual( items[k].getIndex(), j, msg + ' (' + k + ': index(' + i + ', ' + j + '))' );
				if ( full ) {
					assert.strictEqual( items[k].getElement(), metadata.getData( i, j ), msg + ' (' + k + ': element(' + i + ', ' + j + '))' );
					assert.strictEqual( items[k].getParentList(), list, msg + ' (' + k + ': parentList(' + i + ', ' + j + '))' );
				}
				k++;
			}
		}
	}
	assert.strictEqual( items.length, k, msg + ' (number of items)' );
}

QUnit.test( 'constructor', function ( assert ) {
	 var doc = ve.dm.example.createExampleDocument( 'withMeta' ),
		surface = new ve.dm.Surface( doc ),
		list = new ve.dm.MetaList( surface ),
		metadata = doc.metadata;
	QUnit.expect( 4*metadata.getTotalDataLength() + 1 );
	assertItemsMatchMetadata( assert, metadata, list, 'Constructor', true );
} );

QUnit.test( 'onTransact', function ( assert ) {
	var i, j, surface, tx, list,
		doc = ve.dm.example.createExampleDocument( 'withMeta' ),
		comment = { 'type': 'alienMeta', 'attributes': { 'style': 'comment', 'text': 'onTransact test' } },
		heading = { 'type': 'heading', 'attributes': { 'level': 2 } },
		cases = [
			{
				// delta: 0
				'calls': [
					[ 'pushRetain', 1 ],
					[ 'pushReplace', doc, 1, 0, [ 'Q', 'u', 'u', 'x' ] ],
					[ 'pushRetain', 3 ],
					[ 'pushReplace', doc, 4, 1, [] ],
					[ 'pushRetain', 1 ],
					[ 'pushReplace', doc, 6, 4, [ '!' ] ],
					[ 'pushRetain', 2 ]
				],
				'msg': 'Transaction inserting, replacing and removing text'
			},
			{
				'calls': [
					[ 'pushRetain', 1 ],
					[
						'pushReplace', doc, 1, 9,
						[ 'f', 'O', 'O', 'b', 'A', 'R', 'b', 'A', 'Z' ],
						[
							undefined,
							[ ve.dm.example.withMetaMetaData[9][0], ve.dm.example.withMetaMetaData[7][0] ],
							undefined, undefined, undefined, [ ve.dm.example.withMetaMetaData[4][0] ],
							undefined, undefined, undefined
						]
					]
				],
				'msg': 'Transaction replacing text and metadata at the same time'
			},
			{
				// delta: 0
				'calls': [
					[ 'pushRetainMetadata', 1 ],
					[ 'pushReplaceMetadata', [], [ comment ] ],
					[ 'pushRetain', 4 ],
					[ 'pushReplaceMetadata', [ ve.dm.example.withMetaMetaData[4][0] ], [] ],
					[ 'pushRetain', 3 ],
					[ 'pushReplaceMetadata', [ ve.dm.example.withMetaMetaData[7][0] ], [ comment ] ],
					[ 'pushRetain', 4 ],
					[ 'pushRetainMetadata', 1 ],
					[ 'pushReplaceMetadata', [ ve.dm.example.withMetaMetaData[11][1] ], [] ],
					[ 'pushRetainMetadata', 1 ],
					[ 'pushReplaceMetadata', [], [ comment ] ]
				],
				'msg': 'Transaction inserting, replacing and removing metadata'
			},
			{
				// delta: 0
				'calls': [
					[ 'pushReplace', doc, 0, 1, [ heading ] ],
					[ 'pushRetain', 9 ],
					[ 'pushReplace', doc, 10, 1, [ { 'type': '/heading' } ] ]
				],
				'msg': 'Transaction converting paragraph to heading'
			},
			{
				// delta: -9
				'calls': [
					[ 'pushRetain', 1 ],
					[ 'pushReplace', doc, 1, 9, [] ],
					[ 'pushRetain', 1 ]
				],
				'msg': 'Transaction blanking paragraph'
			},
			{
				// delta: +11
				'calls': [
					[ 'pushRetain', 11 ],
					[ 'pushReplace', doc, 11, 0, ve.dm.example.withMetaPlainData ]
				],
				'msg': 'Transaction adding second paragraph at the end'
			},
			{
				// delta: -2
				'calls': [
					[ 'pushRetain', 1 ],
					[ 'pushReplace', doc, 1, 7, [] ],
					[ 'pushRetain', 1 ],
					[ 'pushReplaceMetadata', [ ve.dm.example.withMetaMetaData[9][0] ], [] ],
					[ 'pushRetain', 2 ],
					// The two operations below have to be in this order because of bug 46138
					[ 'pushReplace', doc, 11, 0, [ { 'type': 'paragraph' }, 'a', 'b', 'c', { 'type': '/paragraph' } ] ],
					[ 'pushReplaceMetadata', [], [ comment ] ]
				],
				'msg': 'Transaction adding and removing text and metadata'
			}
	];
	// HACK: This works because most transactions above don't change the document length, and the
	// ones that do change it cancel out
	QUnit.expect( cases.length*( 8*doc.metadata.getTotalDataLength() + 2 ) );

	for ( i = 0; i < cases.length; i++ ) {
		tx = new ve.dm.Transaction();
		for ( j = 0; j < cases[i].calls.length; j++ ) {
			tx[cases[i].calls[j][0]].apply( tx, cases[i].calls[j].slice( 1 ) );
		}
		doc = ve.dm.example.createExampleDocument( 'withMeta' );
		surface = new ve.dm.Surface( doc );
		list = new ve.dm.MetaList( surface );
		// Test both the transaction-via-surface and transaction-via-document flows
		surface.change( tx );
		assertItemsMatchMetadata( assert, doc.metadata, list, cases[i].msg, true );
		surface.change( tx.reversed() );
		assertItemsMatchMetadata( assert, doc.metadata, list, cases[i].msg + ' (rollback)', true );
	}
} );

QUnit.test( 'findItem', function ( assert ) {
	var i, j, g, item, element, expectedElement, group, groupDesc, items, next,
		groups = [ null ],
		doc = ve.dm.example.createExampleDocument( 'withMeta' ),
		surface = new ve.dm.Surface( doc ),
		metadata = doc.metadata,
		list = new ve.dm.MetaList( surface );

	for ( i = 0; i < metadata.getLength(); i++ ) {
		for ( j = 0; j < metadata.getDataLength( i ); j++ ) {
			group = ve.dm.metaItemFactory.getGroup( metadata.getData( i, j ).type );
			if ( ve.indexOf( group, groups ) === -1 ) {
				groups.push( group );
			}
		}
	}
	QUnit.expect( 2*( metadata.getLength() + metadata.getTotalDataLength() )*groups.length );

	for ( g = 0; g < groups.length; g++ ) {
		groupDesc = groups[g] === null ? 'all items' : groups[g];
		items = groups[g] === null ? list.items : list.groups[groups[g]];
		next = 0;
		for ( i = 0; i < metadata.getLength(); i++ ) {
			for ( j = 0; j < metadata.getDataLength( i ); j++ ) {
				item = list.findItem( i, j, groups[g] );
				next = item !== null ? item + 1 : next;
				element = item === null ? null : items[item].getElement();
				expectedElement = metadata.getData( i, j );
				if (
					groups[g] !== null && expectedElement &&
					ve.dm.metaItemFactory.getGroup( expectedElement.type ) !== groups[g]
				) {
					expectedElement = null;
				}
				assert.strictEqual( element, expectedElement, groupDesc + ' (' + i + ', ' + j + ')' );
				assert.strictEqual( list.findItem( i, j, groups[g], true ), item !== null ? item : next,
					groupDesc + ' (forInsertion) (' + i + ', ' + j + ')' );
			}
			assert.strictEqual( list.findItem( i, j, groups[g] ), null, groupDesc + ' (' + i + ', ' + j + ')' );
			assert.strictEqual( list.findItem( i, j, groups[g], true ), next, groupDesc + ' (forInsertion) (' + i + ', ' + j + ')' );
		}
	}
} );

QUnit.test( 'insertMeta', 5, function ( assert ) {
	var expected,
		doc = ve.dm.example.createExampleDocument( 'withMeta' ),
		surface = new ve.dm.Surface( doc ),
		list = new ve.dm.MetaList( surface ),
		insert = {
			'type': 'alienMeta',
			'attributes': {
				'style': 'comment',
				'text': 'insertMeta test'
			}
		};

	list.insertMeta( insert, 2, 0 );
	assert.deepEqual( doc.metadata.getData( 2 ), [ insert ], 'Inserting metadata at an offset without pre-existing metadata' );

	expected = doc.metadata.getData( 0 ).slice( 0 );
	expected.splice( 1, 0, insert );
	list.insertMeta( insert, 0, 1 );
	assert.deepEqual( doc.metadata.getData( 0 ), expected, 'Inserting metadata in the middle' );

	expected.push( insert );
	list.insertMeta( insert, 0 );
	assert.deepEqual( doc.metadata.getData( 0 ), expected, 'Inserting metadata without passing an index adds to the end' );

	list.insertMeta( insert, 1 );
	assert.deepEqual( doc.metadata.getData( 1 ), [ insert ], 'Inserting metadata without passing an index without pre-existing metadata' );

	list.insertMeta( new ve.dm.AlienMetaItem( insert ), 1 );
	assert.deepEqual( doc.metadata.getData( 1 ), [ insert, insert ], 'Passing a MetaItem rather than an element' );
} );

QUnit.test( 'removeMeta', 4, function ( assert ) {
	var expected,
		doc = ve.dm.example.createExampleDocument( 'withMeta' ),
		surface = new ve.dm.Surface( doc ),
		list = new ve.dm.MetaList( surface );

	list.removeMeta( list.getItemAt( 4, 0 ) );
	assert.deepEqual( doc.metadata.getData( 4 ), [], 'Removing the only item at offset 4' );

	expected = doc.metadata.getData( 0 ).slice( 0 );
	expected.splice( 1, 1 );
	list.removeMeta( list.getItemAt( 0, 1 ) );
	assert.deepEqual( doc.metadata.getData( 0 ), expected, 'Removing the item at (0,1)' );

	expected = doc.metadata.getData( 11 ).slice( 0 );
	expected.splice( 0, 1 );
	list.getItemAt( 11, 0 ).remove();
	assert.deepEqual( doc.metadata.getData( 11 ), expected, 'Removing (11,0) using .remove()' );

	expected.splice( 1, 1 );
	list.getItemAt( 11, 1 ).remove();
	assert.deepEqual( doc.metadata.getData( 11 ), expected, 'Removing (11,1) (formerly (11,2)) using .remove()' );
} );
