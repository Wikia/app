/*!
 * VisualEditor Wikia UserInterface dialog tool classes.
 */

/*global mw */

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
ve.ui.WikiaMediaInsertDialogTool.static.icon = 'media';
ve.ui.WikiaMediaInsertDialogTool.static.title =
	OO.ui.deferMsg( 'wikia-visualeditor-dialogbutton-wikiamediainsert-tooltip' );
ve.ui.WikiaMediaInsertDialogTool.static.commandName = 'wikiaMediaInsert';

ve.ui.toolFactory.register( ve.ui.WikiaMediaInsertDialogTool );

/**
 * UserInterface WikiaMapInsertDialog tool.
 *
 * @class
 * @extends ve.ui.DialogTool
 *
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Config options
 */
ve.ui.WikiaMapInsertDialogTool = function VeUiWikiaMapInsertDialogTool( toolGroup, config ) {
	// Parent constructor
	ve.ui.WikiaMapInsertDialogTool.super.call( this, toolGroup, config );
};

OO.inheritClass( ve.ui.WikiaMapInsertDialogTool, ve.ui.DialogTool );

ve.ui.WikiaMapInsertDialogTool.static.name = 'wikiaMapInsert';
ve.ui.WikiaMapInsertDialogTool.static.group = 'object';
ve.ui.WikiaMapInsertDialogTool.static.icon = 'map';
ve.ui.WikiaMapInsertDialogTool.static.title =
	OO.ui.deferMsg( 'wikia-visualeditor-dialogbutton-wikiamapinsert-tooltip' );
ve.ui.WikiaMapInsertDialogTool.static.commandName = 'wikiaMapInsert';

if ( mw.config.get( 'wgEnableWikiaInteractiveMaps' ) === true ) {
	ve.ui.toolFactory.register( ve.ui.WikiaMapInsertDialogTool );
}

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
	if ( window.veSourceEntryPoint && window.veSourceEntryPoint.sourceButtonAsText ) {
		this.title = ve.msg( 'wikia-visualeditor-dialogbutton-wikiasourcemode' );
		this.$element.addClass( 've-ui-noIconDialogTool' );
	}
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
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.WikiaMetaDialogTool = function VeUiWikiaMetaDialogTool( toolGroup, config ) {
	ve.ui.WikiaMetaDialogTool.super.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.WikiaMetaDialogTool, ve.ui.MWMetaDialogTool );
ve.ui.WikiaMetaDialogTool.static.name = 'wikiaMeta';
ve.ui.WikiaMetaDialogTool.static.icon = 'settings';
ve.ui.WikiaMetaDialogTool.static.title =
	OO.ui.deferMsg( 'visualeditor-dialog-meta-settings-label' );
ve.ui.toolFactory.register( ve.ui.WikiaMetaDialogTool );

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

/**
 * UserInterface WikiaMWTransclusionDialog tool.
 *
 * @class
 * @extends ve.ui.MWTransclusionDialogTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.WikiaMWTransclusionDialogTool = function VEUIMWWikiaTransclusionDialogTool( toolGroup, config ) {
	ve.ui.WikiaMWTransclusionDialogTool.super.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.WikiaMWTransclusionDialogTool, ve.ui.MWTransclusionDialogTool );
ve.ui.WikiaMWTransclusionDialogTool.static.contextIcon = 'edit';
ve.ui.toolFactory.register( ve.ui.WikiaMWTransclusionDialogTool );

/**
 * UserInterface WikiaTemplateInsertDialog tool.
 *
 * @class
 * @extends ve.ui.TemplateInsertDialogTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.WikiaTemplateInsertDialogTool = function VEUIWikiaTemplateInsertDialogTool( toolGroup, config ) {
	ve.ui.WikiaTemplateInsertDialogTool.super.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.WikiaTemplateInsertDialogTool, ve.ui.DialogTool );
ve.ui.WikiaTemplateInsertDialogTool.static.name = 'wikiaTemplateInsert';
ve.ui.WikiaTemplateInsertDialogTool.static.group = 'object';
ve.ui.WikiaTemplateInsertDialogTool.static.icon = 'template';
ve.ui.WikiaTemplateInsertDialogTool.static.title =
	OO.ui.deferMsg( 'visualeditor-dialogbutton-template-tooltip' );
ve.ui.WikiaTemplateInsertDialogTool.static.commandName = 'wikiaTemplateInsert';
ve.ui.toolFactory.register( ve.ui.WikiaTemplateInsertDialogTool );

/**
 * UserInterface WikiaMWMediaWditDialog tool.
 *
 * @class
 * @extends ve.ui.MWMediaEditDialogTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.WikiaMWMediaEditDialogTool = function VEUIWikiaMWMediaEditDialogTool( toolGroup, config ) {
	ve.ui.WikiaMWMediaEditDialogTool.super.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.WikiaMWMediaEditDialogTool, ve.ui.MWMediaEditDialogTool );
ve.ui.WikiaMWMediaEditDialogTool.static.contextIcon = 'edit';
ve.ui.toolFactory.register( ve.ui.WikiaMWMediaEditDialogTool );

/**
 * UserInterface WikiaMWReferenceDialog tool.
 *
 * @class
 * @extends ve.ui.MWReferenceDialogTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.WikiaMWReferenceDialogTool = function VEUIWikiaMWReferenceDialogTool( toolGroup, config ) {
	ve.ui.WikiaMWReferenceDialogTool.super.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.WikiaMWReferenceDialogTool, ve.ui.MWReferenceDialogTool );
ve.ui.WikiaMWReferenceDialogTool.static.contextIcon = 'edit';
ve.ui.toolFactory.register( ve.ui.WikiaMWReferenceDialogTool );

/**
 * UserInterface WikiaMWReferenceListDialog tool.
 *
 * @class
 * @extends ve.ui.MWReferenceListDialogTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.WikiaMWReferenceListDialogTool = function VEUIWikiaMWReferenceListDialogTool( toolGroup, config ) {
	ve.ui.WikiaMWReferenceListDialogTool.super.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.WikiaMWReferenceListDialogTool, ve.ui.MWReferenceListDialogTool );
ve.ui.WikiaMWReferenceListDialogTool.static.contextIcon = 'edit';
ve.ui.toolFactory.register( ve.ui.WikiaMWReferenceListDialogTool );

/**
 * UserInterface WikiaSingleMediaDialog tool.
 *
 * @class
 * @extends ve.ui.DialogTool
 *
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Config options
 */
ve.ui.WikiaSingleMediaDialogTool = function VeUiWikiaSingleMediaDialogTool( toolGroup, config ) {
	// Parent constructor
	ve.ui.WikiaSingleMediaDialogTool.super.call( this, toolGroup, config );
};

OO.inheritClass( ve.ui.WikiaSingleMediaDialogTool, ve.ui.DialogTool );

ve.ui.WikiaSingleMediaDialogTool.static.name = 'wikiaSingleMedia';
ve.ui.WikiaSingleMediaDialogTool.static.group = 'object';
ve.ui.WikiaSingleMediaDialogTool.static.icon = 'gallery';
ve.ui.WikiaSingleMediaDialogTool.static.title =
	OO.ui.deferMsg( 'wikia-visualeditor-dialogbutton-wikiasinglemedia-tooltip' );
ve.ui.WikiaSingleMediaDialogTool.static.commandName = 'wikiaSingleMedia';

ve.ui.toolFactory.register( ve.ui.WikiaSingleMediaDialogTool );
