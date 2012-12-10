/**
 * VisualEditor content editable TextNode tests.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.ce.TextNode' );

/* Tests */

QUnit.test( 'getHtml', function ( assert ) {
	var i, len, cases;

	cases = [
		{
			'data': [
				{ 'type': 'paragraph' },
				'a',
				'b',
				'c',
				{ 'type': '/paragraph' }
			],
			'html': 'abc'
		},
		{
			'data': [
				{ 'type': 'paragraph' },
				['a', [ { 'type': 'textStyle/bold' } ]],
				['b', [ { 'type': 'textStyle/bold' } ]],
				['c', [ { 'type': 'textStyle/bold' } ]],
				{ 'type': '/paragraph' }
			],
			'html': '<b>abc</b>'
		},
		{
			'data': [
				{ 'type': 'paragraph' },
				['a', [ { 'type': 'textStyle/bold' } ]],
				'b',
				['c', [ { 'type': 'textStyle/italic' } ]],
				{ 'type': '/paragraph' }
			],
			'html': '<b>a</b>b<i>c</i>'
		},
		{
			'data': [
				{ 'type': 'paragraph' },
				['a', [
					{ 'type': 'textStyle/bold' },
					{ 'type': 'textStyle/italic' },
					{ 'type': 'textStyle/underline' }
				]],
				['b', [
					{ 'type': 'textStyle/bold' },
					{ 'type': 'textStyle/italic' },
					{ 'type': 'textStyle/underline' }
				]],
				['c', [
					{ 'type': 'textStyle/bold' },
					{ 'type': 'textStyle/italic' },
					{ 'type': 'textStyle/underline' }
				]],
				{ 'type': '/paragraph' }
			],
			'html': '<b><i><u>abc</u></i></b>'
		},
		{
			'data': [
				{ 'type': 'paragraph' },
				['a', [
					{ 'type': 'textStyle/bold' },
					{ 'type': 'textStyle/italic' },
					{ 'type': 'textStyle/underline' }
				]],
				['b', [
					{ 'type': 'textStyle/italic' },
					{ 'type': 'textStyle/underline' },
					{ 'type': 'textStyle/bold' }
				]],
				['c', [
					{ 'type': 'textStyle/underline' },
					{ 'type': 'textStyle/bold' },
					{ 'type': 'textStyle/italic' }
				]],
				{ 'type': '/paragraph' }
			],
			'html': '<b><i><u>abc</u></i></b>'
		},
		{
			'data': [
				{ 'type': 'paragraph' },
				['a', [
					{ 'type': 'textStyle/bold' },
					{ 'type': 'textStyle/italic' },
					{ 'type': 'textStyle/underline' }
				]],
				'b',
				['c', [
					{ 'type': 'textStyle/underline' },
					{ 'type': 'textStyle/bold' },
					{ 'type': 'textStyle/italic' }
				]],
				{ 'type': '/paragraph' }
			],
			'html': '<b><i><u>a</u></i></b>b<u><b><i>c</i></b></u>'
		},
		{
			'data': [
				{ 'type': 'paragraph' },
				'a',
				'b',
				'c',
				['d', [
					{ 'type': 'textStyle/bold' },
					{ 'type': 'textStyle/italic' },
					{ 'type': 'textStyle/underline' }
				]],
				['e', [
					{ 'type': 'textStyle/italic' },
					{ 'type': 'textStyle/underline' },
					{ 'type': 'textStyle/bold' }
				]],
				['f', [
					{ 'type': 'textStyle/underline' },
					{ 'type': 'textStyle/bold' },
					{ 'type': 'textStyle/italic' }
				]],
				'g',
				'h',
				'i',
				{ 'type': '/paragraph' }
			],
			'html': 'abc<b><i><u>def</u></i></b>ghi'
		},
		{
			'data': [
				{ 'type': 'paragraph' },
				'a',
				'b',
				'c',
				['d', [
					{ 'type': 'textStyle/bold' },
					{ 'type': 'textStyle/italic' },
					{ 'type': 'textStyle/underline' }
				]],
				['e', [
					{ 'type': 'textStyle/italic' },
					{ 'type': 'textStyle/underline' }
				]],
				['f', [
					{ 'type': 'textStyle/underline' },
					{ 'type': 'textStyle/bold' },
					{ 'type': 'textStyle/italic' }
				]],
				'g',
				'h',
				'i',
				{ 'type': '/paragraph' }
			],
			'html': 'abc<b><i><u>d</u></i></b><i><u>e<b>f</b></u></i>ghi'
		},
		{
			'data': [
				{ 'type': 'paragraph' },
				'a',
				'b',
				'c',
				['d', [
					{ 'type': 'textStyle/italic' },
					{ 'type': 'textStyle/underline' },
					{ 'type': 'textStyle/bold' }
				]],
				['e', [
					{ 'type': 'textStyle/italic' },
					{ 'type': 'textStyle/underline' }
				]],
				['f', [
					{ 'type': 'textStyle/underline' },
					{ 'type': 'textStyle/bold' },
					{ 'type': 'textStyle/italic' }
				]],
				'g',
				'h',
				'i',
				{ 'type': '/paragraph' }
			],
			'html': 'abc<i><u><b>d</b>e<b>f</b></u></i>ghi'
		},
		{
			'data': [
				{ 'type': 'paragraph' },
				'a',
				'b',
				'c',
				['d', [
					{ 'type': 'textStyle/italic' },
					{ 'type': 'textStyle/underline' },
					{ 'type': 'textStyle/bold' }
				]],
				['e', [
					{ 'type': 'textStyle/bold' },
					{ 'type': 'textStyle/underline' }
				]],
				['f', [
					{ 'type': 'textStyle/underline' },
					{ 'type': 'textStyle/bold' }
				]],
				'g',
				'h',
				'i',
				{ 'type': '/paragraph' }
			],
			'html': 'abc<i><u><b>d</b></u></i><u><b>ef</b></u>ghi'
		},
		{
			// [ ]
			'data': [{ 'type': 'paragraph' },{ 'type': '/paragraph' }],
			'html': ''
		},
		{
			// [ ]
			'data': [{ 'type': 'paragraph' },' ',{ 'type': '/paragraph' }],
			'html': '&nbsp;'
		},
		{
			// [ ][ ]
			'data': [{ 'type': 'paragraph' },' ', ' ',{ 'type': '/paragraph' }],
			'html': '&nbsp;&nbsp;'
		},
		{
			// [ ][ ][ ]
			'data': [{ 'type': 'paragraph' },' ', ' ', ' ',{ 'type': '/paragraph' }],
			'html': '&nbsp; &nbsp;'
		},
		{
			// [ ][ ][ ][ ]
			'data': [{ 'type': 'paragraph' },' ', ' ', ' ', ' ',{ 'type': '/paragraph' }],
			'html': '&nbsp; &nbsp;&nbsp;'
		},
		{
			// [ ][ ][ ][ ][ ]
			'data': [{ 'type': 'paragraph' },' ', ' ', ' ', ' ', ' ',{ 'type': '/paragraph' }],
			'html': '&nbsp; &nbsp; &nbsp;'
		},
		{
			// [ ][ ][ ][ ][ ][ ]
			'data': [{ 'type': 'paragraph' },' ', ' ', ' ', ' ', ' ', ' ',{ 'type': '/paragraph' }],
			'html': '&nbsp; &nbsp; &nbsp;&nbsp;'
		},
		{
			// [ ][A][ ][ ][ ][ ]
			'data': [{ 'type': 'paragraph' },' ', 'A', ' ', ' ', ' ', ' ',{ 'type': '/paragraph' }],
			'html': '&nbsp;A &nbsp; &nbsp;'
		},
		{
			// [ ][ ][A][ ][ ][ ]
			'data': [{ 'type': 'paragraph' },' ', ' ', 'A', ' ', ' ', ' ',{ 'type': '/paragraph' }],
			'html': '&nbsp; A &nbsp;&nbsp;'
		},
		{
			// [ ][ ][ ][A][ ][ ]
			'data': [{ 'type': 'paragraph' },' ', ' ', ' ', 'A', ' ', ' ',{ 'type': '/paragraph' }],
			'html': '&nbsp; &nbsp;A &nbsp;'
		},
		{
			// [ ][ ][ ][ ][A][ ]
			'data': [{ 'type': 'paragraph' },' ', ' ', ' ', ' ', 'A', ' ',{ 'type': '/paragraph' }],
			'html': '&nbsp; &nbsp; A&nbsp;'
		},
		{
			// [ ][ ][ ][ ][ ][A]
			'data': [{ 'type': 'paragraph' },' ', ' ', ' ', ' ', ' ', 'A',{ 'type': '/paragraph' }],
			'html': '&nbsp; &nbsp; &nbsp;A'
		},
		{
			'data': [{ 'type': 'paragraph' }, '\n', 'A', '\n', 'B', '\n', { 'type': '/paragraph' }],
			'html': '&crarr;A&crarr;B&crarr;'
		},
		{
			'data': [{ 'type': 'paragraph' }, '\t', 'A', '\t', 'B', '\t', { 'type': '/paragraph' }],
			'html': '&#10142;A&#10142;B&#10142;'
		},
		{
			'data': [{ 'type': 'preformatted' }, '\n', 'A', '\n', 'B', '\n', { 'type': '/preformatted' }],
			'html': '\nA\nB\n'
		},
		{
			'data': [{ 'type': 'preformatted' }, '\t', 'A', '\t', 'B', '\t', { 'type': '/preformatted' }],
			'html': '\tA\tB\t'
		},
		{
			// [ ][ ][ ][A][ ][ ]
			'data': [{ 'type': 'preformatted' },' ', ' ', ' ', 'A', ' ', ' ',{ 'type': '/preformatted' }],
			'html': '   A  '
		}
	];
	QUnit.expect( cases.length );
	for ( i = 0, len = cases.length; i < len; i++ ) {
		ve.dm.example.preprocessAnnotations( cases[i].data );
		assert.equal(
			( new ve.ce.TextNode(
				( new ve.dm.Document( cases[i].data ) )
					.documentNode.getChildren()[0].getChildren()[0] )
			).getHtml(),
			cases[i].html
		);
	}
} );
