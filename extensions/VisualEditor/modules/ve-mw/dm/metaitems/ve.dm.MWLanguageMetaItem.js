/*!
 * VisualEditor DataModel MWLanguageMetaItem class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel language meta item.
 *
 * @class
 * @extends ve.dm.MetaItem
 * @constructor
 * @param {Object} element Reference to element in meta-linmod
 */
ve.dm.MWLanguageMetaItem = function VeDmMWLanguageMetaItem( element ) {
	// Parent constructor
	ve.dm.MetaItem.call( this, element );
};

/* Inheritance */

ve.inheritClass( ve.dm.MWLanguageMetaItem, ve.dm.MetaItem );

/* Static Properties */

ve.dm.MWLanguageMetaItem.static.name = 'mwLanguage';

ve.dm.MWLanguageMetaItem.static.matchTagNames = [ 'link' ];

ve.dm.MWLanguageMetaItem.static.matchRdfaTypes = [
	'mw:WikiLink/Language', // old type, pre-bug 53432
	'mw:PageProp/Language' // new type
];

ve.dm.MWLanguageMetaItem.static.toDataElement = function ( domElements ) {
	var firstDomElement = domElements[0],
		href = firstDomElement.getAttribute( 'href' );
	return {
		'type': 'mwLanguage',
		'attributes': {
			'href': href
		}
	};
};

ve.dm.MWLanguageMetaItem.static.toDomElements = function ( dataElement, doc ) {
	var domElement = doc.createElement( 'link' );
	domElement.setAttribute( 'rel', 'mw:WikiLink/Language' );
	domElement.setAttribute( 'href', dataElement.attributes.href );
	return [ domElement ];
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.MWLanguageMetaItem );
