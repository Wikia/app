/**
 * UserInterface WikiaSourceModeDialog tool.
 *
 * @class
 * @extends ve.ui.IconTextButtonTool
 *
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Config options
 */
ve.ui.WikiaSourceModeDialogTool = function VeUiWikiaSourceModeDialogTool( toolGroup, config ) {
	// Parent constructor
	ve.ui.WikiaSourceModeDialogTool.super.call( this, toolGroup, config );
};

OO.inheritClass( ve.ui.WikiaSourceModeDialogTool, ve.ui.DialogTool );

ve.ui.WikiaSourceModeDialogTool.static.name = 'wikiaSourceMode';
ve.ui.WikiaSourceModeDialogTool.static.group = 'object';
ve.ui.WikiaSourceModeDialogTool.static.icon = 'source';
ve.ui.WikiaSourceModeDialogTool.static.title =
	OO.ui.deferMsg( 'wikia-visualeditor-dialogbutton-wikiasourcemode-tooltip' );
ve.ui.WikiaSourceModeDialogTool.static.commandName = 'wikiaSourceMode';

ve.ui.toolFactory.register( ve.ui.WikiaSourceModeDialogTool );

/**
 * UserInterface WikiaMediaInsertDialog tool.
 *
 * @class
 * @extends ve.ui.DialogTool
 *
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Config options
 */
ve.ui.WikiaMediaInsertDialogTool = function VeUiWikiaMediaInsertDialogTool( toolGroup, config ) {
	// Parent constructor
	ve.ui.WikiaMediaInsertDialogTool.super.call( this, toolGroup, config );
};

OO.inheritClass( ve.ui.WikiaMediaInsertDialogTool, ve.ui.DialogTool );

ve.ui.WikiaMediaInsertDialogTool.static.name = 'wikiaMediaInsert';
ve.ui.WikiaMediaInsertDialogTool.static.group = 'object';

// ve-upstream-sync - review - @author: Paul Oslund
// This should be media; however until we bring in the scss, media doesn't exist
ve.ui.WikiaMediaInsertDialogTool.static.icon = 'picture';
// ve.ui.WikiaMediaInsertDialogTool.static.icon = 'media';
ve.ui.WikiaMediaInsertDialogTool.static.title =
	OO.ui.deferMsg( 'wikia-visualeditor-dialogbutton-wikiamediainsert-tooltip' );
ve.ui.WikiaMediaInsertDialogTool.static.commandName = 'wikiaMediaInsert';

ve.ui.toolFactory.register( ve.ui.WikiaMediaInsertDialogTool );
