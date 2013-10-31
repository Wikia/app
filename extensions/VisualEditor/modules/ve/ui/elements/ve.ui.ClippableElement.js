/*!
 * VisualEditor UserInterface ClippableElement class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Clippable element.
 *
 * @class
 * @abstract
 *
 * @constructor
 * @param {jQuery} $clippable Group element
 */
ve.ui.ClippableElement = function VeUiClippableElement( $clippable ) {
	// Properties
	this.$clippable = $clippable;
	this.clipping = false;
	this.clipped = false;
	this.$clippableContainer = null;
	this.$clippableWindow = null;
	this.onClippableContainerScrollHandler = ve.bind( this.clip, this );
	this.onClippableWindowResizeHandler = ve.bind( this.clip, this );

	// Initialization
	this.$clippable.addClass( 've-ui-clippableElement-clippable' );
};

/* Methods */

/**
 * Set clipping.
 *
 * @method
 * @param {boolean} value Enable clipping
 * @chainable
 */
ve.ui.ClippableElement.prototype.setClipping = function ( value ) {
	value = !!value;

	if ( this.clipping !== value ) {
		this.clipping = value;
		if ( this.clipping ) {
			this.$clippableContainer = this.$$( this.getClosestScrollableElementContainer() )
				.on( 'scroll', this.onClippableContainerScrollHandler );
			this.$clippableWindow = this.$$( this.getElementWindow() )
				.on( 'resize', this.onClippableWindowResizeHandler );
			// Initial clip after visible
			setTimeout( ve.bind( this.clip, this ) );
		} else {
			this.$clippableContainer.off( 'scroll', this.onClippableContainerScrollHandler );
			this.$clippableContainer = null;
			this.$clippableWindow.off( 'resize', this.onClippableWindowResizeHandler );
			this.$clippableWindow = null;
		}
	}

	return this;
};

/**
 * Check if the element will be clipped to fit the visible area of the nearest scrollable container.
 *
 * @method
 * @return {boolean} Element will be clipped to the visible area
 */
ve.ui.ClippableElement.prototype.isClipping = function () {
	return this.clipping;
};

/**
 * Check if the bottom or right of the element is being clipped by the nearest scrollable container.
 *
 * @method
 * @return {boolean} Part of the element is being clipped
 */
ve.ui.ClippableElement.prototype.isClipped = function () {
	return this.clipped;
};

/**
 * Clip element to visible boundaries and allow scrolling when needed.
 *
 * Element will be clipped the bottom or right of the element is within 10px of the edge of, or
 * overlapped by, the visible area of the nearest scrollable container.
 *
 * @method
 * @chainable
 */
ve.ui.ClippableElement.prototype.clip = function () {
	if ( !this.clipping ) {
		// this.$clippableContainer and this.$clippableWindow are null, so the below will fail
		return this;
	}

	var buffer = 10,
		cOffset = this.$clippable.offset(),
		ccOffset = this.$clippableContainer.offset() || { 'top': 0, 'left': 0 },
		ccHeight = this.$clippableContainer.innerHeight() - buffer,
		ccWidth = this.$clippableContainer.innerWidth() - buffer,
		scrollTop = this.$clippableContainer.scrollTop(),
		scrollLeft = this.$clippableContainer.scrollLeft(),
		desiredWidth = ( ccOffset.left + scrollLeft + ccWidth ) - cOffset.left,
		desiredHeight = ( ccOffset.top + scrollTop + ccHeight ) - cOffset.top,
		naturalWidth = this.$clippable.prop( 'scrollWidth' ),
		naturalHeight = this.$clippable.prop( 'scrollHeight' ),
		clipWidth = desiredWidth < naturalWidth,
		clipHeight = desiredHeight < naturalHeight;

	if ( clipWidth ) {
		this.$clippable.css( { 'overflow-x': 'auto', 'width': desiredWidth } );
	} else {
		this.$clippable.css( { 'overflow-x': '', 'width': '' } );
	}
	if ( clipHeight ) {
		this.$clippable.css( { 'overflow-y': 'auto', 'height': desiredHeight } );
	} else {
		this.$clippable.css( { 'overflow-y': '', 'height': '' } );
	}

	this.clipped = clipWidth || clipHeight;

	return this;
};
