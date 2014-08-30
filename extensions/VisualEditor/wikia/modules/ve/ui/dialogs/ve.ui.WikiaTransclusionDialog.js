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

	// Properties
	this.editFlow = null;
	this.shouldTrackFilter = false;
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
	this.filterInput.$input.on( 'blur', ve.bind( this.onFilterInputBlur, this ) );

	// Initialization
	this.modeButton.$element.addClass( 've-ui-mwTransclusionDialog-modeButton' );
	this.$foot.append( this.cancelButton.$element );
};

/**
 * @inheritdoc
 */
ve.ui.WikiaTransclusionDialog.prototype.onTransclusionReady = function () {
	var parts;
	// Parent method
	ve.ui.WikiaTransclusionDialog.super.prototype.onTransclusionReady.call( this );

	this.filterInput.focus();

	// ve.dm.MWTransclusionModel.prototype.process emits "change" that we want to "ignore"
	// Other way to implement this would be to override that process method
	this.transclusionModel.once( 'change', ve.bind( function () {
		this.transclusionModel.connect( this, { 'change': 'onParameterInputValueChange' } );
	}, this ) );

	parts = this.transclusionModel.getParts();
	if ( parts.length === 1 && parts[0].getParameters().length === 0 ) {
		ve.track( 'wikia', {
			'action': ve.track.actions.OPEN,
			'label': 'dialog-template-no-parameters'
		} );
	}
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

	ve.track( 'wikia', {
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
			this.editFlow = this.selectedNode ? true : false;

			if ( this.editFlow ) {
				var single = this.selectedNode.isSingleTemplate();
				this.selectedViewNode = this.surface.getView().getFocusedNode();
				this.setMode( single ? 'single' : 'multiple' );

				this.frame.$content.addClass( 've-ui-mwTemplateDialog-editFlow' );
				this.$body.append( this.$filter );

				if ( single ) {
					// Appearance
					this.position();
					// Drag
					this.setDraggable();
					// Overlay
					this.setOverlayless();
					// Scroll
					$( window ).off( 'mousewheel', this.onWindowMouseWheelHandler );
					// Focus
					this.surface.getFocusWidget().setNode( this.selectedViewNode );
					this.$body.append( this.$filter );
					// Tools
					this.$foot.append( this.previewButton.$element );

					ve.track( 'wikia', {
						'action': ve.track.actions.OPEN,
						'label': 'dialog-template-single'
					} );
				}
			} else {
				this.frame.$content.addClass( 've-ui-mwTemplateDialog-insertFlow' );

				ve.track( 'wikia', {
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
			if ( this.editFlow && data && data.action === 'cancel' ) {
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
			this.frame.$element.parent().css( {
				'width': '',
				'height': '',
				'max-height': ''
			} );
			this.previewButton.$element.remove();
			this.$filter.remove();
			this.frame.$content.removeClass( 've-ui-mwTemplateDialog-insertFlow ve-ui-mwTemplateDialog-editFlow' );

		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.WikiaTransclusionDialog.prototype.applyChanges = function () {
	if ( this.selectedNode ) {
		if ( this.selectedNode.isSingleTemplate() ) {
			ve.track( 'wikia', {
				'action': ve.track.actions.CLICK,
				'label': 'dialog-template-apply-button-single'
			} );
		} else {
			ve.track( 'wikia', {
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
	this.shouldTrackFilter = this.filterInput.getValue().length > 1;
	return ve.ui.WikiaTransclusionDialog.super.prototype.onFilterInputChange.call( this );
};

/**
 * Handle blur event on filter input element
 */
ve.ui.WikiaTransclusionDialog.prototype.onFilterInputBlur = function () {
	if ( this.shouldTrackFilter ) {
		ve.track( 'wikia', {
			'action': ve.track.actions.SUBMIT,
			'label': 'dialog-template-filter'
		} );
		this.shouldTrackFilter = false;
	}
};

/**
 * Position dialog. Vertically in the middle of the viewport
 * and horizontally with the edge (left or right) of the surface
 *
 * @method
 */
ve.ui.WikiaTransclusionDialog.prototype.position = function () {
	var viewportHeight = $( window ).height(),
		dialogHeight = Math.min( 600, viewportHeight * 0.7 ),
		padding = 10,
		$surface = this.surface.getView().$element,
		surfaceOffset = $surface.offset();

	this.frame.$element.parent().css( {
		'width': 400,
		'height': dialogHeight,
		'top': ( viewportHeight - dialogHeight ) / 2,
		'max-height': 'none'
	} );

	if ( this.surface.getView().getFocusedNode().getHorizontalBias() === 'right' ) {
		this.frame.$element.parent()
			.css( 'left', surfaceOffset.left - padding );
	} else {
		this.frame.$element.parent()
			.css( 'left', surfaceOffset.left + $surface.width() - this.frame.$element.parent().outerWidth() + padding );
	}
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.WikiaTransclusionDialog );
