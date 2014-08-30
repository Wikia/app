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
	this.filterInput.$input
		.on( 'focus', ve.bind( this.onFilterInputFocus, this ) )
		.on( 'blur', ve.bind( this.onFilterInputBlur, this ) );

	// Initialization
	this.modeButton.$element.addClass( 've-ui-mwTransclusionDialog-modeButton' );
	this.$foot.append( this.cancelButton.$element );
};

/**
 * @inheritdoc
 */
ve.ui.WikiaTransclusionDialog.prototype.onTransclusionReady = function () {
	// Parent method
	ve.ui.WikiaTransclusionDialog.super.prototype.onTransclusionReady.call( this );

	this.filterInput.focus();

	// ve.dm.MWTransclusionModel.prototype.process emits "change" that we want to "ignore"
	// Other way to implement this would be to override that process method
	this.transclusionModel.once( 'change', ve.bind( function () {
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
	this.selectedViewNode.update( { wikitext: this.transclusionModel.getWikitext() } );
	this.previewCount += 1;

	ve.track( 'both', {
		'action': ve.track.actions.CLICK,
		'label': 'dialog-template-preview-button',
		'value': this.previewCount
	} );
};

/**
 * Handles action when parameter input value has changed
 */
ve.ui.WikiaTransclusionDialog.prototype.onParameterInputValueChange = function () {
	this.previewButton.setDisabled( false );
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

/**
 * @inheritdoc
 */
ve.ui.WikiaTransclusionDialog.prototype.getSetupProcess = function ( data ) {
	return ve.ui.WikiaTransclusionDialog.super.prototype.getSetupProcess.call( this, data )
		.next( function () {
			var single = this.selectedNode.isSingleTemplate();
			this.selectedViewNode = this.surface.getView().getFocusedNode();
			this.setMode( single ? 'single' : 'multiple' );

			if ( single ) {
				// Appearance
				this.frame.$element.parent().css( 'width', 400 );
				this.alignToSurface();
				// Drag
				this.setDraggable();
				// Overlay
				this.setOverlayless();
				// Scroll
				$( window ).off( 'mousewheel', this.onWindowMouseWheelHandler );
				// Focus
				this.surface.getFocusWidget().setNode( this.selectedViewNode );
				// Tools
				this.$foot.append( this.previewButton.$element );

				ve.track( 'both', {
					'action': ve.track.actions.OPEN,
					'label': 'dialog-template-single'
				} );
			} else {
				ve.track( 'both', {
					'action': ve.track.actions.OPEN,
					'label': 'dialog-template-multiple'
				} );
			}
			this.previewCount = 0;
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.WikiaTransclusionDialog.prototype.getTeardownProcess = function ( data ) {
	return ve.ui.WikiaTransclusionDialog.super.prototype.getTeardownProcess.call( this, data )
		.first( function () {
			this.surface.getFocusWidget().unsetNode();
			if ( data && data.action === 'cancel' ) {
				// update without wikitext passed in the config will just use original value
				this.selectedViewNode.update();
			}
		}, this )
		.next( function () {
			if ( this.draggable ) {
				this.unsetDraggable();
			}
			if ( this.overlayless ) {
				this.unsetOverlayless();
			}
			if ( this.allowScroll ) {
				this.unsetAllowScroll();
			}
			this.frame.$element.parent().css( 'width', '' );
			this.previewButton.$element.remove();
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.WikiaTransclusionDialog.prototype.applyChanges = function () {
	if ( this.selectedNode ) {
		if ( this.selectedNode.isSingleTemplate() ) {
			ve.track( 'both', {
				'action': ve.track.actions.CLICK,
				'label': 'dialog-template-apply-button-single'
			} );
		} else {
			ve.track( 'both', {
				'action': ve.track.actions.CLICK,
				'label': 'dialog-template-apply-button-multiple'
			} );
		}
	}
	return ve.ui.WikiaTransclusionDialog.super.prototype.applyChanges.call( this );
};

/**
 * @inheritdoc
 */
ve.ui.WikiaTransclusionDialog.prototype.onFilterInputChange = function () {
	this.shouldTrackSearch = ( this.filterInput.getValue().length > 1 );
	return ve.ui.WikiaTransclusionDialog.super.prototype.onFilterInputChange.call( this );
};

/**
 * Handle focus event on filter input element
 */
ve.ui.WikiaTransclusionDialog.prototype.onFilterInputFocus = function () {
	this.shouldTrackSearch = false;
};

/**
 * Handle blur event on filter input element
 */
ve.ui.WikiaTransclusionDialog.prototype.onFilterInputBlur = function () {
	if ( this.shouldTrackSearch ) {
		ve.track( 'both', {
			'action': ve.track.actions.SUBMIT,
			'label': 'dialog-template-filter'
		} );
	}
};

/**
 * @inheritdoc
 */
ve.ui.WikiaTransclusionDialog.prototype.onReplacePart = function ( removed, added ) {
	if (
		this.selectedNode &&
		this.selectedNode.isSingleTemplate() &&
		added instanceof ve.dm.MWTemplateModel &&
		added.getParameters().length === 0
	) {
		ve.track( 'both', {
			'action': ve.track.actions.OPEN,
			'label': 'dialog-template-no-parameters'
		} );
	}
	return ve.ui.WikiaTransclusionDialog.super.prototype.onReplacePart.call( this, removed, added );
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.WikiaTransclusionDialog );
