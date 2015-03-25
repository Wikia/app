/*!
 * VisualEditor DataModel Document tests.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

QUnit.module( 've.dm.Document' );

/* Tests */

QUnit.test( 'constructor', 11, function ( assert ) {
	var data, htmlDoc,
		doc = ve.dm.example.createExampleDocument();
	assert.equalNodeTree( doc.getDocumentNode(), ve.dm.example.tree, 'node tree matches example data' );
	assert.throws(
		function () {
			doc = new ve.dm.Document( [
				{ type: '/paragraph' },
				{ type: 'paragraph' }
			] );
			doc.buildNodeTree();
		},
		Error,
		'unbalanced input causes exception'
	);

	doc = new ve.dm.Document( [ 'a', 'b', 'c', 'd' ] );
	assert.equalNodeTree(
		doc.getDocumentNode(),
		new ve.dm.DocumentNode( [ new ve.dm.TextNode( 4 ) ] ),
		'plain text input is handled correctly'
	);
	assert.deepEqualWithDomElements( doc.getMetadata(), new Array( 5 ),
		'sparse metadata array is created'
	);
	assert.strictEqual( doc.getHtmlDocument().body.innerHTML, '', 'Empty HTML document is created' );

	htmlDoc = ve.createDocumentFromHtml( 'abcd' );
	doc = new ve.dm.Document( [ 'a', 'b', 'c', 'd' ], htmlDoc );
	assert.strictEqual( doc.getHtmlDocument(), htmlDoc, 'Provided HTML document is used' );

	data = new ve.dm.ElementLinearData(
		new ve.dm.IndexValueStore(),
		[ { type: 'paragraph' }, { type: '/paragraph' } ]
	);
	doc = new ve.dm.Document( data );
	assert.equalNodeTree(
		doc.getDocumentNode(),
		new ve.dm.DocumentNode( [ new ve.dm.ParagraphNode( { type: 'paragraph' } ) ] ),
		'empty paragraph no longer has a text node'
	);
	assert.strictEqual( doc.data, data, 'ElementLinearData is stored by reference' );

	doc = ve.dm.example.createExampleDocument( 'withMeta' );
	assert.deepEqualWithDomElements( doc.getData(), ve.dm.example.withMetaPlainData,
		'metadata is stripped out of the linear model'
	);
	assert.deepEqualWithDomElements( doc.getMetadata(), ve.dm.example.withMetaMetaData,
		'metadata is put in the meta-linmod'
	);
	assert.equalNodeTree(
		doc.getDocumentNode(),
		new ve.dm.DocumentNode( [
			new ve.dm.ParagraphNode( ve.dm.example.withMetaPlainData[0], [ new ve.dm.TextNode( 9 ) ] ),
			new ve.dm.InternalListNode( ve.dm.example.withMetaPlainData[11] )
		] ),
		'node tree does not contain metadata'
	);
} );

QUnit.test( 'getData', 1, function ( assert ) {
	var doc = ve.dm.example.createExampleDocument(),
		expectedData = ve.dm.example.preprocessAnnotations( ve.copy( ve.dm.example.data ) );
	assert.deepEqualWithDomElements( doc.getData(), expectedData.getData() );
} );

QUnit.test( 'getFullData', 1, function ( assert ) {
	var doc = ve.dm.example.createExampleDocument( 'withMeta' );
	assert.deepEqualWithDomElements( doc.getFullData(), ve.dm.example.withMeta );
} );

QUnit.test( 'cloneFromRange', function ( assert ) {
	var i, doc2, doc = ve.dm.example.createExampleDocument( 'internalData' ),
		cases = [
			{
				msg: 'first internal item',
				doc: 'internalData',
				range: new ve.Range( 7, 12 ),
				expectedData: doc.data.slice( 7, 12 ).concat( doc.data.slice( 5, 21 ) )
			},
			{
				msg: 'second internal item',
				doc: 'internalData',
				range: doc.getInternalList().getItemNode( 1 ).getRange(),
				expectedData: doc.data.slice( 14, 19 ).concat( doc.data.slice( 5, 21 ) )
			},
			{
				msg: 'paragraph at the start',
				doc: 'internalData',
				range: new ve.Range( 0, 5 ),
				expectedData: doc.data.slice( 0, 21 )
			},
			{
				msg: 'paragraph at the end',
				doc: 'internalData',
				range: new ve.Range( 21, 27 ),
				expectedData: doc.data.slice( 21, 27 ).concat( doc.data.slice( 5, 21 ) )
			}
		];
	QUnit.expect( 4 * cases.length );
	for ( i = 0; i < cases.length; i++ ) {
		doc = ve.dm.example.createExampleDocument( cases[i].doc );
		doc2 = doc.cloneFromRange( cases[i].range );
		assert.deepEqual( doc2.data.data, cases[i].expectedData,
			cases[i].msg + ': sliced data' );
		assert.notStrictEqual( doc2.data[0], cases[i].expectedData[0],
			cases[i].msg + ': data is cloned, not the same' );
		assert.deepEqual( doc2.store, doc.store,
			cases[i].msg + ': store is copied' );
		assert.notStrictEqual( doc2.store, doc.store,
			cases[i].msg + ': store is a clone, not the same' );
	}
} );

QUnit.test( 'getRelativeOffset', function ( assert ) {
	var i, j,
		expectCount = 0,
		documentModel = ve.dm.example.createExampleDocument( 'alienData' ),
		tests = [
			{
				direction: 1,
				unit: 'character',
				cases: [
					{ input: 0, output: 1 },
					{ input: 2, output: 3 },
					{ input: 3, output: 4 },
					{ input: 4, output: 5 },
					{ input: 6, output: 7 },
					{ input: 7, output: 9 },
					{ input: 10, output: 10 }
				]
			},
			{
				direction: 1,
				unit: 'word',
				cases: [
					{ input: 0, output: 1 },
					{ input: 2, output: 3 },
					{ input: 3, output: 4 },
					{ input: 4, output: 5 },
					{ input: 6, output: 7 },
					{ input: 7, output: 9 },
					{ input: 10, output: 10 }
				]
			},
			{
				direction: -1,
				unit: 'character',
				cases: [
					{ input: 10, output: 9 },
					{ input: 8, output: 7 },
					{ input: 7, output: 6 },
					{ input: 6, output: 5 },
					{ input: 4, output: 3 },
					{ input: 3, output: 1 },
					{ input: 0, output: 0 }
				]
			},
			{
				direction: -1,
				unit: 'word',
				cases: [
					{ input: 10, output: 9 },
					{ input: 8, output: 7 },
					{ input: 7, output: 6 },
					{ input: 6, output: 5 },
					{ input: 4, output: 3 },
					{ input: 3, output: 1 },
					{ input: 0, output: 0 }
				]
			}
		];
	for ( i = 0; i < tests.length; i++ ) {
		for ( j = 0; j < tests[i].cases.length; j++ ) {
			assert.strictEqual(
				documentModel.getRelativeOffset(
					tests[i].cases[j].input,
					tests[i].direction,
					tests[i].unit
				),
				tests[i].cases[j].output,
				tests[i].cases[j].input + ', ' + tests[i].direction + ', ' + tests[i].unit
			);
		}
		expectCount += tests[i].cases.length;
	}
	QUnit.expect( expectCount );
} );

QUnit.test( 'getRelativeRange', function ( assert ) {
	var documentModel, i, j,
		expectCount = 0,
		tests = [
			{
				data: [
					/* 0 */ { type: 'paragraph' },
					/* 1 */ 'a',
					/* 2 */ { type: 'alienInline' },
					/* 3 */ { type: '/alienInline' },
					/* 4 */ 'b',
					/* 5 */ { type: '/paragraph' }
				],
				cases: [
					{
						direction: 1,
						given: new ve.Range( 1 ),
						expected: new ve.Range( 2 )
					},
					{
						direction: 1,
						given: new ve.Range( 2 ),
						expected: new ve.Range( 2, 4 )
					},
					{
						direction: 1,
						given: new ve.Range( 2, 4 ),
						expected: new ve.Range( 4 )
					},

					{
						direction: 1,
						expand: true,
						given: new ve.Range( 1 ),
						expected: new ve.Range( 1, 2 )
					},
					{
						direction: 1,
						expand: true,
						given: new ve.Range( 1, 2 ),
						expected: new ve.Range( 1, 4 )
					},
					{
						direction: 1,
						expand: true,
						given: new ve.Range( 1, 4 ),
						expected: new ve.Range( 1, 5 )
					}
				]
			},
			{
				data: [
					/* 0 */ { type: 'paragraph' },
					/* 1 */ { type: 'alienInline' },
					/* 2 */ { type: '/alienInline' },
					/* 3 */ { type: 'alienInline' },
					/* 4 */ { type: '/alienInline' },
					/* 5 */ { type: '/paragraph' }
				],
				cases: [
					{
						direction: 1,
						given: new ve.Range( 3 ),
						expected: new ve.Range( 3, 5 )
					},
					{
						direction: 1,
						expand: true,
						given: new ve.Range( 1, 3 ),
						expected: new ve.Range( 1, 5 )
					},
					{
						direction: -1,
						expand: true,
						given: new ve.Range( 1, 5 ),
						expected: new ve.Range( 1, 3 )
					},
					{
						direction: 1,
						expand: true,
						given: new ve.Range( 5, 1 ),
						expected: new ve.Range( 5, 3 )
					}
				]
			},
			{
				data: ve.copy( ve.dm.example.alienData ),
				cases: [
					{
						direction: 1,
						given: new ve.Range( 0 ),
						expected: new ve.Range( 0, 2 )
					},
					{
						direction: 1,
						given: new ve.Range( 0, 2 ),
						expected: new ve.Range( 3 )
					},
					{
						direction: 1,
						given: new ve.Range( 3 ),
						expected: new ve.Range( 4 )
					},
					{
						direction: 1,
						given: new ve.Range( 4 ),
						expected: new ve.Range( 4, 6 )
					},
					{
						direction: 1,
						given: new ve.Range( 4, 6),
						expected: new ve.Range( 6 )
					},
					{
						direction: 1,
						given: new ve.Range( 6 ),
						expected: new ve.Range( 7 )
					},
					{
						direction: 1,
						given: new ve.Range( 7 ),
						expected: new ve.Range( 8, 10 )
					},
					{
						direction: 1,
						given: new ve.Range( 10 ),
						expected: new ve.Range( 10 )
					},
					{
						direction: -1,
						given: new ve.Range( 10 ),
						expected: new ve.Range( 10, 8 )
					},
					{
						direction: -1,
						given: new ve.Range( 10, 8 ),
						expected: new ve.Range( 7 )
					},
					{
						direction: -1,
						given: new ve.Range( 7 ),
						expected: new ve.Range( 6 )
					},
					{
						direction: -1,
						given: new ve.Range( 6 ),
						expected: new ve.Range( 6, 4 )
					},
					{
						direction: -1,
						given: new ve.Range( 6, 4 ),
						expected: new ve.Range( 4 )
					},
					{
						direction: -1,
						given: new ve.Range( 4 ),
						expected: new ve.Range( 3 )
					},
					{
						direction: -1,
						given: new ve.Range( 3 ),
						expected: new ve.Range( 2, 0 )
					},
					{
						direction: -1,
						given: new ve.Range( 2, 0 ),
						expected: new ve.Range( 0 )
					}
				]
			}
		];
	for ( i = 0; i < tests.length; i++ ) {
		documentModel = new ve.dm.Document( tests[i].data );
		for ( j = 0; j < tests[i].cases.length; j++ ) {
			expectCount++;
			assert.equalRange(
				documentModel.getRelativeRange(
					tests[i].cases[j].given,
					tests[i].cases[j].direction,
					'character',
					!!tests[i].cases[j].expand
				),
				tests[i].cases[j].expected,
				'Test document ' + i +
				', range ' + tests[i].cases[j].given.toJSON() +
				', direction ' + tests[i].cases[j].direction
			);
		}
	}
	QUnit.expect( expectCount );
} );

QUnit.test( 'getBranchNodeFromOffset', function ( assert ) {
	var i, j, node,
		doc = ve.dm.example.createExampleDocument(),
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
		assert.ok( node === doc.getBranchNodeFromOffset( i ), 'reference at offset ' + i );
	}
} );

QUnit.test( 'hasSlugAtOffset', function ( assert ) {
	var i, l,
		expected = {
			0: true,
			10: true
		},
		doc = ve.dm.example.createExampleDocument( 'alienData' );

	QUnit.expect( doc.data.getLength() + 1 );

	for ( i = 0, l = doc.data.getLength(); i <= l; i++ ) {
		assert.strictEqual( doc.hasSlugAtOffset( i ), !!expected[i], 'hasSlugAtOffset ' + i + ' = ' + !!expected[i] );
	}

} );

QUnit.test( 'getDataFromNode', 3, function ( assert ) {
	var doc = ve.dm.example.createExampleDocument(),
		expectedData = ve.dm.example.preprocessAnnotations( ve.copy( ve.dm.example.data ) );
	assert.deepEqual(
		doc.getDataFromNode( doc.getDocumentNode().getChildren()[0] ),
		expectedData.slice( 1, 4 ),
		'branch with leaf children'
	);
	assert.deepEqual(
		doc.getDataFromNode( doc.getDocumentNode().getChildren()[1] ),
		expectedData.slice( 6, 36 ),
		'branch with branch children'
	);
	assert.deepEqual(
		doc.getDataFromNode( doc.getDocumentNode().getChildren()[2].getChildren()[1] ),
		[],
		'leaf without children'
	);
} );

QUnit.test( 'getOuterLength', 1, function ( assert ) {
	var doc = ve.dm.example.createExampleDocument();
	assert.strictEqual(
		doc.getDocumentNode().getOuterLength(),
		ve.dm.example.data.length,
		'document does not have elements around it'
	);
} );

QUnit.test( 'rebuildNodes', 2, function ( assert ) {
	var tree,
		doc = ve.dm.example.createExampleDocument(),
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
	doc.data.batchSplice( 5, 32, [ { type: 'paragraph' }, 'a', 'b', 'c', { type: '/paragraph' } ] );
	tree.splice( 1, 1, new ve.dm.ParagraphNode(
		doc.data.getData( 5 ), [new ve.dm.TextNode( 3 )]
	) );
	// Rebuild with changes
	doc.rebuildNodes( documentNode, 1, 1, 5, 5 );
	assert.equalNodeTree(
		documentNode,
		tree,
		'replace table with paragraph'
	);
} );

QUnit.test( 'selectNodes', function ( assert ) {
	var i, doc, expectedSelection,
		mainDoc = ve.dm.example.createExampleDocument(),
		cases = ve.dm.example.selectNodesCases;

	function resolveNode( item ) {
		var newItem = ve.extendObject( {}, item );
		newItem.node = ve.dm.example.lookupNode.apply(
			ve.dm.example, [ doc.getDocumentNode() ].concat( item.node )
		);
		return newItem;
	}

	QUnit.expect( cases.length );
	for ( i = 0; i < cases.length; i++ ) {
		doc = cases[i].doc ? ve.dm.example.createExampleDocument( cases[i].doc ) : mainDoc;
		expectedSelection = cases[i].expected.map( resolveNode );
		assert.equalNodeSelection(
			doc.selectNodes( cases[i].range, cases[i].mode ), expectedSelection, cases[i].msg
		);
	}
} );

QUnit.test( 'cloneSliceFromRange', function ( assert ) {
	var i, expectedData, slice, range, doc,
		cases = [
			{
				msg: 'empty range',
				range: new ve.Range( 2 ),
				expected: []
			},
			{
				msg: 'range with one character',
				range: new ve.Range( 2, 3 ),
				expected: [
					['b', [ ve.dm.example.bold ]]
				]
			},
			{
				msg: 'range with two characters',
				range: new ve.Range( 2, 4 ),
				expected: [
					['b', [ ve.dm.example.bold ]],
					['c', [ ve.dm.example.italic ]]
				]
			},
			{
				msg: 'range with two characters and a header closing',
				range: new ve.Range( 2, 5 ),
				expected: [
					{ type: 'heading', attributes: { level: 1 } },
					['b', [ ve.dm.example.bold ]],
					['c', [ ve.dm.example.italic ]],
					{ type: '/heading' }
				],
				originalRange: new ve.Range( 1, 4 )
			},
			{
				msg: 'range with one character, a header closing and a table opening',
				range: new ve.Range( 3, 6 ),
				expected: [
					{ type: 'heading', attributes: { level: 1 } },
					['c', [ ve.dm.example.italic ]],
					{ type: '/heading' },
					{ type: 'table' },
					{ type: '/table' }
				],
				originalRange: new ve.Range( 1, 4 )
			},
			{
				msg: 'range from a paragraph into a list',
				range: new ve.Range( 15, 21 ),
				expected: [
					{ type: 'paragraph' },
					'e',
					{ type: '/paragraph' },
					{ type: 'list', attributes: { style: 'bullet' } },
					{ type: 'listItem' },
					{ type: 'paragraph' },
					'f',
					{ type: '/paragraph' },
					{ type: '/listItem' },
					{ type: '/list' }
				],
				originalRange: new ve.Range( 1, 7 )
			},
			{
				msg: 'range from a paragraph inside a nested list into the next list',
				range: new ve.Range( 20, 27 ),
				expected: [
					{ type: 'list', attributes: { style: 'bullet' } },
					{ type: 'listItem' },
					{ type: 'list', attributes: { style: 'bullet' } },
					{ type: 'listItem' },
					{ type: 'paragraph' },
					'f',
					{ type: '/paragraph' },
					{ type: '/listItem' },
					{ type: '/list' },
					{ type: '/listItem' },
					{ type: '/list' },
					{ type: 'list', attributes: { style: 'number' } },
					{ type: '/list' }
				],
				originalRange: new ve.Range( 5, 12 )
			},
			{
				msg: 'range from a paragraph inside a nested list out of both lists',
				range: new ve.Range( 20, 26 ),
				expected: [
					{ type: 'list', attributes: { style: 'bullet' } },
					{ type: 'listItem' },
					{ type: 'list', attributes: { style: 'bullet' } },
					{ type: 'listItem' },
					{ type: 'paragraph' },
					'f',
					{ type: '/paragraph' },
					{ type: '/listItem' },
					{ type: '/list' },
					{ type: '/listItem' },
					{ type: '/list' }
				],
				originalRange: new ve.Range( 5, 11 )
			},
			{
				msg: 'range from a paragraph inside a nested list out of the outer listItem',
				range: new ve.Range( 20, 25 ),
				expected: [
					{ type: 'list', attributes: { style: 'bullet' } },
					{ type: 'listItem' },
					{ type: 'list', attributes: { style: 'bullet' } },
					{ type: 'listItem' },
					{ type: 'paragraph' },
					'f',
					{ type: '/paragraph' },
					{ type: '/listItem' },
					{ type: '/list' },
					{ type: '/listItem' },
					{ type: '/list' }
				],
				originalRange: new ve.Range( 5, 10 ),
				balancedRange: new ve.Range( 1, 10 )
			},
			{
				msg: 'table cell',
				range: new ve.Range( 8, 34 ),
				expected: [
					{ type: 'table' },
					{ type: 'tableSection', attributes: { style: 'body' } },
					{ type: 'tableRow' },
					{ type: 'tableCell', attributes: { style: 'data' } },
					{ type: 'paragraph' },
					'd',
					{ type: '/paragraph' },
					{ type: 'list', attributes: { style: 'bullet' } },
					{ type: 'listItem' },
					{ type: 'paragraph' },
					'e',
					{ type: '/paragraph' },
					{ type: 'list', attributes: { style: 'bullet' } },
					{ type: 'listItem' },
					{ type: 'paragraph' },
					'f',
					{ type: '/paragraph' },
					{ type: '/listItem' },
					{ type: '/list' },
					{ type: '/listItem' },
					{ type: '/list' },
					{ type: 'list', attributes: { style: 'number' } },
					{ type: 'listItem' },
					{ type: 'paragraph' },
					'g',
					{ type: '/paragraph' },
					{ type: '/listItem' },
					{ type: '/list' },
					{ type: '/tableCell' },
					{ type: '/tableRow' },
					{ type: '/tableSection' },
					{ type: '/table' }
				],
				originalRange: new ve.Range( 3, 29 ),
				balancedRange: new ve.Range( 3, 29 )
			},
			{
				doc: 'inlineAtEdges',
				msg: 'inline node at start',
				range: new ve.Range( 1, 3 ),
				expected: [
					ve.dm.example.image.data,
					{ type: '/inlineImage' }
				],
				originalRange: new ve.Range( 0, 2 ),
				balancedRange: new ve.Range( 0, 2 )
			},
			{
				doc: 'inlineAtEdges',
				msg: 'inline node at end',
				range: new ve.Range( 6, 8 ),
				expected: [
					{ type: 'alienInline', attributes: { domElements: $( '<foobar />' ).toArray() } },
					{ type: '/alienInline' }
				],
				originalRange: new ve.Range( 0, 2 ),
				balancedRange: new ve.Range( 0, 2 )
			},
			{
				doc: 'inlineAtEdges',
				msg: 'inline node at start with text',
				range: new ve.Range( 1, 5 ),
				expected: [
					ve.dm.example.image.data,
					{ type: '/inlineImage' },
					'F', 'o'
				],
				originalRange: new ve.Range( 0, 4 ),
				balancedRange: new ve.Range( 0, 4 )
			},
			{
				doc: 'inlineAtEdges',
				msg: 'inline node at end with text',
				range: new ve.Range( 4, 8 ),
				expected: [
					'o', 'o',
					{ type: 'alienInline', attributes: { domElements: $( '<foobar />' ).toArray() } },
					{ type: '/alienInline' }
				],
				originalRange: new ve.Range( 0, 4 ),
				balancedRange: new ve.Range( 0, 4 )
			}
		];
	QUnit.expect( 3 * cases.length );
	for ( i = 0; i < cases.length; i++ ) {
		doc = ve.dm.example.createExampleDocument( cases[i].doc );
		expectedData = ve.dm.example.preprocessAnnotations( cases[i].expected.slice(), doc.getStore() ).getData();
		range = new ve.Range( 0, cases[i].expected.length );
		expectedData = expectedData.concat( [
			{ type: 'internalList' },
			{ type: '/internalList' }
		] );
		slice = doc.cloneSliceFromRange( cases[i].range );
		assert.deepEqualWithDomElements(
			slice.getData(),
			expectedData,
			cases[i].msg + ': data'
		);
		assert.equalRange(
			slice.originalRange,
			cases[i].originalRange || range,
			cases[i].msg + ': original range'
		);
		assert.equalRange(
			slice.balancedRange,
			cases[i].balancedRange || range,
			cases[i].msg + ': balanced range'
		);
	}
} );

QUnit.test( 'protection against double application of transactions', 1, function ( assert ) {
	var tx = new ve.dm.Transaction(), testDocument = ve.dm.example.createExampleDocument();
	tx.pushRetain( 1 );
	tx.pushReplace( testDocument, 1, 0, ['H', 'e', 'l', 'l', 'o' ] );
	testDocument.commit( tx );
	assert.throws(
		function () {
			testDocument.commit( tx );
		},
		Error,
		'exception thrown when trying to commit an already-committed transaction'
	);
} );
