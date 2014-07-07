/*!
 * VisualEditor UserInterface WikiaSaveDialog class.
 */

/**
 * Dialog for saving MediaWiki articles.
 *
 * @class
 * @extends ve.ui.MWSaveDialog
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.WikiaSaveDialog = function VeUiWikiaSaveDialog( config ) {
	// Parent constructor
	ve.ui.MWSaveDialog.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaSaveDialog, ve.ui.MWSaveDialog );

/* Methods */

ve.ui.WikiaSaveDialog.prototype.initialize = function () {
	ve.ui.MWSaveDialog.prototype.initialize.call( this );
	this.$reviewViewer.addClass( 'WikiaArticle' );
};

/* Registration */

ve.ui.dialogFactory.register( ve.ui.WikiaSaveDialog );