module( 've' );

test( 've.insertIntoArray', 1, function() {
	var insert = [], i, arr = ['foo', 'bar'], expected = [];
	expected[0] = 'foo';
	for ( i = 0; i < 3000; i++ ) {
		insert[i] = i;
		expected[i + 1] = i;
	}
	expected[3001] = 'bar';
	
	ve.insertIntoArray( arr, 1, insert );
	deepEqual( arr, expected, 'splicing 3000 elements into the middle of a 2-element array' );
} );
