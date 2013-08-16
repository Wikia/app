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
 * @param {Object} [config] Config options
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
