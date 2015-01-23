/*!
 * VisualEditor Wikia UserInterface dialog tool classes.
 */

/**
 * UserInterface WikiaCommandHelpDialog tool.
 *
 * @class
 * @extends ve.ui.CommandHelpDialogTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.WikiaCommandHelpDialogTool = function VeUiWikiaCommandHelpDialogTool( toolGroup, config ) {
	ve.ui.WikiaCommandHelpDialogTool.super.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.WikiaCommandHelpDialogTool, ve.ui.CommandHelpDialogTool );
ve.ui.WikiaCommandHelpDialogTool.static.name = 'wikiaCommandHelp';
ve.ui.WikiaCommandHelpDialogTool.static.group = 'utility';
ve.ui.WikiaCommandHelpDialogTool.static.icon = 'keyboard';
ve.ui.WikiaCommandHelpDialogTool.static.title =
	OO.ui.deferMsg( 'visualeditor-dialog-command-help-title' );
ve.ui.toolFactory.register( ve.ui.WikiaCommandHelpDialogTool );
