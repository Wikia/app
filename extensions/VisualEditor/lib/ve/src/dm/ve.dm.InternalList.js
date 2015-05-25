/*!
 * VisualEditor DataModel InternalList class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * DataModel meta item.
 *
 * @class
 * @mixins OO.EventEmitter
 *
 * @constructor
 * @param {ve.dm.Document} doc Document model
 */
ve.dm.InternalList = function VeDmInternalList( doc ) {
	// Mixin constructors
	OO.EventEmitter.call( this );

	// Properties
	this.document = doc;
	this.itemHtmlQueue = [];
	this.listNode = null;
	this.nodes = {};
	this.groupsChanged = [];
	this.keyIndexes = {};
	this.keys = [];
	this.nextUniqueNumber = 0;

	// Event handlers
	if ( doc ) {
		doc.connect( this, { transact: 'onTransact' } );
	}
};

/* Inheritance */

OO.mixinClass( ve.dm.InternalList, OO.EventEmitter );

/* Events */

/**
 * @event update
 * @param {string[]} groupsChanged List of groups changed since the last transaction
 */

/* Methods */

/**
 * Queues up an item's html for parsing later.
 *
 * If an item with the specified group and key already exists it will be ignored, unless
 * the data already stored is an empty string.
 *
 * @method
 * @param {string} groupName Item group
 * @param {string} key Item key
 * @param {string} html Item contents
 * @returns {Object} Object containing index of the item in the index-value store
 * (and also its index in the internal list node), and a flag indicating if it is a new item.
 */
ve.dm.InternalList.prototype.queueItemHtml = function ( groupName, key, html ) {
	var isNew = false,
		index = this.getKeyIndex( groupName, key );

	if ( index === undefined ) {
		index = this.itemHtmlQueue.length;
		this.keyIndexes[groupName + '/' + key] = index;
		this.itemHtmlQueue.push( html );
		isNew = true;
	} else if ( this.itemHtmlQueue[index] === '' ) {
		// Previous value with this key was empty, overwrite value in queue
		this.itemHtmlQueue[index] = html;
		isNew = true;
	}
	return {
		index: index,
		isNew: isNew
	};
};

/**
 * Gets all the item's HTML strings
 * @method
 * @returns {Object} Name-indexed object containing HTMLElements
 */
ve.dm.InternalList.prototype.getItemHtmlQueue = function () {
	return this.itemHtmlQueue;
};

/**
 * Gets the internal list's document model
 * @method
 * @returns {ve.dm.Document} Document model
 */
ve.dm.InternalList.prototype.getDocument = function () {
	return this.document;
};

/**
 * Get the list node
 * @method
 * @returns {ve.dm.InternalListNode} List node
 */
ve.dm.InternalList.prototype.getListNode = function () {
	var i, nodes;
	// find listNode if not set, or unattached
	if ( !this.listNode || !this.listNode.doc ) {
		nodes = this.getDocument().getDocumentNode().children;
		for ( i = nodes.length; i >= 0; i-- ) {
			if ( nodes[i] instanceof ve.dm.InternalListNode ) {
				this.listNode = nodes[i];
				break;
			}
		}
	}
	return this.listNode;
};

/**
 * Get the number it internal items in the internal list.
 *
 * @method
 * @returns {number}
 */
ve.dm.InternalList.prototype.getItemNodeCount = function () {
	return this.getListNode().children.length;
};

/**
 * Get the item node from a specific index.
 *
 * @method
 * @param {number} index Item index
 * @returns {ve.dm.InternalItemNode} Item node
 */
ve.dm.InternalList.prototype.getItemNode = function ( index ) {
	return this.getListNode().children[index];
};

/**
 * Get all node groups.
 *
 * @method
 * @returns {Object} Node groups, keyed by group name
 */
ve.dm.InternalList.prototype.getNodeGroups = function () {
	return this.nodes;
};

/**
 * Get the node group object for a specified group name.
 *
 * @method
 * @param {string} groupName Name of the group
 * @returns {Object} Node group object, containing nodes and key order array
 */
ve.dm.InternalList.prototype.getNodeGroup = function ( groupName ) {
	return this.nodes[groupName];
};

/**
 * Get a unique list key for a given group.
 *
 * The returned list key is added to the list of unique list keys used in this group so that it
 * won't be allocated again. It will also be associated to oldListKey so that if the same oldListKey
 * is passed in again later, the previously allocated name will be returned.
 *
 * @method
 * @param {string} groupName Name of the group
 * @param {string} oldListKey Current list key to associate the generated list key with
 * @param {string} prefix Prefix to distinguish generated keys from non-generated ones
 * @returns {string} Generated unique list key, or existing unique key associated with oldListKey
 */
ve.dm.InternalList.prototype.getUniqueListKey = function ( groupName, oldListKey, prefix ) {
	var group = this.getNodeGroup( groupName ),
		num = 0;

	if ( group.uniqueListKeys[oldListKey] !== undefined ) {
		return group.uniqueListKeys[oldListKey];
	}

	while ( group.keyedNodes[prefix + num] || group.uniqueListKeysInUse[prefix + num] ) {
		num++;
	}

	group.uniqueListKeys[oldListKey] = prefix + num;
	group.uniqueListKeysInUse[prefix + num] = true;
	return prefix + num;
};

/**
 * Get the next number in a monotonically increasing series.
 * @returns {number} One higher than the return value of the previous call, or 0 on the first call
 */
ve.dm.InternalList.prototype.getNextUniqueNumber = function () {
	return this.nextUniqueNumber++;
};

/**
 * Converts stored item HTML into linear data.
 *
 * Each item is an InternalItem, and they are wrapped in an InternalList.
 * If there are no items an empty array is returned.
 *
 * Stored HTML is deleted after conversion.
 *
 * @method
 * @param {ve.dm.Converter} converter Converter object
 * @param {HTMLDocument} doc Document to create nodes in
 * @returns {Array} Linear model data
 */
ve.dm.InternalList.prototype.convertToData = function ( converter, doc ) {
	var i, length, itemData,
		itemHtmlQueue = this.getItemHtmlQueue(), list = [];

	list.push( { type: 'internalList' } );
	for ( i = 0, length = itemHtmlQueue.length; i < length; i++ ) {
		if ( itemHtmlQueue[i] !== '' ) {
			itemData = converter.getDataFromDomSubtree( $( '<div>', doc ).html( itemHtmlQueue[i] )[0] );
			list = list.concat(
				[{ type: 'internalItem' }],
				itemData,
				[{ type: '/internalItem' }]
			);
		} else {
			list = list.concat( [ { type: 'internalItem' }, { type: '/internalItem' } ] );
		}
	}
	list.push( { type: '/internalList' } );
	// After conversion we no longer need the HTML
	this.itemHtmlQueue = [];
	return list;
};

/**
 * Generate a transaction for inserting a new internal item node
 * @param {string} groupName Item group
 * @param {string} key Item key
 * @param {Array} data Linear model data
 * @returns {Object} Object containing the transaction (or null if none required)
 * and the new item's index within the list
 */
ve.dm.InternalList.prototype.getItemInsertion = function ( groupName, key, data ) {
	var tx, itemData,
		index = this.getKeyIndex( groupName, key );

	if ( index === undefined ) {
		index = this.getItemNodeCount();
		this.keyIndexes[groupName + '/' + key] = index;

		itemData = [{ type: 'internalItem' }].concat( data,  [{ type: '/internalItem' }] );
		tx = ve.dm.Transaction.newFromInsertion(
			this.getDocument(),
			this.getListNode().getRange().end,
			itemData
		);
	} else {
		tx = null;
	}

	return {
		transaction: tx,
		index: index
	};
};

/**
 * Get position of a key within a group
 * @param {string} groupName Name of the group
 * @param {string} key Name of the key
 * @returns {number} Position within the key ordering for that group
 */
ve.dm.InternalList.prototype.getIndexPosition = function ( groupName, index ) {
	return ve.indexOf( index, this.nodes[groupName].indexOrder );
};

/**
 * Get the internal item index of a group key if it already exists
 * @param {string} groupName Item group
 * @param {string} key Item name
 * @returns {number|undefined} The index of the group key, or undefined if it doesn't exist yet
 */
ve.dm.InternalList.prototype.getKeyIndex = function ( groupName, key ) {
	return this.keyIndexes[groupName + '/' + key];
};

/**
 * Add a node.
 * @method
 * @param {string} groupName Item group
 * @param {string} key Item name
 * @param {number} index Item index
 * @param {ve.dm.Node} node Item node
 */
ve.dm.InternalList.prototype.addNode = function ( groupName, key, index, node ) {
	var i, len, start, keyedNodes, group = this.nodes[groupName];
	// The group may not exist yet
	if ( group === undefined ) {
		group = this.nodes[groupName] = {
			keyedNodes: {},
			firstNodes: [],
			indexOrder: [],
			uniqueListKeys: {},
			uniqueListKeysInUse: {}
		};
	}
	keyedNodes = group.keyedNodes[key];
	this.keys[index] = key;
	// The key may not exist yet
	if ( keyedNodes === undefined ) {
		keyedNodes = group.keyedNodes[key] = [];
	}
	if ( node.getDocument().buildingNodeTree ) {
		// If the document is building the original node tree
		// then every item is being added in order, so we don't
		// need to worry about sorting.
		keyedNodes.push( node );
		if ( keyedNodes.length === 1 ) {
			group.firstNodes[index] = node;
		}
	} else {
		// TODO: We could use binary search insertion sort
		start = node.getRange().start;
		for ( i = 0, len = keyedNodes.length; i < len; i++ ) {
			if ( start < keyedNodes[i].getRange().start ) {
				break;
			}
		}
		// 'i' is now the insertion point, so add the node here
		keyedNodes.splice( i, 0, node );
		if ( i === 0 ) {
			group.firstNodes[index] = node;
		}
	}
	if ( ve.indexOf( index, group.indexOrder ) === -1 ) {
		group.indexOrder.push( index );
	}
	this.markGroupAsChanged( groupName );
};

/**
 * Mark a node group as having been changed since the last transaction.
 * @param {string} groupName Name of group which has changed
 */
ve.dm.InternalList.prototype.markGroupAsChanged = function ( groupName ) {
	if ( ve.indexOf( groupName, this.groupsChanged ) === -1 ) {
		this.groupsChanged.push( groupName );
	}
};

/**
 * Handle document transaction events
 * @fires update
 */
ve.dm.InternalList.prototype.onTransact = function () {
	var i;
	if ( this.groupsChanged.length > 0 ) {
		// length will almost always be 1, so probably better to not cache it
		for ( i = 0; i < this.groupsChanged.length; i++ ) {
			this.sortGroupIndexes( this.nodes[this.groupsChanged[i]] );
		}
		this.emit( 'update', this.groupsChanged );
		this.groupsChanged = [];
	}
};

/**
 * Remove a node.
 * @method
 * @param {string} groupName Item group
 * @param {string} key Item name
 * @param {number} index Item index
 * @param {ve.dm.Node} node Item node
 */
ve.dm.InternalList.prototype.removeNode = function ( groupName, key, index, node ) {
	var i, len, j, keyedNodes,
		group = this.nodes[groupName];

	keyedNodes = group.keyedNodes[key];
	for ( i = 0, len = keyedNodes.length; i < len; i++ ) {
		if ( keyedNodes[i] === node ) {
			keyedNodes.splice( i, 1 );
			if ( i === 0 ) {
				group.firstNodes[index] = keyedNodes[0];
			}
			break;
		}
	}
	// If the all the items in this key have been removed
	// then remove this index from indexOrder and firstNodes
	if ( keyedNodes.length === 0 ) {
		delete group.keyedNodes[key];
		delete group.firstNodes[index];
		j = ve.indexOf( index, group.indexOrder );
		group.indexOrder.splice( j, 1 );
	}
	this.markGroupAsChanged( groupName );
};

/**
 * Sort the indexOrder array within a group object.
 * @param {Object} group Group object
 */
ve.dm.InternalList.prototype.sortGroupIndexes = function ( group ) {
	// Sort indexOrder
	group.indexOrder.sort( function ( index1, index2 ) {
		return group.firstNodes[index1].getRange().start - group.firstNodes[index2].getRange().start;
	} );
};

/**
 * Clone this internal list.
 *
 * @param {ve.dm.Document} [doc] The new list's document. Defaults to this list's document.
 * @returns {ve.dm.InternalList} Clone of this internal
 */
ve.dm.InternalList.prototype.clone = function ( doc ) {
	var clone = new this.constructor( doc || this.getDocument() );
	// Most properties don't need to be copied, because addNode() will be invoked when the new
	// document tree is built. But some do need copying:
	clone.nextUniqueNumber = this.nextUniqueNumber;
	clone.itemHtmlQueue = ve.copy( this.itemHtmlQueue );
	return clone;
};

/**
 * Merge another internal list into this one.
 *
 * This function updates the state of this list, and returns a mapping from indexes in list to
 * indexes in this, as well as a set of ranges that should be copied from list's linear model
 * into this list's linear model by the caller.
 *
 * @param {ve.dm.InternalList} list Internal list to merge into this list
 * @param {number} commonLength The number of elements, counted from the beginning, that the lists have in common
 * @returns {Object} 'mapping' is an object mapping indexes in list to indexes in this; newItemRanges is an array
 *  of ranges of internal nodes in list's document that should be copied into our document
 */
ve.dm.InternalList.prototype.merge = function ( list, commonLength ) {
	var i, k, key,
		listLen = list.getItemNodeCount(),
		nextIndex = this.getItemNodeCount(),
		newItemRanges = [],
		mapping = {};
	for ( i = 0; i < commonLength; i++ ) {
		mapping[i] = i;
	}
	for ( i = commonLength; i < listLen; i++ ) {
		// Try to find i in list.keyIndexes
		key = undefined;
		for ( k in list.keyIndexes ) {
			if ( list.keyIndexes[k] === i ) {
				key = k;
				break;
			}
		}

		if ( this.keyIndexes[key] !== undefined ) {
			// We already have this key in this internal list. Ignore the duplicate that the other
			// list is trying to merge in.
			// NOTE: This case cannot occur in VE currently, but may be possible in the future with
			// collaborative editing, which is why this code needs to be rewritten before we do
			// collaborative editing.
			mapping[i] = this.keyIndexes[key];
		} else {
			mapping[i] = nextIndex;
			if ( key !== undefined ) {
				this.keyIndexes[key] = nextIndex;
			}
			nextIndex++;
			newItemRanges.push( list.getItemNode( i ).getOuterRange() );
		}
	}
	return {
		mapping: mapping,
		newItemRanges: newItemRanges
	};
};
