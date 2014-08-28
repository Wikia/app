/*
 * VisualEditor user interface WikiaTransclusionDialog class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Dialog for inserting and editing MediaWiki transclusions.
 *
 * @class
 * @extends ve.ui.MWTransclusionDialog
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.WikiaTransclusionDialog = function VeUiWikiaTransclusionDialog( config ) {
	// Configuration initialization
	config = ve.extendObject( {
		'width': '400px',
		'draggable': true,
		'overlayless': true,
		'allowScroll': true
	}, config );

	// Parent constructor
	ve.ui.WikiaTransclusionDialog.super.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaTransclusionDialog, ve.ui.MWTransclusionDialog );

/* Static Properties */

ve.ui.MWTransclusionDialog.static.name = 'transclusion';

ve.ui.WikiaTransclusionDialog.static.icon = 'edit';

ve.ui.WikiaTransclusionDialog.static.title = OO.ui.deferMsg( 'wikia-visualeditor-dialog-transclusion-title' );

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.WikiaTransclusionDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.WikiaTransclusionDialog.super.prototype.initialize.call( this );

	// Properties
	this.cancelButton = new OO.ui.ButtonWidget( {
		'$': this.$,
		'flags': ['secondary'],
		'label': ve.msg( 'visualeditor-dialog-action-cancel' ),
		'classes': [ 've-ui-wikiaTransclusionDialog-cancelButton' ]
	} );
	this.previewButton = new OO.ui.ButtonWidget( {
		'$': this.$,
		'flags': ['secondary'],
		'label': ve.msg( 'wikia-visualeditor-dialog-transclusion-preview-button' ),
		'disabled': true
	} );

	// Events
	this.cancelButton.connect( this, { 'click': 'onCancelButtonClick' } );
	this.previewButton.connect( this, { 'click': 'onPreviewButtonClick' } );

	// Initialization
	this.modeButton.$element.addClass( 've-ui-mwTransclusionDialog-modeButton' );
	this.$foot.append( this.previewButton.$element, this.cancelButton.$element );
};

/**
 * @inheritdoc
 */
ve.ui.WikiaTransclusionDialog.prototype.onTransclusionReady = function () {
	// Parent method
	ve.ui.WikiaTransclusionDialog.super.prototype.onTransclusionReady.call( this );

	// ve.dm.MWTransclusionModel.prototype.process emits "change" that we want to "ignore"
	// Other way to implement this would be to override that process method
	this.transclusionModel.once( 'change', ve.bind( function() {
		this.transclusionModel.connect( this, { 'change': 'onParameterInputValueChange' } );
	}, this ) );
};

/**
 * Handles action when clicking cancel button
 */
ve.ui.WikiaTransclusionDialog.prototype.onCancelButtonClick = function () {
	this.close( { 'action': 'cancel' } );
};

/**
 * Handles action when clicking preview button
 */
ve.ui.WikiaTransclusionDialog.prototype.onPreviewButtonClick = function () {
	this.previewButton.setDisabled( true );
};

ve.ui.WikiaTransclusionDialog.prototype.onParameterInputValueChange = function () {
	this.previewButton.setDisabled( false );
	// TODO: update the template preview
};

/**
 * @inheritdoc
 */
ve.ui.WikiaTransclusionDialog.prototype.getApplyButtonLabel = function () {
	return ve.msg( 'wikia-visualeditor-dialog-done-button' );
};

/**
 * @inheritdoc
 */
ve.ui.WikiaTransclusionDialog.prototype.updateTitle = function () {
	this.setTitle( this.constructor.static.title );
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.WikiaTransclusionDialog );
