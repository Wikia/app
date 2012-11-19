/**
 * VisualEditor content editable TextNode class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable node for text.
 *
 * @class
 * @constructor
 * @extends {ve.ce.LeafNode}
 * @param {ve.dm.TextNode} model Model to observe
 */
ve.ce.TextNode = function VeCeTextNode( model ) {
	// Parent constructor
	ve.ce.LeafNode.call( this, 'text', model, $( document.createTextNode( '' ) ) );

	// Events
	this.model.addListenerMethod( this, 'update', 'onUpdate' );

	// Initialization
	this.onUpdate( true );
};

/* Inheritance */

ve.inheritClass( ve.ce.TextNode, ve.ce.LeafNode );

/* Static Members */

/**
 * Node rules.
 *
 * @see ve.ce.NodeFactory
 * @static
 * @member
 */
ve.ce.TextNode.rules = {
	'canBeSplit': true
};

/**
 * Mapping of character and HTML entities or renderings.
 *
 * @static
 * @member
 */
ve.ce.TextNode.htmlCharacters = {
	'&': '&amp;',
	'<': '&lt;',
	'>': '&gt;',
	'\'': '&#039;',
	'"': '&quot;'
};

ve.ce.TextNode.whitespaceHtmlCharacters = {
	'\n': '&crarr;',
	'\t': '&#10142;'
};

/* Methods */

/**
 * Responds to model update events.
 *
 * If the source changed since last update the image's src attribute will be updated accordingly.
 *
 * @method
 */
ve.ce.TextNode.prototype.onUpdate = function ( force ) {
	if ( !force && !this.root.getSurface ) {
		throw new Error( 'Can not update a text node that is not attached to a document' );
	}
	if ( force === true || !this.root.getSurface().isLocked() ) {
		var $new = $( '<span>' ).html( this.getHtml() ).contents();
		if ( $new.length === 0 ) {
			$new = $new.add( document.createTextNode( '' ) );
		}
		this.$.replaceWith( $new );
		this.$ = $new;
		if ( this.parent ) {
			this.parent.clean();
			if ( ve.debug ) {
				this.parent.$.css( 'backgroundColor', '#F6F6F6' );
				setTimeout( ve.bind( function () {
					this.parent.$.css( 'backgroundColor', 'transparent' );
				}, this ), 350 );
			}
		}
	}
};

/**
 * Gets an HTML rendering of data within content model.
 *
 * @method
 * @param {String} Rendered HTML of data within content model
 */
ve.ce.TextNode.prototype.getHtml = function () {
	var data = this.model.getDocument().getDataFromNode( this.model ),
		htmlChars = ve.ce.TextNode.htmlCharacters,
		whitespaceHtmlChars = ve.ce.TextNode.whitespaceHtmlCharacters,
		significantWhitespace = this.getModel().getParent().hasSignificantWhitespace(),
		out = '',
		i,
		j,
		arr,
		left = '',
		right,
		character,
		nextCharacter,
		open,
		close,
		startedClosing,
		annotation,
		leftPlain,
		rightPlain,
		annotationStack = new ve.AnnotationSet(),
		chr;

	function replaceWithNonBreakingSpace( index, data ) {
		if ( ve.isArray( data[index] ) ) {
			// Don't modify the original array, clone it first
			data[index] = data[index].slice( 0 );
			data[index][0] = '&nbsp;';
		} else {
			data[index] = '&nbsp;';
		}
	}

	if ( !significantWhitespace ) {
		// Replace spaces with &nbsp; where needed
		if ( data.length > 0 ) {
			// Leading space
			character = data[0];
			if ( ve.isArray( character ) ? character[0] === ' ' : character === ' ' ) {
				replaceWithNonBreakingSpace( 0, data );
			}
		}
		if ( data.length > 1 ) {
			// Trailing space
			character = data[data.length - 1];
			if ( ve.isArray( character ) ? character[0] === ' ' : character === ' ' ) {
				replaceWithNonBreakingSpace( data.length - 1, data );
			}
		}
		if ( data.length > 2 ) {
			// Replace any sequence of 2+ spaces with an alternating pattern
			// (space-nbsp-space-nbsp-...)
			for ( i = 1; i < data.length - 1; i++ ) {
				character = data[i];
				nextCharacter = data[i + 1];
				if (
					( ve.isArray( character ) ? character[0] === ' ' : character === ' ' ) &&
					( ve.isArray( nextCharacter ) ? nextCharacter[0] === ' ' : nextCharacter === ' ' )
				) {
					replaceWithNonBreakingSpace( i + 1, data );
					i++;
				}
			}
		}
	}

	function openAnnotations( annotations ) {
		var out = '',
			annotation, i, arr, rendered;
		arr = annotations.get();
		for ( i = 0; i < arr.length; i++ ) {
			annotation = arr[i];
			rendered = annotation.renderHTML();
			out += ve.getOpeningHtmlTag( rendered.tag, rendered.attributes );
			annotationStack.push( annotation );
		}
		return out;
	}

	function closeAnnotations( annotations ) {
		var out = '',
			annotation, i, arr;
		arr = annotations.get();
		for ( i = 0; i < arr.length; i++ ) {
			annotation = arr[i];
			out += '</' + annotation.renderHTML().tag + '>';
			annotationStack.remove( annotation );
		}
		return out;
	}

	for ( i = 0; i < data.length; i++ ) {
		right = data[i];
		leftPlain = typeof left === 'string';
		rightPlain = typeof right === 'string';
		
		if ( !leftPlain && rightPlain ) {
			// [formatted][plain]
			// Close all open annotations, in reverse order
			out += closeAnnotations( annotationStack.reversed() );
		} else if ( leftPlain && !rightPlain ) {
			// [plain][formatted]
			out += openAnnotations( right[1] );
		} else if ( !leftPlain && !rightPlain ) {
			// [formatted][formatted]
			open = new ve.AnnotationSet();
			close = new ve.AnnotationSet();

			// Go through annotationStack from bottom to top (left to right), and
			// close all annotations starting at the first one that's in left[1] but
			// not in right[1]. Then reopen the ones that are in right[1].
			startedClosing = false;
			arr = annotationStack.get();
			for ( j = 0; j < arr.length; j++ ) {
				annotation = arr[j];
				if (
					!startedClosing &&
					left[1].contains( annotation ) &&
					!right[1].contains( annotation )
				) {
					startedClosing = true;
				}
				if ( startedClosing ) {
					// Because we're processing these in reverse order, we need
					// to put these in close in reverse order
					close.add( annotation, 0 );
					if ( right[1].contains( annotation ) ) {
						// open needs to be reversed with respect to close
						open.push( annotation );
					}
				}
			}

			// Open all annotations that are in right but not in left
			open.addSet( right[1].diffWith( left[1] ) );

			out += closeAnnotations( close );
			out += openAnnotations( open );
		}

		chr = rightPlain ? right : right[0];
		if ( !significantWhitespace && chr in whitespaceHtmlChars ) {
			chr = whitespaceHtmlChars[chr];
		}
		out += chr in htmlChars ? htmlChars[chr] : chr;
		left = right;
	}

	// Close all remaining open annotations
	out += closeAnnotations( annotationStack.reversed() );
	return out;
};

/* Registration */

ve.ce.nodeFactory.register( 'text', ve.ce.TextNode );
