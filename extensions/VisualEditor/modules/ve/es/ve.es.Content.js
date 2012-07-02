/**
 * Creates an ve.es.Content object.
 * 
 * A content view flows text into a DOM element and provides methods to get information about the
 * rendered output. HTML serialized specifically for rendering into and editing surface.
 * 
 * Rendering occurs automatically when content is modified, by responding to "update" events from
 * the model. Rendering is iterative and interruptable to reduce user feedback latency.
 * 
 * TODO: Cleanup code and comments
 * 
 * @class
 * @constructor
 * @param {jQuery} $container Element to render into
 * @param {ve.ModelNode} model Model to produce view for
 * @property {jQuery} $
 * @property {ve.ContentModel} model
 * @property {Array} boundaries
 * @property {Array} lines
 * @property {Integer} width
 * @property {RegExp} bondaryTest
 * @property {Object} widthCache
 * @property {Object} renderState
 * @property {Object} contentCache
 */
ve.es.Content = function( $container, model ) {
	// Inheritance
	ve.EventEmitter.call( this );

	// Properties
	this.$ = $container;
	this.model = model;
	this.boundaries = [];
	this.lines = [];
	this.width = null;
	this.boundaryTest = /([ \-\t\r\n\f])/g;
	this.widthCache = {};
	this.renderState = {};
	this.contentCache = null;

	if ( model ) {
		// Events
		var _this = this;
		this.model.on( 'update', function( offset ) {
			_this.scanBoundaries();
			_this.render( offset || 0 );
		} );

		// DOM Changes
		this.$ranges = $( '<div class="es-contentView-ranges"></div>' );
		this.$rangeStart = $( '<div class="es-contentView-range"></div>' );
		this.$rangeFill = $( '<div class="es-contentView-range"></div>' );
		this.$rangeEnd = $( '<div class="es-contentView-range"></div>' );
		this.$.prepend( this.$ranges.append( this.$rangeStart, this.$rangeFill, this.$rangeEnd ) );

		// Initialization
		this.scanBoundaries();
	}
};

/* Static Members */

/**
 * List of annotation rendering implementations.
 * 
 * Each supported annotation renderer must have an open and close property, each either a string or
 * a function which accepts a data argument.
 * 
 * @static
 * @member
 */
ve.es.Content.annotationRenderers = {
	'object/template': {
		'open': function( data ) {
			return '<span class="es-contentView-format-object">' + data.html;
		},
		'close': '</span>'
	},
	'object/hook': {
		'open': function( data ) {
			return '<span class="es-contentView-format-object">' + data.html;
		},
		'close': '</span>'
	},
	'textStyle/bold': {
		'open': '<span class="es-contentView-format-textStyle-bold">',
		'close': '</span>'
	},
	'textStyle/italic': {
		'open': '<span class="es-contentView-format-textStyle-italic">',
		'close': '</span>'
	},
	'textStyle/strong': {
		'open': '<span class="es-contentView-format-textStyle-strong">',
		'close': '</span>'
	},
	'textStyle/emphasize': {
		'open': '<span class="es-contentView-format-textStyle-emphasize">',
		'close': '</span>'
	},
	'textStyle/big': {
		'open': '<span class="es-contentView-format-textStyle-big">',
		'close': '</span>'
	},
	'textStyle/small': {
		'open': '<span class="es-contentView-format-textStyle-small">',
		'close': '</span>'
	},
	'textStyle/superScript': {
		'open': '<span class="es-contentView-format-textStyle-superScript">',
		'close': '</span>'
	},
	'textStyle/subScript': {
		'open': '<span class="es-contentView-format-textStyle-subScript">',
		'close': '</span>'
	},
	'link/external': {
		'open': function( data ) {
			return '<span class="es-contentView-format-link" data-href="' + data.href + '">';
		},
		'close': '</span>'
	},
	'link/internal': {
		'open': function( data ) {
			return '<span class="es-contentView-format-link" data-title="wiki/' + data.title + '">';
		},
		'close': '</span>'
	}
};

/**
 * Mapping of character and HTML entities or renderings.
 * 
 * @static
 * @member
 */
ve.es.Content.htmlCharacters = {
	'&': '&amp;',
	'<': '&lt;',
	'>': '&gt;',
	'\'': '&#039;',
	'"': '&quot;',
	'\n': '<span class="es-contentView-whitespace">&#182;</span>',
	'\t': '<span class="es-contentView-whitespace">&#8702;</span>',
	' ': '&nbsp;'
};

/* Static Methods */

/**
 * Gets a rendered opening or closing of an annotation.
 * 
 * Tag nesting is handled using a stack, which keeps track of what is currently open. A common stack
 * argument should be used while rendering content.
 * 
 * @static
 * @method
 * @param {String} bias Which side of the annotation to render, either "open" or "close"
 * @param {Object} annotation Annotation to render
 * @param {Array} stack List of currently open annotations
 * @returns {String} Rendered annotation
 */
ve.es.Content.renderAnnotation = function( bias, annotation, stack ) {
	var renderers = ve.es.Content.annotationRenderers,
		type = annotation.type,
		out = '';
	if ( type in renderers ) {
		if ( bias === 'open' ) {
			// Add annotation to the top of the stack
			stack.push( annotation );
			// Open annotation
			out += typeof renderers[type].open === 'function' ?
				renderers[type].open( annotation.data ) : renderers[type].open;
		} else {
			if ( stack[stack.length - 1] === annotation ) {
				// Remove annotation from top of the stack
				stack.pop();
				// Close annotation
				out += typeof renderers[type].close === 'function' ?
					renderers[type].close( annotation.data ) : renderers[type].close;
			} else {
				// Find the annotation in the stack
				var depth = ve.inArray( annotation, stack ),
					i;
				if ( depth === -1 ) {
					throw 'Invalid stack error. An element is missing from the stack.';
				}
				// Close each already opened annotation
				for ( i = stack.length - 1; i >= depth + 1; i-- ) {
					out += typeof renderers[stack[i].type].close === 'function' ?
						renderers[stack[i].type].close( stack[i].data ) :
							renderers[stack[i].type].close;
				}
				// Close the buried annotation
				out += typeof renderers[type].close === 'function' ?
					renderers[type].close( annotation.data ) : renderers[type].close;
				// Re-open each previously opened annotation
				for ( i = depth + 1; i < stack.length; i++ ) {
					out += typeof renderers[stack[i].type].open === 'function' ?
						renderers[stack[i].type].open( stack[i].data ) :
							renderers[stack[i].type].open;
				}
				// Remove the annotation from the middle of the stack
				stack.splice( depth, 1 );
			}
		}
	}
	return out;
};

/* Methods */

/**
 * Draws selection around a given range of content.
 * 
 * @method
 * @param {ve.Range} range Range to draw selection around
 */
ve.es.Content.prototype.drawSelection = function( range ) {
	if ( typeof range === 'undefined' ) {
		range = new ve.Range( 0, this.model.getContentLength() );
	} else {
		range.normalize();
	}
	var fromLineIndex = this.getRenderedLineIndexFromOffset( range.start ),
		toLineIndex = this.getRenderedLineIndexFromOffset( range.end ),
		fromPosition = this.getRenderedPositionFromOffset( range.start ),
		toPosition = this.getRenderedPositionFromOffset( range.end );

	if ( fromLineIndex === toLineIndex ) {
		// Single line selection
		if ( toPosition.left - fromPosition.left ) {
			this.$rangeStart.css( {
				'top': fromPosition.top,
				'left': fromPosition.left,
				'width': toPosition.left - fromPosition.left,
				'height': fromPosition.bottom - fromPosition.top
			} ).show();
		}
		this.$rangeFill.hide();
		this.$rangeEnd.hide();
	} else {
		// Multiple line selection
		var contentWidth = this.$.width();
		if ( contentWidth - fromPosition.left ) {
			this.$rangeStart.css( {
				'top': fromPosition.top,
				'left': fromPosition.left,
				'width': contentWidth - fromPosition.left,
				'height': fromPosition.bottom - fromPosition.top
			} ).show();
		} else {
			this.$rangeStart.hide();
		}
		if ( toPosition.left ) {
			this.$rangeEnd.css( {
				'top': toPosition.top,
				'left': 0,
				'width': toPosition.left,
				'height': toPosition.bottom - toPosition.top
			} ).show();
		} else {
			this.$rangeEnd.hide();
		}
		if ( fromLineIndex + 1 < toLineIndex ) {
			this.$rangeFill.css( {
				'top': fromPosition.bottom,
				'left': 0,
				'width': contentWidth,
				'height': toPosition.top - fromPosition.bottom
			} ).show();
		} else {
			this.$rangeFill.hide();
		}
	}
};

/**
 * Clears selection if any was drawn.
 * 
 * @method
 */
ve.es.Content.prototype.clearSelection = function() {
	this.$rangeStart.hide();
	this.$rangeFill.hide();
	this.$rangeEnd.hide();
};

/**
 * Gets the index of the rendered line a given offset is within.
 * 
 * Offsets that are out of range will always return the index of the last line.
 * 
 * @method
 * @param {Integer} offset Offset to get line for
 * @returns {Integer} Index of rendered lin offset is within
 */
ve.es.Content.prototype.getRenderedLineIndexFromOffset = function( offset ) {
	for ( var i = 0; i < this.lines.length; i++ ) {
		if ( this.lines[i].range.containsOffset( offset ) ) {
			return i;
		}
	}
	return this.lines.length - 1;
};

/*
 * Gets the index of the rendered line closest to a given position.
 * 
 * If the position is above the first line, the offset will always be 0, and if the position is
 * below the last line the offset will always be the content length. All other vertical
 * positions will fall inside of one of the lines.
 * 
 * @method
 * @returns {Integer} Index of rendered line closest to position
 */
ve.es.Content.prototype.getRenderedLineIndexFromPosition = function( position ) {
	var lineCount = this.lines.length;
	// Positions above the first line always jump to the first offset
	if ( !lineCount || position.top < 0 ) {
		return 0;
	}
	// Find which line the position is inside of
	var i = 0,
		top = 0;
	while ( i < lineCount ) {
		top += this.lines[i].height;
		if ( position.top < top ) {
			break;
		}
		i++;
	}
	// Positions below the last line always jump to the last offset
	if ( i === lineCount ) {
		return i - 1;
	}
	return i;
};

/**
 * Gets the range of the rendered line a given offset is within.
 * 
 * Offsets that are out of range will always return the range of the last line.
 * 
 * @method
 * @param {Integer} offset Offset to get line for
 * @returns {ve.Range} Range of line offset is within
 */
ve.es.Content.prototype.getRenderedLineRangeFromOffset = function( offset ) {
	for ( var i = 0; i < this.lines.length; i++ ) {
		if ( this.lines[i].range.containsOffset( offset ) ) {
			return this.lines[i].range;
		}
	}
	return this.lines[this.lines.length - 1].range;
};

/**
 * Gets offset within content model closest to of a given position.
 * 
 * Position is assumed to be local to the container the text is being flowed in.
 * 
 * @method
 * @param {Object} position Position to find offset for
 * @param {Integer} position.left Horizontal position in pixels
 * @param {Integer} position.top Vertical position in pixels
 * @returns {Integer} Offset within content model nearest the given coordinates
 */
ve.es.Content.prototype.getOffsetFromRenderedPosition = function( position ) {
	// Empty content model shortcut
	if ( this.model.getContentLength() === 0 ) {
		return 0;
	}

	// Localize position
	position.subtract( ve.Position.newFromElementPagePosition( this.$ ) );

	// Get the line object nearest the position
	var line = this.lines[this.getRenderedLineIndexFromPosition( position )];

	/*
	 * Offset finding
	 * 
	 * Now that we know which line we are on, we can just use the "fitCharacters" method to get the
	 * last offset before "position.left".
	 * 
	 * TODO: The offset needs to be chosen based on nearest offset to the cursor, not offset before
	 * the cursor.
	 */
	var $ruler = $( '<div class="es-contentView-ruler"></div>' ).appendTo( this.$ ),
		ruler = $ruler[0],
		fit = this.fitCharacters( line.range, ruler, position.left ),
		center;
	ruler.innerHTML = this.getHtml( new ve.Range( line.range.start, fit.end ) );
	if ( fit.end < this.model.getContentLength() ) {
		var left = ruler.clientWidth;
		ruler.innerHTML = this.getHtml( new ve.Range( line.range.start, fit.end + 1 ) );
		center = Math.round( left + ( ( ruler.clientWidth - left ) / 2 ) );
	} else {
		center = ruler.clientWidth;
	}
	$ruler.remove();
	// Reset RegExp object's state
	this.boundaryTest.lastIndex = 0;
	return Math.min(
		// If the position is right of the center of the character it's on top of, increment offset
		fit.end + ( position.left >= center ? 1 : 0 ),
		// Don't allow the value to be higher than the end
		line.range.end
	);
};

/**
 * Gets position coordinates of a given offset.
 * 
 * Offsets are boundaries between plain or annotated characters within content model. Results are
 * given in left, top and bottom positions, which could be used to draw a cursor, highlighting, etc.
 * 
 * @method
 * @param {Integer} offset Offset within content model
 * @returns {Object} Object containing left, top and bottom properties, each positions in pixels as
 * well as a line index
 */
ve.es.Content.prototype.getRenderedPositionFromOffset = function( offset, leftBias ) {
	/* 
	 * Range validation
	 * 
	 * Rather than clamping the range, which can hide errors, exceptions will be thrown if offset is
	 * less than 0 or greater than the length of the content model.
	 */
	if ( offset < 0 ) {
		throw 'Out of range error. Offset is expected to be greater than or equal to 0.';
	} else if ( offset > this.model.getContentLength() ) {
		throw 'Out of range error. Offset is expected to be less than or equal to text length.';
	}
	/*
	 * Line finding
	 * 
	 * It's possible that a more efficient method could be used here, but the number of lines to be
	 * iterated through will rarely be over 100, so it's unlikely that any significant gains will be
	 * had. Plus, as long as we are iterating over each line, we can also sum up the top and bottom
	 * positions, which is a nice benefit of this method.
	 */
	var line,
		lineCount = this.lines.length,
		lineIndex = 0,
		position = new ve.Position();
	while ( lineIndex < lineCount ) {
		line = this.lines[lineIndex];
		if ( line.range.containsOffset( offset ) || ( leftBias && line.range.end === offset ) ) {
			position.bottom = position.top + line.height;
			break;
		}
		position.top += line.height;
		lineIndex++;
	}
	/*
	 * Virtual n+1 position
	 * 
	 * To allow access to position information of the right side of the last character on the last
	 * line, a virtual n+1 position is supported. Offsets beyond this virtual position will cause
	 * an exception to be thrown.
	 */
	if ( lineIndex === lineCount ) {
		position.bottom = position.top;
		position.top -= line.height;
	}
	/*
	 * Offset measuring
	 * 
	 * Since the left position will be zero for the first character in the line, so we can skip
	 * measuring for those cases.
	 */
	if ( line.range.start < offset ) {
		var $ruler = $( '<div class="es-contentView-ruler"></div>' ).appendTo( this.$ ),
			ruler = $ruler[0];
		ruler.innerHTML = this.getHtml( new ve.Range( line.range.start, offset ) );
		position.left = ruler.clientWidth;
		$ruler.remove();
	}
	return position;
};

/**
 * Updates the word boundary cache, which is used for word fitting.
 * 
 * @method
 */
ve.es.Content.prototype.scanBoundaries = function() {
	/*
	 * Word boundary scan
	 * 
	 * To perform binary-search on words, rather than characters, we need to collect word boundary
	 * offsets into an array. The offset of the right side of the breaking character is stored, so
	 * the gaps between stored offsets always include the breaking character at the end.
	 * 
	 * To avoid encoding the same words as HTML over and over while fitting text to lines, we also
	 * build a list of HTML escaped strings for each gap between the offsets stored in the
	 * "boundaries" array. Slices of the "words" array can be joined, producing the escaped HTML of
	 * the words.
	 */
	// Get and cache a copy of all content, the make a plain-text version of the cached content
	var data = this.contentCache = this.model.getContentData(),
		text = '';
	for ( var i = 0, length = data.length; i < length; i++ ) {
		text += typeof data[i] === 'string' ? data[i] : data[i][0];
	}
	// Purge "boundaries" and "words" arrays
	this.boundaries = [0];
	// Reset RegExp object's state
	this.boundaryTest.lastIndex = 0;
	// Iterate over each word+boundary sequence, capturing offsets and encoding text as we go
	var match,
		end;
	while ( ( match = this.boundaryTest.exec( text ) ) ) {
		// Include the boundary character in the range
		end = match.index + 1;
		// Store the boundary offset
		this.boundaries.push( end );
	}
	// If the last character is not a boundary character, we need to append the final range to the
	// "boundaries" and "words" arrays
	if ( end < text.length || this.boundaries.length === 1 ) {
		this.boundaries.push( text.length );
	}
};

/**
 * Renders a batch of lines and then yields execution before rendering another batch.
 * 
 * In cases where a single word is too long to fit on a line, the word will be "virtually" wrapped,
 * causing them to be fragmented. Word fragments are rendered on their own lines, except for their
 * remainder, which is combined with whatever proceeding words can fit on the same line.
 * 
 * @method
 * @param {Integer} limit Maximum number of iterations to render before yeilding
 */
ve.es.Content.prototype.renderIteration = function( limit ) {
	var rs = this.renderState,
		iteration = 0,
		fractional = false,
		lineStart = this.boundaries[rs.wordOffset],
		lineEnd,
		wordFit = null,
		charOffset = 0,
		charFit = null,
		wordCount = this.boundaries.length;
	while ( ++iteration <= limit && rs.wordOffset < wordCount - 1 ) {
		wordFit = this.fitWords( new ve.Range( rs.wordOffset, wordCount - 1 ), rs.ruler, rs.width );
		fractional = false;
		if ( wordFit.width > rs.width ) {
			// The first word didn't fit, we need to split it up
			charOffset = lineStart;
			var lineOffset = rs.wordOffset;
			rs.wordOffset++;
			lineEnd = this.boundaries[rs.wordOffset];
			do {
				charFit = this.fitCharacters(
					new ve.Range( charOffset, lineEnd ), rs.ruler, rs.width
				);
				// If we were able to get the rest of the characters on the line OK
				if ( charFit.end === lineEnd) {
					// Try to fit more words on the line
					wordFit = this.fitWords(
						new ve.Range( rs.wordOffset, wordCount - 1 ),
						rs.ruler,
						rs.width - charFit.width
					);
					if ( wordFit.end > rs.wordOffset ) {
						lineOffset = rs.wordOffset;
						rs.wordOffset = wordFit.end;
						charFit.end = lineEnd = this.boundaries[rs.wordOffset];
					}
				}
				this.appendLine( new ve.Range( charOffset, charFit.end ), lineOffset, fractional );
				// Move on to another line
				charOffset = charFit.end;
				// Mark the next line as fractional
				fractional = true;
			} while ( charOffset < lineEnd );
		} else {
			lineEnd = this.boundaries[wordFit.end];
			this.appendLine( new ve.Range( lineStart, lineEnd ), rs.wordOffset, fractional );
			rs.wordOffset = wordFit.end;
		}
		lineStart = lineEnd;
	}
	// Only perform on actual last iteration
	if ( rs.wordOffset >= wordCount - 1 ) {
		// Cleanup
		rs.$ruler.remove();
		if ( rs.line < this.lines.length ) {
			this.lines.splice( rs.line, this.lines.length - rs.line );
		}
		this.$.find( '.es-contentView-line[line-index=' + ( this.lines.length - 1 ) + ']' )
			.nextAll()
			.remove();
		rs.timeout = undefined;
		this.emit( 'update' );
	} else {
		rs.ruler.innerHTML = '';
		var that = this;
		rs.timeout = setTimeout( function() {
			that.renderIteration( 3 );
		}, 0 );
	}
};

/**
 * Renders text into a series of HTML elements, each a single line of wrapped text.
 * 
 * The offset parameter can be used to reduce the amount of work involved in re-rendering the same
 * text, but will be automatically ignored if the text or width of the container has changed.
 * 
 * Rendering happens asynchronously, and yields execution between iterations. Iterative rendering
 * provides the JavaScript engine an ability to process events between rendering batches of lines,
 * allowing rendering to be interrupted and restarted if changes to content model are happening before
 * rendering of all lines is complete.
 * 
 * @method
 * @param {Integer} [offset] Offset to re-render from, if possible
 */
ve.es.Content.prototype.render = function( offset ) {
	var rs = this.renderState;
	// Check if rendering is currently underway
	if ( rs.timeout !== undefined ) {
		// Cancel the active rendering process
		clearTimeout( rs.timeout );
		// Cleanup
		rs.$ruler.remove();
	}
	// Clear caches that were specific to the previous render
	this.widthCache = {};
	// In case of empty content model we still want to display empty with non-breaking space inside
	// This is very important for lists
	if(this.model.getContentLength() === 0) {
		var $line = $( '<div class="es-contentView-line" line-index="0">&nbsp;</div>' );
		this.$
			.children()
				.remove( '.es-contentView-line' )
				.end()
			.append( $line );
		this.lines = [{
			'text': ' ',
			'range': new ve.Range( 0,0 ),
			'width': 0,
			'height': $line.outerHeight(),
			'wordOffset': 0,
			'fractional': false
		}];
		this.emit( 'update' );
		return;
	}
	/*
	 * Container measurement
	 * 
	 * To get an accurate measurement of the inside of the container, without having to deal with
	 * inconsistencies between browsers and box models, we can just create an element inside the
	 * container and measure it.
	 */
	rs.$ruler = $( '<div>&nbsp;</div>' ).appendTo( this.$ );
	rs.width = rs.$ruler.innerWidth();
	rs.ruler = rs.$ruler.addClass('es-contentView-ruler')[0];
	// Ignore offset optimization if the width has changed or the text has never been flowed before
	if (this.width !== rs.width) {
		offset = undefined;
	}
	this.width = rs.width;
	// Reset the render state
	if ( offset ) {
		var gap,
			currentLine = this.lines.length - 1;
		for ( var i = this.lines.length - 1; i >= 0; i-- ) {
			var line = this.lines[i];
			if ( line.range.start < offset && line.range.end > offset ) {
				currentLine = i;
			}
			if ( ( line.range.end < offset && !line.fractional ) || i === 0 ) {
				rs.line = i;
				rs.wordOffset = line.wordOffset;
				gap = currentLine - i;
				break;
			}
		}
		this.renderIteration( 2 + gap );
	} else {
		rs.line = 0;
		rs.wordOffset = 0;
		this.renderIteration( 3 );
	}
};

/**
 * Adds a line containing a given range of text to the end of the DOM and the "lines" array.
 * 
 * @method
 * @param {ve.Range} range Range of data within content model to append
 * @param {Integer} start Beginning of text range for line
 * @param {Integer} end Ending of text range for line
 * @param {Integer} wordOffset Index within this.words which the line begins with
 * @param {Boolean} fractional If the line begins in the middle of a word
 */
ve.es.Content.prototype.appendLine = function( range, wordOffset, fractional ) {
	var rs = this.renderState,
		$line = this.$.children( '[line-index=' + rs.line + ']' );
	if ( !$line.length ) {
		$line = $(
			'<div class="es-contentView-line" line-index="' + rs.line + '"></div>'
		);
		this.$.append( $line );
	}
	$line[0].innerHTML = this.getHtml( range );
	// Overwrite/append line information
	this.lines[rs.line] = {
		'text': this.model.getContentText( range ),
		'range': range,
		'width': $line.outerWidth(),
		'height': $line.outerHeight(),
		'wordOffset': wordOffset,
		'fractional': fractional
	};
	// Disable links within rendered content
	$line.find( '.es-contentView-format-object a' )
		.mousedown( function( e ) {
			e.preventDefault();
		} )
		.click( function( e ) {
			e.preventDefault();
		} );
	rs.line++;
};

/**
 * Gets the index of the boundary of last word that fits inside the line
 * 
 * The "words" and "boundaries" arrays provide linear access to the offsets around non-breakable
 * areas within the text. Using these, we can perform a binary-search for the best fit of words
 * within a line, just as we would with characters.
 * 
 * Results are given as an object containing both an index and a width, the later of which can be
 * used to detect when the first word was too long to fit on a line. In such cases the result will
 * contain the index of the boundary of the first word and it's width.
 * 
 * TODO: Because limit is most likely given as "words.length", it may be possible to improve the
 * efficiency of this code by making a best guess and working from there, rather than always
 * starting with [offset .. limit], which usually results in reducing the end position in all but
 * the last line, and in most cases more than 3 times, before changing directions.
 * 
 * @method
 * @param {ve.Range} range Range of data within content model to try to fit
 * @param {HTMLElement} ruler Element to take measurements with
 * @param {Integer} width Maximum width to allow the line to extend to
 * @returns {Integer} Last index within "words" that contains a word that fits
 */
ve.es.Content.prototype.fitWords = function( range, ruler, width ) {
	var offset = range.start,
		start = range.start,
		end = range.end,
		charOffset = this.boundaries[offset],
		middle,
		charMiddle,
		lineWidth,
		cacheKey;
	do {
		// Place "middle" directly in the center of "start" and "end"
		middle = Math.ceil( ( start + end ) / 2 );
		charMiddle = this.boundaries[middle];
		// Measure and cache width of substring
		cacheKey = charOffset + ':' + charMiddle;
		// Prepare the line for measurement using pre-escaped HTML
		ruler.innerHTML = this.getHtml( new ve.Range( charOffset, charMiddle ) );
		// Test for over/under using width of the rendered line
		this.widthCache[cacheKey] = lineWidth = ruler.clientWidth;
		// Test for over/under using width of the rendered line
		if ( lineWidth > width ) {
			// Detect impossible fit (the first word won't fit by itself)
			if (middle - offset === 1) {
				start = middle;
				break;
			}
			// Words after "middle" won't fit
			end = middle - 1;
		} else {
			// Words before "middle" will fit
			start = middle;
		}
	} while ( start < end );
	// Check if we ended by moving end to the left of middle
	if ( end === middle - 1 ) {
		// A final measurement is required
		var charStart = this.boundaries[start];
		ruler.innerHTML = this.getHtml( new ve.Range( charOffset, charStart ) );
		lineWidth = this.widthCache[charOffset + ':' + charStart] = ruler.clientWidth;
	}
	return { 'end': start, 'width': lineWidth };
};

/**
 * Gets the index of the boundary of the last character that fits inside the line
 * 
 * Results are given as an object containing both an index and a width, the later of which can be
 * used to detect when the first character was too long to fit on a line. In such cases the result
 * will contain the index of the first character and it's width.
 * 
 * @method
 * @param {ve.Range} range Range of data within content model to try to fit
 * @param {HTMLElement} ruler Element to take measurements with
 * @param {Integer} width Maximum width to allow the line to extend to
 * @returns {Integer} Last index within "text" that contains a character that fits
 */
ve.es.Content.prototype.fitCharacters = function( range, ruler, width ) {
	var offset = range.start,
		start = range.start,
		end = range.end,
		middle,
		lineWidth,
		cacheKey;
	do {
		// Place "middle" directly in the center of "start" and "end"
		middle = Math.ceil( ( start + end ) / 2 );
		// Measure and cache width of substring
		cacheKey = offset + ':' + middle;
		if ( cacheKey in this.widthCache ) {
			lineWidth = this.widthCache[cacheKey];
		} else {
			// Fill the line with a portion of the text, escaped as HTML
			ruler.innerHTML = this.getHtml( new ve.Range( offset, middle ) );
			// Test for over/under using width of the rendered line
			this.widthCache[cacheKey] = lineWidth = ruler.clientWidth;
		}
		if ( lineWidth > width ) {
			// Detect impossible fit (the first character won't fit by itself)
			if (middle - offset === 1) {
				start = middle - 1;
				break;
			}
			// Words after "middle" won't fit
			end = middle - 1;
		} else {
			// Words before "middle" will fit
			start = middle;
		}
	} while ( start < end );
	// Check if we ended by moving end to the left of middle
	if ( end === middle - 1 ) {
		// Try for cache hit
		cacheKey = offset + ':' + start;
		if ( cacheKey in this.widthCache ) {
			lineWidth = this.widthCache[cacheKey];
		} else {
			// A final measurement is required
			ruler.innerHTML = this.getHtml( new ve.Range( offset, start ) );
			lineWidth = this.widthCache[cacheKey] = ruler.clientWidth;
		}
	}
	return { 'end': start, 'width': lineWidth };
};

/**
 * Gets an HTML rendering of a range of data within content model.
 * 
 * @method
 * @param {ve.Range} range Range of content to render
 * @param {String} Rendered HTML of data within content model
 */
ve.es.Content.prototype.getHtml = function( range, options ) {
	if ( range ) {
		range.normalize();
	} else {
		range = { 'start': 0, 'end': undefined };
	}
	var data = this.contentCache.slice( range.start, range.end ),
		render = ve.es.Content.renderAnnotation,
		htmlChars = ve.es.Content.htmlCharacters;
	var out = '',
		left = '',
		right,
		leftPlain,
		rightPlain,
		stack = [],
		chr,
		i,
		j;
	for ( i = 0; i < data.length; i++ ) {
		right = data[i];
		leftPlain = typeof left === 'string';
		rightPlain = typeof right === 'string';
		if ( !leftPlain && rightPlain ) {
			// [formatted][plain] pair, close any annotations for left
			for ( j = 1; j < left.length; j++ ) {
				out += render( 'close', left[j], stack );
			}
		} else if ( leftPlain && !rightPlain ) {
			// [plain][formatted] pair, open any annotations for right
			for ( j = 1; j < right.length; j++ ) {
				out += render( 'open', right[j], stack );
			}
		} else if ( !leftPlain && !rightPlain ) {
			// [formatted][formatted] pair, open/close any differences
			for ( j = 1; j < left.length; j++ ) {
				if ( ve.inArray( left[j], right ) === -1 ) {
					out += render( 'close', left[j], stack );
				}
			}
			for ( j = 1; j < right.length; j++ ) {
				if ( ve.inArray( right[j], left ) === -1 ) {
					out += render( 'open', right[j], stack );
				}
			}
		}
		chr = rightPlain ? right : right[0];
		out += chr in htmlChars ? htmlChars[chr] : chr;
		left = right;
	}
	// Close all remaining tags at the end of the content
	if ( !rightPlain && right ) {
		for ( j = 1; j < right.length; j++ ) {
			out += render( 'close', right[j], stack );
		}
	}
	return out;
};

/* Inheritance */

ve.extendClass( ve.es.Content, ve.EventEmitter );
