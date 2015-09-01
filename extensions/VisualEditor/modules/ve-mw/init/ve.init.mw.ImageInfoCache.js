/*!
 * VisualEditor MediaWiki Initialization ImageInfoCache class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Get information about images.
 *
 * @class
 * @extends ve.init.mw.ApiResponseCache
 * @constructor
 */
ve.init.mw.ImageInfoCache = function VeInitMwImageInfoCache() {
	ve.init.mw.ImageInfoCache.super.call( this );
};

/* Inheritance */

OO.inheritClass( ve.init.mw.ImageInfoCache, ve.init.mw.ApiResponseCache );

/* Static methods */

/**
 * @inheritdoc
 */
ve.init.mw.ImageInfoCache.static.processPage = function ( page ) {
	if ( page.imageinfo ) {
		return page.imageinfo[ 0 ];
	}
};

/* Methods */

/**
 * @inheritdoc
 */
ve.init.mw.ImageInfoCache.prototype.getRequestPromise = function ( subqueue ) {
	return new mw.Api().get(
		{
			action: 'query',
			prop: 'imageinfo',
			indexpageids: '1',
			iiprop: 'size|mediatype',
			titles: subqueue.join( '|' )
		},
		{ type: 'POST' }
	);
};
