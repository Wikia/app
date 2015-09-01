/*!
 * VisualEditor DataModel TransactionProcessor class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * DataModel transaction processor.
 *
 * This class reads operations from a transaction and applies them one by one. It's not intended
 * to be used directly; use {ve.dm.Document#commit} instead.
 *
 * NOTE: Instances of this class are not recyclable: you can only call .process() on them once.
 *
 * @class
 * @param {ve.dm.Document} doc Document
 * @param {ve.dm.Transaction} transaction Transaction
 * @constructor
 */
ve.dm.TransactionProcessor = function VeDmTransactionProcessor( doc, transaction ) {
	// Properties
	this.document = doc;
	this.transaction = transaction;
	this.operations = transaction.getOperations();
	this.modificationQueue = [];
	this.rollbackQueue = [];
	this.synchronizer = new ve.dm.DocumentSynchronizer( doc, transaction );
	// Linear model offset that we're currently at. Operations in the transaction are ordered, so
	// the cursor only ever moves forward.
	this.cursor = 0;
	this.metadataCursor = 0;
	// Adjustment that needs to be added to linear model offsets in the original linear model
	// to get offsets in the half-updated linear model. This is needed when queueing modifications
	// after other modifications that will cause offsets to shift.
	this.adjustment = 0;
	// Set and clear are sets of annotations which should be added or removed to content being
	// inserted or retained.
	this.set = new ve.dm.AnnotationSet( this.document.getStore() );
	this.clear = new ve.dm.AnnotationSet( this.document.getStore() );
};

/* Static members */

/* See ve.dm.TransactionProcessor.modifiers */
ve.dm.TransactionProcessor.modifiers = {};

/* See ve.dm.TransactionProcessor.processors */
ve.dm.TransactionProcessor.processors = {};

/* Methods */

/**
 * Get the next operation.
 *
 * @method
 */
ve.dm.TransactionProcessor.prototype.nextOperation = function () {
	return this.operations[ this.operationIndex++ ] || false;
};

/**
 * Execute an operation.
 *
 * @method
 * @param {Object} op Operation object to execute
 * @throws {Error} Operation type is not supported
 */
ve.dm.TransactionProcessor.prototype.executeOperation = function ( op ) {
	if ( Object.prototype.hasOwnProperty.call( ve.dm.TransactionProcessor.processors, op.type ) ) {
		ve.dm.TransactionProcessor.processors[ op.type ].call( this, op );
	} else {
		throw new Error( 'Invalid operation error. Operation type is not supported: ' + op.type );
	}
};

/**
 * Process all operations.
 *
 * When all operations are done being processed, the document will be synchronized.
 *
 * @method
 * @param {Function} [presynchronizeHandler] Callback to emit before synchronizing
 */
ve.dm.TransactionProcessor.prototype.process = function ( presynchronizeHandler ) {
	var op;

	// First process each operation to gather modifications in the modification queue.
	// If an exception occurs during this stage, we don't need to do anything to recover,
	// because no modifications were made yet.
	this.operationIndex = 0;
	// This loop is factored this way to allow operations to be skipped over or executed
	// from within other operations
	while ( ( op = this.nextOperation() ) ) {
		this.executeOperation( op );
	}

	// Apply the queued modifications
	try {
		this.applyModifications();
	} catch ( e ) {
		// Restore the linear model to its original state
		this.rollbackModifications();
		// Rethrow the exception
		throw e;
	}
	// Mark the transaction as committed
	this.transaction.markAsApplied();

	// Synchronize the node tree for the modifications we just made
	try {
		if ( presynchronizeHandler ) {
			presynchronizeHandler();
		}
		this.synchronizer.synchronize( this.transaction );
	} catch ( e ) {
		// Restore the linear model to its original state
		this.rollbackModifications();
		// The synchronizer may have left the tree in some sort of weird half-baked state,
		// so rebuild it from scratch
		this.document.rebuildTree();
		// Rethrow the exception
		throw e;
	}

};

/**
 * Queue a modification.
 *
 * For available method names, see ve.dm.ElementLinearData and ve.dm.MetaLinearData.
 *
 * @param {Object} modification Object describing the modification
 * @param {string} modification.type Name of a method in ve.dm.TransactionProcessor.modifiers
 * @param {Array} [modification.args] Arguments to pass to this method
 * @throws {Error} Unrecognized modification type
 */
ve.dm.TransactionProcessor.prototype.queueModification = function ( modification ) {
	if ( typeof ve.dm.TransactionProcessor.modifiers[ modification.type ] !== 'function' ) {
		throw new Error( 'Unrecognized modification type ' + modification.type );
	}
	this.modificationQueue.push( modification );
};

/**
 * Apply all modifications queued through #queueModification, and add their rollback functions
 * to this.rollbackQueue.
 */
ve.dm.TransactionProcessor.prototype.applyModifications = function () {
	var i, len, modifier, modifications = this.modificationQueue;
	this.modificationQueue = [];
	for ( i = 0, len = modifications.length; i < len; i++ ) {
		modifier = ve.dm.TransactionProcessor.modifiers[ modifications[ i ].type ];
		// Add to the beginning of rollbackQueue, because the most recent change needs to
		// be undone first
		this.rollbackQueue.unshift( modifier.apply( this, modifications[ i ].args || [] ) );
	}
};

/**
 * Roll back all modifications that have been applied so far. This invokes the callbacks returned
 * by the modifier functions.
 */
ve.dm.TransactionProcessor.prototype.rollbackModifications = function () {
	var i, len, rollbacks = this.rollbackQueue;
	this.rollbackQueue = [];
	for ( i = 0, len = rollbacks.length; i < len; i++ ) {
		rollbacks[ i ]();
	}
};

/**
 * Advance the main data cursor.
 *
 * @method
 * @param {number} increment Number of positions to increment the cursor by
 */
ve.dm.TransactionProcessor.prototype.advanceCursor = function ( increment ) {
	this.cursor += increment;
	this.metadataCursor = 0;
};

/**
 * Apply the current annotation stacks.
 *
 * This will set all annotations in this.set and clear all annotations in `this.clear` on the data
 * between the offsets `this.cursor` and `this.cursor + to`.
 *
 * @method
 * @param {number} to Offset to stop annotating at, annotating starts at this.cursor
 * @throws {Error} Cannot annotate a branch element
 * @throws {Error} Annotation to be set is already set
 * @throws {Error} Annotation to be cleared is not set
 */
ve.dm.TransactionProcessor.prototype.applyAnnotations = function ( to ) {
	var isElement, annotations, i, j, jlen;

	function setAndClear( anns, set, clear ) {
		if ( anns.containsAnyOf( set ) ) {
			throw new Error( 'Invalid transaction, annotation to be set is already set' );
		} else {
			anns.addSet( set );
		}
		if ( !anns.containsAllOf( clear ) ) {
			throw new Error( 'Invalid transaction, annotation to be cleared is not set' );
		} else {
			anns.removeSet( clear );
		}
	}

	if ( this.set.isEmpty() && this.clear.isEmpty() ) {
		return;
	}
	// Set/clear annotations on data
	for ( i = this.cursor; i < to; i++ ) {
		isElement = this.document.data.isElementData( i );
		if ( isElement ) {
			if ( !ve.dm.nodeFactory.isNodeContent( this.document.data.getType( i ) ) ) {
				throw new Error( 'Invalid transaction, cannot annotate a non-content element' );
			}
			if ( this.document.data.isCloseElementData( i ) ) {
				// Closing content element, ignore
				continue;
			}
		}
		annotations = this.document.data.getAnnotationsFromOffset( i );
		setAndClear( annotations, this.set, this.clear );
		// Store annotation indexes in linear model
		this.queueModification( {
			type: 'annotateData',
			args: [ i + this.adjustment, annotations ]
		} );
	}
	// Set/clear annotations on metadata, but not on the edges of the range
	for ( i = this.cursor + 1; i < to; i++ ) {
		for ( j = 0, jlen = this.document.metadata.getDataLength( i ); j < jlen; j++ ) {
			annotations = this.document.metadata.getAnnotationsFromOffsetAndIndex( i, j );
			setAndClear( annotations, this.set, this.clear );
			this.queueModification( {
				type: 'annotateMetadata',
				args: [ i + this.adjustment, j, annotations ]
			} );
		}
	}
	// Notify the synchronizer
	if ( this.cursor < to ) {
		this.synchronizer.pushAnnotation( new ve.Range( this.cursor + this.adjustment, to + this.adjustment ) );
	}
};

/**
 * Modifier methods.
 *
 * Each method executes a specific type of linear model modification and returns a function that
 * undoes the modification, in case we need to recover the previous linear model state.
 * Methods are called in the context of a transaction processor, so they work similar to normal
 * methods on the object.
 *
 * @class ve.dm.TransactionProcessor.modifiers
 * @singleton
 */

/**
 * Splice data into / out of the data or metadata array.
 *
 * @param {string} type 'data' or 'metadata'
 * @param {number} offset Offset to remove/insert at
 * @param {number} remove Number of elements to remove
 * @param {Array} [insert] Elements to insert
 * @return {Function} Function that undoes the modification
 */
ve.dm.TransactionProcessor.modifiers.splice = function ( type, offset, remove, insert ) {
	var removed, data;
	insert = insert || [];
	data = type === 'metadata' ? this.document.metadata : this.document.data;
	removed = data.batchSplice( offset, remove, insert );
	return function () {
		data.batchSplice( offset, insert.length, removed );
	};
};

/**
 * Splice metadata into / out of the metadata array at a given offset.
 *
 * @param {number} offset Offset whose metadata array to modify
 * @param {number} index Index in that offset's metadata array to remove/insert at
 * @param {number} remove Number of elements to remove
 * @param {Array} [insert] Elements to insert
 * @return {Function} Function that undoes the modification
 */
ve.dm.TransactionProcessor.modifiers.spliceMetadataAtOffset = function ( offset, index, remove, insert ) {
	var removed, metadata;
	insert = insert || [];
	metadata = this.document.metadata;
	removed = metadata.spliceMetadataAtOffset( offset, index, remove, insert );
	return function () {
		metadata.spliceMetadataAtOffset( offset, index, insert.length, removed );
	};
};

/**
 * Set annotations at a given data offset.
 *
 * @param {number} offset Offset in data array
 * @param {ve.dm.AnnotationSet} annotations New set of annotations; overwrites old set
 * @return {Function} Function that undoes the modification
 */
ve.dm.TransactionProcessor.modifiers.annotateData = function ( offset, annotations ) {
	var data = this.document.data,
		oldAnnotations = data.getAnnotationsFromOffset( offset );
	data.setAnnotationsAtOffset( offset, annotations );
	return function () {
		data.setAnnotationsAtOffset( offset, oldAnnotations );
	};
};

/**
 * Set annotations at a given metadata offset and index.
 *
 * @param {number} offset Offset to annotate at
 * @param {number} index Index in that offset's metadata array
 * @param {ve.dm.AnnotationSet} annotations New set of annotations; overwrites old set
 * @return {Function} Function that undoes the modification
 */
ve.dm.TransactionProcessor.modifiers.annotateMetadata = function ( offset, index, annotations ) {
	var metadata = this.document.metadata,
		oldAnnotations = metadata.getAnnotationsFromOffsetAndIndex( offset, index );
	metadata.setAnnotationsAtOffsetAndIndex( offset, index, annotations );
	return function () {
		metadata.setAnnotationsAtOffsetAndIndex( offset, index, oldAnnotations );
	};
};

/**
 * Set an attribute at a given offset.
 *
 * @param {number} offset Offset in data array
 * @param {string} key Attribute name
 * @param {Mixed} value New attribute value
 * @return {Function} Function that undoes the modification
 */
ve.dm.TransactionProcessor.modifiers.setAttribute = function ( offset, key, value ) {
	var data = this.document.data,
		item = data.getData( offset ),
		oldValue = item.attributes && item.attributes[ key ];
	data.setAttributeAtOffset( offset, key, value );
	return function () {
		data.setAttributeAtOffset( offset, key, oldValue );
	};
};

/**
 * Processing methods.
 *
 * Each method is specific to a type of action. Methods are called in the context of a transaction
 * processor, so they work similar to normal methods on the object.
 *
 * @class ve.dm.TransactionProcessor.processors
 * @singleton
 */

/**
 * Execute a retain operation.
 *
 * This method is called within the context of a transaction processor instance.
 *
 * This moves the cursor by op.length and applies annotations to the characters that the cursor
 * moved over.
 *
 * @method
 * @param {Object} op Operation object:
 * @param {number} op.length Number of elements to retain
 */
ve.dm.TransactionProcessor.processors.retain = function ( op ) {
	this.applyAnnotations( this.cursor + op.length );
	this.advanceCursor( op.length );
};

/**
 * Execute a metadata retain operation.
 *
 * This method is called within the context of a transaction processor instance.
 *
 * This moves the metadata cursor by op.length.
 *
 * @method
 * @param {Object} op Operation object:
 * @param {number} op.length Number of elements to retain
 */
ve.dm.TransactionProcessor.processors.retainMetadata = function ( op ) {
	this.metadataCursor += op.length;
};

/**
 * Execute an annotate operation.
 *
 * This method is called within the context of a transaction processor instance.
 *
 * This will add an annotation to or remove an annotation from `this.set` or `this.clear`.
 *
 * @method
 * @param {Object} op Operation object
 * @param {string} op.method Annotation method, either 'set' to add or 'clear' to remove
 * @param {string} op.bias End point of marker, either 'start' to begin or 'stop' to end
 * @param {string} op.annotation Annotation object to set or clear from content
 * @throws {Error} Invalid annotation method
 */
ve.dm.TransactionProcessor.processors.annotate = function ( op ) {
	var target, annotation;
	if ( op.method === 'set' ) {
		target = this.set;
	} else if ( op.method === 'clear' ) {
		target = this.clear;
	} else {
		throw new Error( 'Invalid annotation method ' + op.method );
	}
	annotation = this.document.getStore().value( op.index );
	if ( op.bias === 'start' ) {
		target.push( annotation );
	} else {
		target.remove( annotation );
	}
	// Tree sync is done by applyAnnotations()
};

/**
 * Execute an attribute operation.
 *
 * This method is called within the context of a transaction processor instance.
 *
 * This sets the attribute named `op.key` on the element at `this.cursor` to `op.to`, or unsets it if
 * `op.to === undefined`. `op.from `is not checked against the old value, but is used instead of `op.to`
 * in reverse mode. So if `op.from` is incorrect, the transaction will commit fine, but won't roll
 * back correctly.
 *
 * @method
 * @param {Object} op Operation object
 * @param {string} op.key Attribute name
 * @param {Mixed} op.from Old attribute value, or undefined if not previously set
 * @param {Mixed} op.to New attribute value, or undefined to unset
 */
ve.dm.TransactionProcessor.processors.attribute = function ( op ) {
	if ( !this.document.data.isElementData( this.cursor ) ) {
		throw new Error( 'Invalid element error, cannot set attributes on non-element data' );
	}
	this.queueModification( {
		type: 'setAttribute',
		args: [ this.cursor + this.adjustment, op.key, op.to ]
	} );

	this.synchronizer.pushAttributeChange(
		this.document.getDocumentNode().getNodeFromOffset( this.cursor + 1 ),
		op.key,
		op.from,
		op.to
	);
};

/**
 * Execute a replace operation.
 *
 * This method is called within the context of a transaction processor instance.
 *
 * This replaces a range of linear model data with another at this.cursor, figures out how the model
 * tree needs to be synchronized, and queues this in the DocumentSynchronizer.
 *
 * op.remove isn't checked against the actual data (instead op.remove.length things are removed
 * starting at this.cursor), but it's used instead of op.insert in reverse mode. So if
 * op.remove is incorrect but of the right length, the transaction will commit fine, but won't roll
 * back correctly.
 *
 * @method
 * @param {Object} op Operation object
 * @param {Array} op.remove Linear model data to remove
 * @param {Array} op.insert Linear model data to insert
 */
ve.dm.TransactionProcessor.processors.replace = function ( op ) {
	var node, selection, range,
		remove = op.remove,
		insert = op.insert,
		removeMetadata = op.removeMetadata,
		insertMetadata = op.insertMetadata,
		removeLinearData = new ve.dm.ElementLinearData( this.document.getStore(), remove ),
		insertLinearData = new ve.dm.ElementLinearData( this.document.getStore(), insert ),
		removeIsContent = removeLinearData.isContentData(),
		insertIsContent = insertLinearData.isContentData(),
		removeHasStructure = removeLinearData.containsElementData(),
		insertHasStructure = insertLinearData.containsElementData(),
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
		opRemove, opInsert, opRemoveMetadata, opInsertMetadata;
	if ( removeIsContent && insertIsContent ) {
		// Content replacement
		// Update the linear model
		this.queueModification( {
			type: 'splice',
			args: [ 'data', this.cursor + this.adjustment, remove.length, insert ]
		} );
		// Keep the meta linear model in sync
		if ( removeMetadata !== undefined ) {
			this.queueModification( {
				type: 'splice',
				args: [
					'metadata',
					this.cursor + this.adjustment,
					removeMetadata.length,
					insertMetadata
				]
			} );
		} else {
			this.queueModification( {
				type: 'splice',
				args: [
					'metadata',
					this.cursor + this.adjustment,
					remove.length, new Array( insert.length )
				]
			} );
		}
		// Get the node containing the replaced content
		selection = this.document.selectNodes(
			new ve.Range(
				this.cursor,
				this.cursor + remove.length
			),
			'leaves'
		);
		node = selection[ 0 ].node;
		if (
			!removeHasStructure && !insertHasStructure &&
			selection.length === 1 &&
			node && node.getType() === 'text'
		) {
			// Text-only replacement
			// Queue a resize for the text node
			this.synchronizer.pushResize( node, insert.length - remove.length );
		} else if (
			!removeHasStructure && !insertHasStructure && remove.length === 0 && insert.length > 0 &&
			selection.length === 1 && node && node.canContainContent() &&
			( selection[ 0 ].indexInNode !== undefined || node.getLength() === 0 )
		) {
			// Text-only addition where a text node didn't exist before. Create one
			this.synchronizer.pushInsertTextNode( node, selection[ 0 ].indexInNode || 0, insert.length - remove.length );
		} else {
			// Replacement is not exclusively text
			// Rebuild all covered nodes
			range = new ve.Range(
				selection[ 0 ].nodeOuterRange.start,
				selection[ selection.length - 1 ].nodeOuterRange.end
			);
			this.synchronizer.pushRebuild( range,
				new ve.Range( range.start + this.adjustment,
					range.end + this.adjustment + insert.length - remove.length )
			);
		}

		// Advance the cursor
		this.advanceCursor( remove.length );
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
				opRemove = operation.remove;
				opInsert = operation.insert;
				opRemoveMetadata = operation.removeMetadata;
				opInsertMetadata = operation.insertMetadata;
				// Update the linear model
				this.queueModification( {
					type: 'splice',
					args: [ 'data', this.cursor + this.adjustment, opRemove.length, opInsert ]
				} );
				// Keep the meta linear model in sync
				if ( opRemoveMetadata !== undefined ) {
					this.queueModification( {
						type: 'splice',
						args: [
							'metadata',
							this.cursor + this.adjustment,
							opRemoveMetadata.length,
							opInsertMetadata
						]
					} );
				} else {
					this.queueModification( {
						type: 'splice',
						args: [
							'metadata',
							this.cursor + this.adjustment,
							opRemove.length,
							new Array( opInsert.length )
						]
					} );
				}
				affectedRanges.push( new ve.Range(
					this.cursor,
					this.cursor + opRemove.length
				) );
				prevCursor = this.cursor;
				this.advanceCursor( opRemove.length );

				// Paint the removed selection, figure out which nodes were
				// covered, and add their ranges to the affected ranges list
				if ( opRemove.length > 0 ) {
					selection = this.document.selectNodes( new ve.Range(
						prevCursor,
						prevCursor + opRemove.length
					), 'siblings' );
					for ( i = 0; i < selection.length; i++ ) {
						affectedRanges.push( selection[ i ].nodeOuterRange );
					}
				}
				// Walk through the remove and insert data
				// and keep track of the element depth change (level)
				// for each of these two separately. The model is
				// only consistent if both levels are zero.
				for ( i = 0; i < opRemove.length; i++ ) {
					type = opRemove[ i ].type;
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
					type = opInsert[ i ].type;
					if ( type !== undefined ) {
						if ( type.charAt( 0 ) === '/' ) {
							// Closing element
							insertLevel--;
							if ( insertLevel < minInsertLevel ) {
								// Closing an unopened element at a higher
								// (more negative) level than before
								// Lazy-initialize scope
								scope = scope || this.document.getBranchNodeFromOffset( prevCursor );
								// Push the full range of the old scope as an affected range
								scopeStart = scope.getOffset();
								scopeEnd = scopeStart + scope.getOuterLength();
								affectedRanges.push( new ve.Range( scopeStart, scopeEnd ) );
								// Update scope
								scope = scope.getParent() || scope;
								minInsertLevel--;
							}
						} else {
							// Opening element
							insertLevel++;
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
		coveringRange = ve.Range.static.newCoveringRange( affectedRanges );
		this.synchronizer.pushRebuild(
			coveringRange,
			new ve.Range(
				coveringRange.start + this.adjustment - opAdjustment,
				coveringRange.end + this.adjustment
			)
		);
	}
};

/**
 * Execute a metadata replace operation.
 *
 * This method is called within the context of a transaction processor instance.
 *
 * @method
 * @param {Object} op Operation object
 * @param {Array} op.remove Metadata to remove
 * @param {Array} op.insert Metadata to insert
 */
ve.dm.TransactionProcessor.processors.replaceMetadata = function ( op ) {
	this.queueModification( {
		type: 'spliceMetadataAtOffset',
		args: [ this.cursor + this.adjustment, this.metadataCursor, op.remove.length, op.insert ]
	} );
	this.metadataCursor += op.insert.length;
};
