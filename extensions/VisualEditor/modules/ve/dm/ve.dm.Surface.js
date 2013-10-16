/*!
 * VisualEditor DataModel Surface class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel surface.
 *
 * @class
 * @mixins ve.EventEmitter
 *
 * @constructor
 * @param {ve.dm.Document} doc Document model to create surface for
 */
ve.dm.Surface = function VeDmSurface( doc ) {
	// Mixin constructors
	ve.EventEmitter.call( this );

	// Properties
	this.documentModel = doc;
	this.metaList = new ve.dm.MetaList( this );
	this.selection = new ve.Range( 1, 1 );
	this.selectedNodes = {};
	this.smallStack = [];
	this.bigStack = [];
	this.undoIndex = 0;
	this.historyTrackingInterval = null;
	this.insertionAnnotations = new ve.dm.AnnotationSet( this.documentModel.getStore() );
	this.enabled = true;
};

/* Inheritance */

ve.mixinClass( ve.dm.Surface, ve.EventEmitter );

/* Events */

/**
 * @event lock
 */

/**
 * @event unlock
 */

/**
 * @event select
 * @param {ve.ui.MenuItemWidget} item Menu item
 */

/**
 * @event transact
 * @param {ve.dm.Transaction[]} transactions Transactions that have just been processed
 */

/**
 * @event contextChange
 */

/**
 * @event change
 * @see #method-change
 * @param {ve.dm.Transaction|null} transaction
 * @param {ve.Range|undefined} selection
 */

/**
 * @event history
 */

/* Methods */

/**
 * Disable changes.
 *
 * @method
 */
ve.dm.Surface.prototype.disable = function () {
	this.stopHistoryTracking();
	this.enabled = false;
};

/**
 * Enable changes.
 *
 * @method
 */
ve.dm.Surface.prototype.enable = function () {
	this.enabled = true;
	this.startHistoryTracking();
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
 * Remove all states from history.
 *
 * @method
 */
ve.dm.Surface.prototype.purgeHistory = function () {
	if ( !this.enabled ) {
		return;
	}
	this.selection = new ve.Range( 0, 0 );
	this.smallStack = [];
	this.bigStack = [];
	this.undoIndex = 0;
};

/**
 * Get a list of all history states.
 *
 * @method
 * @returns {Object[]} List of transaction stacks
 */
ve.dm.Surface.prototype.getHistory = function () {
	if ( this.smallStack.length > 0 ) {
		return this.bigStack.slice( 0 ).concat( [{ 'stack': this.smallStack.slice( 0 ) }] );
	} else {
		return this.bigStack.slice( 0 );
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
 * @emits contextChange
 */
ve.dm.Surface.prototype.setInsertionAnnotations = function ( annotations ) {
	if ( !this.enabled ) {
		return;
	}
	this.insertionAnnotations = annotations !== null ?
		annotations.clone() :
		new ve.dm.AnnotationSet( this.documentModel.getStore() );

	this.emit( 'contextChange' );
};

/**
 * Add an annotation to be used upon insertion.
 *
 * @method
 * @param {ve.dm.Annotation|ve.dm.AnnotationSet} annotations Insertion annotation to add
 * @emits contextChange
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
	this.emit( 'contextChange' );
};

/**
 * Remove an annotation from those that will be used upon insertion.
 *
 * @method
 * @param {ve.dm.Annotation|ve.dm.AnnotationSet} annotations Insertion annotation to remove
 * @emits contextChange
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
	this.emit( 'contextChange' );
};

/**
 * Check if there is a state to redo.
 *
 * @method
 * @returns {boolean} Has a future state
 */
ve.dm.Surface.prototype.hasFutureState = function () {
	return this.undoIndex > 0;
};

/**
 * Check if there is a state to undo.
 *
 * @method
 * @returns {boolean} Has a past state
 */
ve.dm.Surface.prototype.hasPastState = function () {
	return this.bigStack.length - this.undoIndex > 0 || !!this.smallStack.length;
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
 */
ve.dm.Surface.prototype.getFragment = function ( range, noAutoSelect ) {
	return new ve.dm.SurfaceFragment( this, range || this.selection, noAutoSelect );
};

/**
 * Prevent future states from being redone.
 *
 * @method
 * @emits history
 */
ve.dm.Surface.prototype.truncateUndoStack = function () {
	if ( this.undoIndex ) {
		this.bigStack = this.bigStack.slice( 0, this.bigStack.length - this.undoIndex );
		this.undoIndex = 0;
		this.emit( 'history' );
	}
};

/**
 * Apply a transactions and selection changes to the document.
 *
 * @method
 * @param {ve.dm.Transaction|ve.dm.Transaction[]|null} transactions One or more transactions to
 *  process, or null to process none
 * @param {ve.Range|undefined} selection
 * @emits lock
 * @emits select
 * @emits transact
 * @emits contextChange
 * @emits change
 * @emits unlock
 */
ve.dm.Surface.prototype.change = function ( transactions, selection ) {
	if ( !this.enabled ) {
		return;
	}
	var i, len, left, right, leftAnnotations, rightAnnotations, insertionAnnotations,
		selectedNodes = {},
		selectionChange = false,
		contextChange = false,
		dataModelData = this.documentModel.data;

	// Stop observation polling, things changing right now are known already
	this.emit( 'lock' );

	// Process transactions and apply selection changes
	if ( transactions ) {
		if ( transactions instanceof ve.dm.Transaction ) {
			transactions = [transactions];
		}
		for ( i = 0, len = transactions.length; i < len; i++ ) {
			if ( !transactions[i].isNoOp() ) {
				this.truncateUndoStack();
				this.smallStack.push( transactions[i] );
				this.documentModel.commit( transactions[i] );
				if ( !selection ) {
					// translateRange only if selection is not provided because otherwise we are
					// going to overwrite it
					this.selection = transactions[i].translateRange( this.selection );
				}
			}
		}
	}

	if ( selection ) {
		// Detect if selection range changed
		if ( !this.selection || !this.selection.equals( selection ) ) {
			selectionChange = true;
		}
		// Detect if selected nodes changed
		selectedNodes.start = this.documentModel.getNodeFromOffset( selection.start );
		if ( selection.getLength() ) {
			selectedNodes.end = this.documentModel.getNodeFromOffset( selection.end );
		}
		if (
			selectedNodes.start !== this.selectedNodes.start ||
			selectedNodes.end !== this.selectedNodes.end
		) {
			contextChange = true;
		}
		this.selectedNodes = selectedNodes;
		if ( selectionChange ) {
			this.emit( 'select', this.selection.clone() );
		}
		this.selection = selection;
	}

	// Only emit a transact event if transactions were actually processed
	if ( transactions ) {
		this.emit( 'transact', transactions );
		// Detect context change, if not detected already, when element attributes have changed
		if ( !contextChange ) {
			for ( i = 0, len = transactions.length; i < len; i++ ) {
				if ( transactions[i].hasElementAttributeOperations() ) {
					contextChange = true;
					break;
				}
			}
		}
	}

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
		rightAnnotations = dataModelData.getAnnotationsFromOffset( right );
		insertionAnnotations = leftAnnotations.filter( function ( annotation ) {
			return annotation.constructor.static.applyToAppendedContent ||
				rightAnnotations.containsComparable( annotation );
		} );
	}

	// Only emit an annotations change event if there's a meaningful difference
	if (
		!insertionAnnotations.containsAllOf( this.insertionAnnotations ) ||
		!this.insertionAnnotations.containsAllOf( insertionAnnotations )
	) {
		this.setInsertionAnnotations( insertionAnnotations );
		contextChange = true;
	}

	// Only emit one context change event
	if ( contextChange ) {
		this.emit( 'contextChange' );
	}

	this.emit( 'change', transactions, selection );

	// Continue observation polling, we want to know about things that change from here on out
	this.emit( 'unlock' );
};

/**
 * Set a history state breakpoint.
 *
 * @method
 * @param {ve.Range} selection New selection range
 * @emits history
 * @returns {boolean} A breakpoint was added
 */
ve.dm.Surface.prototype.breakpoint = function ( selection ) {
	if ( !this.enabled ) {
		return false;
	}
	if ( this.smallStack.length > 0 ) {
		this.bigStack.push( {
			stack: this.smallStack,
			selection: selection || this.selection.clone()
		} );
		this.smallStack = [];
		this.emit( 'history' );
		return true;
	}
	return false;
};

/**
 * Step backwards in history.
 *
 * @method
 * @emits lock
 * @emits unlock
 * @emits history
 * @returns {ve.Range} Selection or null if no further state could be reached
 */
ve.dm.Surface.prototype.undo = function () {
	if ( !this.enabled || !this.hasPastState() ) {
		return;
	}
	var item, i, transaction, selection;
	this.breakpoint();
	this.undoIndex++;

	if ( this.bigStack[this.bigStack.length - this.undoIndex] ) {
		this.emit( 'lock' );
		item = this.bigStack[this.bigStack.length - this.undoIndex];
		selection = item.selection;

		for ( i = item.stack.length - 1; i >= 0; i-- ) {
			transaction = item.stack[i].reversed();
			selection = transaction.translateRange( selection );
			this.documentModel.commit( transaction );
		}
		this.emit( 'unlock' );
		this.emit( 'history' );
		return selection;
	}
	return null;
};

/**
 * Step forwards in history.
 *
 * @method
 * @emits lock
 * @emits unlock
 * @emits history
 * @returns {ve.Range} Selection or null if no further state could be reached
 */
ve.dm.Surface.prototype.redo = function () {
	if ( !this.enabled || !this.hasFutureState() ) {
		return;
	}
	var item, i, transaction, selection;
	this.breakpoint();

	if ( this.bigStack[this.bigStack.length - this.undoIndex] ) {
		this.emit( 'lock' );
		item = this.bigStack[this.bigStack.length - this.undoIndex];
		selection = item.selection;
		for ( i = 0; i < item.stack.length; i++ ) {
			transaction = item.stack[i].clone();
			this.documentModel.commit( transaction );
		}
		this.undoIndex--;
		this.emit( 'unlock' );
		this.emit( 'history' );
		return selection;
	}
	return null;
};
