/*!
 * VisualEditor DataModel MWTOCForceMetaItem class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel force TOC meta item.
 *
 * @class
 * @extends ve.dm.MetaItem
 * @constructor
 * @param {Object} element Reference to element in meta-linmod
 */
ve.dm.MWTOCForceMetaItem = function VeDmMWTOCForceMetaItem( element ) {
	// Parent constructor
	ve.dm.MetaItem.call( this, element );
};

/* Inheritance */

OO.inheritClass( ve.dm.MWTOCForceMetaItem, ve.dm.MetaItem );

/* Static Properties */

ve.dm.MWTOCForceMetaItem.static.name = 'mwTOCForce';

ve.dm.MWTOCForceMetaItem.static.group = 'mwTOC';

ve.dm.MWTOCForceMetaItem.static.matchTagNames = [ 'meta' ];

ve.dm.MWTOCForceMetaItem.static.matchRdfaTypes = [ 'mw:PageProp/forcetoc' ];

ve.dm.MWTOCForceMetaItem.static.toDomElements = function ( dataElement, doc ) {
	var meta = doc.createElement( 'meta' );
	meta.setAttribute( 'property', 'mw:PageProp/forcetoc' );
	return [ meta ];
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.MWTOCForceMetaItem );
