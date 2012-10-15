module( 've/dm' );

test( 've.dm.BranchNode', 20, function() {
	// Example data (integers) is used for simplicity of testing
	var node1 = new ve.dm.BranchNode( '1' ),
		node2 = new ve.dm.BranchNode( '2' ),
		node3 = new ve.dm.BranchNode(
			'3',
			null,
			[new ve.dm.BranchNode( '3a' )]
		),
		node4 = new ve.dm.BranchNode(
			'4',
			null,
			[new ve.dm.BranchNode( '4a' ), new ve.dm.BranchNode( '4b' )]
		);
	
	// Event triggering is detected using a callback that increments a counter
	var updates = 0;
	node1.on( 'update', function() {
		updates++;
	} );
	var attaches = 0;
	node2.on( 'afterAttach', function() {
		attaches++;
	} );
	node3.on( 'afterAttach', function() {
		attaches++;
	} );
	node4.on( 'afterAttach', function() {
		attaches++;
	} );
	var detaches = 0;
	node2.on( 'afterDetach', function() {
		detaches++;
	} );
	node3.on( 'afterDetach', function() {
		detaches++;
	} );
	node4.on( 'afterDetach', function() {
		detaches++;
	} );
	function strictArrayValueEqual( a, b, msg ) {
		if ( a.length !== b.length ) {
			ok( false, msg );
			return;
		}
		for ( var i = 0; i < a.length; i++ ) {
			if ( a[i] !== b[i] ) {
				ok( false, msg );
				return;
			}
		}
		ok( true, msg );
	}
	
	// Test 1
	node1.push( node2 );
	equal( updates, 1, 'push emits update events' );
	strictArrayValueEqual( node1.getChildren(), [node2], 'push appends a node' );

	// Test 2
	equal( attaches, 1, 'push attaches added node' );
	
	// Test 3, 4
	node1.unshift( node3 );
	equal( updates, 2, 'unshift emits update events' );
	strictArrayValueEqual( node1.getChildren(), [node3, node2], 'unshift prepends a node' );
	
	// Test 5
	equal( attaches, 2, 'unshift attaches added node' );
	
	// Test 6, 7
	node1.splice( 1, 0, node4 );
	equal( updates, 3, 'splice emits update events' );
	strictArrayValueEqual( node1.getChildren(), [node3, node4, node2], 'splice inserts nodes' );
	
	// Test 8
	equal( attaches, 3, 'splice attaches added nodes' );
	
	// Test 9
	node1.reverse();
	equal( updates, 4, 'reverse emits update events' );
	
	// Test 10, 11
	node1.sort( function( a, b ) {
		return a.getChildren().length < b.getChildren().length ? -1 : 1;
	} );
	equal( updates, 5, 'sort emits update events' );
	strictArrayValueEqual(
		node1.getChildren(),
		[node2, node3, node4],
		'sort reorderes nodes correctly'
	);
	
	// Test 12, 13
	node1.pop();
	equal( updates, 6, 'pop emits update events' );
	strictArrayValueEqual(
		node1.getChildren(),
		[node2, node3],
		'pop removes the last child node'
	);

	// Test 14
	equal( detaches, 1, 'pop detaches a node' );
	
	// Test 15, 16
	node1.shift();
	equal( updates, 7, 've.ModelNode emits update events on shift' );
	strictArrayValueEqual(
		node1.getChildren(),
		[node3],
		've.ModelNode removes first Node on shift'
	);
	
	// Test 17
	equal( detaches, 2, 'shift detaches a node' );
	
	// Test 18
	strictEqual( node3.getParent(), node1, 'getParent returns the correct reference' );
	
	// Test 19
	try {
		var view = node3.createView();
	} catch ( err ){
		ok( true, 'createView throws an exception when not overridden' );
	}
} );
