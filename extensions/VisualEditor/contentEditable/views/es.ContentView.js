es.ContentView = function( $container, model ) {
	// Inheritance
	es.EventEmitter.call( this );

	// Properties
	this.$ = $container;
	this.model = model;
	
	if ( model ) {
		// Events
		var _this = this;
		this.model.on( 'update', function( offset ) {
			_this.render( offset || 0 );
		} );
	}
}


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
es.ContentView.annotationRenderers = {
	'object/template': {
		'open': function( data ) {
			return '<span class="es-contentView-format-object" contentEditable="false">' + data.html;
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
		//'open': '<span class="es-contentView-format-textStyle-bold">',
		//'close': '</span>'
		'open': '<b>',
		'close': '</b>'
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
es.ContentView.htmlCharacters = {
	'&': '&amp;',
	'<': '&lt;',
	'>': '&gt;',
	'\'': '&#039;',
	'"': '&quot;',
	'\n': '<span class="es-contentView-whitespace">&#182;</span>',
	'\t': '<span class="es-contentView-whitespace">&#8702;</span>',
	//' ': '&nbsp;'
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
es.ContentView.renderAnnotation = function( bias, annotation, stack ) {
	var renderers = es.ContentView.annotationRenderers,
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
				var depth = es.inArray( annotation, stack ),
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

es.ContentView.prototype.render = function( offset ) {
	this.$.html(this.getHtml(0, this.model.getContentLength()));
};

/**
 * Gets an HTML rendering of a range of data within content model.
 * 
 * @method
 * @param {es.Range} range Range of content to render
 * @param {String} Rendered HTML of data within content model
 */
es.ContentView.prototype.getHtml = function( range, options ) {
	if ( range ) {
		range.normalize();
	} else {
		range = { 'start': 0, 'end': undefined };
	}
	var data = this.model.getContentData(),
		render = es.ContentView.renderAnnotation,
		htmlChars = es.ContentView.htmlCharacters;
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
				if ( es.inArray( left[j], right ) === -1 ) {
					out += render( 'close', left[j], stack );
				}
			}
			for ( j = 1; j < right.length; j++ ) {
				if ( es.inArray( right[j], left ) === -1 ) {
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

es.extendClass( es.ContentView, es.EventEmitter );
