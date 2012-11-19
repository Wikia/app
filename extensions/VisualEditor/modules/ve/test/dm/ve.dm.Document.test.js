/**
 * VisualEditor data model Document tests.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.dm.Document' );

/* Tests */

QUnit.test( 'constructor', 7, function ( assert ) {
	var doc = new ve.dm.Document( ve.copyArray( ve.dm.example.data ) );
	assert.equalNodeTree( doc.getDocumentNode(), ve.dm.example.tree, 'node tree matches example data' );
	assert.throws(
		function () {
			doc = new ve.dm.Document( [
				{ 'type': '/paragraph' },
				{ 'type': 'paragraph' }
			] );
		},
		Error,
		'unbalanced input causes exception'
	);

	// TODO data provider?
	doc = new ve.dm.Document( [ 'a', 'b', 'c', 'd' ] );
	assert.equalNodeTree(
		doc.getDocumentNode(),
		new ve.dm.DocumentNode( [ new ve.dm.TextNode( 4 ) ] ),
		'plain text input is handled correctly'
	);

	doc = new ve.dm.Document( [ { 'type': 'paragraph' }, { 'type': '/paragraph' } ] );
	assert.equalNodeTree(
		doc.getDocumentNode(),
		new ve.dm.DocumentNode( [ new ve.dm.ParagraphNode( [ new ve.dm.TextNode( 0 ) ] ) ] ),
		'empty paragraph gets a zero-length text node'
	);

	doc = new ve.dm.Document( ve.copyArray( ve.dm.example.withMeta ) );
	assert.deepEqual( doc.data, ve.dm.example.withMetaPlainData,
		'metadata is stripped out of the linear model'
	);
	assert.deepEqual( doc.metadata, ve.dm.example.withMetaMetaData,
		'metadata is put in the meta-linmod'
	);
	assert.equalNodeTree(
		doc.getDocumentNode(),
		new ve.dm.DocumentNode( [ new ve.dm.ParagraphNode( [ new ve.dm.TextNode( 9 ) ] ) ] ),
		'node tree does not contain metadata'
	);
} );

QUnit.test( 'getData', 1, function ( assert ) {
	var doc = new ve.dm.Document( ve.copyArray( ve.dm.example.data ) );
	assert.deepEqual( doc.getData(), ve.dm.example.data );
} );

QUnit.test( 'getFullData', 1, function ( assert ) {
	var doc = new ve.dm.Document( ve.copyArray( ve.dm.example.withMeta ) );
	assert.deepEqual( doc.getFullData(), ve.dm.example.withMeta );
} );

QUnit.test( 'spliceData', 12, function ( assert ) {
	var doc = new ve.dm.Document( ve.copyArray( ve.dm.example.withMeta ) ),
		fullData = ve.copyArray( ve.dm.example.withMeta ),
		plainData = ve.copyArray( ve.dm.example.withMetaPlainData ),
		metaData = ve.copyArray( ve.dm.example.withMetaMetaData ),
		actualResult, expectedResult;

	actualResult = doc.spliceData( 2, 0, [ 'X', 'Y' ] );
	expectedResult = plainData.splice( 2, 0, 'X', 'Y' );
	fullData.splice( 4, 0, 'X', 'Y' );
	metaData.splice( 2, 0, undefined, undefined );
	assert.deepEqual( doc.data, plainData, 'adding two elements at offset 2 (plain data)' );
	assert.deepEqual( doc.metadata, metaData, 'adding two elements at offset 2 (metadata)' );
	assert.deepEqual( doc.getFullData(), fullData, 'adding two elements at offset 2 (full data)' );

	actualResult = doc.spliceData( 10, 1 );
	expectedResult = plainData.splice( 10, 1 );
	fullData.splice( 16, 1 );
	metaData.splice( 10, 1 );
	assert.deepEqual( doc.data, plainData, 'removing one element at offset 10 (plain data)' );
	assert.deepEqual( doc.metadata, metaData, 'removing one element at offset 10 (metadata)' );
	assert.deepEqual( doc.getFullData(), fullData, 'removing one element at offset 10 (full data)' );

	actualResult = doc.spliceData( 5, 2 );
	expectedResult = plainData.splice( 5, 2 );
	fullData.splice( 7, 1 );
	fullData.splice( 9, 1 );
	metaData.splice( 5, 3, metaData[6] );
	assert.deepEqual( doc.data, plainData, 'removing two elements at offset 5 (plain data)' );
	assert.deepEqual( doc.metadata, metaData, 'removing two elements at offset 5 (metadata)' );
	assert.deepEqual( doc.getFullData(), fullData, 'removing two elements at offset 5 (full data)' );

	actualResult = doc.spliceData( 1, 8 );
	expectedResult = plainData.splice( 1, 8 );
	fullData.splice( 3, 4 );
	fullData.splice( 5, 2 );
	fullData.splice( 7, 2 );
	metaData.splice( 1, 9, metaData[5].concat( metaData[7] ) );
	assert.deepEqual( doc.data, plainData, 'blanking paragraph, removing 8 elements at offset 1 (plain data)' );
	assert.deepEqual( doc.metadata, metaData, 'blanking paragraph, removing 8 elements at offset 1 (metadata)' );
	assert.deepEqual( doc.getFullData(), fullData, 'blanking paragraph, removing 8 elements at offset 1 (full data)' );
} );

QUnit.test( 'getNodeFromOffset', function ( assert ) {
	var i, j, node,
		doc = new ve.dm.Document( ve.copyArray( ve.dm.example.data ) ),
		root = doc.getDocumentNode().getRoot(),
		expected = [
		[], // 0 - document
		[0], // 1 - heading
		[0], // 2 - heading
		[0], // 3 - heading
		[0], // 4 - heading
		[], // 5 - document
		[1], // 6 - table
		[1, 0], // 7 - tableSection
		[1, 0, 0], // 7 - tableRow
		[1, 0, 0, 0], // 8 - tableCell
		[1, 0, 0, 0, 0], // 9 - paragraph
		[1, 0, 0, 0, 0], // 10 - paragraph
		[1, 0, 0, 0], // 11 - tableCell
		[1, 0, 0, 0, 1], // 12 - list
		[1, 0, 0, 0, 1, 0], // 13 - listItem
		[1, 0, 0, 0, 1, 0, 0], // 14 - paragraph
		[1, 0, 0, 0, 1, 0, 0], // 15 - paragraph
		[1, 0, 0, 0, 1, 0], // 16 - listItem
		[1, 0, 0, 0, 1, 0, 1], // 17 - list
		[1, 0, 0, 0, 1, 0, 1, 0], // 18 - listItem
		[1, 0, 0, 0, 1, 0, 1, 0, 0], // 19 - paragraph
		[1, 0, 0, 0, 1, 0, 1, 0, 0], // 20 - paragraph
		[1, 0, 0, 0, 1, 0, 1, 0], // 21 - listItem
		[1, 0, 0, 0, 1, 0, 1], // 22 - list
		[1, 0, 0, 0, 1, 0], // 23 - listItem
		[1, 0, 0, 0, 1], // 24 - list
		[1, 0, 0, 0], // 25 - tableCell
		[1, 0, 0, 0, 2], // 26 - list
		[1, 0, 0, 0, 2, 0], // 27 - listItem
		[1, 0, 0, 0, 2, 0, 0], // 28 - paragraph
		[1, 0, 0, 0, 2, 0, 0], // 29 - paragraph
		[1, 0, 0, 0, 2, 0], // 30 - listItem
		[1, 0, 0, 0, 2], // 31 - list
		[1, 0, 0, 0], // 32 - tableCell
		[1, 0, 0], // 33 - tableRow
		[1, 0], // 33 - tableSection
		[1], // 34 - table
		[], // 35- document
		[2], // 36 - preformatted
		[2], // 37 - preformatted
		[2], // 38 - preformatted
		[2], // 39 - preformatted
		[2], // 40 - preformatted
		[], // 41 - document
		[3], // 42 - definitionList
		[3, 0], // 43 - definitionListItem
		[3, 0, 0], // 44 - paragraph
		[3, 0, 0], // 45 - paragraph
		[3, 0], // 46 - definitionListItem
		[3], // 47 - definitionList
		[3, 1], // 48 - definitionListItem
		[3, 1, 0], // 49 - paragraph
		[3, 1, 0], // 50 - paragraph
		[3, 1], // 51 - definitionListItem
		[3], // 52 - definitionList
		[], // 53 - document
		[4], // 54 - paragraph
		[4], // 55 - paragraph
		[], // 56 - document
		[5], // 57 - paragraph
		[5], // 58 - paragraph
		[] // 59 - document
	];
	QUnit.expect( expected.length );
	for ( i = 0; i < expected.length; i++ ) {
		node = root;
		for ( j = 0; j < expected[i].length; j++ ) {
			node = node.children[expected[i][j]];
		}
		assert.ok( node === doc.getNodeFromOffset( i ), 'reference at offset ' + i );
	}
} );

QUnit.test( 'getDataFromNode', 3, function ( assert ) {
	var doc = new ve.dm.Document( ve.copyArray( ve.dm.example.data ) );
	assert.deepEqual(
		doc.getDataFromNode( doc.getDocumentNode().getChildren()[0] ),
		ve.dm.example.data.slice( 1, 4 ),
		'branch with leaf children'
	);
	assert.deepEqual(
		doc.getDataFromNode( doc.getDocumentNode().getChildren()[1] ),
		ve.dm.example.data.slice( 6, 36 ),
		'branch with branch children'
	);
	assert.deepEqual(
		doc.getDataFromNode( doc.getDocumentNode().getChildren()[2].getChildren()[1] ),
		[],
		'leaf without children'
	);
} );

QUnit.test( 'getAnnotationsFromOffset', 1, function ( assert ) {
	var c, i, j,
		doc,
		annotations,
		expectCount = 0,
		cases = [
		{
			'msg': ['bold #1', 'bold #2'],
			'data': [
				['a', [ { 'type': 'textStyle/bold' } ]],
				['b', [ { 'type': 'textStyle/bold' } ]]
			],
			'expected': [
				[ { 'type': 'textStyle/bold' } ],
				[ { 'type': 'textStyle/bold' } ]
			]
		},
		{
			'msg': ['bold #3', 'italic #1'],
			'data': [
				['a', [ { 'type': 'textStyle/bold' } ]],
				['b', [ { 'type': 'textStyle/italic' } ]]
			],
			'expected': [
				[ { 'type': 'textStyle/bold' } ],
				[ { 'type': 'textStyle/italic' } ]
			]
		},
		{
			'msg': ['bold, italic & underline'],
			'data': [
				[
					'a',
					[
						{ 'type': 'textStyle/bold' },
						{ 'type': 'textStyle/italic'},
						{ 'type': 'textStyle/underline'}
					]
				]
			],
			'expected':
				[
					[
						{ 'type': 'textStyle/bold' },
						{ 'type': 'textStyle/italic'},
						{ 'type': 'textStyle/underline'}
					]
				]
		}

	];

	// Calculate expected assertion count
	for ( c = 0; c < cases.length; c++ ) {
		expectCount += cases[c].data.length;
	}
	QUnit.expect( expectCount );

	// Run tests
	for ( i = 0; i < cases.length; i++ ) {
		ve.dm.example.preprocessAnnotations( cases[i].data );
		doc = new ve.dm.Document( cases[i].data );
		for ( j = 0; j < doc.getData().length; j++ ) {
			annotations = doc.getAnnotationsFromOffset( j );
			assert.deepEqual( annotations,
				ve.dm.example.createAnnotationSet( cases[i].expected[j] ),
				cases[i].msg[j]
			);
		}
	}
} );

QUnit.test( 'getAnnotationsFromRange', 1, function ( assert ) {
	var i, doc,
		cases = [
		{
			'msg': 'single annotations',
			'data': [
				['a', [ { 'type': 'textStyle/bold' } ] ],
				['b', [ { 'type': 'textStyle/bold' } ] ]
			],
			'expected': [ { 'type': 'textStyle/bold' } ]
		},
		{
			'msg': 'multiple annotations',
			'data': [
				[
					'a',
					[
						{ 'type': 'textStyle/bold' },
						{ 'type': 'textStyle/italic'}
					]
				],
				[
					'b',
					[
						{ 'type': 'textStyle/bold' },
						{ 'type': 'textStyle/italic' }
					]
				]
			],
			'expected': [
				{ 'type': 'textStyle/bold' },
				{ 'type': 'textStyle/italic' }
			]
		},
		{
			'msg': 'lowest common coverage',
			'data': [
				[
					'a',
					[
						{ 'type': 'textStyle/bold' },
						{ 'type': 'textStyle/italic' }
					]
				],
				[
					'b',
					[
						{ 'type': 'textStyle/bold' },
						{ 'type': 'textStyle/italic' },
						{ 'type': 'textStyle/underline' }
					]
				]
			],
			'expected': [
				{ 'type': 'textStyle/bold' },
				{ 'type': 'textStyle/italic' }
			]
		},
		{
			'msg': 'no common coverage due to plain character at the start',
			'data': [
				['a'],
				[
					'b',
					[
						{ 'type': 'textStyle/bold' },
						{ 'type': 'textStyle/italic' },
						{ 'type': 'textStyle/underline' }
					]
				],
				[
					'c',
					[
						{ 'type': 'textStyle/bold' },
						{ 'type': 'textStyle/italic' }
					]
			]
			],
			'expected': []
		},
		{
			'msg': 'no common coverage due to plain character in the middle',
			'data': [
				[
					'a',
					[
						{ 'type': 'textStyle/bold' },
						{ 'type': 'textStyle/italic' },
						{ 'type': 'textStyle/underline' }
					]
				],
				['b'],
				[
					'c',
					[
						{ 'type': 'textStyle/bold' },
						{ 'type': 'textStyle/italic' }
					]
				]
			],
			'expected': []
		},
		{
			'msg': 'no common coverage due to plain character at the end',
			'data': [
				[
					'a',
					[
						{ 'type': 'textStyle/bold' },
						{ 'type': 'textStyle/italic' }
					]
				],
				[
					'b',
					[
						{ 'type': 'textStyle/bold' },
						{ 'type': 'textStyle/italic' },
						{ 'type': 'textStyle/underline' }
					]
				],
				['c']
			],
			'expected': []
		},
		{
			'msg': 'no common coverage due to mismatched annotations',
			'data': [
				['a', [ { 'type': 'textStyle/bold' } ] ],
				['b', [ { 'type': 'textStyle/italic' } ] ]
			],
			'expected': []
		},
		{
			'msg': 'annotations are collected using all with mismatched annotations',
			'data': [
				['a', [ { 'type': 'textStyle/bold' } ] ],
				['b', [ { 'type': 'textStyle/italic' } ] ]
			],
			'all': true,
			'expected': [
				{ 'type': 'textStyle/bold' },
				{ 'type': 'textStyle/italic' }
			]
		},
		{
			'msg': 'annotations are collected using all, even with a plain character at the start',
			'data': [
				['a', [ { 'type': 'textStyle/bold' } ] ],
				['b', [ { 'type': 'textStyle/italic' } ] ],
				['c']
			],
			'all': true,
			'expected': [
				{ 'type': 'textStyle/bold' },
				{ 'type': 'textStyle/italic' }
			]
		},
		{
			'msg': 'annotations are collected using all, even with a plain character at the middle',
			'data': [
				['a', [ { 'type': 'textStyle/bold' } ] ],
				['b', [ { 'type': 'textStyle/italic' } ] ],
				['c']
			],
			'all': true,
			'expected': [
				{ 'type': 'textStyle/bold' },
				{ 'type': 'textStyle/italic' }
			]
		},
		{
			'msg': 'annotations are collected using all, even with a plain character at the end',
			'data': [
				['a', [ { 'type': 'textStyle/bold' } ] ],
				['b', [ { 'type': 'textStyle/italic' } ] ],
				['c']
			],
			'all': true,
			'expected': [
				{ 'type': 'textStyle/bold' },
				{ 'type': 'textStyle/italic' }
			]
		},
		{
			'msg': 'no common coverage from all plain characters',
			'data': ['a', 'b'],
			'expected': {}
		},
		{
			'msg': 'no common coverage using all from all plain characters',
			'data': ['a', 'b'],
			'all': true,
			'expected': {}
		}
	];

	QUnit.expect( cases.length );

	for ( i = 0; i < cases.length; i++ ) {
		ve.dm.example.preprocessAnnotations( cases[i].data );
		doc = new ve.dm.Document( cases[i].data );
		assert.deepEqual(
			doc.getAnnotationsFromRange( new ve.Range( 0, cases[i].data.length ), cases[i].all ),
			ve.dm.example.createAnnotationSet( cases[i].expected ),
			cases[i].msg
		);
	}
} );

QUnit.test( 'offsetContainsAnnotation', 1, function ( assert ) {
	var i, doc,
		cases = [
		{
			msg: 'contains no annotations',
			data: [
				'a'
			],
			lookFor: {'type': 'textStyle/bold'},
			expected: false
		},
		{
			msg: 'contains bold',
			data: [
				['a', [ { 'type': 'textStyle/bold' } ] ]
			],
			lookFor: {'type': 'textStyle/bold'},
			expected: true
		},
		{
			msg: 'contains bold',
			data: [
				['a', [
					{ 'type': 'textStyle/bold' },
					{ 'type': 'textStyle/italic'}
					]
				]
			],
			lookFor: {'type': 'textStyle/bold'},
			expected: true
		}
	];

	QUnit.expect( cases.length );

	for ( i = 0;i < cases.length; i++ ) {
		ve.dm.example.preprocessAnnotations( cases[i].data );
		doc = new ve.dm.Document( cases[i].data );
		assert.deepEqual(
			doc.offsetContainsAnnotation( 0,
				ve.dm.example.createAnnotation( cases[i].lookFor ) ),
			cases[i].expected,
			cases[i].msg
		);
	}
});

QUnit.test( 'getAnnotatedRangeFromOffset', 1, function ( assert ) {
	var i, doc,
		cases = [
		{
			'msg': 'a bold word',
			'data': [
				// 0
				'a',
				// 1
				['b', [ { 'type': 'textStyle/bold' } ]],
				// 2
				['o', [ { 'type': 'textStyle/bold' } ]],
				// 3
				['l', [ { 'type': 'textStyle/bold' } ]],
				// 4
				['d', [ { 'type': 'textStyle/bold' } ]],
				// 5
				'w',
				// 6
				'o',
				// 7
				'r',
				// 8
				'd'
			],
			'annotation': { 'type': 'textStyle/bold' },
			'offset': 3,
			'expected': new ve.Range( 1, 5 )
		},
		{
			'msg': 'a linked',
			'data': [
				// 0
				'x',
				// 1
				'x',
				// 2
				'x',
				// 3
				['l', [ { 'type': 'link' } ]],
				// 4
				['i', [ { 'type': 'link' } ]],
				// 5
				['n', [ { 'type': 'link' } ]],
				// 6
				['k', [ { 'type': 'link' } ]],
				// 7
				'x',
				// 8
				'x',
				// 9
				'x'
			],
			'annotation': { 'type': 'link' },
			'offset': 3,
			'expected': new ve.Range( 3, 7 )
		},
		{
			'msg': 'bold over an annotated leaf node',
			'data': [
				// 0
				'h',
				// 1
				['b', [ { 'type': 'textStyle/bold' } ]],
				// 2
				['o', [ { 'type': 'textStyle/bold' } ]],
				// 3
				{
					'type': 'image',
					'attributes': { 'html/src': 'image.png' },
					'annotations': [ { 'type': 'textStyle/bold' }]
				},
				// 4
				{ 'type': '/image' },
				// 5
				['l', [ { 'type': 'textStyle/bold' } ]],
				// 6
				['d', [ { 'type': 'textStyle/bold' } ]],
				// 7
				'i'
			],
			'annotation': { 'type': 'textStyle/bold' },
			'offset': 3,
			'expected': new ve.Range ( 1, 7 )
		}
	];

	QUnit.expect( cases.length );

	for ( i = 0; i < cases.length; i++ ) {
		ve.dm.example.preprocessAnnotations( cases[i].data );
		doc = new ve.dm.Document( cases[i].data );
		assert.deepEqual(
			doc.getAnnotatedRangeFromOffset( cases[i].offset,
				ve.dm.example.createAnnotation( cases[i].annotation ) ),
			cases[i].expected,
			cases[i].msg
		);
	}
} );

QUnit.test( 'getOuterLength', 1, function ( assert ) {
	var doc = new ve.dm.Document( ve.copyArray( ve.dm.example.data ) );
	assert.strictEqual(
		doc.getDocumentNode().getOuterLength(),
		ve.dm.example.data.length,
		'document does not have elements around it'
	);
} );

QUnit.test( 'isContentOffset', function ( assert ) {
	var i, left, right,
		data = [
		{ 'type': 'heading' },
		'a',
		{ 'type': 'image' },
		{ 'type': '/image' },
		'b',
		'c',
		{ 'type': '/heading' },
		{ 'type': 'paragraph' },
		{ 'type': '/paragraph' },
		{ 'type': 'preformatted' },
		{ 'type': 'image' },
		{ 'type': '/image' },
		{ 'type': '/preformatted' },
		{ 'type': 'list' },
		{ 'type': 'listItem' },
		{ 'type': '/listItem' },
		{ 'type': '/list' },
		{ 'type': 'alienBlock' },
		{ 'type': '/alienBlock' },
		{ 'type': 'table' },
		{ 'type': 'tableRow' },
		{ 'type': 'tableCell' },
		{ 'type': 'alienBlock' },
		{ 'type': '/alienBlock' },
		{ 'type': '/tableCell' },
		{ 'type': '/tableRow' },
		{ 'type': '/table' }
	],
	cases = [
		{ 'msg': 'left of document', 'expected': false },
		{ 'msg': 'begining of content branch', 'expected': true },
		{ 'msg': 'left of non-text inline leaf', 'expected': true },
		{ 'msg': 'inside non-text inline leaf', 'expected': false },
		{ 'msg': 'right of non-text inline leaf', 'expected': true },
		{ 'msg': 'between characters', 'expected': true },
		{ 'msg': 'end of content branch', 'expected': true },
		{ 'msg': 'between content branches', 'expected': false },
		{ 'msg': 'inside emtpy content branch', 'expected': true },
		{ 'msg': 'between content branches', 'expected': false },
		{ 'msg': 'begining of content branch, left of inline leaf', 'expected': true },
		{ 'msg': 'inside content branch with non-text inline leaf', 'expected': false },
		{ 'msg': 'end of content branch, right of non-content leaf', 'expected': true },
		{ 'msg': 'between content, non-content branches', 'expected': false },
		{ 'msg': 'between parent, child branches, descending', 'expected': false },
		{ 'msg': 'inside empty non-content branch', 'expected': false },
		{ 'msg': 'between parent, child branches, ascending', 'expected': false },
		{ 'msg': 'between non-content branch, non-content leaf', 'expected': false },
		{ 'msg': 'inside non-content leaf', 'expected': false },
		{ 'msg': 'between non-content branches', 'expected': false },
		{ 'msg': 'between non-content branches', 'expected': false },
		{ 'msg': 'between non-content branches', 'expected': false },
		{ 'msg': 'inside non-content branch before non-content leaf', 'expected': false },
		{ 'msg': 'inside non-content leaf', 'expected': false },
		{ 'msg': 'inside non-content branch after non-content leaf', 'expected': false },
		{ 'msg': 'between non-content branches', 'expected': false },
		{ 'msg': 'between non-content branches', 'expected': false },
		{ 'msg': 'right of document', 'expected': false }
	];
	QUnit.expect( data.length + 1 );
	for ( i = 0; i < cases.length; i++ ) {
		left = data[i - 1] ? ( data[i - 1].type || data[i - 1][0] ) : '[start]';
		right = data[i] ? ( data[i].type || data[i][0] ) : '[end]';
		assert.strictEqual(
			ve.dm.Document.isContentOffset( data, i ),
			cases[i].expected,
			cases[i].msg + ' (' + left + '|' + right + ' @ ' + i + ')'
		);
	}
} );

QUnit.test( 'isStructuralOffset', function ( assert ) {
	var i, left, right,
		data = [
		{ 'type': 'heading' },
		'a',
		{ 'type': 'image' },
		{ 'type': '/image' },
		'b',
		'c',
		{ 'type': '/heading' },
		{ 'type': 'paragraph' },
		{ 'type': '/paragraph' },
		{ 'type': 'preformatted' },
		{ 'type': 'image' },
		{ 'type': '/image' },
		{ 'type': '/preformatted' },
		{ 'type': 'list' },
		{ 'type': 'listItem' },
		{ 'type': '/listItem' },
		{ 'type': '/list' },
		{ 'type': 'alienBlock' },
		{ 'type': '/alienBlock' },
		{ 'type': 'table' },
		{ 'type': 'tableRow' },
		{ 'type': 'tableCell' },
		{ 'type': 'alienBlock' },
		{ 'type': '/alienBlock' },
		{ 'type': '/tableCell' },
		{ 'type': '/tableRow' },
		{ 'type': '/table' }
	],
	cases = [
		{ 'msg': 'left of document', 'expected': [true, true] },
		{ 'msg': 'begining of content branch', 'expected': [false, false] },
		{ 'msg': 'left of non-text inline leaf', 'expected': [false, false] },
		{ 'msg': 'inside non-text inline leaf', 'expected': [false, false] },
		{ 'msg': 'right of non-text inline leaf', 'expected': [false, false] },
		{ 'msg': 'between characters', 'expected': [false, false] },
		{ 'msg': 'end of content branch', 'expected': [false, false] },
		{ 'msg': 'between content branches', 'expected': [true, true] },
		{ 'msg': 'inside emtpy content branch', 'expected': [false, false] },
		{ 'msg': 'between content branches', 'expected': [true, true] },
		{ 'msg': 'begining of content branch, left of inline leaf', 'expected': [false, false] },
		{ 'msg': 'inside content branch with non-text inline leaf', 'expected': [false, false] },
		{ 'msg': 'end of content branch, right of inline leaf', 'expected': [false, false] },
		{ 'msg': 'between content, non-content branches', 'expected': [true, true] },
		{ 'msg': 'between parent, child branches, descending', 'expected': [true, false] },
		{ 'msg': 'inside empty non-content branch', 'expected': [true, true] },
		{ 'msg': 'between parent, child branches, ascending', 'expected': [true, false] },
		{ 'msg': 'between non-content branch, non-content leaf', 'expected': [true, true] },
		{ 'msg': 'inside non-content leaf', 'expected': [false, false] },
		{ 'msg': 'between non-content branches', 'expected': [true, true] },
		{ 'msg': 'between non-content branches', 'expected': [true, false] },
		{ 'msg': 'between non-content branches', 'expected': [true, false] },
		{ 'msg': 'inside non-content branch before non-content leaf', 'expected': [true, true] },
		{ 'msg': 'inside non-content leaf', 'expected': [false, false] },
		{ 'msg': 'inside non-content branch after non-content leaf', 'expected': [true, true] },
		{ 'msg': 'between non-content branches', 'expected': [true, false] },
		{ 'msg': 'between non-content branches', 'expected': [true, false] },
		{ 'msg': 'right of document', 'expected': [true, true] }
	];
	QUnit.expect( ( data.length + 1 ) * 2 );
	for ( i = 0; i < cases.length; i++ ) {
		left = data[i - 1] ? ( data[i - 1].type || data[i - 1][0] ) : '[start]';
		right = data[i] ? ( data[i].type || data[i][0] ) : '[end]';
		assert.strictEqual(
			ve.dm.Document.isStructuralOffset( data, i ),
			cases[i].expected[0],
			cases[i].msg + ' (' + left + '|' + right + ' @ ' + i + ')'
		);
		assert.strictEqual(
			ve.dm.Document.isStructuralOffset( data, i, true ),
			cases[i].expected[1],
			cases[i].msg + ', unrestricted (' + left + '|' + right + ' @ ' + i + ')'
		);
	}
} );

QUnit.test( 'isElementData', 1, function ( assert ) {
	var i,
		data = [
		{ 'type': 'heading' },
		'a',
		{ 'type': 'image' },
		{ 'type': '/image' },
		'b',
		'c',
		{ 'type': '/heading' },
		{ 'type': 'paragraph' },
		{ 'type': '/paragraph' },
		{ 'type': 'preformatted' },
		{ 'type': 'image' },
		{ 'type': '/image' },
		{ 'type': '/preformatted' },
		{ 'type': 'list' },
		{ 'type': 'listItem' },
		{ 'type': '/listItem' },
		{ 'type': '/list' },
		{ 'type': 'alienBlock' },
		{ 'type': '/alienBlock' }
	],
	cases = [
		{ 'msg': 'left of document', 'expected': true },
		{ 'msg': 'begining of content branch', 'expected': false },
		{ 'msg': 'left of non-text inline leaf', 'expected': true },
		{ 'msg': 'inside non-text inline leaf', 'expected': true },
		{ 'msg': 'right of non-text inline leaf', 'expected': false },
		{ 'msg': 'between characters', 'expected': false },
		{ 'msg': 'end of content branch', 'expected': true },
		{ 'msg': 'between content branches', 'expected': true },
		{ 'msg': 'inside emtpy content branch', 'expected': true },
		{ 'msg': 'between content branches', 'expected': true },
		{ 'msg': 'begining of content branch, left of inline leaf', 'expected': true },
		{ 'msg': 'inside content branch with non-text leaf', 'expected': true },
		{ 'msg': 'end of content branch, right of inline leaf', 'expected': true },
		{ 'msg': 'between content, non-content branches', 'expected': true },
		{ 'msg': 'between parent, child branches, descending', 'expected': true },
		{ 'msg': 'inside empty non-content branch', 'expected': true },
		{ 'msg': 'between parent, child branches, ascending', 'expected': true },
		{ 'msg': 'between non-content branch, non-content leaf', 'expected': true },
		{ 'msg': 'inside non-content leaf', 'expected': true },
		{ 'msg': 'right of document', 'expected': false }
	];
	QUnit.expect( data.length + 1 );
	for ( i = 0; i < cases.length; i++ ) {
		assert.strictEqual( ve.dm.Document.isElementData( data, i ), cases[i].expected, cases[i].msg );
	}
} );

QUnit.test( 'containsElementData', 1, function ( assert ) {
	var i,
		cases = [
		{
			'msg': 'simple paragraph',
			'data': [{ 'type': 'paragraph' }, 'a', { 'type': '/paragraph' }],
			'expected': true
		},
		{
			'msg': 'plain text',
			'data': ['a', 'b', 'c'],
			'expected': false
		},
		{
			'msg': 'annotated text',
			'data': [['a', { '{"type:"bold"}': { 'type': 'bold' } } ]],
			'expected': false
		},
		{
			'msg': 'non-text leaf',
			'data': ['a', { 'type': 'image' }, { 'type': '/image' }, 'c'],
			'expected': true
		}
	];
	QUnit.expect( cases.length );
	for ( i = 0; i < cases.length; i++ ) {
		assert.strictEqual(
			ve.dm.Document.containsElementData( cases[i].data ), cases[i].expected, cases[i].msg
		);
	}
} );

QUnit.test( 'isContentData', 1, function ( assert ) {
	var i,
		cases = [
		{
			'msg': 'simple paragraph',
			'data': [{ 'type': 'paragraph' }, 'a', { 'type': '/paragraph' }],
			'expected': false
		},
		{
			'msg': 'plain text',
			'data': ['a', 'b', 'c'],
			'expected': true
		},
		{
			'msg': 'annotated text',
			'data': [['a', { '{"type:"bold"}': { 'type': 'bold' } } ]],
			'expected': true
		},
		{
			'msg': 'non-text leaf',
			'data': ['a', { 'type': 'image' }, { 'type': '/image' }, 'c'],
			'expected': true
		}
	];
	QUnit.expect( cases.length );
	for ( i = 0; i < cases.length; i++ ) {
		assert.strictEqual(
			ve.dm.Document.isContentData( cases[i].data ), cases[i].expected, cases[i].msg
		);
	}
} );

QUnit.test( 'rebuildNodes', 2, function ( assert ) {
	var tree,
		doc = new ve.dm.Document( ve.copyArray( ve.dm.example.data ) ),
		documentNode = doc.getDocumentNode();
	// Rebuild table without changes
	doc.rebuildNodes( documentNode, 1, 1, 5, 32 );
	assert.equalNodeTree(
		documentNode,
		ve.dm.example.tree,
		'rebuild without changes'
	);

	// XXX: Create a new document node tree from the old one
	tree = new ve.dm.DocumentNode( ve.dm.example.tree.getChildren() );
	// Replace table with paragraph
	doc.spliceData( 5, 32, [ { 'type': 'paragraph' }, 'a', 'b', 'c', { 'type': '/paragraph' } ] );
	tree.splice( 1, 1, new ve.dm.ParagraphNode( [new ve.dm.TextNode( 3 )] ) );
	// Rebuild with changes
	doc.rebuildNodes( documentNode, 1, 1, 5, 5 );
	assert.equalNodeTree(
		documentNode,
		tree,
		'replace table with paragraph'
	);
} );

QUnit.test( 'getRelativeOffset', function ( assert ) {
	var i, doc, cases = [
		{
			'msg': 'document without any valid offsets returns -1',
			'offset': 0,
			'distance': 1,
			'data': [],
			'callback': function () {
				return false;
			},
			'expected': -1
		},
		{
			'msg': 'document with all valid offsets returns offset + distance',
			'offset': 0,
			'distance': 2,
			'data': ['a', 'b'],
			'callback': function () {
				return true;
			},
			'expected': 2
		}
	];
	QUnit.expect( cases.length );
	for ( i = 0; i < cases.length; i++ ) {
		doc = new ve.dm.Document( cases[i].data );
		assert.strictEqual(
			doc.getRelativeOffset.apply(
				doc,
				[
					cases[i].offset,
					cases[i].distance,
					cases[i].callback
				].concat( cases[i].args || [] )
			),
			cases[i].expected,
			cases[i].msg
		);
	}
} );

QUnit.test( 'getRelativeContentOffset', function ( assert ) {
	var i,
		doc = new ve.dm.Document( ve.copyArray( ve.dm.example.data ) ),
		cases = [
		{
			'msg': 'invalid starting offset with zero distance gets corrected',
			'offset': 0,
			'distance': 0,
			'expected': 1
		},
		{
			'msg': 'invalid starting offset with zero distance gets corrected',
			'offset': 61,
			'distance': 0,
			'expected': 60
		},
		{
			'msg': 'valid offset with zero distance returns same offset',
			'offset': 2,
			'distance': 0,
			'expected': 2
		},
		{
			'msg': 'invalid starting offset gets corrected',
			'offset': 0,
			'distance': -1,
			'expected': 1
		},
		{
			'msg': 'invalid starting offset gets corrected',
			'offset': 61,
			'distance': 1,
			'expected': 60
		},
		{
			'msg': 'first content offset is farthest left',
			'offset': 2,
			'distance': -2,
			'expected': 1
		},
		{
			'msg': 'last content offset is farthest right',
			'offset': 59,
			'distance': 2,
			'expected': 60
		},
		{
			'msg': '1 right within text',
			'offset': 1,
			'distance': 1,
			'expected': 2
		},
		{
			'msg': '2 right within text',
			'offset': 1,
			'distance': 2,
			'expected': 3
		},
		{
			'msg': '1 left within text',
			'offset': 2,
			'distance': -1,
			'expected': 1
		},
		{
			'msg': '2 left within text',
			'offset': 3,
			'distance': -2,
			'expected': 1
		},
		{
			'msg': '1 right over elements',
			'offset': 4,
			'distance': 1,
			'expected': 10
		},
		{
			'msg': '2 right over elements',
			'offset': 4,
			'distance': 2,
			'expected': 11
		},
		{
			'msg': '1 left over elements',
			'offset': 10,
			'distance': -1,
			'expected': 4
		},
		{
			'msg': '2 left over elements',
			'offset': 10,
			'distance': -2,
			'expected': 3
		}
	];
	QUnit.expect( cases.length );
	for ( i = 0; i < cases.length; i++ ) {
		assert.strictEqual(
			doc.getRelativeContentOffset( cases[i].offset, cases[i].distance ),
			cases[i].expected,
			cases[i].msg
		);
	}
} );

QUnit.test( 'getNearestContentOffset', function ( assert ) {
	var i,
		doc = new ve.dm.Document( ve.copyArray( ve.dm.example.data ) ),
		cases = [
		{
			'msg': 'unspecified direction results in shortest distance',
			'offset': 0,
			'direction': 0,
			'expected': 1
		},
		{
			'msg': 'unspecified direction results in shortest distance',
			'offset': 5,
			'direction': 0,
			'expected': 4
		},
		{
			'msg': 'positive direction results in next valid offset to the right',
			'offset': 5,
			'direction': 1,
			'expected': 10
		},
		{
			'msg': 'negative direction results in next valid offset to the left',
			'offset': 5,
			'direction': -1,
			'expected': 4
		},
		{
			'msg': 'valid offset without direction returns same offset',
			'offset': 1,
			'expected': 1
		},
		{
			'msg': 'valid offset with positive direction returns same offset',
			'offset': 1,
			'direction': 1,
			'expected': 1
		},
		{
			'msg': 'valid offset with negative direction returns same offset',
			'offset': 1,
			'direction': -1,
			'expected': 1
		}
	];
	QUnit.expect( cases.length );
	for ( i = 0; i < cases.length; i++ ) {
		assert.strictEqual(
			doc.getNearestContentOffset( cases[i].offset, cases[i].direction ),
			cases[i].expected,
			cases[i].msg
		);
	}
} );

QUnit.test( 'getRelativeStructuralOffset', function ( assert ) {
	var i,
		doc = new ve.dm.Document( ve.copyArray( ve.dm.example.data ) ),
		cases = [
		{
			'msg': 'invalid starting offset with zero distance gets corrected',
			'offset': 1,
			'distance': 0,
			'expected': 5
		},
		{
			'msg': 'invalid starting offset with zero distance gets corrected',
			'offset': 60,
			'distance': 0,
			'expected': 61
		},
		{
			'msg': 'valid offset with zero distance returns same offset',
			'offset': 0,
			'distance': 0,
			'expected': 0
		},
		{
			'msg': 'invalid starting offset gets corrected',
			'offset': 2,
			'distance': -1,
			'expected': 0
		},
		{
			'msg': 'invalid starting offset gets corrected',
			'offset': 59,
			'distance': 1,
			'expected': 61
		},
		{
			'msg': 'first structural offset is farthest left',
			'offset': 5,
			'distance': -2,
			'expected': 0
		},
		{
			'msg': 'last structural offset is farthest right',
			'offset': 58,
			'distance': 2,
			'expected': 61
		},
		{
			'msg': '1 right',
			'offset': 0,
			'distance': 1,
			'expected': 5
		},
		{
			'msg': '1 right, unrestricted',
			'offset': 5,
			'distance': 1,
			'unrestricted': true,
			'expected': 9
		},
		{
			'msg': '2 right',
			'offset': 0,
			'distance': 2,
			'expected': 6
		},
		{
			'msg': '2 right, unrestricted',
			'offset': 0,
			'distance': 2,
			'unrestricted': true,
			'expected': 9
		},
		{
			'msg': '1 left',
			'offset': 61,
			'distance': -1,
			'expected': 58
		},
		{
			'msg': '1 left, unrestricted',
			'offset': 9,
			'distance': -1,
			'unrestricted': true,
			'expected': 5
		},
		{
			'msg': '2 left',
			'offset': 61,
			'distance': -2,
			'expected': 55
		},
		{
			'msg': '2 left, unrestricted',
			'offset': 9,
			'distance': -2,
			'unrestricted': true,
			'expected': 0
		}
	];
	QUnit.expect( cases.length );
	for ( i = 0; i < cases.length; i++ ) {
		assert.strictEqual(
			doc.getRelativeStructuralOffset(
				cases[i].offset, cases[i].distance, cases[i].unrestricted
			),
			cases[i].expected,
			cases[i].msg
		);
	}
} );

QUnit.test( 'getNearestStructuralOffset', function ( assert ) {
	var i,
		doc = new ve.dm.Document( ve.copyArray( ve.dm.example.data ) ),
		cases = [
		{
			'msg': 'unspecified direction results in shortest distance',
			'offset': 1,
			'direction': 0,
			'expected': 0
		},
		{
			'msg': 'unspecified direction results in shortest distance',
			'offset': 4,
			'direction': 0,
			'expected': 5
		},
		{
			'msg': 'unspecified direction results in shortest distance, unrestricted',
			'offset': 8,
			'direction': 0,
			'unrestricted': true,
			'expected': 9
		},
		{
			'msg': 'unspecified direction results in shortest distance, unrestricted',
			'offset': 6,
			'direction': 0,
			'unrestricted': true,
			'expected': 5
		},
		{
			'msg': 'positive direction results in next valid offset to the right',
			'offset': 1,
			'direction': 1,
			'expected': 5
		},
		{
			'msg': 'positive direction results in next valid offset to the right',
			'offset': 4,
			'direction': 1,
			'expected': 5
		},
		{
			'msg': 'positive direction results in next valid offset to the right, unrestricted',
			'offset': 7,
			'direction': 1,
			'unrestricted': true,
			'expected': 9
		},
		{
			'msg': 'negative direction results in next valid offset to the left',
			'offset': 1,
			'direction': -1,
			'expected': 0
		},
		{
			'msg': 'negative direction results in next valid offset to the left',
			'offset': 4,
			'direction': -1,
			'expected': 0
		},
		{
			'msg': 'negative direction results in next valid offset to the left, unrestricted',
			'offset': 6,
			'direction': -1,
			'unrestricted': true,
			'expected': 5
		},
		{
			'msg': 'valid offset without direction returns same offset',
			'offset': 0,
			'expected': 0
		},
		{
			'msg': 'valid offset with positive direction returns same offset',
			'offset': 0,
			'direction': 1,
			'expected': 0
		},
		{
			'msg': 'valid offset with negative direction returns same offset',
			'offset': 0,
			'direction': -1,
			'expected': 0
		},
		{
			'msg': 'valid offset without direction returns same offset, unrestricted',
			'offset': 0,
			'unrestricted': true,
			'expected': 0
		},
		{
			'msg': 'valid offset with positive direction returns same offset, unrestricted',
			'offset': 0,
			'direction': 1,
			'unrestricted': true,
			'expected': 0
		},
		{
			'msg': 'valid offset with negative direction returns same offset, unrestricted',
			'offset': 0,
			'direction': -1,
			'unrestricted': true,
			'expected': 0
		}
	];
	QUnit.expect( cases.length );
	for ( i = 0; i < cases.length; i++ ) {
		assert.strictEqual(
			doc.getNearestStructuralOffset(
				cases[i].offset, cases[i].direction, cases[i].unrestricted
			),
			cases[i].expected,
			cases[i].msg
		);
	}
} );

QUnit.test( 'selectNodes', 21, function ( assert ) {
	var i,
		doc = new ve.dm.Document( ve.copyArray( ve.dm.example.data ) ),
		cases = ve.example.getSelectNodesCases( doc );

	for ( i = 0; i < cases.length; i++ ) {
		assert.equalNodeSelection( cases[i].actual, cases[i].expected, cases[i].msg );
	}
} );

QUnit.test( 'getBalancedData', function ( assert ) {
	var i,
		doc = new ve.dm.Document( ve.copyArray( ve.dm.example.data ) ),
		cases = [
		{
			'msg': 'empty range',
			'range': new ve.Range( 2, 2 ),
			'expected': []
		},
		{
			'msg': 'range with one character',
			'range': new ve.Range( 2, 3 ),
			'expected': [
				['b', [ ve.dm.example.bold ]]
			]
		},
		{
			'msg': 'range with two characters',
			'range': new ve.Range( 2, 4 ),
			'expected': [
				['b', [ ve.dm.example.bold ]],
				['c', [ ve.dm.example.italic ]]
			]
		},
		{
			'msg': 'range with two characters and a header closing',
			'range': new ve.Range( 2, 5 ),
			'expected': [
				{ 'type': 'heading', 'attributes': { 'level': 1 } },
				['b', [ ve.dm.example.bold ]],
				['c', [ ve.dm.example.italic ]],
				{ 'type': '/heading' }
			]
		},
		{
			'msg': 'range with one character, a header closing and a table opening',
			'range': new ve.Range( 3, 6 ),
			'expected': [
				{ 'type': 'heading', 'attributes': { 'level': 1 } },
				['c', [ ve.dm.example.italic ]],
				{ 'type': '/heading' },
				{ 'type': 'table' },
				{ 'type': '/table' }
			]
		},
		{
			'msg': 'range from a paragraph into a list',
			'range': new ve.Range( 15, 21 ),
			'expected': [
				{ 'type': 'paragraph' },
				'e',
				{ 'type': '/paragraph' },
				{ 'type': 'list', 'attributes': { 'style': 'bullet' } },
				{ 'type': 'listItem' },
				{ 'type': 'paragraph' },
				'f',
				{ 'type': '/paragraph' },
				{ 'type': '/listItem' },
				{ 'type': '/list' }
			]
		},
		{
			'msg': 'range from a paragraph inside a nested list into the next list',
			'range': new ve.Range( 20, 27 ),
			'expected': [
				{ 'type': 'list', 'attributes': { 'style': 'bullet' } },
				{ 'type': 'listItem' },
				{ 'type': 'list', 'attributes': { 'style': 'bullet' } },
				{ 'type': 'listItem' },
				{ 'type': 'paragraph' },
				'f',
				{ 'type': '/paragraph' },
				{ 'type': '/listItem' },
				{ 'type': '/list' },
				{ 'type': '/listItem' },
				{ 'type': '/list' },
				{ 'type': 'list', 'attributes': { 'style': 'number' } },
				{ 'type': '/list' }
			]
		},
		{
			'msg': 'range from a paragraph inside a nested list out of both lists',
			'range': new ve.Range( 20, 26 ),
			'expected': [
				{ 'type': 'list', 'attributes': { 'style': 'bullet' } },
				{ 'type': 'listItem' },
				{ 'type': 'list', 'attributes': { 'style': 'bullet' } },
				{ 'type': 'listItem' },
				{ 'type': 'paragraph' },
				'f',
				{ 'type': '/paragraph' },
				{ 'type': '/listItem' },
				{ 'type': '/list' },
				{ 'type': '/listItem' },
				{ 'type': '/list' }
			]
		},
		{
			'msg': 'range from a paragraph inside a nested list out of the outer listItem',
			'range': new ve.Range( 20, 25 ),
			'expected': [
				{ 'type': 'listItem' },
				{ 'type': 'list', 'attributes': { 'style': 'bullet' } },
				{ 'type': 'listItem' },
				{ 'type': 'paragraph' },
				'f',
				{ 'type': '/paragraph' },
				{ 'type': '/listItem' },
				{ 'type': '/list' },
				{ 'type': '/listItem' }
			]
		}
	];
	QUnit.expect( cases.length );
	for ( i = 0; i < cases.length; i++ ) {
		ve.dm.example.preprocessAnnotations( cases[i].expected );
		assert.deepEqual(
			doc.getBalancedData( cases[i].range ),
			cases[i].expected,
			cases[i].msg
		);
	}
} );
