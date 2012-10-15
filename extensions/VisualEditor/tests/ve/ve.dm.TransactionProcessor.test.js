module( 've/dm' );

test( 've.dm.TransactionProcessor', 31, function() {
	var documentModel = ve.dm.DocumentNode.newFromPlainObject( veTest.obj );

	// FIXME: These tests shouldn't use prepareFoo() because those functions
	// normalize the transactions they create and are tested separately.
	// We should be creating transactions directly and feeding those into
	// commit()/rollback() --Roan
	var elementAttributeChange = documentModel.prepareElementAttributeChange(
		0, 'set', 'test', 1
	);

	// Test 1
	ve.dm.TransactionProcessor.commit( documentModel, elementAttributeChange );
	deepEqual(
		documentModel.getData( new ve.Range( 0, 5 ) ),
		[
			{ 'type': 'paragraph', 'attributes': { 'test': 1 } },
			'a',
			['b', { 'type': 'textStyle/bold', 'hash': '{"type":"textStyle/bold"}' }],
			['c', { 'type': 'textStyle/italic', 'hash': '{"type":"textStyle/italic"}' }],
			{ 'type': '/paragraph' }
		],
		'commit applies an element attribute change transaction to the content'
	);

	// Test 2
	ve.dm.TransactionProcessor.rollback( documentModel, elementAttributeChange );
	deepEqual(
		documentModel.getData( new ve.Range( 0, 5 ) ),
		[
			{ 'type': 'paragraph' },
			'a',
			['b', { 'type': 'textStyle/bold', 'hash': '{"type":"textStyle/bold"}' }],
			['c', { 'type': 'textStyle/italic', 'hash': '{"type":"textStyle/italic"}' }],
			{ 'type': '/paragraph' }
		],
		'rollback reverses the effect of an element attribute change transaction on the content'
	);

	var contentAnnotation = documentModel.prepareContentAnnotation(
		new ve.Range( 1, 4 ), 'set', { 'type': 'textStyle/bold' }
	);

	// Test 3
	ve.dm.TransactionProcessor.commit( documentModel, contentAnnotation );
	deepEqual(
		documentModel.getData( new ve.Range( 0, 5 ) ),
		[
			{ 'type': 'paragraph' },
			['a', { 'type': 'textStyle/bold', 'hash': '{"type":"textStyle/bold"}' }],
			['b', { 'type': 'textStyle/bold', 'hash': '{"type":"textStyle/bold"}' }],
			[
				'c',
				{ 'type': 'textStyle/italic', 'hash': '{"type":"textStyle/italic"}' },
				{ 'type': 'textStyle/bold', 'hash': '{"type":"textStyle/bold"}' }
			],
			{ 'type': '/paragraph' }
		],
		'commit applies a content annotation transaction to the content'
	);

	// Test 4
	ve.dm.TransactionProcessor.rollback( documentModel, contentAnnotation );
	deepEqual(
		documentModel.getData( new ve.Range( 0, 5 ) ),
		[
			{ 'type': 'paragraph' },
			'a',
			['b', { 'type': 'textStyle/bold', 'hash': '{"type":"textStyle/bold"}' }],
			['c', { 'type': 'textStyle/italic', 'hash': '{"type":"textStyle/italic"}' }],
			{ 'type': '/paragraph' }
		],
		'rollback reverses the effect of a content annotation transaction on the content'
	);

	var insertion = documentModel.prepareInsertion( 3, ['d'] );

	// Test 5
	ve.dm.TransactionProcessor.commit( documentModel, insertion );
	deepEqual(
		documentModel.getData( new ve.Range( 0, 6 ) ),
		[
			{ 'type': 'paragraph' },
			'a',
			['b', { 'type': 'textStyle/bold', 'hash': '{"type":"textStyle/bold"}' }],
			'd',
			['c', { 'type': 'textStyle/italic', 'hash': '{"type":"textStyle/italic"}' }],
			{ 'type': '/paragraph' }
		],
		'commit applies an insertion transaction to the content'
	);

	// Test 6
	deepEqual(
		documentModel.getChildren()[0].getContentData(),
		[
			'a',
			['b', { 'type': 'textStyle/bold', 'hash': '{"type":"textStyle/bold"}' }],
			'd',
			['c', { 'type': 'textStyle/italic', 'hash': '{"type":"textStyle/italic"}' }]
		],
		'commit keeps model tree up to date with insertions'
	);

	// Test 7
	ve.dm.TransactionProcessor.rollback( documentModel, insertion );
	deepEqual(
		documentModel.getData( new ve.Range( 0, 5 ) ),
		[
			{ 'type': 'paragraph' },
			'a',
			['b', { 'type': 'textStyle/bold', 'hash': '{"type":"textStyle/bold"}' }],
			['c', { 'type': 'textStyle/italic', 'hash': '{"type":"textStyle/italic"}' }],
			{ 'type': '/paragraph' }
		],
		'rollback reverses the effect of an insertion transaction on the content'
	);

	// Test 8
	deepEqual(
		documentModel.getChildren()[0].getContentData(),
		[
			'a',
			['b', { 'type': 'textStyle/bold', 'hash': '{"type":"textStyle/bold"}' }],
			['c', { 'type': 'textStyle/italic', 'hash': '{"type":"textStyle/italic"}' }]
		],
		'rollback keeps model tree up to date with insertions'
	);

	var removal = documentModel.prepareRemoval( new ve.Range( 2, 4 ) );

	// Test 9
	ve.dm.TransactionProcessor.commit( documentModel, removal );
	deepEqual(
		documentModel.getData( new ve.Range( 0, 3 ) ),
		[
			{ 'type': 'paragraph' },
			'a',
			{ 'type': '/paragraph' }
		],
		'commit applies a removal transaction to the content'
	);

	// Test 10
	deepEqual(
		documentModel.getChildren()[0].getContentData(),
		['a'],
		'commit keeps model tree up to date with removals'
	);

	// Test 11
	ve.dm.TransactionProcessor.rollback( documentModel, removal );
	deepEqual(
		documentModel.getData( new ve.Range( 0, 5 ) ),
		[
			{ 'type': 'paragraph' },
			'a',
			['b', { 'type': 'textStyle/bold', 'hash': '{"type":"textStyle/bold"}' }],
			['c', { 'type': 'textStyle/italic', 'hash': '{"type":"textStyle/italic"}' }],
			{ 'type': '/paragraph' }
		],
		'rollback reverses the effect of a removal transaction on the content'
	);

	// Test 12
	deepEqual(
		documentModel.getChildren()[0].getContentData(),
		[
			'a',
			['b', { 'type': 'textStyle/bold', 'hash': '{"type":"textStyle/bold"}' }],
			['c', { 'type': 'textStyle/italic', 'hash': '{"type":"textStyle/italic"}' }]
		],
		'rollback keeps model tree up to date with removals'
	);
	
	var paragraphBreak = documentModel.prepareInsertion(
		2, [{ 'type': '/paragraph' }, { 'type': 'paragraph' }]
	);
	
	// Test 13
	ve.dm.TransactionProcessor.commit( documentModel, paragraphBreak );
	deepEqual(
		documentModel.getData( new ve.Range( 0, 7 ) ),
		[
			{ 'type': 'paragraph' },
			'a',
			{ 'type': '/paragraph' },
			{ 'type': 'paragraph' },
			['b', { 'type': 'textStyle/bold', 'hash': '{"type":"textStyle/bold"}' }],
			['c', { 'type': 'textStyle/italic', 'hash': '{"type":"textStyle/italic"}' }],
			{ 'type': '/paragraph' }
		],
		'commit applies an insertion transaction that splits the paragraph'
	);
	
	// Test 14
	deepEqual(
		documentModel.getChildren()[0].getContentData(),
		['a'],
		'commit keeps model tree up to date with paragraph split (paragraph 1)'
	);
	
	// Test 15
	deepEqual(
		documentModel.getChildren()[1].getContentData(),
		[
			['b', { 'type': 'textStyle/bold', 'hash': '{"type":"textStyle/bold"}' }],
			['c', { 'type': 'textStyle/italic', 'hash': '{"type":"textStyle/italic"}' }]
		],
		'commit keeps model tree up to date with paragraph split (paragraph 2)'
	);

	// Test 16
	ve.dm.TransactionProcessor.rollback( documentModel, paragraphBreak );
	deepEqual(
		documentModel.getData( new ve.Range( 0, 5 ) ),
		[
			{ 'type': 'paragraph' },
			'a',
			['b', { 'type': 'textStyle/bold', 'hash': '{"type":"textStyle/bold"}' }],
			['c', { 'type': 'textStyle/italic', 'hash': '{"type":"textStyle/italic"}' }],
			{ 'type': '/paragraph' }
		],
		'rollback reverses the effect of a paragraph split on the content'
	);
	
	// Test 17
	deepEqual(
		documentModel.getChildren()[0].getContentData(),
		[
			'a',
			['b', { 'type': 'textStyle/bold', 'hash': '{"type":"textStyle/bold"}' }],
			['c', { 'type': 'textStyle/italic', 'hash': '{"type":"textStyle/italic"}' }]
		],
		'rollback keeps model tree up to date with paragraph split (paragraphs are merged back)'
	);
	
	// Test 18
	deepEqual(
		documentModel.getChildren()[1].getElementType(),
		'table',
		'rollback keeps model tree up to date with paragraph split (table follows the paragraph)'
	);
	
	var listItemMerge = documentModel.prepareRemoval( new ve.Range( 14, 19 ) );
	
	// Test 19
	ve.dm.TransactionProcessor.commit( documentModel, listItemMerge );
	deepEqual(
		documentModel.getData( new ve.Range( 12, 22 ) ),
		[
			{ 'type': 'listItem', 'attributes': { 'styles': ['bullet'] } },
			{ 'type': 'paragraph' },
			'f',
			{ 'type': '/paragraph' },
			{ 'type': '/listItem' },
			{ 'type': 'listItem', 'attributes': { 'styles': ['number'] } },
			{ 'type': 'paragraph' },
			'g',
			{ 'type': '/paragraph' },
			{ 'type': '/listItem' }
		],
		'removal merges two list items with paragraphs'
	);
	
	// Test 20
	deepEqual( documentModel.children[1].children[0].children[0].children[1].children.length, 2,
		'removal keeps model tree up to date with list item merge (number of children)'
	);
	
	// Test 21
	deepEqual(
		documentModel.children[1].children[0].children[0].children[1].children[0].children[0].getContentData(),
		[ 'f' ],
		'removal keeps model tree up to date with list item merge (first list item)'
	);
	
	// Test 22
	deepEqual(
		documentModel.children[1].children[0].children[0].children[1].children[1].children[0].getContentData(),
		[ 'g' ],
		'removal keeps model tree up to date with list item merge (second list item)'
	);
	
	// Test 23
	deepEqual(
		documentModel.children[2].getContentData(),
		[ 'h' ],
		'rollback keeps model tree up to date with list item split (final paragraph)'
	);
	
	// Test 24
	ve.dm.TransactionProcessor.rollback( documentModel, listItemMerge );
	deepEqual(
		documentModel.getData( new ve.Range( 12, 27 ) ),
		[
			{ 'type': 'listItem', 'attributes': { 'styles': ['bullet'] } },
			{ 'type': 'paragraph' },
			'e',
			{ 'type': '/paragraph' },
			{ 'type': '/listItem' },
			{ 'type': 'listItem', 'attributes': { 'styles': ['bullet', 'bullet'] } },
			{ 'type': 'paragraph' },
			'f',
			{ 'type': '/paragraph' },
			{ 'type': '/listItem' },
			{ 'type': 'listItem', 'attributes': { 'styles': ['number'] } },
			{ 'type': 'paragraph' },
			'g',
			{ 'type': '/paragraph' },
			{ 'type': '/listItem' }
		],
		'rollback reverses list item merge (splits the list items)'
	);
	
	// Test 25
	deepEqual( documentModel.children[1].children[0].children[0].children[1].children.length, 3,
		'rollback keeps model tree up to date with list item split (number of children)'
	);
	
	// Test 26
	deepEqual(
		documentModel.children[1].children[0].children[0].children[1].children[0].children[0].getContentData(),
		[ 'e' ],
		'rollback keeps model tree up to date with list item split (first list item)'
	);
	
	// Test 27
	deepEqual(
		documentModel.children[1].children[0].children[0].children[1].children[1].children[0].getContentData(),
		[ 'f' ],
		'rollback keeps model tree up to date with list item split (second list item)'
	);
	
	// Test 28
	deepEqual(
		documentModel.children[1].children[0].children[0].children[1].children[2].children[0].getContentData(),
		[ 'g' ],
		'rollback keeps model tree up to date with list item split (third list item)'
	);
	
	// Test 29
	deepEqual(
		documentModel.children[2].getContentData(),
		[ 'h' ],
		'rollback keeps model tree up to date with list item split (final paragraph)'
	);
	
	var listSplit = documentModel.prepareInsertion( 17, [{ 'type': '/list' }, { 'type': 'list' }] );

	// Test 30
	ve.dm.TransactionProcessor.commit( documentModel, listSplit );
	deepEqual(
		documentModel.getData( new ve.Range( 15, 21 ) ),
		[
			{ 'type': '/paragraph' },
			{ 'type': '/listItem' },
			{ 'type': '/list' },
			{ 'type': 'list' },
			{ 'type': 'listItem', 'attributes': { 'styles': ['bullet', 'bullet'] } },
			{ 'type': 'paragraph' }
		],
		'commit splits list into two lists'
	);
	
	// Test 31
	ve.dm.TransactionProcessor.rollback( documentModel, listSplit );
	deepEqual(
		documentModel.getData( new ve.Range( 15, 19 ) ),
		[
			{ 'type': '/paragraph' },
			{ 'type': '/listItem' },
			{ 'type': 'listItem', 'attributes': { 'styles': ['bullet', 'bullet'] } },
			{ 'type': 'paragraph' }
		],
		'rollback reverses list split'
	);
} );
