/*!
 * VisualEditor UserInterface MediaWiki MWReferenceDialog class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Dialog for editing MediaWiki references.
 *
 * @class
 * @extends ve.ui.NodeDialog
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.MWReferenceDialog = function VeUiMWReferenceDialog( config ) {
	// Parent constructor
	ve.ui.MWReferenceDialog.super.call( this, config );

	// Properties
	this.referenceModel = null;
};

/* Inheritance */

OO.inheritClass( ve.ui.MWReferenceDialog, ve.ui.NodeDialog );

/* Static Properties */

ve.ui.MWReferenceDialog.static.name = 'reference';

ve.ui.MWReferenceDialog.static.title =
	OO.ui.deferMsg( 'visualeditor-dialog-reference-title' );

ve.ui.MWReferenceDialog.static.icon = 'reference';

ve.ui.MWReferenceDialog.static.actions = [
	{
		action: 'apply',
		label: OO.ui.deferMsg( 'visualeditor-dialog-action-apply' ),
		flags: [ 'progressive', 'primary' ],
		modes: 'edit'
	},
	{
		action: 'insert',
		label: OO.ui.deferMsg( 'visualeditor-dialog-action-insert' ),
		flags: [ 'primary', 'constructive' ],
		modes: 'insert'
	},
	{
		label: OO.ui.deferMsg( 'visualeditor-dialog-action-cancel' ),
		flags: 'safe',
		modes: [ 'insert', 'edit', 'insert-select' ]
	},
	{
		action: 'select',
		label: OO.ui.deferMsg( 'visualeditor-dialog-reference-useexisting-label' ),
		modes: [ 'insert', 'edit' ]
	},
	{
		action: 'back',
		label: OO.ui.deferMsg( 'visualeditor-dialog-action-goback' ),
		flags: 'safe',
		modes: 'select'
	}
];

ve.ui.MWReferenceDialog.static.modelClasses = [ ve.dm.MWReferenceNode ];

ve.ui.MWReferenceDialog.static.excludeCommands = [
	// No formatting
	'paragraph',
	'heading1',
	'heading2',
	'heading3',
	'heading4',
	'heading5',
	'heading6',
	'preformatted',
	'blockquote',
	// No tables
	'insertTable',
	'deleteTable',
	'mergeCells',
	'tableCaption',
	'tableCellHeader',
	'tableCellData',
	// No structure
	'bullet',
	'number',
	'indent',
	'outdent',
	// References
	'reference',
	'reference/existing',
	'referencesList'
];

// HACK: change group: 'cite' to group: 'cite-transclusion'
ve.ui.MWReferenceDialog.static.toolbarGroups = ( function () {
	var toolbarGroups = ve.copy( ve.init.mw.Target.static.toolbarGroups );
	toolbarGroups[4].include[0].group = 'cite-transclusion';
	return toolbarGroups;
} () );

/**
 * Get the import rules for the surface widget in the dialog
 *
 * @see ve.dm.ElementLinearData#sanitize
 * @return {Object} Import rules
 */
ve.ui.MWReferenceDialog.static.getImportRules = function () {
	return ve.extendObject(
		ve.copy( ve.init.target.constructor.static.importRules ),
		{
			all: {
				blacklist: OO.simpleArrayUnion(
					ve.getProp( ve.init.target.constructor.static.importRules, 'all', 'blacklist' ) || [],
					[
						// Nested references are impossible
						'mwReference', 'mwReferencesList',
						// Lists and tables are actually possible in wikitext with a leading
						// line break but we prevent creating these with the UI
						'list', 'listItem', 'definitionList', 'definitionListItem',
						'table', 'tableCaption', 'tableSection', 'tableRow', 'tableCell'
					]
				),
				// Headings are not possible in wikitext without HTML
				conversions: {
					mwHeading: 'paragraph'
				}
			}
		}
	);
};

/* Methods */

/**
 * Determine whether the reference document we're editing has any content.
 * @return {boolean} Document has content
 */
ve.ui.MWReferenceDialog.prototype.documentHasContent = function () {
	// TODO: Check for other types of empty, e.g. only whitespace?
	return this.referenceModel.getDocument().data.countNonInternalElements() > 2;
};

/*
 * Determine whether any changes have been made (and haven't been undone)
 * @return {boolean} Dialog can be applied
 */
ve.ui.MWReferenceDialog.prototype.canApply = function () {
	return this.documentHasContent() &&
		( this.referenceSurface.getSurface().getModel().hasBeenModified() ||
		this.referenceGroupInput.input.getValue() !== this.originalGroup );
};

/**
 * Handle reference surface change events
 */
ve.ui.MWReferenceDialog.prototype.onDocumentTransact = function () {
	var hasContent = this.documentHasContent();

	this.actions.setAbilities( {
		apply: this.canApply(),
		insert: hasContent,
		select: !hasContent && !this.search.isIndexEmpty()
	} );
};

/**
 * Handle reference group input change events
 */
ve.ui.MWReferenceDialog.prototype.onReferenceGroupInputChange = function () {
	this.actions.setAbilities( {
		apply: this.canApply()
	} );
};

/**
 * Handle search select events.
 *
 * @param {ve.dm.MWReferenceModel|null} ref Reference model or null if no item is selected
 */
ve.ui.MWReferenceDialog.prototype.onSearchSelect = function ( ref ) {
	if ( ref instanceof ve.dm.MWReferenceModel ) {
		if ( this.selectedNode instanceof ve.dm.MWReferenceNode ) {
			this.getFragment().removeContent();
			this.selectedNode = null;
		}
		this.useReference( ref );
		this.executeAction( 'insert' );
	}
};

/**
 * @inheritdoc
 */
ve.ui.MWReferenceDialog.prototype.getReadyProcess = function ( data ) {
	return ve.ui.MWReferenceDialog.super.prototype.getReadyProcess.call( this, data )
		.next( function () {
			this.referenceSurface.focus();
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.MWReferenceDialog.prototype.getBodyHeight = function () {
	// Clamp value to between 300 and 400px height, preferring the actual height if available
	return Math.min(
		400,
		Math.max(
			300,
			Math.ceil( this.panels.getCurrentItem().$element[0].scrollHeight )
		)
	);
};

/**
 * Work on a specific reference.
 *
 * @param {ve.dm.MWReferenceModel} [ref] Reference model, omit to work on a new reference
 * @chainable
 */
ve.ui.MWReferenceDialog.prototype.useReference = function ( ref ) {
	var group,
		toolbarGroups = [
			// History
			{ include: [ 'undo' ] },
			// Style
			{ include: [ 'bold', 'italic', 'link' ] },
			{
				type: 'list',
				icon: 'text-style',
				indicator: 'down',
				title: OO.ui.deferMsg( 'visualeditor-toolbar-style-tooltip' ),
				include: [ 'subscript', 'superscript', 'strikethrough', 'underline', 'indent', 'outdent', 'clear' ]
			}
		];

	// Properties
	if ( ref instanceof ve.dm.MWReferenceModel ) {
		// Use an existing reference
		this.referenceModel = ref;
	} else {
		// Create a new reference
		this.referenceModel = new ve.dm.MWReferenceModel();
		this.referenceModel.setDir( this.getFragment().getDocument().getDir() );
		this.referenceModel.setLang( this.getFragment().getDocument().getLang() );
	}

	// Cleanup
	if ( this.referenceSurface ) {
		this.referenceSurface.destroy();
	}

	// Properties
	this.referenceSurface = new ve.ui.MWSurfaceWidget(
		this.referenceModel.getDocument(),
		{
			$: this.$,
			tools: toolbarGroups,
			excludeCommands: this.constructor.static.excludeCommands,
			importRules: this.constructor.static.getImportRules()
		}
	);

	// Events
	this.referenceModel.getDocument().connect( this, { transact: 'onDocumentTransact' } );

	// Initialization
	this.originalGroup = this.referenceModel.getGroup();
	this.referenceGroupInput.input.setValue( this.originalGroup );
	this.contentFieldset.$element.append( this.referenceSurface.$element );
	this.referenceSurface.initialize();

	group = this.getFragment().getDocument().getInternalList()
		.getNodeGroup( this.referenceModel.getListGroup() );
	if ( group && group.keyedNodes[this.referenceModel.getListKey()].length > 1 ) {
		this.$reuseWarning.show();
		this.$reuseWarningText.text( mw.msg(
			'visualeditor-dialog-reference-editing-reused',
			group.keyedNodes[this.referenceModel.getListKey()].length
		) );
	} else {
		this.$reuseWarning.hide();
	}

	return this;
};

/**
 * @inheritdoc
 */
ve.ui.MWReferenceDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.MWReferenceDialog.super.prototype.initialize.call( this );

	// Properties
	this.panels = new OO.ui.StackLayout( { $: this.$ } );
	this.editPanel = new OO.ui.PanelLayout( {
		$: this.$, scrollable: true, padded: true
	} );
	this.searchPanel = new OO.ui.PanelLayout( { $: this.$ } );

	this.reuseWarningIcon = new OO.ui.IconWidget( { icon: 'alert' } );
	this.$reuseWarningText = this.$( '<span>' );
	this.$reuseWarning = this.$( '<span>' ).append( this.reuseWarningIcon.$element, this.$reuseWarningText );

	this.contentFieldset = new OO.ui.FieldsetLayout( { $: this.$ } );
	this.optionsFieldset = new OO.ui.FieldsetLayout( {
		$: this.$,
		label: ve.msg( 'visualeditor-dialog-reference-options-section' ),
		icon: 'settings'
	} );
	this.referenceGroupInput = new ve.ui.MWReferenceGroupInputWidget( {
		$: this.$,
		$overlay: this.$overlay,
		emptyGroupName: ve.msg( 'visualeditor-dialog-reference-options-group-placeholder' )
	} );
	this.referenceGroupInput.input.connect( this, { change: 'onReferenceGroupInputChange' } );
	this.referenceGroupField = new OO.ui.FieldLayout( this.referenceGroupInput, {
		$: this.$,
		align: 'top',
		label: ve.msg( 'visualeditor-dialog-reference-options-group-label' )
	} );
	this.search = new ve.ui.MWReferenceSearchWidget( { $: this.$ } );

	// Events
	this.search.connect( this, { select: 'onSearchSelect' } );

	// Initialization
	this.panels.addItems( [ this.editPanel, this.searchPanel ] );
	this.editPanel.$element.append( this.$reuseWarning, this.contentFieldset.$element, this.optionsFieldset.$element );
	this.optionsFieldset.addItems( [ this.referenceGroupField ] );
	this.searchPanel.$element.append( this.search.$element );
	this.$body.append( this.panels.$element );
};

/**
 * Switches dialog to use existing reference mode
 *
 * @param {string} [action='select'] Symbolic name of action, either 'select' or 'insert-select'
 */
ve.ui.MWReferenceDialog.prototype.useExistingReference = function ( action ) {
	action = action || 'select';
	if ( action === 'insert-select' || action === 'select' ) {
		this.actions.setMode( action );
	}
	this.search.buildIndex();
	this.panels.setItem( this.searchPanel );
	this.search.getQuery().focus().select();
};

/**
 * @inheritdoc
 */
ve.ui.MWReferenceDialog.prototype.getActionProcess = function ( action ) {
	if ( action === 'insert' || action === 'apply' ) {
		return new OO.ui.Process( function () {
			var surfaceModel = this.getFragment().getSurface();

			this.referenceModel.setGroup( this.referenceGroupInput.input.getValue() );

			// Insert reference (will auto-create an internal item if needed)
			if ( !( this.selectedNode instanceof ve.dm.MWReferenceNode ) ) {
				if ( !this.referenceModel.findInternalItem( surfaceModel ) ) {
					this.referenceModel.insertInternalItem( surfaceModel );
				}
				// Collapse returns a new fragment, so update this.fragment
				this.fragment = this.getFragment().collapseToEnd();
				this.referenceModel.insertReferenceNode( this.getFragment() );
			}

			// Update internal item
			this.referenceModel.updateInternalItem( surfaceModel );

			this.close( { action: action } );
		}, this );
	} else if ( action === 'back' ) {
		this.actions.setMode( this.selectedNode ? 'edit' : 'insert' );
		this.panels.setItem( this.editPanel );
		this.editPanel.$element.find( '.ve-ce-documentNode' )[0].focus();
	} else if ( action === 'select' || action === 'insert-select' ) {
		this.useExistingReference( action );
	}
	return ve.ui.MWReferenceDialog.super.prototype.getActionProcess.call( this, action );
};

/**
 * @inheritdoc
 * @param {Object} [data] Setup data
 * @param {boolean} [data.useExistingReference] Open the dialog in "use existing reference" mode
 */
ve.ui.MWReferenceDialog.prototype.getSetupProcess = function ( data ) {
	data = data || {};
	return ve.ui.MWReferenceDialog.super.prototype.getSetupProcess.call( this, data )
		.next( function () {
			this.panels.setItem( this.editPanel );
			if ( this.selectedNode instanceof ve.dm.MWReferenceNode ) {
				this.useReference(
					ve.dm.MWReferenceModel.static.newFromReferenceNode( this.selectedNode )
				);
			} else {
				this.useReference( null );
				this.actions.setAbilities( { apply: false, insert: false } );
			}

			this.actions.setMode( this.selectedNode ? 'edit' : 'insert' );
			this.search.setInternalList( this.getFragment().getDocument().getInternalList() );

			if ( data.useExisting ) {
				this.useExistingReference( 'insert-select' );
			}

			// If we're using an existing reference, start off disabled
			// If not, set disabled based on whether or not there are any existing ones.
			this.actions.setAbilities( {
				select: !( this.selectedNode instanceof ve.dm.MWReferenceNode ) &&
					!this.search.isIndexEmpty(),
				apply: false
			} );

			this.referenceGroupInput.populateMenu( this.getFragment().getDocument().getInternalList() );
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.MWReferenceDialog.prototype.getTeardownProcess = function ( data ) {
	return ve.ui.MWReferenceDialog.super.prototype.getTeardownProcess.call( this, data )
		.first( function () {
			this.search.getQuery().setValue( '' );
			this.referenceSurface.destroy();
			this.referenceSurface = null;
			this.referenceModel = null;
		}, this );
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.MWReferenceDialog );
