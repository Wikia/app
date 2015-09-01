/*!
 * VisualEditor UserInterface Sequence class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Key sequence.
 *
 * @class
 *
 * @constructor
 * @param {string} name Symbolic name
 * @param {string} commandName Command name this sequence executes
 * @param {string|Array} data Data to match
 * @param {number} [strip] Number of data elements to strip after execution (from the right)
 */
ve.ui.Sequence = function VeUiSequence( name, commandName, data, strip ) {
	this.name = name;
	this.commandName = commandName;
	this.data = data;
	this.strip = strip;
};

/* Inheritance */

OO.initClass( ve.ui.Sequence );

/* Methods */

/**
 * Check if the sequence matches a given offset in the data
 *
 * @param {string|Array} data String or linear data
 * @param {number} offset Offset
 * @return {boolean} Sequence matches
 */
ve.ui.Sequence.prototype.match = function ( data, offset ) {
	var i, j = offset - 1;

	for ( i = this.data.length - 1; i >= 0; i--, j-- ) {
		if ( typeof this.data[i] === 'string' ) {
			if ( this.data[i] !== data.getCharacterData( j ) ) {
				return false;
			}
		} else if ( !ve.compare( this.data[i], data.getData( j ), true ) ) {
			return false;
		}
	}
	return true;
};

/**
 * Execute the command associated with the sequence
 *
 * @param {ve.ui.Surface} surface surface
 * @return {boolean} The command executed
 * @throws {Error} Command not found
 */
ve.ui.Sequence.prototype.execute = function ( surface ) {
	var range, executed, stripFragment,
		surfaceModel = surface.getModel(),
		command = ve.ui.commandRegistry.lookup( this.getCommandName() );

	if ( !command ) {
		throw new Error( 'Command not found: ' + this.getCommandName() ) ;
	}

	if ( this.strip ) {
		range = surfaceModel.getSelection().getRange();
		stripFragment = surfaceModel.getLinearFragment( new ve.Range( range.end, range.end - this.strip ) );
	}

	surfaceModel.breakpoint();

	executed = command.execute( surface );

	if ( executed && stripFragment ) {
		stripFragment.removeContent();
	}

	return executed;
};

/**
 * Get the symbolic name of the sequence
 *
 * @return {string} Symbolic name
 */
ve.ui.Sequence.prototype.getName = function () {
	return this.name;
};

/**
 * Get the command name which the sequence will execute
 *
 * @return {string} Command name
 */
ve.ui.Sequence.prototype.getCommandName = function () {
	return this.commandName;
};
