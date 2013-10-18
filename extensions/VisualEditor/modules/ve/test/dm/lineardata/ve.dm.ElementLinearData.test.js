/*!
 * VisualEditor ElementLinearData tests.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.dm.ElementLinearData' );

/* Tests */

QUnit.test( 'getAnnotationsFromOffset', 1, function ( assert ) {
	var c, i, j,
		data,
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
		data = ve.dm.example.preprocessAnnotations( cases[i].data );
		doc = new ve.dm.Document( data );
		for ( j = 0; j < doc.getData().length; j++ ) {
			annotations = doc.data.getAnnotationsFromOffset( j );
			assert.deepEqual( annotations,
				ve.dm.example.createAnnotationSet( doc.getStore(), cases[i].expected[j] ),
				cases[i].msg[j]
			);
		}
	}
} );

QUnit.test( 'getAnnotationsFromRange', 1, function ( assert ) {
	var i, data, doc,
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
				'a',
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
			'msg': 'no common coverage due to un-annotated content node',
			'data': [
				['a', [ { 'type': 'textStyle/bold' } ] ],
				{ 'type': 'image' },
				{ 'type': '/image' }
			],
			'expected': []
		},
		{
			'msg': 'branch node is ignored',
			'data': [
				['a', [ { 'type': 'textStyle/bold' } ] ],
				{ 'type': 'paragraph' },
				{ 'type': '/paragraph' }
			],
			'expected': [ { 'type': 'textStyle/bold' } ]
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
				'a',
				['b', [ { 'type': 'textStyle/bold' } ] ],
				['c', [ { 'type': 'textStyle/italic' } ] ]
			],
			'all': true,
			'expected': [
				{ 'type': 'textStyle/bold' },
				{ 'type': 'textStyle/italic' }
			]
		},
		{
			'msg': 'annotations are collected using all, even with a plain character in the middle',
			'data': [
				['a', [ { 'type': 'textStyle/bold' } ] ],
				'b',
				['c', [ { 'type': 'textStyle/italic' } ] ]
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
				'c'
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
		data = ve.dm.example.preprocessAnnotations( cases[i].data );
		doc = new ve.dm.Document( data );
		assert.deepEqual(
			doc.data.getAnnotationsFromRange( new ve.Range( 0, cases[i].data.length ), cases[i].all ).getIndexes(),
			ve.dm.example.createAnnotationSet( doc.getStore(), cases[i].expected ).getIndexes(),
			cases[i].msg
		);
	}
} );

QUnit.test( 'getAnnotatedRangeFromOffset', 1, function ( assert ) {
	var i, data, doc,
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
					'attributes': { 'src': ve.dm.example.imgSrc },
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
			'expected': new ve.Range( 1, 7 )
		}
	];

	QUnit.expect( cases.length );

	for ( i = 0; i < cases.length; i++ ) {
		data = ve.dm.example.preprocessAnnotations( cases[i].data );
		doc = new ve.dm.Document( data );
		assert.deepEqual(
			doc.data.getAnnotatedRangeFromOffset( cases[i].offset,
				ve.dm.example.createAnnotation( cases[i].annotation ) ),
			cases[i].expected,
			cases[i].msg
		);
	}
} );

QUnit.test( 'trimOuterSpaceFromRange', function ( assert ) {
	var i, elementData,
		data = [
			// 0
			{ 'type': 'paragraph' },
			// 1
			' ',
			// 2
			'F',
			// 3
			'o',
			// 4
			'o',
			// 5
			' ',
			// 6
			' ',
			// 7
			[ ' ', ve.dm.example.bold ],
			// 8
			[ ' ', ve.dm.example.italic ],
			// 9
			[ 'B', ve.dm.example.italic ],
			// 10
			'a',
			// 11
			'r',
			// 12
			' ',
			// 13
			{ 'type': '/paragraph' }
			// 14
		],
		cases = [
			{
				'msg': 'Word without spaces is untouched',
				'range': new ve.Range( 2, 5 ),
				'trimmed': new ve.Range( 2, 5 )
			},
			{
				'msg': 'Consecutive words with spaces in between but not at the edges are untouched',
				'range': new ve.Range( 2, 12 ),
				'trimmed': new ve.Range( 2, 12 )
			},
			{
				'msg': 'Single space is trimmed from the start',
				'range': new ve.Range( 1, 4 ),
				'trimmed': new ve.Range( 2, 4 )
			},
			{
				'msg': 'Single space is trimmed from the end',
				'range': new ve.Range( 3, 6 ),
				'trimmed': new ve.Range( 3, 5 )
			},
			{
				'msg': 'Single space is trimmed from both sides',
				'range': new ve.Range( 1, 6 ),
				'trimmed': new ve.Range( 2, 5 )
			},
			{
				'msg': 'Different number of spaces trimmed on each side',
				'range': new ve.Range( 1, 7 ),
				'trimmed': new ve.Range( 2, 5 )
			},
			{
				'msg': 'Annotated spaces are trimmed correctly from the end',
				'range': new ve.Range( 3, 9 ),
				'trimmed': new ve.Range( 3, 5 )
			},
			{
				'msg': 'Annotated spaces are trimmed correctly from the start',
				'range': new ve.Range( 7, 10 ),
				'trimmed': new ve.Range( 9, 10 )
			},
			{
				'msg': 'Trimming annotated spaces at the end and plain spaces at the start',
				'range': new ve.Range( 1, 9 ),
				'trimmed': new ve.Range( 2, 5 )
			},
			{
				'msg': 'Spaces are trimmed from the ends but not in the middle',
				'range': new ve.Range( 1, 13 ),
				'trimmed': new ve.Range( 2, 12 )
			},
			{
				'msg': 'All-whitespace range is trimmed to empty range',
				'range': new ve.Range( 5, 9 ),
				'trimmed': new ve.Range( 5, 5 )
			}
		];

	QUnit.expect( cases.length );
	elementData = ve.dm.example.preprocessAnnotations( data );
	for ( i = 0; i < cases.length; i++ ) {
		assert.deepEqual(
			elementData.trimOuterSpaceFromRange( cases[i].range ),
			cases[i].trimmed,
			cases[i].msg
		);
	}
} );

QUnit.test( 'isContentOffset', function ( assert ) {
	var i, left, right,
		data = new ve.dm.ElementLinearData( new ve.dm.IndexValueStore(), [
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
		] ),
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
	QUnit.expect( data.getLength() + 1 );
	for ( i = 0; i < cases.length; i++ ) {
		left = data.getData( i - 1 ) ? ( data.getData( i - 1 ).type || data.getCharacterData( i - 1 ) ) : '[start]';
		right = data.getData( i ) ? ( data.getData( i ).type || data.getCharacterData( i ) ) : '[end]';
		assert.strictEqual(
			data.isContentOffset( i ),
			cases[i].expected,
			cases[i].msg + ' (' + left + '|' + right + ' @ ' + i + ')'
		);
	}
} );

QUnit.test( 'isStructuralOffset', function ( assert ) {
	var i, left, right,
		data = new ve.dm.ElementLinearData( new ve.dm.IndexValueStore(), [
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
		] ),
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
	QUnit.expect( ( data.getLength() + 1 ) * 2 );
	for ( i = 0; i < cases.length; i++ ) {
		left = data.getData( i - 1 ) ? ( data.getData( i - 1 ).type || data.getCharacterData( i - 1 ) ) : '[start]';
		right = data.getData( i ) ? ( data.getData( i ).type || data.getCharacterData( i ) ) : '[end]';
		assert.strictEqual(
			data.isStructuralOffset( i ),
			cases[i].expected[0],
			cases[i].msg + ' (' + left + '|' + right + ' @ ' + i + ')'
		);
		assert.strictEqual(
			data.isStructuralOffset( i, true ),
			cases[i].expected[1],
			cases[i].msg + ', unrestricted (' + left + '|' + right + ' @ ' + i + ')'
		);
	}
} );

QUnit.test( 'isElementData', 1, function ( assert ) {
	var i,
		data = new ve.dm.ElementLinearData( new ve.dm.IndexValueStore(), [
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
		] ),
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
	QUnit.expect( data.getLength() + 1 );
	for ( i = 0; i < cases.length; i++ ) {
		assert.strictEqual( data.isElementData( i ), cases[i].expected, cases[i].msg );
	}
} );

QUnit.test( 'containsElementData', 1, function ( assert ) {
	var i, data,
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
		data = new ve.dm.ElementLinearData( new ve.dm.IndexValueStore(), cases[i].data );
		assert.strictEqual(
			data.containsElementData(), cases[i].expected, cases[i].msg
		);
	}
} );

QUnit.test( 'isContentData', 1, function ( assert ) {
	var i, data,
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
		data = new ve.dm.ElementLinearData( new ve.dm.IndexValueStore(), cases[i].data );
		assert.strictEqual(
			data.isContentData(), cases[i].expected, cases[i].msg
		);
	}
} );

QUnit.test( 'getRelativeOffset', function ( assert ) {
	var i, data, cases = [
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
		data = new ve.dm.ElementLinearData( new ve.dm.IndexValueStore(), cases[i].data );
		assert.strictEqual(
			data.getRelativeOffset(
				cases[i].offset,
				cases[i].distance,
				cases[i].callback
			),
			cases[i].expected,
			cases[i].msg
		);
	}
} );

QUnit.test( 'getRelativeContentOffset', function ( assert ) {
	var i,
		doc = ve.dm.example.createExampleDocument(),
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
			'msg': 'stop at left edge if already valid',
			'offset': 1,
			'distance': -1,
			'expected': 1
		},
		{
			'msg': 'stop at right edge if already valid',
			'offset': 60,
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
			doc.data.getRelativeContentOffset( cases[i].offset, cases[i].distance ),
			cases[i].expected,
			cases[i].msg
		);
	}
} );

QUnit.test( 'getNearestContentOffset', function ( assert ) {
	var i,
		doc = ve.dm.example.createExampleDocument(),
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
			doc.data.getNearestContentOffset( cases[i].offset, cases[i].direction ),
			cases[i].expected,
			cases[i].msg
		);
	}
} );

QUnit.test( 'getRelativeStructuralOffset', function ( assert ) {
	var i,
		doc = ve.dm.example.createExampleDocument(),
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
			'offset': 62,
			'distance': 2,
			'expected': 63
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
			doc.data.getRelativeStructuralOffset(
				cases[i].offset, cases[i].distance, cases[i].unrestricted
			),
			cases[i].expected,
			cases[i].msg
		);
	}
} );

QUnit.test( 'getNearestStructuralOffset', function ( assert ) {
	var i,
		doc = ve.dm.example.createExampleDocument(),
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
			doc.data.getNearestStructuralOffset(
				cases[i].offset, cases[i].direction, cases[i].unrestricted
			),
			cases[i].expected,
			cases[i].msg
		);
	}
} );

QUnit.test( 'getNearestWordRange', function ( assert ) {
	var i, data, range, word,
		store = new ve.dm.IndexValueStore(),
		cases = [
		{
			'phrase': 'visual editor test',
			'msg': 'simple Latin word',
			'offset': 10,
			'expected': 'editor'
		},
		{
			'phrase': 'visual editor test',
			'msg': 'cursor at start of word',
			'offset': 7,
			'expected': 'editor'
		},
		{
			'phrase': 'visual editor test',
			'msg': 'cursor at end of word',
			'offset': 13,
			'expected': 'editor'
		},
		{
			'phrase': 'visual editor test',
			'msg': 'cursor at start of text',
			'offset': 0,
			'expected': 'visual'
		},
		{
			'phrase': 'visual editor test',
			'msg': 'cursor at end of text',
			'offset': 18,
			'expected': 'test'
		},
		{
			'phrase': 'Computer-aided design',
			'msg': 'hyphenated Latin word',
			'offset': 12,
			'expected': 'aided'
		},
		{
			'phrase': 'Water (l\'eau) is',
			'msg': 'apostrophe and parentheses (Latin)',
			'offset': 8,
			'expected': 'l\'eau'
		},
		{
			'phrase': 'Water (H2O) is',
			'msg': 'number in word (Latin)',
			'offset': 9,
			'expected': 'H2O'
		},
		{
			'phrase': 'The \'word\' is',
			'msg': 'apostrophes as single quotes',
			'offset': 7,
			'expected': 'word'
		},
		{
			'phrase': 'Some "double" quotes',
			'msg': 'double quotes',
			'offset': 8,
			'expected': 'double'
		},
		{
			'phrase': 'Wikipédia l\'encyclopédie libre',
			'msg': 'extended Latin word',
			'offset': 15,
			'expected': 'l\'encyclopédie'
		},
		{
			'phrase': 'Wikipédia l\'encyclopédie libre',
			'msg': 'Extend characters (i.e. letter + accent)',
			'offset': 15,
			'expected': 'l\'encyclopédie'
		},
		{
			'phrase': 'Википедия свободная энциклопедия',
			'msg': 'Cyrillic word',
			'offset': 14,
			'expected': 'свободная'
		},
		{
			'phrase': 'την ελεύθερη εγκυκλοπαίδεια',
			'msg': 'Greek word',
			'offset': 7,
			'expected': 'ελεύθερη'
		},
		{
			'phrase': '우리 모두의 백과사전',
			'msg': 'Hangul word',
			'offset': 4,
			'expected': '모두의'
		},
		{
			'phrase': 'This: ٠١٢٣٤٥٦٧٨٩ means 0123456789',
			'msg': 'Eastern Arabic numerals',
			'offset': 13,
			'expected': '٠١٢٣٤٥٦٧٨٩'
		},
		{
			'phrase': 'Latinカタカナwrapped',
			'msg': 'Latin-wrapped Katakana word',
			'offset': 7,
			'expected': 'カタカナ'
		},
		{
			'phrase': '维基百科',
			'msg': 'Hanzi characters (cursor in middle)',
			'offset': 2,
			'expected': ''
		},
		{
			'phrase': '维基百科',
			'msg': 'Hanzi characters (cursor at end)',
			'offset': 4,
			'expected': ''
		},
		{
			'phrase': 'Costs £1,234.00 each',
			'msg': 'formatted number sequence',
			'offset': 11,
			'expected': '1,234.00'
		},
		{
			'phrase': 'Reset index_of variable',
			'msg': 'underscore-joined word',
			'offset': 8,
			'expected': 'index_of'
		}
	];
	QUnit.expect( cases.length );
	for ( i = 0; i < cases.length; i++ ) {
		data = new ve.dm.ElementLinearData( store, cases[i].phrase.split( '' ) );
		range = data.getNearestWordRange( cases[i].offset );
		word = cases[i].phrase.substring( range.start, range.end );
		assert.strictEqual( word, cases[i].expected,
			cases[i].msg + ': ' +
			cases[i].phrase.substring( 0, cases[i].offset ) + '│' +
			cases[i].phrase.substring( cases[i].offset, cases[i].phrase.length ) +
			' → ' + cases[i].expected
		);
	}
} );
