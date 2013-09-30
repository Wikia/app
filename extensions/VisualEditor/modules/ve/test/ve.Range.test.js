/*!
 * VisualEditor Range tests.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.Range' );

/* Tests */

QUnit.test( 'Basic usage (isCollapsed, isBackwards, getLength, equals, equalsSelection)', 15, function ( assert ) {
	var range;

	range = new ve.Range( 100, 200 );
	assert.equal( range.isCollapsed(), false );
	assert.equal( range.isBackwards(), false );
	assert.equal( range.getLength(), 100 );
	assert.ok( range.equals( new ve.Range( 100, 200 ) ), 'equals matches identical range' );
	assert.ok( !range.equals( new ve.Range( 200, 100 ) ), 'equals doesn\'t match reverse range' );
	assert.ok( range.equalsSelection( new ve.Range( 200, 100 ) ), 'equalsSelection matches reverse range' );

	range = new ve.Range( 200, 100 );
	assert.equal( range.isCollapsed(), false );
	assert.equal( range.isBackwards(), true );
	assert.equal( range.getLength(), 100 );

	range = new ve.Range( 100, 100 );
	assert.equal( range.isCollapsed(), true );
	assert.equal( range.isBackwards(), false );
	assert.equal( range.getLength(), 0 );

	range = new ve.Range( 200 );
	assert.equal( range.isCollapsed(), true );
	assert.equal( range.isBackwards(), false );
	assert.equal( range.getLength(), 0 );

} );

// TODO: newFromTranslatedRange

// TODO: newCoveringRange

// TODO: clone

// TODO: containsOffset

// TODO: flip

// TODO: truncate
