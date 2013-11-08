/*!
 * VisualEditor UserInterface WikiaDialog class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface MediaWiki dialog.
 *
 * @class
 * @abstract
 * @extends ve.ui.MWDialog
 *
 * @constructor
 * @param {ve.ui.Surface} surface
 * @param {Object} [config] Configuration options
 */
ve.ui.WikiaDialog = function VeUiWikiaDialog( surface, config ) {
	// Parent constructor
	ve.ui.MWDialog.call( this, surface, config );
};

/* Inheritance */

ve.inheritClass( ve.ui.WikiaDialog, ve.ui.MWDialog );

/* Methods */

ve.ui.WikiaDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.MWDialog.prototype.initialize.call( this );

	// Loading graphic overlay
	this.$loadingOverlay = this.$$( '<div>' );
	this.$loadingOverlay.addClass( 'loading-overlay hidden' );
	this.frame.$content.append( this.$loadingOverlay );

};

ve.ui.WikiaDialog.prototype.showLoadingOverlay = function () {
	this.$loadingOverlay.removeClass( 'hidden' );
};

ve.ui.WikiaDialog.prototype.hideLoadingOverlay = function () {
	this.$loadingOverlay.addClass( 'hidden' );
};

