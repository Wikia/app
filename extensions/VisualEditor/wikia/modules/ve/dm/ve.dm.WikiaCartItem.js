/*!
 * VisualEditor DataModel WikiaCartItem class.
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel WikiaCartItem.
 *
 * @class
 * @constructor
 */
ve.dm.WikiaCartItem = function VeDmWikiaCartItem( title, url, type, temporaryFileName, provider, videoId ) {
	this.title = title;
	this.url = url;
	this.type = type;
	this.temporaryFileName = temporaryFileName;
	this.provider = provider;
	this.videoId = videoId;
};

/**
 * @method
 * @description Takes the previous title name and returns it's parts
 * @returns { Array | null } Array of strings or null, same out put as String.prototype.match
 */
ve.dm.WikiaCartItem.prototype.extractFilenameParts = function() {
	return this.title.match( /^(?:[^:]*\:)?(.*?)(\.[^.]+)?$/ );
};

/**
 * @method
 * @description Sets title with special case for user-blanked input
 */
ve.dm.WikiaCartItem.prototype.setTitle = function( title ) {
	var filenameParts = this.extractFilenameParts();
	if ( title === '' || typeof title === 'undefined' ) {
		title = mw.config.get( 'wgPageName' );
	}
	this.title = filenameParts ? title + filenameParts[ filenameParts.length - 1 ] : title;
};
