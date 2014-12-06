/*!
 * VisualEditor MediaWiki Initialization VenusViewPageTarget class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Initialization MediaWiki view page target.
 *
 * @class
 * @extends ve.init.mw.WikiaViewPageTarget
 *
 * @constructor
 */
ve.init.mw.VenusViewPageTarget = function VeInitMwVenusViewPageTarget() {
	// Parent constructor
	ve.init.mw.VenusViewPageTarget.super.call( this );

	// This is used to trigger code after a CSS animation.
	// Its value matches the animation speed in extensions/wikia/Venus/styles/visualeditor.scss
	this.timeout = 500;
};

/* Inheritance */

OO.inheritClass( ve.init.mw.VenusViewPageTarget, ve.init.mw.WikiaViewPageTarget );

/* Static Properties */

ve.init.mw.VenusViewPageTarget.prototype.getNonEditableUIElements = function () {
	return $( '#mw-content-text, .recent-wiki-activity, .article-navigation, #articleCategories' );
};
