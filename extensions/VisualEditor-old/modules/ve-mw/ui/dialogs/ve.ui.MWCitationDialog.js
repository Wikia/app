/*
 * VisualEditor user interface MWCitationDialog class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Dialog for inserting and editing MediaWiki transclusions.
 *
 * @class
 * @extends ve.ui.MWTemplateDialog
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.MWCitationDialog = function VeUiMWCitationDialog( config ) {
	// Parent constructor
	ve.ui.MWCitationDialog.super.call( this, config );

	// Properties
	this.referenceModel = null;
	this.referenceNode = null;
};

/* Inheritance */

OO.inheritClass( ve.ui.MWCitationDialog, ve.ui.MWTemplateDialog );

/* Static Properties */

ve.ui.MWCitationDialog.static.name = 'citation';

ve.ui.MWCitationDialog.static.icon = 'reference';

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.MWCitationDialog.prototype.getApplyButtonLabel = function () {
	return ve.msg(
		this.inserting ?
			'visualeditor-dialog-citation-insert-citation' :
			'visualeditor-dialog-action-apply'
	);
};

/**
 * Get the reference node to be edited.
 *
 * @returns {ve.dm.MWReferenceNode|null} Reference node to be edited, null if none exists
 */
ve.ui.MWCitationDialog.prototype.getReferenceNode = function () {
	var selectedNode = this.getFragment().getSelectedNode();

	if ( selectedNode instanceof ve.dm.MWReferenceNode ) {
		return selectedNode;
	}

	return null;
};

/**
 * @inheritdoc
 */
ve.ui.MWCitationDialog.prototype.getSelectedNode = function () {
	var branches, leaves, transclusionNode,
		referenceNode = this.getReferenceNode();

	if ( referenceNode ) {
		branches = referenceNode.getInternalItem().getChildren();
		leaves = branches &&
			branches.length === 1 &&
			branches[0].canContainContent() &&
			branches[0].getChildren();
		transclusionNode = leaves &&
			leaves.length === 1 &&
			leaves[0] instanceof ve.dm.MWTransclusionNode &&
			leaves[0];
	}

	return transclusionNode || null;
};

/**
 * @inheritdoc
 */
ve.ui.MWCitationDialog.prototype.applyChanges = function () {
	var item,
		surfaceModel = this.getFragment().getSurface(),
		doc = surfaceModel.getDocument(),
		internalList = doc.getInternalList(),
		obj = this.transclusionModel.getPlainObject();

	if ( !this.referenceModel ) {
		// Collapse returns a new fragment, so update this.fragment
		this.fragment = this.getFragment().collapseRangeToEnd();
		this.referenceModel = new ve.dm.MWReferenceModel();
		this.referenceModel.insertInternalItem( surfaceModel );
		this.referenceModel.insertReferenceNode( this.getFragment() );
	}

	item = this.referenceModel.findInternalItem( surfaceModel );
	if ( item ) {
		if ( this.selectedNode ) {
			this.transclusionModel.updateTransclusionNode( surfaceModel, this.selectedNode );
		} else if ( obj !== null ) {
			this.transclusionModel.insertTransclusionNode(
				// HACK: This is trying to place the cursor inside the first content branch node
				// but this theoretically not a safe assumption - in practice, the citation dialog
				// will only reach this code if we are inserting (not updating) a transclusion, so
				// the referenceModel will have already initialized the internal node with a
				// paragraph - getting the range of the item covers the entire paragraph so we have
				// to get the range of it's first (and empty) child
				this.getFragment().clone( item.getChildren()[0].getRange() )
			);
		}
	}

	// HACK: Scorch the earth - this is only needed because without it, the reference list won't
	// re-render properly, and can be removed once someone fixes that
	this.referenceModel.setDocument(
		doc.cloneFromRange(
			internalList.getItemNode( this.referenceModel.getListIndex() ).getRange()
		)
	);
	this.referenceModel.updateInternalItem( surfaceModel );

	// Grandparent method
	return ve.ui.MWCitationDialog.super.super.prototype.applyChanges.call( this );
};

/**
 * @inheritdoc
 */
ve.ui.MWCitationDialog.prototype.initialize = function ( data ) {
	// Parent method
	ve.ui.MWCitationDialog.super.prototype.initialize.call( this, data );

	// HACK: Use the same styling as single-mode transclusion dialog - this should be generalized
	this.frame.$content.addClass( 've-ui-mwTransclusionDialog-single' );
};

/**
 * @inheritdoc
 */
ve.ui.MWCitationDialog.prototype.getSetupProcess = function ( data ) {
	return ve.ui.MWCitationDialog.super.prototype.getSetupProcess.call( this, data )
		.next( function () {
			// Initialization
			if ( this.selectedNode ) {
				this.referenceNode = this.getReferenceNode();
				if ( this.referenceNode ) {
					this.referenceModel = ve.dm.MWReferenceModel.static.newFromReferenceNode(
						this.referenceNode
					);
				}
			}
		}, this );
};

ve.ui.MWCitationDialog.prototype.onTransclusionReady = function () {
	// Parent method
	ve.ui.MWCitationDialog.super.prototype.onTransclusionReady.call( this );

	if ( !this.hasUsefulParameter() ) {
		this.applyButton.setDisabled( true );
	}
};

/**
 * @inheritdoc
 */
ve.ui.MWCitationDialog.prototype.setPageByName = function ( param ) {
	// Parent method
	ve.ui.MWCitationDialog.super.prototype.setPageByName.call( this, param );

	this.applyButton.setDisabled( !this.hasUsefulParameter() );
};

/**
 * @inheritdoc
 */
ve.ui.MWCitationDialog.prototype.onAddParameterBeforeLoad = function ( page ) {
	var citeDialog = this;
	page.preLoad = true;
	page.valueInput.on( 'change', function () {
		citeDialog.applyButton.setDisabled( !citeDialog.hasUsefulParameter() );
	} );
};

/**
 * Works out whether there are any set parameters that aren't just placeholders
 * @return boolean
 */
ve.ui.MWCitationDialog.prototype.hasUsefulParameter = function () {
	var foundUseful = false;
	$.each( this.bookletLayout.pages, function () {
		if (
			this instanceof ve.ui.MWParameterPage &&
			( !this.preLoad || this.valueInput.getValue() !== '' )
		) {
			foundUseful = true;
			return false;
		}
	} );
	return foundUseful;
};

/**
 * @inheritdoc
 */
ve.ui.MWCitationDialog.prototype.getTeardownProcess = function ( data ) {
	return ve.ui.MWCitationDialog.super.prototype.getTeardownProcess.call( this, data )
		.next( function () {
			// Cleanup
			this.referenceModel = null;
			this.referenceNode = null;
		}, this );
};
