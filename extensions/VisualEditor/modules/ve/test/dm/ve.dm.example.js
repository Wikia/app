/**
 * VisualEditor data model example data sets.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/* Static Members */

ve.dm.example = {};

/**
 * Convert arrays of shorthand annotations in a data fragment to AnnotationSets with real
 * annotation objects.
 *
 * Shorthand notation for annotations is:
 * [ 'a', [ { 'type': 'link', 'data': { 'href': '...' }, 'htmlTagName': 'a', 'htmlAttributes': { ... } } ] ]
 *
 * The actual storage format has an instance of ve.dm.LinkAnnotation instead of the plain object,
 * and an instance of ve.AnnotationSet instead of the array.
 *
 * @param {Array} data Linear model data. Will be modified.
 */
ve.dm.example.preprocessAnnotations = function ( data ) {
	var i, key;
	for ( i = 0; i < data.length; i++ ) {
		key = data[i].annotations ? 'annotations' : 1;
		if ( ve.isArray( data[i][key] ) ) {
			data[i][key] = ve.dm.example.createAnnotationSet( data[i][key] );
		}
	}
};

/**
 * Create an annotation object from shorthand notation.
 * @param {Object} annotation Plain object with type, data, htmlTagName and htmlAttributes properties
 * @return {ve.dm.Annotation} Instance of the right ve.dm.Annotation subclass
 */
ve.dm.example.createAnnotation = function ( annotation ) {
	var ann, annKey;
	ann = ve.dm.annotationFactory.create( annotation.type );
	for ( annKey in annotation ) {
		if ( annKey !== 'type' ) {
			ann[annKey] = annotation[annKey];
		}
	}
	return ann;
};

/**
 * Create an AnnotationSet from an array of shorthand annotations.
 *
 * This calls ve.dm.example.createAnnotation() for each element and puts the result in an
 * AnnotationSet.
 *
 * @param {Array} annotations Array of annotations in shorthand format
 * @return {ve.AnnotationSet}
 */
ve.dm.example.createAnnotationSet = function ( annotations ) {
	var i;
	for ( i = 0; i < annotations.length; i++ ) {
		annotations[i] = ve.dm.example.createAnnotation( annotations[i] );
	}
	return new ve.AnnotationSet( annotations );
};

/* Some common annotations in shorthand format */
ve.dm.example.bold = { 'type': 'textStyle/bold', 'htmlTagName': 'b', 'htmlAttributes': {} };
ve.dm.example.italic = { 'type': 'textStyle/italic', 'htmlTagName': 'i', 'htmlAttributes': {} };
ve.dm.example.underline = { 'type': 'textStyle/underline', 'htmlTagName': 'u', 'htmlAttributes': {} };

/**
 * Serialized HTML.
 *
 * This is what the parser will emit.
 * TODO remove some of the <p>s here to test automatic wrapping
 */
ve.dm.example.html =
	'<h1>a<b>b</b><i>c</i></h1>' +
	'<table>' +
		'<tr>' +
			'<td>' +
				'<p>d</p>' +
				'<ul>' +
					'<li>' +
						'<p>e</p>' +
						'<ul>' +
							'<li>' +
								'<p>f</p>' +
							'</li>' +
						'</ul>' +
					'</li>' +
				'</ul>' +
				'<ol>' +
					'<li>' +
						'<p>g</p>' +
					'</li>' +
				'</ol>' +
			'</td>' +
		'</tr>' +
	'</table>' +
	'<pre>h<img src="image.png">i</pre>'+
	'<dl>' +
		'<dt>' +
			'<p>j</p>' +
		'</dt>' +
		'<dd>' +
			'<p>k</p>' +
		'</dd>' +
	'</dl>' +
	'<p>l</p>' +
	'<p>m</p>';

/*
 * Linear data.
 *
 * This is what we convert serialized HTML from the parser into so we can work with it more easily.
 *
 * There are three types of components in content data:
 *
 *     {String} Plain text character
 *
 *     {Array} Annotated character
 *         0: {String} Character
 *         1: {Object} List of references to immutable annotation objects, keyed by JSON
 *            serializations of their values (hashes)
 *
 *     {Object} Opening or closing structural element
 *         type: {String} Symbolic node type name, if closing element first character will be "/"
 *         [attributes]: {Object} List of symbolic attribute name and literal value pairs
 */
ve.dm.example.data = [
	//  0 - Beginning of heading
	{ 'type': 'heading', 'attributes': { 'level': 1 } },
	//  1 - Plain "a"
	'a',
	//  2 - Bold "b"
	['b', [ ve.dm.example.bold ]],
	//  3 - Italic "c"
	['c', [ ve.dm.example.italic ]],
	//  4 - End of heading
	{ 'type': '/heading' },
	//  5 - Beginning of table
	{ 'type': 'table' },
	//  6 - Beginning of body
	{ 'type': 'tableSection', 'attributes': { 'style': 'body' } },
	//  7 - Beginning of row
	{ 'type': 'tableRow' },
	//  8 - Beginning of cell
	{ 'type': 'tableCell', 'attributes': { 'style': 'data' } },
	//  9 - Beginning of paragraph
	{ 'type': 'paragraph' },
	// 10 - Plain "d"
	'd',
	// 11 - End of paragraph
	{ 'type': '/paragraph' },
	// 12 - Beginning of bullet list
	{ 'type': 'list', 'attributes': { 'style': 'bullet' } },
	// 13 - Beginning of list item
	{ 'type': 'listItem' },
	// 14 - Beginning of paragraph
	{ 'type': 'paragraph' },
	// 15 - Plain "e"
	'e',
	// 16 - End of paragraph
	{ 'type': '/paragraph' },
	// 17 - Beginning of nested bullet list
	{ 'type': 'list', 'attributes': { 'style': 'bullet' } },
	// 18 - Beginning of nested bullet list item
	{ 'type': 'listItem' },
	// 19 - Beginning of paragraph
	{ 'type': 'paragraph' },
	// 20 - Plain "f"
	'f',
	// 21 - End of paragraph
	{ 'type': '/paragraph' },
	// 22 - End of nested bullet list item
	{ 'type': '/listItem' },
	// 23 - End of nested bullet list
	{ 'type': '/list' },
	// 24 - End of bullet list item
	{ 'type': '/listItem' },
	// 25 - End of bullet list
	{ 'type': '/list' },
	// 26 - Beginning of numbered list
	{ 'type': 'list', 'attributes': { 'style': 'number' } },
	// 27 - Beginning of numbered list item
	{ 'type': 'listItem' },
	// 28 - Beginning of paragraph
	{ 'type': 'paragraph' },
	// 29 - Plain "g"
	'g',
	// 30 - End of paragraph
	{ 'type': '/paragraph' },
	// 31 - End of item
	{ 'type': '/listItem' },
	// 32 - End of list
	{ 'type': '/list' },
	// 33 - End of cell
	{ 'type': '/tableCell' },
	// 34 - End of row
	{ 'type': '/tableRow' },
	// 35 - End of body
	{ 'type': '/tableSection' },
	// 36 - End of table
	{ 'type': '/table' },
	// 37 - Beginning of preformatted
	{ 'type': 'preformatted' },
	// 38 - Plain "h"
	'h',
	// 39 - Beginning of inline image
	{ 'type': 'image', 'attributes': { 'html/src': 'image.png' } },
	// 40 - End of inline image
	{ 'type': '/image' },
	// 41 - Plain "i"
	'i',
	// 42 - End of preformatted
	{ 'type': '/preformatted' },
	// 43 - Beginning of definition list
	{ 'type': 'definitionList' },
	// 44 - Beginning of definition list term item
	{ 'type': 'definitionListItem', 'attributes': { 'style': 'term' } },
	// 45 - Beginning of paragraph
	{ 'type': 'paragraph' },
	// 46 - Plain "j"
	'j',
	// 47 - End of paragraph
	{ 'type': '/paragraph' },
	// 48 - End of definition list term item
	{ 'type': '/definitionListItem' },
	// 49 - Beginning of definition list definition item
	{ 'type': 'definitionListItem', 'attributes': { 'style': 'definition' } },
	// 50 - Beginning of paragraph
	{ 'type': 'paragraph' },
	// 51 - Plain "k"
	'k',
	// 52 - End of paragraph
	{ 'type': '/paragraph' },
	// 53 - End of definition list definition item
	{ 'type': '/definitionListItem' },
	// 54 - End of definition list
	{ 'type': '/definitionList' },
	// 55 - Beginning of paragraph
	{ 'type': 'paragraph' },
	// 56 - Plain "l"
	'l',
	// 57 - End of paragraph
	{ 'type': '/paragraph' },
	// 58 - Beginning of paragraph
	{ 'type': 'paragraph' },
	// 59 - Plain "m"
	'm',
	// 60 - End of paragraph
	{ 'type': '/paragraph' }
	// 61 - End of document
];
ve.dm.example.preprocessAnnotations( ve.dm.example.data );

ve.dm.example.alienData = [
	// 0 - Open alienBlock
	{ 'type': 'alienBlock' },
	// 1 - Close alienBlock
	{ 'type': '/alienBlock' },
	// 2 - Open paragraph
	{ 'type': 'paragraph' },
	// 3 - Plain character 'a'
	'a',
	// 4 - Open alienInline
	{ 'type': 'alienBlock' },
	// 5 - Close alienInline
	{ 'type': '/alienBlock' },
	// 6 - Plain character 'b'
	'b',
	// 7 - Close paragraph
	{ 'type': '/paragraph' },
	// 8 - Open alienBlock
	{ 'type': 'alienBlock' },
	// 9 - Close alienBlock
	{ 'type': '/alienBlock' }
	// 10 - End of document
];

ve.dm.example.withMeta = [
	{
		'type': 'metaBlock',
		'attributes': {
			'style': 'meta',
			'key': 'mw:PageProp/nocc'
		}
	},
	{ 'type': '/metaBlock' },
	{ 'type': 'paragraph' },
	'F',
	'o',
	'o',
	{
		'type': 'metaInline',
		'attributes': {
			'style': 'link',
			'key': 'mw:WikiLink/Category',
			'value': './Category:Bar'
		}
	},
	{ 'type': '/metaInline' },
	'B',
	'a',
	'r',
	{
		'type': 'metaInline',
		'attributes': {
			'style': 'meta',
			'key': 'mw:foo',
			'value': 'bar'
		}
	},
	{ 'type': '/metaInline' },
	'B',
	'a',
	'z',
	{ 'type': '/paragraph' },
	{
		'type': 'metaBlock',
		'attributes': {
			'style': 'meta',
			'key': 'mw:bar',
			'value': 'baz'
		}
	},
	{ 'type': '/metaBlock' },
	{
		'type': 'metaBlock',
		'attributes': {
			'style': 'link',
			'key': 'mw:WikiLink/Category',
			'value': './Category:Foo#Bar baz%23quux'
		}
	},
	{ 'type': '/metaBlock' },
	{
		'type': 'metaBlock',
		'attributes': {
			'style': 'meta',
			'key': null,
			'html/typeof': 'mw:Placeholder',
			'html/data-parsoid': 'foobar'
		}
	},
	{ 'type': '/metaBlock' }
];

ve.dm.example.withMetaPlainData = [
	{ 'type': 'paragraph' },
	'F',
	'o',
	'o',
	'B',
	'a',
	'r',
	'B',
	'a',
	'z',
	{ 'type': '/paragraph' }
];

ve.dm.example.withMetaMetaData = [
	[
		{
			'type': 'metaBlock',
			'attributes': {
				'style': 'meta',
				'key': 'mw:PageProp/nocc'
			}
		}
	],
	undefined,
	undefined,
	undefined,
	[
		{
			'type': 'metaInline',
			'attributes': {
				'style': 'link',
				'key': 'mw:WikiLink/Category',
				'value': './Category:Bar'
			}
		}
	],
	undefined,
	undefined,
	[
		{
			'type': 'metaInline',
			'attributes': {
				'style': 'meta',
				'key': 'mw:foo',
				'value': 'bar'
			}
		}
	],
	undefined,
	undefined,
	undefined,
	[
		{
			'type': 'metaBlock',
			'attributes': {
				'style': 'meta',
				'key': 'mw:bar',
				'value': 'baz'
			}
		},
		{
			'type': 'metaBlock',
			'attributes': {
				'style': 'link',
				'key': 'mw:WikiLink/Category',
				'value': './Category:Foo#Bar baz%23quux'
			}
		},
		{
			'type': 'metaBlock',
			'attributes': {
				'style': 'meta',
				'key': null,
				'html/typeof': 'mw:Placeholder',
				'html/data-parsoid': 'foobar'
			}
		}
	]
];

/**
 * Sample content data index.
 *
 * This is part of what a ve.dm.DocumentFragment generates when given linear data.
 *
 *  (21) branch nodes
 *     (01) document node
 *     (01) heading node
 *     (01) table node
 *     (01) tableRow node
 *     (01) tableCell node
 *     (06) paragraph nodes
 *     (03) list nodes
 *     (03) listItem nodes
 *     (01) preformatted node
 *     (01) definitionList node
 *     (02) definitionListItem nodes
 *  (10) leaf nodes
 *     (09) text nodes
 *     (01) image node
 */
ve.dm.example.tree = new ve.dm.DocumentNode( [
	// Heading with "abc"
	new ve.dm.HeadingNode( [new ve.dm.TextNode( 3 )], ve.dm.example.data[0].attributes ),
	new ve.dm.TableNode( [
		new ve.dm.TableSectionNode( [
			new ve.dm.TableRowNode( [
				new ve.dm.TableCellNode( [
					// Paragraph with "d"
					new ve.dm.ParagraphNode( [new ve.dm.TextNode( 1 )] ),
					new ve.dm.ListNode( [
						// 1st level bullet list item with "e"
						new ve.dm.ListItemNode( [
							new ve.dm.ParagraphNode( [new ve.dm.TextNode( 1 )] ),
							new ve.dm.ListNode( [
								// 2nd level bullet list item with "f"
								new ve.dm.ListItemNode( [
									new ve.dm.ParagraphNode( [new ve.dm.TextNode( 1 )] )
								] )
							], ve.dm.example.data[17].attributes )
						] )
					], ve.dm.example.data[12].attributes ),
					new ve.dm.ListNode( [
						// Numbered list item with "g"
						new ve.dm.ListItemNode( [
							new ve.dm.ParagraphNode( [new ve.dm.TextNode( 1 )] )
						] )
					], ve.dm.example.data[26].attributes )
				], ve.dm.example.data[8].attributes )
			] )
		], ve.dm.example.data[6].attributes )
	] ),
	// Preformatted with "h[image.png]i"
	new ve.dm.PreformattedNode( [
		new ve.dm.TextNode( 1 ),
		new ve.dm.ImageNode( [], ve.dm.example.data[39].attributes ),
		new ve.dm.TextNode( 1 )
	] ),
	new ve.dm.DefinitionListNode( [
		// Definition list term item with "j"
		new ve.dm.DefinitionListItemNode( [
			new ve.dm.ParagraphNode( [new ve.dm.TextNode( 1 )] )
		], ve.dm.example.data[44].attributes ),
		// Definition list definition item with "k"
		new ve.dm.DefinitionListItemNode( [
			new ve.dm.ParagraphNode( [new ve.dm.TextNode( 1 )] )
		], ve.dm.example.data[49].attributes )
	] ),
	new ve.dm.ParagraphNode( [new ve.dm.TextNode( 1 )] ),
	new ve.dm.ParagraphNode( [new ve.dm.TextNode( 1 )] )
] );

ve.dm.example.conversions = {
	'definitionListItem term': {
		'domElement': ve.example.createDomElement( 'dt' ),
		'dataElement': { 'type': 'definitionListItem', 'attributes': { 'style': 'term' } }
	},
	'definitionListItem definition': {
		'domElement': ve.example.createDomElement( 'dd' ),
		'dataElement': { 'type': 'definitionListItem', 'attributes': { 'style': 'definition' } }
	},
	'definitionList definition': {
		'domElement': ve.example.createDomElement( 'dl' ),
		'dataElement': { 'type': 'definitionList' }
	},
	'heading level 1': {
		'domElement': ve.example.createDomElement( 'h1' ),
		'dataElement': { 'type': 'heading', 'attributes': { 'level': 1 } }
	},
	'heading level 2': {
		'domElement': ve.example.createDomElement( 'h2' ),
		'dataElement': { 'type': 'heading', 'attributes': { 'level': 2 } }
	},
	'heading level 3': {
		'domElement': ve.example.createDomElement( 'h3' ),
		'dataElement': { 'type': 'heading', 'attributes': { 'level': 3 } }
	},
	'heading level 4': {
		'domElement': ve.example.createDomElement( 'h4' ),
		'dataElement': { 'type': 'heading', 'attributes': { 'level': 4 } }
	},
	'heading level 5': {
		'domElement': ve.example.createDomElement( 'h5' ),
		'dataElement': { 'type': 'heading', 'attributes': { 'level': 5 } }
	},
	'heading level 6': {
		'domElement': ve.example.createDomElement( 'h6' ),
		'dataElement': { 'type': 'heading', 'attributes': { 'level': 6 } }
	},
	'image': {
		'domElement': ve.example.createDomElement( 'img' ),
		'dataElement': { 'type': 'image' }
	},
	'listItem': {
		'domElement': ve.example.createDomElement( 'li' ),
		'dataElement': { 'type': 'listItem' }
	},
	'list bullet': {
		'domElement': ve.example.createDomElement( 'ul' ),
		'dataElement': { 'type': 'list', 'attributes': { 'style': 'bullet' } }
	},
	'list number': {
		'domElement': ve.example.createDomElement( 'ol' ),
		'dataElement': { 'type': 'list', 'attributes': { 'style': 'number' } }
	},
	'paragraph': {
		'domElement': ve.example.createDomElement( 'p' ),
		'dataElement': { 'type': 'paragraph' }
	},
	'preformatted': {
		'domElement': ve.example.createDomElement( 'pre' ),
		'dataElement': { 'type': 'preformatted' }
	},
	'tableCell': {
		'domElement': ve.example.createDomElement( 'td' ),
		'dataElement': { 'type': 'tableCell', 'attributes': { 'style': 'data' } }
	},
	'table': {
		'domElement': ve.example.createDomElement( 'table' ),
		'dataElement': { 'type': 'table' }
	},
	'tableRow': {
		'domElement': ve.example.createDomElement( 'tr' ),
		'dataElement': { 'type': 'tableRow' }
	},
	'paragraph with mw-data attribute': {
		'domElement': ve.example.createDomElement( 'p', { 'data-mw': '{"test":1234}' } ),
		'dataElement': { 'type': 'paragraph', 'attributes': { 'html/data-mw': '{"test":1234}' } }
	},
	'paragraph with style attribute': {
		'domElement': ve.example.createDomElement( 'p', { 'style': 'color:blue' } ),
		'dataElement': { 'type': 'paragraph', 'attributes': { 'html/style': 'color:blue' } }
	}
};

ve.dm.example.domToDataCases = {
	'paragraph with plain text': {
		'html': '<p>abc</p>',
		'data': [
			{ 'type': 'paragraph' },
			'a',
			'b',
			'c',
			{ 'type': '/paragraph' }
		]
	},
	'annotated text with bold, italic, underline formatting': {
		'html': '<p><b>a</b><i>b</i><u>c</u></p>',
		'data': [
			{ 'type': 'paragraph' },
			['a', [ ve.dm.example.bold ]],
			['b', [ ve.dm.example.italic ]],
			['c', [ ve.dm.example.underline ]],
			{ 'type': '/paragraph' }
		]
	},
	'image': {
		'html': '<img src="image.png">',
		'data': [
			{ 'type': 'image', 'attributes' : { 'html/src' : 'image.png' } },
			{ 'type' : '/image' }
		]
	},
	'paragraph with alienInline inside': {
		'html': '<p>a<tt class="foo">b</tt>c</p>',
		'data': [
			{ 'type': 'paragraph' },
			'a',
			{
				'type': 'alienInline',
				'attributes': { 'html': '<tt class="foo">b</tt>' }
			},
			{ 'type': '/alienInline' },
			'c',
			{ 'type': '/paragraph' }
		]
	},
	'paragraphs with an alienBlock between them': {
		'html': '<p>abc</p><figure>abc</figure><p>def</p>',
		'data': [
			{ 'type': 'paragraph' },
			'a',
			'b',
			'c',
			{ 'type': '/paragraph' },
			{ 'type': 'alienBlock', 'attributes': { 'html': '<figure>abc</figure>' } },
			{ 'type': '/alienBlock' },
			{ 'type': 'paragraph' },
			'd',
			'e',
			'f',
			{ 'type': '/paragraph' }
		]
	},
	'wrapping of bare content': {
		'html': 'abc',
		'data': [
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			'a',
			'b',
			'c',
			{ 'type': '/paragraph' }
		]
	},
	'wrapping of bare content with inline node': {
		'html': '1<br/>2',
		'data': [
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			'1',
			{ 'type': 'break' },
			{ 'type': '/break' },
			'2',
			{ 'type': '/paragraph' }
		]
	},
	'wrapping of bare content with inline alien': {
		'html': '1<tt class="bar">baz</tt>2',
		'data': [
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			'1',
			{
				'type': 'alienInline',
				'attributes': { 'html': '<tt class="bar">baz</tt>' }
			},
			{ 'type': '/alienInline' },
			'2',
			{ 'type': '/paragraph' }
		]
	},
	'wrapping of bare content with block alien': {
		'html': '1<figure class="bar">baz</figure>2',
		'data': [
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			'1',
			{ 'type': '/paragraph' },
			{
				'type': 'alienBlock',
				'attributes': { 'html': '<figure class="bar">baz</figure>' }
			},
			{ 'type': '/alienBlock' },
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			'2',
			{ 'type': '/paragraph' }
		]
	},
	'wrapping of bare content between structural nodes': {
		'html': '<table></table>abc<table></table>',
		'data': [
			{ 'type': 'table' },
			{ 'type': '/table' },
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			'a',
			'b',
			'c',
			{ 'type': '/paragraph' },
			{ 'type': 'table' },
			{ 'type': '/table' }
		]
	},
	'wrapping of bare content between paragraphs': {
		'html': '<p>abc</p>def<p></p>',
		'data': [
			{ 'type': 'paragraph' },
			'a',
			'b',
			'c',
			{ 'type': '/paragraph' },
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			'd',
			'e',
			'f',
			{ 'type': '/paragraph' },
			{ 'type': 'paragraph' },
			{ 'type': '/paragraph' }
		]
	},
	'example document': {
		'html': ve.dm.example.html,
		'data': ve.dm.example.data
	},
	'list item with space followed by link': {
		'html': '<ul><li><p> <a rel="mw:WikiLink" href="Foo_bar" data-rt="{&quot;sHref&quot;:&quot;foo bar&quot;}">bar</a></p></li></ul>',
		'data': [
			{ 'type': 'list', 'attributes': { 'style': 'bullet' } },
			{ 'type': 'listItem' },
			{ 'type': 'paragraph', 'internal': { 'whitespace': [ undefined, ' ' ] } },
			[
				'b',
				[ {
					'type': 'link/MWinternal',
					'data': {
						'title': 'Foo bar',
						'hrefPrefix': ''
					},
					'htmlTagName': 'a',
					'htmlAttributes': {
						'data-rt': '{"sHref":"foo bar"}',
						'href': 'Foo_bar',
						'rel': 'mw:WikiLink'
					}
				} ]
			],
			[
				'a',
				[ {
					'type': 'link/MWinternal',
					'data': {
						'title': 'Foo bar',
						'hrefPrefix': ''
					},
					'htmlTagName': 'a',
					'htmlAttributes': {
						'data-rt': '{"sHref":"foo bar"}',
						'href': 'Foo_bar',
						'rel': 'mw:WikiLink'
					}
				} ]
			],
			[
				'r',
				[ {
					'type': 'link/MWinternal',
					'data': {
						'title': 'Foo bar',
						'hrefPrefix': ''
					},
					'htmlTagName': 'a',
					'htmlAttributes': {
						'data-rt': '{"sHref":"foo bar"}',
						'href': 'Foo_bar',
						'rel': 'mw:WikiLink'
					}
				} ]
			],
			{ 'type': '/paragraph' },
			{ 'type': '/listItem' },
			{ 'type': '/list' }
		]
	},
	'internal link with ./ and ../': {
		'html': '<p><a rel="mw:WikiLink" href="./../../../Foo/Bar">Foo</a></p>',
		'normalizedHtml': '<p><a rel="mw:WikiLink" href="./../../../Foo/Bar">Foo</a></p>',
		'data': [
			{ 'type': 'paragraph' },
			[
				'F',
				[ {
					'type': 'link/MWinternal',
					'data': {
						'title': 'Foo/Bar',
						'hrefPrefix': './../../../'
					},
					'htmlTagName': 'a',
					'htmlAttributes': {
						'href': './../../../Foo/Bar',
						'rel': 'mw:WikiLink'
					}
				} ]
			],
			[
				'o',
				[ {
					'type': 'link/MWinternal',
					'data': {
						'title': 'Foo/Bar',
						'hrefPrefix': './../../../'
					},
					'htmlTagName': 'a',
					'htmlAttributes': {
						'href': './../../../Foo/Bar',
						'rel': 'mw:WikiLink'
					}
				} ]
			],
			[
				'o',
				[ {
					'type': 'link/MWinternal',
					'data': {
						'title': 'Foo/Bar',
						'hrefPrefix': './../../../'
					},
					'htmlTagName': 'a',
					'htmlAttributes': {
						'href': './../../../Foo/Bar',
						'rel': 'mw:WikiLink'
					}
				} ]
			],
			{ 'type': '/paragraph' }
		]
	},
	'numbered external link': {
		'html': '<p><a rel="mw:ExtLink/Numbered" href="http://www.mediawiki.org/">[1]</a></p>',
		'data': [
			{ 'type': 'paragraph' },
			[
				'[',
				[ {
					'type': 'link/MWexternal',
					'data': {
						'href': 'http://www.mediawiki.org/',
					},
					'htmlTagName': 'a',
					'htmlAttributes': {
						'href': 'http://www.mediawiki.org/',
						'rel': 'mw:ExtLink/Numbered'
					}
				} ]
			],
			[
				'1',
				[ {
					'type': 'link/MWexternal',
					'data': {
						'href': 'http://www.mediawiki.org/',
					},
					'htmlTagName': 'a',
					'htmlAttributes': {
						'href': 'http://www.mediawiki.org/',
						'rel': 'mw:ExtLink/Numbered'
					}
				} ]
			],
			[
				']',
				[ {
					'type': 'link/MWexternal',
					'data': {
						'href': 'http://www.mediawiki.org/',
					},
					'htmlTagName': 'a',
					'htmlAttributes': {
						'href': 'http://www.mediawiki.org/',
						'rel': 'mw:ExtLink/Numbered'
					}
				} ]
			],
			{ 'type': '/paragraph' }
		]
	},
	'URL link': {
		'html': '<p><a rel="mw:ExtLink/URL" href="http://www.mediawiki.org/">mw</a></p>',
		'data': [
			{ 'type': 'paragraph' },
			[
				'm',
				[ {
					'type': 'link/MWexternal',
					'data': {
						'href': 'http://www.mediawiki.org/',
					},
					'htmlTagName': 'a',
					'htmlAttributes': {
						'href': 'http://www.mediawiki.org/',
						'rel': 'mw:ExtLink/URL'
					}
				} ]
			],
			[
				'w',
				[ {
					'type': 'link/MWexternal',
					'data': {
						'href': 'http://www.mediawiki.org/',
					},
					'htmlTagName': 'a',
					'htmlAttributes': {
						'href': 'http://www.mediawiki.org/',
						'rel': 'mw:ExtLink/URL'
					}
				} ]
			],
			{ 'type': '/paragraph' }
		]
	},
	'whitespace preservation in headings': {
		'html': '<h2>Foo</h2><h2> Bar</h2><h2>Baz </h2><h2>  Quux   </h2>',
		'data': [
			{ 'type': 'heading', 'attributes': { 'level': 2 } },
			'F',
			'o',
			'o',
			{ 'type': '/heading' },
			{
				'type': 'heading',
				'attributes': { 'level': 2 },
				'internal': { 'whitespace': [ undefined, ' ' ] }
			},
			'B',
			'a',
			'r',
			{ 'type': '/heading' },
			{
				'type': 'heading',
				'attributes': { 'level': 2 },
				'internal': { 'whitespace': [ undefined, undefined, ' ' ] }
			},
			'B',
			'a',
			'z',
			{ 'type': '/heading' },
			{
				'type': 'heading',
				'attributes': { 'level': 2 },
				'internal': { 'whitespace': [ undefined, '  ', '   ' ] }
			},
			'Q',
			'u',
			'u',
			'x',
			{ 'type': '/heading' }
		]
	},
	'whitespace preservation in list items': {
		'html': '<ul><li>Foo</li><li> Bar</li><li>Baz </li><li>  Quux   </li></ul>',
		'data': [
			{ 'type': 'list', 'attributes': { 'style': 'bullet' } },
			{ 'type': 'listItem' },
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			'F',
			'o',
			'o',
			{ 'type': '/paragraph' },
			{ 'type': '/listItem' },
			{ 'type': 'listItem', 'internal': { 'whitespace': [ undefined, ' ' ]} },
			{ 'type': 'paragraph', 'internal': { 'whitespace': [ ' ' ], 'generated': 'wrapper' } },
			'B',
			'a',
			'r',
			{ 'type': '/paragraph' },
			{ 'type': '/listItem' },
			{ 'type': 'listItem', 'internal': { 'whitespace': [ undefined, undefined, ' ' ] } },
			{ 'type': 'paragraph', 'internal': { 'whitespace': [ undefined, undefined, undefined, ' ' ], 'generated': 'wrapper' } },
			'B',
			'a',
			'z',
			{ 'type': '/paragraph' },
			{ 'type': '/listItem' },
			{ 'type': 'listItem', 'internal': { 'whitespace': [ undefined, '  ', '   '] } },
			{
				'type': 'paragraph',
				'internal': { 'whitespace': [ '  ', undefined, undefined, '   ' ], 'generated': 'wrapper' }
			},
			'Q',
			'u',
			'u',
			'x',
			{ 'type': '/paragraph' },
			{ 'type': '/listItem' },
			{ 'type': '/list' }
		]
	},
	'whitespace preservation with annotations': {
		'html': '<p> <i>  Foo   </i>    </p>',
		'data': [
			{
				'type': 'paragraph',
				'internal': { 'whitespace': [ undefined, ' ', '    ' ] }
			},
			[ ' ', [ ve.dm.example.italic ] ],
			[ ' ', [ ve.dm.example.italic ] ],
			[ 'F', [ ve.dm.example.italic ] ],
			[ 'o', [ ve.dm.example.italic ] ],
			[ 'o', [ ve.dm.example.italic ] ],
			[ ' ', [ ve.dm.example.italic ] ],
			[ ' ', [ ve.dm.example.italic ] ],
			[ ' ', [ ve.dm.example.italic ] ],
			{ 'type': '/paragraph' }
		]
	},
	'outer whitespace preservation in a list with bare text and a wrapper paragraph': {
		'html': '\n<ul>\n\n<li>\n\n\nBa re\n\n\n\n</li>\n\n\n\n\n<li>\t<p>\t\tP\t\t\t</p>\t\t\t\t</li>\t\n</ul>\t\n\t\n',
		'data': [
			{ 'type': 'list', 'attributes': { 'style': 'bullet' }, 'internal': { 'whitespace': [ '\n', '\n\n', '\t\n', '\t\n\t\n' ] } },
			{ 'type': 'listItem', 'internal': { 'whitespace': [ '\n\n', '\n\n\n', '\n\n\n\n', '\n\n\n\n\n' ] } },
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper', 'whitespace': [ '\n\n\n', undefined, undefined, '\n\n\n\n' ] } },
			'B',
			'a',
			' ',
			'r',
			'e',
			{ 'type': '/paragraph' },
			{ 'type': '/listItem' },
			{ 'type': 'listItem', 'internal': { 'whitespace': [ '\n\n\n\n\n', '\t', '\t\t\t\t', '\t\n' ] } },
			{ 'type': 'paragraph', 'internal': { 'whitespace': [ '\t', '\t\t', '\t\t\t', '\t\t\t\t' ] } },
			'P',
			{ 'type': '/paragraph' },
			{ 'type': '/listItem' },
			{ 'type': '/list' }
		]
	},
	'outer whitespace preservation in a list with bare text and a sublist': {
		'html': '<ul>\n<li>\n\nBa re\n\n\n<ul>\n\n\n\n<li> <p>  P   </p>    </li>\t</ul>\t\t</li>\t\t\t</ul>',
		'data': [
			{ 'type': 'list', 'attributes': { 'style': 'bullet' }, 'internal': { 'whitespace': [ undefined, '\n', '\t\t\t' ] } },
			{ 'type': 'listItem', 'internal': { 'whitespace': [ '\n', '\n\n', '\t\t', '\t\t\t' ] } },
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper', 'whitespace': [ '\n\n', undefined, undefined, '\n\n\n' ] } },
			'B',
			'a',
			' ',
			'r',
			'e',
			{ 'type': '/paragraph' },
			{ 'type': 'list', 'attributes': { 'style': 'bullet' }, 'internal': { 'whitespace': [ '\n\n\n', '\n\n\n\n', '\t', '\t\t' ] } },
			{ 'type': 'listItem', 'internal': { 'whitespace': [ '\n\n\n\n', ' ', '    ', '\t' ] } },
			{ 'type': 'paragraph', 'internal': { 'whitespace': [ ' ', '  ', '   ', '    '] } },
			'P',
			{ 'type': '/paragraph' },
			{ 'type': '/listItem' },
			{ 'type': '/list' },
			{ 'type': '/listItem' },
			{ 'type': '/list' }
		]
	},
	'whitespace preservation leaves non-edge content whitespace alone': {
		'html': '<p> A  B   <b>    C\t</b>\t\tD\t\t\t</p>\nE\n\nF\n\n\n<b>\n\n\n\nG </b>  H   ',
		'data': [
			{ 'type': 'paragraph', 'internal': { 'whitespace': [ undefined, ' ', '\t\t\t', '\n' ] } },
			'A',
			' ',
			' ',
			'B',
			' ',
			' ',
			' ',
			[ ' ', [ ve.dm.example.bold ] ],
			[ ' ', [ ve.dm.example.bold ] ],
			[ ' ', [ ve.dm.example.bold ] ],
			[ ' ', [ ve.dm.example.bold ] ],
			[ 'C', [ ve.dm.example.bold ] ],
			[ '\t', [ ve.dm.example.bold ] ],
			'\t',
			'\t',
			'D',
			{ 'type': '/paragraph' },
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper', 'whitespace': [ '\n', undefined, undefined, '   ' ] } },
			'E',
			'\n',
			'\n',
			'F',
			'\n',
			'\n',
			'\n',
			[ '\n', [ ve.dm.example.bold ] ],
			[ '\n', [ ve.dm.example.bold ] ],
			[ '\n', [ ve.dm.example.bold ] ],
			[ '\n', [ ve.dm.example.bold ] ],
			[ 'G', [ ve.dm.example.bold ] ],
			[ ' ', [ ve.dm.example.bold ] ],
			' ',
			' ',
			'H',
			{ 'type': '/paragraph' }
		]
	},
	'whitespace preservation with non-edge content whitespace with nested annotations': {
		'html': '<p> A  B   <b>    C\t<i>\t\tD\t\t\t</i>\t\t\t\tE\n</b>\n\nF\n\n\n</p>',
		'data': [
			{ 'type': 'paragraph', 'internal': { 'whitespace': [ undefined, ' ', '\n\n\n' ] } },
			'A',
			' ',
			' ',
			'B',
			' ',
			' ',
			' ',
			[ ' ', [ ve.dm.example.bold ] ],
			[ ' ', [ ve.dm.example.bold ] ],
			[ ' ', [ ve.dm.example.bold ] ],
			[ ' ', [ ve.dm.example.bold ] ],
			[ 'C', [ ve.dm.example.bold ] ],
			[ '\t', [ ve.dm.example.bold ] ],
			[ '\t', [ ve.dm.example.bold, ve.dm.example.italic ] ],
			[ '\t', [ ve.dm.example.bold, ve.dm.example.italic ] ],
			[ 'D', [ ve.dm.example.bold, ve.dm.example.italic ] ],
			[ '\t', [ ve.dm.example.bold, ve.dm.example.italic ] ],
			[ '\t', [ ve.dm.example.bold, ve.dm.example.italic ] ],
			[ '\t', [ ve.dm.example.bold, ve.dm.example.italic ] ],
			[ '\t', [ ve.dm.example.bold ] ],
			[ '\t', [ ve.dm.example.bold ] ],
			[ '\t', [ ve.dm.example.bold ] ],
			[ '\t', [ ve.dm.example.bold ] ],
			[ 'E', [ ve.dm.example.bold ] ],
			[ '\n', [ ve.dm.example.bold ] ],
			'\n',
			'\n',
			'F',
			{ 'type': '/paragraph' }
		]
	},
	'whitespace preservation with tightly nested annotations': {
		'html': '<p> A  B   <b><i>\t\tC\t\t\t</i></b>\n\nD\n\n\n</p>',
		'data': [
			{ 'type': 'paragraph', 'internal': { 'whitespace': [ undefined, ' ', '\n\n\n' ] } },
			'A',
			' ',
			' ',
			'B',
			' ',
			' ',
			' ',
			[ '\t', [ ve.dm.example.bold, ve.dm.example.italic ] ],
			[ '\t', [ ve.dm.example.bold, ve.dm.example.italic ] ],
			[ 'C', [ ve.dm.example.bold, ve.dm.example.italic ] ],
			[ '\t', [ ve.dm.example.bold, ve.dm.example.italic ] ],
			[ '\t', [ ve.dm.example.bold, ve.dm.example.italic ] ],
			[ '\t', [ ve.dm.example.bold, ve.dm.example.italic ] ],
			'\n',
			'\n',
			'D',
			{ 'type': '/paragraph' }
		]
	},
	'whitespace preservation with nested annotations with whitespace on the left side': {
		'html': '<p> A  B   <b>\n\t<i>\t\tC\t\t\t</i></b>\n\nD\n\n\n</p>',
		'data': [
			{ 'type': 'paragraph', 'internal': { 'whitespace': [ undefined, ' ', '\n\n\n' ] } },
			'A',
			' ',
			' ',
			'B',
			' ',
			' ',
			' ',
			[ '\n', [ ve.dm.example.bold ] ],
			[ '\t', [ ve.dm.example.bold ] ],
			[ '\t', [ ve.dm.example.bold, ve.dm.example.italic ] ],
			[ '\t', [ ve.dm.example.bold, ve.dm.example.italic ] ],
			[ 'C', [ ve.dm.example.bold, ve.dm.example.italic ] ],
			[ '\t', [ ve.dm.example.bold, ve.dm.example.italic ] ],
			[ '\t', [ ve.dm.example.bold, ve.dm.example.italic ] ],
			[ '\t', [ ve.dm.example.bold, ve.dm.example.italic ] ],
			'\n',
			'\n',
			'D',
			{ 'type': '/paragraph' }
		]
	},
	'whitespace preservation with nested annotations with whitespace on the right side': {
		'html': '<p> A  B   <b><i>\t\tC\t\t\t</i>\n\t</b>\n\nD\n\n\n</p>',
		'data': [
			{ 'type': 'paragraph', 'internal': { 'whitespace': [ undefined, ' ', '\n\n\n' ] } },
			'A',
			' ',
			' ',
			'B',
			' ',
			' ',
			' ',
			[ '\t', [ ve.dm.example.bold, ve.dm.example.italic ] ],
			[ '\t', [ ve.dm.example.bold, ve.dm.example.italic ] ],
			[ 'C', [ ve.dm.example.bold, ve.dm.example.italic ] ],
			[ '\t', [ ve.dm.example.bold, ve.dm.example.italic ] ],
			[ '\t', [ ve.dm.example.bold, ve.dm.example.italic ] ],
			[ '\t', [ ve.dm.example.bold, ve.dm.example.italic ] ],
			[ '\n', [ ve.dm.example.bold ] ],
			[ '\t', [ ve.dm.example.bold ] ],
			'\n',
			'\n',
			'D',
			{ 'type': '/paragraph' }
		]
	},
	'whitespace preservation with aliens': {
		'html': ' <p typeof="mw:Placeholder">  <br>   </p>    <p>\tFoo\t\t<tt>\t\t\tBar\t\t\t\t</tt>\nBaz\n\n<span typeof="mw:Placeholder">\n\n\nQuux\n\n\n\n</span> \tWhee \n</p>\t\n<figure>\n\tYay \t </figure> \n ',
		'data': [
			{
				'type': 'alienBlock',
				'attributes': {
					'html': '<p typeof="mw:Placeholder">  <br>   </p>'
				},
				'internal': {
					'whitespace': [ ' ', undefined, undefined, '    ' ]
				}
			},
			{ 'type': '/alienBlock' },
			{ 'type': 'paragraph', 'internal': { 'whitespace': [ '    ', '\t', ' \n', '\t\n' ] } },
			'F',
			'o',
			'o',
			'\t',
			'\t',
			{ 'type': 'alienInline', 'attributes': { 'html': '<tt>\t\t\tBar\t\t\t\t</tt>' } },
			{ 'type': '/alienInline' },
			'\n',
			'B',
			'a',
			'z',
			'\n',
			'\n',
			{
				'type': 'alienInline',
				'attributes': {
					'html': '<span typeof="mw:Placeholder">\n\n\nQuux\n\n\n\n</span>'
				}
			},
			{ 'type': '/alienInline' },
			' ',
			'\t',
			'W',
			'h',
			'e',
			'e',
			{ 'type': '/paragraph' },
			{
				'type': 'alienBlock',
				'attributes': {
					'html': '<figure>\n\tYay \t </figure>'
				},
				'internal': {
					'whitespace': [ '\t\n', undefined, undefined, ' \n ' ]
				}
			},
			{ 'type': '/alienBlock' }
		]
	},
	'whitespace preservation not triggered inside <pre>': {
		'html': '\n<pre>\n\n\nFoo\n\n\nBar\n\n\n\n</pre>\n\n\n\n\n',
		'data': [
			{ 'type': 'preformatted', 'internal': { 'whitespace': ['\n', undefined, undefined, '\n\n\n\n\n' ] } },
			'\n',
			'\n',
			'F',
			'o',
			'o',
			'\n',
			'\n',
			'\n',
			'B',
			'a',
			'r',
			'\n',
			'\n',
			'\n',
			'\n',
			{ 'type': '/preformatted' }
		]
	},
	'mismatching whitespace data is ignored': {
		'html': null,
		'data': [
			{ 'type': 'list', 'attributes': { 'style': 'bullet' }, 'internal': { 'whitespace': [ ' ', '  ', '   ', '    ' ] } },
			{ 'type': 'listItem', 'internal': { 'whitespace': [ ' ', '  ', '   ', '    ' ] } },
			{ 'type': 'paragraph', 'internal': { 'whitespace': [ ' ', '\t', '\n', '  ' ] } },
			'A',
			{ 'type': '/paragraph' },
			{ 'type': 'paragraph', 'internal': { 'whitespace': [ '  ' ] } },
			'B',
			{ 'type': '/paragraph' },
			{ 'type': '/listItem' },
			{ 'type': '/list' }
		],
		'normalizedHtml': ' <ul><li><p>\tA\n</p>  <p>B</p></li></ul>    '
	},
	'order of nested annotations is preserved': {
		'html': '<p><b><a rel="mw:WikiLink" href="Foo"><i>Foo</i></a></b></p>',
		'data': [
			{ 'type': 'paragraph' },
			[
				'F',
				[
					ve.dm.example.bold,
					{
						'type': 'link/MWinternal',
						'data': {
							'hrefPrefix': '',
							'title': 'Foo'
						},
						'htmlTagName': 'a',
						'htmlAttributes': {
							'href': 'Foo',
							'rel': 'mw:WikiLink'
						}
					},
					ve.dm.example.italic
				]
			],
			[
				'o',
				[
					ve.dm.example.bold,
					{
						'type': 'link/MWinternal',
						'data': {
							'hrefPrefix': '',
							'title': 'Foo'
						},
						'htmlTagName': 'a',
						'htmlAttributes': {
							'href': 'Foo',
							'rel': 'mw:WikiLink'
						}
					},
					ve.dm.example.italic
				]
			],
			[
				'o',
				[
					ve.dm.example.bold,
					{
						'type': 'link/MWinternal',
						'data': {
							'hrefPrefix': '',
							'title': 'Foo'
						},
						'htmlTagName': 'a',
						'htmlAttributes': {
							'href': 'Foo',
							'rel': 'mw:WikiLink'
						}
					},
					ve.dm.example.italic
				]
			],
			{ 'type': '/paragraph' }
		]
	},
	'nested annotations are closed and reopened in the correct order': {
		'html': '<p><a rel="mw:WikiLink" href="Foo">F<b>o<i>o</i></b><i>b</i></a><i>a<b>r</b>b<u>a</u>z</i></p>',
		'data': [
			{ 'type': 'paragraph' },
			[
				'F',
				[
					{
						'type': 'link/MWinternal',
						'data': {
							'hrefPrefix': '',
							'title': 'Foo'
						},
						'htmlTagName': 'a',
						'htmlAttributes': {
							'href': 'Foo',
							'rel': 'mw:WikiLink'
						}
					}
				]
			],
			[
				'o',
				[
					{
						'type': 'link/MWinternal',
						'data': {
							'hrefPrefix': '',
							'title': 'Foo'
						},
						'htmlTagName': 'a',
						'htmlAttributes': {
							'href': 'Foo',
							'rel': 'mw:WikiLink'
						}
					},
					ve.dm.example.bold
				]
			],
			[
				'o',
				[
					{
						'type': 'link/MWinternal',
						'data': {
							'hrefPrefix': '',
							'title': 'Foo'
						},
						'htmlTagName': 'a',
						'htmlAttributes': {
							'href': 'Foo',
							'rel': 'mw:WikiLink'
						}
					},
					ve.dm.example.bold,
					ve.dm.example.italic
				]
			],
			[
				'b',
				[
					{
						'type': 'link/MWinternal',
						'data': {
							'hrefPrefix': '',
							'title': 'Foo'
						},
						'htmlTagName': 'a',
						'htmlAttributes': {
							'href': 'Foo',
							'rel': 'mw:WikiLink'
						}
					},
					ve.dm.example.italic
				]
			],
			[
				'a',
				[
					ve.dm.example.italic
				]
			],
			[
				'r',
				[
					ve.dm.example.italic,
					ve.dm.example.bold
				]
			],
			[
				'b',
				[
					ve.dm.example.italic
				]
			],
			[
				'a',
				[
					ve.dm.example.italic,
					ve.dm.example.underline
				]
			],
			[
				'z',
				[
					ve.dm.example.italic
				]
			],
			{ 'type': '/paragraph' }
		]
	},
	'document with meta elements': {
		'html': '<meta property="mw:PageProp/nocc" /><p>Foo' +
			'<link rel="mw:WikiLink/Category" href="./Category:Bar" />Bar' +
			'<meta property="mw:foo" content="bar" />Baz</p>' +
			'<meta property="mw:bar" content="baz" />' +
			'<link rel="mw:WikiLink/Category" href="./Category:Foo#Bar baz%23quux" />' +
			'<meta typeof="mw:Placeholder" data-parsoid="foobar" />',
		'data': ve.dm.example.withMeta
	},
	'change markers': {
		'html': null,
		'data': [
			{ 'type': 'paragraph', 'internal': { 'changed': { 'content': 1 } } },
			'F',
			'o',
			'o',
			{ 'type': 'image', 'internal': { 'changed': { 'attributes': 2 } } },
			{ 'type': '/image' },
			{ 'type': '/paragraph' },
			{ 'type': 'paragraph', 'internal': { 'changed': { 'created': 1 } } },
			'B',
			'a',
			'r',
			{ 'type': '/paragraph' },
			{ 'type': 'list', 'attributes': { 'style': 'bullet' } },
			{ 'type': 'listItem' },
			{
				'type': 'paragraph',
				'internal': {
					'generated': 'wrapper',
					'changed': { 'content': 1 }
				}
			},
			'B',
			'a',
			'z',
			{ 'type': '/paragraph' },
			{ 'type': '/listItem' },
			{ 'type': '/list' }
		],
		'normalizedHtml': '<p data-ve-changed="{&quot;content&quot;:1}">' +
				'Foo<img data-ve-changed="{&quot;attributes&quot;:2}" />' +
				'</p><p data-ve-changed="{&quot;created&quot;:1}">Bar</p>' +
				'<ul><li data-ve-changed="{&quot;content&quot;:1}">Baz</li></ul>'
	},
	'about grouping': {
		'html': '<div typeof="mw:Placeholder" about="#mwt1">Foo</div>' +
			'<figure typeof="mw:Placeholder" about="#mwt1">Bar</figure>' +
			'<figure typeof="mw:Placeholder" about="#mwt2">Baz</figure>' +
			'<span typeof="mw:Placeholder" about="#mwt2">Quux</span>' +
			'<p>Whee</p><span typeof="mw:Placeholder" about="#mwt2">Yay</span>' +
			'<div typeof="mw:Placeholder" about="#mwt2">Blah</div>' +
			'<span typeof="mw:Placeholder" about="#mwt3">Meh</span>',
		'data': [
			{
				'type': 'alienBlock',
				'attributes': {
					'html': '<div typeof="mw:Placeholder" about="#mwt1">Foo</div>' +
						'<figure typeof="mw:Placeholder" about="#mwt1">Bar</figure>'
				}
			},
			{ 'type': '/alienBlock' },
			{
				'type': 'alienBlock',
				'attributes': {
					'html': '<figure typeof="mw:Placeholder" about="#mwt2">Baz</figure>' +
						'<span typeof="mw:Placeholder" about="#mwt2">Quux</span>'
				}
			},
			{ 'type': '/alienBlock' },
			{ 'type': 'paragraph' },
			'W',
			'h',
			'e',
			'e',
			{ 'type': '/paragraph' },
			{
				'type': 'alienBlock',
				'attributes': {
					'html': '<span typeof="mw:Placeholder" about="#mwt2">Yay</span>' +
						'<div typeof="mw:Placeholder" about="#mwt2">Blah</div>'
				}
			},
			{ 'type': '/alienBlock' },
			{
				'type': 'alienBlock',
				'attributes': {
					'html': '<span typeof="mw:Placeholder" about="#mwt3">Meh</span>'
				}
			},
			{ 'type': '/alienBlock' }
		]
	},
	'whitespace preservation with an about group': {
		'html': ' <div typeof="mw:Placeholder" about="#mwt1">\tFoo\t\t</div>\t\t\t' +
			'<div typeof="mw:Placeholder" about="#mwt1">  Bar   </div>    ',
		'data': [
			{
				'type': 'alienBlock',
				'attributes': {
					'html': '<div typeof="mw:Placeholder" about="#mwt1">\tFoo\t\t</div>\t\t\t' +
						'<div typeof="mw:Placeholder" about="#mwt1">  Bar   </div>'
				},
				'internal': {
					'whitespace': [ ' ', undefined, undefined, '    ' ]
				}
			},
			{ 'type': '/alienBlock' }
		]
	}
};
