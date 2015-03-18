/*
 * VisualEditor user interface MWTemplateDialog class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Dialog for inserting and editing MediaWiki transclusions.
 *
 * @class
 * @abstract
 * @extends ve.ui.NodeDialog
 *
 * @constructor
 * @param {ve.ui.Surface} surface Surface dialog is for
 * @param {Object} [config] Configuration options
 */
ve.ui.MWTemplateDialog = function VeUiMWTemplateDialog( config ) {
	// Parent constructor
	ve.ui.MWTemplateDialog.super.call( this, config );

	// Properties
	this.transclusionModel = null;
	this.loaded = false;
	this.preventReselection = false;
};

/* Inheritance */

OO.inheritClass( ve.ui.MWTemplateDialog, ve.ui.NodeDialog );

/* Static Properties */

ve.ui.MWTemplateDialog.static.icon = 'template';

ve.ui.MWTemplateDialog.static.modelClasses = [ ve.dm.MWTransclusionNode ];

/**
 * Configuration for booklet layout.
 *
 * @static
 * @property {Object}
 * @inheritable
 */
ve.ui.MWTemplateDialog.static.bookletLayoutConfig = {
	'continuous': true,
	'outlined': false,
	'autoFocus': false
};

/* Methods */

/**
 * Handle the transclusion being ready to use.
 */
ve.ui.MWTemplateDialog.prototype.onTransclusionReady = function () {
	this.loaded = true;
	this.$element.addClass( 've-ui-mwTemplateDialog-ready' );
	this.popPending();
};

/**
 * Handle parts being replaced.
 *
 * @param {ve.dm.MWTransclusionPartModel} removed Removed part
 * @param {ve.dm.MWTransclusionPartModel} added Added part
 */
ve.ui.MWTemplateDialog.prototype.onReplacePart = function ( removed, added ) {
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
		page = this.getPageFromPart( added );
		if ( page ) {
			this.bookletLayout.addPages( [ page ], this.transclusionModel.getIndex( added ) );
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

			// Add required and suggested params to user created templates
			if ( added instanceof ve.dm.MWTemplateModel && this.loaded ) {
				// Prevent selection changes
				this.preventReselection = true;
				//added.addPromptedParameters();
				added.addUnusedParameters();
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
ve.ui.MWTemplateDialog.prototype.onAddParameter = function ( param ) {
	var page, $parameterPages;

	if ( param.getName() ) {
		page = new ve.ui.WikiaParameterPage( param, param.getId(), { '$': this.$ } );
	} else {
		page = new ve.ui.MWParameterPlaceholderPage( param, param.getId(), { '$': this.$ } );
	}
	this.bookletLayout.addPages( [ page ], this.transclusionModel.getIndex( param ) );
	if ( this.loaded && !this.preventReselection ) {
		this.setPageByName( param.getId() );
	} else {
		this.onAddParameterBeforeLoad( page );
	}

	$parameterPages = this.$body.find( '.ve-ui-mwParameterPage' );

	// Recalculate tab indexes
	$parameterPages.each( function ( index ) {
		$( this )
			.find( '.ve-ui-mwParameterPage-field > .oo-ui-textInputWidget > textarea' )
				.attr( 'tabindex', index * 3 + 2 )
			.end()
			.find( '.ve-ui-mwParameterPage-infoButton > a' )
				.attr( 'tabindex', index * 3 + 3 )
			.end()
			.find( '.ve-ui-mwParameterPage-removeButton > a' )
				.attr( 'tabindex', index * 3 + 4 );
	} );

	this.applyButton.$button.attr( 'tabindex', $parameterPages.length * 3 + 2 );
};

/**
 * Additional handling of parameter addition events before loading.
 *
 * @param {ve.ui.MWParameterPage} page Parameter page object
 */
ve.ui.MWTemplateDialog.prototype.onAddParameterBeforeLoad = function () {};

/**
 * Handle remove param events.
 *
 * @param {ve.dm.MWParameterModel} param Removed param
 */
ve.ui.MWTemplateDialog.prototype.onRemoveParameter = function ( param ) {
	var page = this.bookletLayout.getPage( param.getId() ),
		reselect = this.bookletLayout.getClosestPage( page );

	this.bookletLayout.removePages( [ page ] );
	if ( this.loaded && !this.preventReselection ) {
		this.setPageByName( reselect.getName() );
	}
};

/**
 * Checks if transclusion is in a valid state for inserting into the document
 *
 * If the transclusion is empty or only contains a placeholder it will not be insertable.
 *
 * @returns {boolean} Transclusion can be inserted
 */
ve.ui.MWTemplateDialog.prototype.isInsertable = function () {
	var parts = this.transclusionModel && this.transclusionModel.getParts();

	return !this.loading &&
		parts.length &&
		( parts.length > 1 || !( parts[0] instanceof ve.dm.MWTemplatePlaceholderModel ) );
};

/**
 * Get a page for a transclusion part.
 *
 * @param {ve.dm.MWTransclusionModel} part Part to get page for
 * @return {OO.ui.PageLayout|null} Page for part, null if no matching page could be found
 */
ve.ui.MWTemplateDialog.prototype.getPageFromPart = function ( part ) {
	if ( part instanceof ve.dm.MWTemplateModel ) {
		return new ve.ui.MWTemplatePage( part, part.getId(), { '$': this.$ } );
	} else if ( part instanceof ve.dm.MWTemplatePlaceholderModel ) {
		return new ve.ui.MWTemplatePlaceholderPage( part, part.getId(), { '$': this.$ } );
	}
	return null;
};

/**
 * Get the label of a template or template placeholder.
 *
 * @param {ve.dm.MWTemplateModel|ve.dm.MWTemplatePlaceholderModel} part Part to check
 * @returns {string} Label of template or template placeholder
 */
ve.ui.MWTemplateDialog.prototype.getTemplatePartLabel = function ( part ) {
	return part instanceof ve.dm.MWTemplateModel ?
		part.getSpec().getLabel() : ve.msg( 'visualeditor-dialog-transclusion-placeholder' );
};

/**
 * @inheritdoc
 */
ve.ui.MWTemplateDialog.prototype.getApplyButtonLabel = function () {
	return this.selectedNode ?
		ve.ui.MWTemplateDialog.super.prototype.getApplyButtonLabel.call( this ) :
		ve.msg( 'visualeditor-dialog-transclusion-insert-template' );
};

/**
 * @inheritdoc
 */
ve.ui.MWTemplateDialog.prototype.getSelectedNode = function ( data ) {
	var selectedNode = ve.ui.MWTemplateDialog.super.prototype.getSelectedNode.call( this );

	// Data initialization
	data = data || {};

	// Require template to match if specified
	if ( selectedNode && data.template && !selectedNode.isSingleTemplate( data.template ) ) {
		return null;
	}

	return selectedNode;
};

/**
 * Set the page by name.
 *
 * Page names are always the ID of the part or param they represent.
 *
 * @param {string} name Page name
 */
ve.ui.MWTemplateDialog.prototype.setPageByName = function ( name ) {
	if ( this.bookletLayout.isOutlined() ) {
		this.bookletLayout.getOutline().selectItem(
			this.bookletLayout.getOutline().getItemFromData( name )
		);
	} else {
		this.bookletLayout.setPage( name );
	}
};

/**
 * Update the dialog title.
 */
ve.ui.MWTemplateDialog.prototype.updateTitle = function () {
	var parts = this.transclusionModel && this.transclusionModel.getParts();

	this.setTitle(
		parts && parts.length === 1 && parts[0] ?
			this.getTemplatePartLabel( parts[0] ) :
			ve.msg( 'visualeditor-dialog-transclusion-loading' )
	);
};

/**
 * @inheritdoc
 */
ve.ui.MWTemplateDialog.prototype.applyChanges = function () {
	var surfaceModel = this.getFragment().getSurface(),
		obj = this.transclusionModel.getPlainObject();

	if ( this.selectedNode instanceof ve.dm.MWTransclusionNode ) {
		this.transclusionModel.updateTransclusionNode( surfaceModel, this.selectedNode );
	} else if ( obj !== null ) {
		// Collapse returns a new fragment, so update this.fragment
		this.fragment = this.getFragment().collapseRangeToEnd();
		this.transclusionModel.insertTransclusionNode( this.getFragment() );
	}

	// Parent method
	return ve.ui.MWTemplateDialog.super.prototype.applyChanges.call( this );
};

/**
 * @inheritdoc
 */
ve.ui.MWTemplateDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.MWTemplateDialog.super.prototype.initialize.call( this );

	// Properties
	this.bookletLayout = new OO.ui.BookletLayout(
		ve.extendObject(
			{ '$': this.$ },
			this.constructor.static.bookletLayoutConfig
		)
	);

	// Initialization
	this.frame.$content.addClass( 've-ui-mwTemplateDialog' );
	this.panels.addItems( [ this.bookletLayout ] );
};

/**
 * @inheritdoc
 */
ve.ui.MWTemplateDialog.prototype.getSetupProcess = function ( data ) {
	return ve.ui.MWTemplateDialog.super.prototype.getSetupProcess.call( this, data )
		.next( function () {
			var template, promise;

			// Data initialization
			data = data || {};

			// Properties
			this.loaded = false;
			this.transclusionModel = new ve.dm.WikiaTransclusionModel();

			// Events
			this.transclusionModel.connect( this, { 'replace': 'onReplacePart' } );

			// Initialization
			if ( !this.selectedNode ) {
				if ( data.template ) {
					// New specified template
					template = ve.dm.MWTemplateModel.newFromName(
						this.transclusionModel, data.template
					);
					promise = this.transclusionModel.addPart( template ).done( ve.bind( function () {
						this.initializeNewTemplateParameters();
					}, this ) );
				} else {
					// New template placeholder
					promise = this.transclusionModel.addPart(
						new ve.dm.MWTemplatePlaceholderModel( this.transclusionModel )
					);
				}
			} else {
				// Load existing template
				promise = this.transclusionModel
					.load( ve.copy( this.selectedNode.getAttribute( 'mw' ) ) )
					.done( ve.bind( function () {
						this.initializeTemplateParameters();
					}, this ) );
			}
			this.applyButton.setDisabled( true );
			this.pushPending();
			promise.always( ve.bind( this.onTransclusionReady, this ) );
		}, this );
};

/**
 * Initialize parameters for new template insertion
 *
 * @method
 */
ve.ui.MWTemplateDialog.prototype.initializeNewTemplateParameters = function () {
	var i, parts = this.transclusionModel.getParts();
	for ( i = 0; i < parts.length; i++ ) {
		if ( parts[i] instanceof ve.dm.MWTemplateModel ) {
			parts[i].addPromptedParameters();
		}
	}
};

/**
 * Intentionally empty. This is provided for Wikia extensibility.
 *
 * @method
 */
ve.ui.MWTemplateDialog.prototype.initializeTemplateParameters = function () {};

/**
 * @inheritdoc
 */
ve.ui.MWTemplateDialog.prototype.getTeardownProcess = function ( data ) {
	return ve.ui.MWTemplateDialog.super.prototype.getTeardownProcess.call( this, data )
		.first( function () {
			// Cleanup
			this.$element.removeClass( 've-ui-mwTemplateDialog-ready' );
			this.transclusionModel.disconnect( this );
			this.transclusionModel.abortRequests();
			this.transclusionModel = null;
			this.bookletLayout.clearPages();
			this.content = null;
		}, this );
};
