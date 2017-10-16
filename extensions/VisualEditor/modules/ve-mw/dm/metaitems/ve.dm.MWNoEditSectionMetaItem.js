/*!
 * VisualEditor DataModel MWNoEditSectionMetaItem  class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel disable section edit links meta item.
 *
 * @class
 * @extends ve.dm.MetaItem
 * @constructor
 * @param {Object} element Reference to element in meta-linmod
 */
ve.dm.MWNoEditSectionMetaItem = function VeDmMWNoEditSectionMetaItem( element ) {
	// Parent constructor
	ve.dm.MetaItem.call( this, element );
};

/* Inheritance */

OO.inheritClass( ve.dm.MWNoEditSectionMetaItem, ve.dm.MetaItem );

/* Static Properties */

ve.dm.MWNoEditSectionMetaItem.static.name = 'mwNoEditSection';

ve.dm.MWNoEditSectionMetaItem.static.group = 'mwNoEditSection';

ve.dm.MWNoEditSectionMetaItem.static.matchTagNames = [ 'meta' ];

ve.dm.MWNoEditSectionMetaItem.static.matchRdfaTypes = [ 'mw:PageProp/noeditsection' ];

ve.dm.MWNoEditSectionMetaItem.static.toDomElements = function ( dataElement, doc ) {
	var meta = doc.createElement( 'meta' );
	meta.setAttribute( 'property', 'mw:PageProp/noeditsection' );
	return [ meta ];
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.MWNoEditSectionMetaItem );
