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
 * @extends ve.ui.Dialog
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.MWBetaWelcomeDialog = function VeUiMWBetaWelcomeDialog( config ) {
	// Configuration initialization
	config = ve.extendObject( { 'size': 'medium', 'footless': false }, config );

	// Parent constructor
	ve.ui.Dialog.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWBetaWelcomeDialog, ve.ui.Dialog );

/* Static Properties */

ve.ui.MWBetaWelcomeDialog.static.name = 'betaWelcome';

ve.ui.MWBetaWelcomeDialog.static.title =
	OO.ui.deferMsg( 'visualeditor-dialog-beta-welcome-title' );

ve.ui.MWBetaWelcomeDialog.static.icon = 'help';

/* Methods */

/**
 * Get the title of the window.
 *
 * Send the MediaWiki username along with the message for {{GENDER:}} i18n support
 * @returns {string} Window title
 */
ve.ui.MWBetaWelcomeDialog.prototype.getTitle = function () {
	return ve.msg( this.constructor.static.title, mw.user );
};

/**
 * @inheritdoc
 */
ve.ui.MWBetaWelcomeDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.Dialog.prototype.initialize.call( this );

	// Properties
	this.contentLayout = new OO.ui.PanelLayout( {
		'$': this.$,
		'scrollable': true,
		'padded': true
	} );
	this.continueButton = new OO.ui.ButtonWidget( {
		'$': this.$,
		'label': ve.msg( 'visualeditor-dialog-beta-welcome-action-continue' ),
		'flags': ['primary']
	} );

	// Events
	this.continueButton.connect( this, { 'click': [ 'close', { 'action': 'close' } ] } );

	// Initialization
	this.contentLayout.$element
		.addClass( 've-ui-mwBetaWelcomeDialog-content' )
		.text( ve.msg( 'visualeditor-dialog-beta-welcome-content', $( '#ca-edit' ).text() ) );
	this.$body.append( this.contentLayout.$element );
	this.$foot.append( this.continueButton.$element );
};

/* Registration */

ve.ui.dialogFactory.register( ve.ui.MWBetaWelcomeDialog );
