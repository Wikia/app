/*!
 * VisualEditor DataModel DocumentSynchronizer class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel document synchronizer.
 *
 * This object is a utility for collecting actions to be performed on the model tree in multiple
 * steps as the linear model is modified by a transaction processor and then processing those queued
 * actions when the transaction is done being processed.
 *
 * IMPORTANT NOTE: It is assumed that:
 *
 *   - The linear model has already been updated for the pushed actions
 *   - Actions are pushed in increasing offset order
 *   - Actions are non-overlapping
 *
 * @class
 * @constructor
 * @param {ve.dm.Document} doc Document to synchronize
 * @param {ve.dm.Transaction} transaction The transaction being synchronized for
 */
ve.dm.DocumentSynchronizer = function VeDmDocumentSynchronizer( doc, transaction ) {
	// Properties
	this.document = doc;
	this.actionQueue = [];
	this.eventQueue = [];
	this.adjustment = 0;
	this.transaction = transaction;
};

/* Static Properties */

/**
 * Synchronization methods.
 *
 * Each method is specific to a type of action. Methods are called in the context of a document
 * synchronizer, so they work similar to normal methods on the object.
 *
 * @static
 * @property
 */
ve.dm.DocumentSynchronizer.synchronizers = {};

/* Static Methods */

/**
 * Synchronize an annotation action.
 *
 * This method is called within the context of a document synchronizer instance.
 *
 * @static
 * @method
 * @param {Object} action
 */
ve.dm.DocumentSynchronizer.synchronizers.annotation = function ( action ) {
	// Queue events for all leaf nodes covered by the range
	var i,
		adjustedRange = ve.Range.newFromTranslatedRange( action.range, this.adjustment ),
		selection = this.document.selectNodes( adjustedRange, 'leaves' );
	for ( i = 0; i < selection.length; i++ ) {
		// No tree synchronization needed
		// Queue events
		this.queueEvent( selection[i].node, 'annotation' );
		this.queueEvent( selection[i].node, 'update' );
	}
};

/**
 * Synchronize an attribute change action.
 *
 * This method is called within the context of a document synchronizer instance.
 *
 * @static
 * @method
 * @param {Object} action
 */
ve.dm.DocumentSynchronizer.synchronizers.attributeChange = function ( action ) {
	// No tree synchronization needed
	// Queue events
	this.queueEvent( action.node, 'attributeChange', action.key, action.from, action.to );
	this.queueEvent( action.node, 'update' );
};

/**
 * Synchronize a resize action.
 *
 * This method is called within the context of a document synchronizer instance.
 *
 * @static
 * @method
 * @param {Object} action
 */
ve.dm.DocumentSynchronizer.synchronizers.resize = function ( action ) {
	var node = action.node,
		parent = node.getParent();

	if ( parent && node.getType() === 'text' && node.getLength() + action.adjustment === 0 ) {
		// Auto-prune empty text nodes
		parent.splice( parent.indexOf( node ), 1 );
	} else {
		// Apply length change to tree
		// No update event needed, adjustLength causes an update event on its own
		// FIXME however, any queued update event will still be emitted, resulting in a duplicate
		node.adjustLength( action.adjustment );
	}
	// Update adjustment
	this.adjustment += action.adjustment;
};

/**
 * Synchronize a rebuild action.
 *
 * This method is called within the context of a document synchronizer instance.
 *
 * @static
 * @method
 * @param {Object} action
 */
ve.dm.DocumentSynchronizer.synchronizers.rebuild = function ( action ) {
	var firstNode, parent, index, numNodes,
		// Find the nodes contained by oldRange
		adjustedOldRange = ve.Range.newFromTranslatedRange( action.oldRange, this.adjustment ),
		selection = this.document.selectNodes( adjustedOldRange, 'siblings' );

	// If the document is empty, selection[0].node will be the document (so no parent)
	// but we won't get indexInNode either. Detect this and use index=0 in that case.
	if ( 'indexInNode' in selection[0] || !selection[0].node.getParent() ) {
		// Insertion
		parent = selection[0].node;
		index = selection[0].indexInNode || 0;
		numNodes = 0;
	} else {
		// Rebuild
		firstNode = selection[0].node;
		parent = firstNode.getParent();
		index = selection[0].index;
		numNodes = selection.length;
	}
	// Perform rebuild in tree
	this.document.rebuildNodes( parent, index, numNodes, adjustedOldRange.from,
		action.newRange.getLength()
	);
	// Update adjustment
	this.adjustment += action.newRange.getLength() - adjustedOldRange.getLength();
};

/* Methods */

/**
 * Get the document being synchronized.
 *
 * @method
 * @returns {ve.dm.Document} Document being synchronized
 */
ve.dm.DocumentSynchronizer.prototype.getDocument = function () {
	return this.document;
};

/**
 * Add an annotation action to the queue.
 *
 * This finds all leaf nodes covered wholly or partially by the given range, and emits annotation
 * events for all of them.
 *
 * @method
 * @param {ve.Range} range Range that was annotated
 */
ve.dm.DocumentSynchronizer.prototype.pushAnnotation = function ( range ) {
	this.actionQueue.push( {
		'type': 'annotation',
		'range': range
	} );
};

/**
 * Add an attribute change to the queue.
 *
 * This emits an attributeChange event for the given node with the provided metadata.
 *
 * @method
 * @param {ve.dm.Node} node Node whose attribute changed
 * @param {string} key Key of the attribute that changed
 * @param {Mixed} from Old value of the attribute
 * @param {Mixed} to New value of the attribute
 */
ve.dm.DocumentSynchronizer.prototype.pushAttributeChange = function ( node, key, from, to ) {
	this.actionQueue.push( {
		'type': 'attributeChange',
		'node': node,
		'key': key,
		'from': from,
		'to': to
	} );
};

/**
 * Add a resize action to the queue.
 *
 * This changes the length of a text node.
 *
 * @method
 * @param {ve.dm.TextNode} node Node to resize
 * @param {number} adjustment Length adjustment to apply to the node
 */
ve.dm.DocumentSynchronizer.prototype.pushResize = function ( node, adjustment ) {
	this.actionQueue.push( {
		'type': 'resize',
		'node': node,
		'adjustment': adjustment
	} );
};

/**
 * Add a rebuild action to the queue.
 *
 * When a range of data has been changed arbitrarily this can be used to drop the nodes that
 * represented the original range and replace them with new nodes that represent the new range.
 *
 * @method
 * @param {ve.Range} oldRange Range of old nodes to be dropped
 * @param {ve.Range} newRange Range for new nodes to be built from
 */
ve.dm.DocumentSynchronizer.prototype.pushRebuild = function ( oldRange, newRange ) {
	this.actionQueue.push( {
		'type': 'rebuild',
		'oldRange': oldRange,
		'newRange': newRange
	} );
};

/**
 * Queue an event to be emitted on a node.
 *
 * This method is called by methods defined in {ve.dm.DocumentSynchronizer.synchronizers}.
 *
 * Duplicate events will be ignored only if all arguments match exactly. Hashes of each event that
 * has been queued are stored in the nodes they will eventually be fired on.
 *
 * @method
 * @param {ve.dm.Node} node
 * @param {string} event Event name
 * @param {Mixed...} [args] Additional arguments to be passed to the event when fired
 */
ve.dm.DocumentSynchronizer.prototype.queueEvent = function ( node ) {
	// Check if this is already queued
	var
		args = Array.prototype.slice.call( arguments, 1 ),
		hash = ve.getHash( args );

	if ( !node.queuedEventHashes ) {
		node.queuedEventHashes = {};
	}
	if ( !node.queuedEventHashes[hash] ) {
		node.queuedEventHashes[hash] = true;
		this.eventQueue.push( {
			'node': node,
			'args': args.concat( this.transaction )
		} );
	}
};

/**
 * Synchronize node tree using queued actions.
 *
 * This method uses the static methods defined in {ve.dm.DocumentSynchronizer.synchronizers} and
 * calls them in the context of {this}.
 *
 * After synchronization is complete all queued events will be emitted. Hashes of queued events that
 * have been stored on nodes are removed from the nodes after the events have all been emitted.
 *
 * This method also clears both action and event queues.
 *
 * @method
 */
ve.dm.DocumentSynchronizer.prototype.synchronize = function () {
	var action,
		event,
		i;
	// Execute the actions in the queue
	for ( i = 0; i < this.actionQueue.length; i++ ) {
		action = this.actionQueue[i];
		if ( action.type in ve.dm.DocumentSynchronizer.synchronizers ) {
			ve.dm.DocumentSynchronizer.synchronizers[action.type].call( this, action );
		} else {
			throw new Error( 'Invalid action type ' + action.type );
		}
	}
	// Emit events in the event queue
	for ( i = 0; i < this.eventQueue.length; i++ ) {
		event = this.eventQueue[i];
		event.node.emit.apply( event.node, event.args );
		delete event.node.queuedEventHashes;
	}
	// Clear queues
	this.actionQueue = [];
	this.eventQueue = [];
};
