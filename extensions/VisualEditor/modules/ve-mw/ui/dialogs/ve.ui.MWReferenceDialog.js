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

	// Events
	this.connect( this, { 'ready': 'onReady' } );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWReferenceDialog, ve.ui.NodeDialog );

/* Static Properties */

ve.ui.MWReferenceDialog.static.name = 'reference';

ve.ui.MWReferenceDialog.static.title =
	OO.ui.deferMsg( 'visualeditor-dialog-reference-title' );

ve.ui.MWReferenceDialog.static.icon = 'reference';

ve.ui.MWReferenceDialog.static.modelClasses = [ ve.dm.MWReferenceNode ];

ve.ui.MWReferenceDialog.static.toolbarGroups = [
	// History
	{ 'include': [ 'undo', 'redo' ] },
	// No formatting
	/* {
		'type': 'menu',
		'indicator': 'down',
		'title': OO.ui.deferMsg( 'visualeditor-toolbar-format-tooltip' ),
		'include': [ { 'group': 'format' } ],
		'promote': [ 'paragraph' ],
		'demote': [ 'preformatted', 'heading1' ]
	},*/
	// Style
	{
		'type': 'list',
		'icon': 'text-style',
		'indicator': 'down',
		'title': OO.ui.deferMsg( 'visualeditor-toolbar-style-tooltip' ),
		'include': [ { 'group': 'textStyle' }, 'clear' ],
		'promote': [ 'bold', 'italic' ],
		'demote': [ 'strikethrough', 'code', 'underline', 'clear' ]
	},
	// Link
	{ 'include': [ 'link' ] },
	// Cite
	{
		'type': 'list',
		'label': OO.ui.deferMsg( 'visualeditor-toolbar-cite-label' ),
		'indicator': 'down',
		'include': [ { 'group': 'cite-transclusion' } ]
	},
	// No structure
	/* {
		'type': 'list',
		'icon': 'bullet-list',
		'indicator': 'down',
		'include': [ { 'group': 'structure' } ],
		'demote': [ 'outdent', 'indent' ]
	},*/
	// Insert
	{
		'label': OO.ui.deferMsg( 'visualeditor-toolbar-insert' ),
		'indicator': 'down',
		'include': '*',
		'exclude': [
			{ 'group': 'format' },
			{ 'group': 'structure' },
			'reference',
			'referenceList',
			'gallery'
		],
		'promote': [ 'mediaInsert' ],
		'demote': [ 'language', 'specialcharacter' ]
	}
];

ve.ui.MWReferenceDialog.static.surfaceCommands = [
	'undo',
	'redo',
	'bold',
	'italic',
	'link',
	'clear',
	'underline',
	'subscript',
	'superscript',
	'pasteSpecial'
];

/**
 * Get the paste rules for the surface widget in the dialog
 *
 * @see ve.dm.ElementLinearData#sanitize
 * @return {Object} Paste rules
 */
ve.ui.MWReferenceDialog.static.getPasteRules = function () {
	return ve.extendObject(
		ve.copy( ve.init.target.constructor.static.pasteRules ),
		{
			'all': {
				'blacklist': OO.simpleArrayUnion(
					ve.getProp( ve.init.target.constructor.static.pasteRules, 'all', 'blacklist' ) || [],
					[
						// Nested references are impossible
						'mwReference', 'mwReferenceList',
						// Lists are tables are actually possible in wikitext with a leading
						// line break but we prevent creating these with the UI
						'list', 'listItem', 'definitionList', 'definitionListItem',
						'table', 'tableCaption', 'tableSection', 'tableRow', 'tableCell'
					]
				),
				// Headings are not possible in wikitext without HTML
				'conversions': {
					'mwHeading': 'paragraph'
				}
			}
		}
	);
};

/* Methods */

/**
 * Handle reference surface change events
 */
ve.ui.MWReferenceDialog.prototype.onDocumentTransact = function () {
	var data = this.referenceModel.getDocument().data,
		// TODO: Check for other types of empty, e.g. only whitespace?
		applyDisabled = data.countNoninternalElements() <= 2;

	this.applyButton.setDisabled( applyDisabled );
	this.selectButton.setDisabled( !applyDisabled || this.search.isIndexEmpty() );
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
		// HACK - This proves that the interface for ActionDialog is screwed up
		this.onApplyButtonClick();
	}
};

/**
 * Handle window ready events
 */
ve.ui.MWReferenceDialog.prototype.onReady = function () {
	// Focus the reference surface
	this.referenceSurface.focus();
};

/**
 * Work on a specific reference.
 *
 * @param {ve.dm.MWReferenceModel} [ref] Reference model, omit to work on a new reference
 * @chainable
 */
ve.ui.MWReferenceDialog.prototype.useReference = function ( ref ) {
	// Properties
	if ( ref instanceof ve.dm.MWReferenceModel ) {
		// Use an existing reference
		this.referenceModel = ref;
	} else {
		// Create a new reference
		this.referenceModel = new ve.dm.MWReferenceModel();
	}

	// Cleanup
	if ( this.referenceSurface ) {
		this.referenceSurface.destroy();
	}

	// Properties
	this.referenceSurface = new ve.ui.SurfaceWidget(
		this.referenceModel.getDocument(),
		{
			'$': this.$,
			'tools': this.constructor.static.toolbarGroups,
			'commands': this.constructor.static.surfaceCommands,
			'pasteRules': this.constructor.static.getPasteRules()
		}
	);

	// Events
	this.referenceModel.getDocument().connect( this, { 'transact': 'onDocumentTransact' } );
	this.referenceSurface.getSurface().getModel().connect( this, {
		'documentUpdate': function () {
			this.wikitextWarning = ve.init.mw.ViewPageTarget.static.checkForWikitextWarning(
				this.referenceSurface.getSurface(),
				this.wikitextWarning
			);
		}
	} );

	// Initialization
	this.referenceGroupInput.setValue( this.referenceModel.getGroup() );
	this.contentFieldset.$element.append( this.referenceSurface.$element );
	this.referenceSurface.initialize();

	return this;
};

/**
 * @inheritdoc
 */
ve.ui.MWReferenceDialog.prototype.getApplyButtonLabel = function () {
	return this.selectedNode instanceof ve.dm.MWReferenceNode ?
		ve.ui.MWReferenceDialog.super.prototype.getApplyButtonLabel.call( this ) :
		ve.msg( 'visualeditor-dialog-reference-insert-button' );
};

/**
 * @inheritdoc
 */
ve.ui.MWReferenceDialog.prototype.applyChanges = function () {
	var surfaceModel = this.getFragment().getSurface();

	this.referenceModel.setGroup( this.referenceGroupInput.getValue() );

	// Insert reference (will auto-create an internal item if needed)
	if ( !( this.selectedNode instanceof ve.dm.MWReferenceNode ) ) {
		if ( !this.referenceModel.findInternalItem( surfaceModel ) ) {
			this.referenceModel.insertInternalItem( surfaceModel );
		}
		// Collapse returns a new fragment, so update this.fragment
		this.fragment = this.getFragment().collapseRangeToEnd();
		this.referenceModel.insertReferenceNode( this.getFragment() );
	}

	// Update internal item
	this.referenceModel.updateInternalItem( surfaceModel );

	// Parent method
	return ve.ui.MWReferenceDialog.super.prototype.applyChanges.call( this );
};

/**
 * @inheritdoc
 */
ve.ui.MWReferenceDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.MWReferenceDialog.super.prototype.initialize.call( this );

	// Properties
	this.editPanel = new OO.ui.PanelLayout( {
		'$': this.$, 'scrollable': true, 'padded': true
	} );
	this.searchPanel = new OO.ui.PanelLayout( { '$': this.$ } );
	this.selectButton = new OO.ui.ButtonWidget( {
		'$': this.$,
		'label': ve.msg ( 'visualeditor-dialog-reference-useexisting-label' ),
		'flags': ['secondary']
	} );
	this.backButton = new OO.ui.ButtonWidget( {
		'$': this.$,
		'label': ve.msg( 'visualeditor-dialog-action-goback' )
	} );
	this.contentFieldset = new OO.ui.FieldsetLayout( { '$': this.$ } );
	this.optionsFieldset = new OO.ui.FieldsetLayout( {
		'$': this.$,
		'label': ve.msg( 'visualeditor-dialog-reference-options-section' ),
		'icon': 'settings'
	} );
	// TODO: Use a drop-down or something, and populate with existing groups instead of free-text
	this.referenceGroupInput = new OO.ui.TextInputWidget( {
		'$': this.$,
		'placeholder': ve.msg( 'visualeditor-dialog-reference-options-group-placeholder' )
	} );
	this.referenceGroupField = new OO.ui.FieldLayout( this.referenceGroupInput, {
		'$': this.$,
		'align': 'top',
		'label': ve.msg( 'visualeditor-dialog-reference-options-group-label' )
	} );
	this.search = new ve.ui.MWReferenceSearchWidget( { '$': this.$ } );

	// Events
	this.selectButton.connect( this, { 'click': 'useExistingReference' } );
	this.backButton.connect( this, { 'click': function () {
		this.backButton.$element.hide();
		this.applyButton.$element.show();
		this.selectButton.$element.show();
		this.panels.setItem( this.editPanel );
		this.editPanel.$element.find( '.ve-ce-documentNode' ).focus();
	} } );
	this.search.connect( this, { 'select': 'onSearchSelect' } );

	// Initialization
	this.panels.addItems( [ this.editPanel, this.searchPanel ] );
	this.editPanel.$element.append( this.contentFieldset.$element, this.optionsFieldset.$element );
	this.optionsFieldset.addItems( [ this.referenceGroupField ] );
	this.searchPanel.$element.append( this.search.$element );
	this.$foot.append(
		this.applyButton.$element,
		this.selectButton.$element,
		this.backButton.$element
	);
};

/**
 * Switches dialog to use existing reference mode
 */
ve.ui.MWReferenceDialog.prototype.useExistingReference = function () {
	this.backButton.$element.show();
	this.applyButton.$element.hide();
	this.selectButton.$element.hide();
	this.panels.setItem( this.searchPanel );
	this.search.getQuery().focus().select();
};

/**
 * @inheritdoc
 * @param {Object} [data] Setup data
 * @param {boolean} [data.useExistingReference] Open the dialog in "use existing reference" mode
 */
ve.ui.MWReferenceDialog.prototype.getSetupProcess = function ( data ) {
	return ve.ui.MWReferenceDialog.super.prototype.getSetupProcess.call( this, data )
		.next( function () {
			this.panels.setItem( this.editPanel );
			if ( this.selectedNode instanceof ve.dm.MWReferenceNode ) {
				this.useReference(
					ve.dm.MWReferenceModel.static.newFromReferenceNode( this.selectedNode )
				);
			} else {
				this.useReference( null );
				this.applyButton.setDisabled( true );
			}
			this.selectButton.$element.show();
			this.applyButton.$element.show();
			this.backButton.$element.hide();
			this.search.buildIndex( this.getFragment().getDocument().getInternalList() );

			if ( data.useExisting ) {
				this.useExistingReference();
			}

			// If we're using an existing reference, start off disabled
			// If not, set disabled based on whether or not there are any existing ones.
			this.selectButton.setDisabled(
				this.selectedNode instanceof ve.dm.MWReferenceNode ||
				this.search.isIndexEmpty()
			);
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.MWReferenceDialog.prototype.getTeardownProcess = function ( data ) {
	return ve.ui.MWReferenceDialog.super.prototype.getTeardownProcess.call( this, data )
		.first( function () {
			this.search.getQuery().setValue( '' );
			if ( this.wikitextWarning ) {
				this.wikitextWarning.close();
			}
			this.referenceSurface.destroy();
			this.referenceSurface = null;
			this.referenceModel = null;
		}, this );
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.MWReferenceDialog );
