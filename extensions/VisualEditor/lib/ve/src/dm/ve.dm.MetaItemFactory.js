/*!
 * VisualEditor DataModel MetaItemFactory class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * DataModel meta item factory.
 *
 * @class
 * @extends ve.dm.ModelFactory
 * @constructor
 */
ve.dm.MetaItemFactory = function VeDmMetaItemFactory() {
	// Parent constructor
	ve.dm.MetaItemFactory.super.call( this );
};

/* Inheritance */

OO.inheritClass( ve.dm.MetaItemFactory, ve.dm.ModelFactory );

/* Methods */

/**
 * Get the group a given item type belongs to.
 *
 * @method
 * @param {string} type Meta item type
 * @return {string} Group
 * @throws {Error} Unknown item type
 */
ve.dm.MetaItemFactory.prototype.getGroup = function ( type ) {
	if ( Object.prototype.hasOwnProperty.call( this.registry, type ) ) {
		return this.registry[ type ].static.group;
	}
	throw new Error( 'Unknown item type: ' + type );
};

/* Initialization */

ve.dm.metaItemFactory = new ve.dm.MetaItemFactory();
