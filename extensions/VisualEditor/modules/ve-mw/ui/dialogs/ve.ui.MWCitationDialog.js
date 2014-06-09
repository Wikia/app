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
 * @extends ve.ui.MWTransclusionDialog
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.MWCitationDialog = function VeUiMWCitationDialog( config ) {
	// Parent constructor
	ve.ui.MWTransclusionDialog.call( this, config );

	// Properties
	this.referenceModel = null;
	this.referenceNode = null;
};

/* Inheritance */

OO.inheritClass( ve.ui.MWCitationDialog, ve.ui.MWTransclusionDialog );

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
	var focusedNode = this.getFragment().getSelectedNode();
	return focusedNode instanceof ve.dm.MWReferenceNode ? focusedNode : null;
};

/**
 * @inheritdoc
 */
ve.ui.MWCitationDialog.prototype.getTransclusionNode = function () {
	var branches, leaves, transclusionNode,
		referenceNode = this.getReferenceNode();

	if ( referenceNode instanceof ve.dm.MWReferenceNode ) {
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
ve.ui.MWCitationDialog.prototype.saveChanges = function () {
	var item,
		surfaceFragment = this.getFragment(),
		surfaceModel = surfaceFragment.getSurface(),
		doc = surfaceModel.getDocument(),
		internalList = doc.getInternalList(),
		obj = this.transclusion.getPlainObject();

	if ( !this.referenceModel ) {
		surfaceModel.getFragment().collapseRangeToEnd();
		this.referenceModel = new ve.dm.MWReferenceModel();
		this.referenceModel.insertInternalItem( surfaceModel );
		this.referenceModel.insertReferenceNode( surfaceFragment );
	}

	item = this.referenceModel.findInternalItem( surfaceModel );
	if ( item ) {
		if ( this.transclusionNode instanceof ve.dm.MWTransclusionNode ) {
			this.transclusion.updateTransclusionNode( surfaceModel, this.transclusionNode );
		} else if ( obj !== null ) {
			this.transclusion.insertTransclusionNode(
				// HACK: This is trying to place the cursor inside the first content branch node
				// but this theoretically not a safe assumption - in practice, the citation dialog
				// will only reach this code if we are inserting (not updating) a transclusion, so
				// the referenceModel will have already initialized the internal node with a
				// paragraph - getting the range of the item covers the entire paragraph so we have
				// to get the range of it's first (and empty) child
				surfaceFragment.clone( item.getChildren()[0].getRange() )
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
};

/**
 * @inheritdoc
 */
ve.ui.MWCitationDialog.prototype.setup = function ( data ) {
	// Parent method
	ve.ui.MWTransclusionDialog.prototype.setup.call( this, data );

	// Initialization
	if ( this.transclusionNode ) {
		this.referenceNode = this.getReferenceNode();
		if ( this.referenceNode instanceof ve.dm.MWReferenceNode ) {
			this.referenceModel = ve.dm.MWReferenceModel.static.newFromReferenceNode(
				this.referenceNode
			);
		}
	}
};

/**
 * @inheritdoc
 */
ve.ui.MWCitationDialog.prototype.teardown = function ( data ) {
	// Parent method
	ve.ui.MWTransclusionDialog.prototype.teardown.call( this, data );

	// Cleanup
	this.referenceModel = null;
	this.referenceNode = null;
};
