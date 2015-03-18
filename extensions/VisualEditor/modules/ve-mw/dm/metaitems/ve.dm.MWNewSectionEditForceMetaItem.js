/*!
 * VisualEditor DataModel MWNewSectionEditForceMetaItem class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel force new section edit link meta item (for __NEWSECTIONLINK__).
 *
 * @class
 * @extends ve.dm.MetaItem
 * @constructor
 * @param {Object} element Reference to element in meta-linmod
 */
ve.dm.MWNewSectionEditForceMetaItem = function VeDmMWNewSectionEditForceMetaItem( element ) {
	// Parent constructor
	ve.dm.MetaItem.call( this, element );
};

/* Inheritance */

OO.inheritClass( ve.dm.MWNewSectionEditForceMetaItem, ve.dm.MetaItem );

/* Static Properties */

ve.dm.MWNewSectionEditForceMetaItem.static.name = 'mwNewSectionEditForce';

ve.dm.MWNewSectionEditForceMetaItem.static.group = 'mwNewSectionEdit';

ve.dm.MWNewSectionEditForceMetaItem.static.matchTagNames = [ 'meta' ];

ve.dm.MWNewSectionEditForceMetaItem.static.matchRdfaTypes = [ 'mw:PageProp/newsectionlink' ];

ve.dm.MWNewSectionEditForceMetaItem.static.toDataElement = function ( ) {
	return { type: this.name };
};

ve.dm.MWNewSectionEditForceMetaItem.static.toDomElements = function ( dataElement, doc ) {
	var meta = doc.createElement( 'meta' );
	meta.setAttribute( 'property', 'mw:PageProp/newsectionlink' );
	return [ meta ];
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.MWNewSectionEditForceMetaItem );
