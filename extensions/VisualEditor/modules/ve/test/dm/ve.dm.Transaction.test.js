/**
 * VisualEditor data model Transaction tests.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
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
		assert.deepEqual( tx.getOperations(), cases[msg].ops, msg + ': operations match' );
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
			assert.deepEqual( tx.getOperations(), cases[msg].ops, msg + ': operations match' );
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

QUnit.test( 'newFromInsertion', 13, function ( assert ) {
	var i, key,
		doc = new ve.dm.Document( ve.copyArray( ve.dm.example.data ) ),
		doc2 = new ve.dm.Document( [ { 'type': 'paragraph' }, { 'type': '/paragraph' } ] ),
		cases = {
		'paragraph before first element': {
			'args': [doc, 0, [{ 'type': 'paragraph' }, '1', { 'type': '/paragraph' }]],
			'ops': [
				{
					'type': 'replace',
					'remove': [],
					'insert': [{ 'type': 'paragraph' }, '1', { 'type': '/paragraph' }]
				},
				{ 'type': 'retain', 'length': 61 }
			]
		},
		'paragraph after last element': {
			'args': [doc, 61, [{ 'type': 'paragraph' }, '1', { 'type': '/paragraph' }]],
			'ops': [
				{ 'type': 'retain', 'length': 61 },
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
				{ 'type': 'retain', 'length': 51 }
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
				{ 'type': 'retain', 'length': 59 }
			]
		},
		'paragraph inside a list closes and reopens list': {
			'args': [doc, 13, [{ 'type': 'paragraph' }, 'F', 'O', 'O', { 'type': '/paragraph' }]],
			'ops': [
				{ 'type': 'retain', 'length': 13 },
				{
					'type': 'replace',
					'remove': [],
					'insert': [{'type': '/list' }, { 'type': 'paragraph' } , 'F', 'O', 'O', { 'type': '/paragraph' }, { 'type': 'list', 'attributes': { 'style': 'bullet' } }]
				},
				{ 'type': 'retain', 'length': 48 }
			]
		},
		'tableCell inside the document is wrapped in a table, tableSection and tableRow': {
			'args': [doc, 43, [{ 'type': 'tableCell', 'attributes': { 'style': 'data' } }, { 'type': 'paragraph' }, 'F', 'O', 'O', { 'type': '/paragraph' }, { 'type': '/tableCell' }]],
			'ops': [
				{ 'type': 'retain', 'length': 43 },
				{
					'type': 'replace',
					'remove': [],
					// FIXME tableSection should have type=body
					'insert': [{ 'type': 'table' }, { 'type': 'tableSection' }, { 'type': 'tableRow' }, { 'type': 'tableCell', 'attributes': { 'style': 'data' } }, { 'type': 'paragraph' }, 'F', 'O', 'O', { 'type': '/paragraph' }, { 'type': '/tableCell' }, { 'type': '/tableRow' }, { 'type': '/tableSection' }, { 'type': '/table' }]
				},
				{ 'type': 'retain', 'length': 18 }
			]
		},
		'tableCell inside a paragraph is wrapped in a table, tableSection and tableRow and closes and reopens the paragraph': {
			'args': [doc, 52, [{ 'type': 'tableCell', 'attributes': { 'style': 'data' } }, { 'type': 'paragraph' }, 'F', 'O', 'O', { 'type': '/paragraph' }, { 'type': '/tableCell' }]],
			'ops': [
				{ 'type': 'retain', 'length': 52 },
				{
					'type': 'replace',
					'remove': [],
					// FIXME tableSection should have type=body
					'insert': [{ 'type': '/paragraph' }, { 'type': 'table' }, { 'type': 'tableSection' }, { 'type': 'tableRow' }, { 'type': 'tableCell', 'attributes': { 'style': 'data' } }, { 'type': 'paragraph' }, 'F', 'O', 'O', { 'type': '/paragraph' }, { 'type': '/tableCell' }, { 'type': '/tableRow' }, { 'type': '/tableSection' }, { 'type': '/table' }, { 'type': 'paragraph' }]
				},
				{ 'type': 'retain', 'length': 9 }
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
				{ 'type': 'retain', 'length': 61 }
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
				{ 'type': 'retain', 'length': 45 }
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
				{ 'type': 'retain', 'length': 59 }
			]
		},
		'text inside a tableSection is wrapped in a paragraph and closes and reopens the tableSection, tableRow and table': {
			'args': [doc, 34, ['F', 'O', 'O']],
			'ops': [
				{ 'type': 'retain', 'length': 34 },
				{
					'type': 'replace',
					'remove': [],
					'insert': [{ 'type': '/tableRow' }, { 'type': '/tableSection' }, { 'type': '/table' }, { 'type': 'paragraph' }, 'F', 'O', 'O', { 'type': '/paragraph' }, { 'type': 'table' }, { 'type': 'tableSection', 'attributes': { 'style': 'body' } }, { 'type': 'tableRow' } ]
				},
				{ 'type': 'retain', 'length': 27 }
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
		}
		// TODO test cases for unclosed openings
		// TODO test cases for (currently failing) unopened closings use case
		// TODO analyze other possible cases (substrings of linmod data)
	};
	for ( key in cases ) {
		for ( i = 0; i < cases[key].ops.length; i++ ) {
			if ( cases[key].ops[i].remove ) {
				ve.dm.example.preprocessAnnotations( cases[key].ops[i].remove );
			}
			if ( cases[key].ops[i].insert ) {
				ve.dm.example.preprocessAnnotations( cases[key].ops[i].insert );
			}
		}
	}
	runConstructorTests( assert, ve.dm.Transaction.newFromInsertion, cases );
} );

QUnit.test( 'newFromRemoval', 15, function ( assert ) {
	var i, key,
		alienDoc = new ve.dm.Document( ve.copyArray( ve.dm.example.alienData ) ),
		doc = new ve.dm.Document( ve.copyArray( ve.dm.example.data ) ),
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
				{ 'type': 'retain', 'length': 58 }
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
				{ 'type': 'retain', 'length': 1 }
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
				{ 'type': 'retain', 'length': 56 }
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
						{ 'type': 'image', 'attributes': { 'html/src': 'image.png' } },
						{ 'type': '/image' },
						'i'
					],
					'insert': []
				},
				{ 'type': 'retain', 'length': 19 }
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
				{ 'type': 'retain', 'length': 56 }
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
				}
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
				{ 'type': 'retain', 'length': 22 }
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
				{ 'type': 'retain', 'length': 2 }
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
				{ 'type': 'retain', 'length': 45 }
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
				{ 'type': 'retain', 'length': 6 }
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
				}
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
				{ 'type': 'retain', 'length': 10 }
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
				{ 'type': 'retain', 'length': 2 }
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
				{ 'type': 'retain', 'length': 4 }
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
				{ 'type': 'retain', 'length': 4 }
			]
		}
	};
	for ( key in cases ) {
		for ( i = 0; i < cases[key].ops.length; i++ ) {
			if ( cases[key].ops[i].remove ) {
				ve.dm.example.preprocessAnnotations( cases[key].ops[i].remove );
			}
			if ( cases[key].ops[i].insert ) {
				ve.dm.example.preprocessAnnotations( cases[key].ops[i].insert );
			}
		}
	}
	runConstructorTests( assert, ve.dm.Transaction.newFromRemoval, cases );
} );

QUnit.test( 'newFromAttributeChange', 4, function ( assert ) {
	var doc = new ve.dm.Document( ve.copyArray( ve.dm.example.data ) ),
		cases = {
		'first element': {
			'args': [doc, 0, 'level', 2],
			'ops': [
				{
					'type': 'attribute',
					'key': 'level',
					'from': 1,
					'to': 2
				},
				{ 'type': 'retain', 'length': 61 }
			]
		},
		'middle element': {
			'args': [doc, 17, 'style', 'number'],
			'ops': [
				{ 'type': 'retain', 'length': 17 },
				{
					'type': 'attribute',
					'key': 'style',
					'from': 'bullet',
					'to': 'number'
				},
				{ 'type': 'retain', 'length': 44 }
			]
		},
		'non-element': {
			'args': [doc, 1, 'level', 2],
			'exception': Error
		},
		'closing element': {
			'args': [doc, 4, 'level', 2],
			'exception': Error
		}
	};
	runConstructorTests( assert, ve.dm.Transaction.newFromAttributeChange, cases );
} );

QUnit.test( 'newFromAnnotation', 4, function ( assert ) {
	var bold = ve.dm.example.createAnnotation( ve.dm.example.bold ),
		doc = new ve.dm.Document( ve.copyArray( ve.dm.example.data ) ),
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
				{ 'type': 'retain', 'length': 59 }
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
				{ 'type': 'retain', 'length': 57 }
			]
		},
		'over elements': {
			'args': [doc, new ve.Range( 4, 9 ), 'set', bold],
			'ops': [
				{ 'type': 'retain', 'length': 61 }
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
				{ 'type': 'retain', 'length': 50 }
			]
		}
	};
	runConstructorTests( assert, ve.dm.Transaction.newFromAnnotation, cases );
} );

QUnit.test( 'newFromContentBranchConversion', 2, function ( assert ) {
	var doc = new ve.dm.Document( ve.copyArray( ve.dm.example.data ) ),
		i, key,
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
				{ 'type': 'retain', 'length': 56 }
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
				{ 'type': 'retain', 'length': 3 }
			]
		}
	};
	for ( key in cases ) {
		for ( i = 0; i < cases[key].ops.length; i++ ) {
			if ( cases[key].ops[i].remove ) {
				ve.dm.example.preprocessAnnotations( cases[key].ops[i].remove );
			}
			if ( cases[key].ops[i].insert ) {
				ve.dm.example.preprocessAnnotations( cases[key].ops[i].insert );
			}
		}
	}
	runConstructorTests(
		assert,
		ve.dm.Transaction.newFromContentBranchConversion,
		cases
	);
} );

QUnit.test( 'newFromWrap', 8, function ( assert ) {
	var i, key,
		doc = new ve.dm.Document( ve.copyArray( ve.dm.example.data ) ),
		cases = {
		'changes a heading to a paragraph': {
			'args': [doc, new ve.Range( 1, 4 ), [ { 'type': 'heading', 'attributes': { 'level': 1 } } ], [ { 'type': 'paragraph' } ], [], []],
			'ops': [
				{ 'type': 'replace', 'remove': [ { 'type': 'heading', 'attributes': { 'level': 1 } } ], 'insert': [ { 'type': 'paragraph' } ] },
				{ 'type': 'retain', 'length': 3 },
				{ 'type': 'replace', 'remove': [ { 'type': '/heading' } ], 'insert': [ { 'type': '/paragraph' } ] },
				{ 'type': 'retain', 'length': 56 }
			]
		},
		'unwraps a list': {
			'args': [doc, new ve.Range( 13, 25 ), [ { 'type': 'list' } ], [], [ { 'type': 'listItem' } ], []],
			'ops': [
				{ 'type': 'retain', 'length': 12 },
				{ 'type': 'replace', 'remove': [ { 'type': 'list', 'attributes': { 'style': 'bullet' } } ], 'insert': [] },
				{ 'type': 'replace', 'remove': [ { 'type': 'listItem' } ], 'insert': [] },
				{ 'type': 'retain', 'length': 10 },
				{ 'type': 'replace', 'remove': [ { 'type': '/listItem' } ], 'insert': [] },
				{ 'type': 'replace', 'remove': [ { 'type': '/list' } ], 'insert': [] },
				{ 'type': 'retain', 'length': 35 }
			]
		},
		'replaces a table with a list': {
			'args': [doc, new ve.Range( 9, 33 ), [ { 'type': 'table' }, { 'type': 'tableSection' }, { 'type': 'tableRow' }, { 'type': 'tableCell' } ], [ { 'type': 'list' }, { 'type': 'listItem' } ], [], []],
			'ops': [
				{ 'type': 'retain', 'length': 5 },
				{ 'type': 'replace', 'remove': [ { 'type': 'table' }, { 'type': 'tableSection', 'attributes': { 'style': 'body' } }, { 'type': 'tableRow' }, { 'type': 'tableCell', 'attributes': { 'style': 'data' } } ], 'insert': [ { 'type': 'list' }, { 'type': 'listItem' } ] },
				{ 'type': 'retain', 'length': 24 },
				{ 'type': 'replace', 'remove': [ { 'type': '/tableCell' }, { 'type': '/tableRow' }, { 'type': '/tableSection' }, { 'type': '/table' } ], 'insert': [ { 'type': '/listItem' }, { 'type': '/list' } ] },
				{ 'type': 'retain', 'length': 24 }
			]
		},
		'wraps two adjacent paragraphs in a list': {
			'args': [doc, new ve.Range( 55, 61 ), [], [ { 'type': 'list', 'attributes': { 'style': 'number' } } ], [], [ { 'type': 'listItem' } ]],
			'ops': [
				{ 'type': 'retain', 'length': 55 },
				{ 'type': 'replace', 'remove': [], 'insert': [ { 'type': 'list', 'attributes': { 'style': 'number' } } ] },
				{ 'type': 'replace', 'remove': [], 'insert': [ { 'type': 'listItem' } ] },
				{ 'type': 'retain', 'length': 3 },
				{ 'type': 'replace', 'remove': [], 'insert': [ { 'type': '/listItem' } ] },
				{ 'type': 'replace', 'remove': [], 'insert': [ { 'type': 'listItem' } ] },
				{ 'type': 'retain', 'length': 3 },
				{ 'type': 'replace', 'remove': [], 'insert': [ { 'type': '/listItem' } ] },
				{ 'type': 'replace', 'remove': [], 'insert': [ { 'type': '/list' } ] }
			]
		},
		'wraps two adjacent paragraphs in a definitionList': {
			'args': [doc, new ve.Range( 55, 61 ), [], [ { 'type': 'definitionList' } ], [], [ { 'type': 'definitionListItem', 'attributes': { 'style': 'term' } } ]],
			'ops': [
				{ 'type': 'retain', 'length': 55 },
				{ 'type': 'replace', 'remove': [], 'insert': [ { 'type': 'definitionList' } ] },
				{ 'type': 'replace', 'remove': [], 'insert': [ { 'type': 'definitionListItem', 'attributes': { 'style': 'term' } } ] },
				{ 'type': 'retain', 'length': 3 },
				{ 'type': 'replace', 'remove': [], 'insert': [ { 'type': '/definitionListItem' } ] },
				{ 'type': 'replace', 'remove': [], 'insert': [ { 'type': 'definitionListItem', 'attributes': { 'style': 'term' } } ] },
				{ 'type': 'retain', 'length': 3 },
				{ 'type': 'replace', 'remove': [], 'insert': [ { 'type': '/definitionListItem' } ] },
				{ 'type': 'replace', 'remove': [], 'insert': [ { 'type': '/definitionList' } ] }
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
	for ( key in cases ) {
		for ( i = 0; cases[key].ops && i < cases[key].ops.length; i++ ) {
			if ( cases[key].ops[i].remove ) {
				ve.dm.example.preprocessAnnotations( cases[key].ops[i].remove );
			}
			if ( cases[key].ops[i].insert ) {
				ve.dm.example.preprocessAnnotations( cases[key].ops[i].insert );
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
	var tx, mapping, offset;
	// Populate a transaction with bogus data
	tx = new ve.dm.Transaction();
	tx.pushReplace( [], ['a','b','c'] );
	tx.pushRetain ( 5 );
	tx.pushReplace( ['d', 'e', 'f', 'g'], [] );
	tx.pushRetain( 2 );
	tx.pushStartAnnotating( 'set', { 'type': 'textStyle/bold' } );
	tx.pushRetain( 1 );
	tx.pushReplace( ['h'], ['i', 'j', 'k', 'l', 'm'] );
	tx.pushRetain( 2 );
	tx.pushReplace( [], ['n', 'o', 'p'] );

	mapping = {
		0: 3,
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
		12: 16,
		13: 16,
		14: 17,
		15: 21,
		16: 22
	};
	QUnit.expect( 17 );
	for ( offset in mapping ) {
		assert.strictEqual( tx.translateOffset( Number( offset ) ), mapping[offset] );
	}
} );

QUnit.test( 'translateOffsetReversed', function ( assert ) {
	var tx, mapping, offset;
	// Populate a transaction with bogus data
	tx = new ve.dm.Transaction();
	tx.pushReplace( [], ['a','b','c'] );
	tx.pushRetain ( 5 );
	tx.pushReplace( ['d', 'e', 'f', 'g'], [] );
	tx.pushRetain( 2 );
	tx.pushStartAnnotating( 'set', { 'type': 'textStyle/bold' } );
	tx.pushRetain( 1 );
	tx.pushReplace( ['h'], ['i', 'j', 'k', 'l', 'm'] );
	tx.pushRetain( 2 );
	tx.pushReplace( [], ['n', 'o', 'p'] );

	mapping = {
		0: 0,
		1: 0,
		2: 0,
		3: 0,
		4: 1,
		5: 2,
		6: 3,
		7: 4,
		8: 9,
		9: 10,
		10: 11,
		11: 13,
		12: 13,
		13: 13,
		14: 13,
		15: 13,
		16: 13
	};
	QUnit.expect( 17 );
	for ( offset in mapping ) {
		assert.strictEqual( tx.translateOffset( Number( offset ), true ), mapping[offset] );
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

QUnit.test( 'pushReplace', 16, function ( assert ) {
	var i, key, cases = {
		'insert': {
			'calls': [
				['pushReplace', [], [{ 'type': 'paragraph' }, 'a', 'b', 'c', { 'type': '/paragraph' }]]
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
				['pushReplace', [], [{ 'type': 'paragraph' }, 'a', 'b']],
				['pushReplace', [], ['c', { 'type': '/paragraph' }]]
			],
			'ops': [
				{
					'type': 'replace',
					'remove': [],
					'insert': [{ 'type': 'paragraph' }, 'a', 'b']
				},
				{
					'type': 'replace',
					'remove': [],
					'insert': ['c', { 'type': '/paragraph' }]
				}
			],
			'diff': 5
		},
		'insert and retain': {
			'calls': [
				['pushRetain', 1],
				['pushReplace', [], ['a', 'b', 'c']]
			],
			'ops': [
				{ 'type': 'retain', 'length': 1 },
				{ 'type': 'replace', 'remove': [], 'insert': ['a', 'b', 'c'] }
			],
			'diff': 3
		},
		'remove': {
			'calls': [
				['pushReplace', [{ 'type': 'paragraph' }, 'a', 'b', 'c', { 'type': '/paragraph' }], []]
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
				['pushReplace', [{ 'type': 'paragraph' }, 'a', 'b'], []],
				['pushReplace', ['c', { 'type': '/paragraph' }], []]
			],
			'ops': [
				{
					'type': 'replace',
					'remove': [{ 'type': 'paragraph' }, 'a', 'b'],
					'insert': []
				},
				{
					'type': 'replace',
					'remove': ['c', { 'type': '/paragraph' }],
					'insert': []
				}
			],
			'diff': -5
		},
		'remove and retain': {
			'calls': [
				['pushRetain', 1],
				['pushReplace', ['a', 'b', 'c'], []]
			],
			'ops': [
				{ 'type': 'retain', 'length': 1 },
				{ 'type': 'replace', 'remove': ['a', 'b', 'c'], 'insert': [] }
			],
			'diff': -3
		},
		'replace': {
			'calls': [
				['pushReplace', ['a', 'b', 'c'], ['d', 'e', 'f']]
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
				['pushReplace', ['a', 'b', 'c'], ['d', 'e', 'f']],
				['pushReplace', ['g', 'h', 'i'], ['j', 'k', 'l']]
			],
			'ops': [
				{
					'type': 'replace',
					'remove': ['a', 'b', 'c'],
					'insert': ['d', 'e', 'f']
				},
				{
					'type': 'replace',
					'remove': ['g', 'h', 'i'],
					'insert': ['j', 'k', 'l']
				}
			],
			'diff': 0
		}
	};
	for ( key in cases ) {
		for ( i = 0; i < cases[key].ops.length; i++ ) {
			if ( cases[key].ops[i].remove ) {
				ve.dm.example.preprocessAnnotations( cases[key].ops[i].remove );
			}
			if ( cases[key].ops[i].insert ) {
				ve.dm.example.preprocessAnnotations( cases[key].ops[i].insert );
			}
		}
		for ( i = 0; i < cases[key].calls.length; i++ ) {
			if ( cases[key].calls[i][0] === 'pushReplace' ) {
				ve.dm.example.preprocessAnnotations( cases[key].calls[i][1] );
				ve.dm.example.preprocessAnnotations( cases[key].calls[i][2] );
			}
		}
	}
	runBuilderTests( assert, cases );
} );

QUnit.test( 'pushReplaceElementAttribute', 4, function ( assert ) {
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
	runBuilderTests( assert, cases );
} );

QUnit.test( 'push*Annotating', 8, function ( assert ) {
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
	runBuilderTests( assert, cases );
} );
