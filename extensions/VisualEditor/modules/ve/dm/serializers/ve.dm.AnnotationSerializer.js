/**
 * Creates an annotation renderer object.
 * 
 * @class
 * @constructor
 * @property annotations {Object} List of annotations to be applied
 */
ve.dm.AnnotationSerializer = function() {
	this.annotations = {};
};

/* Static Methods */

/**
 * Adds a set of annotations to be inserted around a range of text.
 * 
 * Insertions for the same range will be nested in order of declaration.
 * @example
 *     stack = new ve.dm.AnnotationSerializer();
 *     stack.add( new ve.Range( 1, 2 ), '[', ']' );
 *     stack.add( new ve.Range( 1, 2 ), '{', '}' );
 *     // Outputs: "a[{b}]c"
 *     console.log( stack.render( 'abc' ) );
 * 
 * @method
 * @param {ve.Range} range Range to insert text around
 * @param {String} pre Text to insert before range
 * @param {String} post Text to insert after range
 */
ve.dm.AnnotationSerializer.prototype.add = function( range, pre, post ) {
	// Normalize the range if it can be normalized
	if ( typeof range.normalize === 'function' ) {
		range.normalize();
	}
	if ( !( range.start in this.annotations ) ) {
		this.annotations[range.start] = [pre];
	} else {
		this.annotations[range.start].push( pre );
	}
	if ( !( range.end in this.annotations ) ) {
		this.annotations[range.end] = [post];
	} else {
		this.annotations[range.end].unshift( post );
	}
};

/**
 * Adds a set of HTML tags to be inserted around a range of text.
 * 
 * @method
 * @param {ve.Range} range Range to insert text around
 * @param {String} type Tag name
 * @param {Object} [attributes] List of HTML attributes
 */
ve.dm.AnnotationSerializer.prototype.addTags = function( range, type, attributes ) {
	this.add( range, ve.Html.makeOpeningTag( type, attributes ), ve.Html.makeClosingTag( type ) );
};

/**
 * Renders annotations into text.
 * 
 * @method
 * @param {String} text Text to apply annotations to
 * @returns {String} Wrapped text
 */
ve.dm.AnnotationSerializer.prototype.render = function( text ) {
	var out = '';
	for ( var i = 0, length = text.length; i <= length; i++ ) {
		if ( i in this.annotations ) {
			out += this.annotations[i].join( '' );
		}
		if ( i < length ) {
			out += text[i];
		}
	}
	return out;
};
