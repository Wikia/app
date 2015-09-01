/*!
 * VisualEditor DataModel Table Selection tests.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

QUnit.module( 've.dm.TableSelection' );

/* Tests */

QUnit.test( 'Construction and getters (getDocument, getRanges, getOuterRanges, getTableNode)', 28, function ( assert ) {
	var i, selection,
		doc = ve.dm.example.createExampleDocument( 'mergedCells' ),
		tableNode = doc.getBranchNodeFromOffset( 1 ),
		tableRange = tableNode.getOuterRange(),
		cases = [
			{
				msg: 'single cell selection',
				selection: new ve.dm.TableSelection( doc, tableRange, 1, 2 ),
				fromCol: 1,
				fromRow: 2,
				toCol: 1,
				toRow: 2,
				startCol: 1,
				startRow: 2,
				endCol: 1,
				endRow: 2,
				ranges: [
					new ve.Range( 65, 69 )
				],
				outerRanges: [
					new ve.Range( 64, 70 )
				]
			},
			{
				msg: 'multi cell selection',
				selection: new ve.dm.TableSelection( doc, tableRange, 1, 2, 0, 1 ),
				fromCol: 1,
				fromRow: 2,
				toCol: 0,
				toRow: 1,
				startCol: 0,
				startRow: 1,
				endCol: 1,
				endRow: 2,
				ranges: [
					new ve.Range( 36, 39 ),
					new ve.Range( 41, 44 ),
					new ve.Range( 59, 63 ),
					new ve.Range( 65, 69 )
				],
				outerRanges: [
					new ve.Range( 35, 40 ),
					new ve.Range( 40, 45 ),
					new ve.Range( 58, 64 ),
					new ve.Range( 64, 70 )
				]
			},
			{
				msg: 'multi cell selection (expanded)',
				selection: new ve.dm.TableSelection( doc, tableRange, 1, 2, 0, 1, true ),
				fromCol: 2,
				fromRow: 2,
				toCol: 0,
				toRow: 1,
				startCol: 0,
				startRow: 1,
				endCol: 2,
				endRow: 2,
				ranges: [
					new ve.Range( 36, 39 ),
					new ve.Range( 41, 44 ),
					new ve.Range( 59, 63 ),
					new ve.Range( 65, 69 ),
					new ve.Range( 71, 75 )
				],
				outerRanges: [
					new ve.Range( 35, 40 ),
					new ve.Range( 40, 45 ),
					new ve.Range( 58, 64 ),
					new ve.Range( 64, 70 ),
					new ve.Range( 70, 76 )
				]
			}
		];

	QUnit.expect( 12 * cases.length );

	for ( i in cases ) {
		selection = cases[ i ].selection;
		assert.strictEqual( selection.getDocument(), doc, 'getDocument' );
		assert.strictEqual( selection.getTableNode(), tableNode, 'getTableNode' );
		assert.deepEqual( selection.getRanges(), cases[ i ].ranges, cases[ i ].msg + ': getRanges' );
		assert.deepEqual( selection.getOuterRanges(), cases[ i ].outerRanges, cases[ i ].msg + ': getOuterRanges' );
		assert.strictEqual( selection.fromCol, cases[ i ].fromCol, cases[ i ].msg + ': fromCol set' );
		assert.strictEqual( selection.fromRow, cases[ i ].fromRow, cases[ i ].msg + ': fromRow set' );
		assert.strictEqual( selection.toCol, cases[ i ].toCol, cases[ i ].msg + ': toCol set' );
		assert.strictEqual( selection.toRow, cases[ i ].toRow, cases[ i ].msg + ': toRow set' );
		assert.strictEqual( selection.startCol, cases[ i ].startCol, cases[ i ].msg + ': startCol set' );
		assert.strictEqual( selection.startRow, cases[ i ].startRow, cases[ i ].msg + ': startRow set' );
		assert.strictEqual( selection.endCol, cases[ i ].endCol, cases[ i ].msg + ': endCol set' );
		assert.strictEqual( selection.endRow, cases[ i ].endRow, cases[ i ].msg + ': endRow set' );
	}

} );

QUnit.test( 'Basic methods (clone, expand, collapse*, getRange(s), isCollased, isSingleCell, equals, isNull, isFullRow/Col, getRow/ColCount)', 17, function ( assert ) {
	var doc = ve.dm.example.createExampleDocument( 'mergedCells' ),
		doc2 = ve.dm.example.createExampleDocument( 'mergedCells' ),
		tableRange = doc.getBranchNodeFromOffset( 1 ).getOuterRange(),
		selection = new ve.dm.TableSelection( doc, tableRange, 1, 2, 0, 1, true ),
		expandedSelection = new ve.dm.TableSelection( doc, tableRange, 2, 2, 0, 1 ),
		selection2 = new ve.dm.TableSelection( doc2, tableRange, 1, 2, 0, 1, true ),
		startSelection = new ve.dm.TableSelection( doc, tableRange, 0, 1 ),
		endSelection = new ve.dm.TableSelection( doc, tableRange, 2, 2 ),
		mergedSingleCell = new ve.dm.TableSelection( doc, tableRange, 1, 3, 3, 5, true ),
		largeSelection = new ve.dm.TableSelection( doc, tableRange, 0, 0, 3, 6 );

	assert.deepEqual( selection.clone(), expandedSelection, 'clone' );
	assert.deepEqual( selection.collapseToStart(), startSelection, 'collapseToStart' );
	assert.deepEqual( selection.collapseToEnd(), endSelection, 'collapseToEnd' );
	assert.deepEqual( selection.collapseToFrom(), endSelection, 'collapseToFrom' );
	assert.deepEqual( selection.collapseToTo(), startSelection, 'collapseToTo' );
	assert.strictEqual( selection.isCollapsed(), false, 'multi cell is not collapsed' );
	assert.strictEqual( startSelection.isCollapsed(), false, 'single cell is not collapsed' );
	assert.strictEqual( selection.isSingleCell(), false, 'multi cell selection is not a single cell' );
	assert.strictEqual( startSelection.isSingleCell(), true, 'single cell selection is a single cell' );
	assert.strictEqual( mergedSingleCell.isSingleCell(), true, 'merged single cell selection is a single cell' );
	assert.strictEqual( selection.equals( selection ), true, 'equals' );
	assert.strictEqual( selection.equals( selection2 ), false, 'not equal when docs are not reference equal' );
	assert.strictEqual( selection.isNull(), false, 'not null' );
	assert.strictEqual( largeSelection.getColCount(), 4, 'getColCount' );
	assert.strictEqual( largeSelection.getRowCount(), 7, 'getRowCount' );
	assert.strictEqual( largeSelection.isFullCol(), true, 'isFullCol' );
	assert.strictEqual( largeSelection.isFullRow(), false, 'isFullRow' );
} );

QUnit.test( 'Factory methods & serialization (newFromJSON, toJSON, getDescription)', 3, function ( assert ) {
	var doc = ve.dm.example.createExampleDocument( 'mergedCells' ),
		tableRange = doc.getBranchNodeFromOffset( 1 ).getOuterRange(),
		selection = new ve.dm.TableSelection( doc, tableRange, 1, 2, 3, 4 ),
		json = {
			type: 'table',
			tableRange: tableRange,
			fromCol: 1,
			fromRow: 2,
			toCol: 3,
			toRow: 4
		};

	assert.deepEqual( selection.toJSON(), json, 'toJSON' );

	assert.deepEqual(
		ve.dm.Selection.static.newFromJSON( doc, JSON.stringify( json ) ),
		selection,
		'newFromJSON'
	);
	assert.deepEqual( selection.getDescription(), 'Table: 0 - 171, c1 r2 - c3 r4', 'getDescription' );
} );

// TODO: getMatrixCells
// TODO: translateByTransaction
// TODO: newFromAdjustment
// TODO: isFullRow
// TODO: isFullCol
