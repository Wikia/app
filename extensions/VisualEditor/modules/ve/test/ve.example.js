/**
 * VisualEditor example data sets and helper functions.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/* Static Members */

ve.example = {};

/* Methods */

ve.example.getSelectNodesCases = function ( doc ) {
	var lookup = ve.example.lookupNode,
		documentNode = doc.getDocumentNode();
	return [
		{
			'actual': doc.selectNodes( new ve.Range( 1 ), 'branches' ),
			'expected': [
				// heading
				{
					'node': lookup( documentNode, 0 ),
					'range': new ve.Range( 1 ),
					'index': 0,
					'nodeRange': new ve.Range( 1, 4 ),
					'nodeOuterRange': new ve.Range( 0, 5 ),
					'parentOuterRange': new ve.Range( 0, 61 )
				}
			]
		},
		{
			'actual': doc.selectNodes( new ve.Range( 10 ), 'branches' ),
			'expected': [
				// table/tableSection/tableRow/tableCell/paragraph
				{
					'node': lookup( documentNode, 1, 0, 0, 0, 0 ),
					'range': new ve.Range( 10 ),
					'index': 0,
					'nodeRange': new ve.Range( 10, 11 ),
					'nodeOuterRange': new ve.Range( 9, 12 ),
					'parentOuterRange': new ve.Range( 8, 34 )
				}
			]
		},
		{
			'actual': doc.selectNodes( new ve.Range( 20 ), 'branches' ),
			'expected': [
				// table/tableSection/tableRow/tableCell/list/listItem/list/listItem/paragraph
				{
					'node': lookup( documentNode, 1, 0, 0, 0, 1, 0, 1, 0, 0 ),
					'range': new ve.Range( 20 ),
					'index': 0,
					'nodeRange': new ve.Range( 20, 21 ),
					'nodeOuterRange': new ve.Range( 19, 22 ),
					'parentOuterRange': new ve.Range( 18, 23 )
				}
			]
		},
		{
			'actual': doc.selectNodes( new ve.Range( 1, 20 ), 'branches' ),
			'expected': [
				// heading
				{
					'node': lookup( documentNode, 0 ),
					'range': new ve.Range( 1, 4 ),
					'index': 0,
					'nodeRange': new ve.Range( 1, 4 ),
					'nodeOuterRange': new ve.Range( 0, 5 ),
					'parentOuterRange': new ve.Range( 0, 61 )
				},

				// table/tableSection/tableRow/tableCell/paragraph
				{
					'node': lookup( documentNode, 1, 0, 0, 0, 0 ),
					'index': 0,
					'nodeRange': new ve.Range( 10, 11 ),
					'nodeOuterRange': new ve.Range( 9, 12 ),
					'parentOuterRange': new ve.Range( 8, 34 )
				},

				// table/tableSection/tableRow/tableCell/list/listItem/paragraph
				{
					'node': lookup( documentNode, 1, 0, 0, 0, 1, 0, 0 ),
					'index': 0,
					'nodeRange': new ve.Range( 15, 16 ),
					'nodeOuterRange': new ve.Range( 14, 17 ),
					'parentOuterRange': new ve.Range( 13, 25 )
				},

				// table/tableSection/tableRow/tableCell/list/listItem/list/listItem/paragraph
				{
					'node': lookup( documentNode, 1, 0, 0, 0, 1, 0, 1, 0, 0 ),
					'range': new ve.Range( 20 ),
					'index': 0,
					'nodeRange': new ve.Range( 20, 21 ),
					'nodeOuterRange': new ve.Range( 19, 22 ),
					'parentOuterRange': new ve.Range( 18, 23 )
				}
			]
		},
		{
			'actual': doc.selectNodes( new ve.Range( 1 ), 'branches' ),
			'expected': [
				// heading
				{
					'node': lookup( documentNode, 0 ),
					'range': new ve.Range( 1 ),
					'index': 0,
					'nodeRange': new ve.Range( 1, 4 ),
					'nodeOuterRange': new ve.Range( 0, 5 ),
					'parentOuterRange': new ve.Range( 0, 61 )
				}
			]
		},
		{
			'actual': doc.selectNodes( new ve.Range( 0, 3 ), 'leaves' ),
			'expected': [
				// heading/text
				{
					'node': lookup( documentNode, 0, 0 ),
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
			'actual': doc.selectNodes( new ve.Range( 0, 11 ), 'leaves' ),
			'expected': [
				// heading/text
				{
					'node': lookup( documentNode, 0, 0 ),
					'index': 0,
					'nodeRange': new ve.Range( 1, 4 ),
					'nodeOuterRange': new ve.Range( 1, 4 ),
					'parentOuterRange': new ve.Range( 0, 5 )
				},
				// table/tableSection/tableRow/tableCell/paragraph/text
				{
					'node': lookup( documentNode, 1, 0, 0, 0, 0, 0 ),
					'index': 0,
					'nodeRange': new ve.Range( 10, 11 ),
					'nodeOuterRange': new ve.Range( 10, 11 ),
					'parentOuterRange': new ve.Range( 9, 12 )
				}
			],
			'msg': 'leaf nodes do not have ranges, leaf nodes from different levels'
		},
		{
			'actual': doc.selectNodes( new ve.Range( 29, 43 ), 'leaves' ),
			'expected': [
				// table/tableSection/tableRow/tableCell/list/listItem/paragraph/text
				{
					'node': lookup( documentNode, 1, 0, 0, 0, 2, 0, 0, 0 ),
					'index': 0,
					'nodeRange': new ve.Range( 29, 30 ),
					'nodeOuterRange': new ve.Range( 29, 30 ),
					'parentOuterRange': new ve.Range( 28, 31 )
				},
				// preformatted/text
				{
					'node': lookup( documentNode, 2, 0 ),
					'index': 0,
					'nodeRange': new ve.Range( 38, 39 ),
					'nodeOuterRange': new ve.Range( 38, 39 ),
					'parentOuterRange': new ve.Range( 37, 43 )
				},
				// preformatted/image
				{
					'node': lookup( documentNode, 2, 1 ),
					'index': 1,
					'nodeRange': new ve.Range( 40, 40 ),
					'nodeOuterRange': new ve.Range( 39, 41 ),
					'parentOuterRange': new ve.Range( 37, 43 )
				},
				// preformatted/text
				{
					'node': lookup( documentNode, 2, 2 ),
					'index': 2,
					'nodeRange': new ve.Range( 41, 42 ),
					'nodeOuterRange': new ve.Range( 41, 42 ),
					'parentOuterRange': new ve.Range( 37, 43 )
				}
			],
			'msg': 'leaf nodes that are not text nodes'
		},
		{
			'actual': doc.selectNodes( new ve.Range( 2, 16 ), 'siblings' ),
			'expected': [
				// heading
				{
					'node': lookup( documentNode, 0 ),
					'range': new ve.Range( 2, 4 ),
					'index': 0,
					'nodeRange': new ve.Range( 1, 4 ),
					'nodeOuterRange': new ve.Range( 0, 5 ),
					'parentOuterRange': new ve.Range( 0, 61 )
				},
				// table
				{
					'node': lookup( documentNode, 1 ),
					'range': new ve.Range( 6, 16 ),
					'index': 1,
					'nodeRange': new ve.Range( 6, 36 ),
					'nodeOuterRange': new ve.Range( 5, 37 ),
					'parentOuterRange': new ve.Range( 0, 61 )
				}
			],
			'msg': 'siblings at the document level'
		},
		{
			'actual': doc.selectNodes( new ve.Range( 2, 51 ), 'siblings' ),
			'expected': [
				// heading
				{
					'node': lookup( documentNode, 0 ),
					'range': new ve.Range( 2, 4 ),
					'index': 0,
					'nodeRange': new ve.Range( 1, 4 ),
					'nodeOuterRange': new ve.Range( 0, 5 ),
					'parentOuterRange': new ve.Range( 0, 61 )
				},
				// table
				{
					'node': lookup( documentNode, 1 ),
					'index': 1,
					'nodeRange': new ve.Range( 6, 36 ),
					'nodeOuterRange': new ve.Range( 5, 37 ),
					'parentOuterRange': new ve.Range( 0, 61 )
				},
				// preformatted
				{
					'node': lookup( documentNode, 2 ),
					'index': 2,
					'nodeRange': new ve.Range( 38, 42 ),
					'nodeOuterRange': new ve.Range( 37, 43 ),
					'parentOuterRange': new ve.Range( 0, 61 )
				},
				// definitionList
				{
					'node': lookup( documentNode, 3 ),
					'range': new ve.Range( 44, 51 ),
					'index': 3,
					'nodeRange': new ve.Range( 44, 54 ),
					'nodeOuterRange': new ve.Range( 43, 55 ),
					'parentOuterRange': new ve.Range( 0, 61 )
				}
			],
			'msg': 'more than 2 siblings at the document level'
		},
		{
			'actual': doc.selectNodes( new ve.Range( 1, 1 ), 'leaves' ),
			'expected': [
				// heading/text
				{
					'node': lookup( documentNode, 0, 0 ),
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
			'actual': doc.selectNodes( new ve.Range( 4, 4 ), 'leaves' ),
			'expected': [
				// heading/text
				{
					'node': lookup( documentNode, 0, 0 ),
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
			'actual': doc.selectNodes( new ve.Range( 2, 3 ), 'leaves' ),
			'expected': [
				// heading/text
				{
					'node': lookup( documentNode, 0, 0 ),
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
			'actual': doc.selectNodes( new ve.Range( 5, 5 ), 'leaves' ),
			'expected': [
				// document
				{
					'node': documentNode,
					'range': new ve.Range( 5, 5 ),
					// no 'index' because documentNode has no parent
					'indexInNode': 1,
					'nodeRange': new ve.Range( 0, 61 ),
					'nodeOuterRange': new ve.Range( 0, 61 )
				}
			],
			'msg': 'zero-length range between two children of the document'
		},
		{
			'actual': doc.selectNodes( new ve.Range( 0, 0 ), 'leaves' ),
			'expected': [
				// document
				{
					'node': documentNode,
					'range': new ve.Range( 0, 0 ),
					// no 'index' because documentNode has no parent
					'indexInNode': 0,
					'nodeRange': new ve.Range( 0, 61 ),
					'nodeOuterRange': new ve.Range( 0, 61 )
				}
			],
			'msg': 'zero-length range at the start of the document'
		},
		{
			'actual': doc.selectNodes( new ve.Range( 32, 39 ), 'leaves' ),
			'expected': [
				// table/tableSection/tableRow/tableCell/list
				{
					'node': lookup( documentNode, 1, 0, 0, 0, 2 ),
					'range': new ve.Range( 32, 32 ),
					'index': 2,
					'indexInNode': 1,
					'nodeRange': new ve.Range( 27, 32 ),
					'nodeOuterRange': new ve.Range( 26, 33 )
				},
				// preformatted/text
				{
					'node': lookup( documentNode, 2, 0 ),
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
			'actual': doc.selectNodes( new ve.Range( 2, 57 ), 'covered' ),
			'expected': [
				// heading/text
				{
					'node': lookup( documentNode, 0, 0 ),
					'range': new ve.Range( 2, 4 ),
					'index': 0,
					'nodeRange': new ve.Range( 1, 4 ),
					'nodeOuterRange': new ve.Range( 1, 4 ),
					'parentOuterRange': new ve.Range( 0, 5 )
				},
				// table
				{
					'node': lookup( documentNode, 1 ),
					// no 'range' because the table is covered completely
					'index': 1,
					'nodeRange': new ve.Range( 6, 36 ),
					'nodeOuterRange': new ve.Range( 5, 37 ),
					'parentOuterRange': new ve.Range( 0, 61 )
				},
				// preformatted
				{
					'node': lookup( documentNode, 2 ),
					// no 'range' because the node is covered completely
					'index': 2,
					'nodeRange': new ve.Range( 38, 42 ),
					'nodeOuterRange': new ve.Range( 37, 43 ),
					'parentOuterRange': new ve.Range( 0, 61 )
				},
				// definitionList
				{
					'node': lookup( documentNode, 3 ),
					// no 'range' because the node is covered completely
					'index': 3,
					'nodeRange': new ve.Range( 44, 54 ),
					'nodeOuterRange': new ve.Range( 43, 55 ),
					'parentOuterRange': new ve.Range( 0, 61 )
				},
				// paragraph/text
				{
					'node': lookup( documentNode, 4, 0 ),
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
			'actual': doc.selectNodes( new ve.Range( 14, 14 ), 'siblings' ),
			'expected': [
				// table/tableSection/tableRow/tableCell/list/listItem
				{
					'node': lookup( documentNode, 1, 0, 0, 0, 1, 0 ),
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
			'actual': doc.selectNodes( new ve.Range( 25, 27 ), 'covered' ),
			'expected': [
				// table/tableSection/tableRow/tableCell/list
				{
					'node': lookup( documentNode, 1, 0, 0, 0, 1 ),
					'range': new ve.Range( 25, 25 ),
					'index': 1,
					'indexInNode': 1,
					'nodeRange': new ve.Range( 13, 25 ),
					'nodeOuterRange': new ve.Range( 12, 26 )
				},
				// table/tableSection/tableRow/tableCell/list
				{
					'node': lookup( documentNode, 1, 0, 0, 0, 2 ),
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
			'actual': doc.selectNodes( new ve.Range( 39, 39 ), 'leaves' ),
			'expected': [
				// preformatted/text
				{
					'node': lookup( documentNode, 2, 0 ),
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
			'actual': doc.selectNodes( new ve.Range( 41, 41 ), 'leaves' ),
			'expected': [
				// preformatted/text
				{
					'node': lookup( documentNode, 2, 2 ),
					'range': new ve.Range( 41, 41 ),
					'index': 2,
					'nodeRange': new ve.Range( 41, 42 ),
					'nodeOuterRange': new ve.Range( 41, 42 ),
					'parentOuterRange': new ve.Range( 37, 43 )
				}
			],
			'msg': 'zero-length range in text node after inline node'
		}
	];
};

/**
 * Looks up a value in a node tree.
 *
 * @method
 * @param {ve.Node} root Root node to lookup from
 * @param {Number} [...] Index path
 * @param {ve.Node} Node at given path
 */
ve.example.lookupNode = function ( root ) {
	var i,
		node = root;
	for ( i = 1; i < arguments.length; i++ ) {
		node = node.children[arguments[i]];
	}
	return node;
};

ve.example.createDomElement = function ( type, attributes ) {
	var key,
		element = document.createElement( type );
	for ( key in attributes ) {
		element.setAttribute( key, attributes[key] );
	}
	return element;
};
