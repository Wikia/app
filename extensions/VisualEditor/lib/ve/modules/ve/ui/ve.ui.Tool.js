/*!
 * VisualEditor UserInterface Tool classes.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface annotation tool.
 *
 * @class
 * @abstract
 * @extends OO.ui.Tool
 *
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.Tool = function VeUiTool( toolGroup, config ) {
	// Parent constructor
	OO.ui.Tool.call( this, toolGroup, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.Tool, OO.ui.Tool );

/* Static Properties */

/**
 * This tool requires this surface to be focused to work
 * @type {boolean}
 */
ve.ui.Tool.static.requiresRange = false;

/**
 * Command to execute when tool is selected.
 *
 * @static
 * @property {string|null}
 * @inheritable
 */
ve.ui.Tool.static.commandName = null;

/**
 * Deactivate tool after it's been selected.
 *
 * Use this for tools which don't display as active when relevant content is selected, such as
 * insertion-only tools.
 *
 * @static
 * @property {boolean}
 * @inheritable
 */
ve.ui.Tool.static.deactivateOnSelect = true;

/**
 * Get the symbolic command name for this tool.
 *
 * @return {ve.ui.Command}
 */
ve.ui.Tool.static.getCommandName = function () {
	return this.commandName;
};

/* Methods */

/**
 * Handle the toolbar state being updated.
 *
 * @method
 * @param {ve.dm.SurfaceFragment} fragment Surface fragment
 * @param {Object} direction Context direction with 'inline' & 'block' properties
 */
ve.ui.Tool.prototype.onUpdateState = function ( fragment ) {
	this.setDisabled( this.constructor.static.requiresRange && !fragment.getRange() );
};

/**
 * @inheritdoc
 */
ve.ui.Tool.prototype.onSelect = function () {
	var command = this.getCommand();
	if ( command instanceof ve.ui.Command ) {
		command.execute( this.toolbar.getSurface() );
	}
	if ( this.constructor.static.deactivateOnSelect ) {
		this.setActive( false );
	}
};

/**
 * Get the command for this tool.
 *
 * @return {ve.ui.Command}
 */
ve.ui.Tool.prototype.getCommand = function () {
	return ve.ui.commandRegistry.lookup( this.constructor.static.commandName );
};
