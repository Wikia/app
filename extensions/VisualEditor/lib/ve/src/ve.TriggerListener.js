/*!
 * VisualEditor UserInterface TriggerListener class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Trigger listener
 *
 * @class
 *
 * @constructor
 * @param {string[]} commands Commands to listen to triggers for
 */
ve.TriggerListener = function VeUiTriggerListener( commands ) {
	// Properties
	this.commands = [];
	this.commandsByTrigger = {};
	this.triggers = {};

	this.setupCommands( commands );
};

/* Inheritance */

OO.initClass( ve.TriggerListener );

/* Methods */

/**
 * Setup commands
 *
 * @param {string[]} commands Commands to listen to triggers for
 */
ve.TriggerListener.prototype.setupCommands = function ( commands ) {
	var i, j, command, triggers;
	this.commands = commands;
	if ( commands.length ) {
		for ( i = this.commands.length - 1; i >= 0; i-- ) {
			command = this.commands[i];
			triggers = ve.ui.triggerRegistry.lookup( command );
			if ( triggers ) {
				for ( j = triggers.length - 1; j >= 0; j-- ) {
					this.commandsByTrigger[triggers[j].toString()] = ve.ui.commandRegistry.lookup( command );
				}
				this.triggers[command] = triggers;
			}
		}
	}
};

/**
 * Get list of commands.
 *
 * @returns {string[]} Commands
 */
ve.TriggerListener.prototype.getCommands = function () {
	return this.commands;
};

/**
 * Get command associated with trigger string.
 *
 * @method
 * @param {string} trigger Trigger string
 * @returns {ve.ui.Command|undefined} Command
 */
ve.TriggerListener.prototype.getCommandByTrigger = function ( trigger ) {
	return this.commandsByTrigger[trigger];
};

/**
 * Get triggers for a specified name.
 *
 * @param {string} name Trigger name
 * @returns {ve.ui.Trigger[]|undefined} Triggers
 */
ve.TriggerListener.prototype.getTriggers = function ( name ) {
	return this.triggers[name];
};
