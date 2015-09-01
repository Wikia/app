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
	this.surface = null;
	this.editFlow = null;
	this.shouldTrackFilter = false;
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaTransclusionDialog, ve.ui.MWTransclusionDialog );

/* Static Properties */

ve.ui.WikiaTransclusionDialog.static.title = OO.ui.deferMsg( 'wikia-visualeditor-dialog-transclusion-title' );

ve.ui.WikiaTransclusionDialog.static.actions = ve.ui.MWTransclusionDialog.static.actions.concat( [
	{
		action: 'preview',
		label: OO.ui.deferMsg( 'wikia-visualeditor-dialog-transclusion-preview-button' ),
		modes: [ 'edit' ]
	}
] );

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.WikiaTransclusionDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.WikiaTransclusionDialog.super.prototype.initialize.call( this );

	// Properties
	this.filterInput = new OO.ui.TextInputWidget( {
		$: this.$,
		icon: 'search',
		placeholder: ve.msg( 'wikia-visualeditor-dialog-transclusion-filter' )
	} );

	this.$filter = this.$( '<div>' )
		.addClass( 've-ui-mwTemplateDialog-filter' )
		.append( this.filterInput.$element );

	// Events
	this.filterInput.on( 'change', this.onFilterInputChange.bind( this ) );
	this.filterInput.$input.on( 'blur', this.onFilterInputBlur.bind( this ) );

	// Initialization
	this.filterInput.$input.attr( 'tabindex', 1 );
	this.$body.append( this.$filter );
};

/**
 * @inheritdoc
 */
ve.ui.WikiaTransclusionDialog.prototype.getSetupProcess = function ( data ) {
	return ve.ui.WikiaTransclusionDialog.super.prototype.getSetupProcess.call( this, data )
		.next( function () {
			this.surface = data.surface;
			this.previewAction = this.actions.get( { actions: 'preview' } )[0];

			this.actions.remove( this.actions.get( { actions: 'mode' } ) );
			this.filterInput.setValue( '' );
			this.editFlow = this.selectedNode ? true : false;
			this.$filter.hide();
			this.actions.setAbilities( { preview: false } );
			this.previewAction.$element.hide();

			if ( this.editFlow ) {
				var single = this.selectedNode.isSingleTemplate();
				this.selectedViewNode = this.surface.getView().getFocusedNode();
				this.setMode( single ? 'single' : 'multiple' );

				this.$content.addClass( 've-ui-mwTemplateDialog-editFlow' );

				// Show filter
				this.$filter.show();

				if ( single ) {
					// Appearance
					this.position();

					// Overlay
					this.setOverlayless();

					// Focus
					if ( this.selectedViewNode.getHorizontalBias() !== null ) {
						this.surface.getFocusWidget().setNode( this.selectedViewNode );
					}
					this.surface.getModel().setSelection( new ve.dm.NullSelection( this.surface.getModel().getDocument() ) );

					// Preview button
					this.previewAction.$element.show();

					ve.track( 'wikia', {
						action: ve.track.actions.OPEN,
						label: 'dialog-template-single'
					} );
				} else {
					ve.track( 'wikia', {
						action: ve.track.actions.OPEN,
						label: 'dialog-template-multiple'
					} );
				}
			} else {
				this.$content.addClass( 've-ui-mwTemplateDialog-insertFlow' );
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
			if ( this.editFlow && ( !data || data.action !== 'apply' ) ) {
				// update without wikitext passed in the config will just use original value
				this.selectedViewNode.update();
				ve.track( 'wikia', {
					action: ve.track.actions.CLICK,
					label: 'dialog-template-button-cancel',
					value: this.previewCount
				} );
			}
			if ( data && data.action === 'apply' && this.selectedNode ) {
				if ( this.selectedNode.isSingleTemplate() ) {
					ve.track( 'wikia', {
						action: ve.track.actions.CLICK,
						label: 'dialog-template-button-apply-single'
					} );
				} else {
					ve.track( 'wikia', {
						action: ve.track.actions.CLICK,
						label: 'dialog-template-button-apply-multiple'
					} );
				}
			}
		}, this )
		.next( function () {
			this.unsetOverlayless();
			this.$content.removeClass( [
				've-ui-mwTemplateDialog-insertFlow',
				've-ui-mwTemplateDialog-editFlow',
				've-ui-wikiaTransclusionDialog-zeroState'
			].join( ' ' ) );
			this.$foot.show();
		}, this );
};

/**
 * Position dialog. Vertically in the middle of the viewport
 * and horizontally with the edge (left or right) of the surface
 */
ve.ui.WikiaTransclusionDialog.prototype.position = function () {
	var $surface = this.surface.getView().$element,
		surfaceOffset = $surface.offset(),
		left;

	if ( this.selectedViewNode.getHorizontalBias() === 'right' ) {
		left = surfaceOffset.left;
	} else {
		left = surfaceOffset.left + $surface.width() - this.$frame.width();
	}
	this.$frame.css( 'margin-left', left );
};

/**
 * @inheritdoc
 */
ve.ui.WikiaTransclusionDialog.prototype.getActionProcess = function ( action ) {
	if ( action === 'preview' ) {
		return new OO.ui.Process( function () {
			this.actions.setAbilities( { preview: false } );
			this.selectedViewNode.update( { wikitext: this.transclusionModel.getWikitext() } );
			this.previewCount += 1;

			ve.track( 'wikia', {
				action: ve.track.actions.CLICK,
				label: 'dialog-template-button-preview',
				value: this.previewCount
			} );
		}, this );
	}
	return ve.ui.WikiaTransclusionDialog.super.prototype.getActionProcess.call( this, action );
};

/**
 * @inheritdoc
 */
ve.ui.WikiaTransclusionDialog.prototype.onTransclusionReady = function () {
	var zeroStatePage, templateGetInfoWidget,
		parts = this.transclusionModel.getParts();

	// Parent method
	ve.ui.WikiaTransclusionDialog.super.prototype.onTransclusionReady.call( this );

	if ( this.isSingleTemplateTransclusion() && Object.keys( parts[0].getParameters() ).length === 0 ) {
		// Hide stuff
		this.$filter.hide();
		this.$content.addClass( 've-ui-wikiaTransclusionDialog-zeroState' );
		this.$foot.hide();
		this.$body.css( 'bottom', 0 );

		// Content
		zeroStatePage = new OO.ui.PageLayout( 'zeroState', {} );
		templateGetInfoWidget = new ve.ui.WikiaTemplateGetInfoWidget( { template: parts[0] } );
		zeroStatePage.$element
			.text( ve.msg( 'wikia-visualeditor-dialog-transclusion-zerostate' ) )
			.append( templateGetInfoWidget.$element );
		this.bookletLayout.addPages( [ zeroStatePage ] );

		// Position
		this.position();

		// Track
		ve.track( 'wikia', {
			action: ve.track.actions.OPEN,
			label: 'dialog-template-no-parameters'
		} );

	} else {
		// ve.dm.MWTransclusionModel.prototype.process emits "change" that we want to "ignore"
		// Other way to implement this would be to override that process method
		this.transclusionModel.once( 'change', function () {
			this.transclusionModel.connect( this, { change: 'onParameterInputValueChange' } );
			this.filterInput.focus();
		}.bind( this ) );
	}
};

/**
 * Handles action when parameter input value has changed
 */
ve.ui.WikiaTransclusionDialog.prototype.onParameterInputValueChange = function () {
	this.actions.setAbilities( { preview: true } );
};

/**
 * @inheritdoc
 */
ve.ui.WikiaTransclusionDialog.prototype.updateTitle = function () {
	this.title.setLabel( this.constructor.static.title );
};

/**
 * Handle blur event on filter input element
 */
ve.ui.WikiaTransclusionDialog.prototype.onFilterInputBlur = function () {
	if ( this.shouldTrackFilter ) {
		ve.track( 'wikia', {
			action: ve.track.actions.SUBMIT,
			label: 'dialog-template-filter'
		} );
		this.shouldTrackFilter = false;
	}
};

/**
 * Handle the filter input change
 */
ve.ui.WikiaTransclusionDialog.prototype.onFilterInputChange = function () {
	var value = this.filterInput.getValue().toLowerCase().trim(),
		parts = this.transclusionModel.getParts(),
		i, len, part, page, parameters, parameter, parameterMatch;

	this.shouldTrackFilter = value.length > 1;

	// iterate over all parts of the transclusion (templates and contents)
	for ( i = 0, len = parts.length; i < len; i++ ) {
		part = parts[i];

		if ( part instanceof ve.dm.MWTransclusionContentModel ) { // content
			page = this.bookletLayout.getPage( part.getId() );
			if ( value !== '' && part.getValue().toLowerCase().indexOf( value ) === -1 ) {
				page.$element.hide();
			} else {
				page.$element.show();
			}
		} else if ( part instanceof ve.dm.MWTemplateModel ) { // template
			// iterate over all parameters of the template
			parameters = part.getParameters();
			parameterMatch = false;
			for ( parameter in parameters ) {
				page = this.bookletLayout.getPage( part.getId() + '/' + parameter );
				if (
					value !== '' &&
					parameters[parameter].getName().toLowerCase().indexOf( value ) === -1 &&
					parameters[parameter].getValue().toLowerCase().indexOf( value ) === -1
				) {
					page.$element.hide();
				} else {
					parameterMatch = true;
					page.$element.show();
				}
			}
			// if there was no match among all parameters for the template then
			// hide template page as well (so not only parameters)
			if ( this.mode === 'multiple' ) {
				page = this.bookletLayout.getPage( part.getId() );
				if ( value !== '' && !parameterMatch ) {
					page.$element.hide();
				} else {
					page.$element.show();
				}
			}
		}
	}
};

/**
 * Initialize parameters for new template insertion
 *
 * @method
 */
ve.ui.WikiaTransclusionDialog.prototype.initializeNewTemplateParameters = function () {
	var i, parts = this.transclusionModel.getParts();
	for ( i = 0; i < parts.length; i++ ) {
		if ( parts[i] instanceof ve.dm.MWTemplateModel ) {
			parts[i].addUnusedParameters();
		}
	}
};

/**
 * Initialize parameters for existing template modification
 *
 * @method
 */
ve.ui.WikiaTransclusionDialog.prototype.initializeTemplateParameters = ve.ui.WikiaTransclusionDialog.prototype.initializeNewTemplateParameters;

/* Registration */

ve.ui.windowFactory.register( ve.ui.WikiaTransclusionDialog );
