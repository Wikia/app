/*!
 * VisualEditor user interface WikiaPreferenceDialog class.
 */

/*global mw */

/**
 * Dialog for informing users of a change to their preferences.
 *
 * @class
 * @extends ve.ui.Dialog
 *
 * @constructor
 * @param {Object} [config] Config options
 */
ve.ui.WikiaPreferenceDialog = function VeUiWikiaPreferenceDialog( config ) {
	config = $.extend( config, {
		width: '550px',
		height: '350px',
		disableAnimation: true
	} );

	// Parent constructor
	ve.ui.WikiaPreferenceDialog.super.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaPreferenceDialog, ve.ui.Dialog );

/* Static Properties */

ve.ui.WikiaPreferenceDialog.static.name = 'wikiaPreference';

ve.ui.WikiaPreferenceDialog.static.title = '';

ve.ui.WikiaPreferenceDialog.static.icon = '';

/* Methods */

/**
 * Initialize the dialog.
 *
 * @method
 */
ve.ui.WikiaPreferenceDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.WikiaPreferenceDialog.super.prototype.initialize.call( this );

	// Properties
	this.$headline = this.$( '<div>' )
		.addClass( 've-ui-wikiaPreferenceDialog-headline' )
		.html(
			ve.msg( 'wikia-visualeditor-dialog-preference-headline' )
		);
	this.$textBody = this.$( '<div>' )
		.addClass( 've-ui-wikiaPreferenceDialog-text' )
		.html(
			ve.msg( 'wikia-visualeditor-dialog-preference-text' )
		);
	this.startButton = new OO.ui.ButtonWidget( {
		'$': this.$,
		'label': ve.msg( 'wikia-visualeditor-dialog-preference-start-button' ),
		'flags': [ 'primary' ]
	} );
	this.helpButton = new OO.ui.ButtonWidget( {
		'$': this.$,
		'frameless': true,
		'icon': 'arrow-circled',
		'label': ve.msg( 'wikia-visualeditor-dialog-preference-link-help' ),
		'tabIndex': -1,
		'classes': [ 've-ui-wikiaPreferenceDialog-link' ]
	} );
	this.preferencesButton = new OO.ui.ButtonWidget( {
		'$': this.$,
		'frameless': true,
		'icon': 'arrow-circled',
		'label': ve.msg( 'wikia-visualeditor-dialog-preference-link-preferences' ),
		'tabIndex': -1,
		'classes': [ 've-ui-wikiaPreferenceDialog-link' ]
	} );

	// Events
	this.startButton.connect( this, { 'click': 'close' } );
	this.helpButton.connect( this, { 'click': 'onHelpButtonClick' } );
	this.preferencesButton.connect( this, { 'click': 'onPreferencesButtonClick' } );

	// Initialization
	this.$content = this.$( '<div>' )
		.addClass( 've-ui-wikiaPreferenceDialog-content' )
		.append( this.$headline, this.$textBody, this.helpButton.$element, this.preferencesButton.$element, this.startButton.$element )
		.appendTo( this.$body );

	this.frame.$content.addClass( 've-ui-wikiaPreferenceDialog' );
};

/**
 * Handle clicks on the link to VisualEditor help
 */
ve.ui.WikiaPreferenceDialog.prototype.onHelpButtonClick = function () {
	window.open( mw.Title.newFromText( 'VisualEditor', 12 ).getUrl() );
	ve.track( 'wikia', {
		'action': ve.track.actions.CLICK,
		'label': 'dialog-wikia-preference-link-help'
	} );
};

/**
 * Handle clicks on the link to user preferences
 */
ve.ui.WikiaPreferenceDialog.prototype.onPreferencesButtonClick = function () {
	window.open( mw.Title.newFromText( 'Preferences', -1 ).getUrl() + '#mw-prefsection-editing' );
	ve.track( 'wikia', {
		'action': ve.track.actions.CLICK,
		'label': 'dialog-wikia-preference-link-preferences'
	} );
};

/**
 * @inheritdoc
 */
ve.ui.WikiaPreferenceDialog.prototype.getSetupProcess = function ( data ) {
	return ve.ui.WikiaPreferenceDialog.super.prototype.getSetupProcess.call( this, data )
		.next( function () {
			this.surface.getFocusWidget().$element.hide();
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.WikiaPreferenceDialog.prototype.getTeardownProcess = function ( data ) {
	return ve.ui.WikiaPreferenceDialog.super.prototype.getTeardownProcess.call( this, data )
		.first( function () {
			if ( !( data && data.action && data.action === 'cancel' ) ) {
				ve.track( 'wikia', {
					'action': ve.track.actions.CLICK,
					'label': 'dialog-wikia-preference-click-got-it'
				} );
			}
			this.surface.getFocusWidget().$element.show();

			// Set an option confirming the user viewed this dialog
			$.ajax( {
				'url': mw.util.wikiScript( 'api' ),
				'type': 'POST',
				'data': {
					'format': 'json',
					'action': 'options',
					'optionname': 'showVisualEditorTransitionDialog',
					'optionvalue': 0
				}
			} );
		}, this );
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.WikiaPreferenceDialog );
