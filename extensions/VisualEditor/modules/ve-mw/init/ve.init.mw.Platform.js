/*!
 * VisualEditor MediaWiki Initialization Platform class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/*global mw */

/**
 * Initialization MediaWiki platform.
 *
 * @class
 * @extends ve.init.Platform
 *
 * @constructor
 */
ve.init.mw.Platform = function VeInitMwPlatform() {
	// Parent constructor
	ve.init.Platform.call( this );

	// Properties
	this.externalLinkUrlProtocolsRegExp = new RegExp( '^' + mw.config.get( 'wgUrlProtocols' ) );
	this.modulesUrl = mw.config.get( 'wgExtensionAssetsPath' ) + '/VisualEditor/modules';
	this.parsedMessages = {};
	this.mediaSources = [
		{ 'url': mw.util.wikiScript( 'api' ) },
		{ 'url': '//commons.wikimedia.org/w/api.php' }
	];
};

/* Inheritance */

ve.inheritClass( ve.init.mw.Platform, ve.init.Platform );

/* Methods */

/**
 * Get a regular expression that matches allowed external link URLs.
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
 * Get a remotely accessible URL to the modules directory.
 *
 * Uses MediaWiki's {wgExtensionAssetsPath} variable.
 *
 * @method
 * @returns {string} Remote modules URL
 */
ve.init.mw.Platform.prototype.getModulesUrl = function () {
	return this.modulesUrl;
};

/**
 * Add multiple messages to the localization system.
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
 * Get a message from the localization system.
 *
 * Wrapper for mw.msg system.
 *
 * @method
 * @param {string} key Message key
 * @param {Mixed...} [args] List of arguments which will be injected at $1, $2, etc. in the messaage
 * @returns {string} Localized message (plain, unescaped)
 */
ve.init.mw.Platform.prototype.getMessage = ve.bind( mw.msg, mw );

/**
 * Add multiple parsed messages to the localization system.
 *
 * @method
 * @param {Object} messages Map of message-key/html pairs
 */
ve.init.mw.Platform.prototype.addParsedMessages = function ( messages ) {
	for ( var key in messages ) {
		this.parsedMessages[key] = messages[key];
	}
};

/**
 * Get a parsed message as HTML string.
 *
 * Falls back to mw.messsage with .escaped().
 * Does not support $# replacements.
 *
 * @method
 * @param {string} key Message key
 * @returns {string} Parsed localized message as HTML string
 */
ve.init.mw.Platform.prototype.getParsedMessage = function ( key ) {
	if ( key in this.parsedMessages ) {
		// Prefer parsed results from VisualEditorMessagesModule.php if available.
		return this.parsedMessages[key];
	}
	// Fallback to regular messages, with mw.message html escaping applied.
	return mw.message( key ).escaped();
};

/**
 * Gets client platform string from browser.
 *
 * @method
 * @returns {string} Client platform string
 */
ve.init.mw.Platform.prototype.getSystemPlatform = function () {
	return $.client.profile().platform;
};

/**
 * Gets the user language from the browser.
 *
 * @method
 * @returns {string} User language string
 */
ve.init.mw.Platform.prototype.getUserLanguage = function () {
	return mw.config.get( 'wgUserLanguage' );
};

/**
 * Get a list of URLs to MediaWiki API entry points where media can be found.
 *
 * @method
 * @returns {string[]} API URLs
 */
ve.init.mw.Platform.prototype.getMediaSources = function () {
	return this.mediaSources;
};

/* Initialization */

ve.init.platform = new ve.init.mw.Platform();
