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
ve.ui.MWReferenceDialogTool.static.requiresRange = true;
ve.ui.toolFactory.register( ve.ui.MWReferenceDialogTool );

/**
 * MediaWiki UserInterface reference list tool.
 *
 * @class
 * @extends ve.ui.DialogTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.MWReferenceListDialogTool = function VeUiMWReferenceListDialogTool( toolGroup, config ) {
	ve.ui.DialogTool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.MWReferenceListDialogTool, ve.ui.DialogTool );
ve.ui.MWReferenceListDialogTool.static.name = 'referenceList';
ve.ui.MWReferenceListDialogTool.static.group = 'object';
ve.ui.MWReferenceListDialogTool.static.icon = 'references';
ve.ui.MWReferenceListDialogTool.static.title =
	OO.ui.deferMsg( 'visualeditor-dialogbutton-referencelist-tooltip' );
ve.ui.MWReferenceListDialogTool.static.modelClasses = [ ve.dm.MWReferenceListNode ];
ve.ui.MWReferenceListDialogTool.static.commandName = 'referenceList';
ve.ui.MWReferenceListDialogTool.static.requiresRange = true;
ve.ui.toolFactory.register( ve.ui.MWReferenceListDialogTool );
