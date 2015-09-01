/*!
 * VisualEditor DataModel Null Selection tests.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

QUnit.module( 've.dm.NullSelection' );

/* Tests */

QUnit.test( 'Construction and getters (getDocument, getRanges)', 2, function ( assert ) {
	var dummyDoc = { a: 1 },
		selection = new ve.dm.NullSelection( dummyDoc );

	assert.strictEqual( selection.getDocument(), dummyDoc, 'getDocument' );
	assert.deepEqual( selection.getRanges(), [], 'getRanges' );
} );

QUnit.test( 'Basic methods (clone, collapse*, isCollased, equals, isNull)', 9, function ( assert ) {
	var dummyDoc = { a: 1 },
		dummyDoc2 = { a: 1 },
		selection = new ve.dm.NullSelection( dummyDoc ),
		selection2 = new ve.dm.NullSelection( dummyDoc2 );

	assert.deepEqual( selection.clone(), selection, 'clone' );
	assert.deepEqual( selection.collapseToStart(), selection, 'collapseToStart' );
	assert.deepEqual( selection.collapseToEnd(), selection, 'collapseToEnd' );
	assert.deepEqual( selection.collapseToFrom(), selection, 'collapseToFrom' );
	assert.deepEqual( selection.collapseToTo(), selection, 'collapseToTo' );
	assert.strictEqual( selection.isCollapsed(), true, 'isCollapsed' );
	assert.strictEqual( selection.equals( selection ), true, 'equals' );
	assert.strictEqual( selection.equals( selection2 ), false, 'not equal when docs are not reference equal' );
	assert.strictEqual( selection.isNull(), true, 'null' );
} );

QUnit.test( 'Factory methods & serialization (newFromJSON, toJSON, getDescription)', 3, function ( assert ) {
	var dummyDoc = { a: 1 },
		selection = new ve.dm.NullSelection( dummyDoc );

	assert.deepEqual( selection.toJSON(), { type: 'null' }, 'toJSON' );
	assert.deepEqual(
		ve.dm.Selection.static.newFromJSON( dummyDoc, JSON.stringify( { type: 'null' } ) ),
		selection,
		'newFromJSON'
	);
	assert.deepEqual( selection.getDescription(), 'Null', 'getDescription' );
} );

// TODO: translateByTransaction
