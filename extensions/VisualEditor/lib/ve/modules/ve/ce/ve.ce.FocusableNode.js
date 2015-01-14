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
 * If your focusable node changes size and the highlight must be redrawn, call redrawHighlights().
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
	this.highlighted = false;
	this.isSetup = false;
	this.$highlights = this.$( '<div>' ).addClass( 've-ce-focusableNode-highlights' );
	this.$focusable = $focusable || this.$element;
	this.surface = null;
	this.boundingRect = null;

	// Events
	this.connect( this, {
		'setup': 'onFocusableSetup',
		'teardown': 'onFocusableTeardown',
		'resizeStart': 'onFocusableResizeStart',
		'resizeEnd': 'onFocusableResizeEnd',
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
 * Create a highlight element.
 *
 * @returns {jQuery} A highlight element
 */
ve.ce.FocusableNode.prototype.createHighlight = function () {
	return this.$( '<div>' )
		.addClass( 've-ce-focusableNode-highlight' )
		.attr( 'draggable', false )
		.append( this.$( '<img>' )
			.addClass( 've-ce-focusableNode-highlight-relocatable-marker' )
			.attr( 'src', 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==' )
			.on( {
				'dragstart': ve.bind( this.onFocusableDragStart, this ),
				'dragend': ve.bind( this.onFocusableDragEnd, this )
			} )
		);
};

/**
 * Handle setup event.
 *
 * @method
 */
ve.ce.FocusableNode.prototype.onFocusableSetup = function () {
	// Exit if already setup or not attached
	if ( this.isSetup || !this.root ) {
		return;
	}

	this.surface = this.getRoot().getSurface();

	// DOM changes
	this.$element
		.addClass( 've-ce-focusableNode' )
		.prop( 'contentEditable', 'false' );

	// Events
	this.$element.on( {
		'mouseenter.ve-ce-focusableNode': ve.bind( this.onFocusableMouseEnter, this ),
		'mousedown.ve-ce-focusableNode': ve.bind( this.onFocusableMouseDown, this )
	} );

	this.isSetup = true;
};

/**
 * Handle node live.
 *
 * @method
 */
ve.ce.FocusableNode.prototype.onFocusableLive = function () {
	// We don't set this.surface here because there are cases where teardown+setup are emitted
	// but live isn't :(
	var surface = this.getRoot().getSurface(),
		surfaceModel = surface.getModel();

	if ( this.live ) {
		this.$window = this.$( this.getElementWindow() );
		//this.$window.on( 'resize.ve-ce-focusableNode', $.throttle( 500, ve.bind( this.onWindowResize, this ) ) );
		surfaceModel.connect( this, { 'history': 'onFocusableHistory' } );
	} else {
		this.$window.off( 'resize.ve-ce-focusableNode' );
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
		this.redrawHighlights();
	}
};

/**
 * Handle teardown events.
 *
 * @method
 */
ve.ce.FocusableNode.prototype.onFocusableTeardown = function () {
	// Exit if not setup or not attached
	if ( !this.isSetup || !this.root ) {
		return;
	}

	// Events
	this.$element.off( '.ve-ce-focusableNode' );

	// Highlights
	this.clearHighlights();

	// DOM changes
	this.$element
		.removeClass( 've-ce-focusableNode' )
		.removeProp( 'contentEditable' );

	this.isSetup = false;
	this.surface = null;
};

/**
 * Handle highlight mouse down events.
 *
 * @method
 * @param {jQuery.Event} e Mouse down event
 */
ve.ce.FocusableNode.prototype.onFocusableMouseDown = function ( e ) {
	var surfaceModel = this.surface.getModel(),
		selectionRange = surfaceModel.getSelection(),
		nodeRange = this.model.getOuterRange();

	// Wait for native selection to change before correcting
	setTimeout( function () {
		surfaceModel.getFragment(
			e.shiftKey ?
				ve.Range.newCoveringRange(
					[ selectionRange, nodeRange ], selectionRange.from > nodeRange.from
				) :
				nodeRange
		).select();
	} );
};

/**
 * Handle highlight double click events.
 *
 * @method
 * @param {jQuery.Event} e Double click event
 */
ve.ce.FocusableNode.prototype.onFocusableDblClick = function () {
	var command = ve.ui.commandRegistry.getCommandForNode( this );
	if ( command ) {
		command.execute( this.surface.getSurface() );
	}
};

/**
 * Handle element drag start.
 *
 * @method
 * @param {jQuery.Event} e Drag start event
 */
ve.ce.FocusableNode.prototype.onFocusableDragStart = function () {
	if ( this.surface ) {
		// Allow dragging this node in the surface
		this.surface.startRelocation( this );
	}
	this.$highlights.addClass( 've-ce-focusableNode-highlights-relocating' );
};

/**
 * Handle element drag end.
 *
 * If a relocation actually takes place the node is destroyed before this events fires.
 *
 * @method
 * @param {jQuery.Event} e Drag end event
 */
ve.ce.FocusableNode.prototype.onFocusableDragEnd = function () {
	// endRelocation is usually triggered by onDocumentDrop in the surface, but if it isn't
	// trigger it here instead
	if ( this.surface ) {
		this.surface.endRelocation();
	}
	this.$highlights.removeClass( 've-ce-focusableNode-highlights-relocating' );
};

/**
 * Handle mouse enter events.
 *
 * @method
 * @param {jQuery.Event} e Mouse enter event
 */
ve.ce.FocusableNode.prototype.onFocusableMouseEnter = function () {
	if ( !this.root.getSurface().dragging && !this.root.getSurface().resizing ) {
		this.createHighlights();
	}
};

/**
 * Handle surface mouse move events.
 *
 * @method
 * @param {jQuery.Event} e Mouse move event
 */
ve.ce.FocusableNode.prototype.onSurfaceMouseMove = function ( e ) {
	var $target = this.$( e.target );
	if (
		!$target.hasClass( 've-ce-focusableNode-highlight' ) &&
		$target.closest( '.ve-ce-focusableNode' ).length === 0
	) {
		this.clearHighlights();
	}
};

/**
 * Handle surface mouse out events.
 *
 * @method
 * @param {jQuery.Event} e Mouse out event
 */
ve.ce.FocusableNode.prototype.onSurfaceMouseOut = function ( e ) {
	if ( e.relatedTarget === null ) {
		this.clearHighlights();
	}
};

/**
 * Handle resize start events.
 *
 * @method
 */
ve.ce.FocusableNode.prototype.onFocusableResizeStart = function () {
	this.clearHighlights();
};

/**
 * Handle resize end event.
 *
 * @method
 */
ve.ce.FocusableNode.prototype.onFocusableResizeEnd = function () {
	this.redrawHighlights();
};

/**
 * Handle rerender event.
 *
 * @method
 */
ve.ce.FocusableNode.prototype.onFocusableRerender = function () {
	if ( this.focused ) {
		this.redrawHighlights();
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
			this.createHighlights();
			this.surface.appendHighlights( this.$highlights, this.focused );
			this.surface.$element.off( '.ve-ce-focusableNode' );
		} else {
			this.emit( 'blur' );
			this.$focusable.removeClass( 've-ce-node-focused' );
			this.clearHighlights();
		}
	}
};

/**
 * Creates highlights.
 *
 * @method
 */
ve.ce.FocusableNode.prototype.createHighlights = function () {
	if ( this.highlighted ) {
		return;
	}

	this.$highlights.on( {
		'mousedown': ve.bind( this.onFocusableMouseDown, this ),
		'dblclick': ve.bind( this.onFocusableDblClick, this )
	} );

	this.highlighted = true;

	this.positionHighlights();

	this.surface.appendHighlights( this.$highlights, this.focused );

	// Events
	if ( !this.focused ) {
		this.surface.$element.on( {
			'mousemove.ve-ce-focusableNode': ve.bind( this.onSurfaceMouseMove, this ),
			'mouseout.ve-ce-focusableNode': ve.bind( this.onSurfaceMouseOut, this )
		} );
	}
	this.surface.getModel().getDocument().connect( this, { 'transact': 'positionHighlights' } );
	this.surface.connect( this, { 'position': 'positionHighlights' } );
};

/**
 * Clears highlight.
 *
 * @method
 */
ve.ce.FocusableNode.prototype.clearHighlights = function () {
	if ( !this.highlighted ) {
		return;
	}
	this.$highlights.remove().empty();
	this.surface.$element.off( '.ve-ce-focusableNode' );
	this.surface.getModel().getDocument().disconnect( this, { 'transact': 'positionHighlights' } );
	this.surface.disconnect( this, { 'position': 'positionHighlights' } );
	this.highlighted = false;
	this.boundingRect = null;
};

/**
 * Redraws highlight.
 *
 * @method
 */
ve.ce.FocusableNode.prototype.redrawHighlights = function () {
	this.clearHighlights();
	this.createHighlights();
};

/**
 * Positions highlights, and remove collapsed ones
 *
 * @method
 */
ve.ce.FocusableNode.prototype.positionHighlights = function () {
	if ( !this.highlighted ) {
		return;
	}

	var i, l,
		surfaceOffset = this.surface.getSurface().$element[0].getBoundingClientRect();

	this.computeRects();
	this.$highlights.empty();

	for ( i = 0, l = this.outerRects.length; i < l; i++ ) {
		this.$highlights.append(
			this.createHighlight().css( {
				'top': this.outerRects[i].top - surfaceOffset.top,
				'left': this.outerRects[i].left - surfaceOffset.left,
				'height': this.outerRects[i].height,
				'width': this.outerRects[i].width
			} )
		);
	}
};

/**
 * Compute boundingRect and outerRects
 *
 * @method
 */
ve.ce.FocusableNode.prototype.computeRects = function () {
	var i, l, top, left, bottom, right,
		outerRects = [],
		surfaceOffset = this.surface.getSurface().$element[0].getBoundingClientRect();

	function contains( rect1, rect2 ) {
		return rect2.left >= rect1.left &&
			rect2.top >= rect1.top &&
			rect2.right <= rect1.right &&
			rect2.bottom <= rect1.bottom;
	}

	this.$element.find( '*' ).addBack().each( function () {
		var i, j, il, jl, contained, clientRects;

		if ( $( this ).hasClass( 've-ce-noHighlight' ) ) {
			return;
		}

		clientRects = this.getClientRects();

		for ( i = 0, il = clientRects.length; i < il; i++ ) {
			// Elements with width/height of 0 return a clientRect with
			// w/h of 1. As elements with an actual w/h of 1 aren't that
			// useful, just throw away anything that is <= 1
			if ( clientRects[i].width <= 1 || clientRects[i].height <= 1 ) {
				continue;
			}
			contained = false;
			for ( j = 0, jl = outerRects.length; j < jl; j++ ) {
				// This rect is contained by an existing rect, discard
				if ( contains( outerRects[j], clientRects[i] ) ) {
					contained = true;
					break;
				}
				// An existing rect is contained by this rect, discard the existing rect
				if ( contains( clientRects[i], outerRects[j] ) ) {
					outerRects.splice( j, 1 );
					j--;
					jl--;
				}
			}
			if ( !contained ) {
				outerRects.push( clientRects[i] );
			}
		}
	} );

	this.boundingRect = {
		'top': Infinity,
		'left': Infinity,
		'bottom': -Infinity,
		'right': -Infinity
	};

	for ( i = 0, l = outerRects.length; i < l; i++ ) {
		top = outerRects[i].top - surfaceOffset.top;
		left = outerRects[i].left - surfaceOffset.left;
		bottom = outerRects[i].bottom - surfaceOffset.top;
		right = outerRects[i].right - surfaceOffset.left;
		this.boundingRect.top = Math.min( this.boundingRect.top, top );
		this.boundingRect.left = Math.min( this.boundingRect.left, left );
		this.boundingRect.bottom = Math.max( this.boundingRect.bottom, bottom );
		this.boundingRect.right = Math.max( this.boundingRect.right, right );
	}

	this.outerRects = outerRects;
};

/**
 * Get the offset of the focusable node highight relative to the surface
 *
 * @return {Object} Top and left offsets of the focusable node relative to the surface
 */
ve.ce.FocusableNode.prototype.getRelativeOffset = function () {
	this.computeRects();
	return {
		'top': this.boundingRect.top,
		'left': this.boundingRect.left
	};
};

/**
 * Get the bounding rectangle of the focusable node highight relative to the surface
 *
 * @return {Object} Top, left, bottom & right positions of the focusable node relative to the surface
 */
ve.ce.FocusableNode.prototype.getBoundingRect = function () {
	this.computeRects();
	return this.boundingRect;
};

/**
 * Get the dimensions of the focusable node highight
 *
 * @return {Object} Width and height of the focusable node
 */
ve.ce.FocusableNode.prototype.getDimensions = function () {
	this.computeRects();
	return {
		'width': this.boundingRect.right - this.boundingRect.left,
		'height': this.boundingRect.bottom - this.boundingRect.top
	};
};

/**
 * Get which side of the article the node is biased toward
 *
 * @return {string} 'left' or 'right'
 */
ve.ce.FocusableNode.prototype.getHorizontalBias = function () {
	var articleCenter = this.surface.$element.width() / 2,
		nodeCenter = this.getDimensions().width / 2 + this.boundingRect.left;

	return ( nodeCenter <= articleCenter ) ? 'left' : 'right';
};

/**
 * Handle window resize event.
 *
 * @method
 */
ve.ce.FocusableNode.prototype.onWindowResize = function () {
	if ( this.focused ) {
		this.redrawHighlight();
	}
};
