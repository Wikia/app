/**
 * VisualEditor data model TransactionProcessor class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel transaction processor.
 *
 * This class reads operations from a transaction and applies them one by one. It's not intended
 * to be used directly; use the static functions ve.dm.TransactionProcessor.commit() and .rollback()
 * instead.
 *
 * NOTE: Instances of this class are not recyclable: you can only call .process() on them once.
 *
 * @class
 * @constructor
 */
ve.dm.TransactionProcessor = function VeDmTransactionProcessor( doc, transaction, reversed ) {
	// Properties
	this.document = doc;
	this.transaction = transaction;
	this.operations = transaction.getOperations();
	this.synchronizer = new ve.dm.DocumentSynchronizer( doc );
	this.reversed = reversed;
	// Linear model offset that we're currently at. Operations in the transaction are ordered, so
	// the cursor only ever moves forward.
	this.cursor = 0;
	// Adjustment used to convert between linear model offsets in the original linear model and
	// in the half-updated linear model.
	this.adjustment = 0;
	// Set and clear are sets of annotations which should be added or removed to content being
	// inserted or retained.
	this.set = new ve.AnnotationSet();
	this.clear = new ve.AnnotationSet();
};

/* Static Members */

/**
 * Processing methods.
 *
 * Each method is specific to a type of action. Methods are called in the context of a transaction
 * processor, so they work similar to normal methods on the object.
 *
 * @static
 * @member
 */
ve.dm.TransactionProcessor.processors = {};

/* Static methods */

/**
 * Commit a transaction to a document.
 *
 * @static
 * @method
 * @param {ve.dm.Document} doc Document object to apply the transaction to
 * @param {ve.dm.Transaction} transaction Transaction to apply
 */
ve.dm.TransactionProcessor.commit = function ( doc, transaction ) {
	if ( transaction.hasBeenApplied() ) {
		throw new Error( 'Cannot commit a transaction that has already been committed' );
	}
	new ve.dm.TransactionProcessor( doc, transaction, false ).process();
};

/**
 * Roll back a transaction; this applies the transaction to the document in reverse.
 *
 * @static
 * @method
 * @param {ve.dm.Document} doc Document object to apply the transaction to
 * @param {ve.dm.Transaction} transaction Transaction to apply
 */
ve.dm.TransactionProcessor.rollback = function ( doc, transaction ) {
	if ( !transaction.hasBeenApplied() ) {
		throw new Error( 'Cannot roll back a transaction that has not been committed' );
	}
	new ve.dm.TransactionProcessor( doc, transaction, true ).process();
};

/**
 * Execute a retain operation.
 *
 * This method is called within the context of a document synchronizer instance.
 *
 * This moves the cursor by op.length and applies annotations to the characters that the cursor
 * moved over.
 *
 * @static
 * @method
 * @param {Object} op Operation object:
 * @param {Number} op.length Number of elements to retain
 */
ve.dm.TransactionProcessor.processors.retain = function ( op ) {
	this.applyAnnotations( this.cursor + op.length );
	this.cursor += op.length;
};

/**
 * Execute an annotate operation.
 *
 * This method is called within the context of a document synchronizer instance.
 *
 * This will add an annotation to or remove an annotation from {this.set} or {this.clear}.
 *
 * @static
 * @method
 * @param {Object} op Operation object
 * @param {String} op.method Annotation method, either 'set' to add or 'clear' to remove
 * @param {String} op.bias End point of marker, either 'start' to begin or 'stop' to end
 * @param {String} op.annotation Annotation object to set or clear from content
 * @throws 'Invalid annotation method'
 */
ve.dm.TransactionProcessor.processors.annotate = function ( op ) {
	var target;
	if ( op.method === 'set' ) {
		target = this.reversed ? this.clear : this.set;
	} else if ( op.method === 'clear' ) {
		target = this.reversed ? this.set : this.clear;
	} else {
		throw new Error( 'Invalid annotation method ' + op.method );
	}
	if ( op.bias === 'start' ) {
		target.push( op.annotation );
	} else {
		target.remove( op.annotation );
	}
	// Tree sync is done by applyAnnotations()
};

/**
 * Execute an attribute operation.
 *
 * This method is called within the context of a document synchronizer instance.
 *
 * This sets the attribute named op.key on the element at this.cursor to op.to , or unsets it if
 * op.to === undefined . op.from is not checked against the old value, but is used instead of op.to
 * in reverse mode. So if op.from is incorrect, the transaction will commit fine, but won't roll
 * back correctly.
 *
 * @static
 * @method
 * @param {Object} op Operation object
 * @param {String} op.key: Attribute name
 * @param {Mixed} op.from: Old attribute value, or undefined if not previously set
 * @param {Mixed} op.to: New attribute value, or undefined to unset
 */
ve.dm.TransactionProcessor.processors.attribute = function ( op ) {
	var element = this.document.data[this.cursor],
		to = this.reversed ? op.from : op.to,
		from = this.reversed ? op.to : op.from;
	if ( element.type === undefined ) {
		throw new Error( 'Invalid element error, can not set attributes on non-element data' );
	}
	if ( to === undefined ) {
		// Clear
		if ( element.attributes ) {
			delete element.attributes[op.key];
		}
	} else {
		// Automatically initialize attributes object
		if ( !element.attributes ) {
			element.attributes = {};
		}
		// Set
		element.attributes[op.key] = to;
	}

	this.synchronizer.pushAttributeChange(
		this.document.getNodeFromOffset( this.cursor + 1 ),
		op.key,
		from, to
	);
	this.setChangeMarker( this.cursor, 'attributes' );
};

/**
 * Execute a replace operation.
 *
 * This method is called within the context of a document synchronizer instance.
 *
 * This replaces a range of linear model data with another at this.cursor, figures out how the model
 * tree needs to be synchronized, and queues this in the DocumentSynchronizer.
 *
 * op.remove isn't checked against the actual data (instead op.remove.length things are removed
 * starting at this.cursor), but it's used instead of op.insert in reverse mode. So if
 * op.remove is incorrect but of the right length, the transaction will commit fine, but won't roll
 * back correctly.
 *
 * @static
 * @method
 * @param {Object} op Operation object
 * @param {Array} op.remove Linear model data to remove
 * @param {Array} op.insert Linear model data to insert
 */
ve.dm.TransactionProcessor.processors.replace = function ( op ) {
	var node, selection, range, parentOffset,
		remove = this.reversed ? op.insert : op.remove,
		insert = this.reversed ? op.remove : op.insert,
		removeIsContent = ve.dm.Document.isContentData( remove ),
		insertIsContent = ve.dm.Document.isContentData( insert ),
		removeHasStructure = ve.dm.Document.containsElementData( remove ),
		insertHasStructure = ve.dm.Document.containsElementData( insert ),
		operation = op,
		removeLevel = 0,
		insertLevel = 0,
		i,
		type,
		prevCursor,
		affectedRanges = [],
		scope,
		minInsertLevel = 0,
		coveringRange,
		scopeStart,
		scopeEnd,
		opAdjustment = 0,
		opRemove,
		opInsert;
	if ( removeIsContent && insertIsContent ) {
		// Content replacement
		// Update the linear model
		this.document.spliceData( this.cursor, remove.length, insert );
		this.applyAnnotations( this.cursor + insert.length );
		// Get the node containing the replaced content
		selection = this.document.selectNodes(
			new ve.Range(
				this.cursor - this.adjustment,
				this.cursor - this.adjustment + remove.length
			),
			'leaves'
		);
		node = selection[0].node;
		if (
			!removeHasStructure && !insertHasStructure &&
			selection.length === 1 &&
			node && node.getType() === 'text'
		) {
			// Text-only replacement
			// Queue a resize for the text node
			this.synchronizer.pushResize( node, insert.length - remove.length );
		} else {
			// Replacement is not exclusively text
			// Rebuild all covered nodes
			range = new ve.Range(
				selection[0].nodeRange.start,
				selection[selection.length - 1].nodeRange.end
			);
			this.synchronizer.pushRebuild( range,
				new ve.Range( range.start + this.adjustment,
					range.end + this.adjustment + insert.length - remove.length )
			);
		}
		// Set change markers on the parents of the affected nodes
		for ( i = 0; i < selection.length; i++ ) {
			this.setChangeMarker(
				selection[i].parentOuterRange.start + this.adjustment,
				'content'
			);
		}
		// Advance the cursor
		this.cursor += insert.length;
		this.adjustment += insert.length - remove.length;
	} else {
		// Structural replacement
		// It's possible that multiple replace operations are needed before the
		// model is back in a consistent state. This loop applies the current
		// replace operation to the linear model, then keeps applying subsequent
		// operations until the model is consistent. We keep track of the changes
		// and queue a single rebuild after the loop finishes.
		while ( true ) {
			if ( operation.type === 'replace' ) {
				opRemove = this.reversed ? operation.insert : operation.remove;
				opInsert = this.reversed ? operation.remove : operation.insert;
				// Update the linear model for this insert
				this.document.spliceData( this.cursor, opRemove.length, opInsert );
				affectedRanges.push( new ve.Range(
					this.cursor - this.adjustment,
					this.cursor - this.adjustment + opRemove.length
				) );
				prevCursor = this.cursor;
				this.cursor += opInsert.length;
				// Paint the removed selection, figure out which nodes were
				// covered, and add their ranges to the affected ranges list
				if ( opRemove.length > 0 ) {
					selection = this.document.selectNodes( new ve.Range(
						prevCursor - this.adjustment,
						prevCursor + opRemove.length - this.adjustment
					), 'siblings' );
					for ( i = 0; i < selection.length; i++ ) {
						affectedRanges.push( selection[i].nodeOuterRange );
						if (
							selection[i].nodeOuterRange.start < prevCursor - this.adjustment &&
							selection[i].node.canContainContent()
						) {
							// The opening element survives, so this
							// node will have some of its content
							// removed and/or have another node merged
							// into it. Mark the node.
							// TODO detect special case where closing is replaced
							parentOffset = selection[i].nodeOuterRange.start + this.adjustment;
							this.setChangeMarker( parentOffset, 'content' );
						}
					}
				}
				// Walk through the remove and insert data
				// and keep track of the element depth change (level)
				// for each of these two separately. The model is
				// only consistent if both levels are zero.
				for ( i = 0; i < opRemove.length; i++ ) {
					type = opRemove[i].type;
					if ( type !== undefined ) {
						if ( type.charAt( 0 ) === '/' ) {
							// Closing element
							removeLevel--;
						} else {
							// Opening element
							removeLevel++;
						}
					}
				}
				// Keep track of the scope of the insertion
				// Normally this is the node we're inserting into, except if the
				// insertion closes elements it doesn't open (i.e. splits elements),
				// in which case it's the affected ancestor
				for ( i = 0; i < opInsert.length; i++ ) {
					type = opInsert[i].type;
					if ( type !== undefined ) {
						if ( type.charAt( 0 ) === '/' ) {
							// Closing element
							insertLevel--;
							if ( insertLevel < minInsertLevel ) {
								// Closing an unopened element at a higher
								// (more negative) level than before
								// Lazy-initialize scope
								scope = scope || this.document.getNodeFromOffset( prevCursor );
								// Push the full range of the old scope as an affected range
								scopeStart = this.document.getDocumentNode().getOffsetFromNode( scope );
								scopeEnd = scopeStart + scope.getOuterLength();
								affectedRanges.push( new ve.Range( scopeStart, scopeEnd ) );
								// Update scope
								scope = scope.getParent() || scope;
								// Set change marker
								this.transaction.setChangeMarker(
									scopeStart + this.adjustment,
									'rebuilt'
								);
							}

						} else {
							// Opening element
							insertLevel++;
							// Mark as 'created'
							this.setChangeMarker( prevCursor + i, 'created' );
						}
					}
				}
				// Update adjustment
				this.adjustment += opInsert.length - opRemove.length;
				opAdjustment += opInsert.length - opRemove.length;
			} else {
				// We know that other operations won't cause adjustments, so we
				// don't have to update adjustment
				this.executeOperation( operation );
			}
			if ( removeLevel === 0 && insertLevel === 0 ) {
				// The model is back in a consistent state, so we're done
				break;
			}
			// Get the next operation
			operation = this.nextOperation();
			if ( !operation ) {
				throw new Error( 'Unbalanced set of replace operations found' );
			}
		}
		// From all the affected ranges we have gathered, compute a range that covers all
		// of them, and rebuild that
		coveringRange = ve.Range.newCoveringRange( affectedRanges );
		this.synchronizer.pushRebuild(
			coveringRange,
			new ve.Range(
				coveringRange.start + this.adjustment - opAdjustment,
				coveringRange.end + this.adjustment
			)
		);
	}
};

/* Methods */

/**
 * Gets the next operation.
 *
 * @method
 */
ve.dm.TransactionProcessor.prototype.nextOperation = function () {
	return this.operations[this.operationIndex++] || false;
};

/**
 * Executes an operation.
 *
 * @method
 * @param {Object} op Operation object to execute
 * @throws 'Invalid operation error. Operation type is not supported'
 */
ve.dm.TransactionProcessor.prototype.executeOperation = function ( op ) {
	if ( op.type in ve.dm.TransactionProcessor.processors ) {
		ve.dm.TransactionProcessor.processors[op.type].call( this, op );
	} else {
		throw new Error( 'Invalid operation error. Operation type is not supported: ' + op.type );
	}
};

/**
 * Processes all operations.
 *
 * When all operations are done being processed, the document will be synchronized.
 *
 * @method
 */
ve.dm.TransactionProcessor.prototype.process = function () {
	var op;
	if ( this.reversed ) {
		// Undo change markers before rolling back the transaction, because the offsets
		// are relevant to the post-commit state
		this.applyChangeMarkers();
		// Unset the change markers we've just undone
		this.transaction.clearChangeMarkers();
	}

	// This loop is factored this way to allow operations to be skipped over or executed
	// from within other operations
	this.operationIndex = 0;
	while ( ( op = this.nextOperation() ) ) {
		this.executeOperation( op );
	}
	this.synchronizer.synchronize();

	if ( !this.reversed ) {
		// Apply the change markers we've accumulated while processing the transaction
		this.applyChangeMarkers();
	}
	// Mark the transaction as committed or rolled back, as appropriate
	this.transaction.toggleApplied();
};

/**
 * Apply the current annotation stacks. This will set all annotations in this.set and clear all
 * annotations in this.clear on the data between the offsets this.cursor and this.cursor + to
 *
 * @method
 * @param {Number} to Offset to stop annotating at. Annotating starts at this.cursor
 * @throws 'Invalid transaction, can not annotate a branch element'
 * @throws 'Invalid transaction, annotation to be set is already set'
 * @throws 'Invalid transaction, annotation to be cleared is not set'
 */
ve.dm.TransactionProcessor.prototype.applyAnnotations = function ( to ) {
	var item, element, annotated, annotations, i, range, selection, offset;
	if ( this.set.isEmpty() && this.clear.isEmpty() ) {
		return;
	}
	for ( i = this.cursor; i < to; i++ ) {
		item = this.document.data[i];
		element = item.type !== undefined;
		if ( element ) {
			if ( item.type.charAt( 0 ) === '/' ) {
				throw new Error( 'Invalid transaction, cannot annotate a branch closing element' );
			} else if ( ve.dm.nodeFactory.canNodeHaveChildren( item.type ) ) {
				throw new Error( 'Invalid transaction, cannot annotate a branch opening element' );
			}
		}
		annotated = element ? 'annotations' in item : ve.isArray( item );
		annotations = annotated ? ( element ? item.annotations : item[1] ) :
			new ve.AnnotationSet();
		// Set and clear annotations
		if ( annotations.containsAnyOf( this.set ) ) {
			throw new Error( 'Invalid transaction, annotation to be set is already set' );
		} else {
			annotations.addSet( this.set );
		}
		if ( !annotations.containsAllOf( this.clear ) ) {
			throw new Error( 'Invalid transaction, annotation to be cleared is not set' );
		} else {
			annotations.removeSet( this.clear );
		}
		// Auto initialize/cleanup
		if ( !annotations.isEmpty() && !annotated ) {
			if ( element ) {
				// Initialize new element annotation
				item.annotations = new ve.AnnotationSet( annotations );
			} else {
				// Initialize new character annotation
				this.document.data[i] = [item, new ve.AnnotationSet( annotations )];
			}
		} else if ( annotations.isEmpty() && annotated ) {
			if ( element ) {
				// Cleanup empty element annotation
				delete item.annotations;
			} else {
				// Cleanup empty character annotation
				this.document.data[i] = item[0];
			}
		}
	}
	if ( this.cursor < to ) {
		range = new ve.Range( this.cursor, to );
		selection = this.document.selectNodes(
			new ve.Range(
				this.cursor - this.adjustment,
				to - this.adjustment
			),
			'leaves'
		);
		for ( i = 0; i < selection.length; i++ ) {
			offset = selection[i].node.isWrapped() ?
				selection[i].nodeOuterRange.start :
				selection[i].parentOuterRange.start;
			this.setChangeMarker( offset + this.adjustment, 'annotations' );
		}
		this.synchronizer.pushAnnotation( new ve.Range( this.cursor, to ) );
	}
};

/**
 * Set a change marker on our transaction, if we are in commit mode. This function is a no-op in
 * rollback mode.
 * @see {ve.dm.Transaction.setChangeMarker}
 */
ve.dm.TransactionProcessor.prototype.setChangeMarker = function ( offset, type, increment ) {
	// Refuse to set any new change markers while reversing transactions
	if ( !this.reversed ) {
		this.transaction.setChangeMarker( offset, type, increment );
	}
}

/**
 * Apply the change markers on this.transaction to this.document . Change markers are set
 * (incremented) in commit mode, and unset (decremented) in rollback mode.
 */
ve.dm.TransactionProcessor.prototype.applyChangeMarkers = function () {
	var offset, type, previousValue, newValue, element,
		markers = this.transaction.getChangeMarkers(),
		m = this.reversed ? -1 : 1;
	for ( offset in markers ) {
		for ( type in markers[offset] ) {
			offset = Number( offset );
			element = this.document.data[offset];
			previousValue = ve.getProp( element, 'internal', 'changed', type );
			newValue = ( previousValue || 0 ) + m*markers[offset][type];
			if ( newValue != 0 ) {
				ve.setProp( element, 'internal', 'changed', type, newValue );
			} else if ( previousValue !== undefined ) {
				// Value was set but becomes zero, delete the key
				delete element.internal.changed[type];
				// If that made .changed empty, delete it
				if ( ve.isEmptyObject( element.internal.changed ) ) {
					delete element.internal.changed;
				}
				// If that made .internal empty, delete it
				if ( ve.isEmptyObject( element.internal ) ) {
					delete element.internal;
				}
			}
		}
	}
};
