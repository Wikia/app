/*!
 * VisualEditor UserInterface MediaWiki MWReferenceDialog class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Dialog for editing MediaWiki references.
 *
 * @class
 * @extends ve.ui.MWDialog
 *
 * @constructor
 * @param {ve.ui.WindowSet} windowSet Window set this dialog is part of
 * @param {Object} [config] Configuration options
 */
ve.ui.MWReferenceDialog = function VeUiMWReferenceDialog( windowSet, config ) {
	// Parent constructor
	ve.ui.MWDialog.call( this, windowSet, config );

	// Properties
	this.ref = null;
};

/* Inheritance */

OO.inheritClass( ve.ui.MWReferenceDialog, ve.ui.MWDialog );

/* Static Properties */

ve.ui.MWReferenceDialog.static.name = 'reference';

ve.ui.MWReferenceDialog.static.titleMessage = 'visualeditor-dialog-reference-title';

ve.ui.MWReferenceDialog.static.icon = 'reference';

ve.ui.MWReferenceDialog.static.toolbarGroups = [
	{ 'include': [ 'undo', 'redo' ] },
	{ 'include': [ 'bold', 'italic', 'link', 'clear' ] },
	{ 'include': [ 'number', 'bullet', 'outdent', 'indent' ] },
	{ 'include': '*', 'exclude': [ { 'group': 'format' }, 'reference', 'referenceList' ] }
];

ve.ui.MWReferenceDialog.static.surfaceCommands = [
	'undo', 'redo', 'bold', 'italic', 'link', 'clear',
	'underline', 'subscript', 'superscript'
];

/* Methods */

/**
 * Handle reference surface change events
 */
ve.ui.MWReferenceDialog.prototype.onDocumentTransact = function () {
	var data = this.referenceSurface.getContent(),
		// TODO: Check for other types of empty, e.g. only whitespace?
		disabled = data.length <= 4;

	this.insertButton.setDisabled( disabled );
	this.applyButton.setDisabled( disabled );
};

/**
 * Handle search select events.
 *
 * @param {Object|null} item Reference attributes or null if no item is selected
 */
ve.ui.MWReferenceDialog.prototype.onSearchSelect = function ( item ) {
	if ( item ) {
		this.useReference( item );
		this.close( { 'action': 'insert' } );
	}
};

/**
 * Work on a specific reference.
 *
 * @param {Object} [ref] Reference attributes, omit to work on a new reference
 * @chainable
 */
ve.ui.MWReferenceDialog.prototype.useReference = function ( ref ) {
	var newDoc, refGroup,
		doc = this.surface.getModel().getDocument();

	if ( ref ) {
		// Use an existing reference
		this.ref = {
			'listKey': ref.listKey,
			'listGroup': ref.listGroup,
			'refGroup': ref.refGroup,
			'listIndex': ref.listIndex
		};
		newDoc = doc.cloneFromRange( doc.getInternalList().getItemNode( ref.listIndex ).getRange() );
		refGroup = ref.refGroup;
	} else {
		// Create a new reference
		this.ref = null;
		newDoc = new ve.dm.Document( [
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		] );
		refGroup = '';
	}

	// Cleanup
	if ( this.referenceSurface ) {
		this.referenceSurface.destroy();
	}

	// Properties
	this.referenceSurface = new ve.ui.SurfaceWidget(
		newDoc,
		{
			'$': this.$,
			'tools': this.constructor.static.toolbarGroups,
			'commands': this.constructor.static.surfaceCommands
		}
	);

	// Event handlers
	this.referenceSurface.getSurface().getModel().getDocument()
		.connect( this, { 'transact': 'onDocumentTransact' } );

	// Initialization
	this.referenceGroupInput.setValue( refGroup );
	this.contentFieldset.$element.append( this.referenceSurface.$element );
	this.referenceSurface.initialize();

	return this;
};

/**
 * @inheritdoc
 */
ve.ui.MWReferenceDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.MWDialog.prototype.initialize.call( this );

	// Properties
	this.panels = new OO.ui.StackPanelLayout( { '$': this.$ } );
	this.editPanel = new OO.ui.PanelLayout( {
		'$': this.$, 'scrollable': true, 'padded': true
	} );
	this.searchPanel = new OO.ui.PanelLayout( { '$': this.$ } );
	this.applyButton = new OO.ui.PushButtonWidget( {
		'$': this.$,
		'label': ve.msg( 'visualeditor-dialog-action-apply' ),
		'flags': ['primary']
	} );
	this.insertButton = new OO.ui.PushButtonWidget( {
		'$': this.$,
		'label': ve.msg( 'visualeditor-dialog-reference-insert-button' ),
		'flags': ['constructive']
	} );
	this.selectButton = new OO.ui.PushButtonWidget( {
		'$': this.$,
		'label': ve.msg ( 'visualeditor-dialog-reference-useexisting-label' )
	} );
	this.backButton = new OO.ui.PushButtonWidget( {
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
	this.referenceGroupInput = new OO.ui.TextInputWidget( { '$': this.$ } );
	this.referenceGroupLabel = new OO.ui.InputLabelWidget( {
		'$': this.$,
		'input': this.referenceGroupInput,
		'label': ve.msg( 'visualeditor-dialog-reference-options-group-label' )
	} );
	this.search = new ve.ui.MWReferenceSearchWidget(
		this.surface, { '$': this.$ }
	);

	// Events
	this.applyButton.connect( this, { 'click': [ 'close', { 'action': 'apply' } ] } );
	this.insertButton.connect( this, { 'click': [ 'close', { 'action': 'insert' } ] } );
	this.selectButton.connect( this, { 'click': function () {
		this.backButton.$element.show();
		this.insertButton.$element.hide();
		this.selectButton.$element.hide();
		this.panels.showItem( this.searchPanel );
		this.search.getQuery().$input.focus().select();
	} } );
	this.backButton.connect( this, { 'click': function () {
		this.backButton.$element.hide();
		this.insertButton.$element.show();
		this.selectButton.$element.show();
		this.panels.showItem( this.editPanel );
		this.editPanel.$element.find( '.ve-ce-documentNode' ).focus();
	} } );
	this.search.connect( this, { 'select': 'onSearchSelect' } );

	// Initialization
	this.panels.addItems( [ this.editPanel, this.searchPanel ] );
	this.editPanel.$element.append( this.contentFieldset.$element, this.optionsFieldset.$element );
	this.optionsFieldset.$element.append( this.referenceGroupLabel.$element, this.referenceGroupInput.$element );
	this.searchPanel.$element.append( this.search.$element );
	this.$body.append( this.panels.$element );
	this.$foot.append(
		this.applyButton.$element,
		this.insertButton.$element,
		this.selectButton.$element,
		this.backButton.$element
	);
};

/**
 * @inheritdoc
 */
ve.ui.MWReferenceDialog.prototype.setup = function ( data ) {
	// Parent method
	ve.ui.MWDialog.prototype.setup.call( this, data );

	var ref,
		focusedNode = this.surface.getView().getFocusedNode();

	if ( focusedNode instanceof ve.ce.MWReferenceNode ) {
		ref = focusedNode.getModel().getAttributes();
		this.applyButton.$element.show();
		this.insertButton.$element.hide();
		this.selectButton.$element.hide();
	} else {
		this.applyButton.$element.hide();
		this.insertButton.$element.show();
		this.selectButton.$element.show();
	}
	this.backButton.$element.hide();
	this.panels.showItem( this.editPanel );
	this.useReference( ref );
	this.search.buildIndex();
	this.selectButton.setDisabled( !this.search.getResults().getItems().length );
};

/**
 * @inheritdoc
 */
ve.ui.MWReferenceDialog.prototype.teardown = function ( data ) {
	var i, len, txs, item, newDoc, group, refGroup, listGroup, keyIndex, refNodes,
		surfaceModel = this.surface.getModel(),
		// Store the original selection browsers may reset it after
		// the first model change.
		selection = surfaceModel.getSelection().clone(),
		doc = surfaceModel.getDocument(),
		internalList = doc.getInternalList();

	// Data initialization
	data = data || {};

	if ( data.action === 'insert' || data.action === 'apply' ) {
		newDoc = this.referenceSurface.getSurface().getModel().getDocument();
		refGroup = this.referenceGroupInput.getValue();
		listGroup = 'mwReference/' + refGroup;

		// Internal item changes
		if ( this.ref ) {
			// Group/key has changed
			if ( this.ref.listGroup !== listGroup ) {
				// Get all reference nodes with the same group and key
				group = internalList.getNodeGroup( this.ref.listGroup );
				refNodes = group.keyedNodes[this.ref.listKey] ?
					group.keyedNodes[this.ref.listKey].slice() :
					[ group.firstNodes[this.ref.listIndex] ];
				// Check for name collision when moving items between groups
				keyIndex = internalList.getKeyIndex( this.ref.listGroup, this.ref.listKey );
				if ( keyIndex !== undefined ) {
					// Resolve name collision by generating a new list key
					this.ref.listKey = 'auto/' + internalList.getNextUniqueNumber();
				}
				// Update the group name of all references nodes with the same group and key
				txs = [];
				for ( i = 0, len = refNodes.length; i < len; i++ ) {
					// HACK: Removing and re-inserting nodes to/from the internal list is done
					// because internal list doesn't yet support attribute changes
					refNodes[i].removeFromInternalList();
					txs.push( ve.dm.Transaction.newFromAttributeChanges(
						doc,
						refNodes[i].getOuterRange().start,
						{ 'refGroup': refGroup, 'listGroup': listGroup }
					) );
				}
				surfaceModel.change( txs );
				// HACK: Same as above, internal list issues
				for ( i = 0, len = refNodes.length; i < len; i++ ) {
					refNodes[i].addToInternalList();
				}
				this.ref.listGroup = listGroup;
				this.ref.refGroup = refGroup;
			}
			// Update internal node content
			surfaceModel.change(
				ve.dm.Transaction.newFromDocumentReplace(
					doc, internalList.getItemNode( this.ref.listIndex ), newDoc
				)
			);
		}

		// Content changes
		if ( data.action === 'insert' ) {
			if ( !this.ref ) {
				listGroup = 'mwReference/' + refGroup;
				// Create new internal item
				this.ref = {
					'listKey': 'auto/' + internalList.getNextUniqueNumber(),
					'listGroup': listGroup,
					'refGroup': refGroup
				};
				// Insert an internal item, then inject the subdocument into it
				item = internalList.getItemInsertion( this.ref.listGroup, this.ref.listKey, [] );
				surfaceModel.change( item.transaction );
				this.ref.listIndex = item.index;
				surfaceModel.change(
					ve.dm.Transaction.newFromDocumentReplace(
						doc, internalList.getItemNode( this.ref.listIndex ), newDoc
					)
				);
			}
			// Add reference at cursor
			surfaceModel.getFragment( selection ).collapseRangeToEnd().insertContent( [
				{ 'type': 'mwReference', 'attributes': this.ref }, { 'type': '/mwReference' }
			] );
		}
	}

	this.referenceSurface.destroy();
	this.referenceSurface = null;
	this.ref = null;

	// Parent method
	ve.ui.MWDialog.prototype.teardown.call( this, data );
};

/* Registration */

ve.ui.dialogFactory.register( ve.ui.MWReferenceDialog );
