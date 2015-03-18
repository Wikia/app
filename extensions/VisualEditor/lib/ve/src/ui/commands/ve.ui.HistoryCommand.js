/*!
 * VisualEditor UserInterface HistoryCommand class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * UserInterface history command.
 *
 * @class
 * @extends ve.ui.Command
 *
 * @constructor
 * @param {string} name
 * @param {string} method
 */
ve.ui.HistoryCommand = function VeUiHistoryCommand( name, method ) {
	// Parent constructor
	ve.ui.HistoryCommand.super.call( this, name, 'history', method );

	this.check = {
		undo: 'canUndo',
		redo: 'canRedo'
	}[method];
};

/* Inheritance */

OO.inheritClass( ve.ui.HistoryCommand, ve.ui.Command );

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.HistoryCommand.prototype.isExecutable = function ( fragment ) {
	var surface = fragment.getSurface();

	// Parent method
	return ve.ui.HistoryCommand.super.prototype.isExecutable.apply( this, arguments ) &&
		surface[this.check].call( surface );
};

/* Registration */

ve.ui.commandRegistry.register( new ve.ui.HistoryCommand( 'undo', 'undo' ) );

ve.ui.commandRegistry.register( new ve.ui.HistoryCommand( 'redo', 'redo' ) );
