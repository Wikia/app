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
ve.ui.WikiaMediaInsertDialogTool.static.title =
	OO.ui.deferMsg( 'wikia-visualeditor-dialogbutton-wikiamediainsert-tooltip' );
ve.ui.WikiaMediaInsertDialogTool.static.commandName = 'wikiaMediaInsert';

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
ve.ui.WikiaSourceModeDialogTool.static.title =
	OO.ui.deferMsg( 'wikia-visualeditor-dialogbutton-wikiasourcemode-tooltip' );
ve.ui.WikiaSourceModeDialogTool.static.commandName = 'wikiaSourceMode';

ve.ui.toolFactory.register( ve.ui.WikiaSourceModeDialogTool );

/**
 * UserInterface WikiaMetaDialog tool.
 *
 * @class
 * @extends ve.ui.MWMetaDialogTool
 * @constructor
 * @param {OO.ui.Toolbar} toolbar
 * @param {Object} [config] Configuration options
 */
ve.ui.WikiaMetaDialogTool = function VeUiWikiaMetaDialogTool( toolbar, config ) {
	ve.ui.MWMetaDialogTool.call( this, toolbar, config );
};
OO.inheritClass( ve.ui.WikiaMetaDialogTool, ve.ui.MWMetaDialogTool );
ve.ui.MWMetaDialogTool.static.name = 'wikiaMeta';
ve.ui.MWMetaDialogTool.static.icon = 'advanced';
ve.ui.MWMetaDialogTool.static.title =
	OO.ui.deferMsg( 'visualeditor-dialog-meta-settings-label' );
ve.ui.toolFactory.register( ve.ui.WikiaMetaDialogTool );
