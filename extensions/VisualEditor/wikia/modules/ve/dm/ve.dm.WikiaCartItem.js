/*!
 * VisualEditor DataModel WikiaCartItem class.
 * @license The MIT License (MIT); see LICENSE.txt
 */

/* global mw */

/**
 * DataModel WikiaCartItem.
 *
 * @class
 * @constructor
 */
ve.dm.WikiaCartItem = function VeDmWikiaCartItem(
	title,
	url,
	type,
	temporaryFileName,
	provider,
	videoId,
	license
) {
	var titleParts = this.getTitleParts( title );

	// TODO: this.title should really be this.filename since it contains prefix & extension
	this.title = title;
	this.url = url;
	this.type = type;
	this.temporaryFileName = temporaryFileName;
	this.provider = provider;
	this.videoId = videoId;
	this.license = license;
	this.prefix = titleParts[1];
	this.basename = titleParts[2];
	this.extension = titleParts[3];
};

/**
 * Is this item temporary (was it added via url)?
 *
 * @method
 * @returns {boolean} True if the item is temporary, false otherwise.
 */
ve.dm.WikiaCartItem.prototype.isTemporary = function () {
	return !!this.temporaryFileName;
};

/**
 * Set the license.
 *
 * @method
 */
ve.dm.WikiaCartItem.prototype.setLicense = function ( license ) {
	this.license = license;
};

/**
 * @method
 * @description Takes a title name and returns it's parts
 * @param String A title passed in at invocation or the title stored in class instance
 * @returns {Array|null} Array of strings or null, the default return of String.prototype.match
 */
ve.dm.WikiaCartItem.prototype.getTitleParts = function ( title ) {
	return ( title || this.title ).match( /^([^:]*\:)?(.*?)(\.[^.]+)?$/ );
};

/**
 * @method
 * @description Sets title with special case for user-blanked input
 * @param {String} title May be full path (File:Example.jpg) or string for basename
 */
ve.dm.WikiaCartItem.prototype.setTitle = function ( title ) {
	var parts,
		prefix,
		basename,
		extension;

	parts = this.getTitleParts( title || mw.config.get( 'wgPageName' ) );
	prefix = parts[1] || this.prefix || '';
	basename = parts[2] || this.basename || '';
	extension = parts[3] || this.extension || '';

	this.title = prefix + basename + extension;
};

/**
 * @method
 * @description Gets the ID based on temporary or permanent file
 * @returns {String} Id string, either the temporary filename or the title
 */
ve.dm.WikiaCartItem.prototype.getId = function () {
	return this.isTemporary() ? this.temporaryFileName : this.title;
};

/**
 * @method
 * @description Makes a copy of this Wikia cart item
 * @returns {ve.dm.WikiaCartItem} Copy of Wikia cart item
 */
ve.dm.WikiaCartItem.prototype.clone = function () {
	return new ve.dm.WikiaCartItem (
		this.title,
		this.url,
		this.type,
		this.temporaryFileName,
		this.provider,
		this.videoId,
		this.license
	);
};
