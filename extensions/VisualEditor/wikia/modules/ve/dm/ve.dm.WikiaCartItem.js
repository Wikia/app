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
 * Is this item temporary (was it uploaded)?
 *
 * @method
 * @returns {boolean} True if the item is temporary, false otherwise.
 */
ve.dm.WikiaCartItem.prototype.isTemporary = function () {
	return !!this.temporaryFileName;
};
