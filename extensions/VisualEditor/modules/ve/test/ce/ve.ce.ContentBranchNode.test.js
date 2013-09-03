/*!
 * VisualEditor ContentEditable ContentBranchNode tests.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.ce.ContentBranchNode' );

/* Tests */

QUnit.test( 'getRenderedContents', function ( assert ) {
	var i, len, doc, $rendered, $wrapper,
		cases = [
		{
			'msg': 'Plain text without annotations',
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
			'msg': 'Bold text',
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
			'msg': 'Italic text',
			'data': [
				{ 'type': 'paragraph' },
				['a', [ { 'type': 'textStyle/italic' } ]],
				['b', [ { 'type': 'textStyle/italic' } ]],
				['c', [ { 'type': 'textStyle/italic' } ]],
				{ 'type': '/paragraph' }
			],
			'html': '<i>abc</i>'
		},
		{
			'msg': 'Underline text',
			'data': [
				{ 'type': 'paragraph' },
				['a', [ { 'type': 'textStyle/underline' } ]],
				['b', [ { 'type': 'textStyle/underline' } ]],
				['c', [ { 'type': 'textStyle/underline' } ]],
				{ 'type': '/paragraph' }
			],
			'html': '<u>abc</u>'
		},
		{
			'msg': 'Strikethrough text',
			'data': [
				{ 'type': 'paragraph' },
				['a', [ { 'type': 'textStyle/strike' } ]],
				['b', [ { 'type': 'textStyle/strike' } ]],
				['c', [ { 'type': 'textStyle/strike' } ]],
				{ 'type': '/paragraph' }
			],
			'html': '<s>abc</s>'
		},
		{
			'msg': 'Small text',
			'data': [
				{ 'type': 'paragraph' },
				['a', [ { 'type': 'textStyle/small' } ]],
				['b', [ { 'type': 'textStyle/small' } ]],
				['c', [ { 'type': 'textStyle/small' } ]],
				{ 'type': '/paragraph' }
			],
			'html': '<small>abc</small>'
		},
		{
			'msg': 'Big text',
			'data': [
				{ 'type': 'paragraph' },
				['a', [ { 'type': 'textStyle/big' } ]],
				['b', [ { 'type': 'textStyle/big' } ]],
				['c', [ { 'type': 'textStyle/big' } ]],
				{ 'type': '/paragraph' }
			],
			'html': '<big>abc</big>'
		},
		{
			'msg': 'Strong text',
			'data': [
				{ 'type': 'paragraph' },
				['a', [ { 'type': 'textStyle/strong' } ]],
				['b', [ { 'type': 'textStyle/strong' } ]],
				['c', [ { 'type': 'textStyle/strong' } ]],
				{ 'type': '/paragraph' }
			],
			'html': '<strong>abc</strong>'
		},
		{
			'msg': 'Emphasized text',
			'data': [
				{ 'type': 'paragraph' },
				['a', [ { 'type': 'textStyle/emphasize' } ]],
				['b', [ { 'type': 'textStyle/emphasize' } ]],
				['c', [ { 'type': 'textStyle/emphasize' } ]],
				{ 'type': '/paragraph' }
			],
			'html': '<em>abc</em>'
		},
		{
			'msg': 'Superscript text',
			'data': [
				{ 'type': 'paragraph' },
				['a', [ { 'type': 'textStyle/superscript' } ]],
				['b', [ { 'type': 'textStyle/superscript' } ]],
				['c', [ { 'type': 'textStyle/superscript' } ]],
				{ 'type': '/paragraph' }
			],
			'html': '<sup>abc</sup>'
		},
		{
			'msg': 'Subscript text',
			'data': [
				{ 'type': 'paragraph' },
				['a', [ { 'type': 'textStyle/subscript' } ]],
				['b', [ { 'type': 'textStyle/subscript' } ]],
				['c', [ { 'type': 'textStyle/subscript' } ]],
				{ 'type': '/paragraph' }
			],
			'html': '<sub>abc</sub>'
		},
		{
			'msg': 'Code text',
			'data': [
				{ 'type': 'paragraph' },
				['a', [ { 'type': 'textStyle/code' } ]],
				['b', [ { 'type': 'textStyle/code' } ]],
				['c', [ { 'type': 'textStyle/code' } ]],
				{ 'type': '/paragraph' }
			],
			'html': '<code>abc</code>'
		},
		{
			'msg': 'Bold character, plain character, italic character',
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
			'msg': 'Bold, italic and underlined text (same order)',
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
			'msg': 'Varying order in consecutive range doesn\'t affect rendering',
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
			'msg': 'Varying order in non-consecutive range does affect rendering',
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
			'msg': 'Text annotated in varying order, surrounded by plain text',
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
			'msg': 'Out-of-order closings do not produce misnested tags',
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
			'msg': 'Additional openings are added inline, even when out of order',
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
			'msg': 'Out-of-order closings surrounded by plain text',
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
			'html': 'abc<i><u><b>d</b></u></i><b><u>ef</u></b>ghi'
		}
	];
	QUnit.expect( cases.length );
	for ( i = 0, len = cases.length; i < len; i++ ) {
		doc = new ve.dm.Document( ve.dm.example.preprocessAnnotations( cases[i].data ) );
		$rendered = ( new ve.ce.ParagraphNode( doc.documentNode.getChildren()[0] ) ).getRenderedContents();
		$wrapper = $( '<div>' ).append( $rendered );
		// HACK strip out all the class="ve-ce-TextStyleAnnotation ve-ce-TextStyleBoldAnnotation" crap
		$wrapper.find( '.ve-ce-TextStyleAnnotation' ).removeAttr( 'class' );
		assert.equalDomElement( $wrapper[0], $( '<div>' ).html( cases[i].html )[0], cases[i].msg );
	}
} );
