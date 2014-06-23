/*!
 * VisualEditor DataModel MWIndexDisableMetaItem class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel disable index meta item (for __NOINDEX__).
 *
 * @class
 * @extends ve.dm.MetaItem
 * @constructor
 * @param {Object} element Reference to element in meta-linmod
 */
ve.dm.MWIndexDisableMetaItem = function VeDmMWIndexDisableMetaItem( element ) {
	// Parent constructor
	ve.dm.MetaItem.call( this, element );
};

/* Inheritance */

OO.inheritClass( ve.dm.MWIndexDisableMetaItem, ve.dm.MetaItem );

/* Static Properties */

ve.dm.MWIndexDisableMetaItem.static.name = 'mwIndexDisable';

ve.dm.MWIndexDisableMetaItem.static.group = 'mwIndex';

ve.dm.MWIndexDisableMetaItem.static.matchTagNames = [ 'meta' ];

ve.dm.MWIndexDisableMetaItem.static.matchRdfaTypes = [ 'mw:PageProp/noindex' ];

ve.dm.MWIndexDisableMetaItem.static.toDataElement = function ( ) {
	return { 'type': this.name };
};

ve.dm.MWIndexDisableMetaItem.static.toDomElements = function ( dataElement, doc ) {
	var meta = doc.createElement( 'meta' );
	meta.setAttribute( 'property', 'mw:PageProp/noindex' );
	return [ meta ];
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.MWIndexDisableMetaItem );
