module( 've' );

/* Stubs */

function BranchNodeStub( items, name, size ) {
	// Inheritance
	ve.BranchNode.call( this, items );

	// Properties
	this.name = name;
	this.size = size;
}

BranchNodeStub.prototype.getContentLength = function() {
	return this.size;
};

BranchNodeStub.prototype.getElementLength = function() {
	// Mimic document data which has an opening and closing around the content
	return this.size + 2;
};

ve.extendClass( BranchNodeStub, ve.BranchNode );

/* Tests */

test( 've.BranchNodeStub.getElementLength', 1, function() {
	// Test 1
	strictEqual(
		( new BranchNodeStub( [], 'a', 0 ) ).getElementLength(),
		2,
		'BranchNodeStub.getElementLength() returns initialized length plus 2 for elements'
	);
} );

// Common stubs
var a = new BranchNodeStub( [], 'a', 0 ),
	b = new BranchNodeStub( [], 'b', 1 ),
	c = new BranchNodeStub( [], 'c', 2 ),
	d = new BranchNodeStub( [], 'd', 3 ),
	e = new BranchNodeStub( [], 'e', 4 ),
	root1 = new BranchNodeStub( [a, b, c, d, e], 'root1', 20 );

test( 've.BranchNode.getRangeFromNode', 6, function() {
	// Tests 1 .. 6
	var getRangeFromNodeTests = [
		{ 'input': a, 'output': new ve.Range( 0, 2 ) },
		{ 'input': b, 'output': new ve.Range( 2, 5 ) },
		{ 'input': c, 'output': new ve.Range( 5, 9 ) },
		{ 'input': d, 'output': new ve.Range( 9, 14 ) },
		{ 'input': e, 'output': new ve.Range( 14, 20 ) },
		{ 'input': null, 'output': null }
	];
	for ( var i = 0; i < getRangeFromNodeTests.length; i++ ) {
		deepEqual(
			root1.getRangeFromNode( getRangeFromNodeTests[i].input ),
			getRangeFromNodeTests[i].output,
			'getRangeFromNode returns the correct range or null if item is not found'
		);
	}
} );

test( 've.BranchNode.getNodeFromOffset', 23, function() {
	// Tests 1 .. 22
	var getNodeFromOffsetTests = [
		// Test 1 - |[<a></a><b> </b><c>  </c><d>   </d><e>    </e>]
		{ 'input': -1, 'output': null },
		// Test 2 - [|<a></a><b> </b><c>  </c><d>   </d><e>    </e>]
		{ 'input': 0, 'output': root1 },
		// Test 3 - [<a>|</a><b> </b><c>  </c><d>   </d><e>    </e>]
		{ 'input': 1, 'output': a },
		// Test 4 - [<a></a>|<b> </b><c>  </c><d>   </d><e>    </e>]
		{ 'input': 2, 'output': root1 },
		// Test 5 - [<a></a><b>| </b><c>  </c><d>   </d><e>    </e>]
		{ 'input': 3, 'output': b },
		// Test 6 - [<a></a><b> |</b><c>  </c><d>   </d><e>    </e>]
		{ 'input': 4, 'output': b },
		// Test 7 - [<a></a><b> </b>|<c>  </c><d>   </d><e>    </e>]
		{ 'input': 5, 'output': root1 },
		// Test 8 - [<a></a><b> </b><c>|  </c><d>   </d><e>    </e>]
		{ 'input': 6, 'output': c },
		// Test 9 - [<a></a><b> </b><c> | </c><d>   </d><e>    </e>]
		{ 'input': 7, 'output': c },
		// Test 10 - [<a></a><b> </b><c>  |</c><d>   </d><e>    </e>]
		{ 'input': 8, 'output': c },
		// Test 11 - [<a></a><b> </b><c>  </c>|<d>   </d><e>    </e>]
		{ 'input': 9, 'output': root1 },
		// Test 12 - [<a></a><b> </b><c>  </c><d>|   </d><e>    </e>]
		{ 'input': 10, 'output': d },
		// Test 13 - [<a></a><b> </b><c>  </c><d> |  </d><e>    </e>]
		{ 'input': 11, 'output': d },
		// Test 14 - [<a></a><b> </b><c>  </c><d>  | </d><e>    </e>]
		{ 'input': 12, 'output': d },
		// Test 15 - [<a></a><b> </b><c>  </c><d>   |</d><e>    </e>]
		{ 'input': 13, 'output': d },
		// Test 16 - [<a></a><b> </b><c>  </c><d>   </d>|<e>    </e>]
		{ 'input': 14, 'output': root1 },
		// Test 17 - [<a></a><b> </b><c>  </c><d>   </d><e>|    </e>]
		{ 'input': 15, 'output': e },
		// Test 18 - [<a></a><b> </b><c>  </c><d>   </d><e> |   </e>]
		{ 'input': 16, 'output': e },
		// Test 19 - [<a></a><b> </b><c>  </c><d>   </d><e>  |  </e>]
		{ 'input': 17, 'output': e },
		// Test 20 - [<a></a><b> </b><c>  </c><d>   </d><e>   | </e>]
		{ 'input': 18, 'output': e },
		// Test 21 - [<a></a><b> </b><c>  </c><d>   </d><e>    |</e>]
		{ 'input': 19, 'output': e },
		// Test 22 - [<a></a><b> </b><c>  </c><d>   </d><e>    </e>|]
		{ 'input': 20, 'output': root1 },
		// Test 22 - [<a></a><b> </b><c>  </c><d>   </d><e>    </e>]|
		{ 'input': 21, 'output': null }
	];
	for ( var i = 0; i < getNodeFromOffsetTests.length; i++ ) {
		ok(
			root1.getNodeFromOffset( getNodeFromOffsetTests[i].input ) ===
			getNodeFromOffsetTests[i].output,
			'getNodeFromOffset finds the right item or returns null when out of range ' +
				'(' + getNodeFromOffsetTests[i].input + ')'
		);
	}
} );

test( 've.BranchNode.getOffsetFromNode', 6, function() {
	// Tests 1 .. 6
	var getOffsetFromNodeTests = [
		{ 'input': a, 'output': 0 },
		{ 'input': b, 'output': 2 },
		{ 'input': c, 'output': 5 },
		{ 'input': d, 'output': 9 },
		{ 'input': e, 'output': 14 },
		{ 'input': null, 'output': -1 }
	];
	for ( var i = 0; i < getOffsetFromNodeTests.length; i++ ) {
		strictEqual(
			root1.getOffsetFromNode( getOffsetFromNodeTests[i].input ),
			getOffsetFromNodeTests[i].output,
			'getOffsetFromNode finds the right offset or returns -1 when node is not found'
		);
	}
} );

test( 've.BranchNode.selectNodes', 77, function() {

	// selectNodes tests

	// <f> a b c d e f g h </f> <g> a b c d e f g h </g> <h> a b c d e f g h </h>
	//^   ^ ^ ^ ^ ^ ^ ^ ^ ^    ^   ^ ^ ^ ^ ^ ^ ^ ^ ^    ^   ^ ^ ^ ^ ^ ^ ^ ^ ^     ^
	//0   1 2 3 4 5 6 7 8 9    0   1 2 3 4 5 6 7 8 9    0   1 2 3 4 5 6 7 8 9     0
	//    0 1 2 3 4 5 6 7 8        0 1 2 3 4 5 6 7 8        0 1 2 3 4 5 6 7 8
	var f = new BranchNodeStub( [], 'f', 8 ),
		g = new BranchNodeStub( [], 'g', 8 ),
		h = new BranchNodeStub( [], 'h', 8 ),
		root2 = new BranchNodeStub( [f, g, h], 'root2', 30 ),
		big = ve.dm.DocumentNode.newFromPlainObject( veTest.obj );
	
	// Tests 1 ... 22
	// Possible positions are:
	// * before beginning
	// * at beginning
	// * middle
	// * at end
	// * past end
	var selectNodesTests = [
		// Complete set of combinations within the same node:

		// Test 1
		{
			'node': root2,
			'input': new ve.Range( 0, 0 ),
			'output': [{ 'node': root2, 'range': new ve.Range( 0, 0 ), 'globalRange': new ve.Range( 0, 0 ) }],
			'desc': 'Zero-length range before the beginning of a node'
		},
		// Test 2
		{
			'node': root2,
			'input': new ve.Range( 0, 1 ),
			'output': [{ 'node': f, 'range': new ve.Range( 0, 0 ), 'globalRange': new ve.Range( 1, 1 ) }],
			'desc': 'Range starting before the beginning of a node and ending at the beginning'
		},
		// Test 3
		{
			'node': root2,
			'input': new ve.Range( 10, 15 ),
			'output': [{ 'node': g, 'range': new ve.Range( 0, 4 ), 'globalRange': new ve.Range( 11, 15 ) }],
			'desc': 'Range starting before the beginning of a node and ending in the middle'
		},
		// Test 4
		{
			'node': root2,
			'input': new ve.Range( 20, 29 ),
			'output': [{ 'node': h, 'range': new ve.Range( 0, 8 ), 'globalRange': new ve.Range( 21, 29 ) }],
			'desc': 'Range starting before the beginning of a node and ending at the end'
		},
		// Test 5
		{
			'node': root2,
			'input': new ve.Range( 0, 10 ),
			'output': [{ 'node': f, 'globalRange': new ve.Range( 0, 10 ) } ],
			'desc': 'Range starting before the beginning of a node and ending past the end'
		},
		// Test 6
		{
			'node': root2,
			'input': new ve.Range( 11, 11 ),
			'output': [{ 'node': g, 'range': new ve.Range( 0, 0 ), 'globalRange': new ve.Range( 11, 11 ) }],
			'desc': 'Zero-length range at the beginning of a node'
		},
		// Test 7
		{
			'node': root2,
			'input': new ve.Range( 21, 26 ),
			'output': [{ 'node': h, 'range': new ve.Range( 0, 5 ), 'globalRange': new ve.Range( 21, 26 ) }],
			'desc': 'Range starting at the beginning of a node and ending in the middle'
		},
		// Test 8
		{
			'node': root2,
			'input': new ve.Range( 1, 9 ),
			'output': [{ 'node': f, 'range': new ve.Range( 0, 8 ), 'globalRange': new ve.Range( 1, 9 ) }],
			'desc': 'Range starting at the beginning of a node and ending at the end'
		},
		// Test 9
		{
			'node': root2,
			'input': new ve.Range( 11, 20 ),
			'output': [{ 'node': g, 'range': new ve.Range( 0, 8 ), 'globalRange': new ve.Range( 11, 19 ) }],
			'desc': 'Range starting at the beginning of a node and ending past the end'
		},
		// Test 10
		{
			'node': root2,
			'input': new ve.Range( 22, 22 ),
			'output': [{ 'node': h, 'range': new ve.Range( 1, 1 ), 'globalRange': new ve.Range( 22, 22 ) }],
			'desc': 'Zero-length range in the middle of a node'
		},
		// Test 11
		{
			'node': root2,
			'input': new ve.Range( 2, 7 ),
			'output': [{ 'node': f, 'range': new ve.Range( 1, 6 ), 'globalRange': new ve.Range( 2, 7 ) }],
			'desc': 'Range starting and ending in the middle of the same node'
		},
		// Test 12
		{
			'node': root2,
			'input': new ve.Range( 13, 19 ),
			'output': [{ 'node': g, 'range': new ve.Range( 2, 8 ), 'globalRange': new ve.Range( 13, 19 ) }],
			'desc': 'Range starting in the middle of a node and ending at the end'
		},
		// Test 13
		{
			'node': root2,
			'input': new ve.Range( 24, 30 ),
			'output': [{ 'node': h, 'range': new ve.Range( 3, 8 ), 'globalRange': new ve.Range( 24, 29 ) }],
			'desc': 'Range starting in the middle of a node and ending past the end'
		},
		// Test 14
		{
			'node': root2,
			'input': new ve.Range( 9, 9 ),
			'output': [{ 'node': f, 'range': new ve.Range( 8, 8 ), 'globalRange': new ve.Range( 9, 9 ) }],
			'desc': 'Zero-length range at the end of a node'
		},
		// Test 15
		{
			'node': root2,
			'input': new ve.Range( 19, 20 ),
			'output': [{ 'node': g, 'range': new ve.Range( 8, 8 ), 'globalRange': new ve.Range( 19, 19 ) }],
			'desc': 'Range starting at the end of a node and ending past the end'
		},
		// Test 16
		{
			'node': root2,
			'input': new ve.Range( 30, 30 ),
			'output': [{ 'node': root2, 'range': new ve.Range( 30, 30 ), 'globalRange': new ve.Range( 30, 30 ) }],
			'desc': 'Zero-length range past the end of a node'
		},
		// Test 17
		{
			'node': root2,
			'input': new ve.Range( 20, 20 ),
			'output': [{ 'node': root2, 'range': new ve.Range( 20, 20 ), 'globalRange': new ve.Range( 20, 20 ) }],
			'desc': 'Zero-length range between two nodes'
		},

		// Complete set of combinations for cross-node selections. Generated with help of a script

		// Test 18
		{
			'node': root2,
			'input': new ve.Range( 0, 11 ),
			'output': [
				{ 'node': f, 'globalRange': new ve.Range( 0, 10 ) },
				{ 'node': g, 'range': new ve.Range( 0, 0 ), 'globalRange': new ve.Range( 11, 11 ) }
			],
			'desc': 'Range starting before the beginning of the first node and ending at the beginning of the second node'
		},
		// Test 19
		{
			'node': root2,
			'input': new ve.Range( 0, 14 ),
			'output': [
				{ 'node': f, 'globalRange': new ve.Range( 0, 10 ) },
				{ 'node': g, 'range': new ve.Range( 0, 3 ), 'globalRange': new ve.Range( 11, 14 ) }
			],
			'desc': 'Range starting before the beginning of the first node and ending in the middle of the second node'
		},
		// Test 20
		{
			'node': root2,
			'input': new ve.Range( 0, 19 ),
			'output': [
				{ 'node': f, 'globalRange': new ve.Range( 0, 10 ) },
				{ 'node': g, 'range': new ve.Range( 0, 8 ), 'globalRange': new ve.Range( 11, 19 ) }
			],
			'desc': 'Range starting before the beginning of the first node and ending at the end of the second node'
		},
		// Test 21
		{
			'node': root2,
			'input': new ve.Range( 0, 20 ),
			'output': [
				{ 'node': f, 'globalRange': new ve.Range( 0, 10 ) },
				{ 'node': g, 'globalRange': new ve.Range( 10, 20 ) }
			],
			'desc': 'Range starting before the beginning of the first node and ending between the second and the third node'
		},
		// Test 22
		{
			'node': root2,
			'input': new ve.Range( 0, 21 ),
			'output': [
				{ 'node': f, 'globalRange': new ve.Range( 0, 10 ) },
				{ 'node': g, 'globalRange': new ve.Range( 10, 20 ) },
				{ 'node': h, 'range': new ve.Range( 0, 0 ), 'globalRange': new ve.Range( 21, 21 ) }
			],
			'desc': 'Range starting before the beginning of the first node and ending at the beginning of the third node'
		},
		// Test 23
		{
			'node': root2,
			'input': new ve.Range( 0, 27 ),
			'output': [
				{ 'node': f, 'globalRange': new ve.Range( 0, 10 ) },
				{ 'node': g, 'globalRange': new ve.Range( 10, 20 ) },
				{ 'node': h, 'range': new ve.Range( 0, 6 ), 'globalRange': new ve.Range( 21, 27 ) }
			],
			'desc': 'Range starting before the beginning of the first node and ending in the middle of the third node'
		},
		// Test 24
		{
			'node': root2,
			'input': new ve.Range( 0, 29 ),
			'output': [
				{ 'node': f, 'globalRange': new ve.Range( 0, 10 ) },
				{ 'node': g, 'globalRange': new ve.Range( 10, 20 ) },
				{ 'node': h, 'range': new ve.Range( 0, 8 ), 'globalRange': new ve.Range( 21, 29 ) }
			],
			'desc': 'Range starting before the beginning of the first node and ending at the end of the third node'
		},
		// Test 25
		{
			'node': root2,
			'input': new ve.Range( 0, 30 ),
			'output': [
				{ 'node': f, 'globalRange': new ve.Range( 0, 10 ) },
				{ 'node': g, 'globalRange': new ve.Range( 10, 20 ) },
				{ 'node': h, 'globalRange': new ve.Range( 20, 30 ) }
			],
			'desc': 'Range starting before the beginning of the first node and ending past the end of the third node'
		},
		// Test 26
		{
			'node': root2,
			'input': new ve.Range( 1, 11 ),
			'output': [
				{ 'node': f, 'range': new ve.Range( 0, 8 ), 'globalRange': new ve.Range( 1, 9 ) },
				{ 'node': g, 'range': new ve.Range( 0, 0 ), 'globalRange': new ve.Range( 11, 11 ) }
			],
			'desc': 'Range starting at the beginning of the first node and ending at the beginning of the second node'
		},
		// Test 27
		{
			'node': root2,
			'input': new ve.Range( 1, 14 ),
			'output': [
				{ 'node': f, 'range': new ve.Range( 0, 8 ), 'globalRange': new ve.Range( 1, 9 ) },
				{ 'node': g, 'range': new ve.Range( 0, 3 ), 'globalRange': new ve.Range( 11, 14 ) }
			],
			'desc': 'Range starting at the beginning of the first node and ending in the middle of the second node'
		},
		// Test 28
		{
			'node': root2,
			'input': new ve.Range( 1, 19 ),
			'output': [
				{ 'node': f, 'range': new ve.Range( 0, 8 ), 'globalRange': new ve.Range( 1, 9 ) },
				{ 'node': g, 'range': new ve.Range( 0, 8 ), 'globalRange': new ve.Range( 11, 19 ) }
			],
			'desc': 'Range starting at the beginning of the first node and ending at the end of the second node'
		},
		// Test 29
		{
			'node': root2,
			'input': new ve.Range( 1, 20 ),
			'output': [
				{ 'node': f, 'range': new ve.Range( 0, 8 ), 'globalRange': new ve.Range( 1, 9 ) },
				{ 'node': g, 'globalRange': new ve.Range( 10, 20 ) }
			],
			'desc': 'Range starting at the beginning of the first node and ending between the second and the third node'
		},
		// Test 30
		{
			'node': root2,
			'input': new ve.Range( 1, 21 ),
			'output': [
				{ 'node': f, 'range': new ve.Range( 0, 8 ), 'globalRange': new ve.Range( 1, 9 ) },
				{ 'node': g, 'globalRange': new ve.Range( 10, 20 ) },
				{ 'node': h, 'range': new ve.Range( 0, 0 ), 'globalRange': new ve.Range( 21, 21 ) }
			],
			'desc': 'Range starting at the beginning of the first node and ending at the beginning of the third node'
		},
		// Test 31
		{
			'node': root2,
			'input': new ve.Range( 1, 27 ),
			'output': [
				{ 'node': f, 'range': new ve.Range( 0, 8 ), 'globalRange': new ve.Range( 1, 9 ) },
				{ 'node': g, 'globalRange': new ve.Range( 10, 20 ) },
				{ 'node': h, 'range': new ve.Range( 0, 6 ), 'globalRange': new ve.Range( 21, 27 ) }
			],
			'desc': 'Range starting at the beginning of the first node and ending in the middle of the third node'
		},
		// Test 32
		{
			'node': root2,
			'input': new ve.Range( 1, 29 ),
			'output': [
				{ 'node': f, 'range': new ve.Range( 0, 8 ), 'globalRange': new ve.Range( 1, 9 ) },
				{ 'node': g, 'globalRange': new ve.Range( 10, 20 ) },
				{ 'node': h, 'range': new ve.Range( 0, 8 ), 'globalRange': new ve.Range( 21, 29 ) }
			],
			'desc': 'Range starting at the beginning of the first node and ending at the end of the third node'
		},
		// Test 33
		{
			'node': root2,
			'input': new ve.Range( 1, 30 ),
			'output': [
				{ 'node': f, 'range': new ve.Range( 0, 8 ), 'globalRange': new ve.Range( 1, 9 ) },
				{ 'node': g, 'globalRange': new ve.Range( 10, 20 ) },
				{ 'node': h, 'globalRange': new ve.Range( 20, 30 ) }
			],
			'desc': 'Range starting at the beginning of the first node and ending past the end of the third node'
		},
		// Test 34
		{
			'node': root2,
			'input': new ve.Range( 5, 11 ),
			'output': [
				{ 'node': f, 'range': new ve.Range( 4, 8 ), 'globalRange': new ve.Range( 5, 9 ) },
				{ 'node': g, 'range': new ve.Range( 0, 0 ), 'globalRange': new ve.Range( 11, 11 ) }
			],
			'desc': 'Range starting in the middle of the first node and ending at the beginning of the second node'
		},
		// Test 35
		{
			'node': root2,
			'input': new ve.Range( 5, 14 ),
			'output': [
				{ 'node': f, 'range': new ve.Range( 4, 8 ), 'globalRange': new ve.Range( 5, 9 ) },
				{ 'node': g, 'range': new ve.Range( 0, 3 ), 'globalRange': new ve.Range( 11, 14 ) }
			],
			'desc': 'Range starting in the middle of the first node and ending in the middle of the second node'
		},
		// Test 36
		{
			'node': root2,
			'input': new ve.Range( 5, 19 ),
			'output': [
				{ 'node': f, 'range': new ve.Range( 4, 8 ), 'globalRange': new ve.Range( 5, 9 ) },
				{ 'node': g, 'range': new ve.Range( 0, 8 ), 'globalRange': new ve.Range( 11, 19 ) }
			],
			'desc': 'Range starting in the middle of the first node and ending at the end of the second node'
		},
		// Test 37
		{
			'node': root2,
			'input': new ve.Range( 5, 20 ),
			'output': [
				{ 'node': f, 'range': new ve.Range( 4, 8 ), 'globalRange': new ve.Range( 5, 9 ) },
				{ 'node': g, 'globalRange': new ve.Range( 10, 20 ) }
			],
			'desc': 'Range starting in the middle of the first node and ending between the second and the third node'
		},
		// Test 38
		{
			'node': root2,
			'input': new ve.Range( 5, 21 ),
			'output': [
				{ 'node': f, 'range': new ve.Range( 4, 8 ), 'globalRange': new ve.Range( 5, 9 ) },
				{ 'node': g, 'globalRange': new ve.Range( 10, 20 ) },
				{ 'node': h, 'range': new ve.Range( 0, 0 ), 'globalRange': new ve.Range( 21, 21 ) }
			],
			'desc': 'Range starting in the middle of the first node and ending at the beginning of the third node'
		},
		// Test 39
		{
			'node': root2,
			'input': new ve.Range( 5, 27 ),
			'output': [
				{ 'node': f, 'range': new ve.Range( 4, 8 ), 'globalRange': new ve.Range( 5, 9 ) },
				{ 'node': g, 'globalRange': new ve.Range( 10, 20 ) },
				{ 'node': h, 'range': new ve.Range( 0, 6 ), 'globalRange': new ve.Range( 21, 27 ) }
			],
			'desc': 'Range starting in the middle of the first node and ending in the middle of the third node'
		},
		// Test 40
		{
			'node': root2,
			'input': new ve.Range( 5, 29 ),
			'output': [
				{ 'node': f, 'range': new ve.Range( 4, 8 ), 'globalRange': new ve.Range( 5, 9 ) },
				{ 'node': g, 'globalRange': new ve.Range( 10, 20 ) },
				{ 'node': h, 'range': new ve.Range( 0, 8 ), 'globalRange': new ve.Range( 21, 29 ) }
			],
			'desc': 'Range starting in the middle of the first node and ending at the end of the third node'
		},
		// Test 41
		{
			'node': root2,
			'input': new ve.Range( 5, 30 ),
			'output': [
				{ 'node': f, 'range': new ve.Range( 4, 8 ), 'globalRange': new ve.Range( 5, 9 ) },
				{ 'node': g, 'globalRange': new ve.Range( 10, 20 ) },
				{ 'node': h, 'globalRange': new ve.Range( 20, 30 ) }
			],
			'desc': 'Range starting in the middle of the first node and ending past the end of the third node'
		},
		// Test 42
		{
			'node': root2,
			'input': new ve.Range( 9, 11 ),
			'output': [
				{ 'node': f, 'range': new ve.Range( 8, 8 ), 'globalRange': new ve.Range( 9, 9 ) },
				{ 'node': g, 'range': new ve.Range( 0, 0 ), 'globalRange': new ve.Range( 11, 11 ) }
			],
			'desc': 'Range starting at the end of the first node and ending at the beginning of the second node'
		},
		// Test 43
		{
			'node': root2,
			'input': new ve.Range( 9, 14 ),
			'output': [
				{ 'node': f, 'range': new ve.Range( 8, 8 ), 'globalRange': new ve.Range( 9, 9 ) },
				{ 'node': g, 'range': new ve.Range( 0, 3 ), 'globalRange': new ve.Range( 11, 14 ) }
			],
			'desc': 'Range starting at the end of the first node and ending in the middle of the second node'
		},
		// Test 44
		{
			'node': root2,
			'input': new ve.Range( 9, 19 ),
			'output': [
				{ 'node': f, 'range': new ve.Range( 8, 8 ), 'globalRange': new ve.Range( 9, 9 ) },
				{ 'node': g, 'range': new ve.Range( 0, 8 ), 'globalRange': new ve.Range( 11, 19 ) }
			],
			'desc': 'Range starting at the end of the first node and ending at the end of the second node'
		},
		// Test 45
		{
			'node': root2,
			'input': new ve.Range( 9, 20 ),
			'output': [
				{ 'node': f, 'range': new ve.Range( 8, 8 ), 'globalRange': new ve.Range( 9, 9 ) },
				{ 'node': g, 'globalRange': new ve.Range( 10, 20 ) }
			],
			'desc': 'Range starting at the end of the first node and ending between the second and the third node'
		},
		// Test 46
		{
			'node': root2,
			'input': new ve.Range( 9, 21 ),
			'output': [
				{ 'node': f, 'range': new ve.Range( 8, 8 ), 'globalRange': new ve.Range( 9, 9 ) },
				{ 'node': g, 'globalRange': new ve.Range( 10, 20 ) },
				{ 'node': h, 'range': new ve.Range( 0, 0 ), 'globalRange': new ve.Range( 21, 21 ) }
			],
			'desc': 'Range starting at the end of the first node and ending at the beginning of the third node'
		},
		// Test 47
		{
			'node': root2,
			'input': new ve.Range( 9, 27 ),
			'output': [
				{ 'node': f, 'range': new ve.Range( 8, 8 ), 'globalRange': new ve.Range( 9, 9 ) },
				{ 'node': g, 'globalRange': new ve.Range( 10, 20 ) },
				{ 'node': h, 'range': new ve.Range( 0, 6 ), 'globalRange': new ve.Range( 21, 27 ) }
			],
			'desc': 'Range starting at the end of the first node and ending in the middle of the third node'
		},
		// Test 48
		{
			'node': root2,
			'input': new ve.Range( 9, 29 ),
			'output': [
				{ 'node': f, 'range': new ve.Range( 8, 8 ), 'globalRange': new ve.Range( 9, 9 ) },
				{ 'node': g, 'globalRange': new ve.Range( 10, 20 ) },
				{ 'node': h, 'range': new ve.Range( 0, 8 ), 'globalRange': new ve.Range( 21, 29 ) }
			],
			'desc': 'Range starting at the end of the first node and ending at the end of the third node'
		},
		// Test 49
		{
			'node': root2,
			'input': new ve.Range( 9, 30 ),
			'output': [
				{ 'node': f, 'range': new ve.Range( 8, 8 ), 'globalRange': new ve.Range( 9, 9 ) },
				{ 'node': g, 'globalRange': new ve.Range( 10, 20 ) },
				{ 'node': h, 'globalRange': new ve.Range( 20, 30 ) }
			],
			'desc': 'Range starting at the end of the first node and ending past the end of the third node'
		},
		// Test 50
		{
			'node': root2,
			'input': new ve.Range( 10, 21 ),
			'output': [
				{ 'node': g, 'globalRange': new ve.Range( 10, 20 ) },
				{ 'node': h, 'range': new ve.Range( 0, 0 ), 'globalRange': new ve.Range( 21, 21 ) }
			],
			'desc': 'Range starting between the first and the second node and ending at the beginning of the third node'
		},
		// Test 51
		{
			'node': root2,
			'input': new ve.Range( 10, 27 ),
			'output': [
				{ 'node': g, 'globalRange': new ve.Range( 10, 20 ) },
				{ 'node': h, 'range': new ve.Range( 0, 6 ), 'globalRange': new ve.Range( 21, 27 ) }
			],
			'desc': 'Range starting between the first and the second node and ending in the middle of the third node'
		},
		// Test 52
		{
			'node': root2,
			'input': new ve.Range( 10, 29 ),
			'output': [
				{ 'node': g, 'globalRange': new ve.Range( 10, 20 ) },
				{ 'node': h, 'range': new ve.Range( 0, 8 ), 'globalRange': new ve.Range( 21, 29 ) }
			],
			'desc': 'Range starting between the first and the second node and ending at the end of the third node'
		},
		// Test 53
		{
			'node': root2,
			'input': new ve.Range( 10, 30 ),
			'output': [
				{ 'node': g, 'globalRange': new ve.Range( 10, 20 ) },
				{ 'node': h, 'globalRange': new ve.Range( 20, 30 ) }
			],
			'desc': 'Range starting between the first and the second node and ending past the end of the third node'
		},
		// Test 54
		{
			'node': root2,
			'input': new ve.Range( 11, 21 ),
			'output': [
				{ 'node': g, 'range': new ve.Range( 0, 8 ), 'globalRange': new ve.Range( 11, 19 ) },
				{ 'node': h, 'range': new ve.Range( 0, 0 ), 'globalRange': new ve.Range( 21, 21 ) }
			],
			'desc': 'Range starting at the beginning of the second node and ending at the beginning of the third node'
		},
		// Test 55
		{
			'node': root2,
			'input': new ve.Range( 11, 27 ),
			'output': [
				{ 'node': g, 'range': new ve.Range( 0, 8 ), 'globalRange': new ve.Range( 11, 19 ) },
				{ 'node': h, 'range': new ve.Range( 0, 6 ), 'globalRange': new ve.Range( 21, 27 ) }
			],
			'desc': 'Range starting at the beginning of the second node and ending in the middle of the third node'
		},
		// Test 56
		{
			'node': root2,
			'input': new ve.Range( 11, 29 ),
			'output': [
				{ 'node': g, 'range': new ve.Range( 0, 8 ), 'globalRange': new ve.Range( 11, 19 ) },
				{ 'node': h, 'range': new ve.Range( 0, 8 ), 'globalRange': new ve.Range( 21, 29 ) }
			],
			'desc': 'Range starting at the beginning of the second node and ending at the end of the third node'
		},
		// Test 57
		{
			'node': root2,
			'input': new ve.Range( 11, 30 ),
			'output': [
				{ 'node': g, 'range': new ve.Range( 0, 8 ), 'globalRange': new ve.Range( 11, 19 ) },
				{ 'node': h, 'globalRange': new ve.Range( 20, 30 ) }
			],
			'desc': 'Range starting at the beginning of the second node and ending past the end of the third node'
		},
		// Test 58
		{
			'node': root2,
			'input': new ve.Range( 14, 21 ),
			'output': [
				{ 'node': g, 'range': new ve.Range( 3, 8 ), 'globalRange': new ve.Range( 14, 19 ) },
				{ 'node': h, 'range': new ve.Range( 0, 0 ), 'globalRange': new ve.Range( 21, 21 ) }
			],
			'desc': 'Range starting in the middle of the second node and ending at the beginning of the third node'
		},
		// Test 59
		{
			'node': root2,
			'input': new ve.Range( 14, 27 ),
			'output': [
				{ 'node': g, 'range': new ve.Range( 3, 8 ), 'globalRange': new ve.Range( 14, 19 ) },
				{ 'node': h, 'range': new ve.Range( 0, 6 ), 'globalRange': new ve.Range( 21, 27 ) }
			],
			'desc': 'Range starting in the middle of the second node and ending in the middle of the third node'
		},
		// Test 60
		{
			'node': root2,
			'input': new ve.Range( 14, 29 ),
			'output': [
				{ 'node': g, 'range': new ve.Range( 3, 8 ), 'globalRange': new ve.Range( 14, 19 ) },
				{ 'node': h, 'range': new ve.Range( 0, 8 ), 'globalRange': new ve.Range( 21, 29 ) }
			],
			'desc': 'Range starting in the middle of the second node and ending at the end of the third node'
		},
		// Test 61
		{
			'node': root2,
			'input': new ve.Range( 14, 30 ),
			'output': [
				{ 'node': g, 'range': new ve.Range( 3, 8 ), 'globalRange': new ve.Range( 14, 19 ) },
				{ 'node': h, 'globalRange': new ve.Range( 20, 30 ) }
			],
			'desc': 'Range starting in the middle of the second node and ending past the end of the third node'
		},
		// Test 62
		{
			'node': root2,
			'input': new ve.Range( 19, 21 ),
			'output': [
				{ 'node': g, 'range': new ve.Range( 8, 8 ), 'globalRange': new ve.Range( 19, 19 ) },
				{ 'node': h, 'range': new ve.Range( 0, 0 ), 'globalRange': new ve.Range( 21, 21 ) }
			],
			'desc': 'Range starting at the end of the second node and ending at the beginning of the third node'
		},
		// Test 63
		{
			'node': root2,
			'input': new ve.Range( 19, 27 ),
			'output': [
				{ 'node': g, 'range': new ve.Range( 8, 8 ), 'globalRange': new ve.Range( 19, 19 ) },
				{ 'node': h, 'range': new ve.Range( 0, 6 ), 'globalRange': new ve.Range( 21, 27 ) }
			],
			'desc': 'Range starting at the end of the second node and ending in the middle of the third node'
		},
		// Test 64
		{
			'node': root2,
			'input': new ve.Range( 19, 29 ),
			'output': [
				{ 'node': g, 'range': new ve.Range( 8, 8 ), 'globalRange': new ve.Range( 19, 19 ) },
				{ 'node': h, 'range': new ve.Range( 0, 8 ), 'globalRange': new ve.Range( 21, 29 ) }
			],
			'desc': 'Range starting at the end of the second node and ending at the end of the third node'
		},
		// Test 65
		{
			'node': root2,
			'input': new ve.Range( 19, 30 ),
			'output': [
				{ 'node': g, 'range': new ve.Range( 8, 8 ), 'globalRange': new ve.Range( 19, 19 ) },
				{ 'node': h, 'globalRange': new ve.Range( 20, 30 ) }
			],
			'desc': 'Range starting at the end of the second node and ending past the end of the third node'
		},
		// Tests for childless nodes

		// Test 66
		{
			'node': g,
			'input': new ve.Range( 1, 3 ),
			'output': [
				{ 'node': g, 'range': new ve.Range( 1, 3 ), 'globalRange': new ve.Range( 1, 3 ) }
			],
			'desc': 'Childless node given, range not out of bounds'
		},
		// Test 67
		{
			'node': g,
			'input': new ve.Range( 0, 8 ),
			'output': [
				{ 'node': g, 'range': new ve.Range( 0, 8 ), 'globalRange': new ve.Range( 0, 8 ) }
			],
			'desc': 'Childless node given, range covers entire node'
		},
		// Tests for out-of-bounds cases

		// Test 68
		{
			'node': g,
			'input': new ve.Range( -1, 3 ),
			'exception': /^The start offset of the range is negative$/,
			'desc': 'Childless node given, range start out of bounds'
		},
		// Test 69
		{
			'node': g,
			'input': new ve.Range( 1, 9 ),
			'exception': /^The end offset of the range is past the end of the node$/,
			'desc': 'Childless node given, range end out of bounds'
		},
		// Test 70
		{
			'node': root2,
			'input': new ve.Range( 31, 35 ),
			'exception': /^The start offset of the range is past the end of the node$/,
			'desc': 'Node with children given, range start out of bounds'
		},
		// Test 71
		{
			'node': root2,
			'input': new ve.Range( 30, 35 ),
			'exception': /^The end offset of the range is past the end of the node$/,
			'desc': 'Node with children given, range end out of bounds'
		},
		// Tests for recursion cases

		// Test 72
		{
			'node': big,
			'input': new ve.Range( 2, 10 ),
			'output': [
				{ 'node': big.children[0], 'range': new ve.Range( 1, 3 ), 'globalRange': new ve.Range( 2, 4 ) },
				{ 'node': big.children[1].children[0].children[0].children[0], 'range': new ve.Range( 0, 1 ), 'globalRange': new ve.Range( 9, 10 ) }
			],
			'desc': 'Select from before the b to after the d'
		},
		// Test 73
		{
			'node': big,
			'input': new ve.Range( 3, 33 ),
			'output': [
				{ 'node': big.children[0], 'range': new ve.Range( 2, 3 ), 'globalRange': new ve.Range( 3, 4 ) },
				{ 'node': big.children[1], 'globalRange': new ve.Range( 5, 31 ) },
				{ 'node': big.children[2], 'range': new ve.Range( 0, 1 ), 'globalRange': new ve.Range( 32, 33 ) }
			],
			'desc': 'Select from before the c to after the h'
		},
		// Test 74
		{
			'node': big,
			'input': new ve.Range( 9, 20 ),
			'output': [
				{ 'node': big.children[1].children[0].children[0].children[0], 'range': new ve.Range( 0, 1 ), 'globalRange': new ve.Range( 9, 10 ) },
				{ 'node': big.children[1].children[0].children[0].children[1].children[0], 'globalRange': new ve.Range( 12, 17 ) },
				{ 'node': big.children[1].children[0].children[0].children[1].children[1].children[0], 'range': new ve.Range( 0, 1 ), 'globalRange': new ve.Range( 19, 20 ) }
			],
			'desc': 'Select from before the d to after the f, with recursion'
		},
		// Test 75
		{
			'node': big,
			'input': new ve.Range( 9, 20 ),
			'shallow': true,
			'output': [
				{ 'node': big.children[1], 'range': new ve.Range( 3, 14 ), 'globalRange': new ve.Range( 9, 20 ) }
			],
			'desc': 'Select from before the d to after the f, without recursion'
		},
		// Test 76
		{
			'node': big,
			'input': new ve.Range( 3, 9 ),
			'output': [
				{ 'node': big.children[0], 'range': new ve.Range( 2, 3 ), 'globalRange': new ve.Range( 3, 4 ) },
				{ 'node': big.children[1].children[0].children[0].children[0], 'range': new ve.Range( 0, 0 ), 'globalRange': new ve.Range( 9, 9 ) }
			],
			'desc': 'Select from before the c to before the d'
		},
		// Test 77
		{
			'node': big,
			'input': new ve.Range( 3, 9 ),
			'shallow': true,
			'output': [
				{ 'node': big.children[0], 'range': new ve.Range( 2, 3 ), 'globalRange': new ve.Range( 3, 4 ) },
				{ 'node': big.children[1], 'range': new ve.Range( 0, 3 ), 'globalRange': new ve.Range( 6, 9 ) }
			],
			'desc': 'Select from before the c to before the d, without recursion'
		}
	];

	function compare( a, b ) {
		if ( $.isArray( a ) && $.isArray( b ) && a.length === b.length ) {
			for ( var i = 0; i < a.length; i++ ) {
				if (
					a[i].node !== b[i].node ||
					(
						( typeof a[i].range !== typeof b[i].range ) ||
						(
							a[i].range !== undefined &&
							(
								a[i].range.start !== b[i].range.start ||
								a[i].range.end !== b[i].range.end
							)
						)
					) || (
						( typeof a[i].globalRange !== typeof b[i].globalRange ) ||
						(
							a[i].globalRange !== undefined &&
							(
								a[i].globalRange.start !== b[i].globalRange.start ||
								a[i].globalRange.end !== b[i].globalRange.end
							)
						)
					)
				) {
					return false;
				}
			}
			return true;
		}
		return false;
	}
	function select( input, shallow ) {
		return function() {
			selectNodesTests[i].node.selectNodes( input, shallow );
		};
	}

	for ( var i = 0; i < selectNodesTests.length; i++ ) {
		if ( 'output' in selectNodesTests[i] ) {
			var result = selectNodesTests[i].node.selectNodes(
					selectNodesTests[i].input, selectNodesTests[i].shallow
				);
			ok(
				compare( result, selectNodesTests[i].output ),
				selectNodesTests[i].desc +
					' (from ' + selectNodesTests[i].input.start +
					' to ' + selectNodesTests[i].input.end + ')'
			);
			if ( console && console.log && !compare( result, selectNodesTests[i].output ) ) {
				console.log( "Test " + (i+1) + " FAILED" );
				console.log( result );
				console.log( selectNodesTests[i].output );
			}
		} else if ( 'exception' in selectNodesTests[i] ) {
			raises(
				function() {
					selectNodesTests[i].node.selectNodes(
						selectNodesTests[i].input,
						selectNodesTests[i].shallow
					);
				},
				selectNodesTests[i].exception,
				selectNodesTests[i].desc
			);
		}
	}
} );

test( 've.BranchNode.traverseLeafNodes', 11, function() {
	var root3 = ve.dm.DocumentNode.newFromPlainObject( veTest.obj );
	
	var tests = [
		// Test 1 & 2
		{
			'node': root3,
			'output': [
				root3.children[0],
				root3.children[1].children[0].children[0].children[0],
				root3.children[1].children[0].children[0].children[1].children[0].children[0],
				root3.children[1].children[0].children[0].children[1].children[1].children[0],
				root3.children[1].children[0].children[0].children[1].children[2].children[0],
				root3.children[2]
			],
			'reverse': true,
			'desc': 'Traversing the entire document returns all leaf nodes'
		},
		// Test 3 & 4
		{
			'node': root3,
			'output': [
				root3.children[0],
				root3.children[1].children[0].children[0].children[0],
				root3.children[1].children[0].children[0].children[1].children[0].children[0]
			],
			'reverse': [
				root3.children[2],
				root3.children[1].children[0].children[0].children[1].children[2].children[0],
				root3.children[1].children[0].children[0].children[1].children[1].children[0],
				root3.children[1].children[0].children[0].children[1].children[0].children[0]
			],
			'callback': function( node ) {
				if ( node === root3.children[1].children[0].children[0].children[1].children[0].children[0] ) {
					return false;
				}
			},
			'desc': 'Returning false from the callback stops the traversal'
		},
		// Test 5 & 6
		{
			'node': root3,
			'output': [
				root3.children[1].children[0].children[0].children[1].children[1].children[0],
				root3.children[1].children[0].children[0].children[1].children[2].children[0],
				root3.children[2]
			],
			'reverse': [
				root3.children[1].children[0].children[0].children[1].children[1].children[0],
				root3.children[1].children[0].children[0].children[1].children[0].children[0],
				root3.children[1].children[0].children[0].children[0],
				root3.children[0]
			],
			'from': root3.children[1].children[0].children[0].children[1].children[1].children[0],
			'desc': 'Starting at a leaf node returns that leaf node and everything after it',
			'reverseDesc': 'Starting at a leaf node returns that leaf node and everything before it (in reverse)'
		},
		// Test 7 & 8
		{
			'node': root3,
			'output': [
				root3.children[1].children[0].children[0].children[0],
				root3.children[1].children[0].children[0].children[1].children[0].children[0],
				root3.children[1].children[0].children[0].children[1].children[1].children[0],
				root3.children[1].children[0].children[0].children[1].children[2].children[0],
				root3.children[2]
			],
			'reverse': [
				root3.children[0]
			],
			'from': root3.children[1],
			'desc': 'Starting at a non-leaf node returns all leaf nodes inside and after it',
			'reverseDesc': 'Starting at a non-leaf node returns all leaf nodes before it and none inside (in reverse)'
		},
		// Test 9 & 10
		{
			'node': root3.children[1],
			'output': [
				root3.children[1].children[0].children[0].children[0],
				root3.children[1].children[0].children[0].children[1].children[0].children[0],
				root3.children[1].children[0].children[0].children[1].children[1].children[0],
				root3.children[1].children[0].children[0].children[1].children[2].children[0]
			],
			'reverse': true,
			'desc': 'Calling traverseLeafNodes() on a non-root node only returns leaf nodes inside that node'
		},
		// Test 11
		{
			'node': root3.children[1],
			'from': root3.children[2],
			'exception': /^from parameter passed to traverseLeafNodes\(\) must be a descendant$/,
			'desc': 'Passing a sibling for from results in an exception'
		}
	];
	
	for ( var i = 0; i < tests.length; i++ ) {
		executeTest( tests[i] );
		if ( tests[i].reverse !== undefined ) {
			var reversed = {
				'node': tests[i].node,
				'from': tests[i].from,
				'callback': tests[i].callback,
				'exception': tests[i].exception,
				'isReversed': true,
				'desc': tests[i].reverseDesc || tests[i].desc + ' (in reverse)'
			};
			if ( tests[i].output !== undefined && tests[i].reverse === true ) {
				reversed.output = tests[i].output.reverse();
			} else {
				reversed.output = tests[i].reverse;
			}
			executeTest( reversed );
		}
	}
	
	function executeTest( test ) {
		var	realLeaves = [],
			callback = function( node ) {
				var retval;
				realLeaves.push( node );
				if ( test.callback ) {
					retval = test.callback( node );
					if ( retval !== undefined ) {
						return retval;
					}
				}
			},
			f = function() {
				test.node.traverseLeafNodes( callback, test.from, test.isReversed );
			};
		if ( test.exception ) {
			raises( f, test.exception, test.desc );
		} else {
			f();
			ok( ve.compareArrays( realLeaves, test.output ), test.desc );
		}
	}
} );