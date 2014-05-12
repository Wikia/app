/*!
 * VisualEditor Wikia UserInterface dialog tool classes.
 */

/**
 * UserInterface WikiaMediaInsertDialog tool.
 *
 * @class
 * @extends ve.ui.DialogTool
 *
 * @constructor
 * @param {OO.ui.Toolbar} toolbar
 * @param {Object} [config] Config options
 */
ve.ui.WikiaMediaInsertDialogTool = function VeUiWikiaMediaInsertDialogTool( toolbar, config ) {
	// Parent constructor
	ve.ui.DialogTool.call( this, toolbar, config );
};

OO.inheritClass( ve.ui.WikiaMediaInsertDialogTool, ve.ui.DialogTool );

ve.ui.WikiaMediaInsertDialogTool.static.name = 'wikiaMediaInsert';
ve.ui.WikiaMediaInsertDialogTool.static.group = 'object';
ve.ui.WikiaMediaInsertDialogTool.static.icon = 'media';
ve.ui.WikiaMediaInsertDialogTool.static.titleMessage = 'wikia-visualeditor-dialogbutton-wikiamediainsert-tooltip';
ve.ui.WikiaMediaInsertDialogTool.static.dialog = 'wikiaMediaInsert';

ve.ui.toolFactory.register( ve.ui.WikiaMediaInsertDialogTool );

/**
 * UserInterface WikiaSourceModeDialog tool.
 *
 * @class
 * @extends ve.ui.IconTextButtonTool
 *
 * @constructor
 * @param {OO.ui.Toolbar} toolbar
 * @param {Object} [config] Config options
 */
ve.ui.WikiaSourceModeDialogTool = function VeUiWikiaSourceModeDialogTool( toolbar, config ) {
	// Parent constructor
	ve.ui.DialogTool.call( this, toolbar, config );
};

OO.inheritClass( ve.ui.WikiaSourceModeDialogTool, ve.ui.DialogTool );

ve.ui.WikiaSourceModeDialogTool.static.name = 'wikiaSourceMode';
ve.ui.WikiaSourceModeDialogTool.static.group = 'object';
ve.ui.WikiaSourceModeDialogTool.static.icon = 'source';
ve.ui.WikiaSourceModeDialogTool.static.titleMessage = 'wikia-visualeditor-dialogbutton-wikiasourcemode-tooltip';
ve.ui.WikiaSourceModeDialogTool.static.dialog = 'wikiaSourceMode';

ve.ui.toolFactory.register( ve.ui.WikiaSourceModeDialogTool );
