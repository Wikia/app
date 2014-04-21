/*!
 * VisualEditor ContentEditable FocusableNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
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
 * 'resizeEnd' and 'rerender' are already bound to call this.
 *
 * @class
 * @abstract
 *
 * @constructor
 * @param {jQuery} [$focusable=this.$element] Primary element user is focusing on
 */
ve.ce.FocusableNode = function VeCeFocusableNode( $focusable ) {
	// Properties
	this.focused = false;
	this.$focusable = $focusable || this.$element;
	this.$highlights = this.$( [] );
	this.surface = null;

	// Events
	this.connect( this, {
		'setup': 'onFocusableSetup',
		'resizeEnd': 'onFocusableResizeEnd',
		'resizing': 'onFocusableResizing',
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

/* Static Methods */

ve.ce.FocusableNode.static = {};

ve.ce.FocusableNode.static.isFocusable = true;

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
 * Handle resize end event.
 *
 * @method
 */
ve.ce.FocusableNode.prototype.onFocusableResizeEnd = function () {
	if ( this.focused ) {
		this.redrawHighlight();
	}
};

/**
 * Handle resizing event.
 *
 * @method
 */
ve.ce.FocusableNode.prototype.onFocusableResizing = function () {
	if ( this.focused && !this.outline ) {
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
		this.surface.getSurface().getContext().update( true, true );
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
 * @fires focus
 * @fires blur
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
	var node = this;
	this.$focusable.find( '*' ).add( this.$focusable ).each(
		ve.bind( function ( i, el ) {
			var offset, $el = this.$( el );
			if ( !$el.is( ':visible' ) ) {
				return true;
			}
			offset = OO.ui.Element.getRelativePosition(
				$el, this.getRoot().getSurface().getSurface().$element
			);
			this.$highlights = this.$highlights.add(
				this.$( '<div>' )
					.css( {
						height: $el.height(),
						width: $el.width(),
						top: offset.top,
						left: offset.left
					} )
					.addClass( 've-ce-focusableNode-highlight' )
					.on( 'dblclick', function () {
						node.emit( 'dblclick' );
					} )
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
	this.$highlights = this.$( [] );
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
