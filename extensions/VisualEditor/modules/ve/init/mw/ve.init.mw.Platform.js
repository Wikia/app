/*global mw */

/**
 * VisualEditor MediaWiki initialization Target class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * MediaWiki platform.
 *
 * @class
 * @constructor
 * @extends {ve.init.Platform}
 */
ve.init.mw.Platform = function VeInitMwPlatform() {
	// Parent constructor
	ve.init.Platform.call( this );

	// Properties
	this.externalLinkUrlProtocolsRegExp = new RegExp( '^' + mw.config.get( 'wgUrlProtocols' ) );
	this.modulesUrl = mw.config.get( 'wgExtensionAssetsPath' ) + '/VisualEditor/modules';
};

/* Inheritance */

ve.inheritClass( ve.init.mw.Platform, ve.init.Platform );

/* Methods */

/**
 * Gets a regular expression that matches allowed external link URLs.
 *
 * Uses the mw.config wgUrlProtocols variable.
 *
 * @method
 * @returns {RegExp} Regular expression object
 */
ve.init.mw.Platform.prototype.getExternalLinkUrlProtocolsRegExp = function () {
	return this.externalLinkUrlProtocolsRegExp;
};

/**
 * Gets a remotely accessible URL to the modules directory.
 *
 * Uses MediaWiki's {wgExtensionAssetsPath} variable.
 *
 * @method
 * @returns {String} Remote modules URL
 */
ve.init.mw.Platform.prototype.getModulesUrl = function () {
	return this.modulesUrl;
};

/**
 * Whether to use change markers.
 *
 * Uses the vechangemarkers query string variable.
 *
 * @method
 * @return {Boolean}
 */
ve.init.mw.Platform.prototype.useChangeMarkers = function () {
	var currentUri = new mw.Uri( window.location.toString() );
	if ( currentUri && 'vechangemarkers' in currentUri.query ) {
		return true;
	}
	return false;
};

/**
 * Adds multiple messages to the localization system.
 *
 * Wrapper for mw.msg system.
 *
 * @method
 * @param {Object} messages Map of message-key/message-string pairs
 */
ve.init.mw.Platform.prototype.addMessages = function ( messages ) {
	return mw.messages.set( messages );
};

/**
 * Gets a message from the localization system.
 *
 * Wrapper for mw.msg system.
 *
 * @method
 * @param {String} key Message key
 * @param {Mixed} [...] List of arguments which will be injected at $1, $2, etc. in the messaage
 * @returns {String} Localized message
 */
ve.init.mw.Platform.prototype.getMessage = function () {
	return mw.msg.apply( mw.msg, arguments );
};

/* Initialization */

ve.init.platform = new ve.init.mw.Platform();
