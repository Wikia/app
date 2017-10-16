/*!
 * VisualEditor user interface MWReferencesListDialog class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Dialog for inserting and editing MediaWiki references lists.
 *
 * @class
 * @extends ve.ui.NodeDialog
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.MWReferencesListDialog = function VeUiMWReferencesListDialog( config ) {
	// Parent constructor
	ve.ui.MWReferencesListDialog.super.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWReferencesListDialog, ve.ui.NodeDialog );

/* Static Properties */

ve.ui.MWReferencesListDialog.static.name = 'referencesList';

ve.ui.MWReferencesListDialog.static.title =
	OO.ui.deferMsg( 'visualeditor-dialog-referenceslist-title' );

ve.ui.MWReferencesListDialog.static.icon = 'references';

ve.ui.MWReferencesListDialog.static.modelClasses = [ ve.dm.MWReferencesListNode ];

ve.ui.MWReferencesListDialog.static.size = 'medium';

ve.ui.MWReferencesListDialog.static.actions = [
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
		modes: [ 'insert', 'edit' ]
	}
];

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.MWReferencesListDialog.prototype.getBodyHeight = function () {
	return Math.max( 150, Math.ceil( this.editPanel.$element[0].scrollHeight ) );
};

/**
 * @inheritdoc
 */
ve.ui.MWReferencesListDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.MWReferencesListDialog.super.prototype.initialize.call( this );

	// Properties
	this.panels = new OO.ui.StackLayout( { $: this.$ } );
	this.editPanel = new OO.ui.PanelLayout( {
		$: this.$, scrollable: true, padded: true
	} );
	this.optionsFieldset = new OO.ui.FieldsetLayout( {
		$: this.$
	} );

	this.groupInput = new ve.ui.MWReferenceGroupInputWidget( {
		$: this.$,
		$overlay: this.$overlay,
		emptyGroupName: ve.msg( 'visualeditor-dialog-reference-options-group-placeholder' )
	} );
	this.groupField = new OO.ui.FieldLayout( this.groupInput, {
		$: this.$,
		align: 'top',
		label: ve.msg( 'visualeditor-dialog-reference-options-group-label' )
	} );

	// Initialization
	this.optionsFieldset.addItems( [ this.groupField ] );
	this.editPanel.$element.append( this.optionsFieldset.$element );
	this.panels.addItems( [ this.editPanel ] );
	this.$body.append( this.panels.$element );
};

/**
 * @inheritdoc
 */
ve.ui.MWReferencesListDialog.prototype.getActionProcess = function ( action ) {
	if ( action === 'apply' || action === 'insert' ) {
		return new OO.ui.Process( function () {
			var refGroup, listGroup, oldListGroup, attrChanges, doc,
				surfaceModel = this.getFragment().getSurface();

			// Save changes
			refGroup = this.groupInput.input.getValue();
			listGroup = 'mwReference/' + refGroup;

			if ( this.selectedNode ) {
				// Edit existing model
				doc = surfaceModel.getDocument();
				oldListGroup = this.selectedNode.getAttribute( 'listGroup' );

				if ( listGroup !== oldListGroup ) {
					attrChanges = {
						listGroup: listGroup,
						refGroup: refGroup
					};
					surfaceModel.change(
						ve.dm.Transaction.newFromAttributeChanges(
							doc, this.selectedNode.getOuterRange().start, attrChanges
						)
					);
				}
			} else {
				// Collapse returns a new fragment, so update this.fragment
				this.fragment = this.getFragment().collapseToEnd().insertContent( [
					{
						type: 'mwReferencesList',
						attributes: {
							listGroup: listGroup,
							refGroup: refGroup
						}
					},
					{ type: '/mwReferencesList' }
				] );
			}

			this.close( { action: action } );
		}, this );
	}
	// Parent method
	return ve.ui.MWReferencesListDialog.super.prototype.getActionProcess.call( this, action );
};

/**
 * @inheritdoc
 */
ve.ui.MWReferencesListDialog.prototype.getSetupProcess = function ( data ) {
	return ve.ui.MWReferencesListDialog.super.prototype.getSetupProcess.call( this, data )
		.next( function () {
			var node, refGroup;

			// Prepopulate from existing node if we're editing a node
			// instead of inserting a new one
			node = this.getFragment().getSelectedNode();
			if ( this.selectedNode instanceof ve.dm.MWReferencesListNode ) {
				refGroup = node.getAttribute( 'refGroup' );
				this.actions.setMode( 'edit' );
			} else {
				refGroup = '';
				this.actions.setMode( 'insert' );
			}

			this.groupInput.input.setValue( refGroup );
			this.groupInput.populateMenu( this.getFragment().getDocument().getInternalList() );
		}, this );
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.MWReferencesListDialog );
