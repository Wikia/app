/*!
 * VisualEditor DataModel MetaItem class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel meta item.
 *
 * @class
 * @abstract
 * @extends ve.dm.Model
 * @mixins ve.EventEmitter
 *
 * @constructor
 * @param {Object} element Reference to element in meta-linmod
 */
ve.dm.MetaItem = function VeDmMetaItem( element ) {
	// Parent constructor
	ve.dm.Model.call( this, element );
	// Mixin
	ve.EventEmitter.call( this );

	// Properties
	this.list = null;
	this.offset = null;
	this.index = null;
	this.move = null;
};

/* Inheritance */

ve.inheritClass( ve.dm.MetaItem, ve.dm.Model );

ve.mixinClass( ve.dm.MetaItem, ve.EventEmitter );

/* Static members */

/**
 * Symbolic name for the group this meta item type will be grouped in in ve.dm.MetaList.
 *
 * @static
 * @property {string} [static.group='misc']
 * @inheritable
 */
ve.dm.MetaItem.static.group = 'misc';

/* Methods */

/**
 * Remove this item from the document. Only works if the item is attached to a MetaList.
 * @throws {Error} Cannot remove detached item
 */
ve.dm.MetaItem.prototype.remove = function () {
	if ( !this.list ) {
		throw new Error( 'Cannot remove detached item' );
	}
	this.list.removeMeta( this );
};

/**
 * Replace item with another in-place.
 *
 * @param {ve.dm.MetaItem} item Item to replace this item with
 */
ve.dm.MetaItem.prototype.replaceWith = function ( item ) {
	var offset = this.getOffset(),
		index = this.getIndex(),
		list = this.list;

	list.removeMeta( this );
	list.insertMeta( item, offset, index );
};

/**
 * Get the group this meta item belongs to.
 * @see ve.dm.MetaItem#static.group
 * @returns {string} Group
 */
ve.dm.MetaItem.prototype.getGroup = function () {
	return this.constructor.static.group;
};

/**
 * Get the MetaList this item is attached to.
 * @returns {ve.dm.MetaList|null} Reference to the parent list, or null if not attached
 */
ve.dm.MetaItem.prototype.getParentList = function () {
	return this.list;
};

/**
 * Get this item's offset in the linear model.
 *
 * This is only known if the item is attached to a MetaList.
 *
 * @returns {number|null} Offset, or null if not attached
 */
ve.dm.MetaItem.prototype.getOffset = function () {
	return this.offset;
};

/**
 * Get this item's index in the metadata array at the offset.
 *
 * This is only known if the item is attached to a MetaList.
 *
 * @returns {number|null} Index, or null if not attached
 */
ve.dm.MetaItem.prototype.getIndex = function () {
	return this.index;
};

/**
 * Set the offset. This is used by the parent list to synchronize the item with the document state.
 * @param {number} offset New offset
 */
ve.dm.MetaItem.prototype.setOffset = function ( offset ) {
	this.offset = offset;
};

/**
 * Set the index. This is used by the parent list to synchronize the item with the document state.
 * @param {number} index New index
 */
ve.dm.MetaItem.prototype.setIndex = function ( index ) {
	this.index = index;
};

/**
 * Attach this item to a MetaList.
 * @param {ve.dm.MetaList} list Parent list to attach to
 * @param {number} offset Offset of this item in the parent list's document
 * @param {number} index Index of this item in the metadata array at the offset
 */
ve.dm.MetaItem.prototype.attach = function ( list, offset, index ) {
	this.list = list;
	this.offset = offset;
	this.index = index;
};

/**
 * Detach this item from its parent list.
 *
 * This clears the stored offset and index, unless the item has already been attached to another list.
 *
 * @param {ve.dm.MetaList} list List to detach from
 */
ve.dm.MetaItem.prototype.detach = function ( list ) {
	if ( this.list === list ) {
		this.list = null;
		this.offset = null;
		this.index = null;
	}
};

/**
 * Check whether this item is attached to a MetaList.
 * @returns {boolean} Whether item is attached
 */
ve.dm.MetaItem.prototype.isAttached = function () {
	return this.list !== null;
};
