/*!
 * VisualEditor UserInterface SequenceRegistry class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Sequence registry.
 *
 * @class
 * @extends OO.Registry
 * @constructor
 */
ve.ui.SequenceRegistry = function VeUiSequenceRegistry() {
	// Parent constructor
	ve.ui.SequenceRegistry.super.call( this );
};

/* Inheritance */

OO.inheritClass( ve.ui.SequenceRegistry, OO.Registry );

/**
 * Register a sequence with the factory.
 *
 * @method
 * @param {ve.ui.Sequence} sequence Sequence object
 * @throws {Error} If sequence is not an instance of ve.ui.Sequence
 */
ve.ui.SequenceRegistry.prototype.register = function ( sequence ) {
	// Validate arguments
	if ( !( sequence instanceof ve.ui.Sequence ) ) {
		throw new Error(
			'sequence must be an instance of ve.ui.Sequence, cannot be a ' + typeof sequence
		);
	}

	ve.ui.SequenceRegistry.super.prototype.register.call( this, sequence.getName(), sequence );
};

/**
 * Find sequence matches a given offset in the data
 *
 * @param {ve.dm.ElementLinearData} data Linear data
 * @param {number} offset Offset
 * @return {{sequence:ve.ui.Sequence,range:ve.Range}[]}
 *   Array of matching sequences, and the corresponding range of the match
 *   for each.
 */
ve.ui.SequenceRegistry.prototype.findMatching = function ( data, offset ) {
	var textStart, plaintext, name, range, sequences = [];
	// To avoid blowup when matching RegExp sequences, we're going to grab
	// all the plaintext to the left (until the nearest node) *once* and pass
	// it to each sequence matcher.  We're also going to hard-limit that
	// plaintext to 256 characters to ensure we don't run into O(N^2)
	// slowdown when inserting N characters of plain text.
	for ( textStart = offset - 1; textStart >= 0 && ( offset - textStart ) <= 256; textStart-- ) {
		// Ignore an element if it occurs in the last two context characters.
		// Typing "foo\n" creates "foo</p><p>" in the data model, and we want
		// to give the matcher a chance against it.
		if ( data.isElementData( textStart ) && ( offset - textStart ) > 2 ) {
			break;
		}
	}
	plaintext = data.getText( true, new ve.Range( textStart + 1, offset ) );
	// Now search through the registry.
	for ( name in this.registry ) {
		range = this.registry[ name ].match( data, offset, plaintext );
		if ( range !== null ) {
			sequences.push( {
				sequence: this.registry[ name ],
				range: range
			} );
		}
	}
	return sequences;
};

/* Initialization */

ve.ui.sequenceRegistry = new ve.ui.SequenceRegistry();

/* Registrations */

ve.ui.sequenceRegistry.register(
	new ve.ui.Sequence( 'bulletStar', 'bulletWrapOnce', [ { type: 'paragraph' }, '*', ' ' ], 2 )
);
ve.ui.sequenceRegistry.register(
	new ve.ui.Sequence( 'numberDot', 'numberWrapOnce', [ { type: 'paragraph' }, '1', '.', ' ' ], 3 )
);
