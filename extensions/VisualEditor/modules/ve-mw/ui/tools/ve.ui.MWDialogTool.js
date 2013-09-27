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
 * @param {ve.ui.Toolbar} toolbar
 * @param {Object} [config] Configuration options
 */
ve.ui.MWMediaEditDialogTool = function VeUiMWMediaEditDialogTool( toolbar, config ) {
	ve.ui.DialogTool.call( this, toolbar, config );
};
ve.inheritClass( ve.ui.MWMediaEditDialogTool, ve.ui.DialogTool );
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
 * @param {ve.ui.Toolbar} toolbar
 * @param {Object} [config] Configuration options
 */
ve.ui.MWMediaInsertDialogTool = function VeUiMWMediaInsertDialogTool( toolbar, config ) {
	ve.ui.DialogTool.call( this, toolbar, config );
};
ve.inheritClass( ve.ui.MWMediaInsertDialogTool, ve.ui.DialogTool );
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
 * @param {ve.ui.Toolbar} toolbar
 * @param {Object} [config] Configuration options
 */
ve.ui.MWReferenceDialogTool = function VeUiMWReferenceDialogTool( toolbar, config ) {
	ve.ui.DialogTool.call( this, toolbar, config );
};
ve.inheritClass( ve.ui.MWReferenceDialogTool, ve.ui.DialogTool );
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
 * @param {ve.ui.Toolbar} toolbar
 * @param {Object} [config] Configuration options
 */
ve.ui.MWReferenceListDialogTool = function VeUiMWReferenceListDialogTool( toolbar, config ) {
	ve.ui.DialogTool.call( this, toolbar, config );
};
ve.inheritClass( ve.ui.MWReferenceListDialogTool, ve.ui.DialogTool );
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
 * @param {ve.ui.Toolbar} toolbar
 * @param {Object} [config] Configuration options
 */
ve.ui.MWTransclusionDialogTool = function VeUiMWTransclusionDialogTool( toolbar, config ) {
	ve.ui.DialogTool.call( this, toolbar, config );
};
ve.inheritClass( ve.ui.MWTransclusionDialogTool, ve.ui.DialogTool );
ve.ui.MWTransclusionDialogTool.static.name = 'transclusion';
ve.ui.MWTransclusionDialogTool.static.group = 'object';
ve.ui.MWTransclusionDialogTool.static.icon = 'template';
ve.ui.MWTransclusionDialogTool.static.titleMessage =
	'visualeditor-dialogbutton-transclusion-tooltip';
ve.ui.MWTransclusionDialogTool.static.dialog = 'transclusion';
ve.ui.MWTransclusionDialogTool.static.modelClasses = [ ve.dm.MWTransclusionNode ];
ve.ui.toolFactory.register( ve.ui.MWTransclusionDialogTool );

