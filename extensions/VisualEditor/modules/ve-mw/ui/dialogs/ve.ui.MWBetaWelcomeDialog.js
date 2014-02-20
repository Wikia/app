/*global mw */
/*!
 * VisualEditor user interface MWBetaWelcomeDialog class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Dialog for inserting MediaWiki media objects.
 *
 * @class
 * @extends ve.ui.MWDialog
 *
 * @constructor
 * @param {ve.ui.WindowSet} windowSet Window set this dialog is part of
 * @param {Object} [config] Configuration options
 */
ve.ui.MWBetaWelcomeDialog = function VeUiMWBetaWelcomeDialog( windowSet, config ) {
	// Configuration initialization
	config = ve.extendObject( { 'small': true, 'footless': false }, config );

	// Parent constructor
	ve.ui.MWDialog.call( this, windowSet, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWBetaWelcomeDialog, ve.ui.MWDialog );

/* Static Properties */

ve.ui.MWBetaWelcomeDialog.static.name = 'betaWelcome';

ve.ui.MWBetaWelcomeDialog.static.titleMessage = 'visualeditor-dialog-beta-welcome-title';

ve.ui.MWBetaWelcomeDialog.static.icon = 'help';

/* Methods */

/**
 * Get the title of the window.
 *
 * Send the MediaWiki username along with the message for {{GENDER:}} i18n support
 * @returns {string} Window title
 */
ve.ui.MWBetaWelcomeDialog.prototype.getTitle = function () {
	return ve.msg( this.constructor.static.titleMessage, mw.user );
};

/**
 * @inheritdoc
 */
ve.ui.MWBetaWelcomeDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.MWDialog.prototype.initialize.call( this );

	// Properties
	this.contentLayout = new OO.ui.PanelLayout( {
		'$': this.$,
		'scrollable': true,
		'padded': true
	} );
	this.continueButton = new OO.ui.PushButtonWidget( {
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
