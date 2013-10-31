/*!
 * VisualEditor DataModel Transaction class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
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
};

/* Static Methods */

/**
 * Generate a transaction that inserts data at an offset.
 *
 * @static
 * @method
 * @param {ve.dm.Document} doc Document to create transaction for
 * @param {number} offset Offset to insert at
 * @param {Array} data Data to insert
 * @returns {ve.dm.Transaction} Transaction that inserts data
 */
ve.dm.Transaction.newFromInsertion = function ( doc, offset, data ) {
	var insertion, tx = new ve.dm.Transaction();
	// Fix up the insertion
	insertion = doc.fixupInsertion( data, offset );
	// Retain up to insertion point, if needed
	tx.pushRetain( insertion.offset );
	// Insert data
	tx.pushReplace( doc, insertion.offset, insertion.remove, insertion.data );
	// Retain to end of document, if needed (for completeness)
	tx.pushFinalRetain( doc, insertion.offset + insertion.remove );
	return tx;
};

/**
 * Generate a transaction that removes data from a range.
 *
 * There are three possible results from a removal:
 *
 * - Remove content only
 *    - Occurs when the range starts and ends on elements of different type, depth or ancestry
 * - Remove entire elements and their content
 *    - Occurs when the range spans across an entire element
 * - Merge two elements by removing the end of one and the beginning of another
 *    - Occurs when the range starts and ends on elements of similar type, depth and ancestry
 *
 * This function uses the following logic to decide what to actually remove:
 *
 * 1. Elements are only removed if range being removed covers the entire element
 * 2. Elements can only be merged if {@link ve.dm.Node#canBeMergedWith} returns true
 * 3. Merges take place at the highest common ancestor
 *
 * @method
 * @param {ve.dm.Document} doc Document to create transaction for
 * @param {ve.Range} range Range of data to remove
 * @returns {ve.dm.Transaction} Transaction that removes data
 * @throws {Error} Invalid range
 */
ve.dm.Transaction.newFromRemoval = function ( doc, range ) {
	var i, selection, first, last, nodeStart, nodeEnd,
		offset = 0,
		removeStart = null,
		removeEnd = null,
		tx = new ve.dm.Transaction();
	// Validate range
	if ( range.isCollapsed() ) {
		// Empty range, nothing to remove, retain up to the end of the document (for completeness)
		tx.pushFinalRetain( doc, 0 );
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
		tx.addSafeRemoveOps( doc, removeStart, removeEnd );
		tx.pushFinalRetain( doc, removeEnd );
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
			tx.addSafeRemoveOps( doc, removeStart, removeEnd );
			offset = removeEnd;

			// Now start this removal
			removeStart = nodeStart;
			removeEnd = nodeEnd;
		}
	}
	// Apply the last removal, if any
	if ( removeEnd !== null ) {
		tx.pushRetain( removeStart - offset );
		tx.addSafeRemoveOps( doc, removeStart, removeEnd );
		offset = removeEnd;
	}
	// Retain up to the end of the document
	tx.pushFinalRetain( doc, offset );
	return tx;
};

/**
 * Build a transaction that replaces the contents of a node with the contents of a document.
 *
 * This is typically used to merge changes to a document slice back into the main document. If newDoc
 * is a document slice of doc, it's assumed that there were no changes to doc's internal list since
 * the slice, so any differences between internal items that doc and newDoc have in common will
 * be resolved in newDoc's favor.
 *
 * @param {ve.dm.Document} doc Main document
 * @param {ve.Range|ve.dm.Node} removeNodeOrRange Node or range to remove
 * @param {ve.dm.Document} newDoc Document to insert
 * @returns {ve.dm.Transaction} Transaction that replaces the node and updates the internal list
 * @throws {Error} removeNodeOrRange must be a ve.dm.Node or a ve.Range
 */
ve.dm.Transaction.newFromDocumentReplace = function ( doc, removeNodeOrRange, newDoc ) {
	var i, len, range, merge, data, metadata, listData, listMetadata, oldEndOffset, newEndOffset,
		listNode = doc.internalList.getListNode(),
		listNodeRange = listNode.getRange(),
		newListNode = newDoc.internalList.getListNode(),
		newListNodeRange = newListNode.getRange(),
		newListNodeOuterRange = newListNode.getOuterRange(),
		tx = new ve.dm.Transaction();

	if ( removeNodeOrRange instanceof ve.dm.Node ) {
		range = removeNodeOrRange.getRange();
	} else if ( removeNodeOrRange instanceof ve.Range ) {
		range = removeNodeOrRange;
	} else {
		throw new Error( 'removeNodeOrRange must be a ve.dm.Node or a ve.Range' );
	}

	// Get the data and the metadata, but skip over the internal list
	data = new ve.dm.ElementLinearData( doc.getStore(),
		newDoc.getData( new ve.Range( 0, newListNodeOuterRange.start ), true ).concat(
			newDoc.getData( new ve.Range( newListNodeOuterRange.end, newDoc.data.getLength() ), true )
		)
	);
	metadata = new ve.dm.MetaLinearData( doc.getStore(),
		newDoc.getMetadata( new ve.Range( 0, newListNodeOuterRange.start ), true ).concat(
			// Merge the metadata immediately before and immediately after the internal list
			ve.copy( ve.dm.MetaLinearData.static.merge( [
				newDoc.metadata.getData( newListNodeOuterRange.start ),
				newDoc.metadata.getData( newListNodeOuterRange.end )
			] ) )
		).concat( newDoc.getMetadata(
			new ve.Range( newListNodeOuterRange.end, newDoc.data.getLength() ), true
		) )
	);
	// Merge the stores
	merge = doc.getStore().merge( newDoc.getStore() );
	// Remap the store indexes in the data
	data.remapStoreIndexes( merge );

	merge = doc.internalList.merge( newDoc.internalList, newDoc.origInternalListLength || 0 );
	// Remap the indexes in the data
	data.remapInteralListIndexes( merge.mapping );
	// Get data for the new internal list
	if ( newDoc.origDoc === doc ) {
		// newDoc is a document slice based on doc, so all the internal list items present in doc
		// when it was cloned are also in newDoc. We need to get the newDoc version of these items
		// so that changes made in newDoc are reflected.
		if ( newDoc.origInternalListLength > 0 ) {
			oldEndOffset = doc.internalList.getItemNode( newDoc.origInternalListLength - 1 ).getOuterRange().end;
			newEndOffset = newDoc.internalList.getItemNode( newDoc.origInternalListLength - 1 ).getOuterRange().end;
		} else {
			oldEndOffset = listNodeRange.start;
			newEndOffset = newListNodeRange.start;
		}
		listData = newDoc.getData( new ve.Range( newListNodeRange.start, newEndOffset ), true )
			.concat( doc.getData( new ve.Range( oldEndOffset, listNodeRange.end ), true ) );
		listMetadata = newDoc.getMetadata( new ve.Range( newListNodeRange.start, newEndOffset ), true )
			.concat( doc.getMetadata( new ve.Range( oldEndOffset, listNodeRange.end ) , true ) );
	} else {
		// newDoc is brand new, so use doc's internal list as a base
		listData = doc.getData( listNodeRange, true );
		listMetadata = doc.getMetadata( listNodeRange, true );
	}
	for ( i = 0, len = merge.newItemRanges.length; i < len; i++ ) {
		listData = listData.concat( newDoc.getData( merge.newItemRanges[i], true ) );
		// We don't have to worry about merging metadata at the edges, because there can't be
		// metadata between internal list items
		listMetadata = listMetadata.concat( newDoc.getMetadata( merge.newItemRanges[i], true ) );
	}

	if ( range.end <= listNodeRange.start ) {
		// range is entirely before listNodeRange
		// First replace the node, then the internal list
		tx.pushRetain( range.start );
		tx.pushReplace( doc, range.start, range.end - range.start, data.data, metadata.data );
		tx.pushRetain( listNodeRange.start - range.end );
		tx.pushReplace( doc, listNodeRange.start, listNodeRange.end - listNodeRange.start,
			listData, listMetadata
		);
		tx.pushRetain( doc.data.getLength() - listNodeRange.end );
	} else if ( listNodeRange.end <= range.start ) {
		// range is entirely after listNodeRange
		// First replace the internal list, then the node
		tx.pushRetain( listNodeRange.start );
		tx.pushReplace( doc, listNodeRange.start, listNodeRange.end - listNodeRange.start,
			listData, listMetadata
		);
		tx.pushRetain( range.start - listNodeRange.end );
		tx.pushReplace( doc, range.start, range.end - range.start, data.data, metadata.data );
		tx.pushRetain( doc.data.getLength() - range.end );
	} else if ( range.start >= listNodeRange.start && range.end <= listNodeRange.end ) {
		// range is entirely within listNodeRange
		// Merge data into listData, then only replace the internal list
		ve.batchSplice( listData, range.start - listNodeRange.start,
			range.end - range.start, data.data );
		ve.batchSplice( listMetadata, range.start - listNodeRange.start,
			range.end - range.start + 1, metadata.data );
		tx.pushRetain( listNodeRange.start );
		tx.pushReplace( doc, listNodeRange.start, listNodeRange.end - listNodeRange.start,
			listData, listMetadata
		);
		tx.pushRetain( doc.data.getLength() - listNodeRange.end );
	}
	return tx;
};

/**
 * Generate a transaction that changes one or more attributes.
 *
 * @static
 * @method
 * @param {ve.dm.Document} doc Document to create transaction for
 * @param {number} offset Offset of element
 * @param {Object.<string,Mixed>} attr List of attribute key and value pairs, use undefined value
 *  to remove an attribute
 * @returns {ve.dm.Transaction} Transaction that changes an element
 * @throws {Error} Cannot set attributes to non-element data
 * @throws {Error} Cannot set attributes on closing element
 */
ve.dm.Transaction.newFromAttributeChanges = function ( doc, offset, attr ) {
	var key,
		tx = new ve.dm.Transaction(),
		data = doc.getData();
	// Verify element exists at offset
	if ( data[offset].type === undefined ) {
		throw new Error( 'Cannot set attributes to non-element data' );
	}
	// Verify element is not a closing
	if ( data[offset].type.charAt( 0 ) === '/' ) {
		throw new Error( 'Cannot set attributes on closing element' );
	}
	// Retain up to element
	tx.pushRetain( offset );
	// Change attribute
	for ( key in attr ) {
		tx.pushReplaceElementAttribute(
			key, 'attributes' in data[offset] ? data[offset].attributes[key] : undefined, attr[key]
		);
	}
	// Retain to end of document
	tx.pushFinalRetain( doc, offset );
	return tx;
};

/**
 * Generate a transaction that annotates content.
 *
 * @static
 * @method
 * @param {ve.dm.Document} doc Document to create transaction for
 * @param {ve.Range} range Range to annotate
 * @param {string} method Annotation mode
 *  - `set`: Adds annotation to all content in range
 *  - `clear`: Removes instances of annotation from content in range
 * @param {ve.dm.Annotation} annotation Annotation to set or clear
 * @returns {ve.dm.Transaction} Transaction that annotates content
 */
ve.dm.Transaction.newFromAnnotation = function ( doc, range, method, annotation ) {
	var covered, type, annotatable,
		tx = new ve.dm.Transaction(),
		data = doc.data,
		i = range.start,
		span = i,
		on = false,
		insideContentNode = false;
	// Iterate over all data in range, annotating where appropriate
	while ( i < range.end ) {
		if ( data.isElementData( i ) ) {
			type = data.getType( i );
			if ( ve.dm.nodeFactory.isNodeContent( type ) ) {
				if ( method === 'set' && !ve.dm.nodeFactory.canNodeTakeAnnotationType( type, annotation ) ) {
					// Blacklisted annotations can't be set
					annotatable = false;
				} else {
					annotatable = true;
				}
			} else {
				// Structural nodes are never annotatable
				annotatable = false;
			}
		} else {
			// Text is always annotatable
			annotatable = true;
		}
		if (
			!annotatable ||
			( insideContentNode && !data.isCloseElementData( i ) )
		) {
			// Structural element opening or closing, or entering a content node
			if ( on ) {
				tx.pushRetain( span );
				tx.pushStopAnnotating( method, annotation );
				span = 0;
				on = false;
			}
		} else if (
			( !data.isElementData( i ) || !data.isCloseElementData( i ) ) &&
			!insideContentNode
		) {
			// Character or content element opening
			if ( data.isElementData( i ) ) {
				insideContentNode = true;
			}
			covered = data.getAnnotationsFromOffset( i ).contains( annotation );
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
		} else if ( data.isCloseElementData( i ) ) {
			// Content closing, skip
			insideContentNode = false;
		}
		span++;
		i++;
	}
	tx.pushRetain( span );
	if ( on ) {
		tx.pushStopAnnotating( method, annotation );
	}
	tx.pushFinalRetain( doc, range.end );
	return tx;
};


/**
 * Generate a transaction that inserts metadata elements.
 *
 * @static
 * @method
 * @param {ve.dm.Document} doc Document to create transaction for
 * @param {number} offset Offset of element
 * @param {number} index Index of metadata cursor within element
 * @param {Array} newElements New elements to insert
 * @returns {ve.dm.Transaction} Transaction that inserts the metadata elements
 */
ve.dm.Transaction.newFromMetadataInsertion = function ( doc, offset, index, newElements ) {
	var tx = new ve.dm.Transaction(),
		data = doc.metadata,
		elements = data.getData( offset ) || [];

	// Retain up to element
	tx.pushRetain( offset );
	// Retain up to metadata element (second dimension)
	tx.pushRetainMetadata( index );
	// Insert metadata elements
	tx.pushReplaceMetadata(
		[], newElements
	);
	// Retain up to end of metadata elements (second dimension)
	tx.pushRetainMetadata( elements.length - index );
	// Retain to end of document
	tx.pushFinalRetain( doc, offset, elements.length );
	return tx;
};


/**
 * Generate a transaction that removes metadata elements.
 *
 * @static
 * @method
 * @param {ve.dm.Document} doc Document to create transaction for
 * @param {number} offset Offset of element
 * @param {ve.Range} range Range of metadata to remove
 * @returns {ve.dm.Transaction} Transaction that removes metadata elements
 * @throws {Error} Cannot remove metadata from empty list
 * @throws {Error} Range out of bounds
 */
ve.dm.Transaction.newFromMetadataRemoval = function ( doc, offset, range ) {
	var selection,
		tx = new ve.dm.Transaction(),
		data = doc.metadata,
		elements = data.getData( offset ) || [];

	if ( !elements.length ) {
		throw new Error( 'Cannot remove metadata from empty list' );
	}

	if ( range.start < 0 || range.end > elements.length ) {
		throw new Error( 'Range out of bounds' );
	}

	selection = elements.slice( range.start, range.end );

	// Retain up to element
	tx.pushRetain( offset );
	// Retain up to metadata element (second dimension)
	tx.pushRetainMetadata( range.start );
	// Remove metadata elements
	tx.pushReplaceMetadata(
		selection, []
	);
	// Retain up to end of metadata elements (second dimension)
	tx.pushRetainMetadata( elements.length - range.end );
	// Retain to end of document (unless we're already off the end )
	tx.pushFinalRetain( doc, offset, elements.length );
	return tx;
};

/**
 * Generate a transaction that replaces a single metadata element.
 *
 * @static
 * @method
 * @param {ve.dm.Document} doc Document to create transaction for
 * @param {number} offset Offset of element
 * @param {number} index Index of metadata cursor within element
 * @param {Object} newElement New element to insert
 * @returns {ve.dm.Transaction} Transaction that replaces a metadata element
 * @throws {Error} Metadata index out of bounds
 */
ve.dm.Transaction.newFromMetadataElementReplacement = function ( doc, offset, index, newElement ) {
	var oldElement,
		tx = new ve.dm.Transaction(),
		data = doc.getMetadata(),
		elements = data[offset] || [];

	if ( index >= elements.length ) {
		throw new Error( 'Metadata index out of bounds' );
	}

	oldElement = elements[index];

	// Retain up to element
	tx.pushRetain( offset );
	// Retain up to metadata element (second dimension)
	tx.pushRetainMetadata( index );
	// Remove metadata elements
	tx.pushReplaceMetadata(
		[ oldElement ], [ newElement ]
	);
	// Retain up to end of metadata elements (second dimension)
	tx.pushRetainMetadata( elements.length - index - 1 );
	// Retain to end of document (unless we're already off the end )
	tx.pushFinalRetain( doc, offset, elements.length );
	return tx;
};

/**
 * Generate a transaction that converts elements that can contain content.
 *
 * @static
 * @method
 * @param {ve.dm.Document} doc Document to create transaction for
 * @param {ve.Range} range Range to convert
 * @param {string} type Symbolic name of element type to convert to
 * @param {Object} attr Attributes to initialize element with
 * @returns {ve.dm.Transaction} Transaction that converts content branches
 */
ve.dm.Transaction.newFromContentBranchConversion = function ( doc, range, type, attr ) {
	var i, selected, branch, branchOuterRange,
		tx = new ve.dm.Transaction(),
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
		branch = selected.node.isContent() ? selected.node.getParent() : selected.node;
		if ( branch.canContainContent() ) {
			// Skip branches that are already of the target type and have identical attributes
			if ( branch.getType() === type && ve.compare( branch.getAttributes(), attr ) ) {
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
			tx.pushReplace( doc, branchOuterRange.start, 1, [ ve.copy( opening ) ] );
			// Retain the contents
			tx.pushRetain( branch.getLength() );
			// Replace the closing
			tx.pushReplace( doc, branchOuterRange.end - 1, 1, [ ve.copy( closing ) ] );
			// Remember this branch and its range for next time
			previousBranch = branch;
			previousBranchOuterRange = branchOuterRange;
		}
	}
	// Retain until the end
	tx.pushFinalRetain( doc, previousBranch ? previousBranchOuterRange.end : 0 );
	return tx;
};

/**
 * Generate a transaction that wraps, unwraps or replaces structure.
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
 * Changing a paragraph to a header:
 *     Before: [ {'type': 'paragraph'}, 'a', 'b', 'c', {'type': '/paragraph'} ]
 *     newFromWrap( new ve.Range( 1, 4 ), [ {'type': 'paragraph'} ], [ {'type': 'heading', 'level': 1 } ] );
 *     After: [ {'type': 'heading', 'level': 1 }, 'a', 'b', 'c', {'type': '/heading'} ]
 *
 * Changing a set of paragraphs to a list:
 *     Before: [ {'type': 'paragraph'}, 'a', {'type': '/paragraph'}, {'type':'paragraph'}, 'b', {'type':'/paragraph'} ]
 *     newFromWrap( new ve.Range( 0, 6 ), [], [ {'type': 'list' } ], [], [ {'type': 'listItem', 'attributes': {'styles': ['bullet']}} ] );
 *     After: [ {'type': 'list'}, {'type': 'listItem', 'attributes': {'styles': ['bullet']}}, {'type':'paragraph'} 'a',
 *              {'type': '/paragraph'}, {'type': '/listItem'}, {'type': 'listItem', 'attributes': {'styles': ['bullet']}},
 *              {'type': 'paragraph'}, 'b', {'type': '/paragraph'}, {'type': '/listItem'}, {'type': '/list'} ]
 *
 * @param {ve.dm.Document} doc Document to generate a transaction for
 * @param {ve.Range} range Range to wrap/unwrap/replace around
 * @param {Array} unwrapOuter Opening elements to unwrap. These must be immediately *outside* the range
 * @param {Array} wrapOuter Opening elements to wrap around the range
 * @param {Array} unwrapEach Opening elements to unwrap from each top-level element in the range
 * @param {Array} wrapEach Opening elements to wrap around each top-level element in the range
 * @returns {ve.dm.Transaction}
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
		// way it appears in the model so we pick up any attributes
		tx.pushReplace( doc, range.start - unwrapOuter.length, unwrapOuter.length, ve.copy( wrapOuter ) );
	}

	if ( wrapEach.length > 0 || unwrapEach.length > 0 ) {
		// Visit each top-level child and wrap/unwrap it
		// TODO figure out if we should use the tree/node functions here
		// rather than iterating over offsets, it may or may not be faster
		for ( i = range.start; i < range.end; i++ ) {
			if ( doc.data.isElementData( i ) ) {
				// This is a structural offset
				if ( !doc.data.isCloseElementData( i ) ) {
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
						tx.pushReplace( doc, i, unwrapEach.length, ve.copy( wrapEach ) );

						// Store this offset for later
						startOffset = i + unwrapEach.length;
					}
					depth++;
				} else {
					// This is a closing element
					depth--;
					if ( depth === 0 ) {
						// We are at the end of a top-level element
						// Advance past the element, then back up past the unwrapEach
						j = ( i + 1 ) - unwrapEach.length;
						// Retain the contents of what we're wrapping
						tx.pushRetain( j - startOffset );
						// Replace the closing elements
						tx.pushReplace( doc, j, unwrapEach.length, ve.copy( closingWrapEach ) );
					}
				}
			}
		}
	} else {
		// There is no wrapEach/unwrapEach to be done, just retain
		// up to the end of the range
		tx.pushRetain( range.end - range.start );
	}

	// this is a no-op if unwrapOuter.length===0 and wrapOuter.length===0
	tx.pushReplace( doc, range.end, unwrapOuter.length, closingArray( wrapOuter ) );

	// Retain up to the end of the document
	tx.pushFinalRetain( doc, range.end + unwrapOuter.length );

	return tx;
};

/**
 * Specification for how each type of operation should be reversed.
 *
 * This object maps operation types to objects, which map property names to reversal instructions.
 * A reversal instruction is either a string (which means the value of that property should be used)
 * or an object (which maps old values to new values). For instance, { 'from': 'to' }
 * means that the .from property of the reversed operation should be set to the .to property of the
 * original operation, and { 'method': { 'set': 'clear' } } means that if the .method property of
 * the original operation was 'set', the reversed operation's .method property should be 'clear'.
 *
 * If a property's treatment isn't specified, its value is simply copied without modification.
 * If an operation type's treatment isn't specified, all properties are copied without modification.
 *
 * @type {Object.<string,Object.<string,string|Object.<string, string>>>}
 */
ve.dm.Transaction.reversers = {
	'annotate': { 'method': { 'set': 'clear', 'clear': 'set' } }, // swap 'set' with 'clear'
	'attribute': { 'from': 'to', 'to': 'from' }, // swap .from with .to
	'replace': { // swap .insert with .remove and .insertMetadata with .removeMetadata
		'insert': 'remove',
		'remove': 'insert',
		'insertMetadata': 'removeMetadata',
		'removeMetadata': 'insertMetadata'
	},
	'replaceMetadata': { 'insert': 'remove', 'remove': 'insert' } // swap .insert with .remove
};

/* Methods */

/**
 * Create a clone of this transaction.
 *
 * The returned transaction will be exactly the same as this one, except that its 'applied' flag
 * will be cleared. This means that if a transaction has already been committed, it will still
 * be possible to commit the clone. This is used for redoing transactions that were undone.
 *
 * @returns {ve.dm.Transaction} Clone of this transaction
 */
ve.dm.Transaction.prototype.clone = function () {
	var tx = new this.constructor();
	tx.operations = ve.copy( this.operations );
	tx.lengthDifference = this.lengthDifference;
	return tx;
};

/**
 * Create a reversed version of this transaction.
 *
 * The returned transaction will be the same as this one but with all operations reversed. This
 * means that applying the original transaction and then applying the reversed transaction will
 * result in no net changes. This is used to undo transactions.
 *
 * @returns {ve.dm.Transaction} Reverse of this transaction
 */
ve.dm.Transaction.prototype.reversed = function () {
	var i, len, op, newOp, reverse, prop, tx = new this.constructor();
	for ( i = 0, len = this.operations.length; i < len; i++ ) {
		op = this.operations[i];
		newOp = ve.copy( op );
		reverse = this.constructor.reversers[op.type] || {};
		for ( prop in reverse ) {
			if ( typeof reverse[prop] === 'string' ) {
				newOp[prop] = op[reverse[prop]];
			} else {
				newOp[prop] = reverse[prop][op[prop]];
			}
		}
		tx.operations.push( newOp );
	}
	tx.lengthDifference = -this.lengthDifference;
	return tx;
};

/**
 * Check if the transaction would make any actual changes if processed.
 *
 * There may be more sophisticated checks that can be done, like looking for things being replaced
 * with identical content, but such transactions probably should not be created in the first place.
 *
 * @method
 * @returns {boolean} Transaction is no-op
 */
ve.dm.Transaction.prototype.isNoOp = function () {
	return (
		this.operations.length === 0 ||
		( this.operations.length === 1 && this.operations[0].type === 'retain' )
	);
};

/**
 * Get all operations.
 *
 * @method
 * @returns {Object[]} List of operations
 */
ve.dm.Transaction.prototype.getOperations = function () {
	return this.operations;
};

/**
 * Check if the transaction has any operations with a certain type.
 *
 * @method
 * @returns {boolean} Has operations of a given type
 */
ve.dm.Transaction.prototype.hasOperationWithType = function ( type ) {
	var i, len;
	for ( i = 0, len = this.operations.length; i < len; i++ ) {
		if ( this.operations[i].type === type ) {
			return true;
		}
	}
	return false;
};

/**
 * Check if the transaction has any content data operations, such as insertion or deletion.
 *
 * @method
 * @returns {boolean} Has content data operations
 */
ve.dm.Transaction.prototype.hasContentDataOperations = function () {
	return this.hasOperationWithType( 'replace' );
};

/**
 * Check if the transaction has any element attribute operations.
 *
 * @method
 * @returns {boolean} Has element attribute operations
 */
ve.dm.Transaction.prototype.hasElementAttributeOperations = function () {
	return this.hasOperationWithType( 'attribute' );
};

/**
 * Check if the transaction has any annotation operations.
 *
 * @method
 * @returns {boolean} Has annotation operations
 */
ve.dm.Transaction.prototype.hasAnnotationOperations = function () {
	return this.hasOperationWithType( 'annotate' );
};

/**
 * Get the difference in content length the transaction will cause if applied.
 *
 * @method
 * @returns {number} Difference in content length
 */
ve.dm.Transaction.prototype.getLengthDifference = function () {
	return this.lengthDifference;
};

/**
 * Check whether the transaction has already been applied.
 *
 * @method
 * @returns {boolean}
 */
ve.dm.Transaction.prototype.hasBeenApplied = function () {
	return this.applied;
};

/**
 * Mark the transaction as having been applied.
 *
 * Should only be called after committing the transaction.
 *
 * @see ve.dm.Transaction#hasBeenApplied
 */
ve.dm.Transaction.prototype.markAsApplied = function () {
	this.applied = true;
};

/**
 * Translate an offset based on a transaction.
 *
 * This is useful when you want to anticipate what an offset will be after a transaction is
 * processed.
 *
 * @method
 * @param {number} offset Offset in the linear model before the transaction has been processed
 * @param {boolean} [excludeInsertion] Map the offset immediately before an insertion to
 *  right before the insertion rather than right after
 * @returns {number} Translated offset, as it will be after processing transaction
 */
ve.dm.Transaction.prototype.translateOffset = function ( offset, excludeInsertion ) {
	var i, op, insertLength, removeLength, prevAdjustment, cursor = 0, adjustment = 0;
	for ( i = 0; i < this.operations.length; i++ ) {
		op = this.operations[i];
		if ( op.type === 'replace' ) {
			insertLength = op.insert.length;
			removeLength = op.remove.length;
			prevAdjustment = adjustment;
			adjustment += insertLength - removeLength;
			if ( offset === cursor + removeLength ) {
				// Offset points to right after the removal or right before the insertion
				if ( excludeInsertion && insertLength > removeLength ) {
					// Translate it to before the insertion
					return offset + adjustment - insertLength + removeLength;
				} else {
					// Translate it to after the removal/insertion
					return offset + adjustment;
				}
			} else if ( offset === cursor ) {
				// The offset points to right before the removal or replacement
				if ( insertLength === 0 ) {
					// Translate it to after the removal
					return cursor + removeLength + adjustment;
				} else {
					// Translate it to before the replacement
					// To translate this correctly, we have to use adjustment as it was before
					// we adjusted it for this replacement
					return cursor + prevAdjustment;
				}
			} else if ( offset > cursor && offset < cursor + removeLength ) {
				// The offset points inside of the removal
				// Translate it to after the removal
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
 * @see #translateOffset
 * @param {ve.Range} range Range in the linear model before the transaction has been processed
 * @returns {ve.Range} Translated range, as it will be after processing transaction
 */
ve.dm.Transaction.prototype.translateRange = function ( range ) {
	var start = this.translateOffset( range.start, true ),
		end = this.translateOffset( range.end, false );
	return range.isBackwards() ? new ve.Range( end, start ) : new ve.Range( start, end );
};

/**
 * Add a final retain operation to finish off a transaction (internal helper).
 *
 * @private
 * @method
 * @param {ve.dm.Document} doc Document to finish off.
 * @param {number} Final offset edited by the transaction up to this point.
 * @param {number} [metaOffset=0] Final metadata offset edited, if nonzero.
 */
ve.dm.Transaction.prototype.pushFinalRetain = function ( doc, offset, metaOffset ) {
	var data = doc.data,
		metadata = doc.metadata,
		finalMetadata = metadata.getData( data.getLength() );
	if ( offset < doc.data.getLength() ) {
		this.pushRetain( doc.data.getLength() - offset );
		metaOffset = 0;
	}
	// if there is trailing metadata, push a final retainMetadata
	if ( finalMetadata !== undefined && finalMetadata.length > 0 ) {
		this.pushRetainMetadata( finalMetadata.length - ( metaOffset || 0 ) );
	}
};

/**
 * Add a retain operation.
 *
 * @method
 * @param {number} length Length of content data to retain
 * @throws {Error} Cannot retain backwards
 */
ve.dm.Transaction.prototype.pushRetain = function ( length ) {
	if ( length < 0 ) {
		throw new Error( 'Invalid retain length, cannot retain backwards:' + length );
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
 * Add a retain metadata operation.
 * // TODO: this is a copy/paste of pushRetain (at the moment). Consider a refactor.
 *
 * @method
 * @param {number} length Length of content data to retain
 * @throws {Error} Cannot retain backwards
 */
ve.dm.Transaction.prototype.pushRetainMetadata = function ( length ) {
	if ( length < 0 ) {
		throw new Error( 'Invalid retain length, cannot retain backwards:' + length );
	}
	if ( length ) {
		var end = this.operations.length - 1;
		if ( this.operations.length && this.operations[end].type === 'retainMetadata' ) {
			this.operations[end].length += length;
		} else {
			this.operations.push( {
				'type': 'retainMetadata',
				'length': length
			} );
		}
	}
};

/**
 * Adds a replace op to remove the desired range and, where required, splices in retain ops
 * to prevent the deletion of internal data.
 *
 * An extra `replaceMetadata` operation might be pushed at the end if the
 * affected region contains metadata; see
 * {@link ve.dm.Transaction#pushReplace} for details.
 *
 * @param {ve.dm.Document} doc Document
 * @param {number} removeStart Offset to start removing from
 * @param {number} removeEnd Offset to remove to
 */
ve.dm.Transaction.prototype.addSafeRemoveOps = function ( doc, removeStart, removeEnd ) {
	var i, retainStart, internalStackDepth = 0;
	// Iterate over removal range and use a stack counter to determine if
	// we are inside an internal node
	for ( i = removeStart; i < removeEnd; i++ ) {
		if ( doc.data.isElementData( i ) && ve.dm.nodeFactory.isNodeInternal( doc.data.getType( i ) ) ) {
			if ( !doc.data.isCloseElementData( i ) ) {
				if ( internalStackDepth === 0 ) {
					this.pushReplace( doc, removeStart, i - removeStart, [] );
					retainStart = i;
				}
				internalStackDepth++;
			} else {
				internalStackDepth--;
				if ( internalStackDepth === 0 ) {
					this.pushRetain( i + 1 - retainStart );
					removeStart = i + 1;
				}
			}
		}
	}
	this.pushReplace( doc, removeStart, removeEnd - removeStart, [] );
};

/**
 * Add a replace operation, keeping metadata in sync if required.
 *
 * Note that metadata attached to removed content is moved so that it
 * attaches just before the inserted content.  If there is
 * metadata attached to the removed content but there is no inserted
 * content, then an extra `replaceMetadata` operation is pushed in order
 * to properly insert the merged metadata before the character immediately
 * after the removed content. (Note that there is an extra metadata element
 * after the final data element; if the removed region is at the very end of
 * the document, the inserted `replaceMetadata` operation targets this
 * final metadata element.)
 *
 * @method
 * @param {ve.dm.Document} doc Document model
 * @param {number} offset Offset to start at
 * @param {number} removeLength Number of data items to remove
 * @param {Array} insert Data to insert
 * @param {Array} [insertMetadata] Overwrite the metadata with this data, rather than collapsing it
 */
ve.dm.Transaction.prototype.pushReplace = function ( doc, offset, removeLength, insert, insertMetadata ) {
	if ( removeLength === 0 && insert.length === 0 ) {
		// Don't push no-ops
		return;
	}

	var op, extraMetadata, end = this.operations.length - 1,
		lastOp = end >= 0 ? this.operations[end] : null,
		penultOp = end >= 1 ? this.operations[ end - 1 ] : null,
		range = new ve.Range( offset, offset + removeLength ),
		remove = doc.getData( range ),
		removeMetadata = doc.getMetadata( range ),
		isRemoveEmpty = ve.compare( removeMetadata, new Array( removeMetadata.length ) ),
		isInsertEmpty = insertMetadata && ve.compare( insertMetadata, new Array( insertMetadata.length ) );

	if ( !insertMetadata && !isRemoveEmpty ) {
		// if we are removing a range which includes metadata, we need to
		// collapse it.  If there's nothing to insert, we also need to add
		// an extra `replaceMetadata` operation later in order to insert the
		// collapsed metadata.
		insertMetadata = ve.dm.MetaLinearData.static.merge( removeMetadata );
		if ( insert.length === 0 ) {
			extraMetadata = insertMetadata[0];
			insertMetadata = [];
		} else {
			// pad out at end so insert metadata is the same length as insert data
			ve.batchSplice( insertMetadata, 1, 0, new Array( insert.length - 1 ) );
		}
	} else if ( isInsertEmpty && isRemoveEmpty ) {
		// No metadata changes, don't pollute the transaction with [undefined, undefined, ...]
		insertMetadata = undefined;
	}

	// simple replaces can be combined
	// (but don't do this if there is metadata to be removed and the previous
	// replace had a non-zero insertion, because that would shift the metadata
	// location.)
	if (
		lastOp && lastOp.type === 'replaceMetadata' &&
		lastOp.insert.length > 0 && lastOp.remove.length === 0 &&
		penultOp && penultOp.type === 'replace' &&
		penultOp.insert.length === 0 /* this is always true */
	) {
		this.operations.pop();
		lastOp = penultOp;
		/* fall through */
	}
	if (
		lastOp && lastOp.type === 'replace' &&
		!( lastOp.insert.length > 0 && insertMetadata !== undefined )
	) {
		lastOp = this.operations.pop();
		this.lengthDifference -= lastOp.insert.length - lastOp.remove.length;
		this.pushReplace(
			doc,
			offset - lastOp.remove.length,
			lastOp.remove.length + removeLength,
			lastOp.insert.concat( insert )
		);
		return;
	}

	if ( lastOp && lastOp.type === 'replaceMetadata' ) {
		// `replace` operates on the metadata at the given offset; the transaction
		// touches the same region twice if `replace` follows a `replaceMetadata`
		// without a `retain` in between.
		throw new Error( 'replace after replaceMetadata not allowed' );
	}

	op = {
		'type': 'replace',
		'remove': remove,
		'insert': insert
	};
	if ( insertMetadata !== undefined ) {
		op.removeMetadata = removeMetadata;
		op.insertMetadata = insertMetadata;
	}
	this.operations.push( op );
	this.lengthDifference += insert.length - remove.length;
	if ( extraMetadata !== undefined ) {
		this.pushReplaceMetadata( [], extraMetadata );
	}
};

/**
 * Add a replace metadata operation
 *
 * @method
 * @param {Array} remove Metadata to remove
 * @param {Array} insert Metadata to replace 'remove' with
 */
ve.dm.Transaction.prototype.pushReplaceMetadata = function ( remove, insert ) {
	if ( remove.length === 0 && insert.length === 0 ) {
		// Don't push no-ops
		return;
	}
	this.operations.push( {
		'type': 'replaceMetadata',
		'remove': remove,
		'insert': insert
	} );
};

/**
 * Add an element attribute change operation.
 *
 * @method
 * @param {string} key Name of attribute to change
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
 * Add a start annotating operation.
 *
 * @method
 * @param {string} method Method to use, either "set" or "clear"
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
 * Add a stop annotating operation.
 *
 * @method
 * @param {string} method Method to use, either "set" or "clear"
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
