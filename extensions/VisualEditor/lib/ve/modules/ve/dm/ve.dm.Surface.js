/*!
 * VisualEditor DataModel Surface class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel surface.
 *
 * @class
 * @mixins OO.EventEmitter
 *
 * @constructor
 * @param {ve.dm.Document} doc Document model to create surface for
 */
ve.dm.Surface = function VeDmSurface( doc ) {
	// Mixin constructors
	OO.EventEmitter.call( this );

	// Properties
	this.documentModel = doc;
	this.metaList = new ve.dm.MetaList( this );
	this.selection = null;
	this.selectionBefore = null;
	this.selectedNodes = {};
	this.newTransactions = [];
	this.stagingStack = [];
	this.undoStack = [];
	this.undoIndex = 0;
	this.historyTrackingInterval = null;
	this.insertionAnnotations = new ve.dm.AnnotationSet( this.documentModel.getStore() );
	this.enabled = true;
	this.transacting = false;
	this.queueingContextChanges = false;
	this.contextChangeQueued = false;

	// Events
	this.documentModel.connect( this, { 'transact': 'onDocumentTransact' } );
};

/* Inheritance */

OO.mixinClass( ve.dm.Surface, OO.EventEmitter );

/* Events */

/**
 * @event select
 * @param {ve.Range|null} selection
 */

/**
 * @event documentUpdate
 *
 * Emitted when a transaction has been processed on the document and the selection has been
 * translated to account for that transaction. You should only use this event if you need
 * to access the selection; in most cases, you should use {ve.dm.Document#event-transact}.
 *
 * @param {ve.dm.Transaction} tx Transaction that was processed on the document
 */

/**
 * @event contextChange
 */

/**
 * @event insertionAnnotationsChange
 * @param {ve.dm.AnnotationSet} insertionAnnotations AnnotationSet being inserted
 */

/**
 * @event history
 */

/* Methods */

/**
 * Disable changes.
 *
 * @method
 * @fires history
 */
ve.dm.Surface.prototype.disable = function () {
	this.stopHistoryTracking();
	this.enabled = false;
	this.emit( 'history' );
};

/**
 * Enable changes.
 *
 * @method
 * @fires history
 */
ve.dm.Surface.prototype.enable = function () {
	this.enabled = true;
	this.startHistoryTracking();
	this.emit( 'history' );
};

/**
 * Start tracking state changes in history.
 *
 * @method
 */
ve.dm.Surface.prototype.startHistoryTracking = function () {
	if ( !this.enabled ) {
		return;
	}
	if ( this.historyTrackingInterval === null ) {
		this.historyTrackingInterval = setInterval( ve.bind( this.breakpoint, this ), 750 );
	}
};

/**
 * Stop tracking state changes in history.
 *
 * @method
 */
ve.dm.Surface.prototype.stopHistoryTracking = function () {
	if ( !this.enabled ) {
		return;
	}
	if ( this.historyTrackingInterval !== null ) {
		clearInterval( this.historyTrackingInterval );
		this.historyTrackingInterval = null;
	}
};

/**
 * Get a list of all history states.
 *
 * @method
 * @returns {Object[]} List of transaction stacks
 */
ve.dm.Surface.prototype.getHistory = function () {
	if ( this.newTransactions.length > 0 ) {
		return this.undoStack.slice( 0 ).concat( [{ 'transactions': this.newTransactions.slice( 0 ) }] );
	} else {
		return this.undoStack.slice( 0 );
	}
};

/**
 * If the surface in staging mode.
 *
 * @returns {boolean} The surface in staging mode
 */
ve.dm.Surface.prototype.isStaging = function () {
	return this.stagingStack.length > 0;
};

/**
 * Get the staging state at the current staging stack depth
 *
 * @returns {Object|undefined} staging Staging state object, or undefined if not staging
 * @returns {ve.dm.Transaction[]} staging.transactions Staging transactions
 * @returns {boolean} staging.allowUndo Allow undo while staging
 */
ve.dm.Surface.prototype.getStaging = function () {
	return this.stagingStack[this.stagingStack.length - 1];
};

/**
 * Undo is allowed at the current staging stack depth
 *
 * @returns {boolean|undefined} Undo is allowed, or undefined if not staging
 */
ve.dm.Surface.prototype.doesStagingAllowUndo = function () {
	var staging = this.getStaging();
	return staging && staging.allowUndo;
};

/**
 * Get the staging transactions at the current staging stack depth
 *
 * The array is returned by reference so it can be pushed to.
 *
 * @returns {ve.dm.Transaction[]|undefined} Staging transactions, or undefined if not staging
 */
ve.dm.Surface.prototype.getStagingTransactions = function () {
	var staging = this.getStaging();
	return staging && staging.transactions;
};

/**
 * Push another level of staging to the staging stack
 *
 * @param {boolean} [allowUndo=false] Allow undo while staging
 * @fires history
 */
ve.dm.Surface.prototype.pushStaging = function ( allowUndo ) {
	// If we're starting staging stop history tracking
	if ( !this.isStaging() ) {
		// Set a breakpoint to make sure newTransactions is clear
		this.breakpoint();
		this.stopHistoryTracking();
		this.emit( 'history' );
	}
	this.stagingStack.push( { 'transactions': [], 'allowUndo': !!allowUndo } );
};

/**
 * Pop a level of staging from the staging stack
 *
 * @fires history
 * @returns {ve.dm.Transaction[]|undefined} Staging transactions, or undefined if not staging
 */
ve.dm.Surface.prototype.popStaging = function () {
	if ( !this.isStaging() ) {
		return;
	}

	var i, transaction,
		reverseTransactions = [],
		staging = this.stagingStack.pop(),
		transactions = staging.transactions;

	// Not applying, so rollback transactions
	for ( i = transactions.length - 1; i >= 0; i-- ) {
		transaction = transactions[i].reversed();
		reverseTransactions.push( transaction );
	}
	this.changeInternal( reverseTransactions, undefined, true );

	if ( !this.isStaging() ) {
		this.startHistoryTracking();
		this.emit( 'history' );
	}

	return transactions;
};

/**
 * Apply a level of staging from the staging stack
 *
 * @fires history
 */
ve.dm.Surface.prototype.applyStaging = function () {
	if ( !this.isStaging() ) {
		return;
	}

	var staging = this.stagingStack.pop(),
		transactions = staging.transactions;

	if ( this.isStaging() ) {
		// Move transactions to the next item down in the staging stack
		Array.prototype.push.apply( this.getStagingTransactions(), transactions );
	} else {
		this.truncateUndoStack();
		// Move transactions to the undo stack
		this.newTransactions = transactions;
		this.breakpoint();
	}

	if ( !this.isStaging() ) {
		this.startHistoryTracking();
		this.emit( 'history' );
	}
};

/**
 * Pop the staging stack until empty
 *
 * @returns {ve.dm.Transaction[]|undefined} Staging transactions, or undefined if not staging
 */
ve.dm.Surface.prototype.popAllStaging = function () {
	if ( !this.isStaging() ) {
		return;
	}

	var transactions = [];
	while ( this.isStaging() ) {
		ve.batchSplice( transactions, 0, 0, this.popStaging() );
	}
	return transactions;
};

/**
 * Apply the staging stack until empty
 */
ve.dm.Surface.prototype.applyAllStaging = function () {
	while ( this.isStaging() ) {
		this.applyStaging();
	}
};

/**
 * Get annotations that will be used upon insertion.
 *
 * @method
 * @returns {ve.dm.AnnotationSet} Insertion anotations
 */
ve.dm.Surface.prototype.getInsertionAnnotations = function () {
	return this.insertionAnnotations.clone();
};

/**
 * Set annotations that will be used upon insertion.
 *
 * @method
 * @param {ve.dm.AnnotationSet|null} Insertion anotations to use or null to disable them
 * @fires insertionAnnotationsChange
 * @fires contextChange
 */
ve.dm.Surface.prototype.setInsertionAnnotations = function ( annotations ) {
	if ( !this.enabled ) {
		return;
	}
	this.insertionAnnotations = annotations !== null ?
		annotations.clone() :
		new ve.dm.AnnotationSet( this.documentModel.getStore() );

	this.emit( 'insertionAnnotationsChange', this.insertionAnnotations );
	this.emit( 'contextChange' );
};

/**
 * Add an annotation to be used upon insertion.
 *
 * @method
 * @param {ve.dm.Annotation|ve.dm.AnnotationSet} annotations Insertion annotation to add
 * @fires insertionAnnotationsChange
 * @fires contextChange
 */
ve.dm.Surface.prototype.addInsertionAnnotations = function ( annotations ) {
	if ( !this.enabled ) {
		return;
	}
	if ( annotations instanceof ve.dm.Annotation ) {
		this.insertionAnnotations.push( annotations );
	} else if ( annotations instanceof ve.dm.AnnotationSet ) {
		this.insertionAnnotations.addSet( annotations );
	} else {
		throw new Error( 'Invalid annotations' );
	}

	this.emit( 'insertionAnnotationsChange', this.insertionAnnotations );
	this.emit( 'contextChange' );
};

/**
 * Remove an annotation from those that will be used upon insertion.
 *
 * @method
 * @param {ve.dm.Annotation|ve.dm.AnnotationSet} annotations Insertion annotation to remove
 * @fires insertionAnnotationsChange
 * @fires contextChange
 */
ve.dm.Surface.prototype.removeInsertionAnnotations = function ( annotations ) {
	if ( !this.enabled ) {
		return;
	}
	if ( annotations instanceof ve.dm.Annotation ) {
		this.insertionAnnotations.remove( annotations );
	} else if ( annotations instanceof ve.dm.AnnotationSet ) {
		this.insertionAnnotations.removeSet( annotations );
	} else {
		throw new Error( 'Invalid annotations' );
	}

	this.emit( 'insertionAnnotationsChange', this.insertionAnnotations );
	this.emit( 'contextChange' );
};

/**
 * Check if redo is allowed in the current state.
 *
 * @method
 * @returns {boolean} Redo is allowed
 */
ve.dm.Surface.prototype.canRedo = function () {
	return this.undoIndex > 0 && this.enabled;
};

/**
 * Check if undo is allowed in the current state.
 *
 * @method
 * @returns {boolean} Undo is allowed
 */
ve.dm.Surface.prototype.canUndo = function () {
	return this.hasBeenModified() && this.enabled && ( !this.isStaging() || this.doesStagingAllowUndo() );
};

/**
 * Check if the surface has been modified.
 *
 * This only checks if there are transactions which haven't been undone.
 *
 * @method
 * @returns {boolean} The surface has been modified
 */
ve.dm.Surface.prototype.hasBeenModified = function () {
	return this.undoStack.length - this.undoIndex > 0 || !!this.newTransactions.length;
};

/**
 * Get the document model.
 *
 * @method
 * @returns {ve.dm.Document} Document model of the surface
 */
ve.dm.Surface.prototype.getDocument = function () {
	return this.documentModel;
};

/**
 * Get the meta list.
 *
 * @method
 * @returns {ve.dm.MetaList} Meta list of the surface
 */
ve.dm.Surface.prototype.getMetaList = function () {
	return this.metaList;
};

/**
 * Get the selection.
 *
 * @method
 * @returns {ve.Range} Current selection
 */
ve.dm.Surface.prototype.getSelection = function () {
	return this.selection;
};

/**
 * Get a fragment for a range.
 *
 * @method
 * @param {ve.Range} [range] Range within target document, current selection used by default
 * @param {boolean} [noAutoSelect] Don't update the surface's selection when making changes
 * @returns {ve.dm.SurfaceFragment} Surface fragment
 */
ve.dm.Surface.prototype.getFragment = function ( range, noAutoSelect ) {
	return new ve.dm.SurfaceFragment( this, range || this.selection, noAutoSelect );
};

/**
 * Prevent future states from being redone.
 *
 * @method
 * @fires history
 */
ve.dm.Surface.prototype.truncateUndoStack = function () {
	if ( this.undoIndex ) {
		this.undoStack = this.undoStack.slice( 0, this.undoStack.length - this.undoIndex );
		this.undoIndex = 0;
		this.emit( 'history' );
	}
};

/**
 * Start queueing up calls to {#emitContextChange} until {#stopQueueingContextChanges} is called.
 * While queueing is active, contextChanges are also collapsed, so if {#emitContextChange} is called
 * multiple times, only one contextChange event will be emitted by {#stopQueueingContextChanges}.
 *
 *     @example
 *     this.emitContextChange(); // emits immediately
 *     this.startQueueingContextChanges();
 *     this.emitContextChange(); // doesn't emit
 *     this.emitContextChange(); // doesn't emit
 *     this.stopQueueingContextChanges(); // emits one contextChange event
 *
 * @method
 * @private
 */
ve.dm.Surface.prototype.startQueueingContextChanges = function () {
	if ( !this.queueingContextChanges ) {
		this.queueingContextChanges = true;
		this.contextChangeQueued = false;
	}
};

/**
 * Emit a contextChange event. If {#startQueueingContextChanges} has been called, then the event
 * is deferred until {#stopQueueingContextChanges} is called.
 *
 * @method
 * @private
 * @fires contextChange
 */
ve.dm.Surface.prototype.emitContextChange = function () {
	if ( this.queueingContextChanges ) {
		this.contextChangeQueued = true;
	} else {
		this.emit( 'contextChange' );
	}
};

/**
 * Stop queueing contextChange events. If {#emitContextChange} was called previously, a contextChange
 * event will now be emitted. Any future calls to {#emitContextChange} will once again emit the
 * event immediately.
 *
 * @method
 * @private
 * @fires contextChange
 */
ve.dm.Surface.prototype.stopQueueingContextChanges = function () {
	if ( this.queueingContextChanges ) {
		this.queueingContextChanges = false;
		if ( this.contextChangeQueued ) {
			this.contextChangeQueued = false;
			this.emit( 'contextChange' );
		}
	}
};

/**
 * Change the selection
 *
 * @param {ve.Range|null} selection New selection
 *
 * @fires select
 * @fires contextChange
 */
ve.dm.Surface.prototype.setSelection = function ( selection ) {
	var left, right, leftAnnotations, rightAnnotations, insertionAnnotations,
		selectedNodes = {},
		oldSelection = this.selection,
		contextChange = false,
		dataModelData = this.documentModel.data;

	if ( !this.enabled ) {
		return;
	}

	if ( this.transacting ) {
		// Update the selection but don't do any processing
		this.selection = selection;
		return;
	}

	// Detect if selected nodes changed
	selectedNodes.start = selection ? this.documentModel.getNodeFromOffset( selection.start ) : null;
	if ( selection && selection.getLength() ) {
		selectedNodes.end = this.documentModel.getNodeFromOffset( selection.end );
	}
	if (
		selectedNodes.start !== this.selectedNodes.start ||
		selectedNodes.end !== this.selectedNodes.end
	) {
		contextChange = true;
	}

	// Update state
	this.selectedNodes = selectedNodes;
	this.selection = selection;

	if ( this.selection ) {
		// Figure out which annotations to use for insertions
		if ( this.selection.isCollapsed() ) {
			// Get annotations from the left of the cursor
			left = dataModelData.getNearestContentOffset( Math.max( 0, this.selection.start - 1 ), -1 );
			right = dataModelData.getNearestContentOffset( Math.max( 0, this.selection.start ) );
		} else {
			// Get annotations from the first character of the selection
			left = dataModelData.getNearestContentOffset( this.selection.start );
			right = dataModelData.getNearestContentOffset( this.selection.end );
		}
		if ( left === -1 ) {
			// Document is empty, use empty set
			insertionAnnotations = new ve.dm.AnnotationSet( this.documentModel.getStore() );
		} else {
			// Include annotations on the left that should be added to appended content, or ones that
			// are on both the left and the right that should not
			leftAnnotations = dataModelData.getAnnotationsFromOffset( left );
			if ( right !== -1 ) {
				rightAnnotations = dataModelData.getAnnotationsFromOffset( right );
				insertionAnnotations = leftAnnotations.filter( function ( annotation ) {
					return annotation.constructor.static.applyToAppendedContent ||
						rightAnnotations.containsComparable( annotation );
				} );
			} else {
				insertionAnnotations = leftAnnotations;
			}
		}

		// Only emit an annotations change event if there's a meaningful difference
		if (
			!insertionAnnotations.containsAllOf( this.insertionAnnotations ) ||
			!this.insertionAnnotations.containsAllOf( insertionAnnotations )
		) {
			this.setInsertionAnnotations( insertionAnnotations );
			contextChange = true;
		}
	}

	// Emit events
	if ( !oldSelection || !oldSelection.equals( this.selection ) ) {
		this.emit( 'select', this.selection && this.selection.clone() );
	}
	if ( contextChange ) {
		this.emitContextChange();
	}
};

/**
 * Place the selection at the first content offset in the document.
 */
ve.dm.Surface.prototype.selectFirstContentOffset = function () {
	var firstOffset = this.getDocument().data.getNearestContentOffset( 0, 1 );
	this.setSelection(
		new ve.Range( firstOffset !== -1 ? firstOffset : 1 )
	);
};

/**
 * Apply a transactions and selection changes to the document.
 *
 * @method
 * @param {ve.dm.Transaction|ve.dm.Transaction[]|null} transactions One or more transactions to
 *  process, or null to process none
 * @param {ve.Range} [selection] Selection to apply
 * @fires contextChange
 */
ve.dm.Surface.prototype.change = function ( transactions, selection ) {
	this.changeInternal( transactions, selection, false );
};

/**
 * Internal implementation of change(). Do not use this, use change() instead.
 *
 * @private
 * @method
 * @param {ve.dm.Transaction|ve.dm.Transaction[]|null} transactions
 * @param {ve.Range} [selection] [selection]
 * @param {boolean} [skipUndoStack=false] If true, do not modify the undo stack. Used by undo/redo
 * @fires select
 * @fires contextChange
 */
ve.dm.Surface.prototype.changeInternal = function ( transactions, selection, skipUndoStack ) {
	var i, len, selectionAfter, selectionBefore = this.selection, contextChange = false;

	if ( !this.enabled ) {
		return;
	}

	this.startQueueingContextChanges();

	// Process transactions
	if ( transactions ) {
		if ( transactions instanceof ve.dm.Transaction ) {
			transactions = [transactions];
		}
		this.transacting = true;
		for ( i = 0, len = transactions.length; i < len; i++ ) {
			if ( !transactions[i].isNoOp() ) {
				if ( !skipUndoStack ) {
					if ( this.isStaging() ) {
						this.getStagingTransactions().push( transactions[i] );
					} else {
						this.truncateUndoStack();
						if ( !this.newTransactions.length ) {
							this.selectionBefore = selectionBefore;
						}
						this.newTransactions.push( transactions[i] );
					}
				}
				// The .commit() call below indirectly invokes setSelection()
				this.documentModel.commit( transactions[i] );
				if ( transactions[i].hasElementAttributeOperations() ) {
					contextChange = true;
				}
			}
		}
		this.transacting = false;
	}
	selectionAfter = this.selection;

	// Apply selection change
	if ( selection ) {
		this.setSelection( selection );
	} else if ( transactions ) {
		// Call setSelection() to trigger selection processing that was bypassed earlier
		this.setSelection( this.selection );
	}

	// If the selection changed while applying the transactions but not while applying the
	// selection change, setSelection() won't have emitted a 'select' event. We don't want that
	// to happen, so emit one anyway.
	if (
		( !selectionBefore || !selectionBefore.equals( selectionAfter ) ) &&
		( selectionAfter && selectionAfter.equals( this.selection ) )
	) {
		this.emit( 'select', this.selection && this.selection.clone() );
	}

	if ( contextChange ) {
		this.emitContextChange();
	}

	this.stopQueueingContextChanges();
};

/**
 * Set a history state breakpoint.
 *
 * @method
 * @fires history
 * @returns {boolean} A breakpoint was added
 */
ve.dm.Surface.prototype.breakpoint = function () {
	if ( !this.enabled ) {
		return false;
	}
	if ( this.newTransactions.length > 0 ) {
		this.undoStack.push( {
			'transactions': this.newTransactions,
			'selection': this.selection && this.selection.clone(),
			'selectionBefore': this.selectionBefore && this.selectionBefore.clone()
		} );
		this.newTransactions = [];
		this.emit( 'history' );
		return true;
	} else if ( !this.selectionBefore && this.selection ) {
		this.selectionBefore = this.selection.clone();
	}
	return false;
};

/**
 * Step backwards in history.
 *
 * @method
 * @fires history
 */
ve.dm.Surface.prototype.undo = function () {
	var i, item, transaction, transactions = [];
	if ( !this.canUndo() ) {
		return;
	}

	if ( this.isStaging() ) {
		this.popAllStaging();
	}

	this.breakpoint();
	this.undoIndex++;

	item = this.undoStack[this.undoStack.length - this.undoIndex];
	if ( item ) {
		// Apply reversed transactions in reversed order
		for ( i = item.transactions.length - 1; i >= 0; i-- ) {
			transaction = item.transactions[i].reversed();
			transactions.push( transaction );
		}
		this.changeInternal( transactions, item.selectionBefore, true );
		this.emit( 'history' );
	}
};

/**
 * Step forwards in history.
 *
 * @method
 * @fires history
 */
ve.dm.Surface.prototype.redo = function () {
	var item;
	if ( !this.canRedo() ) {
		return;
	}

	this.breakpoint();

	item = this.undoStack[this.undoStack.length - this.undoIndex];
	if ( item ) {
		// ve.copy( item.transactions ) invokes .clone() on each transaction in item.transactions
		this.changeInternal( ve.copy( item.transactions ), item.selection, true );
		this.undoIndex--;
		this.emit( 'history' );
	}
};

/**
 * Respond to transactions processed on the document by translating the selection and updating
 * other state.
 *
 * @param {ve.dm.Transaction} tx Transaction that was processed
 * @fires documentUpdate
 */
ve.dm.Surface.prototype.onDocumentTransact = function ( tx ) {
	if ( this.selection ) {
		this.setSelection( tx.translateRange( this.selection ) );
	}
	this.emit( 'documentUpdate', tx );
};
