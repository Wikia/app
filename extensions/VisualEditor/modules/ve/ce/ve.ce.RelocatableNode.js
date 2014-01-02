/*!
 * VisualEditor ContentEditable RelocatableNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable relocatable node.
 *
 * Requires that the node also is Focusable
 *
 * @class
 * @abstract
 *
 * @constructor
 * @param {jQuery} [$relocatable=this.$] Element which can be relocated
 */
ve.ce.RelocatableNode = function VeCeRelocatableNode( $relocatable ) {
	// Properties
	this.relocatingSurface = null;
	this.$relocatable = $relocatable || this.$;
	this.$relocatableMarker = this.$$( '<img>' );

	// Events
	this.connect( this, {
		'focus': 'onRelocatableFocus',
		'blur': 'onRelocatableBlur',
		'resize': 'onRelocatableResize',
		'live': 'onRelocatableLive'
	} );

	// Initialization
	this.$relocatableMarker
		.addClass( 've-ce-relocatableNode-marker' )
		// Do not change this src encoding. This encoding is required for the desired UI effect.
		.attr( 'src', 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==' )
		.on( {
			'dragstart': ve.bind( this.onRelocatableDragStart, this ),
			'dragend': ve.bind( this.onRelocatableDragEnd, this )
		} );
};

/* Static Properties */

/* Methods */

/**
 * Handle node live.
 *
 * @method
 */
ve.ce.RelocatableNode.prototype.onRelocatableLive = function () {
	var surfaceModel = this.root.getSurface().getModel();

	if ( this.live ) {
		surfaceModel.connect( this, { 'history': 'setRelocatableMarkerSizeAndPosition' } );
	} else {
		surfaceModel.disconnect( this, { 'history': 'setRelocatableMarkerSizeAndPosition' } );
	}
};

/**
 * Handle node focus.
 *
 * @method
 */
ve.ce.RelocatableNode.prototype.onRelocatableFocus = function () {
	this.setRelocatableMarkerSizeAndPosition();
	this.$relocatableMarker.appendTo( this.root.getSurface().getSurface().$localOverlayControls );
};

/**
 * Handle node blur.
 *
 * @method
 */
ve.ce.RelocatableNode.prototype.onRelocatableBlur = function () {
	this.$relocatableMarker.detach();
};

/**
 * Handle node resize.
 *
 * @method
 */
ve.ce.RelocatableNode.prototype.onRelocatableResize = function () {
	this.setRelocatableMarkerSizeAndPosition();
};

/**
 * Handle element drag start.
 *
 * @method
 */
ve.ce.RelocatableNode.prototype.onRelocatableDragStart = function () {
	// Store a copy of the surface, when dragend occurs the node will be detached
	this.relocatingSurface = this.root.getSurface();

	if ( this.relocatingSurface ) {
		// Allow dragging this node in the surface
		this.relocatingSurface.startRelocation( this );
	}
	this.$relocatableMarker.addClass( 'relocating' );

	setTimeout( ve.bind( function () {
		this.$relocatableMarker.css( { 'top': -10000, 'left': -10000 } );
	}, this ), 0 );
};

/**
 * Handle element drag end.
 *
 * @method
 */
ve.ce.RelocatableNode.prototype.onRelocatableDragEnd = function () {
	if ( this.relocatingSurface ) {
		this.relocatingSurface.endRelocation();
		this.relocatingSurface = null;
	}
	this.$relocatableMarker.removeClass( 'relocating' );
};

/**
 * Set the correct size and position of the relocatable marker.
 *
 * @method
 */
ve.ce.RelocatableNode.prototype.setRelocatableMarkerSizeAndPosition = function () {
	var offset = ve.Element.getRelativePosition(
		this.$relocatable, this.getRoot().getSurface().getSurface().$
	);

	this.$relocatableMarker.css( {
		'height': this.$relocatable.outerHeight(),
		'width': this.$relocatable.outerWidth(),
		'top': offset.top,
		'left': offset.left
	} );
};
