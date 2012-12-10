/**
 * VisualEditor data model SurfaceFragment tests.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.dm.SurfaceFragment' );

// Tests

QUnit.test( 'constructor', 8, function ( assert ) {
	var doc = new ve.dm.Document( ve.copyArray( ve.dm.example.data ) ),
		surface = new ve.dm.Surface( doc ),
		fragment = new ve.dm.SurfaceFragment( surface );
	// Default range and autoSelect
	assert.strictEqual( fragment.getSurface(), surface, 'surface reference is stored' );
	assert.strictEqual( fragment.getDocument(), doc, 'document reference is stored' );
	assert.deepEqual( fragment.getRange(), new ve.Range( 0, 0 ), 'range is taken from surface' );
	assert.strictEqual( fragment.willAutoSelect(), true, 'auto select by default' );
	assert.strictEqual( fragment.isNull(), false, 'valid fragment is not null' );
	// Invalid range and autoSelect
	fragment = new ve.dm.SurfaceFragment( surface, new ve.Range( -100, 100 ), 'truthy' );
	assert.equal( fragment.getRange().from, 0, 'range is clamped between 0 and document length' );
	assert.equal( fragment.getRange().to, 61, 'range is clamped between 0 and document length' );
	assert.strictEqual( fragment.willAutoSelect(), false, 'noAutoSelect values are boolean' );
} );

QUnit.test( 'onTransact', 1, function ( assert ) {
	var doc = new ve.dm.Document( ve.copyArray( ve.dm.example.data ) ),
		surface = new ve.dm.Surface( doc ),
		fragment1 = new ve.dm.SurfaceFragment( surface, new ve.Range( 1, 56 ) ),
		fragment2 = new ve.dm.SurfaceFragment( surface, new ve.Range( 2, 4 ) );
	fragment1.removeContent();
	assert.deepEqual(
		fragment2.getRange(),
		new ve.Range( 1, 1 ),
		'fragment ranges are auto-translated when transactions are processed'
	);
} );

QUnit.test( 'adjustRange', 3, function ( assert ) {
	var doc = new ve.dm.Document( ve.copyArray( ve.dm.example.data ) ),
		surface = new ve.dm.Surface( doc ),
		fragment = new ve.dm.SurfaceFragment( surface, new ve.Range( 20, 21 ) ),
		adjustedFragment = fragment.adjustRange( -19, 35 );
	assert.ok( fragment !== adjustedFragment, 'adjustRange produces a new fragment' );
	assert.deepEqual( fragment.getRange(), new ve.Range( 20, 21 ), 'old fragment is not changed' );
	assert.deepEqual( adjustedFragment.getRange(), new ve.Range( 1, 56 ), 'new range is used' );
} );

QUnit.test( 'collapseRange', 3, function ( assert ) {
	var doc = new ve.dm.Document( ve.copyArray( ve.dm.example.data ) ),
		surface = new ve.dm.Surface( doc ),
		fragment = new ve.dm.SurfaceFragment( surface, new ve.Range( 20, 21 ) ),
		collapsedFragment = fragment.collapseRange();
	assert.ok( fragment !== collapsedFragment, 'collapseRange produces a new fragment' );
	assert.deepEqual( fragment.getRange(), new ve.Range( 20, 21 ), 'old fragment is not changed' );
	assert.deepEqual( collapsedFragment.getRange(), new ve.Range( 20, 20 ), 'new range is used' );
} );

QUnit.test( 'expandRange', 1, function ( assert ) {
	var doc = new ve.dm.Document( ve.copyArray( ve.dm.example.data ) ),
		surface = new ve.dm.Surface( doc ),
		fragment = new ve.dm.SurfaceFragment( surface, new ve.Range( 20, 21 ) );
	assert.strictEqual(
		fragment.expandRange( 'closest', 'invalid type' ).isNull(),
		true,
		'closest with invalid type results in null fragment'
	);
} );

QUnit.test( 'removeContent', 2, function ( assert ) {
	var doc = new ve.dm.Document( ve.copyArray( ve.dm.example.data ) ),
		surface = new ve.dm.Surface( doc ),
		fragment = new ve.dm.SurfaceFragment( surface, new ve.Range( 1, 56 ) ),
		expectedData = ve.copyArray( ve.dm.example.data.slice( 0, 1 ) )
			.concat( ve.copyArray( ve.dm.example.data.slice( 4, 5 ) ) )
			.concat( ve.copyArray( ve.dm.example.data.slice( 55 ) ) );
	ve.setProp( expectedData[0], 'internal', 'changed', 'content', 1 );
	fragment.removeContent();
	assert.deepEqual(
		doc.getData(),
		expectedData,
		'removing content drops fully covered nodes and strips partially covered ones'
	);
	assert.deepEqual(
		fragment.getRange(),
		new ve.Range( 1, 1 ),
		'removing content results in a zero-length fragment'
	);
} );

QUnit.test( 'insertContent', 3, function ( assert ) {
	var doc = new ve.dm.Document( ve.copyArray( ve.dm.example.data ) ),
		surface = new ve.dm.Surface( doc ),
		fragment = new ve.dm.SurfaceFragment( surface, new ve.Range( 1, 4 ) );
	fragment.insertContent( ['1', '2', '3'] );
	assert.deepEqual(
		doc.getData( new ve.Range( 1, 4 ) ),
		['1', '2', '3'],
		'inserting content replaces selection with new content'
	);
	assert.deepEqual(
		fragment.getRange(),
		new ve.Range( 4, 4 ),
		'inserting content results in a zero-length fragment'
	);
	fragment.insertContent( '321' );
	assert.deepEqual(
		doc.getData( new ve.Range( 4, 7 ) ),
		['3', '2', '1'],
		'strings get converted into data when inserting content'
	);
} );

QUnit.test( 'wrapNodes', 2, function ( assert ) {
	var doc = new ve.dm.Document( ve.copyArray( ve.dm.example.data ) ),
		surface = new ve.dm.Surface( doc ),
		fragment = new ve.dm.SurfaceFragment( surface, new ve.Range( 55, 61 ) );
	// Make 2 paragraphs into 2 lists of 1 item each
	fragment.wrapNodes(
		[{ 'type': 'list', 'attributes': { 'style': 'bullet' } }, { 'type': 'listItem' }]
	);
	assert.deepEqual(
		doc.getData( new ve.Range( 55, 69 ) ),
		[
			{
				'type': 'list',
				'attributes': { 'style': 'bullet' },
				'internal': { 'changed': { 'created': 1 } }
			},
			{ 'type': 'listItem', 'internal': { 'changed': { 'created': 1 } } },
			{ 'type': 'paragraph' },
			'l',
			{ 'type': '/paragraph' },
			{ 'type': '/listItem' },
			{ 'type': '/list' },
			{
				'type': 'list',
				'attributes': { 'style': 'bullet' },
				'internal': { 'changed': { 'created': 1 } }
			},
			{ 'type': 'listItem', 'internal': { 'changed': { 'created': 1 } } },
			{ 'type': 'paragraph' },
			'm',
			{ 'type': '/paragraph' },
			{ 'type': '/listItem' },
			{ 'type': '/list' }
		],
		'wrapping nodes can add multiple levels of wrapping to multiple elements'
	);
	// Make a 1 paragraph into 1 list with 1 item
	fragment = new ve.dm.SurfaceFragment( surface, new ve.Range( 9, 12 ) );
	fragment.wrapNodes(
		[{ 'type': 'list', 'attributes': { 'style': 'bullet' } }, { 'type': 'listItem' }]
	);
	assert.deepEqual(
		doc.getData( new ve.Range( 9, 16 ) ),
		[
			{
				'type': 'list',
				'attributes': { 'style': 'bullet' },
				'internal': { 'changed': { 'created': 1 } }
			},
			{ 'type': 'listItem', 'internal': { 'changed': { 'created': 1 } } },
			{ 'type': 'paragraph' },
			'd',
			{ 'type': '/paragraph' },
			{ 'type': '/listItem' },
			{ 'type': '/list' }
		],
		'wrapping nodes can add multiple levels of wrapping to a single element'
	);
} );

QUnit.test( 'wrapAllNodes', 2, function ( assert ) {
	var doc = new ve.dm.Document( ve.copyArray( ve.dm.example.data ) ),
		surface = new ve.dm.Surface( doc ),
		fragment = new ve.dm.SurfaceFragment( surface, new ve.Range( 55, 61 ) );
	// Make 2 paragraphs into 1 lists of 1 item with 2 paragraphs
	fragment.wrapAllNodes(
		[{ 'type': 'list', 'attributes': { 'style': 'bullet' } }, { 'type': 'listItem' }]
	);
	assert.deepEqual(
		doc.getData( new ve.Range( 55, 65 ) ),
		[
			{
				'type': 'list',
				'attributes': { 'style': 'bullet' },
				'internal': { 'changed': { 'created': 1 } }
			},
			{ 'type': 'listItem', 'internal': { 'changed': { 'created': 1 } } },
			{ 'type': 'paragraph' },
			'l',
			{ 'type': '/paragraph' },
			{ 'type': 'paragraph' },
			'm',
			{ 'type': '/paragraph' },
			{ 'type': '/listItem' },
			{ 'type': '/list' }
		],
		'wrapping nodes can add multiple levels of wrapping to multiple elements'
	);
	// Make a 1 paragraph into 1 list with 1 item
	fragment = new ve.dm.SurfaceFragment( surface, new ve.Range( 9, 12 ) );
	fragment.wrapAllNodes(
		[{ 'type': 'list', 'attributes': { 'style': 'bullet' } }, { 'type': 'listItem' }]
	);
	assert.deepEqual(
		doc.getData( new ve.Range( 9, 16 ) ),
		[
			{
				'type': 'list',
				'attributes': { 'style': 'bullet' },
				'internal': { 'changed': { 'created': 1 } }
			},
			{ 'type': 'listItem', 'internal': { 'changed': { 'created': 1 } } },
			{ 'type': 'paragraph' },
			'd',
			{ 'type': '/paragraph' },
			{ 'type': '/listItem' },
			{ 'type': '/list' }
		],
		'wrapping nodes can add multiple levels of wrapping to a single element'
	);
} );
