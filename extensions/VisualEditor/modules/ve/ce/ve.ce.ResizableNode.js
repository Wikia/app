/*!
 * VisualEditor ContentEditable ResizableNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
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
 */
ve.ce.ResizableNode = function VeCeResizableNode( $resizable, config ) {
	// Properties
	this.$resizable = $resizable || this.$element;
	this.ratio = this.model.getAttribute( 'width' ) / this.model.getAttribute( 'height' );
	this.resizing = false;
	this.$resizeHandles = this.$( '<div>' );
	this.snapToGrid = ( config && config.snapToGrid !== undefined ) ? config.snapToGrid : 10;
	this.outline = !!( config && config.outline );
	if ( !config || config.showSizeLabel !== false ) {
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
		'resizeEnd': 'onResizableFocus'
	} );

	// Initialization
	this.$resizeHandles
		.addClass( 've-ce-resizableNode-handles' )
		.append( this.$( '<div>' ).addClass( 've-ce-resizableNode-nwHandle' ) )
		.append( this.$( '<div>' ).addClass( 've-ce-resizableNode-neHandle' ) )
		.append( this.$( '<div>' ).addClass( 've-ce-resizableNode-seHandle' ) )
		.append( this.$( '<div>' ).addClass( 've-ce-resizableNode-swHandle' ) );
};

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

/**
 * Update the contents and position of the size label
 *
 * Omitting the dimensions object will hide the size label.
 *
 * @param {Object} [dimensions] Dimensions object with width, height, top & left, or undefined to hide
 */
ve.ce.ResizableNode.prototype.updateSizeLabel = function ( dimensions ) {
	if ( !this.$sizeLabel ) {
		return;
	}
	var offset, node, top, height;
	if ( dimensions ) {
		offset = this.getResizableOffset();
		// Things get a bit tight below 100px, so put the label on the outside
		if ( dimensions.width < 100 ) {
			top = offset.top + dimensions.height;
			height = 30;
		} else {
			top = offset.top;
			height = dimensions.height;
		}
		this.$sizeLabel
			.addClass( 've-ce-resizableNode-sizeLabel-resizing' )
			.css( {
				'top': top,
				'left': offset.left,
				'width': dimensions.width,
				'height': height,
				'lineHeight': height + 'px'
			} );
		this.$sizeText.text( Math.round( dimensions.width ) + ' × ' + Math.round( dimensions.height ) );
	} else {
		node = this;
		// Defer the removal of this class otherwise other DOM changes may cause
		// the opacity transition to not play out smoothly
		setTimeout( function () {
			node.$sizeLabel.removeClass( 've-ce-resizableNode-sizeLabel-resizing' );
		} );
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
	var surfaceModel = this.getRoot().getSurface().getModel();

	if ( this.live ) {
		surfaceModel.getDocument().connect( this, { 'transact': 'setResizableHandlesSizeAndPosition' } );
	} else {
		surfaceModel.getDocument().disconnect( this, { 'transact': 'setResizableHandlesSizeAndPosition' } );
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
	if ( !this.outline ) {
		this.$resizable.css( {
			'width': dimensions.width,
			'height': dimensions.height
		} );
		this.setResizableHandlesPosition();
	}
	this.updateSizeLabel( dimensions );
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
		'handle': e.target.className
	};

	// Bind resize events
	this.resizing = true;
	this.updateSizeLabel( this.resizeInfo );
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
	var newWidth, newHeight, newRatio, snapMin, snapMax, snap,
		// TODO: Make these configurable
		min = 1,
		max = 1000,
		diff = {},
		dimensions = {
			'width': 0,
			'height': 0,
			'top': this.resizeInfo.top,
			'left': this.resizeInfo.left
		};

	if ( this.resizing ) {
		// X and Y diff
		switch ( this.resizeInfo.handle ) {
			case 've-ce-resizableNode-seHandle':
				diff.x = e.screenX - this.resizeInfo.mouseX;
				diff.y = e.screenY - this.resizeInfo.mouseY;
				break;
			case 've-ce-resizableNode-nwHandle':
				diff.x = this.resizeInfo.mouseX - e.screenX;
				diff.y = this.resizeInfo.mouseY - e.screenY;
				break;
			case 've-ce-resizableNode-neHandle':
				diff.x = e.screenX - this.resizeInfo.mouseX;
				diff.y = this.resizeInfo.mouseY - e.screenY;
				break;
			case 've-ce-resizableNode-swHandle':
				diff.x = this.resizeInfo.mouseX - e.screenX;
				diff.y = e.screenY - this.resizeInfo.mouseY;
				break;
		}

		// Unconstrained dimensions and ratio
		newWidth = Math.max( Math.min( this.resizeInfo.width + diff.x, max ), min );
		newHeight = Math.max( Math.min( this.resizeInfo.height + diff.y, max ), min );
		newRatio = newWidth / newHeight;

		// Fix the ratio
		if ( this.ratio > newRatio ) {
			dimensions.width = newWidth;
			dimensions.height = this.resizeInfo.height +
				( newWidth - this.resizeInfo.width ) / this.ratio;
		} else {
			dimensions.width = this.resizeInfo.width +
				( newHeight - this.resizeInfo.height ) * this.ratio;
			dimensions.height = newHeight;
		}

		if ( this.snapToGrid && e.shiftKey ) {
			snapMin = Math.ceil( min / this.snapToGrid );
			snapMax = Math.floor( max / this.snapToGrid );
			snap = Math.round( dimensions.width / this.snapToGrid );
			dimensions.width = Math.max( Math.min( snap, snapMax ), snapMin ) * this.snapToGrid;
			dimensions.height = dimensions.width / this.ratio;
		}

		// Fix the position
		switch ( this.resizeInfo.handle ) {
			case 've-ce-resizableNode-neHandle':
				dimensions.top = this.resizeInfo.top +
					( this.resizeInfo.height - dimensions.height );
				break;
			case 've-ce-resizableNode-swHandle':
				dimensions.left = this.resizeInfo.left +
					( this.resizeInfo.width - dimensions.width );
				break;
			case 've-ce-resizableNode-nwHandle':
				dimensions.top = this.resizeInfo.top +
					( this.resizeInfo.height - dimensions.height );
				dimensions.left = this.resizeInfo.left +
					( this.resizeInfo.width - dimensions.width );
				break;
		}

		// Update bounding box
		this.$resizeHandles.css( dimensions );
		this.emit( 'resizing', dimensions );
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
	this.updateSizeLabel();

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
