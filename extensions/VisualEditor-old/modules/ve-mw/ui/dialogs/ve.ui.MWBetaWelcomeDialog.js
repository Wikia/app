/*!
 * VisualEditor user interface MWBetaWelcomeDialog class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/*global mw */

/**
 * Dialog for inserting MediaWiki media objects.
 *
 * @class
 * @extends ve.ui.ActionDialog
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.MWBetaWelcomeDialog = function VeUiMWBetaWelcomeDialog( config ) {
	// Parent constructor
	ve.ui.MWBetaWelcomeDialog.super.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWBetaWelcomeDialog, ve.ui.ActionDialog );

/* Static Properties */

ve.ui.MWBetaWelcomeDialog.static.name = 'betaWelcome';

ve.ui.MWBetaWelcomeDialog.static.title =
	OO.ui.deferMsg( 'visualeditor-dialog-beta-welcome-title' );

ve.ui.MWBetaWelcomeDialog.static.icon = 'help';

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.MWBetaWelcomeDialog.prototype.getTitle = function () {
	// Send the MediaWiki username along with the message for {{GENDER:}} i18n support
	return ve.msg( this.constructor.static.title, mw.user );
};

/**
 * @inheritdoc
 */
ve.ui.MWBetaWelcomeDialog.prototype.getApplyButtonLabel = function () {
	return ve.msg( 'visualeditor-dialog-beta-welcome-action-continue' );
};

/**
 * @inheritdoc
 */
ve.ui.MWBetaWelcomeDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.MWBetaWelcomeDialog.super.prototype.initialize.call( this );

	// Properties
	this.contentPanel = new OO.ui.PanelLayout( {
		'$': this.$,
		'scrollable': true,
		'padded': true,
		'classes': [ 've-ui-mwBetaWelcomeDialog-content' ],
		'text': ve.msg( 'visualeditor-dialog-beta-welcome-content', $( '#ca-edit' ).text() )
	} );

	// Initialization
	this.panels.addItems( [ this.contentPanel ] );
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.MWBetaWelcomeDialog );
