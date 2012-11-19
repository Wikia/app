/**
 * VisualEditor Base method tests.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.Range' );

/* Tests */

QUnit.test( 'Basic usage', 8, function ( assert ) {
	var range;

	range = new ve.Range( 100 , 200 );
	assert.equal( range.isCollapsed(), false );
	assert.equal( range.getLength(), 100 );

	range = new ve.Range( 200 , 100 );
	assert.equal( range.isCollapsed(), false );
	assert.equal( range.getLength(), 100 );

	range = new ve.Range( 100 , 100 );
	assert.equal( range.isCollapsed(), true );
	assert.equal( range.getLength(), 0 );

	range = new ve.Range( 200 );
	assert.equal( range.isCollapsed(), true );
	assert.equal( range.getLength(), 0 );
} );
