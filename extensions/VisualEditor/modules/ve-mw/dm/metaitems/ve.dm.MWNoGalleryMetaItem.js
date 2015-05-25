/*!
 * VisualEditor DataModel MWNoGalleryMetaItem class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel disable gallery meta item (for __NOGALLERY__).
 *
 * @class
 * @extends ve.dm.MetaItem
 * @constructor
 * @param {Object} element Reference to element in meta-linmod
 */
ve.dm.MWNoGalleryMetaItem = function VeDmMWNoGalleryMetaItem( element ) {
	// Parent constructor
	ve.dm.MetaItem.call( this, element );
};

/* Inheritance */

OO.inheritClass( ve.dm.MWNoGalleryMetaItem, ve.dm.MetaItem );

/* Static Properties */

ve.dm.MWNoGalleryMetaItem.static.name = 'mwNoGallery';

ve.dm.MWNoGalleryMetaItem.static.group = 'mwNoGallery';

ve.dm.MWNoGalleryMetaItem.static.matchTagNames = [ 'meta' ];

ve.dm.MWNoGalleryMetaItem.static.matchRdfaTypes = [ 'mw:PageProp/nogallery' ];

ve.dm.MWNoGalleryMetaItem.static.toDataElement = function ( ) {
	return { type: this.name };
};

ve.dm.MWNoGalleryMetaItem.static.toDomElements = function ( dataElement, doc ) {
	var meta = doc.createElement( 'meta' );
	meta.setAttribute( 'property', 'mw:PageProp/nogallery' );
	return [ meta ];
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.MWNoGalleryMetaItem );
