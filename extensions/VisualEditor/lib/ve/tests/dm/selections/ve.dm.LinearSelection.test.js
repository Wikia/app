/*!
 * VisualEditor DataModel Linear Selection tests.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

QUnit.module( 've.dm.LinearSelection' );

/* Tests */

QUnit.test( 'Construction and getters (getDocument, getRange(s))', 3, function ( assert ) {
	var dummyDoc = { a: 1 },
		range = new ve.Range( 200, 100 ),
		selection = new ve.dm.LinearSelection( dummyDoc, range );

	assert.strictEqual( selection.getDocument(), dummyDoc, 'getDocument' );
	assert.deepEqual( selection.getRange(), range, 'getRange' );
	assert.deepEqual( selection.getRanges(), [ range ], 'getRanges' );
} );

QUnit.test( 'Basic methods (clone, collapse*, isCollased, equals, isNull)', 10, function ( assert ) {
	var dummyDoc = { a: 1 },
		dummyDoc2 = { a: 1 },
		range = new ve.Range( 200, 100 ),
		selection = new ve.dm.LinearSelection( dummyDoc, range ),
		selection2 = new ve.dm.LinearSelection( dummyDoc2, range ),
		startSelection = new ve.dm.LinearSelection( dummyDoc, new ve.Range( 100 ) ),
		endSelection = new ve.dm.LinearSelection( dummyDoc, new ve.Range( 200 ) );

	assert.deepEqual( selection.clone(), selection, 'clone' );
	assert.deepEqual( selection.collapseToStart(), startSelection, 'collapseToStart' );
	assert.deepEqual( selection.collapseToEnd(), endSelection, 'collapseToEnd' );
	assert.deepEqual( selection.collapseToFrom(), endSelection, 'collapseToFrom' );
	assert.deepEqual( selection.collapseToTo(), startSelection, 'collapseToTo' );
	assert.strictEqual( selection.isCollapsed(), false, '200-100 is not collapsed' );
	assert.strictEqual( startSelection.isCollapsed(), true, '100-100 is collapsed' );
	assert.strictEqual( selection.equals( selection ), true, 'equals' );
	assert.strictEqual( selection.equals( selection2 ), false, 'not equal when docs are not reference equal' );
	assert.strictEqual( selection.isNull(), false, 'not null' );
} );

QUnit.test( 'Factory methods & serialization (newFromJSON, toJSON, getDescription)', 3, function ( assert ) {
	var dummyDoc = { a: 1 },
		range = new ve.Range( 200, 100 ),
		selection = new ve.dm.LinearSelection( dummyDoc, range );

	assert.deepEqual( selection.toJSON(), { type: 'linear', range: range }, 'toJSON' );
	assert.deepEqual(
		ve.dm.Selection.static.newFromJSON( dummyDoc, JSON.stringify( { type: 'linear', range: range } ) ),
		selection,
		'newFromJSON'
	);
	assert.deepEqual( selection.getDescription(), 'Linear: 200 - 100', 'getDescription' );
} );

// TODO: translateByTransaction
