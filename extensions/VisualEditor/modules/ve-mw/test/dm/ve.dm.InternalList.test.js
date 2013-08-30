/*!
 * VisualEditor DataModel MediaWiki-specific InternalList tests.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.dm.InternalList' );

/* Tests */

QUnit.test( 'addNode/removeNode', 5, function ( assert ) {
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
					':0': [ referenceNodes[0] ],
					'bar': [ referenceNodes[1], referenceNodes[3] ],
					'quux': [ referenceNodes[2] ],
					':1': [ referenceNodes[4] ],
					':2': [ referenceNodes[5] ]
				},
				'firstNodes': [
					referenceNodes[0],
					referenceNodes[1],
					referenceNodes[2],
					referenceNodes[4],
					referenceNodes[5]
				],
				'indexOrder': [ 0, 1, 2, 3, 4 ]
			}
		};

	newInternalList.addNode( 'mwReference/', ':0', 0, referenceNodes[0] );
	newInternalList.addNode( 'mwReference/', 'bar', 1, referenceNodes[1] );
	newInternalList.addNode( 'mwReference/', 'quux', 2, referenceNodes[2] );
	newInternalList.addNode( 'mwReference/', 'bar', 1, referenceNodes[3] );
	newInternalList.addNode( 'mwReference/', ':1', 3, referenceNodes[4] );
	newInternalList.addNode( 'mwReference/', ':2', 4, referenceNodes[5] );
	newInternalList.onTransact();

	assert.deepEqualWithNodeTree(
		newInternalList.nodes,
		expectedNodes,
		'Nodes added in order'
	);

	newInternalList = new ve.dm.InternalList( doc );

	newInternalList.addNode( 'mwReference/', ':2', 4, referenceNodes[5] );
	newInternalList.addNode( 'mwReference/', ':1', 3, referenceNodes[4] );
	newInternalList.addNode( 'mwReference/', 'bar', 1, referenceNodes[3] );
	newInternalList.addNode( 'mwReference/', 'quux', 2, referenceNodes[2] );
	newInternalList.addNode( 'mwReference/', 'bar', 1, referenceNodes[1] );
	newInternalList.addNode( 'mwReference/', ':0', 0, referenceNodes[0] );
	newInternalList.onTransact();


	assert.deepEqualWithNodeTree(
		newInternalList.nodes,
		expectedNodes,
		'Nodes added in reverse order'
	);

	newInternalList.removeNode( 'mwReference/', 'bar', 1, referenceNodes[1] );
	newInternalList.onTransact();

	assert.deepEqualWithNodeTree(
		newInternalList.nodes,
		{
			'mwReference/': {
				'keyedNodes': {
					':0': [ referenceNodes[0] ],
					'bar': [ referenceNodes[3] ],
					'quux': [ referenceNodes[2] ],
					':1': [ referenceNodes[4] ],
					':2': [ referenceNodes[5] ]
				},
				'firstNodes': [
					referenceNodes[0],
					referenceNodes[3],
					referenceNodes[2],
					referenceNodes[4],
					referenceNodes[5]
				],
				'indexOrder': [ 0, 2, 1, 3, 4 ]
			}
		},
		'Keys re-ordered after one item of key removed'
	);

	newInternalList.removeNode( 'mwReference/', 'bar', 1, referenceNodes[3] );
	newInternalList.onTransact();

	assert.deepEqualWithNodeTree(
		newInternalList.nodes,
		{
			'mwReference/': {
				'keyedNodes': {
					':0': [ referenceNodes[0] ],
					'quux': [ referenceNodes[2] ],
					':1': [ referenceNodes[4] ],
					':2': [ referenceNodes[5] ]
				},
				'firstNodes': [
					referenceNodes[0],
					undefined,
					referenceNodes[2],
					referenceNodes[4],
					referenceNodes[5]
				],
				'indexOrder': [ 0, 2, 3, 4 ]
			}
		},
		'Keys truncated after last item of key removed'
	);

	newInternalList.removeNode( 'mwReference/', ':0', 0, referenceNodes[0] );
	newInternalList.removeNode( 'mwReference/', ':2', 4, referenceNodes[5] );
	newInternalList.removeNode( 'mwReference/', ':1', 3, referenceNodes[4] );
	newInternalList.removeNode( 'mwReference/', 'quux', 2, referenceNodes[2] );
	newInternalList.onTransact();

	assert.deepEqualWithNodeTree(
		newInternalList.nodes,
		{
			'mwReference/': {
				'keyedNodes': {},
				'firstNodes': new Array( 5 ),
				'indexOrder': []
			}
		},
		'All nodes removed'
	);
} );

QUnit.test( 'getItemInsertion', 4, function ( assert ) {
	var insertion, index,
		doc = ve.dm.mwExample.createExampleDocument( 'references' ),
		internalList = doc.getInternalList();

	insertion = internalList.getItemInsertion( 'mwReference/', 'foo', [] );
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

	insertion = internalList.getItemInsertion( 'mwReference/', 'foo', [] );
	assert.equal( insertion.index, index, 'Insertion with duplicate key reuses old index' );
	assert.equal( insertion.transaction, null, 'Insertion with duplicate key has null transaction' );
} );
