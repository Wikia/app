/*!
 * VisualEditor DataModel WikiaImageCartItem class.
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel WikiaImageCartItem.
 *
 * @class
 * @constructor
 * @param {String} title Image title
 * @param {String} url Url to the image thumbnail
 */
ve.dm.WikiaImageCartItem = function VeDmWikiaImageCartItem( title, url ) {
	this.title = title;
	this.url = url;
};

/**
 * @method
 * @returns {String} Id string
 */
ve.dm.WikiaImageCartItem.prototype.getId = function () {
	return this.title;
};
