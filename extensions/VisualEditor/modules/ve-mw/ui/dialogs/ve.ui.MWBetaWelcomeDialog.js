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
 * @param {ve.ui.Surface} surface
 * @param {Object} [config] Config options
 */
ve.ui.MWBetaWelcomeDialog = function VeUiMWBetaWelcomeDialog( surface, config ) {
	// Configuration initialization
	config = ve.extendObject( {}, config, { 'small': true, 'footless': false } );

	// Parent constructor
	ve.ui.MWDialog.call( this, surface, config );
};

/* Inheritance */

ve.inheritClass( ve.ui.MWBetaWelcomeDialog, ve.ui.MWDialog );

/* Static Properties */

ve.ui.MWBetaWelcomeDialog.static.name = 'betaWelcome';

ve.ui.MWBetaWelcomeDialog.static.titleMessage = 'visualeditor-dialog-beta-welcome-title';

ve.ui.MWBetaWelcomeDialog.static.icon = 'help';

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.MWBetaWelcomeDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.MWDialog.prototype.initialize.call( this );

	// Properties
	this.contentLayout = new ve.ui.PanelLayout( {
		'$$': this.frame.$$,
		'scrollable': true,
		'padded': true
	} );
	this.continueButton = new ve.ui.ButtonWidget( {
		'$$': this.$$,
		'label': ve.msg( 'visualeditor-dialog-beta-welcome-action-continue' ),
		'flags': ['primary']
	} );

	// Events
	this.continueButton.connect( this, { 'click': [ 'close', 'close' ] } );

	// Initialization
	this.contentLayout.$
		.addClass( 've-ui-mwBetaWelcomeDialog-content' )
		.text( ve.msg( 'visualeditor-dialog-beta-welcome-content', $( '#ca-edit' ).text() ) );
	this.$body.append( this.contentLayout.$ );
	this.$foot.append( this.continueButton.$ );
};

/* Registration */

ve.ui.dialogFactory.register( ve.ui.MWBetaWelcomeDialog );
