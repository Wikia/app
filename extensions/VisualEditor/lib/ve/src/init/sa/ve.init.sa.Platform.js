/*!
 * VisualEditor Standalone Initialization Platform class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
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
	this.messagePaths = [];
	this.parsedMessages = {};
	this.userLanguages = ['en'];
};

/* Inheritance */

OO.inheritClass( ve.init.sa.Platform, ve.init.Platform );

/* Methods */

/** @inheritdoc */
ve.init.sa.Platform.prototype.getExternalLinkUrlProtocolsRegExp = function () {
	return this.externalLinkUrlProtocolsRegExp;
};

/**
 * Add an i18n message folder path
 *
 * @param {string} path Message folder path
 */
ve.init.sa.Platform.prototype.addMessagePath = function ( path ) {
	this.messagePaths.push( path );
};

/**
 * Get message folder paths
 *
 * @returns {string[]} Message folder paths
 */
ve.init.sa.Platform.prototype.getMessagePaths = function () {
	return this.messagePaths;
};

/** @inheritdoc */
ve.init.sa.Platform.prototype.addMessages = function ( messages ) {
	$.i18n().load( messages, $.i18n().locale );
};

/**
 * @method
 * @inheritdoc
 */
ve.init.sa.Platform.prototype.getMessage = $.i18n;

/** @inheritdoc */
ve.init.sa.Platform.prototype.addParsedMessages = function ( messages ) {
	for ( var key in messages ) {
		this.parsedMessages[key] = messages[key];
	}
};

/** @inheritdoc */
ve.init.sa.Platform.prototype.getParsedMessage = function ( key ) {
	if ( Object.prototype.hasOwnProperty.call( this.parsedMessages, key ) ) {
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

/** @inheritdoc */
ve.init.sa.Platform.prototype.getLanguageCodes = function () {
	return Object.keys( $.uls.data.getAutonyms() );
};

/**
 * @method
 * @inheritdoc
 */
ve.init.sa.Platform.prototype.getLanguageName = $.uls.data.getAutonym;

/**
 * @method
 * @inheritdoc
 */
ve.init.sa.Platform.prototype.getLanguageAutonym = $.uls.data.getAutonym;

/**
 * @method
 * @inheritdoc
 */
ve.init.sa.Platform.prototype.getLanguageDirection = $.uls.data.getDir;

/** @inheritdoc */
ve.init.sa.Platform.prototype.getUserLanguages = function () {
	return this.userLanguages;
};

/** @inheritdoc */
ve.init.sa.Platform.prototype.initialize = function () {
	var i, iLen, j, jLen, partialLocale, localeParts, filename, deferred,
		messagePaths = this.getMessagePaths(),
		locale = $.i18n().locale,
		languages = [ locale, 'en' ], // Always use 'en' as the final fallback
		languagesCovered = {},
		promises = [],
		fallbacks = $.i18n.fallbacks[locale];

	if ( !fallbacks ) {
		// Try to find something that has fallbacks (which means it's a language we know about)
		// by stripping things from the end. But collect all the intermediate ones in case we
		// go past languages that don't have fallbacks but do exist.
		localeParts = locale.split( '-' );
		localeParts.pop();
		while ( localeParts.length && !fallbacks ) {
			partialLocale = localeParts.join( '-' );
			languages.push( partialLocale );
			fallbacks = $.i18n.fallbacks[partialLocale];
			localeParts.pop();
		}
	}

	if ( fallbacks ) {
		languages = languages.concat( fallbacks );
	}

	this.userLanguages = languages;

	for ( i = 0, iLen = languages.length; i < iLen; i++ ) {
		if ( languagesCovered[languages[i]] ) {
			continue;
		}
		languagesCovered[languages[i]] = true;

		// Lower-case the language code for the filename. jQuery.i18n does not case-fold
		// language codes, so we should not case-fold the second argument in #load.
		filename = languages[i].toLowerCase() + '.json';

		for ( j = 0, jLen = messagePaths.length; j < jLen; j++ ) {
			deferred = $.Deferred();
			$.i18n().load( messagePaths[j] + filename, languages[i] )
				.always( deferred.resolve );
			promises.push( deferred.promise() );
		}
	}
	return $.when.apply( $, promises );
};

/* Initialization */

ve.init.platform = new ve.init.sa.Platform();

/* Extension */

OO.ui.getUserLanguages = ve.init.platform.getUserLanguages.bind( ve.init.platform );

OO.ui.msg = ve.init.platform.getMessage.bind( ve.init.platform );
