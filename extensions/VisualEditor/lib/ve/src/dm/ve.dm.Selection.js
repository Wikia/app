/*!
 * VisualEditor Selection class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * @class
 * @abstract
 * @constructor
 * @param {ve.dm.Document} doc Document
 */
ve.dm.Selection = function VeDmSelection( doc ) {
	this.documentModel = doc;
};

/* Inheritance */

OO.initClass( ve.dm.Selection );

/* Static Properties */

ve.dm.Selection.static.type = null;

/* Static Methods */

/**
 * Create a new selection from a JSON serialization
 *
 * @param {ve.dm.Document} doc Document to create the selection on
 * @param {string|Object} json JSON serialization or hash object
 * @return {ve.dm.Selection} New selection
 * @throws {Error} Unknown selection type
 */
ve.dm.Selection.static.newFromJSON = function ( doc, json ) {
	var hash = typeof json === 'string' ? JSON.parse( json ) : json,
		constructor = ve.dm.selectionFactory.lookup( hash.type );

	if ( !constructor ) {
		throw new Error( 'Unknown selection type ' + hash.name );
	}

	return constructor.static.newFromHash( doc, hash );
};

/**
 * Create a new selection from a hash object
 *
 * @abstract
 * @method
 * @param {ve.dm.Document} doc Document to create the selection on
 * @param {Object} hash Hash object
 * @return {ve.dm.Selection} New selection
 */
ve.dm.Selection.static.newFromHash = null;

/* Methods */

/**
 * Get a JSON serialization of this selection
 *
 * @abstract
 * @method
 * @return {Object} Object for JSON serialization
 */
ve.dm.Selection.prototype.toJSON = null;

/**
 * Get a textual description of this selection, for debugging purposes
 *
 * @abstract
 * @method
 * @return {string} Textual description
 */
ve.dm.Selection.prototype.getDescription = null;

/**
 * Create a copy of this selection
 *
 * @abstract
 * @method
 * @return {ve.dm.Selection} Cloned selection
 */
ve.dm.Selection.prototype.clone = null;

/**
 * Get a new selection at the start point of this one
 *
 * @abstract
 * @method
 * @return {ve.dm.Selection} Collapsed selection
 */
ve.dm.Selection.prototype.collapseToStart = null;

/**
 * Get a new selection at the end point of this one
 *
 * @abstract
 * @method
 * @return {ve.dm.Selection} Collapsed selection
 */
ve.dm.Selection.prototype.collapseToEnd = null;

/**
 * Get a new selection at the 'from' point of this one
 *
 * @abstract
 * @method
 * @return {ve.dm.Selection} Collapsed selection
 */
ve.dm.Selection.prototype.collapseToFrom = null;

/**
 * Get a new selection at the 'to' point of this one
 *
 * @abstract
 * @method
 * @return {ve.dm.Selection} Collapsed selection
 */
ve.dm.Selection.prototype.collapseToTo = null;

/**
 * Check if a selection is collapsed
 *
 * @abstract
 * @method
 * @return {boolean} Selection is collapsed
 */
ve.dm.Selection.prototype.isCollapsed = null;

/**
 * Apply translations from a transaction
 *
 * @abstract
 * @method
 * @param {ve.dm.Transaction} tx Transaction
 * @param {boolean} [excludeInsertion] Do not grow to cover insertions at boundaries
 * @return {ve.dm.Selection} A new translated selection
 */
ve.dm.Selection.prototype.translateByTransaction = null;

/**
 * Apply translations from a set of transactions
 *
 * @param {ve.dm.Transaction[]} txs Transactions
 * @param {boolean} [excludeInsertion] Do not grow to cover insertions at boundaries
 * @return {ve.dm.Selection} A new translated selection
 */
ve.dm.Selection.prototype.translateByTransactions = function ( txs, excludeInsertion ) {
	var i, l, selection = this;
	for ( i = 0, l = txs.length; i < l; i++ ) {
		selection = selection.translateByTransaction( txs[ i ], excludeInsertion );
	}
	return selection;
};

/**
 * Check if this selection is null
 *
 * @return {boolean} The selection is null
 */
ve.dm.Selection.prototype.isNull = function () {
	return false;
};

/**
 * Get the content ranges for this selection
 *
 * @abstract
 * @method
 * @return {ve.Range[]} Ranges
 */
ve.dm.Selection.prototype.getRanges = null;

/**
 * Get the document model this selection applies to
 *
 * @return {ve.dm.Document} Document model
 */
ve.dm.Selection.prototype.getDocument = function () {
	return this.documentModel;
};

/**
 * Check if two selections are equal
 *
 * @abstract
 * @method
 * @param {ve.dm.Selection} other Other selection
 * @return {boolean} Selections are equal
 */
ve.dm.Selection.prototype.equals = null;

/* Factory */

ve.dm.selectionFactory = new OO.Factory();
