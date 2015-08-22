/*!
 * VisualEditor MediaWiki media dialog tool classes.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * MediaWiki UserInterface media edit tool.
 *
 * @class
 * @extends ve.ui.DialogTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.MWMediaEditDialogTool = function VeUiMWMediaEditDialogTool( toolGroup, config ) {
	ve.ui.DialogTool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.MWMediaEditDialogTool, ve.ui.DialogTool );
ve.ui.MWMediaEditDialogTool.static.name = 'mediaEdit';
ve.ui.MWMediaEditDialogTool.static.group = 'object';
ve.ui.MWMediaEditDialogTool.static.icon = 'picture';
ve.ui.MWMediaEditDialogTool.static.title =
	OO.ui.deferMsg( 'visualeditor-dialogbutton-media-tooltip' );
ve.ui.MWMediaEditDialogTool.static.modelClasses = [ ve.dm.MWBlockImageNode, ve.dm.MWInlineImageNode ];
ve.ui.MWMediaEditDialogTool.static.commandName = 'mediaEdit';
ve.ui.MWMediaEditDialogTool.static.autoAddToCatchall = false;
ve.ui.MWMediaEditDialogTool.static.autoAddToGroup = false;
ve.ui.toolFactory.register( ve.ui.MWMediaEditDialogTool );

/**
 * MediaWiki UserInterface media insert tool.
 *
 * @class
 * @extends ve.ui.DialogTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.MWMediaInsertDialogTool = function VeUiMWMediaInsertDialogTool( toolGroup, config ) {
	ve.ui.DialogTool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.MWMediaInsertDialogTool, ve.ui.DialogTool );
ve.ui.MWMediaInsertDialogTool.static.name = 'mediaInsert';
ve.ui.MWMediaInsertDialogTool.static.group = 'object';
ve.ui.MWMediaInsertDialogTool.static.icon = 'picture';
ve.ui.MWMediaInsertDialogTool.static.title =
	OO.ui.deferMsg( 'visualeditor-dialogbutton-media-tooltip' );
ve.ui.MWMediaInsertDialogTool.static.commandName = 'mediaInsert';
ve.ui.MWMediaInsertDialogTool.static.requiresRange = true;
ve.ui.toolFactory.register( ve.ui.MWMediaInsertDialogTool );
