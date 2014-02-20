/*!
 * VisualEditor MediaWiki UserInterface dialog tool classes.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
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
ve.ui.MWMediaEditDialogTool.static.titleMessage = 'visualeditor-dialogbutton-media-tooltip';
ve.ui.MWMediaEditDialogTool.static.dialog = 'mediaEdit';
ve.ui.MWMediaEditDialogTool.static.modelClasses = [ ve.dm.MWBlockImageNode ];
ve.ui.MWMediaEditDialogTool.static.autoAdd = false;
ve.ui.toolFactory.register( ve.ui.MWMediaEditDialogTool );

/**
 * MediaWiki UserInterface media insert tool.
 *
 * @class
 * @extends ve.ui.DialogTool
 *
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
ve.ui.MWMediaInsertDialogTool.static.titleMessage = 'visualeditor-dialogbutton-media-tooltip';
ve.ui.MWMediaInsertDialogTool.static.dialog = 'mediaInsert';
ve.ui.toolFactory.register( ve.ui.MWMediaInsertDialogTool );

/**
 * MediaWiki UserInterface reference tool.
 *
 * @class
 * @extends ve.ui.DialogTool
 *
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
ve.ui.MWReferenceDialogTool.static.titleMessage = 'visualeditor-dialogbutton-reference-tooltip';
ve.ui.MWReferenceDialogTool.static.dialog = 'reference';
ve.ui.MWReferenceDialogTool.static.modelClasses = [ ve.dm.MWReferenceNode ];
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
ve.ui.MWReferenceListDialogTool.static.titleMessage =
	'visualeditor-dialogbutton-referencelist-tooltip';
ve.ui.MWReferenceListDialogTool.static.dialog = 'referenceList';
ve.ui.MWReferenceListDialogTool.static.modelClasses = [ ve.dm.MWReferenceListNode ];
ve.ui.toolFactory.register( ve.ui.MWReferenceListDialogTool );

/**
 * MediaWiki UserInterface transclusion tool.
 *
 * @class
 * @extends ve.ui.DialogTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.MWTransclusionDialogTool = function VeUiMWTransclusionDialogTool( toolGroup, config ) {
	ve.ui.DialogTool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.MWTransclusionDialogTool, ve.ui.DialogTool );
ve.ui.MWTransclusionDialogTool.static.name = 'transclusion';
ve.ui.MWTransclusionDialogTool.static.group = 'object';
ve.ui.MWTransclusionDialogTool.static.icon = 'template';
ve.ui.MWTransclusionDialogTool.static.titleMessage =
	'wikia-visualeditor-dialogbutton-transclusion-tooltip';
ve.ui.MWTransclusionDialogTool.static.dialog = 'transclusion';
ve.ui.MWTransclusionDialogTool.static.modelClasses = [ ve.dm.MWTransclusionNode ];
ve.ui.toolFactory.register( ve.ui.MWTransclusionDialogTool );

/**
 * MediaWiki UserInterface categories tool.
 *
 * @class
 * @extends ve.ui.DialogTool
 * @constructor
 * @param {OO.ui.Toolbar} toolbar
 * @param {Object} [config] Configuration options
 */
ve.ui.MWMetaDialogTool = function VeUiMWMetaDialogTool( toolbar, config ) {
	ve.ui.DialogTool.call( this, toolbar, config );
};
OO.inheritClass( ve.ui.MWMetaDialogTool, ve.ui.DialogTool );
ve.ui.MWMetaDialogTool.static.name = 'meta';
ve.ui.MWMetaDialogTool.static.group = 'utility';
ve.ui.MWMetaDialogTool.static.icon = 'settings';
ve.ui.MWMetaDialogTool.static.titleMessage = 'visualeditor-meta-tool';
ve.ui.MWMetaDialogTool.static.dialog = 'meta';
ve.ui.MWMetaDialogTool.static.autoAdd = false;
ve.ui.toolFactory.register( ve.ui.MWMetaDialogTool );

/**
 * MediaWiki UserInterface categories tool.
 *
 * @class
 * @extends ve.ui.DialogTool
 * @constructor
 * @param {OO.ui.Toolbar} toolbar
 * @param {Object} [config] Configuration options
 */
ve.ui.MWCategoriesDialogTool = function VeUiMWCategoriesDialogTool( toolbar, config ) {
	ve.ui.DialogTool.call( this, toolbar, config );
};
OO.inheritClass( ve.ui.MWCategoriesDialogTool, ve.ui.DialogTool );
ve.ui.MWCategoriesDialogTool.static.name = 'categories';
ve.ui.MWCategoriesDialogTool.static.group = 'utility';
ve.ui.MWCategoriesDialogTool.static.icon = 'tag';
ve.ui.MWCategoriesDialogTool.static.titleMessage = 'visualeditor-categories-tool';
ve.ui.MWCategoriesDialogTool.static.dialog = 'meta';
ve.ui.MWCategoriesDialogTool.static.config = { 'page': 'categories' };
ve.ui.MWCategoriesDialogTool.static.autoAdd = false;
ve.ui.toolFactory.register( ve.ui.MWCategoriesDialogTool );

/**
 * MediaWiki UserInterface languages tool.
 *
 * @class
 * @extends ve.ui.DialogTool
 * @constructor
 * @param {OO.ui.Toolbar} toolbar
 * @param {Object} [config] Configuration options
 */
ve.ui.MWLanguagesDialogTool = function VeUiMWLanguagesDialogTool( toolbar, config ) {
	ve.ui.DialogTool.call( this, toolbar, config );
};
OO.inheritClass( ve.ui.MWLanguagesDialogTool, ve.ui.DialogTool );
ve.ui.MWLanguagesDialogTool.static.name = 'languages';
ve.ui.MWLanguagesDialogTool.static.group = 'utility';
ve.ui.MWLanguagesDialogTool.static.icon = 'language';
ve.ui.MWLanguagesDialogTool.static.titleMessage = 'visualeditor-languages-tool';
ve.ui.MWLanguagesDialogTool.static.dialog = 'meta';
ve.ui.MWLanguagesDialogTool.static.config = { 'page': 'languages' };
ve.ui.MWLanguagesDialogTool.static.autoAdd = false;
ve.ui.toolFactory.register( ve.ui.MWLanguagesDialogTool );
