/*!
 * VisualEditor MediaWiki Reference dialog tool classes.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * MediaWiki UserInterface reference tool.
 *
 * @class
 * @extends ve.ui.DialogTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.MWReferenceDialogTool = function VeUiMWReferenceDialogTool( toolGroup, config ) {
	ve.ui.DialogTool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.MWReferenceDialogTool, ve.ui.DialogTool );
ve.ui.MWReferenceDialogTool.static.name = 'reference';
ve.ui.MWReferenceDialogTool.static.group = 'object';
ve.ui.MWReferenceDialogTool.static.icon = 'reference';
ve.ui.MWReferenceDialogTool.static.title =
	OO.ui.deferMsg( 'visualeditor-dialogbutton-reference-tooltip' );
ve.ui.MWReferenceDialogTool.static.modelClasses = [ ve.dm.MWReferenceNode ];
ve.ui.MWReferenceDialogTool.static.commandName = 'reference';
ve.ui.toolFactory.register( ve.ui.MWReferenceDialogTool );

/**
 * MediaWiki UserInterface use existing reference tool.
 *
 * @class
 * @extends ve.ui.DialogTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.MWUseExistingReferenceDialogTool = function VeUiMWUseExistingReferenceDialogTool( toolGroup, config ) {
	ve.ui.DialogTool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.MWUseExistingReferenceDialogTool, ve.ui.DialogTool );
ve.ui.MWUseExistingReferenceDialogTool.static.name = 'reference/existing';
ve.ui.MWUseExistingReferenceDialogTool.static.group = 'object';
ve.ui.MWUseExistingReferenceDialogTool.static.icon = 'reference-existing';
ve.ui.MWUseExistingReferenceDialogTool.static.title =
	OO.ui.deferMsg( 'visualeditor-dialog-reference-useexisting-tool' );
ve.ui.MWUseExistingReferenceDialogTool.static.modelClasses = [];
ve.ui.MWUseExistingReferenceDialogTool.static.commandName = 'reference/existing';
ve.ui.MWUseExistingReferenceDialogTool.static.autoAddToGroup = false;
ve.ui.MWUseExistingReferenceDialogTool.static.autoAddToCatchall = false;
ve.ui.toolFactory.register( ve.ui.MWUseExistingReferenceDialogTool );

/**
 * MediaWiki UserInterface references list tool.
 *
 * @class
 * @extends ve.ui.DialogTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.MWReferencesListDialogTool = function VeUiMWReferencesListDialogTool( toolGroup, config ) {
	ve.ui.DialogTool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.MWReferencesListDialogTool, ve.ui.DialogTool );
ve.ui.MWReferencesListDialogTool.static.name = 'referencesList';
ve.ui.MWReferencesListDialogTool.static.group = 'object';
ve.ui.MWReferencesListDialogTool.static.icon = 'references';
ve.ui.MWReferencesListDialogTool.static.title =
	OO.ui.deferMsg( 'visualeditor-dialogbutton-referenceslist-tooltip' );
ve.ui.MWReferencesListDialogTool.static.modelClasses = [ ve.dm.MWReferencesListNode ];
ve.ui.MWReferencesListDialogTool.static.commandName = 'referencesList';
ve.ui.toolFactory.register( ve.ui.MWReferencesListDialogTool );
