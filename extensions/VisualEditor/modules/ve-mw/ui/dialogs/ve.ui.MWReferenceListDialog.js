/*!
 * VisualEditor user interface MWReferenceListDialog class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Dialog for inserting and editing MediaWiki reference lists.
 *
 * @class
 * @extends ve.ui.MWDialog
 *
 * @constructor
 * @param {ve.ui.WindowSet} windowSet Window set this dialog is part of
 * @param {Object} [config] Configuration options
 */
ve.ui.MWReferenceListDialog = function VeUiMWReferenceListDialog( windowSet, config ) {
	// Parent constructor
	ve.ui.MWDialog.call( this, windowSet, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWReferenceListDialog, ve.ui.MWDialog );

/* Static Properties */

ve.ui.MWReferenceListDialog.static.name = 'referenceList';

ve.ui.MWReferenceListDialog.static.titleMessage = 'visualeditor-dialog-referencelist-title';

ve.ui.MWReferenceListDialog.static.icon = 'references';

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.MWReferenceListDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.MWDialog.prototype.initialize.call( this );

	// Properties
	this.editPanel = new OO.ui.PanelLayout( {
		'$': this.$, 'scrollable': true, 'padded': true
	} );
	this.optionsFieldset = new OO.ui.FieldsetLayout( {
		'$': this.$,
		'label': ve.msg( 'visualeditor-dialog-reference-options-section' ),
		'icon': 'settings'
	} );

	this.groupInput = new OO.ui.TextInputWidget( { '$': this.$ } );
	this.groupLabel = new OO.ui.InputLabelWidget( {
		'$': this.$,
		'input': this.groupInput,
		'label': ve.msg( 'visualeditor-dialog-reference-options-group-label' )
	} );

	this.applyButton = new OO.ui.PushButtonWidget( {
		'$': this.$,
		'label': ve.msg( 'visualeditor-dialog-action-apply' ),
		'flags': ['primary']
	} );

	// Events
	this.applyButton.connect( this, { 'click': [ 'close', { 'action': 'apply' } ] } );

	// Initialization
	this.optionsFieldset.$element.append( this.groupLabel.$element, this.groupInput.$element );
	this.editPanel.$element.append( this.optionsFieldset.$element );
	this.$body.append( this.editPanel.$element );
	this.$foot.append( this.applyButton.$element );
};

/**
 * @inheritdoc
 */
ve.ui.MWReferenceListDialog.prototype.setup = function ( data ) {
	// Parent method
	ve.ui.MWDialog.prototype.setup.call( this, data );

	var node, refGroup;

	// Prepopulate from existing node if we're editing a node
	// instead of inserting a new one
	node = this.surface.getView().getFocusedNode();
	if ( node instanceof ve.ce.MWReferenceListNode ) {
		refGroup = node.getModel().getAttribute( 'refGroup' );

	} else {
		refGroup = '';
	}

	this.groupInput.setValue( refGroup );

	/**
	 * Focused node.
	 *
	 * @private
	 * @property {ve.ce.MWReferenceListNode|undefined}
	 */
	this.node = node;
};

/**
 * @inheritdoc
 */
ve.ui.MWReferenceListDialog.prototype.teardown = function ( data ) {
	var refGroup, listGroup, oldListGroup, attrChanges,
		doc, model,
		surfaceModel = this.surface.getModel(),
		node = this.node;

	// Data initialization
	data = data || {};

	// Save changes
	if ( data.action === 'apply' ) {
		refGroup = this.groupInput.getValue();
		listGroup = 'mwReference/' + refGroup;

		if ( node ) {
			// Edit existing model
			doc = surfaceModel.getDocument();
			model = node.getModel();
			oldListGroup = model.getAttribute( 'listGroup' );

			if ( listGroup !== oldListGroup ) {
				attrChanges = {
					listGroup: listGroup,
					refGroup: refGroup
				};
				surfaceModel.change(
					ve.dm.Transaction.newFromAttributeChanges(
						doc, model.getOuterRange().start, attrChanges
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
			] );
		}
	}

	// Parent method
	ve.ui.MWDialog.prototype.teardown.call( this, data );
};

/* Registration */

ve.ui.dialogFactory.register( ve.ui.MWReferenceListDialog );
