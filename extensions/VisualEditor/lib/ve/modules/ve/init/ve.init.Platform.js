/*!
 * VisualEditor Initialization Platform class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Generic Initialization platform.
 *
 * @abstract
 * @mixins OO.EventEmitter
 *
 * @constructor
 */
ve.init.Platform = function VeInitPlatform() {
	// Mixin constructors
	OO.EventEmitter.call( this );
};

/* Inheritance */

OO.mixinClass( ve.init.Platform, OO.EventEmitter );

/* Methods */

/**
 * Get a regular expression that matches allowed external link URLs.
 *
 * @method
 * @abstract
 * @returns {RegExp} Regular expression object
 */
ve.init.Platform.prototype.getExternalLinkUrlProtocolsRegExp = function () {
	throw new Error( 've.init.Platform.getExternalLinkUrlProtocolsRegExp must be overridden in subclass' );
};

/**
 * Get a remotely accessible URL to the modules directory.
 *
 * @method
 * @abstract
 * @returns {string} Remote modules URL
 */
ve.init.Platform.prototype.getModulesUrl = function () {
	throw new Error( 've.init.Platform.getModulesUrl must be overridden in subclass' );
};

/**
 * Add multiple messages to the localization system.
 *
 * @method
 * @abstract
 * @param {Object} messages Containing plain message values
 */
ve.init.Platform.prototype.addMessages = function () {
	throw new Error( 've.init.Platform.addMessages must be overridden in subclass' );
};

/**
 * Get a message from the localization system.
 *
 * @method
 * @abstract
 * @param {string} key Message key
 * @param {Mixed...} [args] List of arguments which will be injected at $1, $2, etc. in the messaage
 * @returns {string} Localized message, or key or '<' + key + '>' if message not found
 */
ve.init.Platform.prototype.getMessage = function () {
	throw new Error( 've.init.Platform.getMessage must be overridden in subclass' );
};

/**
 * Add multiple parsed messages to the localization system.
 *
 * @method
 * @abstract
 * @param {Object} messages Map of message-key/html pairs
 */
ve.init.Platform.prototype.addParsedMessages = function () {
	throw new Error( 've.init.Platform.addParsedMessages must be overridden in subclass' );
};

/**
 * Get a parsed message as HTML string.
 *
 * Does not support $# replacements.
 *
 * @method
 * @abstract
 * @param {string} key Message key
 * @returns {string} Parsed localized message as HTML string
 */
ve.init.Platform.prototype.getParsedMessage = function () {
	throw new Error( 've.init.Platform.getParsedMessage must be overridden in subclass' );
};

/**
 * Get client platform string from browser.
 *
 * @method
 * @abstract
 * @returns {string} Client platform string
 */
ve.init.Platform.prototype.getSystemPlatform = function () {
	throw new Error( 've.init.Platform.getSystemPlatform must be overridden in subclass' );
};

/**
 * Get the user language and any fallback languages.
 *
 * @method
 * @abstract
 * @returns {string[]} User language strings
 */
ve.init.Platform.prototype.getUserLanguages = function () {
	throw new Error( 've.init.Platform.getUserLanguages must be overridden in subclass' );
};

/**
 * Get a list of URL entry points where media can be found.
 *
 * @method
 * @abstract
 * @returns {string[]} API URLs
 */
ve.init.Platform.prototype.getMediaSources = function () {
	throw new Error( 've.init.Platform.getMediaSources must be overridden in subclass' );
};

/**
 * Get a list of all language codes.
 *
 * @method
 * @abstract
 * @returns {string[]} Language codes
 */
ve.init.Platform.prototype.getLanguageCodes = function () {
	throw new Error( 've.init.Platform.getLanguageCodes must be overridden in subclass' );
};

/**
 * Get a language's name from its code, in the current user language if possible.
 *
 * @method
 * @abstract
 * @param {string} code Language code
 * @returns {string} Language name
 */
ve.init.Platform.prototype.getLanguageName = function () {
	throw new Error( 've.init.Platform.getLanguageName must be overridden in subclass' );
};

/**
 * Get a language's autonym from its code.
 *
 * @method
 * @abstract
 * @param {string} code Language code
 * @returns {string} Language autonym
 */
ve.init.Platform.prototype.getLanguageAutonym = function () {
	throw new Error( 've.init.Platform.getLanguageAutonym must be overridden in subclass' );
};

/**
 * Get a language's direction from its code.
 *
 * @method
 * @abstract
 * @param {string} code Language code
 * @returns {string} Language direction
 */
ve.init.Platform.prototype.getLanguageDirection = function () {
	throw new Error( 've.init.Platform.getLanguageDirection must be overridden in subclass' );
};

/**
 * Initialize the platform. The default implementation is to do nothing and return a resolved
 * promise. Subclasses should override this if they have asynchronous initialization work to do.
 *
 * External callers should not call this. Instead, call #getInitializedPromise.
 *
 * @private
 * @returns {jQuery.Promise} Promise that will be resolved once initialization is done
 */
ve.init.Platform.prototype.initialize = function () {
	return $.Deferred().resolve().promise();
};

/**
 * Get a promise to track when the platform has initialized. The platform won't be ready for use
 * until this promise is resolved.
 *
 * Since the initialization only happens once, and the same (resolved) promise
 * is returned when called again, and since the Platform instance is global
 * (shared between different Target instances) it is important not to rely
 * on this promise being asynchronous.
 *
 * @returns {jQuery.Promise} Promise that will be resolved once the platform is ready
 */
ve.init.Platform.prototype.getInitializedPromise = function () {
	if ( !this.initialized ) {
		this.initialized = this.initialize();
	}
	return this.initialized;
};
