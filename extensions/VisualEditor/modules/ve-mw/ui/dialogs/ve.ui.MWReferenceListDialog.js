/*!
 * VisualEditor user interface MWReferenceListDialog class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Dialog for inserting and editing MediaWiki reference lists.
 *
 * @class
 * @extends ve.ui.Dialog
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.MWReferenceListDialog = function VeUiMWReferenceListDialog( config ) {
	// Configuration initialization
	config = ve.extendObject( { 'size': 'small' }, config );

	// Parent constructor
	ve.ui.Dialog.call( this, config );

	// Properties
	this.node = null;
};

/* Inheritance */

OO.inheritClass( ve.ui.MWReferenceListDialog, ve.ui.Dialog );

/* Static Properties */

ve.ui.MWReferenceListDialog.static.name = 'referenceList';

ve.ui.MWReferenceListDialog.static.title =
	OO.ui.deferMsg( 'visualeditor-dialog-referencelist-title' );

ve.ui.MWReferenceListDialog.static.icon = 'references';

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.MWReferenceListDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.Dialog.prototype.initialize.call( this );

	// Properties
	this.editPanel = new OO.ui.PanelLayout( {
		'$': this.$, 'scrollable': true, 'padded': true
	} );
	this.optionsFieldset = new OO.ui.FieldsetLayout( {
		'$': this.$
	} );

	this.groupInput = new OO.ui.TextInputWidget( {
		'$': this.$,
		'placeholder': ve.msg( 'visualeditor-dialog-reference-options-group-placeholder' )
	} );
	this.groupField = new OO.ui.FieldLayout( this.groupInput, {
		'$': this.$,
		'align': 'top',
		'label': ve.msg( 'visualeditor-dialog-reference-options-group-label' )
	} );

	this.applyButton = new OO.ui.ButtonWidget( {
		'$': this.$,
		'flags': ['primary']
	} );

	// Events
	this.applyButton.connect( this, { 'click': [ 'close', { 'action': 'apply' } ] } );

	// Initialization
	this.optionsFieldset.addItems( [ this.groupField ] );
	this.editPanel.$element.append( this.optionsFieldset.$element );
	this.$body.append( this.editPanel.$element );
	this.$foot.append( this.applyButton.$element );
};

/**
 * @inheritdoc
 */
ve.ui.MWReferenceListDialog.prototype.setup = function ( data ) {
	// Parent method
	ve.ui.Dialog.prototype.setup.call( this, data );

	var node, refGroup;

	// Prepopulate from existing node if we're editing a node
	// instead of inserting a new one
	node = this.getFragment().getSelectedNode();
	if ( node instanceof ve.dm.MWReferenceListNode ) {
		refGroup = node.getAttribute( 'refGroup' );
		this.node = node;
	} else {
		refGroup = '';
		this.node = null;
	}

	this.groupInput.setValue( refGroup );
	this.applyButton.setLabel ( ve.msg (
			this.node ?
				'visualeditor-dialog-action-apply' :
				'visualeditor-dialog-referencelist-insert-button'
	) );
};

/**
 * @inheritdoc
 */
ve.ui.MWReferenceListDialog.prototype.teardown = function ( data ) {
	var refGroup, listGroup, oldListGroup, attrChanges, doc,
		surfaceModel = this.getFragment().getSurface();

	// Data initialization
	data = data || {};

	// Save changes
	if ( data.action === 'apply' ) {
		refGroup = this.groupInput.getValue();
		listGroup = 'mwReference/' + refGroup;

		if ( this.node ) {
			// Edit existing model
			doc = surfaceModel.getDocument();
			oldListGroup = this.node.getAttribute( 'listGroup' );

			if ( listGroup !== oldListGroup ) {
				attrChanges = {
					listGroup: listGroup,
					refGroup: refGroup
				};
				surfaceModel.change(
					ve.dm.Transaction.newFromAttributeChanges(
						doc, this.node.getOuterRange().start, attrChanges
					)
				);
			}
		} else {
			// Create new model
			surfaceModel.getFragment().collapseRangeToEnd().insertContent( [
				{
					'type': 'mwReferenceList',
					'attributes': {
						'listGroup': listGroup,
						'refGroup': refGroup
					}
				},
				{ 'type': '/mwReferenceList' }
			] ).collapseRangeToEnd().select();
		}
	}

	// Parent method
	ve.ui.Dialog.prototype.teardown.call( this, data );
};

/* Registration */

ve.ui.dialogFactory.register( ve.ui.MWReferenceListDialog );
