/*!
 * VisualEditor ContentEditable FocusableNode class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
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
 * @param {Object} [config] Configuration options
 * @cfg {string[]} [classes] CSS classes to be added to the highlight container
 */
ve.ce.FocusableNode = function VeCeFocusableNode( $focusable, config ) {
	config = config || {};

	// Properties
	this.focused = false;
	this.highlighted = false;
	this.isFocusableSetup = false;
	this.$highlights = $( '<div>' ).addClass( 've-ce-focusableNode-highlights' );
	this.$focusable = $focusable || this.$element;
	this.focusableSurface = null;
	this.rects = null;
	this.boundingRect = null;
	this.startAndEndRects = null;

	if ( Array.isArray( config.classes ) ) {
		this.$highlights.addClass( config.classes.join( ' ' ) );
	}

	// DOM changes
	this.$element
		.addClass( 've-ce-focusableNode' )
		.prop( 'contentEditable', 'false' );

	// Events
	this.connect( this, {
		setup: 'onFocusableSetup',
		teardown: 'onFocusableTeardown',
		resizeStart: 'onFocusableResizeStart',
		resizeEnd: 'onFocusableResizeEnd',
		rerender: 'onFocusableRerender'
	} );
};

/* Inheritance */

OO.initClass( ve.ce.FocusableNode );

/* Events */

/**
 * @event focus
 */

/**
 * @event blur
 */

/* Methods */

/**
 * Create a highlight element.
 *
 * @return {jQuery} A highlight element
 */
ve.ce.FocusableNode.prototype.createHighlight = function () {
	return $( '<div>' )
		.addClass( 've-ce-focusableNode-highlight' )
		.prop( {
			title: this.constructor.static.getDescription( this.model ),
			draggable: false
		} )
		.append( $( '<img>' )
			.addClass( 've-ce-focusableNode-highlight-relocatable-marker' )
			.attr( 'src', 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==' )
			.on( {
				mousedown: this.onFocusableMouseDown.bind( this ),
				dragstart: this.onFocusableDragStart.bind( this ),
				dragend: this.onFocusableDragEnd.bind( this )
			} )
		);
};

/**
 * Handle node setup.
 *
 * @method
 */
ve.ce.FocusableNode.prototype.onFocusableSetup = function () {
	// Exit if already setup or not attached
	if ( this.isFocusableSetup || !this.root ) {
		return;
	}

	this.focusableSurface = this.root.getSurface();

	// DOM changes (duplicated from constructor in case this.$element is replaced)
	this.$element
		.addClass( 've-ce-focusableNode' )
		.prop( 'contentEditable', 'false' );

	// Events
	this.$focusable.on( {
		'mouseenter.ve-ce-focusableNode': this.onFocusableMouseEnter.bind( this ),
		'mousedown.ve-ce-focusableNode touchend.ve-ce-focusableNode': this.onFocusableMouseDown.bind( this )
	} );
	// $element is ce=false so make sure nothing happens when you click
	// on it, just in case the browser decides to do something.
	// If $element == $focusable then this can be skipped as $focusable already
	// handles mousedown events.
	if ( !this.$element.is( this.$focusable ) ) {
		this.$element.on( {
			'mousedown.ve-ce-focusableNode': function ( e ) { e.preventDefault(); }
		} );
	}

	this.isFocusableSetup = true;
};

/**
 * Handle node teardown.
 *
 * @method
 */
ve.ce.FocusableNode.prototype.onFocusableTeardown = function () {
	// Exit if not setup or not attached
	if ( !this.isFocusableSetup || !this.root ) {
		return;
	}

	// Events
	this.$focusable.off( '.ve-ce-focusableNode' );
	this.$element.off( '.ve-ce-focusableNode' );

	// Highlights
	this.clearHighlights();

	// DOM changes
	this.$element
		.removeClass( 've-ce-focusableNode' )
		.removeProp( 'contentEditable' );

	this.focusableSurface = null;
	this.isFocusableSetup = false;
};

/**
 * Handle highlight mouse down events.
 *
 * @method
 * @param {jQuery.Event} e Mouse down event
 */
ve.ce.FocusableNode.prototype.onFocusableMouseDown = function ( e ) {
	var range,
		node = this,
		surfaceModel = this.focusableSurface.getModel(),
		selection = surfaceModel.getSelection(),
		nodeRange = this.model.getOuterRange();

	if ( !this.isInContentEditable() ) {
		return;
	}
	if ( e.which === 3 ) {
		// Hide images, and select spans so context menu shows 'copy', but not 'copy image'
		this.$highlights.addClass( 've-ce-focusableNode-highlights-contextOpen' );
		// Make ce=true so we get cut/paste options in context menu
		this.$highlights.prop( 'contentEditable', 'true' );
		ve.selectElement( this.$highlights[ 0 ] );
		setTimeout( function () {
			// Undo everything as soon as the context menu is show
			node.$highlights.removeClass( 've-ce-focusableNode-highlights-contextOpen' );
			node.$highlights.prop( 'contentEditable', 'true' );
			node.focusableSurface.preparePasteTargetForCopy();
		} );
	}

	// Wait for native selection to change before correcting
	setTimeout( function () {
		range = selection instanceof ve.dm.LinearSelection && selection.getRange();
		surfaceModel.getLinearFragment(
			e.shiftKey && range ?
				ve.Range.static.newCoveringRange(
					[ range, nodeRange ], range.from > nodeRange.from
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
	if ( !this.isInContentEditable() ) {
		return;
	}
	this.executeCommand();
};

/**
 * Execute the command associated with this node.
 *
 * @method
 */
ve.ce.FocusableNode.prototype.executeCommand = function () {
	var command;
	if ( !this.model.isInspectable() ) {
		return false;
	}
	command = ve.init.target.commandRegistry.getCommandForNode( this );
	if ( command ) {
		command.execute( this.focusableSurface.getSurface() );
	}
};

/**
 * Handle element drag start.
 *
 * @method
 * @param {jQuery.Event} e Drag start event
 */
ve.ce.FocusableNode.prototype.onFocusableDragStart = function () {
	if ( this.focusableSurface ) {
		// Allow dragging this node in the surface
		this.focusableSurface.startRelocation( this );
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
	if ( this.focusableSurface ) {
		this.focusableSurface.endRelocation();
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
	if ( !this.root.getSurface().dragging && !this.root.getSurface().resizing && this.isInContentEditable() ) {
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
	var $target = $( e.target );
	if (
		!$target.hasClass( 've-ce-focusableNode-highlight' ) &&
		!OO.ui.contains( this.$focusable.toArray(), $target[ 0 ], true )
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
	if ( this.focused && this.focusableSurface ) {
		this.redrawHighlights();
		// reposition menu
		this.focusableSurface.getSurface().getContext().updateDimensions( true );
	}
};

/**
 * Check if node is focused.
 *
 * @method
 * @return {boolean} Node is focused
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
			this.$element.addClass( 've-ce-focusableNode-focused' );
			this.createHighlights();
			this.focusableSurface.appendHighlights( this.$highlights, this.focused );
			this.focusableSurface.$element.off( '.ve-ce-focusableNode' );
		} else {
			this.emit( 'blur' );
			this.$element.removeClass( 've-ce-focusableNode-focused' );
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
		mousedown: this.onFocusableMouseDown.bind( this ),
		dblclick: this.onFocusableDblClick.bind( this )
	} );

	this.highlighted = true;

	this.positionHighlights();

	this.focusableSurface.appendHighlights( this.$highlights, this.focused );

	// Events
	if ( !this.focused ) {
		this.focusableSurface.$element.on( {
			'mousemove.ve-ce-focusableNode': this.onSurfaceMouseMove.bind( this ),
			'mouseout.ve-ce-focusableNode': this.onSurfaceMouseOut.bind( this )
		} );
	}
	this.focusableSurface.connect( this, { position: 'positionHighlights' } );
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
	this.focusableSurface.$element.off( '.ve-ce-focusableNode' );
	this.focusableSurface.disconnect( this, { position: 'positionHighlights' } );
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
 * Calculate position of highlights
 */
ve.ce.FocusableNode.prototype.calculateHighlights = function () {
	var i, l, $set, columnCount, columnWidth,
		rects = [],
		filteredRects = [],
		webkitColumns = 'webkitColumnCount' in document.createElement( 'div' ).style,
		surfaceOffset = this.focusableSurface.getSurface().getBoundingClientRect();

	function contains( rect1, rect2 ) {
		return rect2.left >= rect1.left &&
			rect2.top >= rect1.top &&
			rect2.right <= rect1.right &&
			rect2.bottom <= rect1.bottom;
	}

	function process( el ) {
		var i, j, il, jl, contained, clientRects,
			$el = $( el );

		if ( $el.hasClass( 've-ce-noHighlight' ) ) {
			return;
		}

		if ( webkitColumns ) {
			columnCount = $el.css( '-webkit-column-count' );
			columnWidth = $el.css( '-webkit-column-width' );
			if ( ( columnCount && columnCount !== 'auto' ) || ( columnWidth && columnWidth !== 'auto' ) ) {
				// Chrome incorrectly measures children of nodes with columns [1], let's
				// just ignore them rather than render a possibly bizarre highlight. They
				// will usually not be positioned, because Chrome also doesn't position
				// them correctly [2] and so people avoid doing it.
				//
				// Of course there are other ways to render a node outside the bounding
				// box of its parent, like negative margin. We do not handle these cases,
				// and the highlight may not correctly cover the entire node if that
				// happens. This can't be worked around without implementing CSS
				// layouting logic ourselves, which is not worth it.
				//
				// [1] https://code.google.com/p/chromium/issues/detail?id=391271
				// [2] https://code.google.com/p/chromium/issues/detail?id=291616

				// jQuery keeps nodes in its collections in document order, so the
				// children have not been processed yet and can be safely removed.
				$set = $set.not( $el.find( '*' ) );
			}
		}

		clientRects = el.getClientRects();

		for ( i = 0, il = clientRects.length; i < il; i++ ) {
			contained = false;
			for ( j = 0, jl = rects.length; j < jl; j++ ) {
				// This rect is contained by an existing rect, discard
				if ( contains( rects[ j ], clientRects[ i ] ) ) {
					contained = true;
					break;
				}
				// An existing rect is contained by this rect, discard the existing rect
				if ( contains( clientRects[ i ], rects[ j ] ) ) {
					rects.splice( j, 1 );
					j--;
					jl--;
				}
			}
			if ( !contained ) {
				rects.push( clientRects[ i ] );
			}
		}
	}

	$set = this.$focusable.find( '*' ).addBack();
	// Calling process() may change $set.length
	for ( i = 0; i < $set.length; i++ ) {
		process( $set[ i ] );
	}

	// Elements with a width/height of 0 return a clientRect with a width/height of 1
	// As elements with an actual width/height of 1 aren't that useful anyway, just
	// throw away anything that is <=1
	filteredRects = rects.filter( function ( rect ) {
		return rect.width > 1 && rect.height > 1;
	} );
	// But if this filtering doesn't leave any rects at all, then we do want to use the 1px rects
	if ( filteredRects.length > 0 ) {
		rects = filteredRects;
	}

	this.boundingRect = null;
	// startAndEndRects is lazily evaluated in getStartAndEndRects from rects
	this.startAndEndRects = null;

	for ( i = 0, l = rects.length; i < l; i++ ) {
		// Translate to relative
		rects[ i ] = ve.translateRect( rects[ i ], -surfaceOffset.left, -surfaceOffset.top );
		this.$highlights.append(
			this.createHighlight().css( {
				top: rects[ i ].top,
				left: rects[ i ].left,
				width: rects[ i ].width,
				height: rects[ i ].height
			} )
		);

		if ( !this.boundingRect ) {
			this.boundingRect = ve.copy( rects[ i ] );
		} else {
			this.boundingRect.top = Math.min( this.boundingRect.top, rects[ i ].top );
			this.boundingRect.left = Math.min( this.boundingRect.left, rects[ i ].left );
			this.boundingRect.bottom = Math.max( this.boundingRect.bottom, rects[ i ].bottom );
			this.boundingRect.right = Math.max( this.boundingRect.right, rects[ i ].right );
		}
	}
	if ( this.boundingRect ) {
		this.boundingRect.width = this.boundingRect.right - this.boundingRect.left;
		this.boundingRect.height = this.boundingRect.bottom - this.boundingRect.top;
	}

	this.rects = rects;
};

/**
 * Positions highlights, and remove collapsed ones
 *
 * @method
 */
ve.ce.FocusableNode.prototype.positionHighlights = function () {
	var i, l;

	if ( !this.highlighted ) {
		return;
	}

	this.calculateHighlights();
	this.$highlights.empty()
		// Append something selectable for right-click copy
		.append( $( '<span>' ).addClass( 've-ce-focusableNode-highlight-selectable' ).html( '&nbsp;' ) );

	for ( i = 0, l = this.rects.length; i < l; i++ ) {
		this.$highlights.append(
			this.createHighlight().css( {
				top: this.rects[ i ].top,
				left: this.rects[ i ].left,
				width: this.rects[ i ].width,
				height: this.rects[ i ].height
			} )
		);
	}
};

/**
 * Get list of rectangles outlining the shape of the node relative to the surface
 *
 * @return {Object[]} List of rectangle objects
 */
ve.ce.FocusableNode.prototype.getRects = function () {
	if ( !this.highlighted ) {
		this.calculateHighlights();
	}
	return this.rects;
};

/**
 * Get the bounding rectangle of the focusable node highlight relative to the surface
 *
 * @return {Object|null} Top, left, bottom & right positions of the focusable node relative to the surface
 */
ve.ce.FocusableNode.prototype.getBoundingRect = function () {
	if ( !this.highlighted ) {
		this.calculateHighlights();
	}
	return this.boundingRect;
};

/**
 * Get start and end rectangles of an inline focusable node relative to the surface
 *
 * @return {Object|null} Start and end rectangles
 */
ve.ce.FocusableNode.prototype.getStartAndEndRects = function () {
	if ( !this.highlighted ) {
		this.calculateHighlights();
	}
	if ( !this.startAndEndRects ) {
		this.startAndEndRects = ve.getStartAndEndRects( this.rects );
	}
	return this.startAndEndRects;
};
