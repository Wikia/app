/*!
 * VisualEditor DataModel MWStaticRedirectMetaItem class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel enable static redirect meta item.
 *
 * @class
 * @extends ve.dm.MetaItem
 * @constructor
 * @param {Object} element Reference to element in meta-linmod
 */
ve.dm.MWStaticRedirectMetaItem = function VeDmMWStaticRedirectMetaItem( element ) {
	// Parent constructor
	ve.dm.MetaItem.call( this, element );
};

/* Inheritance */

OO.inheritClass( ve.dm.MWStaticRedirectMetaItem, ve.dm.MetaItem );

/* Static Properties */

ve.dm.MWStaticRedirectMetaItem.static.name = 'mwStaticRedirect';

ve.dm.MWStaticRedirectMetaItem.static.group = 'mwStaticRedirect';

ve.dm.MWStaticRedirectMetaItem.static.matchTagNames = [ 'meta' ];

ve.dm.MWStaticRedirectMetaItem.static.matchRdfaTypes = [ 'mw:PageProp/staticredirect' ];

ve.dm.MWStaticRedirectMetaItem.static.toDataElement = function ( ) {
	return { 'type': this.name };
};

ve.dm.MWStaticRedirectMetaItem.static.toDomElements = function ( dataElement, doc ) {
	var meta = doc.createElement( 'meta' );
	meta.setAttribute( 'property', 'mw:PageProp/staticredirect' );
	return [ meta ];
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.MWStaticRedirectMetaItem );
