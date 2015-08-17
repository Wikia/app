/*!
 * VisualEditor Range tests.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

QUnit.module( 've.Range' );

/* Tests */

QUnit.test( 'Basic usage (clone, isCollapsed, isBackwards, getLength, equals, equalsSelection, containsOffset, containsRange)', 26, function ( assert ) {
	var range = new ve.Range( 100, 200 );

	assert.strictEqual( range.isCollapsed(), false );
	assert.strictEqual( range.isBackwards(), false );
	assert.strictEqual( range.getLength(), 100 );
	assert.strictEqual( range.equals( new ve.Range( 100, 200 ) ), true, 'equals matches identical range' );
	assert.strictEqual( range.equals( new ve.Range( 200, 100 ) ), false, 'equals doesn\'t match reverse range' );
	assert.strictEqual( range.equalsSelection( new ve.Range( 200, 100 ) ), true, 'equalsSelection matches reverse range' );
	assert.strictEqual( range.containsOffset( 99 ), false, 'doesn\'t contain 99' );
	assert.strictEqual( range.containsOffset( 100 ), true, 'contains 100' );
	assert.strictEqual( range.containsOffset( 199 ), true, 'contains 199' );
	assert.strictEqual( range.containsOffset( 200 ), false, 'doesn\'t contain 200' );
	assert.strictEqual( range.containsRange( new ve.Range( 99, 100 ) ), false, 'doesn\'t contain 99, 100' );
	assert.strictEqual( range.containsRange( new ve.Range( 100, 199 ) ), true, 'contains 100, 199' );
	assert.strictEqual( range.containsRange( new ve.Range( 100, 200 ) ), false, 'doesn\'t contain 100, 200' );

	range = new ve.Range( 200, 100 );
	assert.strictEqual( range.isCollapsed(), false );
	assert.strictEqual( range.isBackwards(), true );
	assert.strictEqual( range.getLength(), 100 );
	assert.strictEqual( range.containsOffset( 99 ), false, 'doesn\'t contain 99' );
	assert.strictEqual( range.containsOffset( 100 ), true, 'contains 100' );
	assert.strictEqual( range.containsOffset( 199 ), true, 'contains 199' );
	assert.strictEqual( range.containsOffset( 200 ), false, 'doesn\'t contain 200' );
	assert.strictEqual( range.containsRange( new ve.Range( 99, 100 ) ), false, 'doesn\'t contain 99, 100' );
	assert.strictEqual( range.containsRange( new ve.Range( 100, 199 ) ), true, 'contains 100, 199' );
	assert.strictEqual( range.containsRange( new ve.Range( 100, 200 ) ), false, 'doesn\'t contain 100, 200' );

	range = new ve.Range( 100 );
	assert.strictEqual( range.isCollapsed(), true );
	assert.strictEqual( range.isBackwards(), false );
	assert.strictEqual( range.getLength(), 0 );

} );

QUnit.test( 'Modification (flip, truncate, expand, translate, clone)', 17, function ( assert ) {
	var range = new ve.Range( 100, 200 );

	assert.equalRange( range.flip(), new ve.Range( 200, 100 ), 'flip reverses the range' );
	assert.equalRange( range.flip().flip(), range, 'double flip does nothing' );

	assert.equalRange( range, range.clone(), 'clone produces an equal range' );
	assert.equalRange( range.flip().clone(), range.flip(), 'clone produces an equal range backwards' );

	assert.equalRange( range.truncate( 50 ), new ve.Range( 100, 150 ), 'truncate 50' );
	assert.equalRange( range.truncate( 150 ), range, 'truncate 150 does nothing' );
	assert.equalRange( range.truncate( -50 ), new ve.Range( 150, 200 ), 'truncate -50' );
	assert.equalRange( range.truncate( -150 ), range, 'truncate -150 does nothing' );

	assert.equalRange( range.expand( new ve.Range( 150, 250 ) ), new ve.Range( 100, 250 ), 'overlapping expand to right' );
	assert.equalRange( range.expand( new ve.Range( 250 ) ), new ve.Range( 100, 250 ), 'non-overlapping expand to right' );
	assert.equalRange( range.expand( new ve.Range( 250, 150 ) ), new ve.Range( 100, 250 ), 'backwards overlapping expand to right' );
	assert.equalRange( range.expand( new ve.Range( 50, 150 ) ), new ve.Range( 50, 200 ), 'overlapping expand to left' );
	assert.equalRange( range.expand( new ve.Range( 50 ) ), new ve.Range( 50, 200 ), 'non-overlapping expand to left' );
	assert.equalRange( range.expand( new ve.Range( 150, 50 ) ), new ve.Range( 50, 200 ), 'backwards overlapping expand to left' );

	assert.equalRange( range.translate( 10 ), new ve.Range( 110, 210 ), 'translate 10' );
	assert.equalRange( range.translate( -10 ), new ve.Range( 90, 190 ), 'translate -10' );

	assert.strictEqual( range.flip().expand( new ve.Range( 250 ) ).isBackwards(), true, 'expands preserves backwards' );

} );

QUnit.test( 'Factory methods & serialization (newCoveringRange, newFromJSON, toJSON)', 6, function ( assert ) {
	var range = new ve.Range( 100, 200 );

	assert.equalRange(
		ve.Range.static.newCoveringRange( [ range, new ve.Range( 150, 250 ) ] ),
		new ve.Range( 100, 250 ),
		'covering range'
	);
	assert.equalRange(
		ve.Range.static.newCoveringRange( [ range, new ve.Range( 150, 250 ) ], true ),
		new ve.Range( 250, 100 ),
		'backwards covering range'
	);

	assert.deepEqual( range.toJSON(), { type: 'range', from: 100, to: 200 }, 'toJSON' );
	assert.deepEqual( range.flip().toJSON(), { type: 'range', from: 200, to: 100 }, 'backwards toJSON' );

	assert.equalRange( ve.Range.static.newFromJSON( JSON.stringify( range.toJSON() ) ), range, 'newFromJSON' );
	assert.equalRange( ve.Range.static.newFromJSON( JSON.stringify( range.flip().toJSON() ) ), range.flip(), 'backwards newFromJSON' );

} );

// TODO: newFromHash
