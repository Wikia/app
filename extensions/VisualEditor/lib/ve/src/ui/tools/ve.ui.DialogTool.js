/*!
 * VisualEditor UserInterface DialogTool class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * UserInterface dialog tool.
 *
 * @abstract
 * @class
 * @extends ve.ui.Tool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.DialogTool = function VeUiDialogTool( toolGroup, config ) {
	// Parent constructor
	ve.ui.Tool.call( this, toolGroup, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.DialogTool, ve.ui.Tool );

/* Static Properties */

/**
 * Annotation or node models this tool is related to.
 *
 * Used by #isCompatibleWith.
 *
 * @static
 * @property {Function[]}
 * @inheritable
 */
ve.ui.DialogTool.static.modelClasses = [];

/**
 * @inheritdoc
 */
ve.ui.DialogTool.static.isCompatibleWith = function ( model ) {
	return ve.isInstanceOfAny( model, this.modelClasses );
};

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.DialogTool.prototype.onUpdateState = function () {
	// Parent method
	ve.ui.Tool.prototype.onUpdateState.apply( this, arguments );
	// Never show the tool as active
	this.setActive( false );
};

/**
 * @class
 * @extends ve.ui.DialogTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.CommandHelpDialogTool = function VeUiCommandHelpDialogTool( toolGroup, config ) {
	ve.ui.DialogTool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.CommandHelpDialogTool, ve.ui.DialogTool );
ve.ui.CommandHelpDialogTool.static.name = 'commandHelp';
ve.ui.CommandHelpDialogTool.static.group = 'dialog';
ve.ui.CommandHelpDialogTool.static.icon = 'keyboard';
ve.ui.CommandHelpDialogTool.static.title =
	OO.ui.deferMsg( 'visualeditor-dialog-command-help-title' );
ve.ui.CommandHelpDialogTool.static.autoAddToCatchall = false;
ve.ui.CommandHelpDialogTool.static.autoAddToGroup = false;
ve.ui.CommandHelpDialogTool.static.commandName = 'commandHelp';
ve.ui.toolFactory.register( ve.ui.CommandHelpDialogTool );
