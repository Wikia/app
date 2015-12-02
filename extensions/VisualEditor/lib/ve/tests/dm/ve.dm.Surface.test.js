/*!
 * VisualEditor DataModel Surface tests.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

QUnit.module( 've.dm.Surface' );

ve.dm.SurfaceStub = function VeDmSurfaceStub( data, range ) {
	var doc = new ve.dm.Document( data || [{ type: 'paragraph' }, 'h', 'i', { type: '/paragraph' }] );

	// Inheritance
	ve.dm.Surface.call( this, doc );

	// Initialize selection to simulate the surface being focused
	this.setLinearSelection( range || new ve.Range( 1 ) );
};

OO.inheritClass( ve.dm.SurfaceStub, ve.dm.Surface );

// Tests

QUnit.test( 'getDocument', 1, function ( assert ) {
	var surface = new ve.dm.SurfaceStub();
	assert.strictEqual( surface.getDocument(), surface.documentModel );
} );

QUnit.test( 'getSelection', 1, function ( assert ) {
	var surface = new ve.dm.SurfaceStub();
	assert.strictEqual( surface.getSelection(), surface.selection );
} );

QUnit.test( 'documentUpdate/select events', 3, function ( assert ) {
	var surface = new ve.dm.SurfaceStub(),
		doc = surface.getDocument(),
		// docmentUpdate doesn't fire for no-op transactions, so make sure there's something there
		tx = ve.dm.Transaction.newFromInsertion( doc, 3, [ 'i' ] ),
		events = {
			documentUpdate: 0,
			select: 0
		};

	surface.on( 'documentUpdate', function () {
		events.documentUpdate++;
	} );
	surface.on( 'select', function () {
		events.select++;
	} );
	surface.change( tx.clone() );
	assert.deepEqual( events, { documentUpdate: 1, select: 0 }, 'change with transaction only' );
	surface.setLinearSelection( new ve.Range( 2 ) );
	assert.deepEqual( events, { documentUpdate: 1, select: 1 }, 'setSelection' );
	surface.change( tx.clone(), new ve.dm.LinearSelection( doc, new ve.Range( 3 ) ) );
	assert.deepEqual( events, { documentUpdate: 2, select: 2 }, 'change with transaction and selection' );
} );

QUnit.test( 'breakpoint/undo/redo', 12, function ( assert ) {
	var range = new ve.Range( 1, 3 ),
		surface = new ve.dm.SurfaceStub( null, range ),
		fragment = surface.getFragment(),
		doc = surface.getDocument(),
		selection = new ve.dm.LinearSelection( doc, range ),
		tx = new ve.dm.Transaction.newFromInsertion( doc, 1, ['x'] );

	assert.strictEqual( surface.breakpoint(), false, 'Returns false if no transactions applied' );

	surface.change( tx );
	assert.deepEqual( surface.undoStack, [], 'Undo stack data matches before breakpoint' );
	assert.deepEqual( surface.newTransactions, [tx], 'New transactions match before breakpoint' );

	assert.strictEqual( surface.breakpoint(), true, 'Returns true after transaction applied' );
	assert.strictEqual( surface.breakpoint(), false, 'Returns false if no transactions applied since last breakpoint' );

	assert.deepEqual(
		surface.undoStack, [ {
			transactions: [tx],
			selection: new ve.dm.LinearSelection( doc, tx.translateRange( selection.getRange() ) ),
			selectionBefore: selection
		} ],
		'Undo stack data matches after breakpoint'
	);
	assert.deepEqual( surface.newTransactions, [], 'New transactions empty after breakpoint' );

	assert.equalHash( surface.getSelection(), fragment.getSelection(), 'Range changed' );
	// Dirty selection to make sure beforeSelection works
	surface.setLinearSelection( new ve.Range( 3 ) );
	surface.undo();
	assert.equalHash( surface.getSelection().getRange(), range, 'Range restored after undo' );
	assert.strictEqual( fragment.getText(), 'hi', 'Text restored after undo' );

	surface.setLinearSelection( new ve.Range( 3 ) );
	surface.redo();
	assert.equalHash( surface.getSelection(), fragment.getSelection(), 'Range changed after redo' );
	assert.strictEqual( fragment.getText(), 'xhi', 'Text changed after redo' );

} );

QUnit.test( 'staging', 37, function ( assert ) {
	var tx1, tx2,
		surface = new ve.dm.SurfaceStub( null, new ve.Range( 1, 3 ) ),
		fragment = surface.getFragment(),
		doc = surface.getDocument();

	assert.strictEqual( surface.isStaging(), false, 'isStaging false when not staging' );
	assert.strictEqual( surface.getStagingTransactions(), undefined, 'getStagingTransactions undefined when not staging' );
	assert.strictEqual( surface.doesStagingAllowUndo(), undefined, 'doesStagingAllowUndo undefined when not staging' );
	assert.equalHash( surface.getSelection(), fragment.getSelection(), 'Surface range matches fragment range' );

	surface.change( new ve.dm.Transaction.newFromInsertion( doc, 1, ['a'] ) );

	surface.pushStaging();
	assert.strictEqual( surface.isStaging(), true, 'isStaging true after pushStaging' );
	assert.deepEqual( surface.getStagingTransactions(), [], 'getStagingTransactions empty array after pushStaging' );
	assert.strictEqual( surface.doesStagingAllowUndo(), false, 'doesStagingAllowUndo false when staging without undo' );

	tx1 = new ve.dm.Transaction.newFromInsertion( doc, 2, ['b'] );
	surface.change( tx1 );

	assert.strictEqual( fragment.getText(), 'abhi', 'document contents match after first transaction' );
	assert.deepEqual( surface.getStagingTransactions(), [tx1], 'getStagingTransactions contains first transaction after change' );
	assert.equalHash( surface.getSelection(), fragment.getSelection(), 'Surface selection matches fragment range' );

	surface.pushStaging( true );
	assert.strictEqual( surface.isStaging(), true, 'isStaging true after nested pushStaging' );
	assert.deepEqual( surface.getStagingTransactions(), [], 'getStagingTransactions empty array after nested pushStaging' );
	assert.strictEqual( surface.doesStagingAllowUndo(), true, 'doesStagingAllowUndo true when staging with undo' );
	assert.equalHash( surface.getSelection(), fragment.getSelection(), 'Surface selection matches fragment range' );

	tx2 = new ve.dm.Transaction.newFromInsertion( doc, 3, ['c'] );
	surface.change( tx2 );

	assert.strictEqual( fragment.getText(), 'abchi', 'document contents match after second transaction' );
	assert.deepEqual( surface.getStagingTransactions(), [tx2], 'getStagingTransactions contains second transaction after change in nested staging' );

	assert.deepEqual( surface.popStaging(), [tx2], 'popStaging returns second transaction list' );
	assert.strictEqual( surface.isStaging(), true, 'isStaging true after nested popStaging' );
	assert.strictEqual( fragment.getText(), 'abhi', 'document contents match after nested popStaging' );
	assert.equalHash( surface.getSelection(), fragment.getSelection(), 'Surface selection matches fragment range' );

	assert.deepEqual( surface.popStaging(), [tx1], 'popStaging returns first transaction list' );
	assert.strictEqual( surface.isStaging(), false, 'isStaging false after outer popStaging' );
	assert.strictEqual( fragment.getText(), 'ahi', 'document contents match after outer popStaging' );
	assert.equalHash( surface.getSelection(), fragment.getSelection(), 'Surface selection matches fragment range' );

	surface.pushStaging();
	tx1 = new ve.dm.Transaction.newFromInsertion( doc, 2, ['b'] );
	surface.change( tx1 );

	surface.pushStaging();
	tx2 = new ve.dm.Transaction.newFromInsertion( doc, 3, ['c'] );
	surface.change( tx2 );

	assert.deepEqual( surface.popAllStaging(), [tx1, tx2], 'popAllStaging returns full transaction list' );
	assert.strictEqual( fragment.getText(), 'ahi', 'document contents match after outer clearStaging' );
	assert.equalHash( surface.getSelection(), fragment.getSelection(), 'Surface selection matches fragment range' );

	surface.pushStaging();
	tx1 = new ve.dm.Transaction.newFromInsertion( doc, 2, ['b'] );
	surface.change( tx1 );

	surface.pushStaging();
	tx2 = new ve.dm.Transaction.newFromInsertion( doc, 3, ['c'] );
	surface.change( tx2 );

	surface.applyStaging();
	assert.deepEqual( surface.getStagingTransactions(), [tx1, tx2], 'applyStaging merges transactions' );

	surface.applyStaging();
	assert.strictEqual( surface.isStaging(), false, 'isStaging false after outer applyStaging' );
	assert.strictEqual( fragment.getText(), 'abchi', 'document contents changed after applyStaging' );
	assert.equalHash( surface.getSelection(), fragment.getSelection(), 'Surface selection matches fragment range' );

	surface.pushStaging();
	tx1 = new ve.dm.Transaction.newFromInsertion( doc, 4, ['d'] );
	surface.change( tx1 );

	surface.pushStaging();
	tx2 = new ve.dm.Transaction.newFromInsertion( doc, 5, ['e'] );
	surface.change( tx2 );

	surface.applyAllStaging();
	assert.strictEqual( surface.isStaging(), false, 'isStaging false after outer applyAllStaging' );
	assert.strictEqual( fragment.getText(), 'abcdehi', 'document contents changed after applyAllStaging' );
	assert.equalHash( surface.getSelection(), fragment.getSelection(), 'Surface selection matches fragment range' );

	surface.undo();
	assert.strictEqual( fragment.getText(), 'abchi', 'document contents changed after undo' );
	assert.equalHash( surface.getSelection(), fragment.getSelection(), 'Surface selection matches fragment range' );

	surface.pushStaging();
	surface.pushStaging();
	// Apply transaction at second level, first level is empty and has no selctionBefore
	tx1 = new ve.dm.Transaction.newFromInsertion( doc, 4, ['d'] );
	surface.change( tx1 );
	surface.applyAllStaging();
	// Dirty selection
	surface.setLinearSelection( new ve.Range( 1 ) );
	// Undo should restore the selection from the second level's selectionBefore
	surface.undo();

	assert.equalHash( surface.getSelection(), fragment.getSelection(), 'Surface selection matches fragment range' );

} );

// TODO: ve.dm.Surface#getHistory
// TODO: ve.dm.Surface#canRedo
// TODO: ve.dm.Surface#canUndo
// TODO: ve.dm.Surface#hasBeenModified
// TODO: ve.dm.Surface#truncateUndoStack
