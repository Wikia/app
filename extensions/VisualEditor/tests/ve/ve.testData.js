veTest = {};

/*
 * Sample plain object (WikiDom).
 * 
 * There are two kinds of nodes in WikiDom:
 * 
 *     {Object} ElementNode
 *         type: {String} Symbolic node type name
 *         [attributes]: {Object} List of symbolic attribute name and literal value pairs
 *         [content]: {Object} Content node (not defined if node has children)
 *         [children]: {Object[]} Child nodes (not defined if node has content)
 * 
 *     {Object} ContentNode
 *         text: {String} Plain text data of content
 *         [annotations]: {Object[]} List of annotation objects that can be used to render text
 *             type: {String} Symbolic name of annotation type
 *             start: {Integer} Offset within text to begin annotation
 *             end: {Integer} Offset within text to end annotation
 *             [data]: {Object} Additional information, only used by more complex annotations
 */
veTest.obj = {
	'type': 'document',
	'children': [
		{
			'type': 'paragraph',
			'content': {
				'text': 'abc',
				'annotations': [
					{
						'type': 'textStyle/bold',
						'range': {
							'start': 1,
							'end': 2
						}
					},
					{
						'type': 'textStyle/italic',
						'range': {
							'start': 2,
							'end': 3
						}
					}
				]
			}
		},
		{
			'type': 'table',
			'children': [
				{
					'type': 'tableRow',
					'children': [
						{
							'type': 'tableCell',
							'children': [
								{
									'type': 'paragraph',
									'content': {
										'text': 'd'
									}
								},
								{
									'type': 'list',
									'children': [
										{
											'type': 'listItem',
											'attributes': {
												'styles': ['bullet']
											},
											'children': [
												{
													'type': 'paragraph',
													'content': {
														'text': 'e'
													}
												}
											]
										},
										{
											'type': 'listItem',
											'attributes': {
												'styles': ['bullet', 'bullet']
											},
											'children': [
												{
													'type': 'paragraph',
													'content': {
														'text': 'f'
													}
												}
											]
										},
										{
											'type': 'listItem',
											'attributes': {
												'styles': ['number']
											},
											'children': [
												{
													'type': 'paragraph',
													'content': {
														'text': 'g'
													}
												}
											]
										}
									]
								}
							]
						}
					]
				}
			]
		},
		{
			'type': 'paragraph',
			'content': {
				'text': 'h'
			}
		}
	]
};

/*
 * Sample content data.
 * 
 * There are three types of components in content data:
 * 
 *     {String} Plain text character
 *     
 *     {Array} Annotated character
 *         {String} Character
 *         {String} Hash
 *         {Object}... List of annotation object references
 *     
 *     {Object} Opening or closing structural element
 *         type: {String} Symbolic node type name, if closing element first character will be "/"
 *         node: {Object} Reference to model tree node
 *         [attributes]: {Object} List of symbolic attribute name and literal value pairs
 */
veTest.data = [
	//  0 - Beginning of paragraph
	{ 'type': 'paragraph' },
	//  1 - Plain content
	'a',
	//  2 - Annotated content
	['b', { 'type': 'textStyle/bold', 'hash': '{"type":"textStyle/bold"}' }],
	//  3 - Annotated content
	['c', { 'type': 'textStyle/italic', 'hash': '{"type":"textStyle/italic"}' }],
	//  4 - End of paragraph
	{ 'type': '/paragraph' },
	//  5 - Beginning of table
	{ 'type': 'table' },
	//  6 - Beginning of row
	{ 'type': 'tableRow' },
	//  7 - Beginning of cell
	{ 'type': 'tableCell' },
	//  8 - Beginning of paragraph
	{ 'type': 'paragraph' },
	//  9 - Plain content
	'd',
	// 10 - End of paragraph
	{ 'type': '/paragraph' },
	// 11 - Beginning of list
	{ 'type': 'list' },
	// 12 - Beginning of bullet list item
	{ 'type': 'listItem', 'attributes': { 'styles': ['bullet'] } },
	// 13 - Beginning of paragraph
	{ 'type': 'paragraph' },
	// 14 - Plain content
	'e',
	// 15 - End of paragraph
	{ 'type': '/paragraph' },
	// 16 - End of item
	{ 'type': '/listItem' },
	// 17 - Beginning of nested bullet list item
	{ 'type': 'listItem', 'attributes': { 'styles': ['bullet', 'bullet'] } },
	// 18 - Beginning of paragraph
	{ 'type': 'paragraph' },
	// 19 - Plain content
	'f',
	// 20 - End of paragraph
	{ 'type': '/paragraph' },
	// 21 - End of item
	{ 'type': '/listItem' },
	// 22 - Beginning of numbered list item
	{ 'type': 'listItem', 'attributes': { 'styles': ['number'] } },
	// 23 - Beginning of paragraph
	{ 'type': 'paragraph' },
	// 24 - Plain content
	'g',
	// 25 - End of paragraph
	{ 'type': '/paragraph' },
	// 26 - End of item
	{ 'type': '/listItem' },
	// 27 - End of list
	{ 'type': '/list' },
	// 28 - End of cell
	{ 'type': '/tableCell' },
	// 29 - End of row
	{ 'type': '/tableRow' },
	// 30 - End of table
	{ 'type': '/table' },
	// 31 - Beginning of paragraph
	{ 'type': 'paragraph' },
	// 32 - Plain content
	'h',
	// 33 - End of paragraph
	{ 'type': '/paragraph' }
];

/**
 * Sample content data index.
 * 
 * This is a node tree that describes each partition within the document's content data. This is
 * what is automatically built by the ve.DocumentNode constructor.
 */
veTest.tree = [
	new ve.dm.ParagraphNode( veTest.data[0], 3 ),
	new ve.dm.TableNode( veTest.data[5], [
		new ve.dm.TableRowNode( veTest.data[6], [
			new ve.dm.TableCellNode( veTest.data[7], [
				new ve.dm.ParagraphNode( veTest.data[8], 1 ),
				new ve.dm.ListNode( veTest.data[11], [
					new ve.dm.ListItemNode( veTest.data[12], [
						new ve.dm.ParagraphNode( veTest.data[13], 1 )
					] ),
					new ve.dm.ListItemNode( veTest.data[17], [
						new ve.dm.ParagraphNode( veTest.data[18], 1 )
					] ),
					new ve.dm.ListItemNode( veTest.data[22], [
						new ve.dm.ParagraphNode( veTest.data[23], 1 )
					] )
				] )
			] )
		] )
	] ),
	new ve.dm.ParagraphNode( veTest.data[31], 1 )
];
