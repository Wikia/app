/*
 * VisualEditor user interface MWTransclusionDialog class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Dialog for inserting and editing MediaWiki transclusions.
 *
 * @class
 * @extends ve.ui.MWTemplateDialog
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.MWTransclusionDialog = function VeUiMWTransclusionDialog( config ) {
	// Parent constructor
	ve.ui.MWTransclusionDialog.super.call( this, config );

	// Properties
	this.mode = null;
};

/* Inheritance */

OO.inheritClass( ve.ui.MWTransclusionDialog, ve.ui.MWTemplateDialog );

/* Static Properties */

ve.ui.MWTransclusionDialog.static.name = 'transclusion';

ve.ui.MWTransclusionDialog.static.title =
	OO.ui.deferMsg( 'wikia-visualeditor-dialog-transclusion-title' );

/**
 * Map of symbolic mode names and CSS classes.
 *
 * @static
 * @property {Object}
 * @inheritable
 */
ve.ui.MWTransclusionDialog.static.modeCssClasses = {
	'single': 've-ui-mwTransclusionDialog-single',
	'multiple': 've-ui-mwTransclusionDialog-multiple'
};

ve.ui.MWTransclusionDialog.static.bookletLayoutConfig = ve.extendObject(
	{},
	ve.ui.MWTemplateDialog.static.bookletLayoutConfig,
	{ 'outlined': true, 'editable': true }
);

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.MWTransclusionDialog.prototype.onTransclusionReady = function () {
	// Parent method
	ve.ui.MWTransclusionDialog.super.prototype.onTransclusionReady.call( this );

	this.setMode( 'auto' );
};

/**
 * Handle outline controls move events.
 *
 * @param {number} places Number of places to move the selected item
 */
ve.ui.MWTransclusionDialog.prototype.onOutlineControlsMove = function ( places ) {
	var part, promise,
		parts = this.transclusionModel.getParts(),
		item = this.bookletLayout.getOutline().getSelectedItem();

	if ( item ) {
		part = this.transclusionModel.getPartFromId( item.getData() );
		// Move part to new location, and if dialog is loaded switch to new part page
		promise = this.transclusionModel.addPart( part, ve.indexOf( part, parts ) + places );
		if ( this.loaded && !this.preventReselection ) {
			promise.done( ve.bind( this.setPageByName, this, part.getId() ) );
		}
	}
};

/**
 * Handle outline controls remove events.
 */
ve.ui.MWTransclusionDialog.prototype.onOutlineControlsRemove = function () {
	var id, part, param,
		item = this.bookletLayout.getOutline().getSelectedItem();

	if ( item ) {
		id = item.getData();
		part = this.transclusionModel.getPartFromId( id );
		// Check if the part is the actual template, or one of its parameters
		if ( part instanceof ve.dm.MWTemplateModel && id !== part.getId() ) {
			param = part.getParameterFromId( id );
			if ( param instanceof ve.dm.MWParameterModel ) {
				part.removeParameter( param );
			}
		} else if ( part instanceof ve.dm.MWTransclusionPartModel ) {
			this.transclusionModel.removePart( part );
		}
	}
};

/**
 * Handle add template button click events.
 */
ve.ui.MWTransclusionDialog.prototype.onAddTemplateButtonClick = function () {
	this.addPart( new ve.dm.MWTemplatePlaceholderModel( this.transclusionModel ) );
};

/**
 * Handle add content button click events.
 */
ve.ui.MWTransclusionDialog.prototype.onAddContentButtonClick = function () {
	this.addPart( new ve.dm.MWTransclusionContentModel( this.transclusionModel, '' ) );
};

/**
 * Handle add parameter button click events.
 */
ve.ui.MWTransclusionDialog.prototype.onAddParameterButtonClick = function () {
	var part, param,
		item = this.bookletLayout.getOutline().getSelectedItem();

	if ( item ) {
		part = this.transclusionModel.getPartFromId( item.getData() );
		if ( part instanceof ve.dm.MWTemplateModel ) {
			param = new ve.dm.MWParameterModel( part, '', null );
			part.addParameter( param );
		}
	}
};

/**
 * Handle mode button click events.
 */
ve.ui.MWTransclusionDialog.prototype.onModeButtonClick = function () {
	this.setMode( this.mode === 'single' ? 'multiple' : 'single' );
};

/**
 * Handle booklet layout page set events.
 *
 * @param {OO.ui.PageLayout} page Active page
 */
ve.ui.MWTransclusionDialog.prototype.onBookletLayoutSet = function ( page ) {
	this.addParameterButton.setDisabled(
		!( page instanceof ve.ui.MWTemplatePage || page instanceof ve.ui.MWParameterPage )
	);
};

/**
 * @inheritdoc
 */
ve.ui.MWTransclusionDialog.prototype.onReplacePart = function ( removed, added ) {
	ve.ui.MWTransclusionDialog.super.prototype.onReplacePart.call( this, removed, added );
	this.modeButton.setDisabled( !this.isSingleTemplateTransclusion() );
};

/**
 * Checks if transclusion only contains a single template or template placeholder.
 *
 * @returns {boolean} Transclusion only contains a single template or template placeholder
 */
ve.ui.MWTransclusionDialog.prototype.isSingleTemplateTransclusion = function () {
	var parts = this.transclusionModel && this.transclusionModel.getParts();

	return parts && parts.length === 1 && (
		parts[0] instanceof ve.dm.MWTemplateModel ||
		parts[0] instanceof ve.dm.MWTemplatePlaceholderModel
	);
};

/**
 * @inheritdoc
 */
ve.ui.MWTransclusionDialog.prototype.getPageFromPart = function ( part ) {
	var page = ve.ui.MWTransclusionDialog.super.prototype.getPageFromPart.call( this, part );
	if ( !page && part instanceof ve.dm.MWTransclusionContentModel ) {
		return new ve.ui.MWTransclusionContentPage( part, part.getId(), { '$': this.$ } );
	}
	return page;
};

/**
 * Get a label for the apply button.
 *
 * @returns {string} Apply button label
 */
ve.ui.MWTransclusionDialog.prototype.getApplyButtonLabel = function () {
	return !this.selectedNode && !this.isSingleTemplateTransclusion() ?
		ve.msg( 'visualeditor-dialog-transclusion-insert-transclusion' ) :
		ve.ui.MWTransclusionDialog.super.prototype.getApplyButtonLabel.call( this );
};

/**
 * Set dialog mode.
 *
 * Auto mode will choose single if possible.
 *
 * @param {string} [mode='multiple'] Symbolic name of dialog mode, `multiple`, `single` or 'auto'
 */
ve.ui.MWTransclusionDialog.prototype.setMode = function ( mode ) {
	var name, parts, part, single,
		modeCssClasses = ve.ui.MWTransclusionDialog.static.modeCssClasses;

	if ( this.transclusionModel ) {
		parts = this.transclusionModel.getParts();
		part = parts.length && parts[0];
		if ( mode === 'auto' ) {
			mode = this.isSingleTemplateTransclusion() ? 'single' : 'multiple';
		}
	}
	if ( !modeCssClasses[mode] ) {
		mode = 'multiple';
	}
	this.mode = mode;
	single = mode === 'single';
	if ( this.frame.$content ) {
		for ( name in modeCssClasses ) {
			this.frame.$content.toggleClass( modeCssClasses[name], name === mode );
		}
	}
	this.setSize( single ? 'medium' : 'large' );
	this.bookletLayout.toggleOutline( !single );
	this.modeButton
		.setLabel( ve.msg(
			single ?
				'visualeditor-dialog-transclusion-multiple-mode' :
				'visualeditor-dialog-transclusion-single-mode'
		) )
		.setDisabled( !this.isSingleTemplateTransclusion() );
	this.updateTitle();
};

/**
 * Update the dialog title.
 */
ve.ui.MWTransclusionDialog.prototype.updateTitle = function () {
	if ( this.mode === 'multiple' ) {
		this.setTitle( this.constructor.static.title );
	} else {
		// Parent method
		ve.ui.MWTransclusionDialog.super.prototype.updateTitle.call( this );
	}
};

/**
 * Add a part to the transclusion.
 *
 * @param {ve.dm.MWTransclusionPartModel} part Part to add
 */
ve.ui.MWTransclusionDialog.prototype.addPart = function ( part ) {
	var index, promise,
		parts = this.transclusionModel.getParts(),
		item = this.bookletLayout.getOutline().getSelectedItem();

	if ( part ) {
		// Insert after selected part, or at the end if nothing is selected
		index = item ?
			ve.indexOf( this.transclusionModel.getPartFromId( item.getData() ), parts ) + 1 :
			parts.length;
		// Add the part, and if dialog is loaded switch to part page
		promise = this.transclusionModel.addPart( part, index );
		if ( this.loaded && !this.preventReselection ) {
			promise.done( ve.bind( this.setPageByName, this, part.getId() ) );
		}
	}
};

/**
 * @inheritdoc
 */
ve.ui.MWTransclusionDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.MWTransclusionDialog.super.prototype.initialize.call( this );

	// Properties
	this.modeButton = new OO.ui.ButtonWidget( {
		'$': this.$,
		'flags': ['secondary']
	} );
	this.addTemplateButton = new OO.ui.ButtonWidget( {
		'$': this.$,
		'frameless': true,
		'icon': 'template',
		'title': ve.msg( 'visualeditor-dialog-transclusion-add-template' )
	} );
	this.addContentButton = new OO.ui.ButtonWidget( {
		'$': this.$,
		'frameless': true,
		'icon': 'source',
		'title': ve.msg( 'visualeditor-dialog-transclusion-add-content' )
	} );
	this.addParameterButton = new OO.ui.ButtonWidget( {
		'$': this.$,
		'frameless': true,
		'icon': 'parameter',
		'title': ve.msg( 'visualeditor-dialog-transclusion-add-param' )
	} );

	// Events
	this.modeButton.connect( this, { 'click': 'onModeButtonClick' } );
	this.bookletLayout.connect( this, { 'set': 'onBookletLayoutSet' } );
	this.addTemplateButton.connect( this, { 'click': 'onAddTemplateButtonClick' } );
	this.addContentButton.connect( this, { 'click': 'onAddContentButtonClick' } );
	this.addParameterButton.connect( this, { 'click': 'onAddParameterButtonClick' } );
	this.bookletLayout.getOutlineControls()
		.addItems( [ this.addTemplateButton, this.addContentButton, this.addParameterButton ] )
		.connect( this, {
			'move': 'onOutlineControlsMove',
			'remove': 'onOutlineControlsRemove'
		} );

	// Initialization
	this.$foot.append( this.modeButton.$element );
};

/**
 * @inheritdoc
 */
ve.ui.MWTransclusionDialog.prototype.getSetupProcess = function ( data ) {
	return ve.ui.MWTransclusionDialog.super.prototype.getSetupProcess.call( this, data )
		.first( function () {
			this.setMode( 'single' );
			this.modeButton.setDisabled( true );
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.MWTransclusionDialog.prototype.onApplyButtonClick = function () {
	ve.track( 'wikia', {
		'action': ve.track.actions.CLICK,
		'label': 'dialog-template-button-' + ( this.selectedNode ? 'apply-changes' : 'insert-template' )
	} );
	return ve.ui.MWTransclusionDialog.super.prototype.onApplyButtonClick.call( this );
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.MWTransclusionDialog );
