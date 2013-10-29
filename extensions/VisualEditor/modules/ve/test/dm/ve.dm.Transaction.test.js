/*!
 * VisualEditor DataModel Transaction tests.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.dm.Transaction' );

/* Helper methods */

function runBuilderTests( assert, cases ) {
	var msg, tx, i;
	for ( msg in cases ) {
		tx = new ve.dm.Transaction();
		for ( i = 0; i < cases[msg].calls.length; i++ ) {
			tx[cases[msg].calls[i][0]].apply( tx, cases[msg].calls[i].slice( 1 ) );
		}
		assert.deepEqualWithDomElements( tx.getOperations(), cases[msg].ops, msg + ': operations match' );
		assert.deepEqual( tx.getLengthDifference(), cases[msg].diff, msg + ': length differences match' );
	}
}

function runConstructorTests( assert, constructor, cases ) {
	var msg, tx;
	for ( msg in cases ) {
		if ( cases[msg].ops ) {
			tx = constructor.apply(
				ve.dm.Transaction, cases[msg].args
			);
			assert.deepEqualWithDomElements( tx.getOperations(), cases[msg].ops, msg + ': operations match' );
		} else if ( cases[msg].exception ) {
			/*jshint loopfunc:true */
			assert.throws( function () {
				constructor.apply(
					ve.dm.Transaction, cases[msg].args
				);
			}, cases[msg].exception, msg + ': throw exception' );
		}
	}
}

/* Tests */

QUnit.test( 'newFromInsertion', function ( assert ) {
	var i, key,
		doc = ve.dm.example.createExampleDocument(),
		isolationDoc = ve.dm.example.createExampleDocument( 'isolationData' ),
		complexTableDoc = ve.dm.example.createExampleDocument( 'complexTable' ),
		listWithMetaDoc = ve.dm.example.createExampleDocument( 'listWithMeta' ),
		doc2 = new ve.dm.Document(
			ve.dm.example.preprocessAnnotations( [ { 'type': 'paragraph' }, { 'type': '/paragraph' } ] )
		),
		doc3 = new ve.dm.Document(
			ve.dm.example.preprocessAnnotations( [ { 'type': 'paragraph' }, 'F', 'o', 'o', { 'type': '/paragraph' } ] )
		),
		cases = {
			'paragraph before first element': {
				'args': [doc, 0, [{ 'type': 'paragraph' }, '1', { 'type': '/paragraph' }]],
				'ops': [
					{
						'type': 'replace',
						'remove': [],
						'insert': [{ 'type': 'paragraph' }, '1', { 'type': '/paragraph' }]
					},
					{ 'type': 'retain', 'length': 63 }
				]
			},
			'paragraph after last element': {
				'args': [doc, 63, [{ 'type': 'paragraph' }, '1', { 'type': '/paragraph' }]],
				'ops': [
					{ 'type': 'retain', 'length': 63 },
					{
						'type': 'replace',
						'remove': [],
						'insert': [{ 'type': 'paragraph' }, '1', { 'type': '/paragraph' }]
					}
				]
			},
			'split paragraph': {
				'args': [doc, 10, ['1', { 'type': '/paragraph' }, { 'type': 'paragraph' }]],
				'ops': [
					{ 'type': 'retain', 'length': 10 },
					{
						'type': 'replace',
						'remove': [],
						'insert': ['1', { 'type': '/paragraph' }, { 'type': 'paragraph' }]
					},
					{ 'type': 'retain', 'length': 53 }
				]
			},
			'paragraph inside a heading closes and reopens heading': {
				'args': [doc, 2, [{ 'type': 'paragraph' }, 'F', 'O', 'O', { 'type': '/paragraph' }]],
				'ops': [
					{ 'type': 'retain', 'length': 2 },
					{
						'type': 'replace',
						'remove': [],
						'insert': [{'type': '/heading' }, { 'type': 'paragraph' } , 'F', 'O', 'O', { 'type': '/paragraph' }, { 'type': 'heading', 'attributes': { 'level': 1 } }]
					},
					{ 'type': 'retain', 'length': 61 }
				]
			},
			'paragraph inside a list moves in front of list': {
				'args': [doc, 13, [{ 'type': 'paragraph' }, 'F', 'O', 'O', { 'type': '/paragraph' }]],
				'ops': [
					{ 'type': 'retain', 'length': 12 },
					{
						'type': 'replace',
						'remove': [],
						'insert': [{ 'type': 'paragraph' } , 'F', 'O', 'O', { 'type': '/paragraph' }]
					},
					{ 'type': 'retain', 'length': 51 }
				]
			},
			'tableCell inside the document is wrapped in a table, tableSection and tableRow': {
				'args': [doc, 43, [{ 'type': 'tableCell', 'attributes': { 'style': 'data' } }, { 'type': 'paragraph' }, 'F', 'O', 'O', { 'type': '/paragraph' }, { 'type': '/tableCell' }]],
				'ops': [
					{ 'type': 'retain', 'length': 43 },
					{
						'type': 'replace',
						'remove': [],
						'insert': [{ 'type': 'table' }, { 'type': 'tableSection', 'attributes': { 'style': 'body' } }, { 'type': 'tableRow' }, { 'type': 'tableCell', 'attributes': { 'style': 'data' } }, { 'type': 'paragraph' }, 'F', 'O', 'O', { 'type': '/paragraph' }, { 'type': '/tableCell' }, { 'type': '/tableRow' }, { 'type': '/tableSection' }, { 'type': '/table' }]
					},
					{ 'type': 'retain', 'length': 20 }
				]
			},
			'tableCell inside a paragraph is wrapped in a table, tableSection and tableRow and moves outside of paragraph': {
				'args': [doc, 52, [{ 'type': 'tableCell', 'attributes': { 'style': 'data' } }, { 'type': 'paragraph' }, 'F', 'O', 'O', { 'type': '/paragraph' }, { 'type': '/tableCell' }]],
				'ops': [
					{ 'type': 'retain', 'length': 53 },
					{
						'type': 'replace',
						'remove': [],
						'insert': [{ 'type': 'table' }, { 'type': 'tableSection', 'attributes': { 'style': 'body' } }, { 'type': 'tableRow' }, { 'type': 'tableCell', 'attributes': { 'style': 'data' } }, { 'type': 'paragraph' }, 'F', 'O', 'O', { 'type': '/paragraph' }, { 'type': '/tableCell' }, { 'type': '/tableRow' }, { 'type': '/tableSection' }, { 'type': '/table' }]
					},
					{ 'type': 'retain', 'length': 10 }
				]
			},
			'text at a structural location in the document is wrapped in a paragraph': {
				'args': [doc, 0, ['F', 'O', 'O']],
				'ops': [
					{
						'type': 'replace',
						'remove': [],
						'insert': [{ 'type': 'paragraph' }, 'F', 'O', 'O', { 'type': '/paragraph' }]
					},
					{ 'type': 'retain', 'length': 63 }
				]
			},
			'text inside a paragraph is not wrapped in a paragraph': {
				'args': [doc, 16, ['F', 'O', 'O']],
				'ops': [
					{ 'type': 'retain', 'length': 16 },
					{
						'type': 'replace',
						'remove': [],
						'insert': ['F', 'O', 'O']
					},
					{ 'type': 'retain', 'length': 47 }
				]
			},
			'text inside a heading is not wrapped in a paragraph': {
				'args': [doc, 2, ['F', 'O', 'O']],
				'ops': [
					{ 'type': 'retain', 'length': 2 },
					{
						'type': 'replace',
						'remove': [],
						'insert': ['F', 'O', 'O']
					},
					{ 'type': 'retain', 'length': 61 }
				]
			},
			'text inside a tableSection moves all the way to the end of the table and is wrapped in a paragraph': {
				'args': [doc, 34, ['F', 'O', 'O']],
				'ops': [
					{ 'type': 'retain', 'length': 37 },
					{
						'type': 'replace',
						'remove': [],
						'insert': [{ 'type': 'paragraph' }, 'F', 'O', 'O', { 'type': '/paragraph' }]
					},
					{ 'type': 'retain', 'length': 26 }
				]
			},
			'insert two complete paragraphs into start of paragraph moves insertion point left': {
				'args': [doc, 10, [{ 'type': 'paragraph' }, 'F', 'O', 'O', { 'type': '/paragraph' }, { 'type': 'paragraph' }, 'B', 'A', 'R', { 'type': '/paragraph' }]],
				'ops': [
					{ 'type': 'retain', 'length': 9 },
					{
						'type': 'replace',
						'remove': [],
						'insert': [{ 'type': 'paragraph' }, 'F', 'O', 'O', { 'type': '/paragraph' }, { 'type': 'paragraph' }, 'B', 'A', 'R', { 'type': '/paragraph' }]
					},
					{ 'type': 'retain', 'length': 54 }
				]
			},
			'insert text, close paragraph and open heading into end of paragraph moves insertion point right': {
				'args': [doc, 57, ['F', 'O', 'O', { 'type': '/paragraph' }, { 'type': 'heading', 'attributes': { 'level': 1 } }, 'B', 'A', 'R']],
				'ops': [
					{ 'type': 'retain', 'length': 58 },
					{
						'type': 'replace',
						'remove': [],
						'insert': [{ 'type': 'paragraph' }, 'F', 'O', 'O', { 'type': '/paragraph' }, { 'type': 'heading', 'attributes': { 'level': 1 } }, 'B', 'A', 'R', { 'type': '/heading' }]
					},
					{ 'type': 'retain', 'length': 5 }
				]
			},
			'insert heading and incomplete paragraph into heading': {
				'args': [doc, 2, [{ 'type': 'heading', 'attributes': { 'level': 1 } }, 'F', 'O', 'O', { 'type': '/heading' }, { 'type': 'paragraph' }, 'B', 'A', 'R']],
				'ops': [
					{ 'type': 'retain', 'length': 2 },
					{
						'type': 'replace',
						'remove': [],
						'insert': [
							{ 'type': '/heading' }, { 'type': 'heading', 'attributes': { 'level': 1 } }, 'F', 'O', 'O', { 'type': '/heading' },
							{ 'type': 'paragraph' }, 'B', 'A', 'R', { 'type': '/paragraph' },
							{ 'type': 'heading', 'attributes': { 'level': 1 } }
						]
					},
					{ 'type': 'retain', 'length': 61 }
				]
			},
			'inserting two paragraphs into a document with just an empty paragraph': {
				'args': [doc2, 1, ['F', 'O', 'O', { 'type': '/paragraph' }, { 'type': 'paragraph' }, 'B', 'A', 'R']],
				'ops': [
					{ 'type': 'retain', 'length': 1 },
					{
						'type': 'replace',
						'remove': [],
						'insert': ['F', 'O', 'O', { 'type': '/paragraph' }, { 'type': 'paragraph' }, 'B', 'A', 'R']
					},
					{ 'type': 'retain', 'length': 1 }
				]
			},
			'inserting three paragraphs into a document with just an empty paragraph': {
				'args': [doc2, 1, ['F', 'O', 'O', { 'type': '/paragraph' }, { 'type': 'paragraph' }, 'B', 'A', 'R', { 'type': '/paragraph' }, { 'type': 'paragraph' }, 'B', 'A', 'Z']],
				'ops': [
					{ 'type': 'retain', 'length': 1 },
					{
						'type': 'replace',
						'remove': [],
						'insert': ['F', 'O', 'O', { 'type': '/paragraph' }, { 'type': 'paragraph' }, 'B', 'A', 'R', { 'type': '/paragraph' }, { 'type': 'paragraph' }, 'B', 'A', 'Z']
					},
					{ 'type': 'retain', 'length': 1 }
				]
			},
			'inserting one paragraph into empty paragraph moves insertion before': {
				'args': [doc2, 1, [{ 'type': 'paragraph' }, 'F', 'O', 'O', { 'type': '/paragraph' }]],
				'ops': [
					{
						'type': 'replace',
						'remove': [],
						'insert': [{ 'type': 'paragraph' }, 'F', 'O', 'O', { 'type': '/paragraph' }]
					},
					{ 'type': 'retain', 'length': 2 }
				]
			},
			'inserting paragraph at end of paragraph moves insertion point forward': {
				'args': [doc3, 4, [{ 'type': 'paragraph' }, 'B', 'A', 'R', { 'type': '/paragraph' }]],
				'ops': [
					{ 'type': 'retain', 'length': 5 },
					{
						'type': 'replace',
						'remove': [],
						'insert': [{ 'type': 'paragraph' }, 'B', 'A', 'R', { 'type': '/paragraph' }]
					}
				]
			},
			'inserting paragraph into middle of paragraph splits paragraph': {
				'args': [doc3, 2, [{ 'type': 'paragraph' }, 'B', 'A', 'R', { 'type': '/paragraph' }]],
				'ops': [
					{ 'type': 'retain', 'length': 2 },
					{
						'type': 'replace',
						'remove': [],
						'insert': [{ 'type': '/paragraph' }, { 'type': 'paragraph' }, 'B', 'A', 'R', { 'type': '/paragraph' }, { 'type': 'paragraph' }]
					},
					{ 'type': 'retain', 'length': 3 }
				]
			},
			'inserting paragraph into middle of list splits list': {
				'args': [isolationDoc, 11, [{ 'type': 'paragraph' }, 'B', 'A', 'R', { 'type': '/paragraph' }]],
				'ops': [
					{ 'type': 'retain', 'length': 11 },
					{
						'type': 'replace',
						'remove': [],
						'insert': [{ 'type': '/list' }, { 'type': 'paragraph' }, 'B', 'A', 'R', { 'type': '/paragraph' }, { 'type': 'list', 'attributes': { 'style': 'bullet' } }]
					},
					{ 'type': 'retain', 'length': 235 }
				]
			},
			'inserting paragraph between table cells splits table, tableSection and tableRow': {
				'args': [complexTableDoc, 40, [{ 'type': 'paragraph' }, 'B', 'A', 'R', { 'type': '/paragraph' }]],
				'ops': [
					{ 'type': 'retain', 'length': 40 },
					{
						'type': 'replace',
						'remove': [],
						'insert': [
							{ 'type': '/tableRow' }, { 'type': '/tableSection' }, { 'type': '/table' },
							{ 'type': 'paragraph' }, 'B', 'A', 'R', { 'type': '/paragraph' },
							{ 'type': 'table' }, { 'type': 'tableSection', 'attributes' : { 'style': 'body' } }, { 'type': 'tableRow' }
						]
					},
					{ 'type': 'retain', 'length': 13 }
				]
			},
			'preserving trailing metadata': {
				'args': [ listWithMetaDoc, 4, [ 'b' ] ],
				'ops': [
					{ 'type': 'retain', 'length': 4 },
					{
						'type': 'replace',
						'remove': [],
						'insert': [ 'b' ]
					},
					{ 'type': 'retain', 'length': 8 },
					{ 'type': 'retainMetadata', 'length': 1 }
				]
			}
			// TODO test cases for unclosed openings
			// TODO test cases for (currently failing) unopened closings use case
			// TODO analyze other possible cases (substrings of linmod data)
		};
	QUnit.expect( ve.getObjectKeys( cases ).length );
	for ( key in cases ) {
		for ( i = 0; i < cases[key].ops.length; i++ ) {
			if ( cases[key].ops[i].remove ) {
				ve.dm.example.preprocessAnnotations( cases[key].ops[i].remove, doc.getStore() );
			}
			if ( cases[key].ops[i].insert ) {
				ve.dm.example.preprocessAnnotations( cases[key].ops[i].insert, doc.getStore() );
			}
		}
	}
	runConstructorTests( assert, ve.dm.Transaction.newFromInsertion, cases );
} );

QUnit.test( 'newFromRemoval', function ( assert ) {
	var i, key, store,
		doc = ve.dm.example.createExampleDocument( 'data' ),
		alienDoc = ve.dm.example.createExampleDocument( 'alienData' ),
		metaDoc = ve.dm.example.createExampleDocument( 'withMeta' ),
		internalDoc = ve.dm.example.createExampleDocument( 'internalData' ),
		cases = {
			'content in first element': {
				'args': [doc, new ve.Range( 1, 3 )],
				'ops': [
					{ 'type': 'retain', 'length': 1 },
					{
						'type': 'replace',
						'remove': [
							'a',
							['b', [ ve.dm.example.bold ]]
						],
						'insert': []
					},
					{ 'type': 'retain', 'length': 60 }
				]
			},
			'content in last element': {
				'args': [doc, new ve.Range( 59, 60 )],
				'ops': [
					{ 'type': 'retain', 'length': 59 },
					{
						'type': 'replace',
						'remove': ['m'],
						'insert': []
					},
					{ 'type': 'retain', 'length': 3 }
				]
			},
			'first element': {
				'args': [doc, new ve.Range( 0, 5 )],
				'ops': [
					{
						'type': 'replace',
						'remove': [
							{ 'type': 'heading', 'attributes': { 'level': 1 } },
							'a',
							['b', [ ve.dm.example.bold ]],
							['c', [ ve.dm.example.italic ]],
							{ 'type': '/heading' }
						],
						'insert': []
					},
					{ 'type': 'retain', 'length': 58 }
				]
			},
			'middle element with image': {
				'args': [doc, new ve.Range( 38, 42 )],
				'ops': [
					{ 'type': 'retain', 'length': 38 },
					{
						'type': 'replace',
						'remove': [
							'h',
							ve.dm.example.image.data,
							{ 'type': '/image' },
							'i'
						],
						'insert': []
					},
					{ 'type': 'retain', 'length': 21 }
				]
			},
			'extra openings': {
				'args': [doc, new ve.Range( 0, 7 )],
				'ops': [
					{
						'type': 'replace',
						'remove': [
							{ 'type': 'heading', 'attributes': { 'level': 1 } },
							'a',
							['b', [ ve.dm.example.bold ]],
							['c', [ ve.dm.example.italic ]],
							{ 'type': '/heading' }
						],
						'insert': []
					},
					{ 'type': 'retain', 'length': 58 }
				]
			},
			'last element': {
				'args': [doc, new ve.Range( 58, 61 )],
				'ops': [
					{ 'type': 'retain', 'length': 58 },
					{
						'type': 'replace',
						'remove': [{ 'type': 'paragraph' }, 'm', { 'type': '/paragraph' }],
						'insert': []
					},
					{ 'type': 'retain', 'length': 2 }
				]
			},
			'extra closings': {
				'args': [doc, new ve.Range( 31, 39 )],
				'ops': [
					{ 'type': 'retain', 'length': 38 },
					{
						'type': 'replace',
						'remove': ['h'],
						'insert': []
					},
					{ 'type': 'retain', 'length': 24 }
				]
			},
			'merge last two elements': {
				'args': [doc, new ve.Range( 57, 59 )],
				'ops': [
					{ 'type': 'retain', 'length': 57 },
					{
						'type': 'replace',
						'remove': [{ 'type': '/paragraph' }, { 'type': 'paragraph' }],
						'insert': []
					},
					{ 'type': 'retain', 'length': 4 }
				]
			},
			'strip out of paragraph in tableCell and paragraph in listItem': {
				'args': [doc, new ve.Range( 10, 16 )],
				'ops': [
					{ 'type': 'retain', 'length': 10 },
					{
						'type': 'replace',
						'remove': ['d'],
						'insert': []
					},
					{ 'type': 'retain', 'length': 4 },
					{
						'type': 'replace',
						'remove': ['e'],
						'insert': []
					},
					{ 'type': 'retain', 'length': 47 }
				]
			},
			'over first alien into paragraph': {
				'args': [alienDoc, new ve.Range( 0, 4 )],
				'ops': [
					{
						'type': 'replace',
						'remove': [{ 'type': 'alienBlock' }, { 'type': '/alienBlock' }],
						'insert': []
					},
					{ 'type': 'retain', 'length': 1 },
					{
						'type': 'replace',
						'remove': ['a'],
						'insert': []
					},
					{ 'type': 'retain', 'length': 8 }
				]
			},
			'out of paragraph over last alien': {
				'args': [alienDoc, new ve.Range( 6, 10 )],
				'ops': [
					{ 'type': 'retain', 'length': 6 },
					{
						'type': 'replace',
						'remove': ['b'],
						'insert': []
					},
					{ 'type': 'retain', 'length': 1 },
					{
						'type': 'replace',
						'remove': [{ 'type': 'alienBlock' }, { 'type': '/alienBlock' }],
						'insert': []
					},
					{ 'type': 'retain', 'length': 2 }
				]
			},
			'merging two paragraphs inside definitionListItems': {
				'args': [doc, new ve.Range( 47, 51 )],
				'ops': [
					{ 'type': 'retain', 'length': 47 },
					{
						'type': 'replace',
						'remove': [{ 'type': '/paragraph' }, { 'type': '/definitionListItem' }, { 'type': 'definitionListItem', 'attributes': { 'style': 'definition' } }, { 'type': 'paragraph' }],
						'insert': []
					},
					{ 'type': 'retain', 'length': 12 }
				]
			},
			'merging two paragraphs while also deleting some content': {
				'args': [doc, new ve.Range( 56, 59 )],
				'ops': [
					{ 'type': 'retain', 'length': 56 },
					{
						'type': 'replace',
						'remove': ['l', { 'type': '/paragraph' }, { 'type': 'paragraph' } ],
						'insert': []
					},
					{ 'type': 'retain', 'length': 4 }
				]
			},
			'removing from a heading into a paragraph': {
				'args': [doc, new ve.Range( 2, 57 )],
				'ops': [
					{ 'type': 'retain', 'length': 2 },
					{
						'type': 'replace',
						'remove': doc.getData().slice( 2, 4 ),
						'insert': []
					},
					{ 'type': 'retain', 'length': 1 },
					{
						'type': 'replace',
						'remove': doc.getData().slice( 5, 55 ),
						'insert': []
					},
					{ 'type': 'retain', 'length': 1 },
					{
						'type': 'replace',
						'remove': ['l'],
						'insert': []
					},
					{ 'type': 'retain', 'length': 6 }
				]
			},
			'removing content from a paragraph in the middle': {
				'args': [doc, new ve.Range( 56, 57 )],
				'ops': [
					{ 'type': 'retain', 'length': 56 },
					{
						'type': 'replace',
						'remove': ['l'],
						'insert': []
					},
					{ 'type': 'retain', 'length': 6 }
				]
			},
			'removing content spanning metadata': {
				'args': [metaDoc, new ve.Range( 7, 9 )],
				'ops': [
					{ 'type': 'retain', 'length': 7 },
					{
						'type': 'replace',
						'remove': ['B', 'a'],
						'insert': [],
						'removeMetadata': metaDoc.getMetadata().slice( 7, 9 ),
						'insertMetadata': []
					},
					{
						'type': 'replaceMetadata',
						'remove': [],
						'insert': ve.dm.MetaLinearData.static.merge( metaDoc.getMetadata().slice( 7, 9 ) )[0]
					},
					{ 'type': 'retain', 'length': 4 }
				]
			},
			'selection including internal nodes doesn\'t remove them': {
				'args': [internalDoc, new ve.Range( 2, 24 )],
				'ops': [
					{ 'type': 'retain', 'length': 2 },
					{
						'type': 'replace',
						'remove': [
							'o', 'o',
							{ 'type': '/paragraph' }
						],
						'insert': []
					},
					{ 'type': 'retain', 'length': 16 },
					{
						'type': 'replace',
						'remove': [
							{ 'type': 'paragraph' },
							'Q', 'u'
						],
						'insert': []
					},
					{ 'type': 'retain', 'length': 3 }
				]
			},
			'selection ending with internal nodes': {
				'args': [internalDoc, new ve.Range( 2, 21 )],
				'ops': [
					{ 'type': 'retain', 'length': 2 },
					{
						'type': 'replace',
						'remove': [
							'o', 'o'
						],
						'insert': []
					},
					{ 'type': 'retain', 'length': 23 }
				]
			},
			'selection starting with internal nodes': {
				'args': [internalDoc, new ve.Range( 5, 24 )],
				'ops': [
					{ 'type': 'retain', 'length': 22 },
					{
						'type': 'replace',
						'remove': [
							'Q', 'u'
						],
						'insert': []
					},
					{ 'type': 'retain', 'length': 3 }
				]
			},
			'selection of just internal nodes returns a no-op transaction': {
				'args': [internalDoc, new ve.Range( 5, 21 )],
				'ops': [
					{ 'type': 'retain', 'length': 27 }
				]
			}
		};
	QUnit.expect( ve.getObjectKeys( cases ).length );
	for ( key in cases ) {
		for ( i = 0; i < cases[key].ops.length; i++ ) {
			store = cases[key].args[0].getStore();
			if ( cases[key].ops[i].remove ) {
				ve.dm.example.preprocessAnnotations( cases[key].ops[i].remove, store );
			}
			if ( cases[key].ops[i].insert ) {
				ve.dm.example.preprocessAnnotations( cases[key].ops[i].insert, store );
			}
		}
	}
	runConstructorTests( assert, ve.dm.Transaction.newFromRemoval, cases );
} );

QUnit.test( 'newFromDocumentReplace', function ( assert ) {
	var i, j, doc2, tx, actualStoreItems, expectedStoreItems,
		doc = ve.dm.example.createExampleDocument( 'internalData' ),
		nextIndex = doc.store.valueStore.length,
		whee = [ { 'type': 'paragraph' }, 'W', 'h', 'e', 'e', { 'type': '/paragraph' } ],
		wheeItem = [ { 'type': 'internalItem' } ].concat( whee ).concat( [ { 'type': '/internalItem' } ] ),
		cases = [
			{
				'msg': 'simple insertion',
				'doc': 'internalData',
				'range': new ve.Range( 7, 12 ),
				'modify': function ( newDoc ) {
					// Change "Bar" to "Bazaar"
					newDoc.commit( ve.dm.Transaction.newFromInsertion(
						newDoc, 3, [ 'z', 'a', 'a' ]
					) );
				},
				'expectedOps': [
					{ 'type': 'retain', 'length': 6 },
					{
						'type': 'replace',
						'remove': doc.getData( new ve.Range( 6, 20 ) ),
						'insert': doc.getData( new ve.Range( 6, 10 ) )
							.concat( [ 'z', 'a', 'a' ] )
							.concat( doc.getData( new ve.Range( 10, 20 ) ) )
					},
					{ 'type': 'retain', 'length': 7 }
				]
			},
			{
				'msg': 'simple annotation',
				'doc': 'internalData',
				'range': doc.getInternalList().getItemNode( 1 ),
				'modify': function ( newDoc ) {
					// Bold the first two characters
					newDoc.commit( ve.dm.Transaction.newFromAnnotation(
						newDoc, new ve.Range( 1, 3 ), 'set', ve.dm.example.bold
					) );
				},
				'expectedOps': [
					{ 'type': 'retain', 'length': 6 },
					{
						'type': 'replace',
						'remove': doc.getData( new ve.Range( 6, 20 ) ),
						'insert': doc.getData( new ve.Range( 6, 15 ) )
							.concat( [ [ doc.data.getData( 15 ), [ nextIndex ] ] ] )
							.concat( [ [ doc.data.getData( 16 ), [ nextIndex ] ] ] )
							.concat( doc.getData( new ve.Range( 17, 20 ) ) )
					},
					{ 'type': 'retain', 'length': 7 }
				],
				'expectedStoreItems': [
					ve.dm.example.bold
				]
			},
			{
				'msg': 'insertion into internal list',
				'doc': 'internalData',
				'range': new ve.Range( 21, 27 ),
				'modify': function ( newDoc ) {
					var insertion = newDoc.internalList.getItemInsertion( 'test', 'whee', whee );
					newDoc.commit( insertion.transaction );
				},
				'expectedOps': [
					{ 'type': 'retain', 'length': 6 },
					{
						'type': 'replace',
						'remove': doc.getData( new ve.Range( 6, 20 ) ),
						'insert': doc.getData( new ve.Range( 6, 20 ) ).concat( wheeItem )
					},
					{ 'type': 'retain', 'length': 1 },
					{
						'type': 'replace',
						'remove': doc.getData( new ve.Range( 21, 27 ) ),
						'insert': doc.getData( new ve.Range( 21, 27 ) )
					}
				]
			},
			{
				'msg': 'change in internal list',
				'doc': 'internalData',
				'range': new ve.Range( 21, 27 ),
				'modify': function ( newDoc ) {
					newDoc.commit( ve.dm.Transaction.newFromInsertion(
						newDoc, 12, [ '!', '!', '!' ]
					) );
				},
				'expectedOps': [
					{ 'type': 'retain', 'length': 6 },
					{
						'type': 'replace',
						'remove': doc.getData( new ve.Range( 6, 20 ) ),
						'insert': doc.getData( new ve.Range( 6, 11 ) )
							.concat( [ '!', '!', '!' ] )
							.concat( doc.getData( new ve.Range( 11, 20 ) ) )
					},
					{ 'type': 'retain', 'length': 1 },
					{
						'type': 'replace',
						'remove': doc.getData( new ve.Range( 21, 27 ) ),
						'insert': doc.getData( new ve.Range( 21, 27 ) )
					}
				]
			},
			{
				'msg': 'insertion into internal list from slice within internal list',
				'doc': 'internalData',
				'range': new ve.Range( 7, 12 ),
				'modify': function ( newDoc ) {
					var insertion = newDoc.internalList.getItemInsertion( 'test', 'whee', whee );
					newDoc.commit( insertion.transaction );
				},
				'expectedOps': [
					{ 'type': 'retain', 'length': 6 },
					{
						'type': 'replace',
						'remove': doc.getData( new ve.Range( 6, 20 ) ),
						'insert': doc.getData( new ve.Range( 6, 20 ) ).concat( wheeItem )
					},
					{ 'type': 'retain', 'length': 7 }
				]
			}
		];
	QUnit.expect( 2 * cases.length );
	for ( i = 0; i < cases.length; i++ ) {
		doc = ve.dm.example.createExampleDocument( cases[i].doc );
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
QUnit.test( 'newFromAttributeChanges', function ( assert ) {
	var doc = ve.dm.example.createExampleDocument(),
		cases = {
			'first element': {
				'args': [doc, 0, { 'level': 2 }],
				'ops': [
					{
						'type': 'attribute',
						'key': 'level',
						'from': 1,
						'to': 2
					},
					{ 'type': 'retain', 'length': 63 }
				]
			},
			'middle element': {
				'args': [doc, 17, { 'style': 'number'} ],
				'ops': [
					{ 'type': 'retain', 'length': 17 },
					{
						'type': 'attribute',
						'key': 'style',
						'from': 'bullet',
						'to': 'number'
					},
					{ 'type': 'retain', 'length': 46 }
				]
			},
			'multiple attributes': {
				'args': [doc, 17, { 'style': 'number', 'level': 1 } ],
				'ops': [
					{ 'type': 'retain', 'length': 17 },
					{
						'type': 'attribute',
						'key': 'style',
						'from': 'bullet',
						'to': 'number'
					},
					{
						'type': 'attribute',
						'key': 'level',
						'from': undefined,
						'to': 1
					},
					{ 'type': 'retain', 'length': 46 }
				]
			},
			'non-element': {
				'args': [doc, 1, { 'level': 2 }],
				'exception': Error
			},
			'closing element': {
				'args': [doc, 4, { 'level': 2 }],
				'exception': Error
			}
		};
	QUnit.expect( ve.getObjectKeys( cases ).length );
	runConstructorTests( assert, ve.dm.Transaction.newFromAttributeChanges, cases );
} );

QUnit.test( 'newFromAnnotation', function ( assert ) {
	var bold = ve.dm.example.createAnnotation( ve.dm.example.bold ),
		doc = ve.dm.example.createExampleDocument(),
		annotationDoc = ve.dm.example.createExampleDocument( 'annotationData' ),
		cases = {
			'over plain text': {
				'args': [doc, new ve.Range( 1, 2 ), 'set', bold],
				'ops': [
					{ 'type': 'retain', 'length': 1 },
					{
						'type': 'annotate',
						'method': 'set',
						'bias': 'start',
						'annotation': bold
					},
					{ 'type': 'retain', 'length': 1 },
					{
						'type': 'annotate',
						'method': 'set',
						'bias': 'stop',
						'annotation': bold
					},
					{ 'type': 'retain', 'length': 61 }
				]
			},
			'over annotated text': {
				'args': [doc, new ve.Range( 1, 4 ), 'set', bold],
				'ops': [
					{ 'type': 'retain', 'length': 1 },
					{
						'type': 'annotate',
						'method': 'set',
						'bias': 'start',
						'annotation': bold
					},
					{ 'type': 'retain', 'length': 1 },
					{
						'type': 'annotate',
						'method': 'set',
						'bias': 'stop',
						'annotation': bold
					},
					{ 'type': 'retain', 'length': 1 },
					{
						'type': 'annotate',
						'method': 'set',
						'bias': 'start',
						'annotation': bold
					},
					{ 'type': 'retain', 'length': 1 },
					{
						'type': 'annotate',
						'method': 'set',
						'bias': 'stop',
						'annotation': bold
					},
					{ 'type': 'retain', 'length': 59 }
				]
			},
			'over elements': {
				'args': [doc, new ve.Range( 4, 9 ), 'set', bold],
				'ops': [
					{ 'type': 'retain', 'length': 63 }
				]
			},
			'over elements and content': {
				'args': [doc, new ve.Range( 3, 11 ), 'set', bold],
				'ops': [
					{ 'type': 'retain', 'length': 3 },
					{
						'type': 'annotate',
						'method': 'set',
						'bias': 'start',
						'annotation': bold
					},
					{ 'type': 'retain', 'length': 1 },
					{
						'type': 'annotate',
						'method': 'set',
						'bias': 'stop',
						'annotation': bold
					},
					{ 'type': 'retain', 'length': 6 },
					{
						'type': 'annotate',
						'method': 'set',
						'bias': 'start',
						'annotation': bold
					},
					{ 'type': 'retain', 'length': 1 },
					{
						'type': 'annotate',
						'method': 'set',
						'bias': 'stop',
						'annotation': bold
					},
					{ 'type': 'retain', 'length': 52 }
				]
			},
			'over content and content element (image)': {
				'args': [doc, new ve.Range( 38, 42 ), 'set', bold],
				'ops': [
					{ 'type': 'retain', 'length': 38 },
					{
						'type': 'annotate',
						'method': 'set',
						'bias': 'start',
						'annotation': bold
					},
					{ 'type': 'retain', 'length': 4 },
					{
						'type': 'annotate',
						'method': 'set',
						'bias': 'stop',
						'annotation': bold
					},
					{ 'type': 'retain', 'length': 21 }
				]
			},
			'over content and unannotatable content element (unboldable node)': {
				'args': [annotationDoc, new ve.Range( 1, 9 ), 'set', bold],
				'ops': [
					{ 'type': 'retain', 'length': 1 },
					{
						'type': 'annotate',
						'method': 'set',
						'bias': 'start',
						'annotation': bold
					},
					{ 'type': 'retain', 'length': 3 },
					{
						'type': 'annotate',
						'method': 'set',
						'bias': 'stop',
						'annotation': bold
					},
					{ 'type': 'retain', 'length': 2 },
					{
						'type': 'annotate',
						'method': 'set',
						'bias': 'start',
						'annotation': bold
					},
					{ 'type': 'retain', 'length': 3 },
					{
						'type': 'annotate',
						'method': 'set',
						'bias': 'stop',
						'annotation': bold
					},
					{ 'type': 'retain', 'length': 3 }
				]
			}
		};

	QUnit.expect( ve.getObjectKeys( cases ).length );
	runConstructorTests( assert, ve.dm.Transaction.newFromAnnotation, cases );
} );

QUnit.test( 'newFromContentBranchConversion', function ( assert ) {
	var i, key, store,
		doc = ve.dm.example.createExampleDocument(),
		doc2 = ve.dm.example.createExampleDocument( 'inlineAtEdges' ),
		cases = {
			'range inside a heading, convert to paragraph': {
				'args': [doc, new ve.Range( 1, 2 ), 'paragraph'],
				'ops': [
					{
						'type': 'replace',
						'remove': [{ 'type': 'heading', 'attributes': { 'level': 1 } }],
						'insert': [{ 'type': 'paragraph' }]
					},
					{ 'type': 'retain', 'length': 3 },
					{
						'type': 'replace',
						'remove': [{ 'type': '/heading' }],
						'insert': [{ 'type': '/paragraph' }]
					},
					{ 'type': 'retain', 'length': 58 }
				]
			},
			'range around 2 paragraphs, convert to preformatted': {
				'args': [doc, new ve.Range( 50, 58 ), 'preformatted'],
				'ops': [
					{ 'type': 'retain', 'length': 50 },
					{
						'type': 'replace',
						'remove': [{ 'type': 'paragraph' }],
						'insert': [{ 'type': 'preformatted' }]
					},
					{ 'type': 'retain', 'length': 1 },
					{
						'type': 'replace',
						'remove': [{ 'type': '/paragraph' }],
						'insert': [{ 'type': '/preformatted' }]
					},
					{ 'type': 'retain', 'length': 2 },
					{
						'type': 'replace',
						'remove': [{ 'type': 'paragraph' }],
						'insert': [{ 'type': 'preformatted' }]
					},
					{ 'type': 'retain', 'length': 1 },
					{
						'type': 'replace',
						'remove': [{ 'type': '/paragraph' }],
						'insert': [{ 'type': '/preformatted' }]
					},
					{ 'type': 'retain', 'length': 5 }
				]
			},
			'zero-length range before inline node at the start': {
				'args': [doc2, new ve.Range( 1, 1 ), 'heading', { 'level': 2 }],
				'ops': [
					{
						'type': 'replace',
						'remove': [{ 'type': 'paragraph' }],
						'insert': [{ 'type': 'heading', 'attributes': { 'level': 2 } }]
					},
					{ 'type': 'retain', 'length': 7 },
					{
						'type': 'replace',
						'remove': [{ 'type': '/paragraph' }],
						'insert': [{ 'type': '/heading' }]
					}
				]
			},
			'zero-length range inside inline node at the start': {
				'args': [doc2, new ve.Range( 2, 2 ), 'heading', { 'level': 2 }],
				'ops': [
					{
						'type': 'replace',
						'remove': [{ 'type': 'paragraph' }],
						'insert': [{ 'type': 'heading', 'attributes': { 'level': 2 } }]
					},
					{ 'type': 'retain', 'length': 7 },
					{
						'type': 'replace',
						'remove': [{ 'type': '/paragraph' }],
						'insert': [{ 'type': '/heading' }]
					}
				]
			},
			'zero-length range after inline node at the start': {
				'args': [doc2, new ve.Range( 3, 3 ), 'heading', { 'level': 2 }],
				'ops': [
					{
						'type': 'replace',
						'remove': [{ 'type': 'paragraph' }],
						'insert': [{ 'type': 'heading', 'attributes': { 'level': 2 } }]
					},
					{ 'type': 'retain', 'length': 7 },
					{
						'type': 'replace',
						'remove': [{ 'type': '/paragraph' }],
						'insert': [{ 'type': '/heading' }]
					}
				]
			},
			'zero-length range before inline node at the end': {
				'args': [doc2, new ve.Range( 6, 6 ), 'heading', { 'level': 2 }],
				'ops': [
					{
						'type': 'replace',
						'remove': [{ 'type': 'paragraph' }],
						'insert': [{ 'type': 'heading', 'attributes': { 'level': 2 } }]
					},
					{ 'type': 'retain', 'length': 7 },
					{
						'type': 'replace',
						'remove': [{ 'type': '/paragraph' }],
						'insert': [{ 'type': '/heading' }]
					}
				]
			},
			'zero-length range inside inline node at the end': {
				'args': [doc2, new ve.Range( 7, 7 ), 'heading', { 'level': 2 }],
				'ops': [
					{
						'type': 'replace',
						'remove': [{ 'type': 'paragraph' }],
						'insert': [{ 'type': 'heading', 'attributes': { 'level': 2 } }]
					},
					{ 'type': 'retain', 'length': 7 },
					{
						'type': 'replace',
						'remove': [{ 'type': '/paragraph' }],
						'insert': [{ 'type': '/heading' }]
					}
				]
			},
			'zero-length range after inline node at the end': {
				'args': [doc2, new ve.Range( 8, 8 ), 'heading', { 'level': 2 }],
				'ops': [
					{
						'type': 'replace',
						'remove': [{ 'type': 'paragraph' }],
						'insert': [{ 'type': 'heading', 'attributes': { 'level': 2 } }]
					},
					{ 'type': 'retain', 'length': 7 },
					{
						'type': 'replace',
						'remove': [{ 'type': '/paragraph' }],
						'insert': [{ 'type': '/heading' }]
					}
				]
			}
		};
	QUnit.expect( ve.getObjectKeys( cases ).length );
	for ( key in cases ) {
		for ( i = 0; i < cases[key].ops.length; i++ ) {
			store = cases[key].args[0].getStore();
			if ( cases[key].ops[i].remove ) {
				ve.dm.example.preprocessAnnotations( cases[key].ops[i].remove, store );
			}
			if ( cases[key].ops[i].insert ) {
				ve.dm.example.preprocessAnnotations( cases[key].ops[i].insert, store );
			}
		}
	}
	runConstructorTests(
		assert,
		ve.dm.Transaction.newFromContentBranchConversion,
		cases
	);
} );

QUnit.test( 'newFromWrap', function ( assert ) {
	var i, key,
		doc = ve.dm.example.createExampleDocument(),
		metaDoc = ve.dm.example.createExampleDocument( 'withMeta' ),
		listMetaDoc = ve.dm.example.createExampleDocument( 'listWithMeta' ),
		listDoc = ve.dm.example.createExampleDocumentFromObject( 'listDoc', null, { 'listDoc': listMetaDoc.getData() } ),
		cases = {
			'changes a heading to a paragraph': {
				'args': [doc, new ve.Range( 1, 4 ), [ { 'type': 'heading', 'attributes': { 'level': 1 } } ], [ { 'type': 'paragraph' } ], [], []],
				'ops': [
					{ 'type': 'replace', 'remove': [ { 'type': 'heading', 'attributes': { 'level': 1 } } ], 'insert': [ { 'type': 'paragraph' } ] },
					{ 'type': 'retain', 'length': 3 },
					{ 'type': 'replace', 'remove': [ { 'type': '/heading' } ], 'insert': [ { 'type': '/paragraph' } ] },
					{ 'type': 'retain', 'length': 58 }
				]
			},
			'unwraps a list': {
				'args': [doc, new ve.Range( 13, 25 ), [ { 'type': 'list' } ], [], [ { 'type': 'listItem' } ], []],
				'ops': [
					{ 'type': 'retain', 'length': 12 },
					{
						'type': 'replace',
						'remove': [ { 'type': 'list', 'attributes': { 'style': 'bullet' } }, { 'type': 'listItem' } ],
						'insert': []
					},
					{ 'type': 'retain', 'length': 10 },
					{ 'type': 'replace', 'remove': [ { 'type': '/listItem' }, { 'type': '/list' } ], 'insert': [] },
					{ 'type': 'retain', 'length': 37 }
				]
			},
			'unwraps a multiple-item list': {
				'args': [listDoc, new ve.Range( 1, 11 ), [ { 'type': 'list' } ], [], [ { 'type': 'listItem', 'attributes': {'styles': ['bullet']} } ], [] ],
				'ops': [
					{ 'type': 'replace',
					  'remove': [ { 'type': 'list' }, { 'type': 'listItem', 'attributes': { 'styles': ['bullet'] } } ],
					  'insert': []
					},
					{ 'type': 'retain', 'length': 3 },
					{ 'type': 'replace',
					  'remove': [ { 'type': '/listItem' }, { 'type': 'listItem', 'attributes': { 'styles': ['bullet'] } } ],
					  'insert': []
					},
					{ 'type': 'retain', 'length': 3 },
					{ 'type': 'replace',
					  'remove': [ { 'type': '/listItem' }, { 'type': '/list' } ],
					  'insert': []
					}
				]
			},
			'replaces a table with a list': {
				'args': [doc, new ve.Range( 9, 33 ), [ { 'type': 'table' }, { 'type': 'tableSection', 'attributes': { 'style': 'body' } }, { 'type': 'tableRow' }, { 'type': 'tableCell' } ], [ { 'type': 'list' }, { 'type': 'listItem' } ], [], []],
				'ops': [
					{ 'type': 'retain', 'length': 5 },
					{ 'type': 'replace', 'remove': [ { 'type': 'table' }, { 'type': 'tableSection', 'attributes': { 'style': 'body' } }, { 'type': 'tableRow' }, { 'type': 'tableCell', 'attributes': { 'style': 'data' } } ], 'insert': [ { 'type': 'list' }, { 'type': 'listItem' } ] },
					{ 'type': 'retain', 'length': 24 },
					{ 'type': 'replace', 'remove': [ { 'type': '/tableCell' }, { 'type': '/tableRow' }, { 'type': '/tableSection' }, { 'type': '/table' } ], 'insert': [ { 'type': '/listItem' }, { 'type': '/list' } ] },
					{ 'type': 'retain', 'length': 26 }
				]
			},
			'wraps two adjacent paragraphs in a list': {
				'args': [doc, new ve.Range( 55, 61 ), [], [ { 'type': 'list', 'attributes': { 'style': 'number' } } ], [], [ { 'type': 'listItem' } ]],
				'ops': [
					{ 'type': 'retain', 'length': 55 },
					{
						'type': 'replace',
						'remove': [],
						'insert': [ { 'type': 'list', 'attributes': { 'style': 'number' } }, { 'type': 'listItem' } ]
					},
					{ 'type': 'retain', 'length': 3 },
					{ 'type': 'replace', 'remove': [], 'insert': [ { 'type': '/listItem' }, { 'type': 'listItem' } ] },
					{ 'type': 'retain', 'length': 3 },
					{ 'type': 'replace', 'remove': [], 'insert': [ { 'type': '/listItem' }, { 'type': '/list' } ] },
					{ 'type': 'retain', 'length': 2 }
				]
			},
			'wraps two adjacent paragraphs in a definitionList': {
				'args': [doc, new ve.Range( 55, 61 ), [], [ { 'type': 'definitionList' } ], [], [ { 'type': 'definitionListItem', 'attributes': { 'style': 'term' } } ]],
				'ops': [
					{ 'type': 'retain', 'length': 55 },
					{
						'type': 'replace',
						'remove': [],
						'insert': [ { 'type': 'definitionList' }, { 'type': 'definitionListItem', 'attributes': { 'style': 'term' } } ]
					},
					{ 'type': 'retain', 'length': 3 },
					{
						'type': 'replace',
						'remove': [],
						'insert': [ { 'type': '/definitionListItem' }, { 'type': 'definitionListItem', 'attributes': { 'style': 'term' } } ]
					},
					{ 'type': 'retain', 'length': 3 },
					{ 'type': 'replace', 'remove': [], 'insert': [ { 'type': '/definitionListItem' }, { 'type': '/definitionList' } ] },
					{ 'type': 'retain', 'length': 2 }
				]
			},
			'metadata is preserved on wrap': {
				'args': [metaDoc, new ve.Range( 1, 10 ), [ { 'type': 'paragraph' } ], [ { 'type': 'heading', 'level': 1 } ], [], [] ],
				'ops': [
					{ 'type': 'replace',
					  'remove': [ { 'type': 'paragraph' } ],
					  'insert': [ { 'type': 'heading', 'level': 1 } ],
					  'insertMetadata': metaDoc.getMetadata().slice(0, 1),
					  'removeMetadata': metaDoc.getMetadata().slice(0, 1)
					},
					{ 'type': 'retain', 'length': 9 },
					{ 'type': 'replace',
					  'remove': [ { 'type': '/paragraph' } ],
					  'insert': [ { 'type': '/heading' } ]
					},
					{ 'type': 'retain', 'length': 2 }
				]
			},
			'metadata is preserved on unwrap': {
				'args': [listMetaDoc, new ve.Range( 1, 11 ), [ { 'type': 'list' } ], [], [ { 'type': 'listItem', 'attributes': {'styles': ['bullet']} } ], [] ],
				'ops': [
					{ 'type': 'replace',
					  'remove': [ { 'type': 'list' }, { 'type': 'listItem', 'attributes': { 'styles': ['bullet'] } } ],
					  'insert': [],
					  'insertMetadata': [],
					  'removeMetadata': listMetaDoc.getMetadata().slice(0, 2)
					},
					{ 'type': 'replaceMetadata',
					  'insert': ve.dm.MetaLinearData.static.merge( listMetaDoc.getMetadata().slice(0, 2) )[0],
					  'remove': []
					},
					{ 'type': 'retain', 'length': 3 },
					{ 'type': 'replace',
					  'remove': [ { 'type': '/listItem' }, { 'type': 'listItem', 'attributes': { 'styles': ['bullet'] } } ],
					  'insert': [],
					  'insertMetadata': [],
					  'removeMetadata': listMetaDoc.getMetadata().slice(5, 7)
					},
					{ 'type': 'replaceMetadata',
					  'insert': ve.dm.MetaLinearData.static.merge( listMetaDoc.getMetadata().slice(5, 7) )[0],
					  'remove': []
					},
					{ 'type': 'retain', 'length': 3 },
					{ 'type': 'replace',
					  'remove': [ { 'type': '/listItem' }, { 'type': '/list' } ],
					  'insert': [],
					  'insertMetadata': [],
					  'removeMetadata': listMetaDoc.getMetadata().slice(10, 12)
					},
					{ 'type': 'replaceMetadata',
					  'insert': ve.dm.MetaLinearData.static.merge( listMetaDoc.getMetadata().slice(10, 12) )[0],
					  'remove': []
					},
					{ 'type': 'retainMetadata', 'length': 1 }
				]
			},
			'checks integrity of unwrapOuter parameter': {
				'args': [doc, new ve.Range( 13, 32 ), [ { 'type': 'table' } ], [], [], []],
				'exception': Error
			},
			'checks integrity of unwrapEach parameter': {
				'args': [doc, new ve.Range( 13, 32 ), [ { 'type': 'list' } ], [], [ { 'type': 'paragraph' } ], []],
				'exception': Error
			},
			'checks that unwrapOuter fits before the range': {
				'args': [doc, new ve.Range( 1, 4 ), [ { 'type': 'listItem' }, { 'type': 'paragraph' } ], [], [], []],
				'exception': Error
			}
		};
	QUnit.expect( ve.getObjectKeys( cases ).length );
	for ( key in cases ) {
		for ( i = 0; cases[key].ops && i < cases[key].ops.length; i++ ) {
			if ( cases[key].ops[i].remove ) {
				ve.dm.example.preprocessAnnotations( cases[key].ops[i].remove, doc.getStore() );
			}
			if ( cases[key].ops[i].insert ) {
				ve.dm.example.preprocessAnnotations( cases[key].ops[i].insert, doc.getStore() );
			}
		}
	}
	runConstructorTests(
		assert,
		ve.dm.Transaction.newFromWrap,
		cases
	);
} );

QUnit.test( 'translateOffset', function ( assert ) {
	var mapping, offset, expected,
		doc = new ve.dm.Document( '-----defg---h--'.split( '' ) ),
		tx = new ve.dm.Transaction();

	tx.pushReplace( doc, 0, 0, ['a','b','c'] );
	tx.pushRetain( 5 );
	tx.pushReplace( doc, 5, 4, [] );
	tx.pushRetain( 2 );
	tx.pushStartAnnotating( 'set', { 'type': 'textStyle/bold' } );
	tx.pushRetain( 1 );
	tx.pushReplace( doc, 12, 1, ['i', 'j', 'k', 'l', 'm'] );
	tx.pushRetain( 2 );
	tx.pushReplace( doc, 15, 0, ['n', 'o', 'p'] );

	mapping = {
		0: [0, 3],
		1: 4,
		2: 5,
		3: 6,
		4: 7,
		5: 8,
		6: 8,
		7: 8,
		8: 8,
		9: 8,
		10: 9,
		11: 10,
		12: 11,
		13: [12, 16],
		14: 17,
		15: [18, 21],
		16: 22
	};
	QUnit.expect( 2*ve.getObjectKeys( mapping ).length );
	for ( offset in mapping ) {
		expected = ve.isArray( mapping[offset] ) ? mapping[offset] : [ mapping[offset], mapping[offset] ];
		assert.strictEqual( tx.translateOffset( Number( offset ) ), expected[1], offset );
		assert.strictEqual( tx.translateOffset( Number( offset ), true ), expected[0], offset + ' (excludeInsertion)' );
	}
} );

QUnit.test( 'translateRange', function ( assert ) {
	var i, cases,
		doc = ve.dm.example.createExampleDocument(),
		tx = new ve.dm.Transaction();
	tx.pushRetain( 55 );
	tx.pushReplace( doc, 55, 0, [ { 'type': 'list', 'attributes': { 'style': 'number' } } ] );
	tx.pushReplace( doc, 55, 0, [ { 'type': 'listItem' } ] );
	tx.pushRetain( 3 );
	tx.pushReplace( doc, 58, 0, [ { 'type': '/listItem' } ] );
	tx.pushReplace( doc, 58, 0, [ { 'type': 'listItem' } ] );
	tx.pushRetain( 3 );
	tx.pushReplace( doc, 61, 0, [ { 'type': '/listItem' } ] );
	tx.pushReplace( doc, 61, 0, [ { 'type': '/list' } ] );

	cases = [
		{
			'before': new ve.Range( 55, 61 ),
			'after': new ve.Range( 55, 67 ),
			'msg': 'Wrapped range is translated to outer range'
		},
		{
			'before': new ve.Range( 54, 62 ),
			'after': new ve.Range( 54, 68 ),
			'msg': 'Wrapped range plus one each side is translated to outer range plus one each side'
		},
		{
			'before': new ve.Range( 54, 61 ),
			'after': new ve.Range( 54, 67 ),
			'msg': 'Wrapped range plus one on the left'
		},
		{
			'before': new ve.Range( 55, 62 ),
			'after': new ve.Range( 55, 68 ),
			'msg': 'wrapped range plus one on the right'
		}
	];
	QUnit.expect( cases.length * 2 );

	for ( i = 0; i < cases.length; i++ ) {
		assert.deepEqual( tx.translateRange( cases[i].before ), cases[i].after, cases[i].msg );
		assert.deepEqual( tx.translateRange( cases[i].before.flip() ), cases[i].after.flip(), cases[i].msg + ' (reversed)' );
	}
} );

QUnit.test( 'pushRetain', 4, function ( assert ) {
	var cases = {
		'retain': {
			'calls': [['pushRetain', 5]],
			'ops': [{ 'type': 'retain', 'length': 5 }],
			'diff': 0
		},
		'multiple retain': {
			'calls': [['pushRetain', 5], ['pushRetain', 3]],
			'ops': [{ 'type': 'retain', 'length': 8 }],
			'diff': 0
		}
	};
	runBuilderTests( assert, cases );
} );

QUnit.test( 'pushReplace', function ( assert ) {
	var doc = new ve.dm.Document( [{ 'type': 'paragraph' }, 'a', 'b', 'c', { 'type': '/paragraph' }] ),
		doc2 = new ve.dm.Document( [{ 'type': 'paragraph' }, 'a', 'b', 'c', 'g', 'h', 'i', { 'type': '/paragraph' }] ),
		cases = {
			'insert': {
				'calls': [
					['pushReplace', doc, 0, 0, [{ 'type': 'paragraph' }, 'a', 'b', 'c', { 'type': '/paragraph' }]]
				],
				'ops': [
					{
						'type': 'replace',
						'remove': [],
						'insert': [{ 'type': 'paragraph' }, 'a', 'b', 'c', { 'type': '/paragraph' }]
					}
				],
				'diff': 5
			},
			'multiple insert': {
				'calls': [
					['pushReplace', doc, 0, 0, [{ 'type': 'paragraph' }, 'a', 'b']],
					['pushReplace', doc, 0, 0, ['c', { 'type': '/paragraph' }]]
				],
				'ops': [
					{
						'type': 'replace',
						'remove': [],
						'insert': [{ 'type': 'paragraph' }, 'a', 'b', 'c', { 'type': '/paragraph' }]
					}
				],
				'diff': 5
			},
			'insert and retain': {
				'calls': [
					['pushRetain', 1],
					['pushReplace', doc, 0, 0, ['a', 'b', 'c']]
				],
				'ops': [
					{ 'type': 'retain', 'length': 1 },
					{ 'type': 'replace', 'remove': [], 'insert': ['a', 'b', 'c'] }
				],
				'diff': 3
			},
			'remove': {
				'calls': [
					['pushReplace', doc, 0, 5, []]
				],
				'ops': [
					{
						'type': 'replace',
						'remove': [{ 'type': 'paragraph' }, 'a', 'b', 'c', { 'type': '/paragraph' }],
						'insert': []
					}
				],
				'diff': -5
			},
			'multiple remove': {
				'calls': [
					['pushReplace', doc, 0, 3, []],
					['pushReplace', doc, 3, 2, []]
				],
				'ops': [
					{
						'type': 'replace',
						'remove': [{ 'type': 'paragraph' }, 'a', 'b', 'c', { 'type': '/paragraph' }],
						'insert': []
					}
				],
				'diff': -5
			},
			'retain and remove': {
				'calls': [
					['pushRetain', 1],
					['pushReplace', doc, 1, 3, []]
				],
				'ops': [
					{ 'type': 'retain', 'length': 1 },
					{ 'type': 'replace', 'remove': ['a', 'b', 'c'], 'insert': [] }
				],
				'diff': -3
			},
			'replace': {
				'calls': [
					['pushReplace', doc, 1, 3, ['d', 'e', 'f']]
				],
				'ops': [
					{
						'type': 'replace',
						'remove': ['a', 'b', 'c'],
						'insert': ['d', 'e', 'f']
					}
				],
				'diff': 0
			},
			'multiple replace': {
				'calls': [
					['pushReplace', doc2, 1, 3, ['d', 'e', 'f']],
					['pushReplace', doc2, 4, 3, ['j', 'k', 'l']]
				],
				'ops': [
					{
						'type': 'replace',
						'remove': ['a', 'b', 'c', 'g', 'h', 'i'],
						'insert': ['d', 'e', 'f', 'j', 'k', 'l']
					}
				],
				'diff': 0
			}
		};
	QUnit.expect( 2*ve.getObjectKeys( cases ).length );
	runBuilderTests( assert, cases );
} );

QUnit.test( 'pushReplaceElementAttribute', function ( assert ) {
	var cases = {
		'replace element attribute': {
			'calls': [
				['pushReplaceElementAttribute', 'style', 'bullet', 'number']
			],
			'ops': [
				{
					'type': 'attribute',
					'key': 'style',
					'from': 'bullet',
					'to': 'number'
				}
			],
			'diff': 0
		},
		'replace multiple element attributes': {
			'calls': [
				['pushReplaceElementAttribute', 'style', 'bullet', 'number'],
				['pushReplaceElementAttribute', 'level', 1, 2]
			],
			'ops': [
				{
					'type': 'attribute',
					'key': 'style',
					'from': 'bullet',
					'to': 'number'
				},
				{
					'type': 'attribute',
					'key': 'level',
					'from': 1,
					'to': 2
				}
			],
			'diff': 0
		}
	};
	QUnit.expect( 2*ve.getObjectKeys( cases ).length );
	runBuilderTests( assert, cases );
} );

QUnit.test( 'push*Annotating', function ( assert ) {
	var cases = {
		'start annotating': {
			'calls': [
				['pushStartAnnotating', 'set', { 'type': 'textStyle/bold' }]
			],
			'ops': [
				{
					'type': 'annotate',
					'method': 'set',
					'bias': 'start',
					'annotation': { 'type': 'textStyle/bold' }
				}
			],
			'diff': 0
		},
		'stop annotating': {
			'calls': [
				['pushStopAnnotating', 'set', { 'type': 'textStyle/bold' }]
			],
			'ops': [
				{
					'type': 'annotate',
					'method': 'set',
					'bias': 'stop',
					'annotation': { 'type': 'textStyle/bold' }
				}
			],
			'diff': 0
		},
		'start multiple annotations': {
			'calls': [
				['pushStartAnnotating', 'set', { 'type': 'textStyle/bold' }],
				['pushStartAnnotating', 'set', { 'type': 'textStyle/italic' }]
			],
			'ops': [
				{
					'type': 'annotate',
					'method': 'set',
					'bias': 'start',
					'annotation': { 'type': 'textStyle/bold' }
				},
				{
					'type': 'annotate',
					'method': 'set',
					'bias': 'start',
					'annotation': { 'type': 'textStyle/italic' }
				}
			],
			'diff': 0
		},
		'stop multiple annotations': {
			'calls': [
				['pushStopAnnotating', 'set', { 'type': 'textStyle/bold' }],
				['pushStopAnnotating', 'set', { 'type': 'textStyle/italic' }]
			],
			'ops': [
				{
					'type': 'annotate',
					'method': 'set',
					'bias': 'stop',
					'annotation': { 'type': 'textStyle/bold' }
				},
				{
					'type': 'annotate',
					'method': 'set',
					'bias': 'stop',
					'annotation': { 'type': 'textStyle/italic' }
				}
			],
			'diff': 0
		}
	};
	QUnit.expect( 2*ve.getObjectKeys( cases ).length );
	runBuilderTests( assert, cases );
} );

QUnit.test( 'newFromMetadataInsertion', function ( assert ) {
	var doc = ve.dm.example.createExampleDocument( 'withMeta' ),
		listWithMetaDoc = ve.dm.example.createExampleDocument( 'listWithMeta' ),
		element = {
			'type': 'alienMeta',
			'attributes': {
				'style': 'comment',
				'text': ' inline '
			}
		},
		cases = {
			'inserting metadata element into existing element list': {
				'args': [ doc, 11, 2, [ element ] ],
				'ops': [
					{ 'type': 'retain', 'length': 11 },
					{ 'type': 'retainMetadata', 'length': 2 },
					{
						'type': 'replaceMetadata',
						'remove': [],
						'insert': [ element ]
					},
					{ 'type': 'retainMetadata', 'length': 2 },
					{ 'type': 'retain', 'length': 2 }
				]
			},
			'inserting metadata element into empty list': {
				'args': [ doc, 3, 0, [ element ] ],
				'ops': [
					{ 'type': 'retain', 'length': 3 },
					{
						'type': 'replaceMetadata',
						'remove': [],
						'insert': [ element ]
					},
					{ 'type': 'retain', 'length': 10 }
				]
			},
			'inserting trailing metadata (1)': {
				'args': [ listWithMetaDoc, 12, 0, [ element ] ],
				'ops': [
					{ 'type': 'retain', 'length': 12 },
					{
						'type': 'replaceMetadata',
						'remove': [],
						'insert': [ element ]
					},
					{ 'type': 'retainMetadata', 'length': 1 }
				]
			},
			'inserting trailing metadata (2)': {
				'args': [ listWithMetaDoc, 12, 1, [ element ] ],
				'ops': [
					{ 'type': 'retain', 'length': 12 },
					{ 'type': 'retainMetadata', 'length': 1 },
					{
						'type': 'replaceMetadata',
						'remove': [],
						'insert': [ element ]
					}
				]
			}
		};
	QUnit.expect( ve.getObjectKeys( cases ).length );
	runConstructorTests( assert, ve.dm.Transaction.newFromMetadataInsertion, cases );
} );

QUnit.test( 'newFromMetadataRemoval', function ( assert ) {
	var doc = ve.dm.example.createExampleDocument( 'withMeta' ),
		listWithMetaDoc = ve.dm.example.createExampleDocument( 'listWithMeta' ),
		allElements = ve.dm.example.withMetaMetaData[11],
		someElements = allElements.slice( 1, 3 ),
		cases = {
			'removing all metadata elements from metadata list': {
				'args': [ doc, 11, new ve.Range( 0, 4 ) ],
				'ops': [
					{ 'type': 'retain', 'length': 11 },
					{
						'type': 'replaceMetadata',
						'remove': allElements,
						'insert': []
					},
					{ 'type': 'retain', 'length': 2 }
				]
			},
			'removing some metadata elements from metadata list': {
				'args': [ doc, 11, new ve.Range( 1, 3 ) ],
				'ops': [
					{ 'type': 'retain', 'length': 11 },
					{ 'type': 'retainMetadata', 'length': 1 },
					{
						'type': 'replaceMetadata',
						'remove': someElements,
						'insert': []
					},
					{ 'type': 'retainMetadata', 'length': 1 },
					{ 'type': 'retain', 'length': 2 }
				]
			},
			'removing trailing metadata': {
				'args': [ listWithMetaDoc, 12, new ve.Range( 0, 1 ) ],
				'ops': [
					{ 'type': 'retain', 'length': 12 },
					{
						'type': 'replaceMetadata',
						'remove': [
							{
								'type': 'alienMeta',
								'attributes': {
									'domElements': $( '<meta property="thirteen" />' ).toArray()
								}
							}
						],
						'insert': []
					}
				]
			},
			'checks metadata at offset is non-empty': {
				'args': [ doc, 5, new ve.Range( 1, 3 ) ],
				'exception': Error
			},
			'checks range is valid for metadata at offset': {
				'args': [ doc, 11, new ve.Range( 1, 5 ) ],
				'exception': Error
			}
		};
	QUnit.expect( ve.getObjectKeys( cases ).length );
	runConstructorTests( assert, ve.dm.Transaction.newFromMetadataRemoval, cases );
} );

QUnit.test( 'newFromMetadataElementReplacement', function ( assert ) {
	var doc = ve.dm.example.createExampleDocument( 'withMeta' ),
		listWithMetaDoc = ve.dm.example.createExampleDocument( 'listWithMeta' ),
		newElement = {
			'type': 'alienMeta',
			'attributes': {
				'style': 'comment',
				'text': ' inline '
			}
		},
		oldElement = ve.dm.example.withMetaMetaData[11][3],
		cases = {
			'replacing metadata at end of list': {
				'args': [ doc, 11, 3, newElement ],
				'ops': [
					{ 'type': 'retain', 'length': 11 },
					{ 'type': 'retainMetadata', 'length': 3 },
					{
						'type': 'replaceMetadata',
						'remove': [ oldElement ],
						'insert': [ newElement ]
					},
					{ 'type': 'retain', 'length': 2 }
				]
			},
			'replacing trailing metadata': {
				'args': [ listWithMetaDoc, 12, 0, newElement ],
				'ops': [
					{ 'type': 'retain', 'length': 12 },
					{
						'type': 'replaceMetadata',
						'remove': [ listWithMetaDoc.metadata.getData( 12 )[0] ],
						'insert': [ newElement ]
					}
				]
			},
			'checks offset is in bounds': {
				'args': [ doc, 15, 0, newElement ],
				'exception': Error
			},
			'checks metadata index is in bounds': {
				'args': [ doc, 11, 5, newElement ],
				'exception': Error
			}
		};
	QUnit.expect( ve.getObjectKeys( cases ).length );
	runConstructorTests( assert, ve.dm.Transaction.newFromMetadataElementReplacement, cases );
} );
