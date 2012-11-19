/**
 * VisualEditor stand-alone initialization Target class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Stand-alone platform.
 *
 * @class
 * @constructor
 * @extends {ve.init.Platform}
 */
ve.init.sa.Platform = function VeInitSaPlatform() {
	// Parent constructor
	ve.init.Platform.call( this );

	// Properties
	this.externalLinkUrlProtocolsRegExp = /^https?\:\/\//;
	this.modulesUrl = 'extensions/VisualEditor/modules';
	this.messages = {};
};

/* Inheritance */

ve.inheritClass( ve.init.sa.Platform, ve.init.Platform );

/* Methods */

/**
 * Gets a regular expression that matches allowed external link URLs.
 *
 * @method
 * @returns {RegExp} Regular expression object
 */
ve.init.sa.Platform.prototype.getExternalLinkUrlProtocolsRegExp = function () {
	return this.externalLinkUrlProtocolsRegExp;
};

/**
 * Sets the remotely accessible URL to the modules directory.
 *
 * @method
 * @param {String} url Remote modules URL
 */
ve.init.sa.Platform.prototype.setModulesUrl = function ( url ) {
	this.modulesUrl = url;
};

/**
 * Gets a remotely accessible URL to the modules directory.
 *
 * @method
 * @returns {String} Remote modules URL
 */
ve.init.sa.Platform.prototype.getModulesUrl = function () {
	return this.modulesUrl;
};

/**
 * Adds multiple messages to the localization system.
 *
 * @method
 * @param {Object} messages Map of message-key/message-string pairs
 */
ve.init.sa.Platform.prototype.addMessages = function ( messages ) {
	for ( var key in messages ) {
		this.messages[key] = messages[key];
	}
};

/**
 * Gets a message from the localization system.
 *
 * @method
 * @param {String} key Message key
 * @param {Mixed} [...] List of arguments which will be injected at $1, $2, etc. in the messaage
 * @returns {String} Localized message
 */
ve.init.sa.Platform.prototype.getMessage = function ( key ) {
	if ( key in this.messages ) {
		// Simple message parser, does $N replacement and nothing else.
		var parameters = Array.prototype.slice.call( arguments, 1 );
		return this.messages[key].replace( /\$(\d+)/g, function ( str, match ) {
			var index = parseInt( match, 10 ) - 1;
			return parameters[index] !== undefined ? parameters[index] : '$' + match;
		} );
	}
	return '<' + key + '>';
};

/* Initialization */

ve.init.platform = new ve.init.sa.Platform();
