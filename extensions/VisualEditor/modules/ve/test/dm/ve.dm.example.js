/*!
 * VisualEditor DataModel example data sets.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * @class
 * @singleton
 * @ignore
 */
ve.dm.example = {};

/* Methods */

/**
 * Convert arrays of shorthand annotations in a data fragment to AnnotationSets with real
 * annotation objects, and wraps the result in a ve.dm.ElementLinearData object.
 *
 * Shorthand notation for annotations is:
 * [ 'a', [ { 'type': 'link', 'attributes': { 'href': '...' } ] ]
 *
 * The actual storage format has an instance of ve.dm.LinkAnnotation instead of the plain object,
 * and an instance of ve.dm.AnnotationSet instead of the array.
 *
 * @method
 * @param {Array} data Linear model data
 * @param {ve.dm.IndexValueStore} [store] Index-value store to use, creates one if undefined
 * @returns {ve.dm.ElementLinearData} Element linear data store
 * @throws {Error} Example data passed to preprocessAnnotations by reference
 */
ve.dm.example.preprocessAnnotations = function ( data, store ) {
	var i, key;

	// Sanity check to make sure ve.dm.example data has not been passed in
	// by reference. Always use ve#copy.
	for ( i in ve.dm.example ) {
		if ( data === ve.dm.example[i] ) {
			throw new Error( 'Example data passed to preprocessAnnotations by reference' );
		}
	}

	store = store || new ve.dm.IndexValueStore();
	for ( i = 0; i < data.length; i++ ) {
		key = data[i].annotations ? 'annotations' : 1;
		// check for shorthand annotation objects in array
		if ( ve.isArray( data[i][key] ) && data[i][key][0].type ) {
			data[i][key] = ve.dm.example.createAnnotationSet( store, data[i][key] ).getIndexes();
		}
	}
	return new ve.dm.ElementLinearData( store, data );
};

/**
 * Create an annotation object from shorthand notation.
 * @method
 * @param {Object} annotation Plain object with type and attributes properties
 * @returns {ve.dm.Annotation} Instance of the right ve.dm.Annotation subclass
 */
ve.dm.example.createAnnotation = function ( annotation ) {
	return ve.dm.annotationFactory.create( annotation.type, annotation );
};

/**
 * Create an AnnotationSet from an array of shorthand annotations.
 *
 * This calls ve.dm.example.createAnnotation() for each element and puts the result in an
 * AnnotationSet.
 *
 * @method
 * @param {Array} annotations Array of annotations in shorthand format
 * @returns {ve.dm.AnnotationSet}
 */
ve.dm.example.createAnnotationSet = function ( store, annotations ) {
	var i;
	for ( i = 0; i < annotations.length; i++ ) {
		annotations[i] = ve.dm.example.createAnnotation( annotations[i] );
	}
	return new ve.dm.AnnotationSet( store, store.indexes( annotations ) );
};

/* Some common annotations in shorthand format */
ve.dm.example.bold = { 'type': 'textStyle/bold', 'attributes': { 'nodeName': 'b' } };
ve.dm.example.italic = { 'type': 'textStyle/italic', 'attributes': { 'nodeName': 'i' } };
ve.dm.example.underline = { 'type': 'textStyle/underline', 'attributes': { 'nodeName': 'u' } };
ve.dm.example.span = { 'type': 'textStyle/span', 'attributes': { 'nodeName': 'span' } };
ve.dm.example.big = { 'type': 'textStyle/big', 'attributes': { 'nodeName': 'big' } };
ve.dm.example.code = { 'type': 'textStyle/code', 'attributes': { 'nodeName': 'code' } };
ve.dm.example.tt = { 'type': 'textStyle/code', 'attributes': { 'nodeName': 'tt' } };

/**
 * Creates a document from example data.
 *
 * Defaults to ve.dm.example.data if no name is supplied.
 *
 * @param {string} [name='data'] Named element of ve.dm.example
 * @param {ve.dm.IndexValueStore} [store] A specific index-value store to use, optionally.
 * @returns {ve.dm.Document} Document
 * @throws {Error} Example data not found
 */
ve.dm.example.createExampleDocument = function ( name, store ) {
	return ve.dm.example.createExampleDocumentFromObject( name, store, ve.dm.example );
};

/**
 * Helper function for ve.dm.createExampleDocument.
 *
 * @param {string} [name='data'] Named element of ve.dm.example
 * @param {ve.dm.IndexValueStore} [store] A specific index-value store to use, optionally.
 * @param {Object} [object] Collection of test documents, keyed by name
 * @returns {ve.dm.Document} Document
 * @throws {Error} Example data not found
 */
ve.dm.example.createExampleDocumentFromObject = function ( name, store, object ) {
	var doc, i;
	name = name || 'data';
	store = store || new ve.dm.IndexValueStore();
	if ( object[name] === undefined ) {
		throw new Error( 'Example data \'' + name + '\' not found' );
	}
	doc = new ve.dm.Document(
		ve.dm.example.preprocessAnnotations( ve.copy( object[name] ), store )
	);
	// HACK internalList isn't populated when creating a document from data
	if ( object[name].internalItems ) {
		for ( i = 0; i < object[name].internalItems.length; i++ ) {
			doc.internalList.queueItemHtml(
				object[name].internalItems[i].group,
				object[name].internalItems[i].key,
				object[name].internalItems[i].body
			);
		}
	}
	return doc;
};

/**
 * Looks up a value in a node tree.
 *
 * @method
 * @param {ve.Node} root Root node to lookup from
 * @param {number...} [paths] Index path
 * @returns {ve.Node} Node at given path
 */
ve.dm.example.lookupNode = function ( root ) {
	var i,
		node = root;
	for ( i = 1; i < arguments.length; i++ ) {
		node = node.children[arguments[i]];
	}
	return node;
};

ve.dm.example.createDomElement = function ( type, attributes ) {
	var key,
		element = document.createElement( type );
	for ( key in attributes ) {
		element.setAttribute( key, attributes[key] );
	}
	return element;
};

ve.dm.example.testDir = window.VE_TESTDIR || '.';

ve.dm.example.imgSrc = ve.dm.example.testDir + '/example.png';

ve.dm.example.image = {
	html: '<img src="' + ve.dm.example.imgSrc + '" alt="Example" width="100" height="50">',
	data: {
		'type': 'image',
		'attributes' : {
			'src': ve.dm.example.imgSrc,
			'alt': 'Example',
			'width': 100,
			'height': 50
		},
		'htmlAttributes': [ { 'values': {
			'src': ve.dm.example.imgSrc,
			'alt': 'Example',
			'width': '100',
			'height': '50'
		} } ]
	}
};

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
	'<pre>h' + ve.dm.example.image.html + 'i</pre>'+
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
 *     {string} Plain text character
 *
 *     {Array} Annotated character
 *         0: {string} Character
 *         1: {Object} List of references to immutable annotation objects, keyed by JSON
 *            serializations of their values (hashes)
 *
 *     {Object} Opening or closing structural element
 *         type: {string} Symbolic node type name, if closing element first character will be "/"
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
	// 32 - End of lis t
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
	ve.dm.example.image.data,
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
	{ 'type': '/paragraph' },
	// 61 - Beginning of internalList
	{ 'type': 'internalList' },
	// 62 - End of internalList
	{ 'type': '/internalList' }
	// 63 - End of document
];

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
	{ 'type': '/alienBlock' },
	// 10 - Beginning of internalList
	{ 'type': 'internalList' },
	// 11 - End of internalList
	{ 'type': '/internalList' }
	// 12 - End of document
];

ve.dm.example.internalData = [
	{ 'type': 'paragraph' },
	'F', 'o', 'o',
	{ 'type': '/paragraph' },
	{ 'type': 'internalList' },
	{ 'type': 'internalItem' },
	{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
	'B', 'a', 'r',
	{ 'type': '/paragraph' },
	{ 'type': '/internalItem' },
	{ 'type': 'internalItem' },
	{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
	'B', 'a', 'z',
	{ 'type': '/paragraph' },
	{ 'type': '/internalItem' },
	{ 'type': '/internalList' },
	{ 'type': 'paragraph' },
	'Q', 'u', 'u', 'x',
	{ 'type': '/paragraph' }
];

ve.dm.example.internalData.internalItems = [
	{ 'group': 'test', 'key': 'bar', 'body': 'Bar' },
	{ 'group': 'test', 'key': 'baz', 'body': 'Baz' }
];

ve.dm.example.withMeta = [
	{
		'type': 'alienMeta',
		'attributes': {
			'domElements': $( '<!-- No content conversion -->' ).toArray()
		}
	},
	{ 'type': '/alienMeta' },
	{
		'type': 'alienMeta',
		'attributes': {
			'domElements': $( '<meta property="foo" />' ).toArray()
		}
	},
	{ 'type': '/alienMeta' },
	{ 'type': 'paragraph' },
	'F',
	'o',
	'o',
	{
		'type': 'alienMeta',
		'attributes': {
			'domElements': $( '<link rel="bar" href="baz" />' ).toArray()
		}
	},
	{ 'type': '/alienMeta' },
	'B',
	'a',
	'r',
	{
		'type': 'alienMeta',
		'attributes': {
			'domElements': $( '<meta property="foo" content="bar" />' ).toArray()
		}
	},
	{ 'type': '/alienMeta' },
	'B',
	'a',
	{
		'type': 'alienMeta',
		'attributes': {
			'domElements': $( '<!-- inline -->' ).toArray()
		}
	},
	{ 'type': '/alienMeta' },
	'z',
	{ 'type': '/paragraph' },
	{
		'type': 'alienMeta',
		'attributes': {
			'domElements': $( '<meta property="bar" content="baz" />' ).toArray()
		}
	},
	{ 'type': '/alienMeta' },
	{
		'type': 'alienMeta',
		'attributes': {
			'domElements': $( '<!--barbaz-->' ).toArray()
		}
	},
	{ 'type': '/alienMeta' },
	{
		'type': 'alienMeta',
		'attributes': {
			'domElements': $( '<link rel="foofoo" href="barbar" />' ).toArray()
		}
	},
	{ 'type': '/alienMeta' },
	{
		'type': 'alienMeta',
		'attributes': {
			'domElements': $( '<meta typeof=bazquux" data-foo="foobar" />' ).toArray()
		}
	},
	{ 'type': '/alienMeta' },
	{ 'type': 'internalList' },
	{ 'type': '/internalList' }
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
	{ 'type': '/paragraph' },
	{ 'type': 'internalList' },
	{ 'type': '/internalList' }
];

ve.dm.example.withMetaMetaData = [
	[
		{
			'type': 'alienMeta',
			'attributes': {
				'domElements': $( '<!-- No content conversion -->' ).toArray()
			}
		},
		{
			'type': 'alienMeta',
			'attributes': {
				'domElements': $( '<meta property="foo" />' ).toArray()
			}
		}
	],
	undefined,
	undefined,
	undefined,
	[
		{
			'type': 'alienMeta',
			'attributes': {
				'domElements': $( '<link rel="bar" href="baz" />' ).toArray()
			}
		}
	],
	undefined,
	undefined,
	[
		{
			'type': 'alienMeta',
			'attributes': {
				'domElements': $( '<meta property="foo" content="bar" />' ).toArray()
			}
		}
	],
	undefined,
	[
		{
			'type': 'alienMeta',
			'attributes': {
				'domElements': $( '<!-- inline -->' ).toArray()
			}
		}
	],
	undefined,
	[
		{
			'type': 'alienMeta',
			'attributes': {
				'domElements': $( '<meta property="bar" content="baz" />' ).toArray()
			}
		},
		{
			'type': 'alienMeta',
			'attributes': {
				'domElements': $( '<!--barbaz-->' ).toArray()
			}
		},
		{
		'type': 'alienMeta',
			'attributes': {
				'domElements': $( '<link rel="foofoo" href="barbar" />' ).toArray()
			}
		},
		{
			'type': 'alienMeta',
			'attributes': {
				'domElements': $( '<meta typeof=bazquux" data-foo="foobar" />' ).toArray()
			}
		}
	],
	undefined,
	undefined
];


ve.dm.example.listWithMeta = [
	//  0 - Beginning of list
	{
		'type': 'alienMeta',
		'attributes': {
			'domElements': $( '<meta property="one" />' ).toArray()
		}
	},
	{ 'type': '/alienMeta' },
	{ 'type': 'list' },
	//  1 - Beginning of first list item
	{
		'type': 'alienMeta',
		'attributes': {
			'domElements': $( '<meta property="two" />' ).toArray()
		}
	},
	{ 'type': '/alienMeta' },
	{ 'type': 'listItem', 'attributes': { 'styles': ['bullet'] } },
	//  2 - Beginning of paragraph
	{
		'type': 'alienMeta',
		'attributes': {
			'domElements': $( '<meta property="three" />' ).toArray()
		}
	},
	{ 'type': '/alienMeta' },
	{ 'type': 'paragraph' },
	//  3 - Plain "a"
	{
		'type': 'alienMeta',
		'attributes': {
			'domElements': $( '<meta property="four" />' ).toArray()
		}
	},
	{ 'type': '/alienMeta' },
	'a',
	//  4 - End of paragraph
	{
		'type': 'alienMeta',
		'attributes': {
			'domElements': $( '<meta property="five" />' ).toArray()
		}
	},
	{ 'type': '/alienMeta' },
	{ 'type': '/paragraph' },
	//  5 - End of first list item
	{
		'type': 'alienMeta',
		'attributes': {
			'domElements': $( '<meta property="six" />' ).toArray()
		}
	},
	{ 'type': '/alienMeta' },
	{ 'type': '/listItem' },
	//  6 - Beginning of second list item
	{
		'type': 'alienMeta',
		'attributes': {
			'domElements': $( '<meta property="seven" />' ).toArray()
		}
	},
	{ 'type': '/alienMeta' },
	{ 'type': 'listItem', 'attributes': { 'styles': ['bullet'] } },
	//  7 - Beginning of paragraph
	{
		'type': 'alienMeta',
		'attributes': {
			'domElements': $( '<meta property="eight" />' ).toArray()
		}
	},
	{ 'type': '/alienMeta' },
	{ 'type': 'paragraph' },
	//  8 - Plain "b"
	{
		'type': 'alienMeta',
		'attributes': {
			'domElements': $( '<meta property="nine" />' ).toArray()
		}
	},
	{ 'type': '/alienMeta' },
	'b',
	//  9 - End of paragraph
	{
		'type': 'alienMeta',
		'attributes': {
			'domElements': $( '<meta property="ten" />' ).toArray()
		}
	},
	{ 'type': '/alienMeta' },
	{ 'type': '/paragraph' },
	// 10 - End of second list item
	{
		'type': 'alienMeta',
		'attributes': {
			'domElements': $( '<meta property="eleven" />' ).toArray()
		}
	},
	{ 'type': '/alienMeta' },
	{ 'type': '/listItem' },
	// 11 - End of list
	{
		'type': 'alienMeta',
		'attributes': {
			'domElements': $( '<meta property="twelve" />' ).toArray()
		}
	},
	{ 'type': '/alienMeta' },
	{ 'type': '/list' },
	// 12 - Trailing metadata
	{
		'type': 'alienMeta',
		'attributes': {
			'domElements': $( '<meta property="thirteen" />' ).toArray()
		}
	},
	{ 'type': '/alienMeta' }
];


ve.dm.example.complexTableHtml = '<table><caption>Foo</caption><thead><tr><th>Bar</th></tr></thead>' +
	'<tfoot><tr><td>Baz</td></tr></tfoot><tbody><tr><td>Quux</td><td>Whee</td></tr></tbody></table>';

ve.dm.example.complexTable = [
	{ 'type': 'table' },
	{ 'type': 'tableCaption' },
	{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
	'F',
	'o',
	'o',
	{ 'type': '/paragraph' },
	{ 'type': '/tableCaption' },
	{ 'type': 'tableSection', 'attributes': { 'style': 'header' } },
	{ 'type': 'tableRow' },
	{ 'type': 'tableCell', 'attributes': { 'style': 'header' } },
	{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
	'B',
	'a',
	'r',
	{ 'type': '/paragraph' },
	{ 'type': '/tableCell' },
	{ 'type': '/tableRow' },
	{ 'type': '/tableSection' },
	{ 'type': 'tableSection', 'attributes': { 'style': 'footer' } },
	{ 'type': 'tableRow' },
	{ 'type': 'tableCell', 'attributes': { 'style': 'data' } },
	{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
	'B',
	'a',
	'z',
	{ 'type': '/paragraph' },
	{ 'type': '/tableCell' },
	{ 'type': '/tableRow' },
	{ 'type': '/tableSection' },
	{ 'type': 'tableSection', 'attributes': { 'style': 'body' } },
	{ 'type': 'tableRow' },
	{ 'type': 'tableCell', 'attributes': { 'style': 'data' } },
	{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
	'Q',
	'u',
	'u',
	'x',
	{ 'type': '/paragraph' },
	{ 'type': '/tableCell' },
	{ 'type': 'tableCell', 'attributes': { 'style': 'data' } },
	{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
	'W',
	'h',
	'e',
	'e',
	{ 'type': '/paragraph' },
	{ 'type': '/tableCell' },
	{ 'type': '/tableRow' },
	{ 'type': '/tableSection' },
	{ 'type': '/table' },
	{ 'type': 'internalList' },
	{ 'type': '/internalList' }
];

ve.dm.example.inlineAtEdges = [
	{ 'type': 'paragraph' },
	ve.dm.example.image.data,
	{ 'type': '/image' },
	'F',
	'o',
	'o',
	{ 'type': 'alienInline', 'attributes': { 'domElements': $( '<foobar />' ).toArray() } },
	{ 'type': '/alienInline' },
	{ 'type': '/paragraph' }
];

ve.dm.example.emptyBranch = [
	{ 'type': 'table' },
	{ 'type': '/table' }
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
	new ve.dm.HeadingNode( [new ve.dm.TextNode( 3 )], ve.dm.example.data[0] ),
	new ve.dm.TableNode( [
		new ve.dm.TableSectionNode( [
			new ve.dm.TableRowNode( [
				new ve.dm.TableCellNode( [
					// Paragraph with "d"
					new ve.dm.ParagraphNode( [new ve.dm.TextNode( 1 )],
						ve.dm.example.data[9] ),
					new ve.dm.ListNode( [
						// 1st level bullet list item with "e"
						new ve.dm.ListItemNode( [
							new ve.dm.ParagraphNode(
								[new ve.dm.TextNode( 1 )],
								ve.dm.example.data[14]
							),
							new ve.dm.ListNode( [
								// 2nd level bullet list item with "f"
								new ve.dm.ListItemNode( [
									new ve.dm.ParagraphNode(
										[new ve.dm.TextNode( 1 )],
										ve.dm.example.data[19]
									)
								], ve.dm.example.data[18] )
							], ve.dm.example.data[17] )
						], ve.dm.example.data[13] )
					], ve.dm.example.data[12] ),
					new ve.dm.ListNode( [
						// Numbered list item with "g"
						new ve.dm.ListItemNode( [
							new ve.dm.ParagraphNode(
								[new ve.dm.TextNode( 1 )],
								ve.dm.example.data[28]
							)
						], ve.dm.example.data[27] )
					], ve.dm.example.data[26] )
				], ve.dm.example.data[8] )
			], ve.dm.example.data[7] )
		], ve.dm.example.data[6] )
	], ve.dm.example.data[5] ),
	// Preformatted with "h[example.png]i"
	new ve.dm.PreformattedNode( [
		new ve.dm.TextNode( 1 ),
		new ve.dm.ImageNode( [], ve.dm.example.data[39] ),
		new ve.dm.TextNode( 1 )
	], ve.dm.example.data[37] ),
	new ve.dm.DefinitionListNode( [
		// Definition list term item with "j"
		new ve.dm.DefinitionListItemNode( [
			new ve.dm.ParagraphNode( [new ve.dm.TextNode( 1 )], ve.dm.example.data[45] )
		], ve.dm.example.data[44] ),
		// Definition list definition item with "k"
		new ve.dm.DefinitionListItemNode( [
			new ve.dm.ParagraphNode( [new ve.dm.TextNode( 1 )], ve.dm.example.data[50] )
		], ve.dm.example.data[49] )
	], ve.dm.example.data[43] ),
	new ve.dm.ParagraphNode( [new ve.dm.TextNode( 1 )], ve.dm.example.data[55] ),
	new ve.dm.ParagraphNode( [new ve.dm.TextNode( 1 )], ve.dm.example.data[58] ),
	new ve.dm.InternalListNode( [], ve.dm.example.data[61] )
] );

ve.dm.example.conversions = {
	'definitionListItem term': {
		'domElement': ve.dm.example.createDomElement( 'dt' ),
		'dataElement': { 'type': 'definitionListItem', 'attributes': { 'style': 'term' } }
	},
	'definitionListItem definition': {
		'domElement': ve.dm.example.createDomElement( 'dd' ),
		'dataElement': { 'type': 'definitionListItem', 'attributes': { 'style': 'definition' } }
	},
	'definitionList definition': {
		'domElement': ve.dm.example.createDomElement( 'dl' ),
		'dataElement': { 'type': 'definitionList' }
	},
	'heading level 1': {
		'domElement': ve.dm.example.createDomElement( 'h1' ),
		'dataElement': { 'type': 'heading', 'attributes': { 'level': 1 } }
	},
	'heading level 2': {
		'domElement': ve.dm.example.createDomElement( 'h2' ),
		'dataElement': { 'type': 'heading', 'attributes': { 'level': 2 } }
	},
	'heading level 3': {
		'domElement': ve.dm.example.createDomElement( 'h3' ),
		'dataElement': { 'type': 'heading', 'attributes': { 'level': 3 } }
	},
	'heading level 4': {
		'domElement': ve.dm.example.createDomElement( 'h4' ),
		'dataElement': { 'type': 'heading', 'attributes': { 'level': 4 } }
	},
	'heading level 5': {
		'domElement': ve.dm.example.createDomElement( 'h5' ),
		'dataElement': { 'type': 'heading', 'attributes': { 'level': 5 } }
	},
	'heading level 6': {
		'domElement': ve.dm.example.createDomElement( 'h6' ),
		'dataElement': { 'type': 'heading', 'attributes': { 'level': 6 } }
	},
	'image': {
		'domElement': ve.dm.example.createDomElement( 'img' ),
		'dataElement': { 'type': 'image' }
	},
	'listItem': {
		'domElement': ve.dm.example.createDomElement( 'li' ),
		'dataElement': { 'type': 'listItem' }
	},
	'list bullet': {
		'domElement': ve.dm.example.createDomElement( 'ul' ),
		'dataElement': { 'type': 'list', 'attributes': { 'style': 'bullet' } }
	},
	'list number': {
		'domElement': ve.dm.example.createDomElement( 'ol' ),
		'dataElement': { 'type': 'list', 'attributes': { 'style': 'number' } }
	},
	'paragraph': {
		'domElement': ve.dm.example.createDomElement( 'p' ),
		'dataElement': { 'type': 'paragraph' }
	},
	'preformatted': {
		'domElement': ve.dm.example.createDomElement( 'pre' ),
		'dataElement': { 'type': 'preformatted' }
	},
	'tableCell': {
		'domElement': ve.dm.example.createDomElement( 'td' ),
		'dataElement': { 'type': 'tableCell', 'attributes': { 'style': 'data' } }
	},
	'table': {
		'domElement': ve.dm.example.createDomElement( 'table' ),
		'dataElement': { 'type': 'table' }
	},
	'tableRow': {
		'domElement': ve.dm.example.createDomElement( 'tr' ),
		'dataElement': { 'type': 'tableRow' }
	},
	'paragraph with data-mw attribute': {
		'domElement': ve.dm.example.createDomElement( 'p', { 'data-mw': '{"test":1234}' } ),
		'dataElement': {
			'type': 'paragraph',
			'htmlAttributes': [ { 'values': { 'data-mw': '{"test":1234}' } } ]
		}
	},
	'paragraph with style attribute': {
		'domElement': ve.dm.example.createDomElement( 'p', { 'style': 'color:blue' } ),
		'dataElement': {
			'type': 'paragraph',
			'htmlAttributes': [ { 'values': { 'style': 'color:blue' } } ]
		}
	}
};

ve.dm.example.domToDataCases = {
	'paragraph with plain text': {
		'html': '<body><p>abc</p></body>',
		'data': [
			{ 'type': 'paragraph' },
			'a',
			'b',
			'c',
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'annotated text with bold, italic, underline formatting': {
		'html': '<body><p><b>a</b><i>b</i><u>c</u></p></body>',
		'data': [
			{ 'type': 'paragraph' },
			['a', [ ve.dm.example.bold ]],
			['b', [ ve.dm.example.italic ]],
			['c', [ ve.dm.example.underline ]],
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'equivalent annotations': {
		'html': '<body><p><code>a</code>b<tt>c</tt>d<code>e</code><tt>f</tt></body>',
		'data': [
			{ 'type': 'paragraph' },
			['a', [ ve.dm.example.code ]],
			'b',
			['c', [ ve.dm.example.tt ]],
			'd',
			['e', [ ve.dm.example.code ]],
			['f', [ ve.dm.example.tt ]],
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		],
		'normalizedHtml': '<body><p><code>a</code>b<tt>c</tt>d<code>ef</code></body>'
	},
	'additive annotations': {
		'html': '<body><p><big>a<big>b</big>c</big><b>d<b>e</b>f</b></p></body>',
		'data': [
			{ 'type': 'paragraph' },
			['a', [ ve.dm.example.big ]],
			['b', [ ve.dm.example.big, ve.dm.example.big ]],
			['c', [ ve.dm.example.big ]],
			['d', [ ve.dm.example.bold ]],
			['e', [ ve.dm.example.bold, ve.dm.example.bold ]],
			['f', [ ve.dm.example.bold ]],
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'additive annotations overlapping other annotations': {
		'html': '<body><p><i><big>a<big><b>b</b></big><b>c</b></big></i></p></body>',
		'data': [
			{ 'type': 'paragraph' },
			['a', [ ve.dm.example.italic, ve.dm.example.big ]],
			['b', [ ve.dm.example.italic, ve.dm.example.big, ve.dm.example.big, ve.dm.example.bold ]],
			['c', [ ve.dm.example.italic, ve.dm.example.big, ve.dm.example.bold ]],
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'strip leading whitepsace in paragraphs': {
		'data': [
			{ 'type': 'paragraph' },
			' ', 'f', 'o', 'o',
			{ 'type': '/paragraph' },
			{ 'type': 'paragraph' },
			' ', '\t', ' ', '\t', 'b', 'a', 'r',
			{ 'type': '/paragraph' },
			{ 'type': 'heading', 'attributes': { 'level': 2 } },
			' ', ' ', 'b', 'a', 'z',
			{ 'type': '/heading' },
			{ 'type': 'preformatted' },
			' ', '\t', 'q', 'u', 'u', 'x',
			{ 'type': '/preformatted' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		],
		'normalizedHtml': '<body><p>foo</p><p>bar</p><h2>baz</h2><pre> \tquux</pre></body>'
	},
	'image': {
		'html': '<body>' + ve.dm.example.image.html + '</body>',
		'data': [
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			ve.dm.example.image.data,
			{ 'type' : '/image' },
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'paragraph with alienInline inside': {
		'html': '<body><p>a<foobar class="foo">b</foobar>c</p></body>',
		'data': [
			{ 'type': 'paragraph' },
			'a',
			{
				'type': 'alienInline',
				'attributes': { 'domElements': $( '<foobar class="foo">b</foobar>' ).toArray() }
			},
			{ 'type': '/alienInline' },
			'c',
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'paragraphs with an alienBlock between them': {
		'html': '<body><p>abc</p><figure>abc</figure><p>def</p></body>',
		'data': [
			{ 'type': 'paragraph' },
			'a',
			'b',
			'c',
			{ 'type': '/paragraph' },
			{ 'type': 'alienBlock', 'attributes': { 'domElements': $( '<figure>abc</figure>' ).toArray() } },
			{ 'type': '/alienBlock' },
			{ 'type': 'paragraph' },
			'd',
			'e',
			'f',
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'annotated inline nodes': {
		'html': '<body><p>a<b><foobar class="foo">b</foobar><i><foobar class="bar">c</foobar></i></b>' +
			'<i><br/>d</i>e</p></body>',
		'data': [
			{ 'type': 'paragraph' },
			'a',
			{
				'type': 'alienInline',
				'attributes': { 'domElements': $( '<foobar class="foo">b</foobar>' ).toArray() },
				'annotations': [ ve.dm.example.bold ]
			},
			{ 'type': '/alienInline' },
			{
				'type': 'alienInline',
				'attributes': { 'domElements': $( '<foobar class="bar">c</foobar>' ).toArray() },
				'annotations': [ ve.dm.example.bold, ve.dm.example.italic ]
			},
			{ 'type': '/alienInline' },
			{
				'type': 'break',
				'annotations': [ ve.dm.example.italic ]
			},
			{ 'type': '/break' },
			['d', [ ve.dm.example.italic ]],
			'e',
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'annotated metadata': {
		'html': '<body><p><b><!--foo-->bar<!--baz--></b></p></body>',
		'data': [
			{ 'type': 'paragraph' },
			{
				'type': 'alienMeta',
				'annotations': [ ve.dm.example.bold ],
				'attributes': {
					'domElements': $( '<!--foo-->' ).toArray()
				}
			},
			{ 'type': '/alienMeta' },
			[ 'b', [ ve.dm.example.bold ] ],
			[ 'a', [ ve.dm.example.bold ] ],
			[ 'r', [ ve.dm.example.bold ] ],
			{
				'type': 'alienMeta',
				'annotations': [ ve.dm.example.bold ],
				'attributes': {
					'domElements': $( '<!--baz-->' ).toArray()
				}
			},
			{ 'type': '/alienMeta' },
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'annotated comment metadata in a wrapper': {
		'html': '<body><b><!--foo-->bar<!--baz-->quux<!--whee--></b></body>',
		'data': [
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			{
				'type': 'alienMeta',
				'annotations': [ ve.dm.example.bold ],
				'attributes': {
					'domElements': $( '<!--foo-->' ).toArray()
				}
			},
			{ 'type': '/alienMeta' },
			[ 'b', [ ve.dm.example.bold ] ],
			[ 'a', [ ve.dm.example.bold ] ],
			[ 'r', [ ve.dm.example.bold ] ],
			{
				'type': 'alienMeta',
				'annotations': [ ve.dm.example.bold ],
				'attributes': {
					'domElements': $( '<!--baz-->' ).toArray()
				}
			},
			{ 'type': '/alienMeta' },
			[ 'q', [ ve.dm.example.bold ] ],
			[ 'u', [ ve.dm.example.bold ] ],
			[ 'u', [ ve.dm.example.bold ] ],
			[ 'x', [ ve.dm.example.bold ] ],
			{
				'type': 'alienMeta',
				'annotations': [ ve.dm.example.bold ],
				'attributes': {
					'domElements': $( '<!--whee-->' ).toArray()
				}
			},
			{ 'type': '/alienMeta' },
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'annotated element metadata in a wrapper with content': {
		'html': '<body><b><link />foo<link /></b></body>',
		'data': [
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			{
				'type': 'alienMeta',
				'annotations': [ ve.dm.example.bold ],
				'attributes': {
					'domElements': $( '<link />' ).toArray()
				}
			},
			{ 'type': '/alienMeta' },
			[ 'f', [ ve.dm.example.bold ] ],
			[ 'o', [ ve.dm.example.bold ] ],
			[ 'o', [ ve.dm.example.bold ] ],
			{
				'type': 'alienMeta',
				'annotations': [ ve.dm.example.bold ],
				'attributes': {
					'domElements': $( '<link />' ).toArray()
				}
			},
			{ 'type': '/alienMeta' },
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'comment metadata in a wrapper followed by annotated text': {
		'html': '<body>Foo<!--bar--><b>Baz</b></body>',
		'data': [
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			'F',
			'o',
			'o',
			{
				'type': 'alienMeta',
				'attributes': {
					'domElements': $( '<!--bar-->' ).toArray()
				}
			},
			{ 'type': '/alienMeta' },
			[ 'B', [ ve.dm.example.bold ] ],
			[ 'a', [ ve.dm.example.bold ] ],
			[ 'z', [ ve.dm.example.bold ] ],
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'wrapping of bare content': {
		'html': '<body>abc</body>',
		'data': [
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			'a',
			'b',
			'c',
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'wrapping of bare content with inline node': {
		'html': '<body>1<br/>2</body>',
		'data': [
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			'1',
			{ 'type': 'break' },
			{ 'type': '/break' },
			'2',
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'wrapping of bare content starting with inline node': {
		'html': '<body>' + ve.dm.example.image.html + '12</body>',
		'data': [
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			ve.dm.example.image.data,
			{ 'type': '/image' },
			'1',
			'2',
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'wrapping of bare content with inline alien': {
		'html': '<body>1<foobar class="bar">baz</foobar>2</body>',
		'data': [
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			'1',
			{
				'type': 'alienInline',
				'attributes': { 'domElements': $( '<foobar class="bar">baz</foobar>' ).toArray() }
			},
			{ 'type': '/alienInline' },
			'2',
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'wrapping of bare content with block alien': {
		'html': '<body>1<figure class="bar">baz</figure>2</body>',
		'data': [
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			'1',
			{ 'type': '/paragraph' },
			{
				'type': 'alienBlock',
				'attributes': { 'domElements': $( '<figure class="bar">baz</figure>' ).toArray() }
			},
			{ 'type': '/alienBlock' },
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			'2',
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'wrapping of bare content starting with inline alien': {
		'html': '<body><foobar class="bar">Foo</foobar>Bar</body>',
		'data': [
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			{
				'type': 'alienInline',
				'attributes': { 'domElements': $( '<foobar class="bar">Foo</foobar>' ).toArray() }
			},
			{ 'type': '/alienInline' },
			'B',
			'a',
			'r',
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'wrapping of bare content ending with inline alien': {
		'html': '<body>Foo<foobar class="bar">Bar</foobar></body>',
		'data': [
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			'F',
			'o',
			'o',
			{
				'type': 'alienInline',
				'attributes': { 'domElements': $( '<foobar class="bar">Bar</foobar>' ).toArray() }
			},
			{ 'type': '/alienInline' },
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'wrapping of bare content with about group': {
		'html': '<body>1<foobar about="#mwt1">foo</foobar><foobar about="#mwt1">bar</foobar>2</body>',
		'data': [
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			'1',
			{
				'type': 'alienInline',
				'attributes': { 'domElements': $( '<foobar about="#mwt1">foo</foobar><foobar about="#mwt1">bar</foobar>' ).toArray() }
			},
			{ 'type': '/alienInline' },
			'2',
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'wrapping of bare content between structural nodes': {
		'html': '<body><table></table>abc<table></table></body>',
		'data': [
			{ 'type': 'table' },
			{ 'type': '/table' },
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			'a',
			'b',
			'c',
			{ 'type': '/paragraph' },
			{ 'type': 'table' },
			{ 'type': '/table' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'wrapping of bare content between paragraphs': {
		'html': '<body><p>abc</p>def<p></p></body>',
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
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'wrapping prevents empty list items': {
		'html': '<body><ul><li></li></ul></body>',
		'data': [
			{ 'type': 'list', 'attributes': { 'style': 'bullet' } },
			{ 'type': 'listItem' },
			{ 'type': 'paragraph', 'internal': { 'generated': 'empty' } },
			{ 'type': '/paragraph' },
			{ 'type': '/listItem' },
			{ 'type': '/list' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'empty document': {
		'html': '',
		'data': [
			{ 'type': 'paragraph', 'internal': { 'generated': 'empty' } },
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'empty document with meta': {
		'html': '<body><!-- comment --></body>',
		'data': [
			{
				'type': 'alienMeta',
				'attributes': {
					'domElements': $( '<!-- comment -->' ).toArray()
				}
			},
			{ 'type': '/alienMeta' },
			{ 'type': 'paragraph', 'internal': { 'generated': 'empty' } },
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'empty document with content added by the editor': {
		'data': [
			{ 'type': 'paragraph', 'internal': { 'generated': 'empty' } },
			'F',
			'o',
			'o',
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		],
		'normalizedHtml': '<body><p>Foo</p></body>'
	},
	'empty list item with content added by the editor': {
		'data': [
			{ 'type': 'list', 'attributes': { 'style': 'bullet' } },
			{ 'type': 'listItem' },
			{ 'type': 'paragraph', 'internal': { 'generated': 'empty' } },
			'F',
			'o',
			'o',
			{ 'type': '/paragraph' },
			{ 'type': '/listItem' },
			{ 'type': '/list' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		],
		'normalizedHtml': '<body><ul><li><p>Foo</p></li></ul></body>'
	},
	'example document': {
		'html': ve.dm.example.html,
		'data': ve.dm.example.data
	},
	'empty annotation': {
		'html': '<body><p>Foo<span id="anchorTarget"></span>Bar</p></body>',
		'data': [
			{ 'type': 'paragraph' },
			'F', 'o', 'o',
			{
				'type': 'alienMeta',
				'attributes': {
					'domElements': $( '<span id="anchorTarget"></span>' ).toArray()
				}
			},
			{ 'type': '/alienMeta' },
			'B', 'a', 'r',
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'empty annotation in wrapper paragraph': {
		'html': '<body>Foo<span id="anchorTarget"></span>Bar</body>',
		'data': [
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			'F', 'o', 'o',
			{
				'type': 'alienMeta',
				'attributes': {
					'domElements': $( '<span id="anchorTarget"></span>' ).toArray()
				}
			},
			{ 'type': '/alienMeta' },
			'B', 'a', 'r',
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'nested empty annotation': {
		'html': '<body><p>Foo<i><b><u></u></b></i>Bar</p></body>',
		'data': [
			{ 'type': 'paragraph' },
			'F', 'o', 'o',
			{
				'type': 'alienMeta',
				'attributes': {
					'domElements': $( '<i><b><u></u></b></i>' ).toArray()
				}
			},
			{ 'type': '/alienMeta' },
			'B', 'a', 'r',
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'empty annotation inside nonempty annotation': {
		'html': '<body><p><i>Foo<b></b></i></p></body>',
		'data': [
			{ 'type': 'paragraph' },
			[ 'F', [ ve.dm.example.italic ] ],
			[ 'o', [ ve.dm.example.italic ] ],
			[ 'o', [ ve.dm.example.italic ] ],
			{
				'type': 'alienMeta',
				'attributes': {
					'domElements': $( '<b></b>' ).toArray()
				},
				'annotations': [ ve.dm.example.italic ]
			},
			{ 'type': '/alienMeta' },
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'empty annotation with comment': {
		'html': '<body><p>Foo<b><!-- Bar --></b>Baz</p></body>',
		'data': [
			{ 'type': 'paragraph' },
			'F', 'o', 'o',
			{
				'type': 'alienMeta',
				'attributes': {
					'domElements': $( '<b><!-- Bar --></b>' ).toArray()
				}
			},
			{ 'type': '/alienMeta' },
			'B', 'a', 'z',
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'list item with space followed by link': {
		'html': '<body><ul><li><p> <a href="Foobar">bar</a></p></li></ul></body>',
		'data': [
			{ 'type': 'list', 'attributes': { 'style': 'bullet' } },
			{ 'type': 'listItem' },
			{ 'type': 'paragraph', 'internal': { 'whitespace': [ undefined, ' ' ] } },
			[
				'b',
				[ {
					'type': 'link',
					'attributes': {
						'href': 'Foobar'
					},
					'htmlAttributes': [ { 'values': {
						'href': 'Foobar'
					} } ]
				} ]
			],
			[
				'a',
				[ {
					'type': 'link',
					'attributes': {
						'href': 'Foobar'
					},
					'htmlAttributes': [ { 'values': {
						'href': 'Foobar'
					} } ]
				} ]
			],
			[
				'r',
				[ {
					'type': 'link',
					'attributes': {
						'href': 'Foobar'
					},
					'htmlAttributes': [ { 'values': {
						'href': 'Foobar'
					} } ]
				} ]
			],
			{ 'type': '/paragraph' },
			{ 'type': '/listItem' },
			{ 'type': '/list' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'whitespace between unwrapped inline nodes': {
		'html':
			'<body>' +
				'<foobar>c</foobar> <foobar>d</foobar>\n<foobar>e</foobar>' +
			'</body>',
		'data': [
			{
				'type': 'paragraph',
				'internal': {
					'generated': 'wrapper'
				}
			},
			{
				'type': 'alienInline',
				'attributes': {
					'domElements': $( '<foobar>c</foobar>' ).toArray()
				}
			},
			{ 'type': '/alienInline' },
			' ',
			{
				'type': 'alienInline',
				'attributes': {
					'domElements': $( '<foobar>d</foobar>' ).toArray()
				}
			},
			{ 'type': '/alienInline' },
			'\n',
			{
				'type': 'alienInline',
				'attributes': {
					'domElements': $( '<foobar>e</foobar>' ).toArray()
				}
			},
			{ 'type': '/alienInline' },
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'whitespace preservation in headings': {
		'html': '<body><h2>Foo</h2><h2> Bar</h2><h2>Baz </h2><h2>  Quux   </h2></body>',
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
			{ 'type': '/heading' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'whitespace preservation in list items': {
		'html': '<body><ul><li>Foo</li><li> Bar</li><li>Baz </li><li>  Quux   </li></ul></body>',
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
			{ 'type': '/list' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'whitespace preservation with annotations': {
		'html': '<body><p> <i>  Foo   </i>    </p></body>',
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
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'outer whitespace preservation in a list with bare text and a wrapper paragraph': {
		'html': '<body>\n<ul>\n\n<li>\n\n\nBa re\n\n\n\n</li>\n\n\n\n\n<li>\t<p>\t\tP\t\t\t</p>\t\t\t\t</li>\t\n</ul>\t\n\t\n</body>',
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
			{ 'type': '/list' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'outer whitespace preservation in a list with bare text and a sublist': {
		'html': '<body><ul>\n<li>\n\nBa re\n\n\n<ul>\n\n\n\n<li> <p>  P   </p>    </li>\t</ul>\t\t</li>\t\t\t</ul></body>',
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
			{ 'type': '/list' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'whitespace preservation leaves non-edge content whitespace alone': {
		'html': '<body><p> A  B   <b>    C\t</b>\t\tD\t\t\t</p>\nE\n\nF\n\n\n<b>\n\n\n\nG </b>  H   </body>',
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
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'whitespace preservation with non-edge content whitespace with nested annotations': {
		'html': '<body><p> A  B   <b>    C\t<i>\t\tD\t\t\t</i>\t\t\t\tE\n</b>\n\nF\n\n\n</p></body>',
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
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'whitespace preservation with tightly nested annotations': {
		'html': '<body><p> A  B   <b><i>\t\tC\t\t\t</i></b>\n\nD\n\n\n</p></body>',
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
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'whitespace preservation with nested annotations with whitespace on the left side': {
		'html': '<body><p> A  B   <b>\n\t<i>\t\tC\t\t\t</i></b>\n\nD\n\n\n</p></body>',
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
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'whitespace preservation with nested annotations with whitespace on the right side': {
		'html': '<body><p> A  B   <b><i>\t\tC\t\t\t</i>\n\t</b>\n\nD\n\n\n</p></body>',
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
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'whitespace preservation with aliens': {
		'html': '<body> <figure>  <br>   </figure>    <p>\tFoo\t\t<foobar>\t\t\tBar\t\t\t\t</foobar>\nBaz\n\n<foobar>\n\n\nQuux\n\n\n\n</foobar> \tWhee \n</p>\t\n<figure>\n\tYay \t </figure> \n </body>',
		'data': [
			{
				'type': 'alienBlock',
				'attributes': {
					'domElements': $( '<figure>  <br>   </figure>' ).toArray()
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
			{ 'type': 'alienInline', 'attributes': { 'domElements': $( '<foobar>\t\t\tBar\t\t\t\t</foobar>' ).toArray() } },
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
					'domElements': $( '<foobar>\n\n\nQuux\n\n\n\n</foobar>' ).toArray()
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
					'domElements': $( '<figure>\n\tYay \t </figure>' ).toArray()
				},
				'internal': {
					'whitespace': [ '\t\n', undefined, undefined, ' \n ' ]
				}
			},
			{ 'type': '/alienBlock' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'whitespace preservation not triggered inside <pre>': {
		'html': '<body>\n<pre>\n\n\nFoo\n\n\nBar\n\n\n\n</pre>\n\n\n\n\n</body>',
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
			{ 'type': '/preformatted' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'whitespace preservation in table cell starting with text and ending with annotation': {
		'html': '<body><table><tbody><tr><td>Foo <b>Bar</b></td></tr></tbody></table></body>',
		'data': [
			{ 'type': 'table' },
			{ 'type': 'tableSection', 'attributes': { 'style': 'body' } },
			{ 'type': 'tableRow' },
			{ 'type': 'tableCell', 'attributes': { 'style': 'data' } },
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			'F',
			'o',
			'o',
			' ',
			[ 'B', [ ve.dm.example.bold ] ],
			[ 'a', [ ve.dm.example.bold ] ],
			[ 'r', [ ve.dm.example.bold ] ],
			{ 'type': '/paragraph' },
			{ 'type': '/tableCell' },
			{ 'type': '/tableRow' },
			{ 'type': '/tableSection' },
			{ 'type': '/table' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'whitespace preservation with wrapped text and comments': {
		'html': '<body><!-- Foo --> <!-- Bar -->\nFoo</body>',
		'data': [
			{
				'type': 'alienMeta',
				'internal': { 'whitespace': [ undefined, undefined, undefined, ' ' ] },
				'attributes': {
					'domElements': $( '<!-- Foo -->' ).toArray()
				}
			},
			{ 'type': '/alienMeta' },
			{
				'type': 'alienMeta',
				'internal': { 'whitespace': [ ' ', undefined, undefined, '\n' ] },
				'attributes': {
					'domElements': $( '<!-- Bar -->' ).toArray()
				}
			},
			{ 'type': '/alienMeta' },
			{
				'type': 'paragraph',
				'internal': {
					'generated': 'wrapper',
					'whitespace': [ '\n' ]
				}
			},
			'F',
			'o',
			'o',
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'whitespace preservation with comments at end of wrapper paragraph': {
		'html': '<body><ul><li> bar<!-- baz -->quux </li></ul></body>',
		'data': [
			{ 'type': 'list', 'attributes': { 'style': 'bullet' } },
			{
				'type': 'listItem',
				'internal': {
					'whitespace': [
						undefined,
						' ',
						' '
					]
				}
			},
			{
				'type': 'paragraph',
				'internal': {
					'generated': 'wrapper',
					'whitespace': [
						' ',
						undefined,
						undefined,
						' '
					]
				}
			},
			'b', 'a', 'r',
			{
				'type': 'alienMeta',
				'attributes': {
					'domElements': $( '<!-- baz -->' ).toArray()
				}
			},
			{ 'type': '/alienMeta' },
			'q', 'u', 'u', 'x',
			{ 'type': '/paragraph' },
			{ 'type': '/listItem' },
			{ 'type': '/list' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'whitespace preservation with comment at end of wrapper paragraph': {
		'html': '<body><ul><li> bar<!-- baz --> </li></ul></body>',
		'data': [
			{ 'type': 'list', 'attributes': { 'style': 'bullet' } },
			{
				'type': 'listItem',
				'internal': {
					'whitespace': [
						undefined,
						' ',
						' '
					]
				}
			},
			{
				'type': 'paragraph',
				'internal': {
					'generated': 'wrapper',
					'whitespace': [
						' '
					]
				}
			},
			'b', 'a', 'r',
			{ 'type': '/paragraph' },
			{
				'type': 'alienMeta',
				'attributes': {
					'domElements': $( '<!-- baz -->' ).toArray()
				},
				'internal': {
					'whitespace': [
						undefined,
						undefined,
						undefined,
						' '
					]
				}
			},
			{ 'type': '/alienMeta' },
			{ 'type': '/listItem' },
			{ 'type': '/list' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'whitespace preservation with multiple comments at end of wrapper paragraph': {
		'html': '<body><ul><li> foo <!-- bar --> <!-- baz --> </li></ul></body>',
		'data': [
			{ 'type': 'list', 'attributes': { 'style': 'bullet' } },
			{
				'type': 'listItem',
				'internal': {
					'whitespace': [
						undefined,
						' ',
						' '
					]
				}
			},
			{
				'type': 'paragraph',
				'internal': {
					'generated': 'wrapper',
					'whitespace': [
						' ',
						undefined,
						undefined,
						' '
					]
				}
			},
			'f', 'o', 'o',
			{ 'type': '/paragraph' },
			{
				'type': 'alienMeta',
				'attributes': {
					'domElements': $( '<!-- bar -->' ).toArray()
				},
				'internal': {
					'whitespace': [
						' ',
						undefined,
						undefined,
						' '
					]
				}
			},
			{ 'type': '/alienMeta' },
			{
				'type': 'alienMeta',
				'attributes': {
					'domElements': $( '<!-- baz -->' ).toArray()
				},
				'internal': {
					'whitespace': [
						' ',
						undefined,
						undefined,
						' '
					]
				}
			},
			{ 'type': '/alienMeta' },
			{ 'type': '/listItem' },
			{ 'type': '/list' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'whitespace preservation with comment at start or end of element': {
		'html': '<body><p> <!-- foo -->bar<!-- baz --> </p></body>',
		'data': [
			{
				'type': 'paragraph',
				'internal': {
					'whitespace': [
						undefined,
						' ',
						' '
					]
				}
			},
			{
				'type': 'alienMeta',
				'attributes': {
					'domElements': $( '<!-- foo -->' ).toArray()
				}
			},
			{ 'type': '/alienMeta' },
			'b', 'a', 'r',
			{
				'type': 'alienMeta',
				'attributes': {
					'domElements': $( '<!-- baz -->' ).toArray()
				}
			},
			{ 'type': '/alienMeta' },
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'whitespace surrounding metadata in a wrapper': {
		'html': '<body><b>Foo</b> <!-- comment -->\n<i>Bar</i></body>',
		'data': [
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			[ 'F', [ ve.dm.example.bold ] ],
			[ 'o', [ ve.dm.example.bold ] ],
			[ 'o', [ ve.dm.example.bold ] ],
			' ',
			{
				'type': 'alienMeta',
				'attributes': {
					'domElements': $( '<!-- comment -->' ).toArray()
				}
			},
			{ 'type': '/alienMeta' },
			'\n',
			[ 'B', [ ve.dm.example.italic ] ],
			[ 'a', [ ve.dm.example.italic ] ],
			[ 'r', [ ve.dm.example.italic ] ],
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'whitespace preservation in empty branch node': {
		'html': '<body><table>\n\n</table></body>',
		'data': [
			{ 'type': 'table', 'internal': { 'whitespace': [ undefined, '\n\n' ] } },
			{ 'type': '/table' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'mismatching whitespace data is ignored': {
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
			{ 'type': '/list' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		],
		'normalizedHtml': '<body> <ul><li><p>\tA\n</p>  <p>B</p></li></ul>    </body>'
	},
	'order of nested annotations is preserved': {
		'html': '<body><p><b><u><i>Foo</i></u></b></p></body>',
		'data': [
			{ 'type': 'paragraph' },
			[
				'F',
				[
					ve.dm.example.bold,
					ve.dm.example.underline,
					ve.dm.example.italic
				]
			],
			[
				'o',
				[
					ve.dm.example.bold,
					ve.dm.example.underline,
					ve.dm.example.italic

				]
			],
			[
				'o',
				[
					ve.dm.example.bold,
					ve.dm.example.underline,
					ve.dm.example.italic

				]
			],
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'nested annotations are closed and reopened in the correct order': {
		'html': '<body><p><a href="Foo">F<b>o<i>o</i></b><i>b</i></a><i>a<b>r</b>b<u>a</u>z</i></p></body>',
		'data': [
			{ 'type': 'paragraph' },
			[
				'F',
				[
					{
						'type': 'link',
						'attributes': {
							'href': 'Foo'
						},
						'htmlAttributes': [ { 'values': {
							'href': 'Foo'
						} } ]
					}
				]
			],
			[
				'o',
				[
					{
						'type': 'link',
						'attributes': {
							'href': 'Foo'
						},
						'htmlAttributes': [ { 'values': {
							'href': 'Foo'
						} } ]
					},
					ve.dm.example.bold
				]
			],
			[
				'o',
				[
					{
						'type': 'link',
						'attributes': {
							'href': 'Foo'
						},
						'htmlAttributes': [ { 'values': {
							'href': 'Foo'
						} } ]
					},
					ve.dm.example.bold,
					ve.dm.example.italic
				]
			],
			[
				'b',
				[
					{
						'type': 'link',
						'attributes': {
							'href': 'Foo'
						},
						'htmlAttributes': [ { 'values': {
							'href': 'Foo'
						} } ]
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
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'about grouping': {
		'html': '<body><figure about="#mwt1">Foo</figure>' +
			'<figure about="#mwt1">Bar</figure>' +
			'<figure about="#mwt2">Baz</figure>' +
			'<foobar about="#mwt2">Quux</foobar>' +
			'<p>Whee</p>' +
			'<foobar about="#mwt2">Yay</foobar>' +
			'<figure about="#mwt2">Blah</figure>' +
			'<foobar about="#mwt3">Meh</foobar></body>',
		'data': [
			{
				'type': 'alienBlock',
				'attributes': {
					'domElements': $( '<figure about="#mwt1">Foo</figure>' +
						'<figure about="#mwt1">Bar</figure>' ).toArray()
				}
			},
			{ 'type': '/alienBlock' },
			{
				'type': 'alienBlock',
				'attributes': {
					'domElements': $( '<figure about="#mwt2">Baz</figure>' +
						'<foobar about="#mwt2">Quux</foobar>' ).toArray()
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
					'domElements': $( '<foobar about="#mwt2">Yay</foobar>' +
						'<figure about="#mwt2">Blah</figure>' ).toArray()
				}
			},
			{ 'type': '/alienBlock' },
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			{
				'type': 'alienInline',
				'attributes': {
					'domElements': $( '<foobar about="#mwt3">Meh</foobar>' ).toArray()
				}
			},
			{ 'type': '/alienInline' },
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'whitespace preservation with an about group': {
		'html': '<body> <figure about="#mwt1">\tFoo\t\t</figure>\t\t\t' +
			'<figure about="#mwt1">  Bar   </figure>    </body>',
		'data': [
			{
				'type': 'alienBlock',
				'attributes': {
					'domElements': $( '<figure about="#mwt1">\tFoo\t\t</figure>\t\t\t' +
						'<figure about="#mwt1">  Bar   </figure>' ).toArray()
				},
				'internal': {
					'whitespace': [ ' ', undefined, undefined, '    ' ]
				}
			},
			{ 'type': '/alienBlock' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'block node inside annotation node is alienated': {
		'html': '<body><span>\n<p>Bar</p></span></body>',
		'data': [
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			[ '\n', [ ve.dm.example.span ] ],
			{
				'type': 'alienInline',
				'attributes': {
					'domElements': $( '<p>Bar</p>' ).toArray()
				},
				'annotations': [ ve.dm.example.span ]
			},
			{ 'type': '/alienInline' },
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'block node inside annotation node surrounded by tables': {
		'html': '<body><table></table><span>\n<p>Bar</p></span><table></table></body>',
		'data': [
			{ 'type': 'table' },
			{ 'type': '/table' },
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			[ '\n', [ ve.dm.example.span ] ],
			{
				'type': 'alienInline',
				'attributes': {
					'domElements': $( '<p>Bar</p>' ).toArray()
				},
				'annotations': [ ve.dm.example.span ]
			},
			{ 'type': '/alienInline' },
			{ 'type': '/paragraph' },
			{ 'type': 'table' },
			{ 'type': '/table' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'block node inside annotation node is alienated and continues wrapping': {
		'html': '<body>Foo<span>\n<p>Bar</p></span>Baz</body>',
		'data': [
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			'F',
			'o',
			'o',
			[ '\n', [ ve.dm.example.span ] ],
			{
				'type': 'alienInline',
				'attributes': {
					'domElements': $( '<p>Bar</p>' ).toArray()
				},
				'annotations': [ ve.dm.example.span ]
			},
			{ 'type': '/alienInline' },
			'B',
			'a',
			'z',
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'whitespace before meta node in wrapping mode': {
		'html': '<body><table><tbody><tr><td>Foo\n<meta content="bar" /></td></tr></tbody></table></body>',
		'data': [
			{ 'type': 'table' },
			{ 'type': 'tableSection', 'attributes': { 'style': 'body' } },
			{ 'type': 'tableRow' },
			{
				'type': 'tableCell',
				'attributes': { 'style': 'data' },
				'internal': { 'whitespace': [ undefined, undefined, '\n' ] }
			},
			{
				'type': 'paragraph',
				'internal': {
					'generated': 'wrapper',
					'whitespace': [ undefined, undefined, undefined, '\n' ]
				}
			},
			'F',
			'o',
			'o',
			{ 'type': '/paragraph' },
			{
				'type': 'alienMeta',
				'internal': { 'whitespace': [ '\n' ] },
				'attributes': {
					'domElements': $( '<meta content="bar" />' ).toArray()
				}
			},
			{ 'type': '/alienMeta' },
			{ 'type': '/tableCell' },
			{ 'type': '/tableRow' },
			{ 'type': '/tableSection' },
			{ 'type': '/table' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'table with caption, head, foot and body': {
		'html': ve.dm.example.complexTableHtml,
		'data': ve.dm.example.complexTable
	},
	'div set to RTL with paragraph inside': {
		'html': '<body><div style="direction: rtl;"><p>a<b>b</b>c<i>d</i>e</p></body>',
		'data': [
			{
				'type': 'div',
				'htmlAttributes': [ { 'values': { 'style': 'direction: rtl;' } } ]
			},
			{ 'type': 'paragraph' },
			'a',
			['b', [ ve.dm.example.bold ]],
			'c',
			['d', [ ve.dm.example.italic ]],
			'e',
			{ 'type': '/paragraph' },
			{ 'type': '/div' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	}
};

ve.dm.example.isolationHtml =
	'<ul><li>Item 1</li><li>Item 2</li><li>Item 3</li></ul>' +
	'Paragraph' +
	'<ul><li>Item 4</li><li>Item 5</li><li>Item 6</li></ul>' +
	'<table><tbody><tr><td>Cell 1</td><td>Cell 2</td><td>Cell 3</td></tr><tr><td>Cell 4</td></tr></tbody></table>' +
	'Not allowed by dm:' +
	'<ul><li><h1>Title in list</h1></li><li><pre>Preformatted in list</pre></li></ul>' +
	'<ul><li><ol><li>Nested 1</li><li>Nested 2</li><li>Nested 3</li></ol></li></ul>' +
	'<ul><li><p>P1</p><p>P2</p><p>P3</p></li></ul>';

ve.dm.example.isolationData = [
	// 0
	{ 'type': 'list', 'attributes': { 'style': 'bullet' } },
	{ 'type': 'listItem' },
	{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
	'I', 't', 'e', 'm', ' ', '1',
	{ 'type': '/paragraph' },
	// 10
	{ 'type': '/listItem' },
	{ 'type': 'listItem' },
	{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
	'I', 't', 'e', 'm', ' ', '2',
	{ 'type': '/paragraph' },
	// 20
	{ 'type': '/listItem' },
	{ 'type': 'listItem' },
	{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
	'I', 't', 'e', 'm', ' ', '3',
	{ 'type': '/paragraph' },
	// 30
	{ 'type': '/listItem' },
	{ 'type': '/list' },
	{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
	'P', 'a', 'r', 'a', 'g', 'r', 'a',
	// 40
	'p', 'h',
	{ 'type': '/paragraph' },
	{ 'type': 'list', 'attributes': { 'style': 'bullet' } },
	{ 'type': 'listItem' },
	{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
	'I', 't', 'e', 'm',
	// 50
	' ', '4',
	{ 'type': '/paragraph' },
	{ 'type': '/listItem' },
	{ 'type': 'listItem' },
	{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
	'I', 't', 'e', 'm',
	// 60
	' ', '5',
	{ 'type': '/paragraph' },
	{ 'type': '/listItem' },
	{ 'type': 'listItem' },
	{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
	'I', 't', 'e', 'm',
	// 70
	' ', '6',
	{ 'type': '/paragraph' },
	{ 'type': '/listItem' },
	{ 'type': '/list' },
	{ 'type': 'table' },
	{ 'type': 'tableSection', 'attributes': { 'style': 'body' } },
	{ 'type': 'tableRow' },
	{ 'type': 'tableCell', 'attributes': { 'style': 'data' } },
	{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
	// 80
	'C', 'e', 'l', 'l', ' ', '1',
	{ 'type': '/paragraph' },
	{ 'type': '/tableCell' },
	{ 'type': 'tableCell', 'attributes': { 'style': 'data' } },
	{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
	// 90
	'C', 'e', 'l', 'l', ' ', '2',
	{ 'type': '/paragraph' },
	{ 'type': '/tableCell' },
	{ 'type': 'tableCell', 'attributes': { 'style': 'data' } },
	{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
	// 100
	'C', 'e', 'l', 'l', ' ', '3',
	{ 'type': '/paragraph' },
	{ 'type': '/tableCell' },
	{ 'type': '/tableRow' },
	{ 'type': 'tableRow' },
	// 110
	{ 'type': 'tableCell', 'attributes': { 'style': 'data' } },
	{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
	'C', 'e', 'l', 'l', ' ', '4',
	{ 'type': '/paragraph' },
	{ 'type': '/tableCell' },
	// 120
	{ 'type': '/tableRow' },
	{ 'type': '/tableSection' },
	{ 'type': '/table' },
	{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
	'N', 'o', 't', ' ', 'a', 'l',
	// 130
	'l', 'o', 'w', 'e', 'd', ' ', 'b', 'y', ' ', 'd',
	// 140
	'm', ':',
	{ 'type': '/paragraph' },
	{ 'type': 'list', 'attributes': { 'style': 'bullet' } },
	{ 'type': 'listItem' },
	{ 'type': 'heading', 'attributes': { 'level': 1 } },
	'T', 'i', 't', 'l',
	// 150
	'e', ' ', 'i', 'n', ' ', 'l', 'i', 's', 't',
	{ 'type': '/heading' },
	// 160
	{ 'type': '/listItem' },
	{ 'type': 'listItem' },
	{ 'type': 'preformatted' },
	'P', 'r', 'e', 'f', 'o', 'r', 'm',
	// 170
	'a', 't', 't', 'e', 'd', ' ', 'i', 'n', ' ', 'l',
	// 180
	'i', 's', 't',
	{ 'type': '/preformatted' },
	{ 'type': '/listItem' },
	{ 'type': '/list' },
	{ 'type': 'list', 'attributes': { 'style': 'bullet' } },
	{ 'type': 'listItem' },
	{ 'type': 'list', 'attributes': { 'style': 'number' } },
	{ 'type': 'listItem' },
	// 190
	{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
	'N', 'e', 's', 't', 'e', 'd', ' ', '1',
	{ 'type': '/paragraph' },
	// 200
	{ 'type': '/listItem' },
	{ 'type': 'listItem' },
	{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
	'N', 'e', 's', 't', 'e', 'd', ' ',
	// 210
	'2',
	{ 'type': '/paragraph' },
	{ 'type': '/listItem' },
	{ 'type': 'listItem' },
	{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
	'N', 'e', 's', 't', 'e',
	// 220
	'd', ' ', '3',
	{ 'type': '/paragraph' },
	{ 'type': '/listItem' },
	{ 'type': '/list' },
	{ 'type': '/listItem' },
	{ 'type': '/list' },
	{ 'type': 'list', 'attributes': { 'style': 'bullet' } },
	{ 'type': 'listItem' },
	// 230
	{ 'type': 'paragraph' },
	'P', '1',
	{ 'type': '/paragraph' },
	{ 'type': 'paragraph' },
	'P', '2',
	{ 'type': '/paragraph' },
	{ 'type': 'paragraph' },
	'P',
	// 240
	'3',
	{ 'type': '/paragraph' },
	{ 'type': '/listItem' },
	{ 'type': '/list' },
	{ 'type': 'internalList' },
	{ 'type': '/internalList' }
	// 246
];

ve.dm.example.UnboldableNode = function ( lenght, element ) {
	// Parent constructor
	ve.dm.LeafNode.call( this, 0, element );
};
ve.inheritClass( ve.dm.example.UnboldableNode, ve.dm.LeafNode );
ve.dm.example.UnboldableNode.static.name = 'exampleUnboldable';
ve.dm.example.UnboldableNode.static.isContent = true;
ve.dm.example.UnboldableNode.static.blacklistedAnnotationTypes = [ 'textStyle/bold' ];
ve.dm.example.UnboldableNode.static.matchTagNames = [];
ve.dm.modelRegistry.register( ve.dm.example.UnboldableNode );

ve.dm.example.annotationData = [
	{ 'type': 'paragraph' },
	'F',
	'o',
	'o',
	{ 'type': 'exampleUnboldable' },
	{ 'type': '/exampleUnboldable' },
	'B',
	'a',
	'r',
	{ 'type': '/paragraph' },
	{ 'type': 'internalList' },
	{ 'type': '/internalList' }
];

ve.dm.example.selectNodesCases = [
	{
		'range': new ve.Range( 1 ),
		'mode': 'branches',
		'expected': [
			// heading
			{
				'node': [ 0 ],
				'range': new ve.Range( 1 ),
				'index': 0,
				'nodeRange': new ve.Range( 1, 4 ),
				'nodeOuterRange': new ve.Range( 0, 5 ),
				'parentOuterRange': new ve.Range( 0, 63 )
			}
		]
	},
	{
		'range': new ve.Range( 10 ),
		'mode': 'branches',
		'expected': [
			// table/tableSection/tableRow/tableCell/paragraph
			{
				'node': [ 1, 0, 0, 0, 0 ],
				'range': new ve.Range( 10 ),
				'index': 0,
				'nodeRange': new ve.Range( 10, 11 ),
				'nodeOuterRange': new ve.Range( 9, 12 ),
				'parentOuterRange': new ve.Range( 8, 34 )
			}
		]
	},
	{
		'range': new ve.Range( 20 ),
		'mode': 'branches',
		'expected': [
			// table/tableSection/tableRow/tableCell/list/listItem/list/listItem/paragraph
			{
				'node': [ 1, 0, 0, 0, 1, 0, 1, 0, 0 ],
				'range': new ve.Range( 20 ),
				'index': 0,
				'nodeRange': new ve.Range( 20, 21 ),
				'nodeOuterRange': new ve.Range( 19, 22 ),
				'parentOuterRange': new ve.Range( 18, 23 )
			}
		]
	},
	{
		'range': new ve.Range( 1, 20 ),
		'mode': 'branches',
		'expected': [
			// heading
			{
				'node': [ 0 ],
				'range': new ve.Range( 1, 4 ),
				'index': 0,
				'nodeRange': new ve.Range( 1, 4 ),
				'nodeOuterRange': new ve.Range( 0, 5 ),
				'parentOuterRange': new ve.Range( 0, 63 )
			},

			// table/tableSection/tableRow/tableCell/paragraph
			{
				'node': [ 1, 0, 0, 0, 0 ],
				'index': 0,
				'nodeRange': new ve.Range( 10, 11 ),
				'nodeOuterRange': new ve.Range( 9, 12 ),
				'parentOuterRange': new ve.Range( 8, 34 )
			},

			// table/tableSection/tableRow/tableCell/list/listItem/paragraph
			{
				'node': [ 1, 0, 0, 0, 1, 0, 0 ],
				'index': 0,
				'nodeRange': new ve.Range( 15, 16 ),
				'nodeOuterRange': new ve.Range( 14, 17 ),
				'parentOuterRange': new ve.Range( 13, 25 )
			},

			// table/tableSection/tableRow/tableCell/list/listItem/list/listItem/paragraph
			{
				'node': [ 1, 0, 0, 0, 1, 0, 1, 0, 0 ],
				'range': new ve.Range( 20 ),
				'index': 0,
				'nodeRange': new ve.Range( 20, 21 ),
				'nodeOuterRange': new ve.Range( 19, 22 ),
				'parentOuterRange': new ve.Range( 18, 23 )
			}
		]
	},
	{
		'range': new ve.Range( 1 ),
		'mode': 'branches',
		'expected': [
			// heading
			{
				'node': [ 0 ],
				'range': new ve.Range( 1 ),
				'index': 0,
				'nodeRange': new ve.Range( 1, 4 ),
				'nodeOuterRange': new ve.Range( 0, 5 ),
				'parentOuterRange': new ve.Range( 0, 63 )
			}
		]
	},
	{
		'range': new ve.Range( 0, 3 ),
		'mode': 'leaves',
		'expected': [
			// heading/text
			{
				'node': [ 0, 0 ],
				'range': new ve.Range( 1, 3 ),
				'index': 0,
				'nodeRange': new ve.Range( 1, 4 ),
				'nodeOuterRange': new ve.Range( 1, 4 ),
				'parentOuterRange': new ve.Range( 0, 5 )
			}
		],
		'msg': 'partial leaf results have ranges with global offsets'
	},
	{
		'range': new ve.Range( 0, 11 ),
		'mode': 'leaves',
		'expected': [
			// heading/text
			{
				'node': [ 0, 0 ],
				'index': 0,
				'nodeRange': new ve.Range( 1, 4 ),
				'nodeOuterRange': new ve.Range( 1, 4 ),
				'parentOuterRange': new ve.Range( 0, 5 )
			},
			// table/tableSection/tableRow/tableCell/paragraph/text
			{
				'node': [ 1, 0, 0, 0, 0, 0 ],
				'index': 0,
				'nodeRange': new ve.Range( 10, 11 ),
				'nodeOuterRange': new ve.Range( 10, 11 ),
				'parentOuterRange': new ve.Range( 9, 12 )
			}
		],
		'msg': 'leaf nodes do not have ranges, leaf nodes from different levels'
	},
	{
		'range': new ve.Range( 29, 43 ),
		'mode': 'leaves',
		'expected': [
			// table/tableSection/tableRow/tableCell/list/listItem/paragraph/text
			{
				'node': [ 1, 0, 0, 0, 2, 0, 0, 0 ],
				'index': 0,
				'nodeRange': new ve.Range( 29, 30 ),
				'nodeOuterRange': new ve.Range( 29, 30 ),
				'parentOuterRange': new ve.Range( 28, 31 )
			},
			// preformatted/text
			{
				'node': [ 2, 0 ],
				'index': 0,
				'nodeRange': new ve.Range( 38, 39 ),
				'nodeOuterRange': new ve.Range( 38, 39 ),
				'parentOuterRange': new ve.Range( 37, 43 )
			},
			// preformatted/image
			{
				'node': [ 2, 1 ],
				'index': 1,
				'nodeRange': new ve.Range( 40, 40 ),
				'nodeOuterRange': new ve.Range( 39, 41 ),
				'parentOuterRange': new ve.Range( 37, 43 )
			},
			// preformatted/text
			{
				'node': [ 2, 2 ],
				'index': 2,
				'nodeRange': new ve.Range( 41, 42 ),
				'nodeOuterRange': new ve.Range( 41, 42 ),
				'parentOuterRange': new ve.Range( 37, 43 )
			}
		],
		'msg': 'leaf nodes that are not text nodes'
	},
	{
		'range': new ve.Range( 2, 16 ),
		'mode': 'siblings',
		'expected': [
			// heading
			{
				'node': [ 0 ],
				'range': new ve.Range( 2, 4 ),
				'index': 0,
				'nodeRange': new ve.Range( 1, 4 ),
				'nodeOuterRange': new ve.Range( 0, 5 ),
				'parentOuterRange': new ve.Range( 0, 63 )
			},
			// table
			{
				'node': [ 1 ],
				'range': new ve.Range( 6, 16 ),
				'index': 1,
				'nodeRange': new ve.Range( 6, 36 ),
				'nodeOuterRange': new ve.Range( 5, 37 ),
				'parentOuterRange': new ve.Range( 0, 63 )
			}
		],
		'msg': 'siblings at the document level'
	},
	{
		'range': new ve.Range( 2, 51 ),
		'mode': 'siblings',
		'expected': [
			// heading
			{
				'node': [ 0 ],
				'range': new ve.Range( 2, 4 ),
				'index': 0,
				'nodeRange': new ve.Range( 1, 4 ),
				'nodeOuterRange': new ve.Range( 0, 5 ),
				'parentOuterRange': new ve.Range( 0, 63 )
			},
			// table
			{
				'node': [ 1 ],
				'index': 1,
				'nodeRange': new ve.Range( 6, 36 ),
				'nodeOuterRange': new ve.Range( 5, 37 ),
				'parentOuterRange': new ve.Range( 0, 63 )
			},
			// preformatted
			{
				'node': [ 2 ],
				'index': 2,
				'nodeRange': new ve.Range( 38, 42 ),
				'nodeOuterRange': new ve.Range( 37, 43 ),
				'parentOuterRange': new ve.Range( 0, 63 )
			},
			// definitionList
			{
				'node': [ 3 ],
				'range': new ve.Range( 44, 51 ),
				'index': 3,
				'nodeRange': new ve.Range( 44, 54 ),
				'nodeOuterRange': new ve.Range( 43, 55 ),
				'parentOuterRange': new ve.Range( 0, 63 )
			}
		],
		'msg': 'more than 2 siblings at the document level'
	},
	{
		'range': new ve.Range( 1, 1 ),
		'mode': 'leaves',
		'expected': [
			// heading/text
			{
				'node': [ 0, 0 ],
				'range': new ve.Range( 1, 1 ),
				'index': 0,
				'nodeRange': new ve.Range( 1, 4 ),
				'nodeOuterRange': new ve.Range( 1, 4 ),
				'parentOuterRange': new ve.Range( 0, 5 )
			}
		],
		'msg': 'zero-length range at the start of a text node returns text node rather than parent'
	},
	{
		'range': new ve.Range( 4, 4 ),
		'mode': 'leaves',
		'expected': [
			// heading/text
			{
				'node': [ 0, 0 ],
				'range': new ve.Range( 4, 4 ),
				'index': 0,
				'nodeRange': new ve.Range( 1, 4 ),
				'nodeOuterRange': new ve.Range( 1, 4 ),
				'parentOuterRange': new ve.Range( 0, 5 )
			}
		],
		'msg': 'zero-length range at the end of a text node returns text node rather than parent'
	},
	{
		'range': new ve.Range( 2, 3 ),
		'mode': 'leaves',
		'expected': [
			// heading/text
			{
				'node': [ 0, 0 ],
				'range': new ve.Range( 2, 3 ),
				'index': 0,
				'nodeRange': new ve.Range( 1, 4 ),
				'nodeOuterRange': new ve.Range( 1, 4 ),
				'parentOuterRange': new ve.Range( 0, 5 )
			}
		],
		'msg': 'range entirely within one leaf node'
	},
	{
		'range': new ve.Range( 5, 5 ),
		'mode': 'leaves',
		'expected': [
			// document
			{
				'node': [],
				'range': new ve.Range( 5, 5 ),
				// no 'index' because documentNode has no parent
				'indexInNode': 1,
				'nodeRange': new ve.Range( 0, 63 ),
				'nodeOuterRange': new ve.Range( 0, 63 )
			}
		],
		'msg': 'zero-length range between two children of the document'
	},
	{
		'range': new ve.Range( 0, 0 ),
		'mode': 'leaves',
		'expected': [
			// document
			{
				'node': [],
				'range': new ve.Range( 0, 0 ),
				// no 'index' because documentNode has no parent
				'indexInNode': 0,
				'nodeRange': new ve.Range( 0, 63 ),
				'nodeOuterRange': new ve.Range( 0, 63 )
			}
		],
		'msg': 'zero-length range at the start of the document'
	},
	{
		'range': new ve.Range( 32, 39 ),
		'mode': 'leaves',
		'expected': [
			// table/tableSection/tableRow/tableCell/list
			{
				'node': [ 1, 0, 0, 0, 2 ],
				'range': new ve.Range( 32, 32 ),
				'index': 2,
				'indexInNode': 1,
				'nodeRange': new ve.Range( 27, 32 ),
				'nodeOuterRange': new ve.Range( 26, 33 )
			},
			// preformatted/text
			{
				'node': [ 2, 0 ],
				// no 'range' because the text node is covered completely
				'index': 0,
				'nodeRange': new ve.Range( 38, 39 ),
				'nodeOuterRange': new ve.Range( 38, 39 ),
				'parentOuterRange': new ve.Range( 37, 43 )
			}
		],
		'msg': 'range with 5 closings and a text node'
	},
	{
		'range': new ve.Range( 2, 57 ),
		'mode': 'covered',
		'expected': [
			// heading/text
			{
				'node': [ 0, 0 ],
				'range': new ve.Range( 2, 4 ),
				'index': 0,
				'nodeRange': new ve.Range( 1, 4 ),
				'nodeOuterRange': new ve.Range( 1, 4 ),
				'parentOuterRange': new ve.Range( 0, 5 )
			},
			// table
			{
				'node': [ 1 ],
				// no 'range' because the table is covered completely
				'index': 1,
				'nodeRange': new ve.Range( 6, 36 ),
				'nodeOuterRange': new ve.Range( 5, 37 ),
				'parentOuterRange': new ve.Range( 0, 63 )
			},
			// preformatted
			{
				'node': [ 2 ],
				// no 'range' because the node is covered completely
				'index': 2,
				'nodeRange': new ve.Range( 38, 42 ),
				'nodeOuterRange': new ve.Range( 37, 43 ),
				'parentOuterRange': new ve.Range( 0, 63 )
			},
			// definitionList
			{
				'node': [ 3 ],
				// no 'range' because the node is covered completely
				'index': 3,
				'nodeRange': new ve.Range( 44, 54 ),
				'nodeOuterRange': new ve.Range( 43, 55 ),
				'parentOuterRange': new ve.Range( 0, 63 )
			},
			// paragraph/text
			{
				'node': [ 4, 0 ],
				// no 'range' because the text node is covered completely
				'index': 0,
				'nodeRange': new ve.Range( 56, 57 ),
				'nodeOuterRange': new ve.Range( 56, 57 ),
				'parentOuterRange': new ve.Range( 55, 58 )
			}
		],
		'msg': 'range from the first heading into the second-to-last paragraph, in covered mode'
	},
	{
		'range': new ve.Range( 14, 14 ),
		'mode': 'siblings',
		'expected': [
			// table/tableSection/tableRow/tableCell/list/listItem
			{
				'node': [ 1, 0, 0, 0, 1, 0 ],
				'range': new ve.Range( 14, 14 ),
				'index': 0,
				'indexInNode': 0,
				'nodeRange': new ve.Range( 14, 24 ),
				'nodeOuterRange': new ve.Range( 13, 25 )
			}
		],
		'msg': 'zero-length range at the beginning of a listItem, in siblings mode'
	},
	{
		'range': new ve.Range( 25, 27 ),
		'mode': 'covered',
		'expected': [
			// table/tableSection/tableRow/tableCell/list
			{
				'node': [ 1, 0, 0, 0, 1 ],
				'range': new ve.Range( 25, 25 ),
				'index': 1,
				'indexInNode': 1,
				'nodeRange': new ve.Range( 13, 25 ),
				'nodeOuterRange': new ve.Range( 12, 26 )
			},
			// table/tableSection/tableRow/tableCell/list
			{
				'node': [ 1, 0, 0, 0, 2 ],
				'range': new ve.Range( 27, 27 ),
				'index': 2,
				'indexInNode': 0,
				'nodeRange': new ve.Range( 27, 32 ),
				'nodeOuterRange': new ve.Range( 26, 33 )
			}
		],
		'msg': 'range covering a list closing and a list opening'
	},
	{
		'range': new ve.Range( 39, 39 ),
		'mode': 'leaves',
		'expected': [
			// preformatted/text
			{
				'node': [ 2, 0 ],
				'range': new ve.Range( 39, 39 ),
				'index': 0,
				'nodeRange': new ve.Range( 38, 39 ),
				'nodeOuterRange': new ve.Range( 38, 39 ),
				'parentOuterRange': new ve.Range( 37, 43 )
			}
		],
		'msg': 'zero-length range in text node before inline node'
	},
	{
		'range': new ve.Range( 41, 41 ),
		'mode': 'leaves',
		'expected': [
			// preformatted/text
			{
				'node': [ 2, 2 ],
				'range': new ve.Range( 41, 41 ),
				'index': 2,
				'nodeRange': new ve.Range( 41, 42 ),
				'nodeOuterRange': new ve.Range( 41, 42 ),
				'parentOuterRange': new ve.Range( 37, 43 )
			}
		],
		'msg': 'zero-length range in text node after inline node'
	},
	{
		'doc': 'emptyBranch',
		'range': new ve.Range( 1 ),
		'mode': 'leaves',
		'expected': [
			// table
			{
				'node': [ 0 ],
				'range': new ve.Range( 1, 1 ),
				'index': 0,
				'indexInNode': 0,
				'nodeRange': new ve.Range( 1, 1 ),
				'nodeOuterRange': new ve.Range( 0, 2 ),
				'parentOuterRange': new ve.Range( 0, 2 )
			}
		],
		'msg': 'Zero-length range in empty branch node'
	}
];
