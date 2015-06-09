/*!
 * VisualEditor FlatLinearData tests.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

QUnit.module( 've.dm.FlatLinearData' );

/* Tests */

QUnit.test( 'getType/isOpenElementData/isCloseElementData', function ( assert ) {
	var i,
		data = new ve.dm.FlatLinearData( new ve.dm.IndexValueStore(), [
			{ type: 'paragraph' },
			'a', ['b', [0]],
			{ type: '/paragraph' }
		] ),
		types = ['paragraph', undefined, undefined, 'paragraph'],
		isOpen = [0],
		isClose = [3];

	QUnit.expect( data.getLength() * 3 );
	for ( i = 0; i < data.getLength(); i++ ) {
		assert.strictEqual( data.getType( i ), types[i], 'Type at offset ' + i );
		assert.strictEqual( data.isOpenElementData( i ), ve.indexOf( i, isOpen ) !== -1, 'isOpen ' + i );
		assert.strictEqual( data.isCloseElementData( i ), ve.indexOf( i, isClose ) !== -1, 'isClose ' + i );
	}
} );

QUnit.test( 'isElementData', 1, function ( assert ) {
	var i,
		data = new ve.dm.FlatLinearData( new ve.dm.IndexValueStore(), [
			{ type: 'heading' },
			'a',
			{ type: 'inlineImage' },
			{ type: '/inlineImage' },
			'b',
			'c',
			{ type: '/heading' },
			{ type: 'paragraph' },
			{ type: '/paragraph' },
			{ type: 'preformatted' },
			{ type: 'inlineImage' },
			{ type: '/inlineImage' },
			{ type: '/preformatted' },
			{ type: 'list' },
			{ type: 'listItem' },
			{ type: '/listItem' },
			{ type: '/list' },
			{ type: 'alienBlock' },
			{ type: '/alienBlock' }
		] ),
		cases = [
			{ msg: 'left of document', expected: true },
			{ msg: 'begining of content branch', expected: false },
			{ msg: 'left of non-text inline leaf', expected: true },
			{ msg: 'inside non-text inline leaf', expected: true },
			{ msg: 'right of non-text inline leaf', expected: false },
			{ msg: 'between characters', expected: false },
			{ msg: 'end of content branch', expected: true },
			{ msg: 'between content branches', expected: true },
			{ msg: 'inside emtpy content branch', expected: true },
			{ msg: 'between content branches', expected: true },
			{ msg: 'begining of content branch, left of inline leaf', expected: true },
			{ msg: 'inside content branch with non-text leaf', expected: true },
			{ msg: 'end of content branch, right of inline leaf', expected: true },
			{ msg: 'between content, non-content branches', expected: true },
			{ msg: 'between parent, child branches, descending', expected: true },
			{ msg: 'inside empty non-content branch', expected: true },
			{ msg: 'between parent, child branches, ascending', expected: true },
			{ msg: 'between non-content branch, non-content leaf', expected: true },
			{ msg: 'inside non-content leaf', expected: true },
			{ msg: 'right of document', expected: false }
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
				msg: 'simple paragraph',
				data: [{ type: 'paragraph' }, 'a', { type: '/paragraph' }],
				expected: true
			},
			{
				msg: 'plain text',
				data: ['a', 'b', 'c'],
				expected: false
			},
			{
				msg: 'annotated text',
				data: [['a', { '{"type:"bold"}': { type: 'bold' } } ]],
				expected: false
			},
			{
				msg: 'non-text leaf',
				data: ['a', { type: 'inlineImage' }, { type: '/inlineImage' }, 'c'],
				expected: true
			}
		];
	QUnit.expect( cases.length );
	for ( i = 0; i < cases.length; i++ ) {
		data = new ve.dm.FlatLinearData( new ve.dm.IndexValueStore(), cases[i].data );
		assert.strictEqual(
			data.containsElementData(), cases[i].expected, cases[i].msg
		);
	}
} );
