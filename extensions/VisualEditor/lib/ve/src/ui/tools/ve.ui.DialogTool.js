/*!
 * VisualEditor UserInterface DialogTool class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
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
ve.ui.DialogTool = function VeUiDialogTool() {
	// Parent constructor
	ve.ui.DialogTool.super.apply( this, arguments );
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
 * Name of the associated windows, if there is more than one possible value, or if it can't be
 * deduced from the tool's command.
 *
 * @static
 * @property {string[]}
 * @inheritable
 */
ve.ui.DialogTool.static.associatedWindows = null;

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
ve.ui.DialogTool.prototype.onUpdateState = function ( fragment, contextDirection, activeDialogs ) {
	var myWindowNames = [];

	// Parent method
	ve.ui.DialogTool.super.prototype.onUpdateState.apply( this, arguments );

	if ( this.constructor.static.associatedWindows !== null ) {
		myWindowNames = this.constructor.static.associatedWindows;
	} else if ( this.getCommand().getAction() === 'window' ) {
		myWindowNames = [ this.getCommand().getArgs()[ 0 ] ];
	}

	// Show the tool as active if any of its associated windows is open
	this.setActive( $( activeDialogs ).filter( myWindowNames ).length !== 0 );
};

/**
 * Command help tool.
 *
 * @class
 * @extends ve.ui.DialogTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.CommandHelpDialogTool = function VeUiCommandHelpDialogTool() {
	ve.ui.CommandHelpDialogTool.super.apply( this, arguments );
};
OO.inheritClass( ve.ui.CommandHelpDialogTool, ve.ui.DialogTool );
ve.ui.CommandHelpDialogTool.static.name = 'commandHelp';
ve.ui.CommandHelpDialogTool.static.group = 'dialog';
ve.ui.CommandHelpDialogTool.static.icon = 'help';
ve.ui.CommandHelpDialogTool.static.title =
	OO.ui.deferMsg( 'visualeditor-dialog-command-help-title' );
ve.ui.CommandHelpDialogTool.static.autoAddToCatchall = false;
ve.ui.CommandHelpDialogTool.static.autoAddToGroup = false;
ve.ui.CommandHelpDialogTool.static.commandName = 'commandHelp';
ve.ui.toolFactory.register( ve.ui.CommandHelpDialogTool );
