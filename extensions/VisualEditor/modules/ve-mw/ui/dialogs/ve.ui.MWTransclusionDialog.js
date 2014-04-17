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
 * @extends ve.ui.Dialog
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.MWTransclusionDialog = function VeUiMWTransclusionDialog( config ) {
	// Parent constructor
	ve.ui.Dialog.call( this, config );

	// Properties
	this.transclusionNode = null;
	this.transclusion = null;
	this.loaded = false;
	this.preventReselection = false;
	this.mode = null;
	this.inserting = false;
};

/* Inheritance */

OO.inheritClass( ve.ui.MWTransclusionDialog, ve.ui.Dialog );

/* Static Properties */

ve.ui.MWTransclusionDialog.static.name = 'transclusion';

ve.ui.MWTransclusionDialog.static.icon = 'template';

ve.ui.MWTransclusionDialog.static.title =
	OO.ui.deferMsg( 'visualeditor-dialog-transclusion-title' );

/**
 * Map of symbolic mode names and CSS classes.
 *
 * @static
 * @property {Object}
 */
ve.ui.MWTransclusionDialog.static.modeCssClasses = {
	'single': 've-ui-mwTransclusionDialog-single',
	'multiple': 've-ui-mwTransclusionDialog-multiple'
};

/* Methods */

/**
 * Handle outline controls move events.
 *
 * @param {number} places Number of places to move the selected item
 */
ve.ui.MWTransclusionDialog.prototype.onOutlineControlsMove = function ( places ) {
	var part, promise,
		parts = this.transclusion.getParts(),
		item = this.bookletLayout.getOutline().getSelectedItem();

	if ( item ) {
		part = this.transclusion.getPartFromId( item.getData() );
		// Move part to new location, and if dialog is loaded switch to new part page
		promise = this.transclusion.addPart( part, ve.indexOf( part, parts ) + places );
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
		part = this.transclusion.getPartFromId( id );
		// Check if the part is the actual template, or one of its parameters
		if ( part instanceof ve.dm.MWTemplateModel && id !== part.getId() ) {
			param = part.getParameterFromId( id );
			if ( param instanceof ve.dm.MWParameterModel ) {
				part.removeParameter( param );
			}
		} else if ( part instanceof ve.dm.MWTransclusionPartModel ) {
			this.transclusion.removePart( part );
		}
	}
};

/**
 * Handle add template button click events.
 */
ve.ui.MWTransclusionDialog.prototype.onAddTemplateButtonClick = function () {
	this.addPart( new ve.dm.MWTemplatePlaceholderModel( this.transclusion ) );
};

/**
 * Handle add content button click events.
 */
ve.ui.MWTransclusionDialog.prototype.onAddContentButtonClick = function () {
	this.addPart( new ve.dm.MWTransclusionContentModel( this.transclusion, '' ) );
};

/**
 * Handle add parameter button click events.
 */
ve.ui.MWTransclusionDialog.prototype.onAddParameterButtonClick = function () {
	var part, param,
		item = this.bookletLayout.getOutline().getSelectedItem();

	if ( item ) {
		part = this.transclusion.getPartFromId( item.getData() );
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
 * Handle parts being replaced.
 *
 * @param {ve.dm.MWTransclusionPartModel} removed Removed part
 * @param {ve.dm.MWTransclusionPartModel} added Added part
 */
ve.ui.MWTransclusionDialog.prototype.onReplacePart = function ( removed, added ) {
	var i, len, page, name, names, params, partPage, reselect,
		removePages = [];

	if ( removed ) {
		// Remove parameter pages of removed templates
		partPage = this.bookletLayout.getPage( removed.getId() );
		if ( removed instanceof ve.dm.MWTemplateModel ) {
			params = removed.getParameters();
			for ( name in params ) {
				removePages.push( this.bookletLayout.getPage( params[name].getId() ) );
			}
			removed.disconnect( this );
		}
		if ( this.loaded && !this.preventReselection && partPage.isActive() ) {
			reselect = this.bookletLayout.getClosestPage( partPage );
		}
		removePages.push( partPage );
		this.bookletLayout.removePages( removePages );
	}

	if ( added ) {
		if ( added instanceof ve.dm.MWTemplateModel ) {
			page = new ve.ui.MWTemplatePage( added, added.getId(), { '$': this.$ } );
		} else if ( added instanceof ve.dm.MWTransclusionContentModel ) {
			page = new ve.ui.MWTransclusionContentPage( added, added.getId(), { '$': this.$ } );
		} else if ( added instanceof ve.dm.MWTemplatePlaceholderModel ) {
			page = new ve.ui.MWTemplatePlaceholderPage( added, added.getId(), { '$': this.$ } );
		}
		if ( page ) {
			this.bookletLayout.addPages( [ page ], this.transclusion.getIndex( added ) );
			if ( reselect ) {
				// Use added page instead of closest page
				this.setPageByName( added.getId() );
			}
			// Add existing params to templates (the template might be being moved)
			if ( added instanceof ve.dm.MWTemplateModel ) {
				names = added.getParameterNames();
				params = added.getParameters();
				// Prevent selection changes
				this.preventReselection = true;
				for ( i = 0, len = names.length; i < len; i++ ) {
					this.onAddParameter( params[names[i]] );
				}
				this.preventReselection = false;
				added.connect( this, { 'add': 'onAddParameter', 'remove': 'onRemoveParameter' } );
				if ( names.length ) {
					this.setPageByName( params[names[0]].getId() );
				}
			}

			// Add required params to user created templates
			if ( added instanceof ve.dm.MWTemplateModel && this.loaded ) {
				// Prevent selection changes
				this.preventReselection = true;
				added.addRequiredParameters();
				this.preventReselection = false;
				names = added.getParameterNames();
				params = added.getParameters();
				if ( names.length ) {
					this.setPageByName( params[names[0]].getId() );
				}
			}
		}
	} else if ( reselect ) {
		this.setPageByName( reselect.getName() );
	}
	// Update widgets related to a transclusion being a single template or not
	this.modeButton.setDisabled( !this.isSingleTemplateTransclusion() );
	this.applyButton
		.setLabel( this.getApplyButtonLabel() )
		.setDisabled( !this.isInsertable() );
	this.updateTitle();
};

/**
 * Handle add param events.
 *
 * @param {ve.dm.MWParameterModel} param Added param
 */
ve.ui.MWTransclusionDialog.prototype.onAddParameter = function ( param ) {
	var page;

	if ( param.getName() ) {
		page = new ve.ui.MWParameterPage( param, param.getId(), { '$': this.$ } );
	} else {
		page = new ve.ui.MWParameterPlaceholderPage( param, param.getId(), { '$': this.$ } );
	}
	this.bookletLayout.addPages( [ page ], this.transclusion.getIndex( param ) );
	if ( this.loaded && !this.preventReselection ) {
		this.setPageByName( param.getId() );
	}
};

/**
 * Handle remove param events.
 *
 * @param {ve.dm.MWParameterModel} param Removed param
 */
ve.ui.MWTransclusionDialog.prototype.onRemoveParameter = function ( param ) {
	var page = this.bookletLayout.getPage( param.getId() ),
		reselect = this.bookletLayout.getClosestPage( page );

	this.bookletLayout.removePages( [ page ] );
	if ( this.loaded && !this.preventReselection ) {
		this.setPageByName( reselect.getName() );
	}
};

/**
 * Checks if transclusion only contains a single template or template placeholder.
 *
 * @returns {boolean} Transclusion only contains a single template or template placeholder
 */
ve.ui.MWTransclusionDialog.prototype.isSingleTemplateTransclusion = function () {
	var parts = this.transclusion && this.transclusion.getParts();

	return parts && parts.length === 1 && (
		parts[0] instanceof ve.dm.MWTemplateModel ||
		parts[0] instanceof ve.dm.MWTemplatePlaceholderModel
	);
};

/**
 * Checks if transclusion is in a valid state for inserting into the document
 *
 * If the transclusion is empty or only contains a placeholder it will not be insertable.
 *
 * @returns {boolean} Transclusion can be inserted
 */
ve.ui.MWTransclusionDialog.prototype.isInsertable = function () {
	var parts = this.transclusion && this.transclusion.getParts();

	return !this.loading &&
		parts.length &&
		( parts.length > 1 || !( parts[0] instanceof ve.dm.MWTemplatePlaceholderModel ) );
};

/**
 * Get the label of a template or template placeholder.
 *
 * @param {ve.dm.MWTemplateModel|ve.dm.MWTemplatePlaceholderModel} part Part to check
 * @returns {string} Label of template or template placeholder
 */
ve.ui.MWTransclusionDialog.prototype.getTemplatePartLabel = function ( part ) {
	return part instanceof ve.dm.MWTemplateModel ?
		part.getSpec().getLabel() : ve.msg( 'visualeditor-dialog-transclusion-placeholder' );
};

/**
 * Get a label for the apply button.
 *
 * @returns {string} Apply button label
 */
ve.ui.MWTransclusionDialog.prototype.getApplyButtonLabel = function () {
	var single = this.isSingleTemplateTransclusion();
	return ve.msg(
		this.inserting ?
			(
				single ?
					'visualeditor-dialog-transclusion-insert-template' :
					'visualeditor-dialog-transclusion-insert-transclusion'
			) : 'visualeditor-dialog-action-apply'
	);
};

/**
 * Set the page by name.
 *
 * Page names are always the ID of the part or param they represent.
 *
 * @param {string} name Page name
 */
ve.ui.MWTransclusionDialog.prototype.setPageByName = function ( name ) {
	if ( this.bookletLayout.isOutlined() ) {
		this.bookletLayout.getOutline().selectItem(
			this.bookletLayout.getOutline().getItemFromData( name )
		);
	} else {
		this.bookletLayout.setPage( name );
	}
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

	if ( this.transclusion ) {
		parts = this.transclusion.getParts();
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
	this.modeButton.setLabel( ve.msg(
		single ?
			'visualeditor-dialog-transclusion-multiple-mode' :
			'visualeditor-dialog-transclusion-single-mode'
	) );
	this.updateTitle();
};

/**
 * Update the dialog title.
 */
ve.ui.MWTransclusionDialog.prototype.updateTitle = function () {
	var parts = this.transclusion && this.transclusion.getParts();

	this.setTitle(
		this.mode === 'single' && parts && parts.length && parts[0] ?
			this.getTemplatePartLabel( parts[0] ) :
			this.constructor.static.title
	);
};

/**
 * Add a part to the transclusion.
 *
 * @param {ve.dm.MWTransclusionPartModel} part Part to add
 */
ve.ui.MWTransclusionDialog.prototype.addPart = function ( part ) {
	var index, promise,
		parts = this.transclusion.getParts(),
		item = this.bookletLayout.getOutline().getSelectedItem();

	if ( part ) {
		// Insert after selected part, or at the end if nothing is selected
		index = item ?
			ve.indexOf( this.transclusion.getPartFromId( item.getData() ), parts ) + 1 :
			parts.length;
		// Add the part, and if dialog is loaded switch to part page
		promise = this.transclusion.addPart( part, index );
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
	ve.ui.Dialog.prototype.initialize.call( this );

	// Properties
	this.applyButton = new OO.ui.ButtonWidget( {
		'$': this.$,
		'flags': ['primary']
	} );
	this.modeButton = new OO.ui.ButtonWidget( { '$': this.$ } );
	this.bookletLayout = new OO.ui.BookletLayout( {
		'$': this.$,
		'continuous': true,
		'autoFocus': true,
		'outlined': true,
		'editable': true
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
	this.applyButton.connect( this, { 'click': [ 'close', { 'action': 'apply' } ] } );
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
	this.frame.$content.addClass( 've-ui-mwTransclusionDialog' );
	this.$body.append( this.bookletLayout.$element );
	this.$foot.append( this.applyButton.$element, this.modeButton.$element );
	this.setMode( 'single' );
};

/**
 * Get the transclusion node to be edited.
 *
 * @returns {ve.dm.MWTransclusionNode|null} Transclusion node to be edited, null if none exists
 */
ve.ui.MWTransclusionDialog.prototype.getTransclusionNode = function () {
	var focusedNode = this.getFragment().getSelectedNode();
	return focusedNode instanceof ve.dm.MWTransclusionNode ? focusedNode : null;
};

/**
 * Save changes.
 */
ve.ui.MWTransclusionDialog.prototype.saveChanges = function () {
	var surfaceFragment = this.getFragment(),
		surfaceModel = surfaceFragment.getSurface(),
		obj = this.transclusion.getPlainObject();

	if ( this.transclusionNode instanceof ve.dm.MWTransclusionNode ) {
		this.transclusion.updateTransclusionNode( surfaceModel, this.transclusionNode );
	} else if ( obj !== null ) {
		this.transclusion.insertTransclusionNode( surfaceFragment );
	}
};

/**
 * @inheritdoc
 */
ve.ui.MWTransclusionDialog.prototype.setup = function ( data ) {
	var template, promise,
		transclusionNode = this.getTransclusionNode( data );

	// Parent method
	ve.ui.Dialog.prototype.setup.call( this, data );

	// Data initialization
	data = data || {};

	// Properties
	this.loaded = false;
	this.transclusion = new ve.dm.MWTransclusionModel();
	this.transclusionNode = transclusionNode instanceof ve.dm.MWTransclusionNode &&
		( !data.template || transclusionNode.isSingleTemplate( data.template ) ) ?
			transclusionNode : null;
	this.inserting = !this.transclusionNode;

	// Events
	this.transclusion.connect( this, { 'replace': 'onReplacePart' } );

	// Initialization
	this.applyButton
		.setDisabled( true )
		.setLabel( ve.msg( 'visualeditor-dialog-transclusion-loading' ) );
	if ( this.inserting ) {
		if ( data.template ) {
			template = ve.dm.MWTemplateModel.newFromName( this.transclusion, data.template );
			promise = this.transclusion.addPart( template ).done( function () {
				template.addRequiredParameters();
			} );
		} else {
			promise = this.transclusion.addPart(
				new ve.dm.MWTemplatePlaceholderModel( this.transclusion )
			);
		}
	} else {
		promise = this.transclusion
			.load( ve.copy( this.transclusionNode.getAttribute( 'mw' ) ) );
	}
	promise.always( ve.bind( function () {
		this.loaded = true;
		this.setMode( 'auto' );
	}, this ) );
};

/**
 * @inheritdoc
 */
ve.ui.MWTransclusionDialog.prototype.teardown = function ( data ) {
	// Data initialization
	data = data || {};

	// Save changes
	if ( data.action === 'apply' ) {
		this.saveChanges();
	}

	this.transclusion.disconnect( this );
	this.transclusion.abortRequests();
	this.transclusion = null;
	this.bookletLayout.clearPages();
	this.transclusionNode = null;
	this.content = null;

	this.setMode( 'single' );

	// Parent method
	ve.ui.Dialog.prototype.teardown.call( this, data );
};

/* Registration */

ve.ui.dialogFactory.register( ve.ui.MWTransclusionDialog );
