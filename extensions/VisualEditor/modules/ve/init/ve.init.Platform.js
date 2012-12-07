/**
 * VisualEditor initialization Target class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Generic platform.
 *
 * @class
 * @abstract
 * @constructor
 * @extends {ve.EventEmitter}
 */
ve.init.Platform = function VeInitPlatform() {
	// Parent constructor
	ve.EventEmitter.call( this );
};

/* Inheritance */

ve.inheritClass( ve.init.Platform, ve.EventEmitter );

/* Methods */

/**
 * Gets a regular expression that matches allowed external link URLs.
 *
 * @method
 * @abstract
 * @returns {RegExp} Regular expression object
 */
ve.init.Platform.prototype.getExternalLinkUrlProtocolsRegExp = function () {
	throw new Error( 've.init.Platform.getExternalLinkUrlProtocolsRegExp must be overridden in subclass' );
};

/**
 * Gets a remotely accessible URL to the modules directory.
 *
 * @method
 * @abstract
 * @returns {String} Remote modules URL
 */
ve.init.Platform.prototype.getModulesUrl = function () {
	throw new Error( 've.init.Platform.getModulesUrl must be overridden in subclass' );
};

/**
 * Whether to use change markers
 *
 * @method
 * @returns {Boolean}
 */
ve.init.Platform.prototype.useChangeMarkers = function () {
	return true;
};

/**
 * Adds multiple messages to the localization system.
 *
 * @method
 * @abstract
 * @param {Object} messages Map of message-key/message-string pairs
 */
ve.init.Platform.prototype.addMessages = function () {
	throw new Error( 've.init.Platform.addMessages must be overridden in subclass' );
};

/**
 * Gets a message from the localization system.
 *
 * @method
 * @abstract
 * @param {String} key Message key
 * @param {Mixed} [...] List of arguments which will be injected at $1, $2, etc. in the messaage
 * @returns {String} Localized message
 */
ve.init.Platform.prototype.getMessage = function () {
	throw new Error( 've.init.Platform.getMessage must be overridden in subclass' );
};
