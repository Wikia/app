/*!
 * VisualEditor UserInterface IndentationTool classes.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface intentation tool.
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

/* Static Properties */

ve.ui.IndentationTool.static.requiresRange = true;

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.IndentationTool.prototype.onSelect = function () {
	ve.track( 'tool.indentation.select', { name: this.constructor.static.name } );
	ve.ui.Tool.prototype.onSelect.apply( this, arguments );
};

/**
 * @inheritdoc
 */
ve.ui.IndentationTool.prototype.onUpdateState = function ( fragment ) {
	// Parent method
	ve.ui.Tool.prototype.onUpdateState.apply( this, arguments );

	if ( !this.isDisabled() ) {
		var i, len,
			nodes = fragment.getSelectedLeafNodes(),
			any = false;
		for ( i = 0, len = nodes.length; i < len; i++ ) {
			if ( nodes[i].hasMatchingAncestor( 'listItem' ) ) {
				any = true;
				break;
			}
		}
		this.setDisabled( !any );
	}
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
