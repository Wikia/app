/*!
 * VisualEditor MediaWiki Initialization WikiaViewPageTarget class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Initialization MediaWiki view page target.
 *
 * @class
 * @extends ve.init.mw.ViewPageTarget
 *
 * @constructor
 */
ve.init.mw.WikiaViewPageTarget = function VeInitMwWikiaViewPageTarget() {
	// Parent constructor
	ve.init.mw.ViewPageTarget.call( this );
};

/* Inheritance */

ve.inheritClass( ve.init.mw.WikiaViewPageTarget, ve.init.mw.ViewPageTarget );

ve.init.mw.WikiaViewPageTarget.prototype.setupSkinTabs = function () {
	// Intentionally left empty
};

ve.init.mw.WikiaViewPageTarget.prototype.mutePageContent = function () {
	$( '#mw-content-text, .WikiaArticleCategories' )
		.addClass( 've-init-mw-viewPageTarget-content' )
		.fadeTo( 'fast', 0.6 );
};

ve.init.mw.WikiaViewPageTarget.prototype.hidePageContent = function () {
	$( '#mw-content-text, .WikiaArticleCategories' )
		.addClass( 've-init-mw-viewPageTarget-content' )
		.hide();
};

ve.init.mw.WikiaViewPageTarget.prototype.showPageContent = function () {
	$( '.ve-init-mw-viewPageTarget-content' )
		.removeClass( 've-init-mw-viewPageTarget-content' )
		.show()
		.fadeTo( 0, 1 );
};
