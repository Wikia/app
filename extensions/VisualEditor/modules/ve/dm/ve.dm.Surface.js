/**
 * Creates an ve.dm.Surface object.
 * 
 * @class
 * @constructor
 * @extends {ve.EventEmitter}
 * @param {ve.dm.DocumentNode} doc Document model to create surface for
 */
ve.dm.Surface = function( doc ) {
	// Inheritance
	ve.EventEmitter.call( this );

	// Properties
	this.doc = doc;
	this.selection = null;

	this.smallStack = [];
	this.bigStack = [];
	this.undoIndex = 0;

	var _this = this;
	setInterval( function () {
		_this.breakpoint();
	}, 750 );
};

/* Methods */

ve.dm.Surface.prototype.purgeHistory = function() {
	this.selection = null;
	this.smallStack = [];
	this.bigStack = [];
	this.undoIndex = 0;	
};

ve.dm.Surface.prototype.getHistory = function() {
	if ( this.smallStack.length > 0 ) {
		return this.bigStack.slice( 0 ).concat( [{ 'stack': this.smallStack.slice(0) }] ); 
	} else {
		return this.bigStack.slice( 0 );
	}
};

/**
 * Gets the document model of the surface.
 * 
 * @method
 * @returns {ve.dm.DocumentNode} Document model of the surface
 */
ve.dm.Surface.prototype.getDocument = function() {
	return this.doc;
};

/**
 * Gets the selection 
 * 
 * @method
 * @returns {ve.Range} Current selection
 */
ve.dm.Surface.prototype.getSelection = function() {
	return this.selection;
};

/**
 * Changes the selection.
 * 
 * If changing the selection at a high frequency (such as while dragging) use the combine argument
 * to avoid them being split up into multiple history items
 * 
 * @method
 * @param {ve.Range} selection
 * @param {Boolean} isManual Whether this selection was the result of a user action, and thus should
 * be recorded in history...?
 */
ve.dm.Surface.prototype.select = function( selection, isManual ) {
	selection.normalize();
	/*if (
		( ! this.selection ) || ( ! this.selection.equals( selection ) )
	) {*/
		if ( isManual ) {
			this.breakpoint();
		}
		// check if the last thing is a selection, if so, swap it.
		this.selection = selection;	
		this.emit( 'select', this.selection.clone() );
	//}
};

/**
 * Applies a series of transactions to the content data.
 * 
 * If committing multiple transactions which are the result of a single user action and need to be
 * part of a single history item, use the isPartial argument for all but the last one to avoid them
 * being split up into multple history items.
 * 
 * @method
 * @param {ve.dm.Transaction} transactions Tranasction to apply to the document
 * @param {boolean} isPartial whether this transaction is part of a larger logical grouping of
 * transactions (such as when replacing - delete, then insert)
 */
ve.dm.Surface.prototype.transact = function( transaction ) {
	this.bigStack = this.bigStack.slice( 0, this.bigStack.length - this.undoIndex );
	this.undoIndex = 0;
	this.smallStack.push( transaction );
	this.doc.commit( transaction );
	this.emit( 'transact', transaction );
};

ve.dm.Surface.prototype.breakpoint = function( selection ) {
	if( this.smallStack.length > 0 ) {
		this.bigStack.push( {
			stack: this.smallStack,
			selection: selection || this.selection.clone()
		} );
		this.smallStack = [];
	}};

ve.dm.Surface.prototype.undo = function() {
	this.breakpoint();
	this.undoIndex++
	if ( this.bigStack[this.bigStack.length - this.undoIndex] ) {
		var diff = 0;
		var item = this.bigStack[this.bigStack.length - this.undoIndex];
		for( var i = item.stack.length - 1; i >= 0; i-- ) {
			this.doc.rollback( item.stack[i] );
			diff += item.stack[i].lengthDifference;
		}
		var selection = item.selection;
		selection.from -= diff;
		selection.to -= diff;
		this.select( selection );
	}
};

ve.dm.Surface.prototype.redo = function() {
	this.breakpoint();
	if ( this.undoIndex > 0 ) {
		if ( this.bigStack[this.bigStack.length - this.undoIndex] ) {
			var diff = 0;
			var item = this.bigStack[this.bigStack.length - this.undoIndex];
			for( var i = 0; i < item.stack.length; i++ ) {
				this.doc.commit( item.stack[i] );
				diff += item.stack[i].lengthDifference;
			}
			var selection = item.selection;
			selection.from += diff;
			selection.to += diff;
			this.selection = null;
			this.select( selection );
		}
		this.undoIndex--;
	}
};

/* Inheritance */

ve.extendClass( ve.dm.Surface, ve.EventEmitter );
