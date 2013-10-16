/*!
 * VisualEditor DataModel MediaWiki-specific InternalList tests.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.dm.InternalList' );

/* Tests */

QUnit.test( 'addNode/removeNode', 6, function ( assert ) {
	var doc = ve.dm.mwExample.createExampleDocument( 'references' ),
		newInternalList = new ve.dm.InternalList( doc ),
		referenceNodes = [
			doc.documentNode.children[0].children[0],
			doc.documentNode.children[1].children[1],
			doc.documentNode.children[1].children[3],
			doc.documentNode.children[1].children[5],
			doc.documentNode.children[2].children[0],
			doc.documentNode.children[2].children[1]
		],
		expectedNodes = {
			'mwReference/': {
				'keyedNodes': {
					'auto/0': [ referenceNodes[0] ],
					'literal/bar': [ referenceNodes[1], referenceNodes[3] ],
					'literal/:3': [ referenceNodes[2] ],
					'auto/1': [ referenceNodes[4] ]
				},
				'firstNodes': [
					referenceNodes[0],
					referenceNodes[1],
					referenceNodes[2],
					referenceNodes[4]
				],
				'indexOrder': [ 0, 1, 2, 3 ],
				'uniqueListKeys': {},
				'uniqueListKeysInUse': {}
			},
			'mwReference/foo': {
				'keyedNodes': {
					'auto/2': [ referenceNodes[5] ]
				},
				'firstNodes': [ undefined, undefined, undefined, undefined, referenceNodes[5] ],
				'indexOrder': [ 4 ],
				'uniqueListKeys': {},
				'uniqueListKeysInUse': {}
			}
		};

	assert.deepEqualWithNodeTree(
		doc.internalList.nodes,
		expectedNodes,
		'Document construction populates internal list correctly'
	);

	newInternalList.addNode( 'mwReference/', 'auto/0', 0, referenceNodes[0] );
	newInternalList.addNode( 'mwReference/', 'literal/bar', 1, referenceNodes[1] );
	newInternalList.addNode( 'mwReference/', 'literal/:3', 2, referenceNodes[2] );
	newInternalList.addNode( 'mwReference/', 'literal/bar', 1, referenceNodes[3] );
	newInternalList.addNode( 'mwReference/', 'auto/1', 3, referenceNodes[4] );
	newInternalList.addNode( 'mwReference/foo', 'auto/2', 4, referenceNodes[5] );
	newInternalList.onTransact();

	assert.deepEqualWithNodeTree(
		newInternalList.nodes,
		expectedNodes,
		'Nodes added in order'
	);

	newInternalList = new ve.dm.InternalList( doc );

	newInternalList.addNode( 'mwReference/foo', 'auto/2', 4, referenceNodes[5] );
	newInternalList.addNode( 'mwReference/', 'auto/1', 3, referenceNodes[4] );
	newInternalList.addNode( 'mwReference/', 'literal/bar', 1, referenceNodes[3] );
	newInternalList.addNode( 'mwReference/', 'literal/:3', 2, referenceNodes[2] );
	newInternalList.addNode( 'mwReference/', 'literal/bar', 1, referenceNodes[1] );
	newInternalList.addNode( 'mwReference/', 'auto/0', 0, referenceNodes[0] );
	newInternalList.onTransact();


	assert.deepEqualWithNodeTree(
		newInternalList.nodes,
		expectedNodes,
		'Nodes added in reverse order'
	);

	newInternalList.removeNode( 'mwReference/', 'literal/bar', 1, referenceNodes[1] );
	newInternalList.onTransact();

	assert.deepEqualWithNodeTree(
		newInternalList.nodes,
		{
			'mwReference/': {
				'keyedNodes': {
					'auto/0': [ referenceNodes[0] ],
					'literal/bar': [ referenceNodes[3] ],
					'literal/:3': [ referenceNodes[2] ],
					'auto/1': [ referenceNodes[4] ]
				},
				'firstNodes': [
					referenceNodes[0],
					referenceNodes[3],
					referenceNodes[2],
					referenceNodes[4]
				],
				'indexOrder': [ 0, 2, 1, 3 ],
				'uniqueListKeys': {},
				'uniqueListKeysInUse': {}
			},
			'mwReference/foo': {
				'keyedNodes': {
					'auto/2': [ referenceNodes[5] ]
				},
				'firstNodes': [ undefined, undefined, undefined, undefined, referenceNodes[5] ],
				'indexOrder': [ 4 ],
				'uniqueListKeys': {},
				'uniqueListKeysInUse': {}
			}
		},
		'Keys re-ordered after one item of key removed'
	);

	newInternalList.removeNode( 'mwReference/', 'literal/bar', 1, referenceNodes[3] );
	newInternalList.onTransact();

	assert.deepEqualWithNodeTree(
		newInternalList.nodes,
		{
			'mwReference/': {
				'keyedNodes': {
					'auto/0': [ referenceNodes[0] ],
					'literal/:3': [ referenceNodes[2] ],
					'auto/1': [ referenceNodes[4] ]
				},
				'firstNodes': [
					referenceNodes[0],
					undefined,
					referenceNodes[2],
					referenceNodes[4]
				],
				'indexOrder': [ 0, 2, 3 ],
				'uniqueListKeys': {},
				'uniqueListKeysInUse': {}
			},
			'mwReference/foo': {
				'keyedNodes': {
					'auto/2': [ referenceNodes[5] ]
				},
				'firstNodes': [ undefined, undefined, undefined, undefined, referenceNodes[5] ],
				'indexOrder': [ 4 ],
				'uniqueListKeys': {},
				'uniqueListKeysInUse': {}
			}
		},
		'Keys truncated after last item of key removed'
	);

	newInternalList.removeNode( 'mwReference/', 'auto/0', 0, referenceNodes[0] );
	newInternalList.removeNode( 'mwReference/foo', 'auto/2', 4, referenceNodes[5] );
	newInternalList.removeNode( 'mwReference/', 'auto/1', 3, referenceNodes[4] );
	newInternalList.removeNode( 'mwReference/', 'literal/:3', 2, referenceNodes[2] );
	newInternalList.onTransact();

	assert.deepEqualWithNodeTree(
		newInternalList.nodes,
		{
			'mwReference/': {
				'keyedNodes': {},
				'firstNodes': new Array( 4 ),
				'indexOrder': [],
				'uniqueListKeys': {},
				'uniqueListKeysInUse': {}
			},
			'mwReference/foo': {
				'keyedNodes': {},
				'firstNodes': new Array( 5 ),
				'indexOrder': [],
				'uniqueListKeys': {},
				'uniqueListKeysInUse': {}
			}
		},
		'All nodes removed'
	);
} );

QUnit.test( 'getItemInsertion', 4, function ( assert ) {
	var insertion, index,
		doc = ve.dm.mwExample.createExampleDocument( 'references' ),
		internalList = doc.getInternalList();

	insertion = internalList.getItemInsertion( 'mwReference/', 'literal/foo', [] );
	index = internalList.getItemNodeCount();
	assert.equal( insertion.index, index, 'Insertion creates a new reference' );
	assert.deepEqual(
		insertion.transaction.getOperations(),
		[
			{ 'type': 'retain', 'length': 91 },
			{
				'type': 'replace',
				'remove': [],
				'insert': [
					{ 'type': 'internalItem' },
					{ 'type': '/internalItem' }
				]
			},
			{ 'type': 'retain', 'length': 1 }
		],
		'New reference operations match' );

	insertion = internalList.getItemInsertion( 'mwReference/', 'literal/foo', [] );
	assert.equal( insertion.index, index, 'Insertion with duplicate key reuses old index' );
	assert.equal( insertion.transaction, null, 'Insertion with duplicate key has null transaction' );
} );

QUnit.test( 'getUniqueListKey', 7, function ( assert ) {
	var generatedName,
		doc = ve.dm.mwExample.createExampleDocument( 'references' ),
		internalList = doc.getInternalList();

	generatedName = internalList.getUniqueListKey( 'mwReference/', 'auto/0', 'literal/:' );
	assert.equal( generatedName, 'literal/:0', '0 maps to 0' );
	generatedName = internalList.getUniqueListKey( 'mwReference/', 'auto/1', 'literal/:' );
	assert.equal( generatedName, 'literal/:1', '1 maps to 1' );
	generatedName = internalList.getUniqueListKey( 'mwReference/', 'auto/2', 'literal/:' );
	assert.equal( generatedName, 'literal/:2', '2 maps to 2' );
	generatedName = internalList.getUniqueListKey( 'mwReference/', 'auto/3', 'literal/:' );
	assert.equal( generatedName, 'literal/:4', '3 maps to 4 (because a literal :3 is present)' );
	generatedName = internalList.getUniqueListKey( 'mwReference/', 'auto/4', 'literal/:' );
	assert.equal( generatedName, 'literal/:5', '4 maps to 5' );

	generatedName = internalList.getUniqueListKey( 'mwReference/', 'auto/0', 'literal/:' );
	assert.equal( generatedName, 'literal/:0', 'Reusing a key reuses the name' );

	generatedName = internalList.getUniqueListKey( 'mwReference/foo', 'auto/4', 'literal/:' );
	assert.equal( generatedName, 'literal/:0', 'Different groups are treated separately' );
} );