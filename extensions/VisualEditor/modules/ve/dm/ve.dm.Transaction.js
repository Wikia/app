/**
 * Creates an ve.dm.Transaction object.
 * 
 * @class
 * @constructor
 * @param {Object[]} operations List of operations
 */
ve.dm.Transaction = function( operations ) {
	this.operations = ve.isArray( operations ) ? operations : [];
	this.lengthDifference = 0;
};

/* Methods */

/**
 * Gets a list of all operations.
 * 
 * @method
 * @returns {Object[]} List of operations
 */
ve.dm.Transaction.prototype.getOperations = function() {
	return this.operations;
};

/**
 * Gets the difference in content length this transaction will cause if applied.
 * 
 * @method
 * @returns {Integer} Difference in content length
 */
ve.dm.Transaction.prototype.getLengthDifference = function() {
	return this.lengthDifference;
};

/**
 * Adds a retain operation.
 * 
 * @method
 * @param {Integer} length Length of content data to retain
 */
ve.dm.Transaction.prototype.pushRetain = function( length ) {
	var end = this.operations.length - 1;
	if ( this.operations.length && this.operations[end].type === 'retain' ) {
		this.operations[end].length += length;
	} else {
		this.operations.push( {
			'type': 'retain',
			'length': length
		} );
	}
};

/**
 * Adds an insertion operation.
 * 
 * @method
 * @param {Array} data Data to retain
 */
ve.dm.Transaction.prototype.pushInsert = function( data ) {
	var end = this.operations.length - 1;
	if ( this.operations.length && this.operations[end].type === 'insert' ) {
		this.operations[end].data = this.operations[end].data.concat( data );
	} else {
		this.operations.push( {
			'type': 'insert',
			'data': data
		} );
	}
	this.lengthDifference += data.length;
};

/**
 * Adds a removal operation.
 * 
 * @method
 * @param {Array} data Data to remove
 */
ve.dm.Transaction.prototype.pushRemove = function( data ) {
	var end = this.operations.length - 1;
	if ( this.operations.length && this.operations[end].type === 'remove' ) {
		this.operations[end].data = this.operations[end].data.concat( data );
	} else {
		this.operations.push( {
			'type': 'remove',
			'data': data
		} );
	}
	this.lengthDifference -= data.length;
};

/**
 * Adds an element attribute change operation.
 * 
 * @method
 * @param {String} method Method to use, either "set" or "clear"
 * @param {String} key Name of attribute to change
 * @param {Mixed} value Value to set attribute to, or value of attribute being cleared
 */
ve.dm.Transaction.prototype.pushChangeElementAttribute = function( method, key, value ) {
	this.operations.push( {
		'type': 'attribute',
		'method': method,
		'key': key,
		'value': value
	} );
};

/**
 * Adds a start annotating operation.
 * 
 * @method
 * @param {String} method Method to use, either "set" or "clear"
 * @param {Object} annotation Annotation object to start setting or clearing from content data
 */
ve.dm.Transaction.prototype.pushStartAnnotating = function( method, annotation ) {
	this.operations.push( {
		'type': 'annotate',
		'method': method,
		'bias': 'start',
		'annotation': annotation
	} );
};

/**
 * Adds a stop annotating operation.
 * 
 * @method
 * @param {String} method Method to use, either "set" or "clear"
 * @param {Object} annotation Annotation object to stop setting or clearing from content data
 */
ve.dm.Transaction.prototype.pushStopAnnotating = function( method, annotation ) {
	this.operations.push( {
		'type': 'annotate',
		'method': method,
		'bias': 'stop',
		'annotation': annotation
	} );
};
