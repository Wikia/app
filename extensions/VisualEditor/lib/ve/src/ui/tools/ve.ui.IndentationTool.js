/*!
 * VisualEditor UserInterface IndentationTool classes.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * UserInterface indentation tool.
 *
 * @abstract
 * @class
 * @extends ve.ui.Tool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.IndentationTool = function VeUiIndentationTool( toolGroup, config ) {
	// Parent constructor
	ve.ui.Tool.call( this, toolGroup, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.IndentationTool, ve.ui.Tool );

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.IndentationTool.prototype.onSelect = function () {
	ve.track( 'tool.indentation.select', { name: this.constructor.static.name } );
	ve.ui.Tool.prototype.onSelect.apply( this, arguments );
};

/**
 * UserInterface indent tool.
 *
 * @class
 * @extends ve.ui.IndentationTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.IncreaseIndentationTool = function VeUiIncreaseIndentationTool( toolGroup, config ) {
	ve.ui.IndentationTool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.IncreaseIndentationTool, ve.ui.IndentationTool );
ve.ui.IncreaseIndentationTool.static.name = 'indent';
ve.ui.IncreaseIndentationTool.static.group = 'structure';
ve.ui.IncreaseIndentationTool.static.icon = 'indent-list';
ve.ui.IncreaseIndentationTool.static.title =
	OO.ui.deferMsg( 'visualeditor-indentationbutton-indent-tooltip' );
ve.ui.IncreaseIndentationTool.static.commandName = 'indent';
ve.ui.toolFactory.register( ve.ui.IncreaseIndentationTool );

/**
 * UserInterface outdent tool.
 *
 * TODO: Consistency between increase/decrease, indent/outdent and indent/unindent.
 *
 * @class
 * @extends ve.ui.IndentationTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.DecreaseIndentationTool = function VeUiDecreaseIndentationTool( toolGroup, config ) {
	ve.ui.IndentationTool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.DecreaseIndentationTool, ve.ui.IndentationTool );
ve.ui.DecreaseIndentationTool.static.name = 'outdent';
ve.ui.DecreaseIndentationTool.static.group = 'structure';
ve.ui.DecreaseIndentationTool.static.icon = 'outdent-list';
ve.ui.DecreaseIndentationTool.static.title =
	OO.ui.deferMsg( 'visualeditor-indentationbutton-outdent-tooltip' );
ve.ui.DecreaseIndentationTool.static.commandName = 'outdent';
ve.ui.toolFactory.register( ve.ui.DecreaseIndentationTool );
