/*!
 * VisualEditor MediaWiki UserInterface core dialog tool classes.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * MediaWiki UserInterface command help tool.
 *
 * @class
 * @extends ve.ui.DialogTool
 * @constructor
 * @param {OO.ui.Toolbar} toolbar
 * @param {Object} [config] Configuration options
 */
ve.ui.MWCommandHelpDialogTool = function VeUiMWCommandHelpDialogTool( toolbar, config ) {
	ve.ui.DialogTool.call( this, toolbar, config );
};
OO.inheritClass( ve.ui.MWCommandHelpDialogTool, ve.ui.DialogTool );
ve.ui.MWCommandHelpDialogTool.static.name = 'commandHelp';
ve.ui.MWCommandHelpDialogTool.static.group = 'utility';
ve.ui.MWCommandHelpDialogTool.static.icon = 'help';
ve.ui.MWCommandHelpDialogTool.static.title =
	OO.ui.deferMsg( 'visualeditor-dialog-command-help-title' );
ve.ui.MWCommandHelpDialogTool.static.commandName = 'commandHelp';
ve.ui.MWCommandHelpDialogTool.static.autoAddToCatchall = false;
ve.ui.MWCommandHelpDialogTool.static.autoAddToGroup = false;
ve.ui.toolFactory.register( ve.ui.MWCommandHelpDialogTool );
