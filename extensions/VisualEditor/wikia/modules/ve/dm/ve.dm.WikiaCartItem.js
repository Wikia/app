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
	var filenameParts = this.extractFilenameParts( this.title );
	// TODO: this.title should really be this.filename since it contains prefix & extension
	this.title = title;
	this.url = url;
	this.type = type;
	this.temporaryFileName = temporaryFileName;
	this.provider = provider;
	this.videoId = videoId;

	this.prefix = filenameParts[1];
	this.basename = filenameParts[2];
	this.extension = filenameParts[3];
};

/**
 * @method
 * @description Takes a title name and returns it's parts
 * @param String A title passed in at invocation or the title stored in class instance
 * @returns {Array|null} Array of strings or null, the default return of String.prototype.match
 */
ve.dm.WikiaCartItem.prototype.extractFilenameParts = function( title ) {
	return ( title || this.title ).match( /^([^:]*\:)?(.*?)(\.[^.]+)?$/ );
};

/**
 * @method
 * @description Sets title with special case for user-blanked input
 */
ve.dm.WikiaCartItem.prototype.setTitle = function( title ) {
	var parts,
			prefix,
			basename,
			extension;

	if ( typeof title === 'number' ) {
		title = title.toString();
	}

	parts = this.extractFilenameParts( title || mw.config.get( 'wgPageName' ) );
	prefix = parts[1] || this.prefix || '';
	basename = parts[2] || this.basename || '';
	extension = parts[3] || this.extension || '';

	this.title = prefix + basename + extension;
};
