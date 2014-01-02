/*!
 * VisualEditor DataModel MetaList class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel meta item.
 *
 * @class
 * @mixins ve.EventEmitter
 *
 * @constructor
 * @param {ve.dm.Surface} surface Surface model
 */
ve.dm.MetaList = function VeDmMetaList( surface ) {
	var i, j, jlen, metadata, item, group;

	// Mixin constructors
	ve.EventEmitter.call( this );

	// Properties
	this.surface = surface;
	this.document = surface.getDocument();
	this.groups = {};
	this.items = [];

	// Event handlers
	this.document.connect( this, { 'transact': 'onTransact' } );

	// Populate from document
	metadata = this.document.getMetadata();
	for ( i in metadata ) {
		if ( metadata.hasOwnProperty( i ) && ve.isArray( metadata[i] ) ) {
			for ( j = 0, jlen = metadata[i].length; j < jlen; j++ ) {
				item = ve.dm.metaItemFactory.createFromElement( metadata[i][j] );
				group = this.groups[item.getGroup()];
				if ( !group ) {
					group = this.groups[item.getGroup()] = [];
				}
				item.attach( this, Number( i ), j );
				group.push( item );
				this.items.push( item );
			}
		}
	}
};

/* Inheritance */

ve.mixinClass( ve.dm.MetaList, ve.EventEmitter );

/* Events */

/**
 * @event insert
 * @param {ve.dm.MetaItem} item Item that was inserted
 */

/**
 * @event remove
 * @param {ve.dm.MetaItem} item Item that was removed
 * @param {Number} offset Linear model offset that the item was at
 * @param {Number} index Index within that offset the item was at
 */

/* Methods */

/**
 * Event handler for transactions on the document.
 *
 * When a transaction occurs, update this list to account for it:
 * - insert items for new metadata that was inserted
 * - remove items for metadata that was removed
 * - translate offsets and recompute indices for metadata that has shifted
 * @param {ve.dm.Transaction} tx Transaction that was applied to the document
 * @emits insert
 * @emits remove
 */
ve.dm.MetaList.prototype.onTransact = function ( tx ) {
	var i, ilen, j, jlen, k, klen, item, ins, rm, insMeta, rmMeta,
		numItems = this.items.length,
		itemIndex = 0, // Current index into this.items
		offset = 0, // Current pre-transaction offset
		newOffset = 0, // Current post-transaction offset
		index = 0, // Current pre-transaction index
		newIndex = 0, // Current post-transaction index
		// Array of items that should appear in this.items after we're done. This includes newly
		// inserted items as well as existing items that aren't being removed.
		// [ { item: ve.dm.MetaItem, offset: offset to move to, index: index to move to } ]
		newItems = [],
		removedItems = [], // Array of items that should be removed from this.items
		events = [], // Array of events that we should emit when we're done
		ops = tx.getOperations();

	// Go through the transaction operations and plan out where to add, remove and move items. We
	// don't actually touch this.items yet, otherwise we 1) get it out of order which breaks
	// findItem() and 2) lose information about what the pre-transaction state of this.items was.
	for ( i = 0, ilen = ops.length; i < ilen; i++ ) {
		switch ( ops[i].type ) {
			case 'retain':
				// Advance itemIndex through the retain and update items we encounter along the way
				for ( ;
					itemIndex < numItems && this.items[itemIndex].offset < offset + ops[i].length;
					itemIndex++
				) {
					// Plan to move this item to the post-transaction offset and index
					newItems.push( {
						'item': this.items[itemIndex],
						'offset': this.items[itemIndex].offset + newOffset - offset,
						'index': this.items[itemIndex].offset === offset ?
							// Adjust index for insertions or removals that happened at this offset
							newIndex - index + this.items[itemIndex].index :
							// Offset is retained over completely, don't adjust index
							this.items[itemIndex].index } );
				}

				offset += ops[i].length;
				newOffset += ops[i].length;
				index = 0;
				newIndex = 0;
				break;

			case 'retainMetadata':
				// Advance itemIndex through the retain and update items we encounter along the way
				for ( ;
					itemIndex < numItems && this.items[itemIndex].offset === offset &&
						this.items[itemIndex].index < index + ops[i].length;
					itemIndex++
				) {
					newItems.push( {
						'item': this.items[itemIndex],
						'offset': newOffset,
						'index': this.items[itemIndex].index + newIndex - index
					} );
				}

				index += ops[i].length;
				newIndex += ops[i].length;
				break;

			case 'replace':
				ins = ops[i].insert;
				rm = ops[i].remove;
				if ( ops[i].removeMetadata !== undefined ) {
					insMeta = ops[i].insertMetadata;
					rmMeta = ops[i].removeMetadata;

					// Process removed metadata
					for ( ;
						itemIndex < numItems &&
							this.items[itemIndex].offset < offset + rmMeta.length;
						itemIndex++
					) {
						removedItems.push( this.items[itemIndex] );
					}

					// Process inserted metadata
					for ( j = 0, jlen = insMeta.length; j < jlen; j++ ) {
						if ( insMeta[j] ) {
							for ( k = 0, klen = insMeta[j].length; k < klen; k++ ) {
								item = ve.dm.metaItemFactory.createFromElement( insMeta[j][k] );
								newItems.push( {
									'item': item,
									'offset': newOffset + j,
									'index': k
								} );
							}
						}
					}
				} else {
					// No metadata handling specified, which means we just have to deal with offset
					// adjustments, same as a retain
					for ( ;
							itemIndex < numItems &&
								this.items[itemIndex].offset < offset + rm.length;
							itemIndex++
					) {
						newItems.push( {
							'item': this.items[itemIndex],
							'offset': this.items[itemIndex].offset + newOffset - offset,
							'index': this.items[itemIndex].index
						} );
					}
				}

				offset += rm.length;
				newOffset += ins.length;
				break;

			case 'replaceMetadata':
				insMeta = ops[i].insert;
				rmMeta = ops[i].remove;

				// Process removed items
				for ( ;
					itemIndex < numItems && this.items[itemIndex].offset === offset &&
						this.items[itemIndex].index < index + rmMeta.length;
					itemIndex++
				) {
					removedItems.push( this.items[itemIndex] );
				}

				// Process inserted items
				for ( j = 0, jlen = insMeta.length; j < jlen; j++ ) {
					item = ve.dm.metaItemFactory.createFromElement( insMeta[j] );
					newItems.push( { 'item': item, 'offset': newOffset, 'index': newIndex + j } );
				}

				index += rmMeta.length;
				newIndex += insMeta.length;
				break;
		}
	}
	// Update the remaining items that the transaction didn't touch or retain over
	for ( ; itemIndex < numItems; itemIndex++ ) {
		newItems.push( {
			'item': this.items[itemIndex],
			'offset': this.items[itemIndex].offset + newOffset - offset,
			'index': this.items[itemIndex].offset === offset ?
				newIndex - index + this.items[itemIndex].index :
				this.items[itemIndex].index
		} );
	}

	// Process the changes, and queue up events. We emit the events at the end when the MetaList
	// is back in a consistent state

	// Remove removed items
	for ( i = 0, ilen = removedItems.length; i < ilen; i++ ) {
		this.deleteRemovedItem( removedItems[i].offset, removedItems[i].index );
		events.push( [
			'remove', removedItems[i], removedItems[i].offset, removedItems[i].index
		] );
	}

	// Move moved items (these appear as inserted items that are already attached)
	for ( i = 0, ilen = newItems.length; i < ilen; i++ ) {
		if ( newItems[i].item.isAttached() ) {
			if ( newItems[i].offset !== newItems[i].item.offset || newItems[i].index !== newItems[i].item.index ) {
				this.deleteRemovedItem( newItems[i].item.offset, newItems[i].item.index );
				this.addInsertedItem( newItems[i].offset, newItems[i].index, newItems[i].item );
			}
		}
	}

	// Insert new items
	for ( i = 0, ilen = newItems.length; i < ilen; i++ ) {
		if ( !newItems[i].item.isAttached() ) {
			this.addInsertedItem( newItems[i].offset, newItems[i].index, newItems[i].item );
			events.push( [ 'insert', newItems[i].item ] );
		}
	}

	// Emit events
	for ( i = 0, ilen = events.length; i < ilen; i++ ) {
		this.emit.apply( this, events[i] );
	}
};

/**
 * Find an item by its offset, index and group.
 *
 * This function is mostly for internal usage.
 *
 * @param {number} offset Offset in the linear model
 * @param {number} index Index in the metadata array associated with that offset
 * @param {string} [group] Group to search in. If not set, search in all groups
 * @param {boolean} [forInsertion] If the item is not found, return the index where it should have
 *  been rather than null
 * @returns {number|null} Index into this.items or this.groups[group] where the item was found, or
 *  null if not found
 */
ve.dm.MetaList.prototype.findItem = function ( offset, index, group, forInsertion ) {
	// Binary search for the item
	var mid, items = typeof group === 'string' ? ( this.groups[group] || [] ) : this.items,
		left = 0, right = items.length;
	while ( left < right ) {
		// Equivalent to Math.floor( ( left + right ) / 2 ) but much faster in V8
		/*jshint bitwise:false */
		mid = ( left + right ) >> 1;
		if ( items[mid].getOffset() === offset && items[mid].getIndex() === index ) {
			return mid;
		}
		if ( items[mid].getOffset() < offset || (
			items[mid].getOffset() === offset && items[mid].getIndex() < index
		) ) {
			left = mid + 1;
		} else {
			right = mid;
		}
	}
	return forInsertion ? left : null;
};

/**
 * Get the item at a given offset and index, if there is one.
 *
 * @param {number} offset Offset in the linear model
 * @param {number} index Index in the metadata array
 * @returns {ve.dm.MetaItem|null} The item at (offset,index), or null if not found
 */
ve.dm.MetaList.prototype.getItemAt = function ( offset, index ) {
	var at = this.findItem( offset, index );
	return at === null ? null : this.items[at];
};

/**
 * Get all items in a group.
 *
 * This function returns a shallow copy, so the array isn't returned by reference but the items
 * themselves are.
 *
 * @param {string} group Group
 * @returns {ve.dm.MetaItem[]} Array of items in the group (shallow copy)
 */
ve.dm.MetaList.prototype.getItemsInGroup = function ( group ) {
	return ( this.groups[group] || [] ).slice( 0 );
};

/**
 * Get all items in the list.
 *
 * This function returns a shallow copy, so the array isn't returned by reference but the items
 * themselves are.
 *
 * @returns {ve.dm.MetaItem[]} Array of items in the list
 */
ve.dm.MetaList.prototype.getAllItems = function () {
	return this.items.slice( 0 );
};

/**
 * Insert new metadata into the document. This builds and processes a transaction that inserts
 * metadata into the document.
 * @param {Object|ve.dm.MetaItem} meta Metadata element (or MetaItem) to insert
 * @param {Number} [offset] Offset to insert the new metadata, or undefined to add to the end
 * @param {Number} [index] Index to insert the new metadata, or undefined to add to the end
 */
ve.dm.MetaList.prototype.insertMeta = function ( meta, offset, index ) {
	var tx;
	if ( meta instanceof ve.dm.MetaItem ) {
		meta = meta.getElement();
	}
	if ( offset === undefined ) {
		offset = this.document.data.getLength();
	}
	if ( index === undefined ) {
		index = ( this.document.metadata.getData( offset ) || [] ).length;
	}
	tx = ve.dm.Transaction.newFromMetadataInsertion( this.document, offset, index, [ meta ] );
	this.surface.change( tx );
};

/**
 * Remove a meta item from the document. This builds and processes a transaction that removes the
 * associated metadata from the document.
 * @param {ve.dm.MetaItem} item Item to remove
 */
ve.dm.MetaList.prototype.removeMeta = function ( item ) {
	var tx;
	tx = ve.dm.Transaction.newFromMetadataRemoval(
		this.document,
		item.getOffset(),
		new ve.Range( item.getIndex(), item.getIndex() + 1 )
	);
	this.surface.change( tx );
};

/**
 * Insert an item at a given offset and index in response to a transaction.
 *
 * This function is for internal usage by onTransact(). To actually insert an item, use
 * insertItem().
 *
 * @param {number} offset Offset in the linear model of the new item
 * @param {number} index Index of the new item in the metadata array at offset
 * @param {ve.dm.MetaItem} item Item object
 * @emits insert
 */
ve.dm.MetaList.prototype.addInsertedItem = function ( offset, index, item ) {
	var group = item.getGroup(), at = this.findItem( offset, index, null, true );
	this.items.splice( at, 0, item );
	if ( this.groups[group] ) {
		at = this.findItem( offset, index, group, true );
		this.groups[group].splice( at, 0, item );
	} else {
		this.groups[group] = [ item ];
	}
	item.attach( this, offset, index );
};

/**
 * Remove an item in response to a transaction.
 *
 * This function is for internal usage by onTransact(). To actually remove an item, use
 * removeItem().
 *
 * @param {number} offset Offset in the linear model of the item
 * @param {number} index Index of the item in the metadata array at offset
 * @emits remove
 */
ve.dm.MetaList.prototype.deleteRemovedItem = function ( offset, index ) {
	var item, group, at = this.findItem( offset, index );
	if ( at === null ) {
		return;
	}
	item = this.items[at];
	group = item.getGroup();
	this.items.splice( at, 1 );
	at = this.findItem( offset, index, group );
	if ( at !== null ) {
		this.groups[group].splice( at, 1 );
	}
	item.detach( this );
	return item;
};
