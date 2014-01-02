/*!
 * VisualEditor UserInterface Element class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.Element object.
 *
 * @class
 * @abstract
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @cfg {Function} [$$] jQuery for the frame the widget is in
 */
ve.Element = function VeElement( config ) {
	// Initialize config
	config = config || {};
	// Properties
	this.$$ = config.$$ || ve.Element.get$$( document );
	this.$ = this.$$( this.$$.context.createElement( this.getTagName() ) );
};

/* Static Properties */

/**
 * @static
 * @property
 * @inheritable
 */
ve.Element.static = {};

/**
 * HTML tag name.
 *
 * This may be ignored if getTagName is overridden.
 *
 * @static
 * @property {string}
 * @inheritable
 */
ve.Element.static.tagName = 'div';

/* Static Methods */

/**
 * Gets a jQuery function within a specific document.
 *
 * @static
 * @param {jQuery|HTMLElement|HTMLDocument|Window} context Context to bind the function to
 * @param {ve.ui.Frame} [frame] Frame of the document context
 * @returns {Function} Bound jQuery function
 */
ve.Element.get$$ = function ( context, frame ) {
	function wrapper( selector ) {
		return $( selector, wrapper.context );
	}

	wrapper.context = this.getDocument( context );

	if ( frame ) {
		wrapper.frame = frame;
	}

	return wrapper;
};

/**
 * Get the document of an element.
 *
 * @static
 * @param {jQuery|HTMLElement|HTMLDocument|Window} context Context to bind the function to
 * @returns {HTMLDocument} Document object
 * @throws {Error} If context is invalid
 */
ve.Element.getDocument = function ( context ) {
	var doc =
		// jQuery - selections created "offscreen" won't have a context, so .context isn't reliable
		( context[0] && context[0].ownerDocument ) ||
		// Empty jQuery selections might have a context
		context.context ||
		// HTMLElement
		context.ownerDocument ||
		// Window
		context.document ||
		// HTMLDocument
		( context.nodeType === 9 && context );

	if ( doc ) {
		return doc;
	}

	throw new Error( 'Invalid context' );
};

/**
 * Get the window of an element or document.
 *
 * @static
 * @param {jQuery|HTMLElement|HTMLDocument|Window} context Context to bind the function to
 * @returns {Window} Window object
 */
ve.Element.getWindow = function ( context ) {
	var doc = this.getDocument( context );
	return doc.parentWindow || doc.defaultView;
};

/**
 * Get the offset between two frames.
 *
 * TODO: Make this function not use recursion.
 *
 * @static
 * @param {Window} from Window of the child frame
 * @param {Window} [to=window] Window of the parent frame
 * @param {Object} [offset] Offset to start with, used internally
 * @returns {Object} Offset object, containing left and top properties
 */
ve.Element.getFrameOffset = function ( from, to, offset ) {
	var i, len, frames, frame, rect;

	if ( !to ) {
		to = window;
	}
	if ( !offset ) {
		offset = { 'top': 0, 'left': 0 };
	}
	if ( from.parent === from ) {
		return offset;
	}

	// Get iframe element
	frames = from.parent.document.getElementsByTagName( 'iframe' );
	for ( i = 0, len = frames.length; i < len; i++ ) {
		if ( frames[i].contentWindow === from ) {
			frame = frames[i];
			break;
		}
	}

	// Recursively accumulate offset values
	if ( frame ) {
		rect = frame.getBoundingClientRect();
		offset.left += rect.left;
		offset.top += rect.top;
		if ( from !== to ) {
			this.getFrameOffset( from.parent, offset );
		}
	}
	return offset;
};

/**
 * Get the offset between two elements.
 *
 * @static
 * @param {jQuery} $from
 * @param {jQuery} $to
 * @returns {Object} Translated position coordinates, containing top and left properties
 */
ve.Element.getRelativePosition = function ( $from, $to ) {
	var from = $from.offset(),
		to = $to.offset();
	return { 'top': from.top - to.top, 'left': from.left - to.left };
};

/**
 * Get element border sizes.
 *
 * @param {HTMLElement} el Element to measure
 * @return {Object} Dimensions object with `top`, `left`, `bottom` and `right` properties
 */
ve.Element.getBorders = function ( el ) {
	var doc = el.ownerDocument,
		win = doc.parentWindow || doc.defaultView,
		style = win && win.getComputedStyle ?
			win.getComputedStyle( el, null ) :
			el.currentStyle,
		$el = $( el ),
		top = parseFloat( style ? style.borderTopWidth : $el.css( 'borderTopWidth' ) ) || 0,
		left = parseFloat( style ? style.borderLeftWidth : $el.css( 'borderLeftWidth' ) ) || 0,
		bottom = parseFloat( style ? style.borderBottomWidth : $el.css( 'borderBottomWidth' ) ) || 0,
		right = parseFloat( style ? style.borderRightWidth : $el.css( 'borderRightWidth' ) ) || 0;

	return {
		'top': Math.round( top ),
		'left': Math.round( left ),
		'bottom': Math.round( bottom ),
		'right': Math.round( right )
	};
};

/**
 * Get dimensions of an element or window.
 *
 * @param {HTMLElement|Window} el Element to measure
 * @return {Object} Dimensions object with `borders`, `scroll`, `scrollbar` and `rect` properties
 */
ve.Element.getDimensions = function ( el ) {
	var $el, $win,
		doc = el.ownerDocument || el.document,
		win = doc.parentWindow || doc.defaultView;

	if ( win === el || el === doc.documentElement ) {
		$win = $( win );
		return {
			'borders': { 'top': 0, 'left': 0, 'bottom': 0, 'right': 0 },
			'scroll': {
				'top': $win.scrollTop(),
				'left': $win.scrollLeft()
			},
			'scrollbar': { 'right': 0, 'bottom': 0 },
			'rect': {
				'top': 0,
				'left': 0,
				'bottom': $win.innerHeight(),
				'right': $win.innerWidth()
			}
		};
	} else {
		$el = $( el );
		return {
			'borders': this.getBorders( el ),
			'scroll': {
				'top': $el.scrollTop(),
				'left': $el.scrollLeft()
			},
			'scrollbar': {
				'right': $el.innerWidth() - el.clientWidth,
				'bottom': $el.innerHeight() - el.clientHeight
			},
			'rect': el.getBoundingClientRect()
		};
	}
};

/**
 * Get closest scrollable container.
 *
 * Traverses up until either a scrollable element or the root is reached, in which case the window
 * will be returned.
 *
 * @static
 * @param {HTMLElement} el Element to find scrollable container for
 * @param {string} [dimension] Dimension of scrolling to look for; `x`, `y` or omit for either
 * @return {HTMLElement|Window} Closest scrollable container
 */
ve.Element.getClosestScrollableContainer = function ( el, dimension ) {
	var i, val,
		props = [ 'overflow' ],
		$parent = $( el ).parent();

	if ( dimension === 'x' || dimension === 'y' ) {
		props.push( 'overflow-' + dimension );
	}

	while ( $parent.length ) {
		if ( $parent[0] === el.ownerDocument.body ) {
			return $parent[0];
		}
		i = props.length;
		while ( i-- ) {
			val = $parent.css( props[i] );
			if ( val === 'auto' || val === 'scroll' ) {
				return $parent[0];
			}
		}
		$parent = $parent.parent();
	}
	return this.getDocument( el ).body;
};

/**
 * Scroll element into view
 *
 * @static
 * @param {HTMLElement} el Element to scroll into view
 * @param {Object} [config={}] Configuration config
 * @param {string} [config.duration] jQuery animation duration value
 * @param {string} [config.direction] Scroll in only one direction, e.g. 'x' or 'y', omit
 *  to scroll in both directions
 * @param {Function} [config.complete] Function to call when scrolling completes
 */
ve.Element.scrollIntoView = function ( el, config ) {
	// Configuration initialization
	config = config || {};

	var anim = {},
		callback = typeof config.complete === 'function' && config.complete,
		sc = this.getClosestScrollableContainer( el, config.direction ),
		$sc = $( sc ),
		eld = this.getDimensions( el ),
		scd = this.getDimensions( sc ),
		rel = {
			'top': eld.rect.top - ( scd.rect.top + scd.borders.top ),
			'bottom': scd.rect.bottom - scd.borders.bottom - scd.scrollbar.bottom - eld.rect.bottom,
			'left': eld.rect.left - ( scd.rect.left + scd.borders.left ),
			'right': scd.rect.right - scd.borders.right - scd.scrollbar.right - eld.rect.right
		};

	if ( !config.direction || config.direction === 'y' ) {
		if ( rel.top < 0 ) {
			anim.scrollTop = scd.scroll.top + rel.top;
		} else if ( rel.top > 0 && rel.bottom < 0 ) {
			anim.scrollTop = scd.scroll.top + Math.min( rel.top, -rel.bottom );
		}
	}
	if ( !config.direction || config.direction === 'x' ) {
		if ( rel.left < 0 ) {
			anim.scrollLeft = scd.scroll.left + rel.left;
		} else if ( rel.left > 0 && rel.right < 0 ) {
			anim.scrollLeft = scd.scroll.left + Math.min( rel.left, -rel.right );
		}
	}
	if ( !ve.isEmptyObject( anim ) ) {
		$sc.stop( true ).animate( anim, config.duration || 'fast' );
		if ( callback ) {
			$sc.queue( function ( next ) {
				callback();
				next();
			} );
		}
	} else {
		if ( callback ) {
			callback();
		}
	}
};

/* Methods */

/**
 * Get the HTML tag name.
 *
 * Override this method to base the result on instance information.
 *
 * @returns {string} HTML tag name
 */
ve.Element.prototype.getTagName = function () {
	return this.constructor.static.tagName;
};

/**
 * Get the DOM document.
 *
 * @returns {HTMLDocument} Document object
 */
ve.Element.prototype.getElementDocument = function () {
	return ve.Element.getDocument( this.$ );
};

/**
 * Get the DOM window.
 *
 * @returns {Window} Window object
 */
ve.Element.prototype.getElementWindow = function () {
	return ve.Element.getWindow( this.$ );
};

/**
 * Get closest scrollable container.
 *
 * @method
 * @see #static-method-getClosestScrollableContainer
 */
ve.Element.prototype.getClosestScrollableElementContainer = function () {
	return ve.Element.getClosestScrollableContainer( this.$[0] );
};

/**
 * Scroll element into view
 *
 * @method
 * @see #static-method-scrollIntoView
 * @param {Object} [config={}]
 */
ve.Element.prototype.scrollElementIntoView = function ( config ) {
	return ve.Element.scrollIntoView( this.$[0], config );
};
