/*!
 * VisualEditor DataModel Transaction tests.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.dm.Transaction' );

// FIXME duplicates test runner; should be using a data provider
QUnit.test( 'newFromDocumentReplace with references', function ( assert ) {
	var i, j, doc2, tx, actualStoreItems, expectedStoreItems,
		doc = ve.dm.example.createExampleDocument( 'internalData' ),
		complexDoc = ve.dm.mwExample.createExampleDocument( 'complexInternalData' ),
		comment = { 'type': 'alienMeta', 'attributes': { 'domElements': $( '<!-- hello -->' ).get() } },
		withReference = [
			{ 'type': 'paragraph' },
			'B', 'a', 'r',
			{ 'type': 'mwReference', 'attributes': {
				'mw': {},
				'about': '#mwt4',
				'listIndex': 0,
				'listGroup': 'mwReference/',
				'listKey': null,
				'refGroup': '',
				'contentsUsed': true
			} },
			{ 'type': '/mwReference' },
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': 'internalItem' },
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			'B',
			'a',
			'z',
			{ 'type': '/paragraph' },
			{ 'type': '/internalItem' },
			{ 'type': '/internalList' }
		],
		cases = [
			{
				'msg': 'metadata insertion',
				'doc': complexDoc,
				'range': new ve.Range( 0, 7 ),
				'modify': function ( newDoc ) {
					newDoc.commit( ve.dm.Transaction.newFromMetadataInsertion(
						newDoc, 5, 0, [ comment ]
					) );
				},
				'expectedOps': [
					{
						'type': 'replace',
						'remove': complexDoc.getData( new ve.Range( 0, 7 ) ),
						'insert': complexDoc.getData( new ve.Range( 0, 7 ) ),
						'removeMetadata': complexDoc.getMetadata( new ve.Range( 0, 7 ) ),
						'insertMetadata': complexDoc.getMetadata( new ve.Range( 0, 5 ) )
							.concat( [ [ comment ] ] )
							.concat( complexDoc.getMetadata( new ve.Range( 6, 8 ) ) )
					},
					{ 'type': 'retain', 'length': 1 },
					{
						'type': 'replace',
						'remove': complexDoc.getData( new ve.Range( 8, 32 ) ),
						'insert': complexDoc.getData( new ve.Range( 8, 32 ) ),
						'removeMetadata': complexDoc.getMetadata( new ve.Range( 8, 32 ) ),
						'insertMetadata': complexDoc.getMetadata( new ve.Range( 8, 32 ) )
					},
					{ 'type': 'retain', 'length': 1 }
				]
			},
			{
				'msg': 'metadata removal',
				'doc': complexDoc,
				'range': new ve.Range( 24, 31 ),
				'modify': function ( newDoc ) {
					newDoc.commit( ve.dm.Transaction.newFromMetadataRemoval(
						newDoc, 6, new ve.Range( 0, 1 )
					) );
				},
				'expectedOps': [
					{ 'type': 'retain', 'length': 8 },
					{
						'type': 'replace',
						'remove': complexDoc.getData( new ve.Range( 8, 32 ) ),
						'insert': complexDoc.getData( new ve.Range( 8, 32 ) ),
						'removeMetadata': complexDoc.getMetadata( new ve.Range( 8, 32 ) ),
						'insertMetadata': complexDoc.getMetadata( new ve.Range( 8, 30 ) )
							.concat( [ [] ] )
							.concat( complexDoc.getMetadata( new ve.Range( 31, 32 ) ) )
					},
					{ 'type': 'retain', 'length': 1 }
				]
			},
			{
				'msg': 'inserting a brand new document; internal lists are merged and items renumbered',
				'doc': complexDoc,
				'range': new ve.Range( 7, 7 ),
				'newDocData': withReference,
				'expectedOps': [
					{ 'type': 'retain', 'length': 7 },
					{
						'type': 'replace',
						'remove': [],
						'insert': withReference.slice( 0, 4 )
							// Renumber listIndex from 0 to 2
							.concat( [ ve.extendObject( true, {}, withReference[4],
								{ 'attributes': { 'listIndex': 2 } } ) ] )
							.concat( withReference.slice( 5, 7 ) )
					},
					{ 'type': 'retain', 'length': 1 },
					{
						'type': 'replace',
						'remove': complexDoc.getData( new ve.Range( 8, 32 ) ),
						'insert': complexDoc.getData( new ve.Range( 8, 32 ) )
							.concat( withReference.slice( 8, 15 ) ),
						'removeMetadata': complexDoc.getMetadata( new ve.Range( 8, 32 ) ),
						'insertMetadata': complexDoc.getMetadata( new ve.Range( 8, 32 ) )
							.concat( new Array( 7 ) )
					},
					{ 'type': 'retain', 'length': 1 }
				]
			}
		];
		QUnit.expect( 2 * cases.length );
		for ( i = 0; i < cases.length; i++ ) {
			doc = cases[i].doc; // TODO deep copy?
			if ( cases[i].newDocData ) {
				doc2 = new ve.dm.Document( cases[i].newDocData );
			} else {
				doc2 = doc.cloneFromRange( cases[i].range instanceof ve.Range ? cases[i].range : cases[i].range.getRange() );
				cases[i].modify( doc2 );
			}
			tx = ve.dm.Transaction.newFromDocumentReplace( doc, cases[i].range, doc2 );
			assert.deepEqualWithDomElements( tx.getOperations(), cases[i].expectedOps, cases[i].msg + ': transaction' );

			actualStoreItems = [];
			expectedStoreItems = cases[i].expectedStoreItems || [];
			for ( j = 0; j < expectedStoreItems.length; j++ ) {
				actualStoreItems[j] = doc.store.value( doc.store.indexOfHash(
					ve.getHash( expectedStoreItems[j] )
				) );
			}
			assert.deepEqual( actualStoreItems, expectedStoreItems, cases[i].msg + ': store items' );
		}
} );