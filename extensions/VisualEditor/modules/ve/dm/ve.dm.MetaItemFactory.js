/*!
 * VisualEditor DataModel MetaItemFactory class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel meta item factory.
 *
 * @class
 * @extends ve.Factory
 * @constructor
 */
ve.dm.MetaItemFactory = function VeDmMetaItemFactory() {
	// Parent constructor
	ve.Factory.call( this );
};

/* Inheritance */

ve.inheritClass( ve.dm.MetaItemFactory, ve.Factory );

/* Methods */

/**
 * Get the group a given item type belongs to.
 *
 * @method
 * @param {string} type Meta item type
 * @returns {string} Group
 * @throws {Error} Unknown item type
 */
ve.dm.MetaItemFactory.prototype.getGroup = function ( type ) {
	if ( type in this.registry ) {
		return this.registry[type].static.group;
	}
	throw new Error( 'Unknown item type: ' + type );
};

/**
 * Create a new item from a metadata element
 * @param {Object} element Metadata element
 * @returns {ve.dm.MetaItem} MetaItem constructed from element
 * @throws {Error} Element must have a .type property
 */
ve.dm.MetaItemFactory.prototype.createFromElement = function ( element ) {
	if ( element && element.type ) {
		return this.create( element.type, element );
	}
	throw new Error( 'Element must have a .type property' );
};

/* Initialization */

ve.dm.metaItemFactory = new ve.dm.MetaItemFactory();
