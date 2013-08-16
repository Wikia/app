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
 * @param {boolean} reversed Whether the transaction was applied in reverse
 * @emits insert
 * @emits remove
 */
ve.dm.MetaList.prototype.onTransact = function ( tx, reversed ) {
	var i, j, k, ilen, jlen, klen, ins, rm, retain, itemIndex, item,
		offset = 0, newOffset = 0, index = 0, ops = tx.getOperations(),
		insertedItems = [], removedItems = [];
	// Look for replaceMetadata operations in the transaction and insert/remove items as appropriate
	// This requires we also inspect retain, replace and replaceMetadata operations in order to
	// track the offset and index. We track the pre-transaction offset, we need to do that in
	// order to remove items correctly. This also means inserted items are initially at the wrong
	// offset, but we translate it later.
	for ( i = 0, ilen = ops.length; i < ilen; i++ ) {
		switch ( ops[i].type ) {
			case 'retain':
				offset += ops[i].length;
				newOffset += ops[i].length;
				index = 0;
				break;
			case 'replace':
				// if we have metadata replace info we can calculate the new
				// offset and index directly
				ins = reversed ? ops[i].removeMetadata : ops[i].insertMetadata;
				rm = reversed ? ops[i].insertMetadata : ops[i].removeMetadata;
				retain = ops[i].retainMetadata || 0;
				if ( rm !== undefined ) {
					// find the first itemIndex - the rest should be in order after it
					for ( j = 0, jlen = rm.length; j < jlen; j++ ) {
						if ( rm[j] !== undefined ) {
							itemIndex = this.findItem( offset + retain + j, 0 );
							break;
						}
					}
					// iterate through all the inserted metaItems
					for ( j = 0, jlen = ins.length; j < jlen; j++ ) {
						item = ins[j];
						if ( item !== undefined ) {
							for ( k = 0, klen = item.length; k < klen; k++ ) {
								// Queue up the move for later so we don't break the metaItem ordering
								this.items[itemIndex].setMove( newOffset + retain + j, k );
								itemIndex++;
							}
						}
					}
				}
				offset += reversed ? ops[i].insert.length : ops[i].remove.length;
				newOffset += reversed ? ops[i].remove.length : ops[i].insert.length;
				index = 0;
				break;
			case 'retainMetadata':
				index += ops[i].length;
				break;
			case 'replaceMetadata':
				ins = reversed ? ops[i].remove : ops[i].insert;
				rm = reversed ? ops[i].insert : ops[i].remove;
				for ( j = 0, jlen = rm.length; j < jlen; j++ ) {
					item = this.deleteRemovedItem( offset, index + j );
					removedItems.push( { 'item': item, 'offset': offset, 'index': index } );
				}
				for ( j = 0, jlen = ins.length; j < jlen; j++ ) {
					item = ve.dm.metaItemFactory.createFromElement( ins[j] );
					// offset and index are pre-transaction, but we'll fix them later
					this.addInsertedItem( offset, index + j, item );
					insertedItems.push( { 'item': item } );
				}
				index += rm.length;
				break;
		}
	}

	// Translate the offsets of all items, and reindex them too
	// Reindexing is simple because the above ensures the items are already in the right order
	offset = -1;
	index = 0;
	for ( i = 0, ilen = this.items.length; i < ilen; i++ ) {
		if ( this.items[i].isMovePending() ) {
			// move was calculated from metadata replace info, just apply it
			this.items[i].applyMove();
		} else {
			// otherwise calculate the new offset from the transaction
			this.items[i].setOffset( tx.translateOffset( this.items[i].getOffset(), reversed ) );
			if ( this.items[i].getOffset() === offset ) {
				index++;
			} else {
				index = 0;
			}
			this.items[i].setIndex( index );
		}
		offset = this.items[i].getOffset();
	}

	for ( i = 0, ilen = insertedItems.length; i < ilen; i++ ) {
		this.emit( 'insert', insertedItems[i].item );
	}
	for ( i = 0, ilen = removedItems.length; i < ilen; i++ ) {
		this.emit( 'remove', removedItems[i].item, removedItems[i].offset, removedItems[i].index );
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
