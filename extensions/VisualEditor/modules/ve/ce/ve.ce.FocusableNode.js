/*!
 * VisualEditor ContentEditable FocusableNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable focusable node.
 *
 * Focusable elements have a special treatment by ve.ce.Surface. When the user selects only a single
 * node, if it is focusable, the surface will set the focusable node's focused state. Other systems,
 * such as the context, may also use a focusable node's $focusable property as a hint of where the
 * primary element in the node is. Typically, and by default, the primary element is the root
 * element, but in some cases it may need to be configured to be a specific child element within the
 * node's DOM rendering.
 *
 * If your focusable node changes size and the highlight must be redrawn, call redrawHighlight().
 * 'resize' and 'rerender' are already bound to call this.
 *
 * @class
 * @abstract
 *
 * @constructor
 * @param {jQuery} [$focusable=this.$] Primary element user is focusing on
 */
ve.ce.FocusableNode = function VeCeFocusableNode( $focusable ) {
	// Properties
	this.focused = false;
	this.$focusable = $focusable || this.$;
	this.$highlights = $( [] );
	this.surface = null;

	// Events
	this.connect( this, {
		'setup': 'onFocusableSetup',
		'resize': 'onFocusableResize',
		'rerender': 'onFocusableRerender',
		'live': 'onFocusableLive'
	} );
};

/* Events */

/**
 * @event focus
 */

/**
 * @event blur
 */

/* Methods */

/**
 * Handle setup event.
 *
 * @method
 */
ve.ce.FocusableNode.prototype.onFocusableSetup = function () {
	if ( this.live ) {
		this.surface = this.root.getSurface();
	}
};

/**
 * Handle node live.
 *
 * @method
 */
ve.ce.FocusableNode.prototype.onFocusableLive = function () {
	var surfaceModel = this.root.getSurface().getModel();

	if ( this.live ) {
		surfaceModel.connect( this, { 'history': 'onFocusableHistory' } );
	} else {
		surfaceModel.disconnect( this, { 'history': 'onFocusableHistory' } );
	}
};

/**
 * Handle history event.
 *
 * @method
 */
ve.ce.FocusableNode.prototype.onFocusableHistory = function () {
	if ( this.focused ) {
		this.redrawHighlight();
	}
};

/**
 * Handle resize event.
 *
 * @method
 */
ve.ce.FocusableNode.prototype.onFocusableResize = function () {
	if ( this.focused ) {
		this.redrawHighlight();
	}
};

/**
 * Handle rerender event.
 *
 * @method
 */
ve.ce.FocusableNode.prototype.onFocusableRerender = function () {
	if ( this.focused ) {
		this.redrawHighlight();
		// reposition menu
		this.surface.getSurface().getContext().show( true );
	}
};

/**
 * Check if node is focused.
 *
 * @method
 * @returns {boolean} Node is focused
 */
ve.ce.FocusableNode.prototype.isFocused = function () {
	return this.focused;
};

/**
 * Set the selected state of the node.
 *
 * @method
 * @param {boolean} value Node is focused
 * @emits focus
 * @emits blur
 */
ve.ce.FocusableNode.prototype.setFocused = function ( value ) {
	value = !!value;
	if ( this.focused !== value ) {
		this.focused = value;
		if ( this.focused ) {
			this.emit( 'focus' );
			this.$focusable.addClass( 've-ce-node-focused' );
			this.createHighlight();
		} else {
			this.emit( 'blur' );
			this.$focusable.removeClass( 've-ce-node-focused' );
			this.clearHighlight();
		}
	}
};

/**
 * Creates highlight.
 *
 * @method
 */
ve.ce.FocusableNode.prototype.createHighlight = function () {
	this.$focusable.find( '*' ).add( this.$focusable ).each(
		ve.bind( function( i, element ) {
			var offset, $element = $( element );
			if ( !$element.is( ':visible' ) ) {
				return true;
			}
			offset = ve.Element.getRelativePosition(
				$element, this.getRoot().getSurface().getSurface().$
			);
			this.$highlights = this.$highlights.add(
				$( '<div>' )
					.css( {
						height: $element.height(),
						width: $element.width(),
						top: offset.top,
						left: offset.left
					} )
					.addClass( 've-ce-focusableNode-highlight' )
			);
		}, this )
	);

	this.surface.replaceHighlight( this.$highlights );
};

/**
 * Clears highlight.
 *
 * @method
 */
ve.ce.FocusableNode.prototype.clearHighlight = function () {
	this.$highlights = $( [] );
	this.surface.replaceHighlight( null );
};

/**
 * Redraws highlight.
 *
 * @method
 */
ve.ce.FocusableNode.prototype.redrawHighlight = function () {
	this.clearHighlight();
	this.createHighlight();
};
