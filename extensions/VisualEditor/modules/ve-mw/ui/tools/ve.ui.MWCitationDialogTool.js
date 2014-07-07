/*!
 * VisualEditor MediaWiki UserInterface citation dialog tool class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * MediaWiki UserInterface citation dialog tool.
 *
 * @class
 * @abstract
 * @extends ve.ui.DialogTool
 * @constructor
 * @param {OO.ui.Toolbar} toolbar
 * @param {Object} [config] Configuration options
 */
ve.ui.MWCitationDialogTool = function VeUiMWCitationDialogTool( toolbar, config ) {
	ve.ui.DialogTool.call( this, toolbar, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWCitationDialogTool, ve.ui.DialogTool );

/* Static Properties */

ve.ui.MWCitationDialogTool.static.group = 'cite';

ve.ui.MWCitationDialogTool.static.template = null;

ve.ui.MWCitationDialogTool.static.modelClasses = [ ve.dm.MWReferenceNode ];

ve.ui.MWCitationDialogTool.static.requiresRange = true;

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.MWCitationDialogTool.static.isCompatibleWith = function ( model ) {
	var internalItem, branches, leaves, partsList,
		compatible = ve.ui.DialogTool.static.isCompatibleWith.call( this, model );

	if ( compatible && this.template ) {
		// Check if content of the reference node contains only a template with the same name as
		// this.template
		internalItem = model.getInternalItem();
		branches = internalItem.getChildren();
		if ( branches.length === 1 && branches[0].canContainContent() ) {
			leaves = branches[0].getChildren();
			if ( leaves.length === 1 && leaves[0] instanceof ve.dm.MWTransclusionNode ) {
				partsList = leaves[0].getPartsList();
				return partsList.length === 1 &&
					partsList[0].template === this.template;
			}
		}
		return false;
	}

	return compatible;
};
