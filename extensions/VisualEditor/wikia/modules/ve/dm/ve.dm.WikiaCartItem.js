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
	var filenameParts = this.title.match( /^(?:[^:]*\:)?(.*?)(\.[^.]+)?$/ );
	return filenameParts ? filenameParts[ filenameParts.length - 1 ] : filenameParts;
};

/**
 * @method
 * @description Sets title with special case for user-blanked input
 */
ve.dm.WikiaCartItem.prototype.setTitle = function( title ) {
	var extension = this.extractFilenameParts();
	if ( !title ) {
		title = mw.config.get( 'wgPageName' );
	}
	this.title = extension ? title + extension : title;
};
