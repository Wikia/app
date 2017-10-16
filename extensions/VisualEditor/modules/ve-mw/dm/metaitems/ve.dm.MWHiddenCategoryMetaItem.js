/*!
 * VisualEditor DataModel MWHiddenCategoryMetaItem class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel hidden category meta item (for __HIDDENCAT__).
 *
 * @class
 * @extends ve.dm.MetaItem
 * @constructor
 * @param {Object} element Reference to element in meta-linmod
 */
ve.dm.MWHiddenCategoryMetaItem = function VeDmMWHiddenCategoryMetaItem( element ) {
	// Parent constructor
	ve.dm.MetaItem.call( this, element );
};

/* Inheritance */

OO.inheritClass( ve.dm.MWHiddenCategoryMetaItem, ve.dm.MetaItem );

/* Static Properties */

ve.dm.MWHiddenCategoryMetaItem.static.name = 'mwHiddenCategory';

ve.dm.MWHiddenCategoryMetaItem.static.group = 'mwHiddenCategory';

ve.dm.MWHiddenCategoryMetaItem.static.matchTagNames = [ 'meta' ];

ve.dm.MWHiddenCategoryMetaItem.static.matchRdfaTypes = [ 'mw:PageProp/hiddencat' ];

ve.dm.MWHiddenCategoryMetaItem.static.toDataElement = function ( ) {
	return { type: this.name };
};

ve.dm.MWHiddenCategoryMetaItem.static.toDomElements = function ( dataElement, doc ) {
	var meta = doc.createElement( 'meta' );
	meta.setAttribute( 'property', 'mw:PageProp/hiddencat' );
	return [ meta ];
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.MWHiddenCategoryMetaItem );
