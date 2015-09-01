/*!
 * VisualEditor UserInterface Sequence class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Key sequence.
 *
 * @class
 *
 * @constructor
 * @param {string} name Symbolic name
 * @param {string} commandName Command name this sequence executes
 * @param {string|Array|RegExp} data Data to match
 * @param {number} [strip=0] Number of data elements to strip after execution
 *        (from the right)
 * @param {boolean} [setSelection=false] Whether to set the selection to the
 *        range matching the sequence before executing the command.
 */
ve.ui.Sequence = function VeUiSequence( name, commandName, data, strip, setSelection ) {
	this.name = name;
	this.commandName = commandName;
	this.data = data;
	this.strip = strip;
	this.setSelection = setSelection;
};

/* Inheritance */

OO.initClass( ve.ui.Sequence );

/* Methods */

/**
 * Check if the sequence matches a given offset in the data
 *
 * @param {ve.dm.ElementLinearData} data String or linear data
 * @param {number} offset Offset
 * @return {ve.Range|null} Range corresponding to the match, or else null
 */
ve.ui.Sequence.prototype.match = function ( data, offset, plaintext ) {
	var i, j = offset - 1;

	if ( this.data instanceof RegExp ) {
		i = plaintext.search( this.data );
		return ( i < 0 ) ? null :
			new ve.Range( offset - plaintext.length + i, offset );
	}
	for ( i = this.data.length - 1; i >= 0; i--, j-- ) {
		if ( typeof this.data[ i ] === 'string' ) {
			if ( this.data[ i ] !== data.getCharacterData( j ) ) {
				return null;
			}
		} else if ( !ve.compare( this.data[ i ], data.getData( j ), true ) ) {
			return null;
		}
	}
	return new ve.Range( offset - this.data.length, offset );
};

/**
 * Execute the command associated with the sequence
 *
 * @param {ve.ui.Surface} surface surface
 * @return {boolean} The command executed
 * @throws {Error} Command not found
 */
ve.ui.Sequence.prototype.execute = function ( surface, range ) {
	var stripRange, executed, stripFragment, selection,
		surfaceModel = surface.getModel(),
		command = ve.init.target.commandRegistry.lookup( this.getCommandName() );

	if ( !command ) {
		throw new Error( 'Command not found: ' + this.getCommandName() ) ;
	}

	if ( this.strip ) {
		stripRange = surfaceModel.getSelection().getRange();
		stripFragment = surfaceModel.getLinearFragment( new ve.Range( stripRange.end, stripRange.end - this.strip ) );
	}

	surfaceModel.breakpoint();

	if ( this.setSelection ) {
		selection = surfaceModel.getSelection();
		surfaceModel.setLinearSelection( range );
	}

	executed = command.execute( surface );

	if ( executed && stripFragment ) {
		stripFragment.removeContent();
	}

	if ( !executed && selection ) {
		surfaceModel.setSelection( selection );
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
