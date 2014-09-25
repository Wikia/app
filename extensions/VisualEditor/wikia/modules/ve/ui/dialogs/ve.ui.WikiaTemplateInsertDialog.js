/*
 * VisualEditor user interface WikiaTemplateInsertDialog class.
 */

/**
 * Dialog for inserting templates.
 *
 * @class
 * @extends ve.ui.Dialog
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.WikiaTemplateInsertDialog = function VeUiWikiaTemplateInsertDialog( config ) {
	// Parent constructor
	ve.ui.WikiaTemplateInsertDialog.super.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaTemplateInsertDialog, ve.ui.Dialog );

/* Static Properties */

ve.ui.WikiaTemplateInsertDialog.static.name = 'wikiaTemplateInsert';

ve.ui.WikiaTemplateInsertDialog.static.icon = 'template';

ve.ui.WikiaTemplateInsertDialog.static.title = OO.ui.deferMsg( 'wikia-visualeditor-dialog-template-insert-title' );

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.WikiaTemplateInsertDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.WikiaTemplateInsertDialog.super.prototype.initialize.call( this );

	// Properties
	this.search = new ve.ui.WikiaTemplateSearchWidget( {
		'placeholder': ve.msg( 'wikia-visualeditor-dialog-wikiamediainsert-search-input-placeholder' )
	} );

	// Events
	this.search.connect( this, {
		'select': 'onTemplateSelect'
	} );

	// Initialization
	this.frame.$content.addClass( 've-ui-wikiaTemplateInsertDialog' );
	this.$body.append( this.search.$element );
};

/**
 * Handle selecting results.
 *
 * @method
 * @param {Object|null} itemData Data of selected item, or null
 */
ve.ui.WikiaTemplateInsertDialog.prototype.onTemplateSelect = function ( itemData ) {
	var template;

	if ( itemData ) {
		this.transclusionModel = new ve.dm.MWTransclusionModel();

		template = ve.dm.MWTemplateModel.newFromName(
			this.transclusionModel, itemData.title
		);
		this.transclusionModel.addPart( template )
			.done( ve.bind( this.insertTemplate, this ) );
	}
};

/**
 * Insert template
 */
ve.ui.WikiaTemplateInsertDialog.prototype.insertTemplate = function () {
	// Collapse returns a new fragment, so update this.fragment
	this.fragment = this.getFragment().collapseRangeToEnd();

	// Update the surface selection to match the fragment's collapsed range.
	// Translating an expanded range will result in a selection that covers more than just the inserted node.
	this.surface.getModel().setSelection( this.getFragment().getRange() );

	// Ask the transclusionModel to transact with the document model and listen for the 'tranact' event.
	this.surface.getModel().getDocument().once( 'transact', ve.bind( this.onTransact, this ) );
	this.transclusionModel.insertTransclusionNode( this.getFragment() );
};

/**
 * Handle document model transaction
 *
 * Once the transclusionModel has inserted the transclusion, the new node in the surface will be selected.
 * We can ask the commandRegistry for the command for the node and execute it.
 */
ve.ui.WikiaTemplateInsertDialog.prototype.onTransact = function () {
	setTimeout( ve.bind( function () {
		ve.ui.commandRegistry.getCommandForNode(
			this.surface.getView().getFocusedNode()
		).execute( this.surface );

		ve.track( 'wikia', {
			'action': ve.track.actions.ADD,
			'label': 'dialog-template-insert'
		} );

	}, this ), 0 );
};

/**
 * @inheritdoc
 */
ve.ui.WikiaTemplateInsertDialog.prototype.getTeardownProcess = function ( data ) {
	return ve.ui.WikiaTemplateInsertDialog.super.prototype.getTeardownProcess.call( this, data )
		.next( function () {
			// Unselect
			this.search.unselectItem();
		}, this );
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.WikiaTemplateInsertDialog );
