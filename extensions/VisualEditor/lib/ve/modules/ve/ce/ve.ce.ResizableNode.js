/*!
 * VisualEditor ContentEditable ResizableNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable resizable node.
 *
 * @class
 * @abstract
 *
 * @constructor
 * @param {jQuery} [$resizable=this.$element] Resizable DOM element
 * @param {Object} [config] Configuration options
 * @param {number|null} [config.snapToGrid=10] Snap to a grid of size X when the shift key is held. Null disables.
 * @param {boolean} [config.outline=false] Resize using an outline of the element only, don't live preview.
 * @param {boolean} [config.showSizeLabel=true] Show a label with the current dimensions while resizing
 * @param {boolean} [config.showScaleLabel=true] Show a label with the current scale while resizing
 */
ve.ce.ResizableNode = function VeCeResizableNode( $resizable, config ) {
	config = config || {};

	// Properties
	this.$resizable = $resizable || this.$element;
	this.resizing = false;
	this.$resizeHandles = this.$( '<div>' );
	this.snapToGrid = config.snapToGrid !== undefined ? config.snapToGrid : 10;
	this.outline = !!config.outline;
	this.showSizeLabel = config.showSizeLabel !== false;
	this.showScaleLabel = config.showScaleLabel !== false;
	// Only gets enabled when the original dimensions are provided
	this.canShowScaleLabel = false;
	if ( this.showSizeLabel || this.showScaleLabel ) {
		this.$sizeText = this.$( '<span>' ).addClass( 've-ce-resizableNode-sizeText' );
		this.$sizeLabel = this.$( '<div>' ).addClass( 've-ce-resizableNode-sizeLabel' ).append( this.$sizeText );
	}
	this.resizableOffset = null;

	// Events
	this.connect( this, {
		'focus': 'onResizableFocus',
		'blur': 'onResizableBlur',
		'live': 'onResizableLive',
		'resizing': 'onResizableResizing',
		'resizeEnd': 'onResizableFocus',
		'rerender': 'onResizableFocus'
	} );

	// Initialization
	this.$resizeHandles
		.addClass( 've-ce-resizableNode-handles' )
		.append( this.$( '<div>' )
			.addClass( 've-ce-resizableNode-nwHandle ve-ui-icon-resize-nw-se' )
			.data( 'handle', 'nw' ) )
		.append( this.$( '<div>' )
			.addClass( 've-ce-resizableNode-neHandle ve-ui-icon-resize-ne-sw' )
			.data( 'handle', 'ne' ) )
		.append( this.$( '<div>' )
			.addClass( 've-ce-resizableNode-seHandle ve-ui-icon-resize-nw-se' )
			.data( 'handle', 'se' ) )
		.append( this.$( '<div>' )
			.addClass( 've-ce-resizableNode-swHandle ve-ui-icon-resize-ne-sw' )
			.data( 'handle', 'sw' ) );
};

/* Inheritance */

/* Events */

/**
 * @event resizeStart
 */

/**
 * @event resizing
 * @param {Object} dimensions Dimension object containing width & height
 */

/**
 * @event resizeEnd
 */

/* Static Properties */

ve.ce.ResizableNode.static = {};

/* Methods */

/**
 * Get and cache the relative offset of the $resizable node
 *
 * @returns {Object} Position coordinates, containing top & left
 */
ve.ce.ResizableNode.prototype.getResizableOffset = function () {
	if ( !this.resizableOffset ) {
		this.resizableOffset = OO.ui.Element.getRelativePosition(
			this.$resizable, this.getRoot().getSurface().getSurface().$element
		);
	}
	return this.resizableOffset;
};

/** */
ve.ce.ResizableNode.prototype.setOriginalDimensions = function ( dimensions ) {
	var scalable = this.model.getScalable();

	scalable.setOriginalDimensions( dimensions );

	// If dimensions are valid and the scale label is desired, enable it
	this.canShowScaleLabel = this.showScaleLabel &&
		scalable.getOriginalDimensions().width &&
		scalable.getOriginalDimensions().height;
};

/**
 * Hide the size label
 */
ve.ce.ResizableNode.prototype.hideSizeLabel = function () {
	var node = this;
	// Defer the removal of this class otherwise other DOM changes may cause
	// the opacity transition to not play out smoothly
	setTimeout( function () {
		node.$sizeLabel.removeClass( 've-ce-resizableNode-sizeLabel-resizing' );
	} );
	// Actually hide the size label after it's done animating
	setTimeout( function () {
		node.$sizeLabel.hide();
	}, 200 );
};

/**
 * Update the contents and position of the size label
 */
ve.ce.ResizableNode.prototype.updateSizeLabel = function () {
	if ( !this.showSizeLabel && !this.canShowScaleLabel ) {
		return;
	}

	var top, height,
		scalable = this.model.getScalable(),
		dimensions = scalable.getCurrentDimensions(),
		offset = this.getResizableOffset(),
		minWidth = ( this.showSizeLabel ? 100 : 0 ) + ( this.showScaleLabel ? 30 : 0 );

	// Put the label on the outside when too narrow
	if ( dimensions.width < minWidth ) {
		top = offset.top + dimensions.height;
		height = 30;
	} else {
		top = offset.top;
		height = dimensions.height;
	}
	this.$sizeLabel
		.show()
		.addClass( 've-ce-resizableNode-sizeLabel-resizing' )
		.css( {
			'top': top,
			'left': offset.left,
			'width': dimensions.width,
			'height': height,
			'lineHeight': height + 'px'
		} );
	this.$sizeText.empty();
	if ( this.showSizeLabel ) {
		this.$sizeText.append( this.$( '<span>' )
			.addClass( 've-ce-resizableNode-sizeText-size' )
			.text( Math.round( dimensions.width ) + ' × ' + Math.round( dimensions.height ) )
		);
	}
	if ( this.canShowScaleLabel ) {
		this.$sizeText.append( this.$( '<span>' )
			.addClass( 've-ce-resizableNode-sizeText-scale' )
			.text( Math.round( 100 * scalable.getCurrentScale() ) + '%' )
		);
	}
	this.$sizeText.toggleClass( 've-ce-resizableNode-sizeText-warning', scalable.isTooSmall() || scalable.isTooLarge() );
};

/**
 * Show specific resize handles
 *
 * @param {string[]} [handles] List of handles to show: 'nw', 'ne', 'sw', 'se'. Show all if undefined.
 */
ve.ce.ResizableNode.prototype.showHandles = function ( handles ) {
	var i;

	if ( handles === undefined ) {
		this.$resizeHandles.find( 'div' ).show();
	} else {
		this.$resizeHandles.find( 'div' ).hide();
		for ( i = handles.length; i >= 0; i-- ) {
			this.$resizeHandles.find( '.ve-ce-resizableNode-' + handles[i] + 'Handle' ).show();
		}
	}
};

/**
 * Handle node focus.
 *
 * @method
 */
ve.ce.ResizableNode.prototype.onResizableFocus = function () {
	if ( this.$sizeLabel ) {
		// Attach the size label first so it doesn't mask the resize handles
		this.$sizeLabel.appendTo( this.root.getSurface().getSurface().$localOverlayControls );
	}
	this.$resizeHandles.appendTo( this.root.getSurface().getSurface().$localOverlayControls );

	// Call getScalable to pre-fetch the extended data
	this.model.getScalable();

	this.setResizableHandlesSizeAndPosition();

	this.$resizeHandles
		.find( '.ve-ce-resizableNode-neHandle' )
			.css( { 'margin-right': -this.$resizable.width() } )
			.end()
		.find( '.ve-ce-resizableNode-swHandle' )
			.css( { 'margin-bottom': -this.$resizable.height() } )
			.end()
		.find( '.ve-ce-resizableNode-seHandle' )
			.css( {
				'margin-right': -this.$resizable.width(),
				'margin-bottom': -this.$resizable.height()
			} );

	this.$resizeHandles.children()
		.off( '.ve-ce-resizableNode' )
		.on(
			'mousedown.ve-ce-resizableNode',
			ve.bind( this.onResizeHandlesCornerMouseDown, this )
		);
};

/**
 * Handle node blur.
 *
 * @method
 */
ve.ce.ResizableNode.prototype.onResizableBlur = function () {
	this.$resizeHandles.detach();
	if ( this.$sizeLabel ) {
		this.$sizeLabel.detach();
	}
};

/**
 * Handle live event.
 *
 * @method
 */
ve.ce.ResizableNode.prototype.onResizableLive = function () {
	var surface = this.getRoot().getSurface(),
		documentModel = surface.getModel().getDocument();

	if ( this.live ) {
		documentModel.connect( this, { 'transact': 'setResizableHandlesSizeAndPosition' } );
		surface.connect( this, { 'position': 'setResizableHandlesSizeAndPosition' } );
	} else {
		documentModel.disconnect( this, { 'transact': 'setResizableHandlesSizeAndPosition' } );
		surface.disconnect( this, { 'position': 'setResizableHandlesSizeAndPosition' } );
		this.onResizableBlur();
	}
};

/**
 * Handle resizing event.
 *
 * @method
 * @param {Object} dimensions Dimension object containing width & height
 */
ve.ce.ResizableNode.prototype.onResizableResizing = function ( dimensions ) {
	// Clear cached resizable offset position as it may have changed
	this.resizableOffset = null;
	this.model.getScalable().setCurrentDimensions( dimensions );
	if ( !this.outline ) {
		this.$resizable.css( this.model.getScalable().getCurrentDimensions() );
		this.setResizableHandlesPosition();
	}
	this.updateSizeLabel();
};

/**
 * Handle bounding box handle mousedown.
 *
 * @method
 * @param {jQuery.Event} e Click event
 * @fires resizeStart
 */
ve.ce.ResizableNode.prototype.onResizeHandlesCornerMouseDown = function ( e ) {
	// Hide context menu
	// TODO: Maybe there's a more generic way to handle this sort of thing? For relocation it's
	// handled in ve.ce.Surface
	this.root.getSurface().getSurface().getContext().hide();

	// Set bounding box width and undo the handle margins
	this.$resizeHandles
		.addClass( 've-ce-resizableNode-handles-resizing' )
		.css( {
			'width': this.$resizable.width(),
			'height': this.$resizable.height()
		} );

	this.$resizeHandles.children().css( 'margin', 0 );

	// Values to calculate adjusted bounding box size
	this.resizeInfo = {
		'mouseX': e.screenX,
		'mouseY': e.screenY,
		'top': this.$resizeHandles.position().top,
		'left': this.$resizeHandles.position().left,
		'height': this.$resizeHandles.height(),
		'width': this.$resizeHandles.width(),
		'handle': $( e.target ).data( 'handle' )
	};

	// Bind resize events
	this.resizing = true;
	this.root.getSurface().resizing = true;

	this.model.getScalable().setCurrentDimensions( {
		'width': this.resizeInfo.width,
		'height': this.resizeInfo.height
	} );
	this.updateSizeLabel();
	this.$( this.getElementDocument() ).on( {
		'mousemove.ve-ce-resizableNode': ve.bind( this.onDocumentMouseMove, this ),
		'mouseup.ve-ce-resizableNode': ve.bind( this.onDocumentMouseUp, this )
	} );
	this.emit( 'resizeStart' );

	return false;
};

/**
 * Set the proper size and position for resize handles
 *
 * @method
 */
ve.ce.ResizableNode.prototype.setResizableHandlesSizeAndPosition = function () {
	var width = this.$resizable.width(),
		height = this.$resizable.height();

	// Clear cached resizable offset position as it may have changed
	this.resizableOffset = null;

	this.setResizableHandlesPosition();

	this.$resizeHandles
		.css( {
			'width': 0,
			'height': 0
		} )
		.find( '.ve-ce-resizableNode-neHandle' )
			.css( { 'margin-right': -width } )
			.end()
		.find( '.ve-ce-resizableNode-swHandle' )
			.css( { 'margin-bottom': -height } )
			.end()
		.find( '.ve-ce-resizableNode-seHandle' )
			.css( {
				'margin-right': -width,
				'margin-bottom': -height
			} );
};

/**
 * Set the proper position for resize handles
 *
 * @method
 */
ve.ce.ResizableNode.prototype.setResizableHandlesPosition = function () {
	var offset = this.getResizableOffset();

	this.$resizeHandles.css( {
		'top': offset.top,
		'left': offset.left
	} );
};

/**
 * Handle body mousemove.
 *
 * @method
 * @param {jQuery.Event} e Click event
 * @fires resizing
 */
ve.ce.ResizableNode.prototype.onDocumentMouseMove = function ( e ) {
	var diff = {},
		dimensions = {
			'width': 0,
			'height': 0,
			'top': this.resizeInfo.top,
			'left': this.resizeInfo.left
		};

	if ( this.resizing ) {
		// X and Y diff
		switch ( this.resizeInfo.handle ) {
			case 'se':
				diff.x = e.screenX - this.resizeInfo.mouseX;
				diff.y = e.screenY - this.resizeInfo.mouseY;
				break;
			case 'nw':
				diff.x = this.resizeInfo.mouseX - e.screenX;
				diff.y = this.resizeInfo.mouseY - e.screenY;
				break;
			case 'ne':
				diff.x = e.screenX - this.resizeInfo.mouseX;
				diff.y = this.resizeInfo.mouseY - e.screenY;
				break;
			case 'sw':
				diff.x = this.resizeInfo.mouseX - e.screenX;
				diff.y = e.screenY - this.resizeInfo.mouseY;
				break;
		}

		dimensions = this.model.getScalable().getBoundedDimensions( {
			'width': this.resizeInfo.width + diff.x,
			'height': this.resizeInfo.height + diff.y
		}, e.shiftKey && this.snapToGrid );

		// Fix the position
		switch ( this.resizeInfo.handle ) {
			case 'ne':
				dimensions.top = this.resizeInfo.top +
					( this.resizeInfo.height - dimensions.height );
				break;
			case 'sw':
				dimensions.left = this.resizeInfo.left +
					( this.resizeInfo.width - dimensions.width );
				break;
			case 'nw':
				dimensions.top = this.resizeInfo.top +
					( this.resizeInfo.height - dimensions.height );
				dimensions.left = this.resizeInfo.left +
					( this.resizeInfo.width - dimensions.width );
				break;
		}

		// Update bounding box
		this.$resizeHandles.css( dimensions );
		this.emit( 'resizing', {
			'width': dimensions.width,
			'height': dimensions.height
		} );
	}
};

/**
 * Handle body mouseup.
 *
 * @method
 * @fires resizeEnd
 */
ve.ce.ResizableNode.prototype.onDocumentMouseUp = function () {
	var attrChanges,
		offset = this.model.getOffset(),
		width = this.$resizeHandles.outerWidth(),
		height = this.$resizeHandles.outerHeight(),
		surfaceModel = this.getRoot().getSurface().getModel(),
		documentModel = surfaceModel.getDocument(),
		selection = surfaceModel.getSelection();

	this.$resizeHandles.removeClass( 've-ce-resizableNode-handles-resizing' );
	this.$( this.getElementDocument() ).off( '.ve-ce-resizableNode' );
	this.resizing = false;
	this.root.getSurface().resizing = false;
	this.hideSizeLabel();

	// Apply changes to the model
	attrChanges = this.getAttributeChanges( width, height );
	if ( !ve.isEmptyObject( attrChanges ) ) {
		surfaceModel.change(
			ve.dm.Transaction.newFromAttributeChanges( documentModel, offset, attrChanges ),
			selection
		);
	}

	// Update the context menu. This usually happens with the redraw, but not if the
	// user doesn't perform a drag
	this.root.getSurface().getSurface().getContext().update();

	this.emit( 'resizeEnd' );
};

/**
 * Generate an object of attributes changes from the new width and height.
 *
 * @param {number} width New image width
 * @param {number} height New image height
 * @returns {Object} Attribute changes
 */
ve.ce.ResizableNode.prototype.getAttributeChanges = function ( width, height ) {
	var attrChanges = {};
	if ( this.model.getAttribute( 'width' ) !== width ) {
		attrChanges.width = width;
	}
	if ( this.model.getAttribute( 'height' ) !== height ) {
		attrChanges.height = height;
	}
	return attrChanges;
};
