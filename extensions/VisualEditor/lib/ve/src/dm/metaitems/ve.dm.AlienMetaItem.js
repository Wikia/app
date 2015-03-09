/*!
 * VisualEditor DataModel AlienMetaItem class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * DataModel alien meta item.
 *
 * @class
 * @extends ve.dm.MetaItem
 * @constructor
 * @param {Object} element Reference to element in meta-linmod
 */
ve.dm.AlienMetaItem = function VeDmAlienMetaItem() {
	// Parent constructor
	ve.dm.AlienMetaItem.super.apply( this, arguments );
};

/* Inheritance */

OO.inheritClass( ve.dm.AlienMetaItem, ve.dm.MetaItem );

/* Static Properties */

ve.dm.AlienMetaItem.static.name = 'alienMeta';

ve.dm.AlienMetaItem.static.matchTagNames = [ 'meta', 'link' ];

ve.dm.AlienMetaItem.static.storeHtmlAttributes = false;

ve.dm.AlienMetaItem.static.toDataElement = function ( domElements ) {
	return {
		type: this.name,
		attributes: {
			domElements: ve.copy( domElements )
		}
	};
};

ve.dm.AlienMetaItem.static.toDomElements = function ( dataElement, doc ) {
	return ve.copyDomElements( dataElement.attributes.domElements, doc );
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.AlienMetaItem );
