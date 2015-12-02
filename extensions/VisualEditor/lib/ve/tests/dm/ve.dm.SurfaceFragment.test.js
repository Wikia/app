/*!
 * VisualEditor DataModel SurfaceFragment tests.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

QUnit.module( 've.dm.SurfaceFragment' );

/* Tests */

QUnit.test( 'constructor', 5, function ( assert ) {
	var fragment,
		doc = ve.dm.example.createExampleDocument(),
		surface = new ve.dm.Surface( doc );

	surface.setLinearSelection( new ve.Range( 1 ) );
	fragment = new ve.dm.SurfaceFragment( surface );

	// Default range and autoSelect
	assert.strictEqual( fragment.getSurface(), surface, 'surface reference is stored' );
	assert.strictEqual( fragment.getDocument(), doc, 'document reference is stored' );
	assert.equalRange( fragment.getSelection().getRange(), new ve.Range( 1 ), 'range is taken from surface' );
	assert.strictEqual( fragment.willAutoSelect(), true, 'auto select by default' );
	// AutoSelect
	fragment = new ve.dm.SurfaceFragment( surface, null, 'truthy' );
	assert.strictEqual( fragment.willAutoSelect(), false, 'noAutoSelect values are boolean' );
} );

QUnit.test( 'update', 3, function ( assert ) {
	var doc = ve.dm.example.createExampleDocument(),
		surface = new ve.dm.Surface( doc ),
		fragment1 = surface.getLinearFragment( new ve.Range( 55, 61 ) ),
		fragment2 = surface.getLinearFragment( new ve.Range( 55, 61 ) ),
		fragment3 = surface.getLinearFragment( new ve.Range( 55, 61 ) );
	fragment1.wrapNodes(
		[{ type: 'list', attributes: { style: 'bullet' } }, { type: 'listItem' }]
	);
	assert.equalRange(
		fragment2.getSelection().getRange(),
		new ve.Range( 55, 69 ),
		'fragment range changes after wrapNodes'
	);
	surface.undo();
	assert.equalRange(
		fragment3.getSelection().getRange(),
		new ve.Range( 55, 61 ),
		'fragment range restored after undo'
	);

	fragment1 = surface.getLinearFragment( new ve.Range( 1 ) );
	surface.breakpoint();

	fragment1.insertContent( '01' );
	surface.breakpoint();

	fragment1 = fragment1.collapseToEnd();
	fragment1.insertContent( '234' );
	fragment2 = fragment1.clone();

	surface.undo();
	fragment1.insertContent( '5678' );
	assert.equalRange(
		fragment2.getSelection().getRange(),
		new ve.Range( 3, 7 ),
		'Range created during truncated undo point still translates correctly'
	);

} );

QUnit.test( 'adjustLinearSelection', 4, function ( assert ) {
	var doc = ve.dm.example.createExampleDocument(),
		surface = new ve.dm.Surface( doc ),
		fragment = surface.getLinearFragment( new ve.Range( 20, 21 ) ),
		adjustedFragment = fragment.adjustLinearSelection( -19, 35 );
	assert.ok( fragment !== adjustedFragment, 'adjustLinearSelection produces a new fragment' );
	assert.equalRange( fragment.getSelection().getRange(), new ve.Range( 20, 21 ), 'old fragment is not changed' );
	assert.equalRange( adjustedFragment.getSelection().getRange(), new ve.Range( 1, 56 ), 'new range is used' );

	adjustedFragment = fragment.adjustLinearSelection();
	assert.deepEqual( adjustedFragment, fragment, 'fragment is clone if no parameters supplied' );
} );

QUnit.test( 'collapseToStart/End', 6, function ( assert ) {
	var doc = ve.dm.example.createExampleDocument(),
		surface = new ve.dm.Surface( doc ),
		fragment = surface.getLinearFragment( new ve.Range( 20, 21 ) ),
		collapsedFragment = fragment.collapseToStart();
	assert.ok( fragment !== collapsedFragment, 'collapseToStart produces a new fragment' );
	assert.equalRange( fragment.getSelection().getRange(), new ve.Range( 20, 21 ), 'old fragment is not changed' );
	assert.equalRange( collapsedFragment.getSelection().getRange(), new ve.Range( 20 ), 'new range is used' );

	collapsedFragment = fragment.collapseToEnd();
	assert.ok( fragment !== collapsedFragment, 'collapseToEnd produces a new fragment' );
	assert.equalRange( fragment.getSelection().getRange(), new ve.Range( 20, 21 ), 'old fragment is not changed' );
	assert.equalRange( collapsedFragment.getSelection().getRange(), new ve.Range( 21 ), 'range is at end when collapseToEnd is set' );
} );

QUnit.test( 'expandLinearSelection (closest)', 1, function ( assert ) {
	var doc = ve.dm.example.createExampleDocument(),
		surface = new ve.dm.Surface( doc ),
		fragment = surface.getLinearFragment( new ve.Range( 20, 21 ) ),
		expandedFragment = fragment.expandLinearSelection( 'closest', function () {} );

	assert.equalHash(
		expandedFragment.getSelection(),
		new ve.dm.NullSelection( doc ),
		'closest with invalid type results in null fragment'
	);
} );

QUnit.test( 'expandLinearSelection (word)', 1, function ( assert ) {
	var i, doc, surface, fragment, newFragment, range, word, cases = [
		{
			phrase: 'the quick brown fox',
			range: new ve.Range( 6, 13 ),
			expected: 'quick brown',
			msg: 'range starting and ending in latin words'
		},
		{
			phrase: 'the quick brown fox',
			range: new ve.Range( 18, 12 ),
			expected: 'brown fox',
			msg: 'backwards range starting and ending in latin words'
		},
		{
			phrase: 'the quick brown fox',
			range: new ve.Range( 7 ),
			expected: 'quick',
			msg: 'zero-length range'
		}
	];
	QUnit.expect( cases.length * 2 );
	for ( i = 0; i < cases.length; i++ ) {
		doc = new ve.dm.Document( cases[i].phrase.split( '' ) );
		surface = new ve.dm.Surface( doc );
		fragment = surface.getLinearFragment( cases[i].range );
		newFragment = fragment.expandLinearSelection( 'word' );
		range = newFragment.getSelection().getRange();
		word = cases[i].phrase.substring( range.start, range.end );
		assert.strictEqual( word, cases[i].expected, cases[i].msg + ': text' );
		assert.strictEqual( cases[i].range.isBackwards(), range.isBackwards(), cases[i].msg + ': range direction' );
	}
} );

QUnit.test( 'removeContent', 6, function ( assert ) {
	var doc = ve.dm.example.createExampleDocument(),
		originalDoc = ve.dm.example.createExampleDocument(),
		expectedDoc = ve.dm.example.createExampleDocument(),
		surface = new ve.dm.Surface( doc ),
		fragment = surface.getLinearFragment( new ve.Range( 1, 56 ) ),
		expectedData = ve.copy( expectedDoc.data.slice( 0, 1 ) )
			.concat( ve.copy( expectedDoc.data.slice( 4, 5 ) ) )
			.concat( ve.copy( expectedDoc.data.slice( 55 ) ) );
	fragment.removeContent();
	assert.deepEqual(
		doc.getData(),
		expectedData,
		'removing content drops fully covered nodes and strips partially covered ones'
	);
	assert.equalRange(
		fragment.getSelection().getRange(),
		new ve.Range( 1, 3 ),
		'removing content results in a fragment covering just remaining structure'
	);
	surface.undo();
	assert.deepEqual(
		doc.getData(),
		originalDoc.getData(),
		'content restored after undo'
	);
	assert.equalRange(
		fragment.getSelection().getRange(),
		new ve.Range( 1, 56 ),
		'range restored after undo'
	);

	fragment = surface.getLinearFragment( new ve.Range( 1, 4 ) );
	fragment.removeContent();
	assert.deepEqual(
		doc.getData( new ve.Range( 0, 2 ) ),
		[
			{ type: 'heading', attributes: { level: 1 } },
			{ type: '/heading' }
		],
		'removing content empties node'
	);
	assert.equalRange(
		fragment.getSelection().getRange(),
		new ve.Range( 1 ),
		'removing content collapses range'
	);
} );

ve.test.utils.runSurfaceFragmentDeleteTest = function ( assert, html, range, directionAfterRemove, expectedData, expectedRange, msg ) {
	var data, doc, surface, fragment;

	if ( html ) {
		doc = new ve.dm.Document(
			ve.dm.converter.getModelFromDom( ve.createDocumentFromHtml( html ) )
		);
	} else {
		doc = ve.dm.example.createExampleDocument();
	}
	surface = new ve.dm.Surface( doc );
	fragment = surface.getLinearFragment( range );

	data = ve.copy( fragment.getDocument().getFullData() );
	expectedData( data );

	fragment.delete( directionAfterRemove );

	assert.deepEqualWithDomElements( fragment.getDocument().getFullData(), data, msg + ': data' );
	assert.equalRange( fragment.getSelection().getRange(), expectedRange, msg + ': range' );
};

QUnit.test( 'delete', function ( assert ) {
	var i,
		cases = [
			{
				range: new ve.Range( 1, 4 ),
				directionAfterRemove: -1,
				expectedData: function ( data ) {
					data.splice( 1, 3 );
				},
				expectedRange: new ve.Range( 1 ),
				msg: 'Selection deleted by backspace'
			},
			{
				range: new ve.Range( 1, 4 ),
				directionAfterRemove: 1,
				expectedData: function ( data ) {
					data.splice( 1, 3 );
				},
				expectedRange: new ve.Range( 1 ),
				msg: 'Selection deleted by delete'
			},
			{
				range: new ve.Range( 39, 41 ),
				directionAfterRemove: 1,
				expectedData: function ( data ) {
					data.splice( 39, 2 );
				},
				expectedRange: new ve.Range( 39 ),
				msg: 'Focusable node deleted if selected first'
			},
			{
				range: new ve.Range( 39, 41 ),
				expectedData: function ( data ) {
					data.splice( 39, 2 );
				},
				expectedRange: new ve.Range( 39 ),
				msg: 'Focusable node deleted by cut'
			},
			{
				range: new ve.Range( 0, 63 ),
				directionAfterRemove: -1,
				expectedData: function ( data ) {
					data.splice( 0, 61,
							{ type: 'paragraph' },
							{ type: '/paragraph' }
						);
				},
				expectedRange: new ve.Range( 1 ),
				msg: 'Backspace after select all spanning entire document creates empty paragraph'
			}
		];

	QUnit.expect( cases.length * 2 );

	for ( i = 0; i < cases.length; i++ ) {
		ve.test.utils.runSurfaceFragmentDeleteTest(
			assert, cases[i].html, cases[i].range, cases[i].directionAfterRemove,
			cases[i].expectedData, cases[i].expectedRange, cases[i].msg
		);
	}
} );

QUnit.test( 'insertContent', 8, function ( assert ) {
	var doc = ve.dm.example.createExampleDocument(),
		surface = new ve.dm.Surface( doc ),
		fragment = surface.getLinearFragment( new ve.Range( 1, 4 ) );
	fragment.insertContent( ['1', '2', '3'] );
	assert.deepEqual(
		doc.getData( new ve.Range( 1, 4 ) ),
		['1', '2', '3'],
		'inserting content replaces selection with new content'
	);
	assert.equalRange(
		fragment.getSelection().getRange(),
		new ve.Range( 1, 4 ),
		'inserting content results in range around content'
	);

	surface.breakpoint();
	fragment = surface.getLinearFragment( new ve.Range( 4 ) );
	fragment.insertContent( '321' );
	assert.deepEqual(
		doc.getData( new ve.Range( 4, 7 ) ),
		['3', '2', '1'],
		'strings get converted into data when inserting content'
	);

	surface.undo();
	assert.equalRange(
		fragment.getSelection().getRange(),
		new ve.Range( 4 ),
		'range restored after undo'
	);

	fragment = surface.getLinearFragment( new ve.Range( 1 ) );
	fragment.insertContent( [ { type: 'table' }, { type: '/table' } ] );
	assert.deepEqual(
		doc.getData( new ve.Range( 0, 2 ) ),
		[ { type: 'table' }, { type: '/table' } ],
		'table insertion at start of heading is moved outside of heading'
	);
	assert.equalRange(
		fragment.getSelection().getRange(),
		new ve.Range( 0, 2 ),
		'range covers inserted content in moved position (left)'
	);

	// Set up document and surface from scratch
	doc = ve.dm.example.createExampleDocument();
	surface = new ve.dm.Surface( doc );

	fragment = surface.getLinearFragment( new ve.Range( 4 ) );
	fragment.insertContent( [ { type: 'list' }, { type: '/list' } ] );
	assert.deepEqual(
		doc.getData( new ve.Range( 5, 7 ) ),
		[ { type: 'list' }, { type: '/list' } ],
		'list insertion at end of heading is moved outside of heading'
	);
	assert.equalRange(
		fragment.getSelection().getRange(),
		new ve.Range( 5, 7 ),
		'range covers inserted content in moved position (right)'
	);
} );

QUnit.test( 'changeAttributes', 1, function ( assert ) {
	var doc = ve.dm.example.createExampleDocument(),
		surface = new ve.dm.Surface( doc ),
		fragment = surface.getLinearFragment( new ve.Range( 0, 5 ) );
	fragment.changeAttributes( { level: 3 } );
	assert.deepEqual(
		doc.getData( new ve.Range( 0, 1 ) ),
		[ { type: 'heading', attributes: { level: 3 } } ],
		'changing attributes affects covered nodes'
	);
} );

QUnit.test( 'wrapNodes/unwrapNodes', 10, function ( assert ) {
	var doc = ve.dm.example.createExampleDocument(),
		originalDoc = ve.dm.example.createExampleDocument(),
		surface = new ve.dm.Surface( doc ),
		fragment = surface.getLinearFragment( new ve.Range( 55, 61 ) );

	// Make 2 paragraphs into 2 lists of 1 item each
	fragment.wrapNodes(
		[{ type: 'list', attributes: { style: 'bullet' } }, { type: 'listItem' }]
	);
	assert.deepEqual(
		doc.getData( new ve.Range( 55, 69 ) ),
		[
			{
				type: 'list',
				attributes: { style: 'bullet' }
			},
			{ type: 'listItem' },
			{ type: 'paragraph' },
			'l',
			{ type: '/paragraph' },
			{ type: '/listItem' },
			{ type: '/list' },
			{
				type: 'list',
				attributes: { style: 'bullet' }
			},
			{ type: 'listItem' },
			{ type: 'paragraph' },
			'm',
			{ type: '/paragraph' },
			{ type: '/listItem' },
			{ type: '/list' }
		],
		'wrapping nodes can add multiple levels of wrapping to multiple elements'
	);
	assert.equalRange( fragment.getSelection().getRange(), new ve.Range( 55, 69 ), 'new range contains wrapping elements' );

	fragment.unwrapNodes( 0, 2 );
	assert.deepEqual( doc.getData(), originalDoc.getData(), 'unwrapping 2 levels restores document to original state' );
	assert.equalRange( fragment.getSelection().getRange(), new ve.Range( 55, 61 ), 'range after unwrapping is same as original range' );

	// Make a 1 paragraph into 1 list with 1 item
	fragment = surface.getLinearFragment( new ve.Range( 9, 12 ) );
	fragment.wrapNodes(
		[{ type: 'list', attributes: { style: 'bullet' } }, { type: 'listItem' }]
	);
	assert.deepEqual(
		doc.getData( new ve.Range( 9, 16 ) ),
		[
			{
				type: 'list',
				attributes: { style: 'bullet' }
			},
			{ type: 'listItem' },
			{ type: 'paragraph' },
			'd',
			{ type: '/paragraph' },
			{ type: '/listItem' },
			{ type: '/list' }
		],
		'wrapping nodes can add multiple levels of wrapping to a single element'
	);
	assert.equalRange( fragment.getSelection().getRange(), new ve.Range( 9, 16 ), 'new range contains wrapping elements' );

	fragment.unwrapNodes( 0, 2 );
	assert.deepEqual( doc.getData(), originalDoc.getData(), 'unwrapping 2 levels restores document to original state' );
	assert.equalRange( fragment.getSelection().getRange(), new ve.Range( 9, 12 ), 'range after unwrapping is same as original range' );

	fragment = surface.getLinearFragment( new ve.Range( 8, 34 ) );
	fragment.unwrapNodes( 3, 1 );
	assert.deepEqual( fragment.getData(), doc.getData( new ve.Range( 5, 29 ) ), 'unwrapping multiple outer nodes and an inner node' );
	assert.equalRange( fragment.getSelection().getRange(), new ve.Range( 5, 29 ), 'new range contains inner elements' );
} );

QUnit.test( 'rewrapNodes', 4, function ( assert ) {
	var doc = ve.dm.example.createExampleDocument(),
		surface = new ve.dm.Surface( doc ),
		fragment = surface.getLinearFragment( new ve.Range( 43, 55 ) ),
		expectedDoc = ve.dm.example.createExampleDocument(),
		expectedSurface = new ve.dm.Surface( expectedDoc ),
		expectedFragment = expectedSurface.getLinearFragment( new ve.Range( 43, 55 ) ),
		expectedData;

	// set up wrapped nodes in example document
	fragment.wrapNodes(
		[{ type: 'list', attributes: { style: 'bullet' } }, { type: 'listItem' }]
	);
	expectedFragment.wrapNodes(
		[{ type: 'list', attributes: { style: 'bullet' } }, { type: 'listItem' }]
	);
	// range is now 43, 59

	// Compare a rewrap operation with its equivalent unwrap + wrap
	// This type of test can only exist if the intermediate state is valid
	fragment.rewrapNodes(
		2,
		[{ type: 'definitionList' }, { type: 'definitionListItem', attributes: { style: 'term' } }]
	);
	expectedFragment.unwrapNodes( 0, 2 );
	expectedFragment.wrapNodes(
		[{ type: 'definitionList' }, { type: 'definitionListItem', attributes: { style: 'term' } }]
	);

	assert.deepEqual(
		doc.getData(),
		expectedDoc.getData(),
		'rewrapping multiple nodes via a valid intermediate state produces the same document as unwrapping then wrapping'
	);
	assert.equalHash( fragment.getSelection(), expectedFragment.getSelection(), 'new range contains rewrapping elements' );

	// Rewrap paragrphs as headings
	// The intermediate stage (plain text attached to the document) would be invalid
	// if performed as an unwrap and a wrap
	expectedData = ve.copy( doc.getData() );

	fragment = surface.getLinearFragment( new ve.Range( 59, 65 ) );
	fragment.rewrapNodes( 1, [ { type: 'heading', attributes: { level: 1 } } ] );

	expectedData.splice( 59, 1, { type: 'heading', attributes: { level: 1 } } );
	expectedData.splice( 61, 1, { type: '/heading' } );
	expectedData.splice( 62, 1, { type: 'heading', attributes: { level: 1 } } );
	expectedData.splice( 64, 1, { type: '/heading' } );

	assert.deepEqual( doc.getData(), expectedData, 'rewrapping paragraphs as headings' );
	assert.equalRange( fragment.getSelection().getRange(), new ve.Range( 59, 65 ), 'new range contains rewrapping elements' );
} );

QUnit.test( 'wrapAllNodes', 10, function ( assert ) {
	var doc = ve.dm.example.createExampleDocument(),
		originalDoc = ve.dm.example.createExampleDocument(),
		surface = new ve.dm.Surface( doc ),
		fragment = surface.getLinearFragment( new ve.Range( 55, 61 ) ),
		expectedData = ve.copy( doc.getData() );

	// Make 2 paragraphs into 1 lists of 1 item with 2 paragraphs
	fragment.wrapAllNodes(
		[{ type: 'list', attributes: { style: 'bullet' } }, { type: 'listItem' }]
	);
	assert.deepEqual(
		doc.getData( new ve.Range( 55, 65 ) ),
		[
			{
				type: 'list',
				attributes: { style: 'bullet' }
			},
			{ type: 'listItem' },
			{ type: 'paragraph' },
			'l',
			{ type: '/paragraph' },
			{ type: 'paragraph' },
			'm',
			{ type: '/paragraph' },
			{ type: '/listItem' },
			{ type: '/list' }
		],
		'wrapping nodes can add multiple levels of wrapping to multiple elements'
	);
	assert.equalRange( fragment.getSelection().getRange(), new ve.Range( 55, 65 ), 'new range contains wrapping elements' );

	fragment.unwrapNodes( 0, 2 );
	assert.deepEqual( doc.getData(), originalDoc.getData(), 'unwrapping 2 levels restores document to original state' );
	assert.equalRange( fragment.getSelection().getRange(), new ve.Range( 55, 61 ), 'range after unwrapping is same as original range' );

	// Make a 1 paragraph into 1 list with 1 item
	fragment = surface.getLinearFragment( new ve.Range( 9, 12 ) );
	fragment.wrapAllNodes(
		[{ type: 'list', attributes: { style: 'bullet' } }, { type: 'listItem' }]
	);
	assert.deepEqual(
		doc.getData( new ve.Range( 9, 16 ) ),
		[
			{
				type: 'list',
				attributes: { style: 'bullet' }
			},
			{ type: 'listItem' },
			{ type: 'paragraph' },
			'd',
			{ type: '/paragraph' },
			{ type: '/listItem' },
			{ type: '/list' }
		],
		'wrapping nodes can add multiple levels of wrapping to a single element'
	);
	assert.equalRange( fragment.getSelection().getRange(), new ve.Range( 9, 16 ), 'new range contains wrapping elements' );

	fragment.unwrapNodes( 0, 2 );
	assert.deepEqual( doc.getData(), originalDoc.getData(), 'unwrapping 2 levels restores document to original state' );
	assert.equalRange( fragment.getSelection().getRange(), new ve.Range( 9, 12 ), 'range after unwrapping is same as original range' );

	fragment = surface.getLinearFragment( new ve.Range( 5, 37 ) );

	assert.throws( function () {
		fragment.unwrapNodes( 0, 20 );
	}, /cannot unwrap by greater depth/, 'error thrown trying to unwrap more nodes that it is possible to contain' );

	expectedData.splice( 5, 4 );
	expectedData.splice( 29, 4 );
	fragment.unwrapNodes( 0, 4 );
	assert.deepEqual(
		doc.getData(),
		expectedData,
		'unwrapping 4 levels (table, tableSection, tableRow and tableCell)'
	);
} );

QUnit.test( 'rewrapAllNodes', 6, function ( assert ) {
	var expectedData,
		doc = ve.dm.example.createExampleDocument(),
		originalDoc = ve.dm.example.createExampleDocument(),
		surface = new ve.dm.Surface( doc ),
		fragment = surface.getLinearFragment( new ve.Range( 5, 37 ) ),
		expectedDoc = ve.dm.example.createExampleDocument(),
		expectedSurface = new ve.dm.Surface( expectedDoc ),
		expectedFragment = expectedSurface.getLinearFragment( new ve.Range( 5, 37 ) );

	// Compare a rewrap operation with its equivalent unwrap + wrap
	// This type of test can only exist if the intermediate state is valid
	fragment.rewrapAllNodes(
		4,
		[{ type: 'list', attributes: { style: 'bullet' } }, { type: 'listItem' }]
	);
	expectedFragment.unwrapNodes( 0, 4 );
	expectedFragment.wrapAllNodes(
		[{ type: 'list', attributes: { style: 'bullet' } }, { type: 'listItem' }]
	);
	assert.deepEqual(
		doc.getData(),
		expectedDoc.getData(),
		'rewrapping multiple nodes via a valid intermediate state produces the same document as unwrapping then wrapping'
	);
	assert.equalHash( fragment.getSelection(), expectedFragment.getSelection(), 'new range contains rewrapping elements' );

	// Reverse of first test
	fragment.rewrapAllNodes(
		2,
		[
			{ type: 'table' },
			{ type: 'tableSection', attributes: { style: 'body' } },
			{ type: 'tableRow' },
			{ type: 'tableCell', attributes: { style: 'data' } }
		]
	);

	expectedData = originalDoc.getData();
	assert.deepEqual(
		doc.getData(),
		expectedData,
		'rewrapping multiple nodes via a valid intermediate state produces the same document as unwrapping then wrapping'
	);
	assert.equalRange( fragment.getSelection().getRange(), new ve.Range( 5, 37 ), 'new range contains rewrapping elements' );

	// Rewrap a heading as a paragraph
	// The intermediate stage (plain text attached to the document) would be invalid
	// if performed as an unwrap and a wrap
	fragment = surface.getLinearFragment( new ve.Range( 0, 5 ) );
	fragment.rewrapAllNodes( 1, [ { type: 'paragraph' } ] );

	expectedData.splice( 0, 1, { type: 'paragraph' } );
	expectedData.splice( 4, 1, { type: '/paragraph' } );

	assert.deepEqual( doc.getData(), expectedData, 'rewrapping a heading as a paragraph' );
	assert.equalRange( fragment.getSelection().getRange(), new ve.Range( 0, 5 ), 'new range contains rewrapping elements' );
} );

QUnit.test( 'isolateAndUnwrap', 1, function ( assert ) {
	ve.test.utils.runIsolateTest( assert, 'heading', new ve.Range( 12, 20 ), function ( data ) {
		data.splice( 11, 0, { type: 'listItem' } );
		data.splice( 12, 1 );
		data.splice( 20, 1, { type: '/listItem' } );
	}, 'isolating paragraph in list item "Item 2" for heading' );
} );
