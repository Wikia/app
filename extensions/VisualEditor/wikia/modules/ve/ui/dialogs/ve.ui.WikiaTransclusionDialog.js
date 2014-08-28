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
		'label': ve.msg( 'visualeditor-dialog-action-cancel' )
	} );

	// Events
	this.cancelButton.connect( this, { 'click': 'onCancelButtonClick' } );

	// Initialization
	this.modeButton.$element.addClass( 've-ui-mwTransclusionDialog-modeButton' );
	this.$foot.append( this.cancelButton.$element );
};

/**
 * Handles action when clicking cancel button
 */
ve.ui.WikiaTransclusionDialog.prototype.onCancelButtonClick = function () {
	this.close();
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
