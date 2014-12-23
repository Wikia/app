/*!
 * VisualEditor MediaWiki Initialization Platform class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

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
	this.externalLinkUrlProtocolsRegExp = new RegExp(
		'^(' + mw.config.get( 'wgUrlProtocols' ) + ')'
	);
	this.parsedMessages = {};
	this.linkCache = new ve.init.mw.LinkCache();
};

/* Inheritance */

OO.inheritClass( ve.init.mw.Platform, ve.init.Platform );

/* Static Methods */

/** @inheritdoc */
ve.init.mw.Platform.static.getSystemPlatform = function () {
	return $.client.profile().platform;
};

/** @inheritdoc */
ve.init.mw.Platform.static.isInternetExplorer = function () {
	return $.client.profile().name === 'msie';
};

/* Methods */

/** @inheritdoc */
ve.init.mw.Platform.prototype.getExternalLinkUrlProtocolsRegExp = function () {
	return this.externalLinkUrlProtocolsRegExp;
};

/** @inheritdoc */
ve.init.mw.Platform.prototype.addMessages = function ( messages ) {
	return mw.messages.set( messages );
};

/**
 * @method
 * @inheritdoc
 */
ve.init.mw.Platform.prototype.getMessage = mw.msg.bind( mw );

/** @inheritdoc */
ve.init.mw.Platform.prototype.addParsedMessages = function ( messages ) {
	for ( var key in messages ) {
		this.parsedMessages[key] = messages[key];
	}
};

/** @inheritdoc */
ve.init.mw.Platform.prototype.getParsedMessage = function ( key ) {
	if ( Object.prototype.hasOwnProperty.call( this.parsedMessages, key ) ) {
		// Prefer parsed results from VisualEditorDataModule if available.
		return this.parsedMessages[key];
	}
	// Fallback to regular messages, with mw.message html escaping applied.
	return mw.message( key ).escaped();
};

/** @inheritdoc */
ve.init.mw.Platform.prototype.getLanguageCodes = function () {
	return Object.keys(
		mw.language.getData( mw.config.get( 'wgUserLanguage' ), 'languageNames' ) ||
		$.uls.data.getAutonyms()
	);
};

/** @inheritdoc */
ve.init.mw.Platform.prototype.getLanguageName = function ( code ) {
	var languageNames = mw.language.getData( mw.config.get( 'wgUserLanguage' ), 'languageNames' ) ||
		$.uls.data.getAutonyms();
	return languageNames[code] || '';
};

/**
 * @method
 * @inheritdoc
 */
ve.init.mw.Platform.prototype.getLanguageAutonym = $.uls.data.getAutonym;

/**
 * @method
 * @inheritdoc
 */
ve.init.mw.Platform.prototype.getLanguageDirection = $.uls.data.getDir;

/** @inheritdoc */
ve.init.mw.Platform.prototype.getUserLanguages = function () {
	// Wikia change
	return [ mw.config.get( 'wgUserLanguage' ), mw.config.get( 'wgContentLanguage' ) ];
	//return mw.language.getFallbackLanguageChain();
};

/* Initialization */

ve.init.platform = new ve.init.mw.Platform();

/* Extension */

OO.ui.getUserLanguages = ve.init.platform.getUserLanguages.bind( ve.init.platform );

OO.ui.msg = ve.init.platform.getMessage.bind( ve.init.platform );
