/**
 * Serializes a WikiDom plain object into a JSON string.
 * 
 * @class
 * @constructor
 * @param {Object} options List of options for serialization
 * @param {String} options.indentWith Text to use as indentation, such as \t or 4 spaces
 * @param {String} options.joinWith Text to use as line joiner, such as \n or '' (empty string)
 */
ve.dm.JsonSerializer = function( options ) {
	this.options = $.extend( {
		'indentWith': '\t',
		'joinWith': '\n'
	}, options || {} );
};

/* Static Methods */

/**
 * Get a serialized version of data.
 * 
 * @static
 * @method
 * @param {Object} data Data to serialize
 * @param {Object} options Options to use, @see {ve.dm.JsonSerializer} for details
 * @returns {String} Serialized version of data
 */
ve.dm.JsonSerializer.stringify = function( data, options ) {
	return ( new ve.dm.JsonSerializer( options ) ).stringify( data );
};

/**
 * Gets the type of a given value.
 * 
 * @static
 * @method
 * @param {Mixed} value Value to get type of
 * @returns {String} Symbolic name of type
 */
ve.dm.JsonSerializer.typeOf = function( value ) {
	if ( typeof value === 'object' ) {
		if ( value === null ) {
			return 'null';
		}
		switch ( value.constructor ) {
			case [].constructor:
				return 'array';
			case ( new Date() ).constructor:
				return 'date';
			case ( new RegExp() ).constructor:
				return 'regex';
			default:
				return 'object';
		}
	}
	return typeof value;
};

/* Methods */

/**
 * Get a serialized version of data.
 * 
 * @method
 * @param {Object} data Data to serialize
 * @param {String} indentation String to prepend each line with (used internally with recursion)
 * @returns {String} Serialized version of data
 */
ve.dm.JsonSerializer.prototype.stringify = function( data, indention ) {
	if ( indention === undefined ) {
		indention = '';
	}
	var type = ve.dm.JsonSerializer.typeOf( data ),
		key;
	
	// Open object/array
	var json = '';
	if ( type === 'array' ) {
		if (data.length === 0) {
			// Empty array
			return '[]';
		}
		json += '[';
	} else {
		var empty = true;
		for ( key in data ) {
			if ( data.hasOwnProperty( key ) ) {
				empty = false;
				break;
			}
		}
		if ( empty ) {
			return '{}';
		}
		json += '{';
	}
	
	// Iterate over items
	var comma = false;
	for ( key in data ) {
		if ( data.hasOwnProperty( key ) ) {
			json += ( comma ? ',' : '' ) + this.options.joinWith + indention +
				this.options.indentWith + ( type === 'array' ? '' : '"' + key + '"' + ': ' );
			switch ( ve.dm.JsonSerializer.typeOf( data[key] ) ) {
				case 'array':
				case 'object':
					json += this.stringify( data[key], indention + this.options.indentWith );
					break;
				case 'boolean':
				case 'number':
					json += data[key].toString();
					break;
				case 'null':
					json += 'null';
					break;
				case 'string':
					json += '"' + data[key].replace(/[\n]/g, '\\n').replace(/[\t]/g, '\\t') + '"';
					break;
				// Skip other types
			}
			comma = true;
		}
	}
	
	// Close object/array
	json += this.options.joinWith + indention + ( type === 'array' ? ']' : '}' );
	
	return json;
};
