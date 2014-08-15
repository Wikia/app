/*!
 * VisualEditor DataModel MWTOCDisableMetaItem class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel disable TOC meta item.
 *
 * @class
 * @extends ve.dm.MetaItem
 * @constructor
 * @param {Object} element Reference to element in meta-linmod
 */
ve.dm.MWTOCDisableMetaItem = function VeDmMWTOCDisableMetaItem( element ) {
	// Parent constructor
	ve.dm.MetaItem.call( this, element );
};

/* Inheritance */

OO.inheritClass( ve.dm.MWTOCDisableMetaItem, ve.dm.MetaItem );

/* Static Properties */

ve.dm.MWTOCDisableMetaItem.static.name = 'mwTOCDisable';

ve.dm.MWTOCDisableMetaItem.static.group = 'mwTOC';

ve.dm.MWTOCDisableMetaItem.static.matchTagNames = [ 'meta' ];

ve.dm.MWTOCDisableMetaItem.static.matchRdfaTypes = [ 'mw:PageProp/notoc' ];

ve.dm.MWTOCDisableMetaItem.static.toDomElements = function ( dataElement, doc ) {
	var meta = doc.createElement( 'meta' );
	meta.setAttribute( 'property', 'mw:PageProp/notoc' );
	return [ meta ];
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.MWTOCDisableMetaItem );
