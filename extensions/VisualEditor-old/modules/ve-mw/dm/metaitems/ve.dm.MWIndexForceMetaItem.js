/*!
 * VisualEditor DataModel MWIndexForceMetaItem class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel force index meta item (for __INDEX__).
 *
 * @class
 * @extends ve.dm.MetaItem
 * @constructor
 * @param {Object} element Reference to element in meta-linmod
 */
ve.dm.MWIndexForceMetaItem = function VeDmMWIndexForceMetaItem( element ) {
	// Parent constructor
	ve.dm.MetaItem.call( this, element );
};

/* Inheritance */

OO.inheritClass( ve.dm.MWIndexForceMetaItem, ve.dm.MetaItem );

/* Static Properties */

ve.dm.MWIndexForceMetaItem.static.name = 'mwIndexForce';

ve.dm.MWIndexForceMetaItem.static.group = 'mwIndex';

ve.dm.MWIndexForceMetaItem.static.matchTagNames = [ 'meta' ];

ve.dm.MWIndexForceMetaItem.static.matchRdfaTypes = [ 'mw:PageProp/index' ];

ve.dm.MWIndexForceMetaItem.static.toDataElement = function ( ) {
	return { type: this.name };
};

ve.dm.MWIndexForceMetaItem.static.toDomElements = function ( dataElement, doc ) {
	var meta = doc.createElement( 'meta' );
	meta.setAttribute( 'property', 'mw:PageProp/index' );
	return [ meta ];
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.MWIndexForceMetaItem );
