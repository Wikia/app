/*!
 * VisualEditor ContentEditable MediaWiki-specific ContentBranchNode tests.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.ce.ContentBranchNode' );

/* Tests */

// FIXME runner copypasted from core, use data provider
QUnit.test( 'getRenderedContents', function ( assert ) {
	var i, len, doc, $wrapper,
		cases = [ {
			msg: 'Annotation spanning text and inline nodes',
			data: [
				{ type: 'paragraph' },
				'a',
				['b', [ { type: 'textStyle/bold' } ]],
				{
					type: 'mwEntity',
					attributes: { character: 'c' },
					htmlAttributes: [ { keys: [ 'typeof' ], values: { typeof: 'mw:Entity' } } ],
					annotations: [ { type: 'textStyle/bold' } ]
				},
				{ type: '/mwEntity' },
				['d', [ { type: 'textStyle/bold' } ]],
				{
					type: 'alienInline',
					attributes: { domElements: $( '<tt>e</tt>' ).toArray() },
					annotations: [ { type: 'textStyle/bold' } ]
				},
				{ type: '/alienInline' },
				{ type: '/paragraph' }
			],
			html: 'a<b>b<span typeof="mw:Entity" class="ve-ce-leafNode ' +
				've-ce-mwEntityNode" contenteditable="false">c</span>d<tt>e</tt></b>'
		} ];
	QUnit.expect( cases.length );
	for ( i = 0, len = cases.length; i < len; i++ ) {
		doc = new ve.dm.Document( ve.dm.example.preprocessAnnotations( cases[i].data ) );
		$wrapper = $( new ve.ce.ParagraphNode( doc.getDocumentNode().getChildren()[0] ).getRenderedContents() );
		// HACK strip out all the class="ve-ce-textStyleAnnotation ve-ce-textStyleBoldAnnotation" crap
		$wrapper.find( '.ve-ce-textStyleAnnotation' ).removeAttr( 'class' );
		assert.equalDomElement( $wrapper[0], $( '<div>' ).html( cases[i].html )[0], cases[i].msg );
	}
} );
