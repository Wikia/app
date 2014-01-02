/*!
 * VisualEditor ContentEditable MediaWiki-specific ContentBranchNode tests.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.ce.ContentBranchNode' );

/* Tests */

// FIXME runner copypasted from core, use data provider
QUnit.test( 'getRenderedContents', function ( assert ) {
	var i, len, doc, $rendered, $wrapper,
		cases = [
		{
			'msg': 'Annotation spanning text and inline nodes',
			'data': [
				{ 'type': 'paragraph' },
				'a',
				['b', [ { 'type': 'textStyle/bold' } ]],
				{
					'type': 'mwEntity',
					'attributes': { 'character': 'c' },
					'htmlAttributes': [ { 'keys': [ 'typeof' ], 'values': { 'typeof': 'mw:Entity' } } ],
					'annotations': [ { 'type': 'textStyle/bold' } ]
				},
				{ 'type': '/mwEntity' },
				['d', [ { 'type': 'textStyle/bold' } ]],
				{
					'type': 'alienInline',
					'attributes': { 'domElements': $( '<tt>e</tt>' ).toArray() },
					'annotations': [ { 'type': 'textStyle/bold' } ]
				},
				{ 'type': '/alienInline' },
				{ 'type': '/paragraph' }
			],
			'html': 'a<b>b<span typeof="mw:Entity" class="ve-ce-leafNode ' +
				've-ce-mwEntityNode" contenteditable="false">c</span>d<span ' +
				'class="ve-ce-leafNode ve-ce-generatedContentNode ' +
				've-ce-alienNode ve-ce-alienInlineNode"><tt>e</tt></span></b>'
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
