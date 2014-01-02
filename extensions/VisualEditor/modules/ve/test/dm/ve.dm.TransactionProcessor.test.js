/*!
 * VisualEditor DataModel TransactionProcessor tests.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.dm.TransactionProcessor' );

/* Tests */

QUnit.test( 'commit', function ( assert ) {
	var i, originalData, originalDoc,
		msg, testDoc, tx, expectedData, expectedDoc,
		n = 0,
		store = ve.dm.example.createExampleDocument().getStore(),
		bold = ve.dm.example.createAnnotation( ve.dm.example.bold ),
		italic = ve.dm.example.createAnnotation( ve.dm.example.italic ),
		underline = ve.dm.example.createAnnotation( ve.dm.example.underline ),
		metaElementInsert = {
				'type': 'alienMeta',
				'attributes': {
					'style': 'comment',
					'text': ' inline '
				}
			},
		metaElementInsertClose = { 'type': '/alienMeta' },
		cases = {
			'no operations': {
				'calls': [],
				'expected': function () {}
			},
			'retaining': {
				'calls': [['pushRetain', 38]],
				'expected': function () {}
			},
			'annotating content': {
				'calls': [
					['pushRetain', 1],
					['pushStartAnnotating', 'set', bold],
					['pushRetain', 1],
					['pushStopAnnotating', 'set', bold],
					['pushRetain', 1],
					['pushStartAnnotating', 'clear', italic],
					['pushStartAnnotating', 'set', bold],
					['pushStartAnnotating', 'set', underline],
					['pushRetain', 1],
					['pushStopAnnotating', 'clear', italic],
					['pushStopAnnotating', 'set', bold],
					['pushStopAnnotating', 'set', underline]
				],
				'expected': function ( data ) {
					data[1] = ['a', store.indexes( [ bold ] )];
					data[2] = ['b', store.indexes( [ bold ] )];
					data[3] = ['c', store.indexes( [ bold, underline ] )];
				}
			},
			'annotating content and leaf elements': {
				'calls': [
					['pushRetain', 38],
					['pushStartAnnotating', 'set', bold],
					['pushRetain', 4],
					['pushStopAnnotating', 'set', bold]
				],
				'expected': function ( data ) {
					data[38] = ['h', store.indexes( [ bold ] )];
					data[39].annotations = store.indexes( [ bold ] );
					data[41] = ['i', store.indexes( [ bold ] )];
				}
			},
			'using an annotation method other than set or clear throws an exception': {
				'calls': [
					['pushStartAnnotating', 'invalid-method', bold],
					['pushRetain', 1],
					['pushStopAnnotating', 'invalid-method', bold]
				],
				'exception': Error
			},
			'annotating branch opening element throws an exception': {
				'calls': [
					['pushStartAnnotating', 'set', bold],
					['pushRetain', 1],
					['pushStopAnnotating', 'set', bold]
				],
				'exception': Error
			},
			'annotating branch closing element throws an exception': {
				'calls': [
					['pushRetain', 4],
					['pushStartAnnotating', 'set', bold],
					['pushRetain', 1],
					['pushStopAnnotating', 'set', bold]
				],
				'exception': Error
			},
			'setting duplicate annotations throws an exception': {
				'calls': [
					['pushRetain', 2],
					['pushStartAnnotating', 'set', bold],
					['pushRetain', 1],
					['pushStopAnnotating', 'set', bold]
				],
				'exception': Error
			},
			'removing non-existent annotations throws an exception': {
				'calls': [
					['pushRetain', 1],
					['pushStartAnnotating', 'clear', bold],
					['pushRetain', 1],
					['pushStopAnnotating', 'clear', bold]
				],
				'exception': Error
			},
			'changing, removing and adding attributes': {
				'calls': [
					['pushReplaceElementAttribute', 'level', 1, 2],
					['pushRetain', 12],
					['pushReplaceElementAttribute', 'style', 'bullet', 'number'],
					['pushReplaceElementAttribute', 'test', undefined, 'abcd'],
					['pushRetain', 27],
					['pushReplaceElementAttribute', 'src', ve.dm.example.imgSrc, undefined]
				],
				'expected': function ( data ) {
					data[0].attributes.level = 2;
					data[12].attributes.style = 'number';
					data[12].attributes.test = 'abcd';
					delete data[39].attributes.src;
				}
			},
			'changing attributes on non-element data throws an exception': {
				'calls': [
					['pushRetain', 1],
					['pushReplaceElementAttribute', 'foo', 23, 42]
				],
				'exception': Error
			},
			'inserting text': {
				'calls': [
					['pushRetain', 1],
					['pushReplace', 1, 0, ['F', 'O', 'O']]
				],
				'expected': function ( data ) {
					data.splice( 1, 0, 'F', 'O', 'O' );
				}
			},
			'removing text': {
				'calls': [
					['pushRetain', 1],
					['pushReplace', 1, 1, []]
				],
				'expected': function ( data ) {
					data.splice( 1, 1 );
				}
			},
			'replacing text': {
				'calls': [
					['pushRetain', 1],
					['pushReplace', 1, 1, ['F', 'O', 'O']]
				],
				'expected': function ( data ) {
					data.splice( 1, 1, 'F', 'O', 'O' );
				}
			},
			'emptying text': {
				'calls': [
					['pushRetain', 10],
					['pushReplace', 10, 1, []]
				],
				'expected': function ( data ) {
					data.splice( 10, 1 );
				}
			},
			'inserting mixed content': {
				'calls': [
					['pushRetain', 1],
					['pushReplace', 1, 1, ['F', 'O', 'O', {'type':'image'}, {'type':'/image'}, 'B', 'A', 'R']]
				],
				'expected': function ( data ) {
					data.splice( 1, 1, 'F', 'O', 'O', {'type':'image'}, {'type':'/image'}, 'B', 'A', 'R' );
				}
			},
			'converting an element': {
				'calls': [
					['pushReplace', 0, 1, [{ 'type': 'paragraph' }]],
					['pushRetain', 3],
					['pushReplace', 4, 1, [{ 'type': '/paragraph' }]]
				],
				'expected': function ( data ) {
					data[0].type = 'paragraph';
					delete data[0].attributes;
					data[4].type = '/paragraph';
				}
			},
			'splitting an element': {
				'calls': [
					['pushRetain', 2],
					[
						'pushReplace', 2, 0,
						[{ 'type': '/heading' }, { 'type': 'heading', 'attributes': { 'level': 1 } }]
					]
				],
				'expected': function ( data ) {
					data.splice(
						2,
						0,
						{ 'type': '/heading' },
						{ 'type': 'heading', 'attributes': { 'level': 1 } }
					);
				}
			},
			'merging an element': {
				'calls': [
					['pushRetain', 57],
					['pushReplace', 57, 2, []]
				],
				'expected': function ( data ) {
					data.splice( 57, 2 );
				}
			},
			'stripping elements': {
				'calls': [
					['pushRetain', 3],
					['pushReplace', 3, 1, []],
					['pushRetain', 6],
					['pushReplace', 10, 1, []]
				],
				'expected': function ( data ) {
					data.splice( 10, 1 );
					data.splice( 3, 1 );
				}
			},
			'inserting text after alien node at the end': {
				'data': [
					{ 'type': 'paragraph' },
					'a',
					{ 'type': 'alienInline' },
					{ 'type': '/alienInline' },
					{ 'type': '/paragraph' }
				],
				'calls': [
					['pushRetain', 4],
					['pushReplace', 4, 0, ['b']]
				],
				'expected': function ( data ) {
					data.splice( 4, 0, 'b' );
				}
			},
			'inserting metadata element into existing element list': {
				'data': ve.dm.example.withMeta,
				'calls': [
					['pushRetain', 11 ],
					['pushRetainMetadata', 2 ],
					['pushReplaceMetadata', [], [ metaElementInsert ] ],
					['pushRetainMetadata', 2 ],
					['pushRetain', 1 ]
				],
				'expected': function ( data ) {
					data.splice( 25, 0, metaElementInsert, metaElementInsertClose );
				}
			},
			'inserting metadata element into empty list': {
				'data': ve.dm.example.withMeta,
				'calls': [
					['pushRetain', 3 ],
					['pushReplaceMetadata', [], [ metaElementInsert ] ],
					['pushRetain', 9 ]
				],
				'expected': function ( data ) {
					data.splice( 7, 0, metaElementInsert, metaElementInsertClose );
				}
			},
			'removing all metadata elements from a metadata list': {
				'data': ve.dm.example.withMeta,
				'calls': [
					['pushRetain', 11 ],
					['pushReplaceMetadata', ve.dm.example.withMetaMetaData[11], [] ],
					['pushRetain', 1 ]
				],
				'expected': function ( data ) {
					data.splice( 21, 8 );
				}
			},
			'removing some metadata elements from metadata list': {
				'data': ve.dm.example.withMeta,
				'calls': [
					['pushRetain', 11 ],
					['pushRetainMetadata', 1 ],
					['pushReplaceMetadata', ve.dm.example.withMetaMetaData[11].slice( 1, 3 ), [] ],
					['pushRetainMetadata', 1 ],
					['pushRetain', 1 ]
				],
				'expected': function ( data ) {
					data.splice( 23, 4 );
				}
			},
			'replacing metadata at end of list': {
				'data': ve.dm.example.withMeta,
				'calls': [
					['pushRetain', 11 ],
					['pushRetainMetadata', 3 ],
					['pushReplaceMetadata', [ ve.dm.example.withMetaMetaData[11][3] ], [ metaElementInsert ] ],
					['pushRetain', 1 ]
				],
				'expected': function ( data ) {
					data.splice( 27, 2, metaElementInsert, metaElementInsertClose );
				}
			},
			'replacing metadata twice at the same offset': {
				'data': ve.dm.example.withMeta,
				'calls': [
					[ 'pushRetain', 11 ],
					[ 'pushRetainMetadata', 1 ],
					[ 'pushReplaceMetadata', [ ve.dm.example.withMetaMetaData[11][1] ], [ metaElementInsert ] ],
					[ 'pushRetainMetadata', 1 ],
					[ 'pushReplaceMetadata', [ ve.dm.example.withMetaMetaData[11][3] ], [ metaElementInsert ] ],
					[ 'pushRetain', 1 ]
				],
				'expected': function ( data ) {
					data.splice( 23, 2, metaElementInsert, metaElementInsertClose );
					data.splice( 27, 2, metaElementInsert, metaElementInsertClose );
				}
			},
			'removing data from between metadata merges metadata': {
				'data': ve.dm.example.withMeta,
				'calls': [
					['pushRetain', 7 ],
					['pushReplace', 7, 2, []],
					['pushRetain', 2 ]
				],
				'expected': function ( data ) {
					data.splice( 15, 2 );
				}
			},
			'structural replacement starting at an offset without metadata': {
				'data': [
					{ 'type': 'paragraph' },
					'F',
					{
						'type': 'alienMeta',
						'attributes': {
							'domElements': $( '<!-- foo -->' ).toArray()
						}
					},
					{ 'type': '/alienMeta' },
					'o', 'o',
					{ 'type': '/paragraph' }
				],
				'calls': [
					['pushReplace', 0, 5, [ { 'type': 'table' }, { 'type': '/table' } ]]
				],
				'expected': function ( data ) {
					data.splice( 0, 2 );
					data.splice( 2, 3, { 'type': 'table' }, { 'type': '/table' } );
				}
			},
			'structural replacement starting at an offset with metadata': {
				'data': [
					{
						'type': 'alienMeta',
						'attributes': {
							'domElements': $( '<!-- foo -->' ).toArray()
						}
					},
					{ 'type': '/alienMeta' },
					{ 'type': 'paragraph' },
					'F',
					{
						'type': 'alienMeta',
						'attributes': {
							'style': 'comment',
							'text': ' inline '
						}
					},
					{ 'type': '/alienMeta' },
					'o', 'o',
					{ 'type': '/paragraph' }
				],
				'calls': [
					['pushReplace', 0, 5, [ { 'type': 'table' }, { 'type': '/table' } ]]
				],
				'expected': function ( data ) {
					// metadata  is merged.
					data.splice( 2, 2 );
					data.splice( 4, 3, { 'type': 'table' }, { 'type': '/table' } );
				}
			},
			'structural replacement ending at an offset with metadata': {
				'data': [
					{
						'type': 'alienMeta',
						'attributes': {
							'domElements': $( '<!-- foo -->' ).toArray()
						}
					},
					{ 'type': '/alienMeta' },
					{ 'type': 'paragraph' },
					'F',
					{
						'type': 'alienMeta',
						'attributes': {
							'style': 'comment',
							'text': ' inline '
						}
					},
					{ 'type': '/alienMeta' },
					'o', 'o',
					{ 'type': '/paragraph' },
					{
						'type': 'alienMeta',
						'attributes': {
							'domElements': $( '<!-- bar -->' ).toArray()
						}
					},
					{ 'type': '/alienMeta' },
					{ 'type': 'paragraph' },
					'B', 'a', 'r',
					{ 'type': '/paragraph' }
				],
				'calls': [
					['pushReplace', 0, 5, [ { 'type': 'table' }, { 'type': '/table' } ]],
					['pushRetain', 5 ]
				],
				'expected': function ( data ) {
					// metadata  is merged.
					data.splice( 2, 2 );
					data.splice( 4, 3, { 'type': 'table' }, { 'type': '/table' } );
				}
			},
			'structural deletion ending at an offset with metadata': {
				'data': [
					{
						'type': 'alienMeta',
						'attributes': {
							'domElements': $( '<!-- foo -->' ).toArray()
						}
					},
					{ 'type': '/alienMeta' },
					{ 'type': 'paragraph' },
					'F',
					{
						'type': 'alienMeta',
						'attributes': {
							'style': 'comment',
							'text': ' inline '
						}
					},
					{ 'type': '/alienMeta' },
					'o', 'o',
					{ 'type': '/paragraph' },
					{
						'type': 'alienMeta',
						'attributes': {
							'domElements': $( '<!-- bar -->' ).toArray()
						}
					},
					{ 'type': '/alienMeta' },
					{ 'type': 'paragraph' },
					'B', 'a', 'r',
					{ 'type': '/paragraph' }
				],
				'calls': [
					['pushReplace', 0, 5, [] ],
					['pushRetain', 5 ]
				],
				'expected': function ( data ) {
					// metadata  is merged.
					data.splice( 2, 2 );
					data.splice( 4, 3 );
				}
			},
			'preserves metadata on unwrap': {
				'data': ve.dm.example.listWithMeta,
				'calls': [
					[ 'newFromWrap', new ve.Range( 1, 11 ),
					  [ { 'type': 'list' } ], [],
					  [ { 'type': 'listItem', 'attributes': {'styles': ['bullet']} } ], [] ]
				],
				'expected': function ( data ) {
					data.splice( 35, 1 ); // remove '/list'
					data.splice( 32, 1 ); // remove '/listItem'
					data.splice( 20, 1 ); // remove 'listItem'
					data.splice( 17, 1 ); // remove '/listItem'
					data.splice(  5, 1 ); // remove 'listItem'
					data.splice(  2, 1 ); // remove 'list'
				}
			},
			'inserting trailing metadata (1)': {
				'data': ve.dm.example.listWithMeta,
				'calls': [
					[ 'newFromMetadataInsertion', 12, 0, [
						{
							'type': 'alienMeta',
							'attributes': {
								'domElements': $( '<meta property="fourteen" />' ).toArray()
							}
						}
					] ]
				],
				'expected': function ( data ) {
					ve.batchSplice( data, data.length - 2, 0, [
						{
							'type': 'alienMeta',
							'attributes': {
								'domElements': $( '<meta property="fourteen" />' ).toArray()
							}
						},
						{
							'type': '/alienMeta'
						}
					] );
				}
			},
			'inserting trailing metadata (2)': {
				'data': ve.dm.example.listWithMeta,
				'calls': [
					[ 'newFromMetadataInsertion', 12, 1, [
						{
							'type': 'alienMeta',
							'attributes': {
								'domElements': $( '<meta property="fourteen" />' ).toArray()
							}
						}
					] ]
				],
				'expected': function ( data ) {
					ve.batchSplice( data, data.length, 0, [
						{
							'type': 'alienMeta',
							'attributes': {
								'domElements': $( '<meta property="fourteen" />' ).toArray()
							}
						},
						{
							'type': '/alienMeta'
						}
					] );
				}
			},
			'removing trailing metadata': {
				'data': ve.dm.example.listWithMeta,
				'calls': [
					[ 'newFromMetadataRemoval', 12, new ve.Range( 0, 1 ) ]
				],
				'expected': function ( data ) {
					ve.batchSplice( data, data.length - 2, 2, [] );
				}
			},
			'preserves trailing metadata': {
				'data': ve.dm.example.listWithMeta,
				'calls': [
					[ 'newFromInsertion', 4, [ 'b' ] ]
				],
				'expected': function ( data ) {
					ve.batchSplice( data, 12, 0, [ 'b' ] );
				}
			}
		};

	for ( msg in cases ) {
		n += ( 'expected' in cases[msg] ) ? 4 : 1;
	}
	QUnit.expect( n );

	// Run tests
	for ( msg in cases ) {
		// Generate original document
		originalData = cases[msg].data || ve.dm.example.data;
		originalDoc = new ve.dm.Document(
			ve.dm.example.preprocessAnnotations( ve.copy( originalData ), store )
		);
		testDoc = new ve.dm.Document(
			ve.dm.example.preprocessAnnotations( ve.copy( originalData ), store )
		);

		tx = new ve.dm.Transaction();
		for ( i = 0; i < cases[msg].calls.length; i++ ) {
			// some calls need the document as its first argument
			if ( /^(pushReplace$|new)/.test( cases[msg].calls[i][0] ) ) {
				cases[msg].calls[i].splice( 1, 0, testDoc );
			}
			// special case static methods of Transaction
			if ( /^new/.test( cases[msg].calls[i][0] ) ) {
				tx = ve.dm.Transaction[cases[msg].calls[i][0]].apply( null, cases[msg].calls[i].slice( 1 ) );
				break;
			}
			tx[cases[msg].calls[i][0]].apply( tx, cases[msg].calls[i].slice( 1 ) );
		}

		if ( 'expected' in cases[msg] ) {
			// Generate expected document
			expectedData = ve.copy( originalData );
			cases[msg].expected( expectedData );
			expectedDoc = new ve.dm.Document(
				ve.dm.example.preprocessAnnotations( expectedData, store )
			);
			// Commit
			testDoc.commit( tx );
			assert.deepEqualWithDomElements( testDoc.getFullData(), expectedDoc.getFullData(), 'commit (data): ' + msg );
			assert.equalNodeTree(
				testDoc.getDocumentNode(),
				expectedDoc.getDocumentNode(),
				'commit (tree): ' + msg
			);
			// Rollback
			testDoc.commit( tx.reversed() );
			assert.deepEqualWithDomElements( testDoc.getFullData(), originalDoc.getFullData(), 'rollback (data): ' + msg );
			assert.equalNodeTree(
				testDoc.getDocumentNode(),
				originalDoc.getDocumentNode(),
				'rollback (tree): ' + msg
			);
		} else if ( 'exception' in cases[msg] ) {
			/*jshint loopfunc:true */
			assert.throws(
				function () {
					testDoc.commit( tx );
				},
				cases[msg].exception,
				'commit: ' + msg
			);
		}
	}
} );
