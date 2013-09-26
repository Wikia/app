/*!
 * VisualEditor DataModel MWCategoryMetaItem class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel category meta item.
 *
 * @class
 * @extends ve.dm.MetaItem
 * @constructor
 * @param {Object} element Reference to element in meta-linmod
 */
ve.dm.MWCategoryMetaItem = function VeDmMWCategoryMetaItem( element ) {
	// Parent constructor
	ve.dm.MetaItem.call( this, element );
};

/* Inheritance */

ve.inheritClass( ve.dm.MWCategoryMetaItem, ve.dm.MetaItem );

/* Static Properties */

ve.dm.MWCategoryMetaItem.static.name = 'mwCategory';

ve.dm.MWCategoryMetaItem.static.group = 'mwCategory';

ve.dm.MWCategoryMetaItem.static.matchTagNames = [ 'link' ];

ve.dm.MWCategoryMetaItem.static.matchRdfaTypes = [
	'mw:WikiLink/Category', // old type, pre-bug 53432
	'mw:PageProp/Category' // new type
];

ve.dm.MWCategoryMetaItem.static.toDataElement = function ( domElements ) {
	var firstDomElement = domElements[0],
		href = firstDomElement.getAttribute( 'href' ),
		/*jshint regexp:false */
		matches = href.match( /^((?:\.\.?\/)*)(.*?)(?:#(.*))?$/ ),
		rawSortkey = matches[3] || '';
	return {
		'type': 'mwCategory',
		'attributes': {
			'hrefPrefix': matches[1],
			'category': decodeURIComponent( matches[2] ).replace( /_/g, ' ' ),
			'origCategory': matches[2],
			'sortkey': decodeURIComponent( rawSortkey ).replace( /_/g, ' ' ),
			'origSortkey': rawSortkey
		}
	};
};

ve.dm.MWCategoryMetaItem.static.toDomElements = function ( dataElement, doc ) {
	var href,
		domElement = doc.createElement( 'link' ),
		hrefPrefix = dataElement.attributes.hrefPrefix || '',
		category = dataElement.attributes.category || '',
		sortkey = dataElement.attributes.sortkey || '',
		origCategory = dataElement.attributes.origCategory || '',
		origSortkey = dataElement.attributes.origSortkey || '',
		normalizedOrigCategory = decodeURIComponent( origCategory ).replace( /_/g, ' ' ),
		normalizedOrigSortkey = decodeURIComponent( origSortkey );
	if ( normalizedOrigSortkey === sortkey ) {
		sortkey = origSortkey;
	} else {
		sortkey = encodeURIComponent( sortkey );
	}
	if ( normalizedOrigCategory === category ) {
		category = origCategory;
	} else {
		category = encodeURIComponent( category );
	}
	domElement.setAttribute( 'rel', 'mw:WikiLink/Category' );
	href = hrefPrefix + category;
	if ( sortkey !== '' ) {
		href += '#' + sortkey;
	}
	domElement.setAttribute( 'href', href );
	return [ domElement ];
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.MWCategoryMetaItem );
