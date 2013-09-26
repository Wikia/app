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

/** @inheritdoc */
ve.init.sa.Platform.prototype.getExternalLinkUrlProtocolsRegExp = function () {
	return this.externalLinkUrlProtocolsRegExp;
};

/**
 * Set the remotely accessible URL to the modules directory.
 *
 * @param {string} url Remote modules URL
 */
ve.init.sa.Platform.prototype.setModulesUrl = function ( url ) {
	this.modulesUrl = url;
};

/** @inheritdoc */
ve.init.sa.Platform.prototype.getModulesUrl = function () {
	return this.modulesUrl;
};


/** @inheritdoc */
ve.init.sa.Platform.prototype.addMessages = function ( messages ) {
	for ( var key in messages ) {
		this.messages[key] = messages[key];
	}
};

/** @inheritdoc */
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

/** @inheritdoc */
ve.init.sa.Platform.prototype.addParsedMessages = function ( messages ) {
	for ( var key in messages ) {
		this.parsedMessages[key] = messages[key];
	}
};

/** @inheritdoc */
ve.init.sa.Platform.prototype.getParsedMessage = function ( key ) {
	if ( key in this.parsedMessages ) {
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
ve.init.sa.Platform.prototype.getSystemPlatform = function () {
	var platforms = ['win', 'mac', 'linux', 'sunos', 'solaris', 'iphone'],
		match = new RegExp( '(' + platforms.join( '|' ) + ')' ).exec( window.navigator.platform.toLowerCase() );
	if ( match ) {
		return match[1];
	}
};

/** @inheritdoc */
ve.init.sa.Platform.prototype.getUserLanguages = function () {
	// IE or Firefox Safari Opera
	var lang = window.navigator.userLanguage || window.navigator.language,
		langParts = lang.split( '-' ),
		langs = [ lang ];

	if ( langParts.length > 0 ) {
		langs.push( langParts[0] );
	}

	return langs;
};

/* Initialization */

ve.init.platform = new ve.init.sa.Platform();
