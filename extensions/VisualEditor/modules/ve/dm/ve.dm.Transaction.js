/**
 * VisualEditor data model Transaction class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel transaction.
 *
 * @class
 * @constructor
 */
ve.dm.Transaction = function VeDmTransaction() {
	this.operations = [];
	this.lengthDifference = 0;
	this.applied = false;
	this.changeMarkers = {};
};

/* Static Methods */

/**
 * Generates a transaction that inserts data at a given offset.
 *
 * @static
 * @method
 * @param {ve.dm.Document} doc Document to create transaction for
 * @param {Number} offset Offset to insert at
 * @param {Array} data Data to insert
 * @returns {ve.dm.Transaction} Transcation that inserts data
 */
ve.dm.Transaction.newFromInsertion = function ( doc, offset, insertion ) {
	var tx = new ve.dm.Transaction(),
		data = doc.getData();
	// Fix up the insertion
	insertion = doc.fixupInsertion( insertion, offset );
	// Retain up to insertion point, if needed
	tx.pushRetain( offset );
	// Insert data
	tx.pushReplace( [], insertion );
	// Retain to end of document, if needed (for completeness)
	tx.pushRetain( data.length - offset );
	return tx;
};

/**
 * Generates a transaction which removes data from a given range.
 *
 * There are three possible results from a removal:
 *    1. Remove content only
 *       - Occurs when the range starts and ends on elements of different type, depth or ancestry
 *    2. Remove entire elements and their content
 *       - Occurs when the range spans across an entire element
 *    3. Merge two elements by removing the end of one and the beginning of another
 *       - Occurs when the range starts and ends on elements of similar type, depth and ancestry
 *
 * This function uses the following logic to decide what to actually remove:
 *     1. Elements are only removed if range being removed covers the entire element
 *     2. Elements can only be merged if ve.dm.Node.canBeMergedWith() returns true
 *     3. Merges take place at the highest common ancestor
 *
 * @method
 * @param {ve.dm.Document} doc Document to create transaction for
 * @param {ve.Range} range Range of data to remove
 * @returns {ve.dm.Transaction} Transcation that removes data
 * @throws 'Invalid range, can not remove from {range.start} to {range.end}'
 */
ve.dm.Transaction.newFromRemoval = function ( doc, range ) {
	var i, selection, first, last, nodeStart, nodeEnd,
		offset = 0,
		removeStart = null,
		removeEnd = null,
		tx = new ve.dm.Transaction(),
		data = doc.getData();
	// Normalize and validate range
	range.normalize();
	if ( range.start === range.end ) {
		// Empty range, nothing to remove, retain up to the end of the document (for completeness)
		tx.pushRetain( data.length );
		return tx;
	}
	// Select nodes and validate selection
	selection = doc.selectNodes( range, 'covered' );
	if ( selection.length === 0 ) {
		// Empty selection? Something is wrong!
		throw new Error( 'Invalid range, cannot remove from ' + range.start + ' to ' + range.end );
	}
	first = selection[0];
	last = selection[selection.length - 1];
	// If the first and last node are mergeable, merge them
	if ( first.node.canBeMergedWith( last.node ) ) {
		if ( !first.range && !last.range ) {
			// First and last node are both completely covered, remove them
			removeStart = first.nodeOuterRange.start;
			removeEnd = last.nodeOuterRange.end;
		} else {
			// Either the first node or the last node is partially covered, so remove
			// the selected content
			removeStart = ( first.range || first.nodeRange ).start;
			removeEnd = ( last.range || last.nodeRange ).end;
		}
		tx.pushRetain( removeStart );
		tx.pushReplace( data.slice( removeStart, removeEnd ), [] );
		tx.pushRetain( data.length - removeEnd );
		// All done
		return tx;
	}

	// The selection wasn't mergeable, so remove nodes that are completely covered, and strip
	// nodes that aren't
	for ( i = 0; i < selection.length; i++ ) {
		if ( !selection[i].range ) {
			// Entire node is covered, remove it
			nodeStart = selection[i].nodeOuterRange.start;
			nodeEnd = selection[i].nodeOuterRange.end;
		} else {
			// Part of the node is covered, remove that range
			nodeStart = selection[i].range.start;
			nodeEnd = selection[i].range.end;
		}

		// Merge contiguous removals. Only apply a removal when a gap appears, or at the
		// end of the loop
		if ( removeEnd === null ) {
			// First removal
			removeStart = nodeStart;
			removeEnd = nodeEnd;
		} else if ( removeEnd === nodeStart ) {
			// Merge this removal into the previous one
			removeEnd = nodeEnd;
		} else {
			// There is a gap between the previous removal and this one

			// Push the previous removal first
			tx.pushRetain( removeStart - offset );
			tx.pushReplace( data.slice( removeStart, removeEnd ), [] );
			offset = removeEnd;

			// Now start this removal
			removeStart = nodeStart;
			removeEnd = nodeEnd;
		}
	}
	// Apply the last removal, if any
	if ( removeEnd !== null ) {
		tx.pushRetain( removeStart - offset );
		tx.pushReplace( data.slice( removeStart, removeEnd ), [] );
		offset = removeEnd;
	}
	// Retain up to the end of the document
	tx.pushRetain( data.length - offset );
	return tx;
};

/**
 * Generates a transaction that changes an attribute.
 *
 * @static
 * @method
 * @param {ve.dm.Document} doc Document to create transaction for
 * @param {Number} offset Offset of element
 * @param {String} key Attribute name
 * @param {Mixed} value New value, or undefined to remove the attribute
 * @returns {ve.dm.Transaction} Transcation that changes an element
 * @throws 'Can not set attributes to non-element data'
 * @throws 'Can not set attributes on closing element'
 */
ve.dm.Transaction.newFromAttributeChange = function ( doc, offset, key, value ) {
	var tx = new ve.dm.Transaction(),
		data = doc.getData();
	// Verify element exists at offset
	if ( data[offset].type === undefined ) {
		throw new Error( 'Can not set attributes to non-element data' );
	}
	// Verify element is not a closing
	if ( data[offset].type.charAt( 0 ) === '/' ) {
		throw new Error( 'Can not set attributes on closing element' );
	}
	// Retain up to element
	tx.pushRetain( offset );
	// Change attribute
	tx.pushReplaceElementAttribute(
		key, 'attributes' in data[offset] ? data[offset].attributes[key] : undefined, value
	);
	// Retain to end of document
	tx.pushRetain( data.length - offset );
	return tx;
};

/**
 * Generates a transaction that annotates content.
 *
 * @static
 * @method
 * @param {ve.dm.Document} doc Document to create transaction for
 * @param {ve.Range} range Range to annotate
 * @param {String} method Annotation mode
 *     'set': Adds annotation to all content in range
 *     'clear': Removes instances of annotation from content in range
 * @param {Object} annotation Annotation to set or clear
 * @returns {ve.dm.Transaction} Transaction that annotates content
 */
ve.dm.Transaction.newFromAnnotation = function ( doc, range, method, annotation ) {
	var covered,
		tx = new ve.dm.Transaction(),
		data = doc.getData(),
		i = range.start,
		span = i,
		on = false;
	// Iterate over all data in range, annotating where appropriate
	range.normalize();
	while ( i < range.end ) {
		if ( data[i].type !== undefined ) {
			// Element
			if ( on ) {
				tx.pushRetain( span );
				tx.pushStopAnnotating( method, annotation );
				span = 0;
				on = false;
			}
		} else {
			// Content
			covered = doc.offsetContainsAnnotation( i, annotation );
			if ( ( covered && method === 'set' ) || ( !covered && method === 'clear' ) ) {
				// Skip annotated content
				if ( on ) {
					tx.pushRetain( span );
					tx.pushStopAnnotating( method, annotation );
					span = 0;
					on = false;
				}
			} else {
				// Cover non-annotated content
				if ( !on ) {
					tx.pushRetain( span );
					tx.pushStartAnnotating( method, annotation );
					span = 0;
					on = true;
				}
			}
		}
		span++;
		i++;
	}
	tx.pushRetain( span );
	if ( on ) {
		tx.pushStopAnnotating( method, annotation );
	}
	tx.pushRetain( data.length - range.end );
	return tx;
};

/**
 * Generates a transaction that converts elements that can contain content.
 *
 * @static
 * @method
 * @param {ve.dm.Document} doc Document to create transaction for
 * @param {ve.Range} range Range to convert
 * @param {String} type Symbolic name of element type to convert to
 * @param {Object} attr Attributes to initialize element with
 * @returns {ve.dm.Transaction} Transaction that converts content branches
 */
ve.dm.Transaction.newFromContentBranchConversion = function ( doc, range, type, attr ) {
	var i, selected, branch, branchOuterRange,
		tx = new ve.dm.Transaction(),
		data = doc.getData(),
		selection = doc.selectNodes( range, 'leaves' ),
		opening = { 'type': type },
		closing = { 'type': '/' + type },
		previousBranch,
		previousBranchOuterRange;
	// Add attributes to opening if needed
	if ( ve.isPlainObject( attr ) ) {
		opening.attributes = attr;
	} else {
		attr = {};
	}
	// Replace the wrappings of each content branch in the range
	for ( i = 0; i < selection.length; i++ ) {
		selected = selection[i];
		if ( selected.node.isContent() ) {
			branch = selected.node.getParent();
			// Skip branches that are already of the target type and have identical attributes
			if ( branch.getType() === type && ve.compareObjects( branch.getAttributes(), attr ) ) {
				continue;
			}
			branchOuterRange = branch.getOuterRange();
			// Don't convert the same branch twice
			if ( branch === previousBranch ) {
				continue;
			}
			// Retain up to this branch, considering where the previous one left off
			tx.pushRetain(
				branchOuterRange.start - ( previousBranch ? previousBranchOuterRange.end : 0 )
			);
			// Replace the opening
			tx.pushReplace( [data[branchOuterRange.start]], [ve.copyObject( opening )] );
			// Retain the contents
			tx.pushRetain( branch.getLength() );
			// Replace the closing
			tx.pushReplace( [data[branchOuterRange.end - 1]], [ve.copyObject( closing )] );
			// Remember this branch and its range for next time
			previousBranch = branch;
			previousBranchOuterRange = branchOuterRange;
		}
	}
	// Retain until the end
	tx.pushRetain(
		data.length - ( previousBranch ? previousBranchOuterRange.end : 0 )
	);
	return tx;
};

/**
 * Generates a transaction which wraps, unwraps or replaces structure.
 *
 * The unwrap parameters are checked against the actual model data, and
 * an exception is thrown if the type fields don't match. This means you
 * can omit attributes from the unwrap parameters, those are automatically
 * picked up from the model data instead.
 *
 * NOTE: This function currently does not fix invalid parent/child relationships, so it will
 * happily convert paragraphs to listItems without wrapping them in a list if that's what you
 * ask it to do. We'll probably fix this later but for now the caller is responsible for giving
 * valid instructions.
 *
 * @param {ve.dm.Document} doc Document to generate a transaction for
 * @param {ve.Range} range Range to wrap/unwrap/replace around
 * @param {Array} unwrapOuter Array of opening elements to unwrap. These must be immediately *outside* the range.
 * @param {Array} wrapOuter Array of opening elements to wrap around the range.
 * @param {Array} unwrapEach Array of opening elements to unwrap from each top-level element in the range.
 * @param {Array} wrapEach Array of opening elements to wrap around each top-level element in the range.
 * @returns {ve.dm.Transaction}
 *
 * @example Changing a paragraph to a header:
 *     Before: [ {'type': 'paragraph'}, 'a', 'b', 'c', {'type': '/paragraph'} ]
 *     newFromWrap( new ve.Range( 1, 4 ), [ {'type': 'paragraph'} ], [ {'type': 'heading', 'level': 1 } ] );
 *     After: [ {'type': 'heading', 'level': 1 }, 'a', 'b', 'c', {'type': '/heading'} ]
 *
 * @example Changing a set of paragraphs to a list:
 *     Before: [ {'type': 'paragraph'}, 'a', {'type': '/paragraph'}, {'type':'paragraph'}, 'b', {'type':'/paragraph'} ]
 *     newFromWrap( new ve.Range( 0, 6 ), [], [ {'type': 'list' } ], [], [ {'type': 'listItem', 'attributes': {'styles': ['bullet']}} ] );
 *     After: [ {'type': 'list'}, {'type': 'listItem', 'attributes': {'styles': ['bullet']}}, {'type':'paragraph'} 'a',
 *              {'type': '/paragraph'}, {'type': '/listItem'}, {'type': 'listItem', 'attributes': {'styles': ['bullet']}},
 *              {'type': 'paragraph'}, 'b', {'type': '/paragraph'}, {'type': '/listItem'}, {'type': '/list'} ]
 */
ve.dm.Transaction.newFromWrap = function ( doc, range, unwrapOuter, wrapOuter, unwrapEach, wrapEach ) {
	var i, j, unwrapOuterData, startOffset, unwrapEachData, closingUnwrapEach, closingWrapEach,
		tx = new ve.dm.Transaction(),
		depth = 0;

	// Function to generate arrays of closing elements in reverse order
	function closingArray( openings ) {
		var closings = [], i, len = openings.length;
		for ( i = 0; i < len; i++ ) {
			closings[closings.length] = { 'type': '/' + openings[len - i - 1].type };
		}
		return closings;
	}
	closingUnwrapEach = closingArray( unwrapEach );
	closingWrapEach = closingArray( wrapEach );

	// TODO: check for and fix nesting validity like fixupInsertion does
	range.normalize();
	if ( range.start > unwrapOuter.length ) {
		// Retain up to the first thing we're unwrapping
		// The outer unwrapping takes place *outside*
		// the range, so compensate for that
		tx.pushRetain( range.start - unwrapOuter.length );
	} else if ( range.start < unwrapOuter.length ) {
		throw new Error( 'unwrapOuter is longer than the data preceding the range' );
	}

	// Replace the opening elements for the outer unwrap&wrap
	if ( wrapOuter.length > 0 || unwrapOuter.length > 0 ) {
		// Verify that wrapOuter matches the data at this position
		unwrapOuterData = doc.data.slice( range.start - unwrapOuter.length, range.start );
		for ( i = 0; i < unwrapOuterData.length; i++ ) {
			if ( unwrapOuterData[i].type !== unwrapOuter[i].type ) {
				throw new Error( 'Element in unwrapOuter does not match: expected ' +
					unwrapOuter[i].type + ' but found ' + unwrapOuterData[i].type );
			}
		}
		// Instead of putting in unwrapOuter as given, put it in the
		// way it appears in the mode,l so we pick up any attributes
		tx.pushReplace( unwrapOuterData, ve.copyArray( wrapOuter ) );
	}

	if ( wrapEach.length > 0 || unwrapEach.length > 0 ) {
		// Visit each top-level child and wrap/unwrap it
		// TODO figure out if we should use the tree/node functions here
		// rather than iterating over offsets, it may or may not be faster
		for ( i = range.start; i < range.end; i++ ) {
			if ( doc.data[i].type !== undefined ) {
				// This is a structural offset
				if ( doc.data[i].type.charAt( 0 ) !== '/' ) {
					// This is an opening element
					if ( depth === 0 ) {
						// We are at the start of a top-level element
						// Replace the opening elements

						// Verify that unwrapEach matches the data at this position
						unwrapEachData = doc.data.slice( i, i + unwrapEach.length );
						for ( j = 0; j < unwrapEachData.length; j++ ) {
							if ( unwrapEachData[j].type !== unwrapEach[j].type ) {
								throw new Error( 'Element in unwrapEach does not match: expected ' +
									unwrapEach[j].type + ' but found ' +
									unwrapEachData[j].type );
							}
						}
						// Instead of putting in unwrapEach as given, put it in the
						// way it appears in the model, so we pick up any attributes
						tx.pushReplace( ve.copyArray( unwrapEachData ), ve.copyArray( wrapEach ) );

						// Store this offset for later
						startOffset = i;
					}
					depth++;
				} else {
					// This is a closing element
					depth--;
					if ( depth === 0 ) {
						// We are at the end of a top-level element
						// Retain the contents of what we're wrapping
						tx.pushRetain( i - startOffset + 1 - unwrapEach.length*2 );
						// Replace the closing elements
						tx.pushReplace( ve.copyArray( closingUnwrapEach ), ve.copyArray( closingWrapEach ) );
					}
				}
			}
		}
	} else {
		// There is no wrapEach/unwrapEach to be done, just retain
		// up to the end of the range
		tx.pushRetain( range.end - range.start );
	}

	if ( wrapOuter.length > 0 || unwrapOuter.length > 0 ) {
		tx.pushReplace( closingArray( unwrapOuter ), closingArray( wrapOuter ) );
	}

	// Retain up to the end of the document
	if ( range.end < doc.data.length ) {
		tx.pushRetain( doc.data.length - range.end - unwrapOuter.length );
	}

	return tx;
};

/* Methods */

/**
 * Checks if transaction would make any actual changes if processed.
 *
 * There may be more sophisticated checks that can be done, like looking for things being replaced
 * with identical content, but such transactions probably should not be created in the first place.
 *
 * @method
 * @returns {Boolean} Transaction is no-op
 */
ve.dm.Transaction.prototype.isNoOp = function () {
	return (
		this.operations.length === 0 ||
		( this.operations.length === 1 && this.operations[0].type === 'retain' )
	);
};

/**
 * Gets a list of all operations.
 *
 * @method
 * @returns {Object[]} List of operations
 */
ve.dm.Transaction.prototype.getOperations = function () {
	return this.operations;
};

/**
 * Gets the difference in content length this transaction will cause if applied.
 *
 * @method
 * @returns {Number} Difference in content length
 */
ve.dm.Transaction.prototype.getLengthDifference = function () {
	return this.lengthDifference;
};

/**
 * Checks whether this transaction has already been applied.
 *
 * A transaction that has been applied can be rolled back, at which point it will no longer be
 * considered applied. In other words, this function returns false if the transaction can be
 * committed, and true if the transaction can be rolled back.
 *
 * @method
 * @returns {Boolean}
 */
ve.dm.Transaction.prototype.hasBeenApplied = function () {
	return this.applied;
};

/**
 * Toggle the 'applied' state of this transaction. Should only be called after committing or
 * rolling back the transaction.
 * @see {ve.dm.Transaction.prototype.hasBeenApplied}
 */
ve.dm.Transaction.prototype.toggleApplied = function () {
	this.applied = !this.applied;
}

/**
 * Translate an offset based on a transaction.
 *
 * This is useful when you want to anticipate what an offset will be after a transaction is
 * processed.
 *
 * @method
 * @param {Number} offset Offset in the linear model before the transaction has been processed
 * @returns {Number} Translated offset, as it will be after processing transaction
 */
ve.dm.Transaction.prototype.translateOffset = function ( offset, reversed ) {
	var i, cursor = 0, adjustment = 0, op, insertLength, removeLength;
	for ( i = 0; i < this.operations.length; i++ ) {
		op = this.operations[i];
		if ( op.type === 'replace' ) {
			insertLength = reversed ? op.remove.length : op.insert.length;
			removeLength = reversed ? op.insert.length : op.remove.length;
			adjustment += insertLength - removeLength;
			if ( offset === cursor + removeLength ) {
				// Offset points to right after the removal, translate it
				return offset + adjustment;
			} else if ( offset >= cursor && offset < cursor + removeLength ) {
				// The offset points inside of the removal
				return cursor + removeLength + adjustment;
			}
			cursor += removeLength;
		} else if ( op.type === 'retain' ) {
			if ( offset >= cursor && offset < cursor + op.length ) {
				return offset + adjustment;
			}
			cursor += op.length;
		}
	}
	return offset + adjustment;
};

/**
 * Translate a range based on a transaction.
 *
 * This is useful when you want to anticipate what a selection will be after a transaction is
 * processed.
 *
 * @method
 * @see {translateOffset}
 * @param {ve.Range} range Range in the linear model before the transaction has been processed
 * @returns {ve.Range} Translated range, as it will be after processing transaction
 */
ve.dm.Transaction.prototype.translateRange = function ( range, reversed ) {
	return new ve.Range( this.translateOffset( range.from, reversed ), this.translateOffset( range.to, reversed ) );
};

/**
 * Adds a retain operation.
 *
 * @method
 * @param {Number} length Length of content data to retain
 * @throws 'Invalid retain length, can not retain backwards: {length}'
 */
ve.dm.Transaction.prototype.pushRetain = function ( length ) {
	if ( length < 0 ) {
		throw new Error( 'Invalid retain length, can not retain backwards:' + length );
	}
	if ( length ) {
		var end = this.operations.length - 1;
		if ( this.operations.length && this.operations[end].type === 'retain' ) {
			this.operations[end].length += length;
		} else {
			this.operations.push( {
				'type': 'retain',
				'length': length
			} );
		}
	}
};

/**
 * Adds a replace operation
 *
 * @method
 * @param {Array} remove Data to remove
 * @param {Array] insert Data to replace 'remove' with
 */
ve.dm.Transaction.prototype.pushReplace = function ( remove, insert ) {
	if ( remove.length === 0 && insert.length === 0 ) {
		// Don't push no-ops
		return;
	}
	this.operations.push( {
		'type': 'replace',
		'remove': remove,
		'insert': insert
	} );
	this.lengthDifference += insert.length - remove.length;
};

/**
 * Adds an element attribute change operation.
 *
 * @method
 * @param {String} key Name of attribute to change
 * @param {Mixed} from Value change attribute from, or undefined if not previously set
 * @param {Mixed} to Value to change attribute to, or undefined to remove
 */
ve.dm.Transaction.prototype.pushReplaceElementAttribute = function ( key, from, to ) {
	this.operations.push( {
		'type': 'attribute',
		'key': key,
		'from': from,
		'to': to
	} );
};

/**
 * Adds a start annotating operation.
 *
 * @method
 * @param {String} method Method to use, either "set" or "clear"
 * @param {Object} annotation Annotation object to start setting or clearing from content data
 */
ve.dm.Transaction.prototype.pushStartAnnotating = function ( method, annotation ) {
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
ve.dm.Transaction.prototype.pushStopAnnotating = function ( method, annotation ) {
	this.operations.push( {
		'type': 'annotate',
		'method': method,
		'bias': 'stop',
		'annotation': annotation
	} );
};

/**
 * Get the change markers for this transaction. Change markers are added using setChangeMarker().
 *
 * @returns {Object} { offset: { markerType: number } }
 */
ve.dm.Transaction.prototype.getChangeMarkers = function () {
	return this.changeMarkers;
};

/**
 * Store a change marker to mark a change made while applying the transaction. Markers are stored
 * in the .internal.changed property of elements in the linear model, as well as in the Transaction
 * that effected the changes.
 *
 * The purpose of storing change markers in the linear model is so the linmod->HTML converter can
 * mark what has changed relative to the HTML we originally received. For that reason, change
 * markers only track what has changed relative to the original state of the document. This means
 * we avoid reporting changes that cancel each other out, where possible. For instance, if an
 * element marked 'created' is changed, this doesn't result in an additional change marker.
 * In particular, rolling back a transaction causes all change marking done by that transaction to
 * be undone. For that reason, change markers are stored in the Transaction object as well, so it's
 * easy to undo a transaction's markers when rolling back.
 *
 * Marker types:
 * - 'created': This element was newly created and did not exist in the original document
 * - 'attributes': This element's attributes have changed
 * - 'content': This element's content changed (content-containing elements only)
 * - 'annotations': The annotations within this element changed (content-containing elements only)
 * - 'rebuilt': This element and its children/contents changed in some way, no details available
 *
 * Change markers are numbers, which are incremented when setting a marker and decremented when
 * unsetting it. This is because the same event can occur multiple times for the same element, and
 * we want to be able to keep track of whether all the changes have canceled each other out.
 *
 * @param {Number} offset Linear model offset (post-transaction) of the element to mark
 * @param {String} marker Marker type
 * @param {Number} [increment=1] Number to add to the change marker counter
 */
ve.dm.Transaction.prototype.setChangeMarker = function ( offset, marker, increment ) {
	increment = increment || 1;
	if ( this.changeMarkers[offset] === undefined ) {
		this.changeMarkers[offset] = {};
	}
	if ( this.changeMarkers[offset].created ) {
		// Can't set any other markers on a 'created' element
		return;
	}
	if ( marker === 'created' ) {
		// Clear other markers prior to setting 'created'
		this.changeMarkers[offset] = {};
	}
	if ( this.changeMarkers[offset][marker] === undefined ) {
		this.changeMarkers[offset][marker] = increment;
	} else {
		this.changeMarkers[offset][marker] += increment;
	}
};

/**
 * Clear all change markers.
 */
ve.dm.Transaction.prototype.clearChangeMarkers = function () {
	this.changeMarkers = {};
};
