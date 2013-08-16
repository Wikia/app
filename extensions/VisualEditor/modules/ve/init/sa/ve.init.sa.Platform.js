/*!
 * VisualEditor Standalone Initialization Platform class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Initialization Standalone platform.
 *
 * @class
 * @extends ve.init.Platform
 *
 * @constructor
 */
ve.init.sa.Platform = function VeInitSaPlatform() {
	// Parent constructor
	ve.init.Platform.call( this );

	// Properties
	this.externalLinkUrlProtocolsRegExp = /^https?\:\/\//;
	this.modulesUrl = 'extensions/VisualEditor/modules';
	this.messages = {};
	this.parsedMessages = {};
};

/* Inheritance */

ve.inheritClass( ve.init.sa.Platform, ve.init.Platform );

/* Methods */

/**
 * Get a regular expression that matches allowed external link URLs.
 *
 * @method
 * @returns {RegExp} Regular expression object
 */
ve.init.sa.Platform.prototype.getExternalLinkUrlProtocolsRegExp = function () {
	return this.externalLinkUrlProtocolsRegExp;
};

/**
 * Set the remotely accessible URL to the modules directory.
 *
 * @method
 * @param {string} url Remote modules URL
 */
ve.init.sa.Platform.prototype.setModulesUrl = function ( url ) {
	this.modulesUrl = url;
};

/**
 * Get a remotely accessible URL to the modules directory.
 *
 * @method
 * @returns {string} Remote modules URL
 */
ve.init.sa.Platform.prototype.getModulesUrl = function () {
	return this.modulesUrl;
};

/**
 * Add multiple messages to the localization system.
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
 * Get a message from the localization system.
 *
 * @method
 * @param {string} key Message key
 * @param {Mixed...} [args] List of arguments which will be injected at $1, $2, etc. in the messaage
 * @returns {string} Localized message
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

/**
 * Add multiple parsed messages to the localization system.
 *
 * @method
 * @param {Object} messages Map of message-key/html pairs
 */
ve.init.sa.Platform.prototype.addParsedMessages = function ( messages ) {
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
ve.init.sa.Platform.prototype.getParsedMessage = function ( key ) {
	if ( key in this.parsedMessages ) {
		// Prefer parsed results from VisualEditorMessagesModule.php if available.
		return this.parsedMessages[key];
	}
	// Fallback to regular messages, html escaping applied.
	return this.getMessage( key ).replace( /['"<>&]/g, function escapeCallback( s ) {
		switch ( s ) {
			case '\'':
				return '&#039;';
			case '"':
				return '&quot;';
			case '<':
				return '&lt;';
			case '>':
				return '&gt;';
			case '&':
				return '&amp;';
		}
	} );
};

/**
 * Gets client platform string from browser.
 *
 * @method
 * @returns {string} Client platform string
 */
ve.init.sa.Platform.prototype.getSystemPlatform = function () {
	var platforms = ['win', 'mac', 'linux', 'sunos', 'solaris', 'iphone'],
		match = new RegExp( '(' + platforms.join( '|' ) + ')' ).exec( window.navigator.platform.toLowerCase() );
	if ( match ) {
		return match[1];
	}
};

/**
 * Gets the user language from the browser.
 *
 * @method
 * @returns {string} User language string
 */
ve.init.sa.Platform.prototype.getUserLanguage = function () {
	// IE or Firefox Safari Opera
	var lang = window.navigator.userLanguage || window.navigator.language;
	return lang.split( '-' )[0];
};

/* Initialization */

ve.init.platform = new ve.init.sa.Platform();
