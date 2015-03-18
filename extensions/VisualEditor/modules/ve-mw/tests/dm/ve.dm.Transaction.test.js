/*!
 * VisualEditor DataModel MediaWiki-specific Transaction tests.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.dm.Transaction' );

// FIXME: Duplicates test runner; should be using a data provider
QUnit.test( 'newFromDocumentInsertion with references', function ( assert ) {
	var i, j, doc2, tx, actualStoreItems, expectedStoreItems, removalOps, doc,
		complexDoc = ve.dm.mwExample.createExampleDocument( 'complexInternalData' ),
		comment = { type: 'alienMeta', attributes: { domElements: $( '<!-- hello -->' ).get() } },
		withReference = [
			{ type: 'paragraph' },
			'B', 'a', 'r',
			{ type: 'mwReference', attributes: {
				mw: {},
				about: '#mwt4',
				listIndex: 0,
				listGroup: 'mwReference/',
				listKey: 'auto/0',
				refGroup: '',
				contentsUsed: true
			} },
			{ type: '/mwReference' },
			{ type: '/paragraph' },
			{ type: 'internalList' },
			{ type: 'internalItem' },
			{ type: 'paragraph', internal: { generated: 'wrapper' } },
			'B',
			'a',
			'z',
			{ type: '/paragraph' },
			{ type: '/internalItem' },
			{ type: '/internalList' }
		],
		cases = [
			{
				msg: 'metadata insertion',
				doc: 'complexInternalData',
				offset: 0,
				range: new ve.Range( 0, 7 ),
				modify: function ( newDoc ) {
					newDoc.commit( ve.dm.Transaction.newFromMetadataInsertion(
						newDoc, 4, 0, [ comment ]
					) );
				},
				removalOps: [
					{
						type: 'replace',
						remove: complexDoc.getData( new ve.Range( 0, 7 ) ),
						insert: [],
						removeMetadata: complexDoc.getMetadata( new ve.Range( 0, 7 ) ),
						insertMetadata: []
					},
					{ type: 'retain', length: 26 }
				],
				expectedOps: [
					{
						type: 'replace',
						remove: [],
						insert: complexDoc.getData( new ve.Range( 0, 4 ) )
							// Reference gets (unnecessarily) renumbered from auto/0 to auto/1
							.concat( [
								ve.extendObject( true, {}, complexDoc.data.data[4],
									{ attributes: { listKey: 'auto/1' } }
								)
							] )
							.concat( complexDoc.getData( new ve.Range( 5, 7 ) ) ),
						removeMetadata: [],
						insertMetadata: complexDoc.getMetadata( new ve.Range( 0, 4 ) )
							.concat( [ [ comment ] ] )
							.concat( complexDoc.getMetadata( new ve.Range( 5, 7 ) ) )
					},
					{ type: 'retain', length: 1 },
					{
						type: 'replace',
						remove: complexDoc.getData( new ve.Range( 8, 32 ) ),
						insert: complexDoc.getData( new ve.Range( 8, 32 ) ),
						removeMetadata: complexDoc.getMetadata( new ve.Range( 8, 32 ) ),
						insertMetadata: complexDoc.getMetadata( new ve.Range( 8, 32 ) )
					},
					{ type: 'retain', length: 1 }
				]
			},
			{
				msg: 'metadata removal',
				doc: 'complexInternalData',
				offset: 24,
				range: new ve.Range( 24, 31 ),
				modify: function ( newDoc ) {
					newDoc.commit( ve.dm.Transaction.newFromMetadataRemoval(
						newDoc, 6, new ve.Range( 0, 1 )
					) );
				},
				removalOps: [
					{ type: 'retain', length: 24 },
					{
						type: 'replace',
						remove: complexDoc.getData( new ve.Range( 24, 31 ) ),
						insert: [],
						removeMetadata: complexDoc.getMetadata( new ve.Range( 24, 31 ) ),
						insertMetadata: []
					},
					{ type: 'retain', length: 2 }
				],
				expectedOps: [
					{ type: 'retain', length: 8 },
					{
						type: 'replace',
						remove: complexDoc.getData( new ve.Range( 8, 24 ) )
							.concat( complexDoc.getData( new ve.Range( 31, 32 ) ) ),
						insert: complexDoc.getData( new ve.Range( 8, 32 ) ),
						removeMetadata: complexDoc.getMetadata( new ve.Range( 8, 24 ) )
							.concat( complexDoc.getMetadata( new ve.Range( 31, 32 ) ) ),
						insertMetadata: complexDoc.getMetadata( new ve.Range( 8, 30 ) )
							.concat( [ [] ] )
							.concat( complexDoc.getMetadata( new ve.Range( 31, 32 ) ) )
					},
					{ type: 'retain', length: 1 }
				]
			},
			{
				msg: 'inserting a brand new document; internal lists are merged and items renumbered',
				doc: 'complexInternalData',
				offset: 7,
				newDocData: withReference,
				removalOps: [],
				expectedOps: [
					{ type: 'retain', length: 7 },
					{
						type: 'replace',
						remove: [],
						insert: withReference.slice( 0, 4 )
							// Renumber listIndex from 0 to 2
							// Renumber listKey from auto/0 to auto/1
							.concat( [
								ve.extendObject( true, {}, withReference[4],
									{ attributes: { listIndex: 2, listKey: 'auto/1' } }
								)
							] )
							.concat( withReference.slice( 5, 7 ) )
					},
					{ type: 'retain', length: 1 },
					{
						type: 'replace',
						remove: complexDoc.getData( new ve.Range( 8, 32 ) ),
						insert: complexDoc.getData( new ve.Range( 8, 32 ) )
							.concat( withReference.slice( 8, 15 ) ),
						removeMetadata: complexDoc.getMetadata( new ve.Range( 8, 32 ) ),
						insertMetadata: complexDoc.getMetadata( new ve.Range( 8, 32 ) )
							.concat( new Array( 7 ) )
					},
					{ type: 'retain', length: 1 }
				]
			}
		];
	QUnit.expect( 3 * cases.length );
	for ( i = 0; i < cases.length; i++ ) {
		doc = ve.dm.mwExample.createExampleDocument( cases[i].doc );
		if ( cases[i].newDocData ) {
			doc2 = new ve.dm.Document( cases[i].newDocData );
			removalOps = [];
		} else if ( cases[i].range ) {
			doc2 = doc.cloneFromRange( cases[i].range );
			cases[i].modify( doc2 );
			tx = ve.dm.Transaction.newFromRemoval( doc, cases[i].range, true );
			doc.commit( tx );
			removalOps = tx.getOperations();
		}

		assert.deepEqualWithDomElements( removalOps, cases[i].removalOps, cases[i].msg + ': removal' );

		tx = ve.dm.Transaction.newFromDocumentInsertion( doc, cases[i].offset, doc2 );
		assert.deepEqualWithDomElements( tx.getOperations(), cases[i].expectedOps, cases[i].msg + ': transaction' );

		actualStoreItems = [];
		expectedStoreItems = cases[i].expectedStoreItems || [];
		for ( j = 0; j < expectedStoreItems.length; j++ ) {
			actualStoreItems[j] = doc.store.value( doc.store.indexOfHash(
				OO.getHash( expectedStoreItems[j] )
			) );
		}
		assert.deepEqual( actualStoreItems, expectedStoreItems, cases[i].msg + ': store items' );
	}
} );
