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
ve.ui.MWMediaDialogTool = function VeUiMWMediaDialogTool( toolGroup, config ) {
	ve.ui.DialogTool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.MWMediaDialogTool, ve.ui.DialogTool );
ve.ui.MWMediaDialogTool.static.name = 'media';
ve.ui.MWMediaDialogTool.static.group = 'object';
ve.ui.MWMediaDialogTool.static.icon = 'picture';
ve.ui.MWMediaDialogTool.static.title =
	OO.ui.deferMsg( 'visualeditor-dialogbutton-media-tooltip' );
ve.ui.MWMediaDialogTool.static.modelClasses = [ ve.dm.MWBlockImageNode, ve.dm.MWInlineImageNode ];
ve.ui.MWMediaDialogTool.static.commandName = 'media';
ve.ui.MWMediaDialogTool.static.autoAddToCatchall = false;
ve.ui.MWMediaDialogTool.static.autoAddToGroup = false;
ve.ui.toolFactory.register( ve.ui.MWMediaDialogTool );
