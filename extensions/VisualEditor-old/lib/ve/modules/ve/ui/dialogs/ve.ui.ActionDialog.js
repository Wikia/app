/*!
 * VisualEditor user interface ActionDialog class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Dialog to perform one or more actions.
 *
 * @class
 * @extends ve.ui.Dialog
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.ActionDialog = function VeUiActionDialog( config ) {
	// Parent constructor
	ve.ui.Dialog.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.ActionDialog, ve.ui.Dialog );

/* Static Properties */

/**
 * Default dialog size, either `small`, `medium` or `large`.
 *
 * @static
 * @property {string}
 * @inheritable
 */
ve.ui.ActionDialog.static.defaultSize = 'medium';

/* Methods */

/**
 * Handle dismiss errors button click events.
 *
 * Hides errors.
 */
ve.ui.ActionDialog.prototype.onDismissErrorsButtonClick = function () {
	this.dismissErrors();
};

/**
 * Handle apply button click events.
 *
 * Activates pending state and calls #applyChanges with a configured deferred object.
 */
ve.ui.ActionDialog.prototype.onApplyButtonClick = function () {
	this.pushPending();
	this.applyButton.setDisabled( true );
	this.applyChanges()
		.done( ve.bind( this.onApplyChangesDone, this ) )
		.fail( ve.bind( this.onApplyChangesFail, this ) )
		.always( ve.bind( this.onApplyChangesAlways, this ) );
};

/**
 * Handle apply changes done events.
 *
 * Closes dialog and re-enables apply button.
 *
 * @param {Object} data Dialog closing data
 */
ve.ui.ActionDialog.prototype.onApplyChangesDone = function ( data ) {
	this.close( data );
};

/**
 * Handle apply changes fail events.
 *
 * Shows errors that occured.
 *
 * @param {string[]} data Apply changes errors
 */
ve.ui.ActionDialog.prototype.onApplyChangesFail = function ( errors ) {
	this.showErrors( errors );
	this.applyButton.setDisabled( false );
};

/**
 * Handle apply changes fail events.
 *
 * Pops pending state.
 */
ve.ui.ActionDialog.prototype.onApplyChangesAlways = function () {
	this.popPending();
};

/**
 * Get the apply button label.
 *
 * @returns {string} Apply button label
 */
ve.ui.ActionDialog.prototype.getApplyButtonLabel = function () {
	return ve.msg( 'visualeditor-dialog-action-apply' );
};

/**
 * Get the apply button flags.
 *
 * @returns {string[]} Apply button flags
 */
ve.ui.ActionDialog.prototype.getApplyButtonFlags = function () {
	return [ 'primary' ];
};

/**
 * Apply changes to selected node.
 *
 * To display errors, reject the deferred object, passing in an array of strings, one for each error
 * message to display.
 *
 * @return {jQuery.Promise} Promise that is resolved when changes are applied
 */
ve.ui.ActionDialog.prototype.applyChanges = function () {
	return $.Deferred().resolve().promise();
};

/**
 * Show errors.
 *
 * @param {Array} errors Can be a list of jQuery objects, otherwise interpreted as a list of strings.
 */
ve.ui.ActionDialog.prototype.showErrors = function ( errors ) {
	var i, len, $errorDiv,
		$errors = this.$( [] );

	for ( i = 0, len = errors.length; i < len; i++ ) {
		$errorDiv = this.$( '<div>' ).addClass( 've-ui-actionDialog-error' );
		if ( errors[i] instanceof jQuery ) {
			$errorDiv.append( errors[i] );
		} else {
			$errorDiv.text( String( errors[i] ) );
		}
		$errors = $errors.add( $errorDiv );
	}

	this.$errorsTitle.after( $errors );
	this.$errors.show();
};

/**
 * Hide errors.
 */
ve.ui.ActionDialog.prototype.dismissErrors = function () {
	this.$errors
		.hide()
		.find( '.ve-ui-actionDialog-error' )
			.remove();
};

/**
 * @inheritdoc
 */
ve.ui.ActionDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.ActionDialog.super.prototype.initialize.call( this );

	// Properties
	this.applyButton = new OO.ui.ButtonWidget( { '$': this.$, 'icon': 'check' } );
	this.dismissErrorsButton = new OO.ui.ButtonWidget( {
		'$': this.$, 'label': ve.msg( 'visualeditor-dialog-error-dismiss' )
	} );
	this.panels = new OO.ui.StackLayout( { '$': this.$ } );
	this.$errors = this.$( '<div>' );
	this.$errorsTitle = this.$( '<div>' );

	// Events
	this.applyButton.connect( this, { 'click': [ 'onApplyButtonClick' ] } );
	this.dismissErrorsButton.connect( this, { 'click': [ 'onDismissErrorsButtonClick' ] } );

	// Initialization
	this.$errorsTitle
		.addClass( 've-ui-actionDialog-error-title' )
		.text( ve.msg( 'visualeditor-dialog-error' ) );
	this.$errors
		.addClass( 've-ui-actionDialog-errors' )
		.append( this.$errorsTitle, this.dismissErrorsButton.$element );
	this.frame.$content
		.addClass( 've-ui-actionDialog' )
		.append( this.$errors );
	this.$body.append( this.panels.$element );
	this.$foot.append( this.applyButton.$element );
	this.setSize( this.constructor.static.defaultSize );
};

/**
 * @inheritdoc
 */
ve.ui.ActionDialog.prototype.getSetupProcess = function ( data ) {
	return ve.ui.ActionDialog.super.prototype.getSetupProcess.call( this, data )
		.next( function () {
			this.applyButton.setLabel( this.getApplyButtonLabel() );
			this.applyButton.clearFlags().setFlags( this.getApplyButtonFlags() );
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.ActionDialog.prototype.getTeardownProcess = function ( data ) {
	return ve.ui.ActionDialog.super.prototype.getTeardownProcess.call( this, data )
		.next( function () {
			this.applyButton.setDisabled( false );
		}, this );
};
