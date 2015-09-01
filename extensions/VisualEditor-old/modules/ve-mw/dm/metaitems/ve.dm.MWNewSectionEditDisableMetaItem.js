/*!
 * VisualEditor DataModel MWNewSectionEditDisableMetaItem class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel disable new section edit link meta item (for __NONEWSECTIONLINK__).
 *
 * @class
 * @extends ve.dm.MetaItem
 * @constructor
 * @param {Object} element Reference to element in meta-linmod
 */
ve.dm.MWNewSectionEditDisableMetaItem = function VeDmMWNewSectionEditDisableMetaItem( element ) {
	// Parent constructor
	ve.dm.MetaItem.call( this, element );
};

/* Inheritance */

OO.inheritClass( ve.dm.MWNewSectionEditDisableMetaItem, ve.dm.MetaItem );

/* Static Properties */

ve.dm.MWNewSectionEditDisableMetaItem.static.name = 'mwNewSectionEditDisable';

ve.dm.MWNewSectionEditDisableMetaItem.static.group = 'mwNewSectionEdit';

ve.dm.MWNewSectionEditDisableMetaItem.static.matchTagNames = [ 'meta' ];

ve.dm.MWNewSectionEditDisableMetaItem.static.matchRdfaTypes = [ 'mw:PageProp/nonewsectionlink' ];

ve.dm.MWNewSectionEditDisableMetaItem.static.toDataElement = function ( ) {
	return { type: this.name };
};

ve.dm.MWNewSectionEditDisableMetaItem.static.toDomElements = function ( dataElement, doc ) {
	var meta = doc.createElement( 'meta' );
	meta.setAttribute( 'property', 'mw:PageProp/nonewsectionlink' );
	return [ meta ];
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.MWNewSectionEditDisableMetaItem );
