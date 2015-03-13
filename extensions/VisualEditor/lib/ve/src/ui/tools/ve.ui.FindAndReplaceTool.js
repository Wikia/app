/*!
 * VisualEditor UserInterface FindAndReplaceTool classes.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * UserInterface FindAndReplace tool.
 *
 * @abstract
 * @class
 * @extends ve.ui.Tool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.FindAndReplaceTool = function VeUiFindAndReplaceTool( toolGroup, config ) {
	// Parent constructor
	ve.ui.Tool.call( this, toolGroup, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.FindAndReplaceTool, ve.ui.Tool );

ve.ui.FindAndReplaceTool.static.name = 'findAndReplace';
ve.ui.FindAndReplaceTool.static.group = 'dialog';
ve.ui.FindAndReplaceTool.static.icon = 'find';
ve.ui.FindAndReplaceTool.static.title =
	OO.ui.deferMsg( 'visualeditor-find-and-replace-title' );
ve.ui.FindAndReplaceTool.static.autoAddToCatchall = false;
ve.ui.FindAndReplaceTool.static.autoAddToGroup = false;
ve.ui.FindAndReplaceTool.static.commandName = 'findAndReplace';
ve.ui.toolFactory.register( ve.ui.FindAndReplaceTool );
