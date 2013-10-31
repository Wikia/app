/*!
 * VisualEditor user interface MWTransclusionDialog class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Dialog for inserting and editing MediaWiki transclusions.
 *
 * See https://raw.github.com/wikimedia/mediawiki-extensions-TemplateData/master/spec.templatedata.json
 * for the latest version of the TemplateData specification.
 *
 * @class
 * @extends ve.ui.MWDialog
 *
 * @constructor
 * @param {ve.ui.Surface} surface
 * @param {Object} [config] Configuration options
 */
ve.ui.MWTransclusionDialog = function VeUiMWTransclusionDialog( surface, config ) {
	// Parent constructor
	ve.ui.MWDialog.call( this, surface, config );

	// Properties
	this.node = null;
	this.transclusion = null;
	this.pending = [];
};

/* Inheritance */

ve.inheritClass( ve.ui.MWTransclusionDialog, ve.ui.MWDialog );

/* Static Properties */

ve.ui.MWTransclusionDialog.static.name = 'transclusion';

ve.ui.MWTransclusionDialog.static.titleMessage = 'visualeditor-dialog-transclusion-title';

ve.ui.MWTransclusionDialog.static.icon = 'template';

/* Methods */

/** */
ve.ui.MWTransclusionDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.MWDialog.prototype.initialize.call( this );

	// Properties
	this.applyButton = new ve.ui.ButtonWidget( {
		'$$': this.$$, 'label': ve.msg( 'visualeditor-dialog-action-apply' ), 'flags': ['primary']
	} );
	this.pagedOutlineLayout = new ve.ui.PagedOutlineLayout( {
		'$$': this.frame.$$,
		'editable': true,
		'adders': [
			{
				'name': 'template',
				'icon': 'template',
				'title': ve.msg( 'visualeditor-dialog-transclusion-add-template' )
			},
			{
				'name': 'content',
				'icon': 'source',
				'title': ve.msg( 'visualeditor-dialog-transclusion-add-content' )
			}
		]
	} );

	// Events
	this.pagedOutlineLayout.getOutlineControls().connect( this, {
		'move': 'onOutlineControlsMove',
		'add': 'onOutlineControlsAdd'
	} );
	this.applyButton.connect( this, { 'click': [ 'close', 'apply' ] } );

	// Initialization
	this.$body.append( this.pagedOutlineLayout.$ );
	this.$foot.append( this.applyButton.$ );
};

/** */
ve.ui.MWTransclusionDialog.prototype.onOpen = function () {
	// Parent method
	ve.ui.MWDialog.prototype.onOpen.call( this );

	// Sanity check
	this.node = this.surface.getView().getFocusedNode();

	// Properties
	this.transclusion = new ve.dm.MWTransclusionModel();

	// Events
	this.transclusion.connect( this, { 'add': 'onAddPart', 'remove': 'onRemovePart' } );

	// Initialization
	if ( this.node instanceof ve.ce.MWTransclusionNode ) {
		this.transclusion.load( ve.copy( this.node.getModel().getAttribute( 'mw' ) ) );
	} else {
		this.transclusion.addPart(
			new ve.dm.MWTemplatePlaceholderModel( this.transclusion, 'user' )
		);
	}
};

/** */
ve.ui.MWTransclusionDialog.prototype.onClose = function ( action ) {
	var surfaceModel = this.surface.getModel(),
		obj = this.transclusion.getPlainObject();

	// Parent method
	ve.ui.MWDialog.prototype.onClose.call( this );

	// Save changes
	if ( action === 'apply' ) {
		if ( this.node instanceof ve.ce.MWTransclusionNode ) {
			if ( obj !== null ) {
				surfaceModel.getFragment().changeAttributes( { 'mw': obj } );
			} else {
				surfaceModel.getFragment().removeContent();
			}
		} else if ( obj !== null ) {
			surfaceModel.getFragment().collapseRangeToEnd().insertContent( [
				{
					'type': 'mwTransclusionInline',
					'attributes': {
						'mw': obj
					}
				},
				{ 'type': '/mwTransclusionInline' }
			] );
		}
	}

	this.transclusion.disconnect( this );
	this.transclusion.abortRequests();
	this.transclusion = null;
	this.pagedOutlineLayout.clearPages();
	this.node = null;
	this.content = null;
};

/**
 * Handle add part events.
 *
 * @method
 * @param {ve.dm.MWTransclusionPartModel} part Added part
 */
ve.ui.MWTransclusionDialog.prototype.onAddPart = function ( part ) {
	var i, len, page, params, names, pending, item, spec;

	if ( part instanceof ve.dm.MWTemplateModel ) {
		page = this.getTemplatePage( part );
	} else if ( part instanceof ve.dm.MWTransclusionContentModel ) {
		page = this.getContentPage( part );
	} else if ( part instanceof ve.dm.MWTemplatePlaceholderModel ) {
		page = this.getPlaceholderPage( part );
	}
	if ( page ) {
		page.index = this.getPageIndex( part );
		this.pagedOutlineLayout.addPage( part.getId(), page );
		// Add existing params to templates
		if ( part instanceof ve.dm.MWTemplateModel ) {
			names = part.getParameterNames();
			params = part.getParameters();
			for ( i = 0, len = names.length; i < len; i++ ) {
				this.onAddParameter( params[names[i]] );
			}
			part.connect( this, { 'add': 'onAddParameter', 'remove': 'onRemoveParameter' } );
		}
	}

	// Add required params to user created templates
	if ( part instanceof ve.dm.MWTemplateModel && part.getOrigin() === 'user' ) {
		spec = part.getSpec();
		names = spec.getParameterNames();
		for ( i = 0, len = names.length; i < len; i++ ) {
			// Only add required params
			if ( spec.isParameterRequired( names[i] ) ) {
				part.addParameter( new ve.dm.MWTemplateParameterModel( part, names[i] ) );
			}
		}
	}

	// Resolve pending placeholder
	for ( i = 0, len = this.pending.length; i < len; i++ ) {
		pending = this.pending[i];
		if ( pending.part === part ) {
			// Auto-select new part if placeholder is still selected
			item = this.pagedOutlineLayout.getOutline().getSelectedItem();
			if ( item.getData() === pending.placeholder.getId() ) {
				this.setPageByName( part.getId() );
			}
			// Cleanup
			pending.placeholder.remove();
			this.pending.splice( i, 1 );
			break;
		}
	}
};

/**
 * Handle remove part events.
 *
 * @method
 * @param {ve.dm.MWTransclusionPartModel} part Removed part
 */
ve.ui.MWTransclusionDialog.prototype.onRemovePart = function ( part ) {
	var name, params;

	if ( part instanceof ve.dm.MWTemplateModel ) {
		params = part.getParameters();
		for ( name in params ) {
			this.pagedOutlineLayout.removePage( params[name].getId() );
		}
		part.disconnect( this );
	}
	this.pagedOutlineLayout.removePage( part.getId() );
};

/**
 * Handle add param events.
 *
 * @method
 * @param {ve.dm.MWTemplateParameterModel} param Added param
 */
ve.ui.MWTransclusionDialog.prototype.onAddParameter = function ( param ) {
	var page = this.getParameterPage( param );
	page.index = this.getPageIndex( param );
	this.pagedOutlineLayout.addPage( param.getId(), page );
};

/**
 * Handle remove param events.
 *
 * @method
 * @param {ve.dm.MWTemplateParameterModel} param Removed param
 */
ve.ui.MWTransclusionDialog.prototype.onRemoveParameter = function ( param ) {
	this.pagedOutlineLayout.removePage( param.getId() );
	// Return to template page
	this.setPageByName( param.getTemplate().getId() );
};

/**
 * Handle outline controls move events.
 *
 * @method
 * @param {number} places Number of places to move the selected item
 */
ve.ui.MWTransclusionDialog.prototype.onOutlineControlsMove = function ( places ) {
	var part, index, name,
		parts = this.transclusion.getParts(),
		item = this.pagedOutlineLayout.getOutline().getSelectedItem();

	if ( item ) {
		name = item.getData();
		part = this.transclusion.getPartFromId( name );
		index = ve.indexOf( part, parts );
		// Auto-removes part from old location
		this.transclusion.addPart( part, index + places )
			.done( ve.bind( this.setPageByName, this, part.getId() ) );
	}
};

/**
 * Handle outline controls add events.
 *
 * @method
 * @param {string} type Type of item to add
 */
ve.ui.MWTransclusionDialog.prototype.onOutlineControlsAdd = function ( type ) {
	var part;

	if ( type === 'content' ) {
		part = new ve.dm.MWTransclusionContentModel( this.transclusion, '', 'user' );
	} else if ( type === 'template' ) {
		part = new ve.dm.MWTemplatePlaceholderModel( this.transclusion, 'user' );
	}
	if ( part ) {
		this.transclusion.addPart( part, this.getPartInsertionIndex() )
			.done( ve.bind( this.setPageByName, this, part.getId() ) );
	}
};

/**
 * Get an index for part insertion.
 *
 * @method
 * @returns {number} Index to insert new parts at
 */
ve.ui.MWTransclusionDialog.prototype.getPartInsertionIndex = function () {
	var parts = this.transclusion.getParts(),
		item = this.pagedOutlineLayout.getOutline().getSelectedItem();

	if ( item ) {
		return ve.indexOf( this.transclusion.getPartFromId( item.getData() ), parts ) + 1;
	}
	return parts.length;
};

/**
 * Set the page by name.
 *
 * Page names are always the ID of the part or param they represent.
 *
 * @method
 * @param {string} name Page name
 */
ve.ui.MWTransclusionDialog.prototype.setPageByName = function ( name ) {
	this.pagedOutlineLayout.getOutline().selectItem(
		this.pagedOutlineLayout.getOutline().getItemFromData( name )
	);
};

/**
 * Get the page index of an item.
 *
 * @method
 * @param {ve.dm.MWTransclusionPartModel|ve.dm.MWTemplateParameterModel} item Part or parameter
 * @returns {number} Page index of item
 */
ve.ui.MWTransclusionDialog.prototype.getPageIndex = function ( item ) {
	// Build pages from parts
	var i, iLen, j, jLen, part, names,
		parts = this.transclusion.getParts(),
		index = 0;

	// Populate pages
	for ( i = 0, iLen = parts.length; i < iLen; i++ ) {
		part = parts[i];
		if ( part === item ) {
			return index;
		}
		index++;
		if ( part instanceof ve.dm.MWTemplateModel ) {
			names = part.getParameterNames();
			for ( j = 0, jLen = names.length; j < jLen; j++ ) {
				if ( part.getParameter( names[j] ) === item ) {
					return index;
				}
				index++;
			}
		}
	}
	return -1;
};

/**
 * Get page for transclusion content.
 *
 * @method
 * @param {ve.dm.MWTransclusionContentModel} content Content model
 */
ve.ui.MWTransclusionDialog.prototype.getContentPage = function ( content ) {
	var valueFieldset, textInput, optionsFieldset, removeButton;

	valueFieldset = new ve.ui.FieldsetLayout( {
		'$$': this.frame.$$,
		'label': ve.msg( 'visualeditor-dialog-transclusion-content' ),
		'icon': 'source'
	} );

	textInput = new ve.ui.TextInputWidget( { '$$': this.frame.$$, 'multiline': true } );
	textInput.setValue( content.getValue() );
	textInput.connect( this, { 'change': function () {
		content.setValue( textInput.getValue() );
	} } );
	textInput.$.addClass( 've-ui-mwTransclusionDialog-input' );
	valueFieldset.$.append( textInput.$ );

	optionsFieldset = new ve.ui.FieldsetLayout( {
		'$$': this.frame.$$,
		'label': ve.msg( 'visualeditor-dialog-transclusion-options' ),
		'icon': 'settings'
	} );

	removeButton = new ve.ui.ButtonWidget( {
		'$$': this.frame.$$,
		'label': ve.msg( 'visualeditor-dialog-transclusion-remove-content' ),
		'flags': ['destructive']
	} );
	removeButton.connect( this, { 'click': function () {
		content.remove();
	} } );
	optionsFieldset.$.append( removeButton.$ );

	return {
		'label': ve.msg( 'visualeditor-dialog-transclusion-content' ),
		'icon': 'source',
		'$content': valueFieldset.$.add( optionsFieldset.$ ),
		'moveable': true
	};
};

/**
 * Get page for a template.
 *
 * @method
 * @param {ve.dm.MWTemplateModel} template Template model
 */
ve.ui.MWTransclusionDialog.prototype.getTemplatePage = function ( template ) {
	var infoFieldset, addParameterFieldset, addParameterSearch, optionsFieldset,
		removeButton,
		spec = template.getSpec(),
		label = spec.getLabel(),
		description = spec.getDescription();

	function addParameter( name ) {
		var param;

		if ( name ) {
			param = new ve.dm.MWTemplateParameterModel( template, name );
			template.addParameter( param );
			addParameterSearch.query.setValue();
			this.setPageByName( param.getId() );
		}
	}

	infoFieldset = new ve.ui.FieldsetLayout( {
		'$$': this.frame.$$,
		'label': label,
		'icon': 'template'
	} );

	if ( description ) {
		infoFieldset.$.append( this.frame.$$( '<div>' ).text( description ) );
	}

	addParameterFieldset = new ve.ui.FieldsetLayout( {
		'$$': this.frame.$$,
		'label': ve.msg( 'visualeditor-dialog-transclusion-add-param' ),
		'icon': 'parameter'
	} );
	addParameterFieldset.$.addClass( 've-ui-mwTransclusionDialog-addParameterFieldset' );
	addParameterSearch = new ve.ui.MWParameterSearchWidget( template, { '$$': this.frame.$$ } );
	addParameterSearch.connect( this, { 'select': addParameter } );
	addParameterFieldset.$.append( addParameterSearch.$ );

	optionsFieldset = new ve.ui.FieldsetLayout( {
		'$$': this.frame.$$,
		'label': ve.msg( 'visualeditor-dialog-transclusion-options' ),
		'icon': 'settings'
	} );

	removeButton = new ve.ui.ButtonWidget( {
		'$$': this.frame.$$,
		'label': ve.msg( 'visualeditor-dialog-transclusion-remove-template' ),
		'flags': ['destructive']
	} );
	removeButton.connect( this, { 'click': function () {
		template.remove();
	} } );
	optionsFieldset.$.append( removeButton.$ );

	return {
		'label': label,
		'icon': 'template',
		'$content': infoFieldset.$.add( addParameterFieldset.$ ).add( optionsFieldset.$ ),
		'moveable': true
	};
};

/**
 * Get page for a parameter.
 *
 * @method
 * @param {ve.dm.MWTemplateParameterModel} parameter Parameter model
 */
ve.ui.MWTransclusionDialog.prototype.getParameterPage = function ( parameter ) {
	var valueFieldset, optionsFieldset, textInput, inputLabel, removeButton,
		spec = parameter.getTemplate().getSpec(),
		name = parameter.getName(),
		label = spec.getParameterLabel( name ),
		description = spec.getParameterDescription( name );

	valueFieldset = new ve.ui.FieldsetLayout( {
		'$$': this.frame.$$,
		'label': label,
		'icon': 'parameter'
	} );

	if ( description ) {
		inputLabel = new ve.ui.InputLabelWidget( {
			'$$': this.frame.$$,
			'input': textInput,
			'label': description
		} );
		valueFieldset.$.append( inputLabel.$ );
	}

	textInput = new ve.ui.TextInputWidget( { '$$': this.frame.$$, 'multiline': true } );
	textInput.setValue( parameter.getValue() );
	textInput.connect( this, { 'change': function () {
		parameter.setValue( textInput.getValue() );
	} } );
	textInput.$.addClass( 've-ui-mwTransclusionDialog-input' );
	valueFieldset.$.append( textInput.$ );

	optionsFieldset = new ve.ui.FieldsetLayout( {
		'$$': this.frame.$$,
		'label': ve.msg( 'visualeditor-dialog-transclusion-options' ),
		'icon': 'settings'
	} );

	removeButton = new ve.ui.ButtonWidget( {
		'$$': this.frame.$$,
		'label': ve.msg( 'visualeditor-dialog-transclusion-remove-param' ),
		'flags': ['destructive']
	} );
	removeButton.connect( this, { 'click': function () {
		parameter.remove();
	} } );
	optionsFieldset.$.append( removeButton.$ );

	// TODO: Use spec.required
	// TODO: Use spec.deprecation
	// TODO: Use spec.default
	// TODO: Use spec.type

	return {
		'label': label,
		'icon': 'parameter',
		'level': 1,
		'$content': valueFieldset.$.add( optionsFieldset.$ )
	};
};

/**
 * Get page for a parameter.
 *
 * @method
 * @param {ve.dm.MWTemplateParameterModel} parameter Parameter model
 */
ve.ui.MWTransclusionDialog.prototype.getPlaceholderPage = function ( placeholder ) {
	var addTemplateFieldset, addTemplateInput, addTemplateButton, optionsFieldset, removeButton,
		label = ve.msg( 'visualeditor-dialog-transclusion-placeholder' );

	function addTemplate() {
		var parts = placeholder.getTransclusion().getParts(),
			part = ve.dm.MWTemplateModel.newFromName(
				this.transclusion, addTemplateInput.getValue()
			);

		this.transclusion.addPart( part, ve.indexOf( placeholder, parts ) );
		this.pending.push( { 'part': part, 'placeholder': placeholder } );
		addTemplateInput.pushPending();
		addTemplateButton.setDisabled( true );
		removeButton.setDisabled( true );
	}

	addTemplateFieldset = new ve.ui.FieldsetLayout( {
		'$$': this.frame.$$,
		'label': label,
		'icon': 'template'
	} );
	addTemplateFieldset.$.addClass( 've-ui-mwTransclusionDialog-addTemplateFieldset' );

	addTemplateInput = new ve.ui.MWTitleInputWidget( {
		'$$': this.frame.$$, '$overlay': this.$overlay, 'namespace': 10
	} );
	addTemplateButton = new ve.ui.ButtonWidget( {
		'$$': this.frame.$$,
		'label': ve.msg( 'visualeditor-dialog-transclusion-add-template' ),
		'flags': ['constructive'],
		'disabled': true
	} );
	addTemplateInput.connect( this, {
		'change': function () {
			addTemplateButton.setDisabled( addTemplateInput.getValue() === '' );
		},
		'enter': addTemplate
	} );
	addTemplateButton.connect( this, { 'click': addTemplate } );
	addTemplateFieldset.$.append( addTemplateInput.$, addTemplateButton.$ );

	optionsFieldset = new ve.ui.FieldsetLayout( {
		'$$': this.frame.$$,
		'label': ve.msg( 'visualeditor-dialog-transclusion-options' ),
		'icon': 'settings'
	} );

	removeButton = new ve.ui.ButtonWidget( {
		'$$': this.frame.$$,
		'label': ve.msg( 'visualeditor-dialog-transclusion-remove-template' ),
		'flags': ['destructive']
	} );
	removeButton.connect( this, { 'click': function () {
		placeholder.remove();
	} } );
	optionsFieldset.$.append( removeButton.$ );

	return {
		'label': this.frame.$$( '<span>' )
			.addClass( 've-ui-mwTransclusionDialog-placeholder-label' )
			.text( label ),
		'icon': 'template',
		'$content': addTemplateFieldset.$.add( optionsFieldset.$ )
	};
};

/* Registration */

ve.ui.dialogFactory.register( ve.ui.MWTransclusionDialog );
