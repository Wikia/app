/*!
 * VisualEditor UserInterface PopupWidget class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.PopupWidget object.
 *
 * @class
 * @extends ve.ui.Widget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @cfg {jQuery} [$container] Container to make popup positioned relative to
 * @cfg {boolean} [autoClose=false] Popup auto-closes when it loses focus
 */
ve.ui.PopupWidget = function VeUiPopupWidget( config ) {
	// Config intialization
	config = config || {};

	// Parent constructor
	ve.ui.Widget.call( this, config );

	// Properties
	this.visible = false;
	this.$callout = this.$$( '<div>' );
	this.$container = config.$container || this.$$( 'body' );
	this.$body = this.$$( '<div>' );
	this.transitionTimeout = null;
	this.align = config.align || 'center';
	this.autoClose = !!config.autoClose;

	// Events
	this.$.add( this.$body ).add( this.$callout )
		.on( 'mousedown', function ( e ) {
			// Cancel only local mousedown events
			return e.target !== this;
		} );

	// Initialization
	if ( this.autoClose ) {
		// Tab index on body so that it may blur
		this.$body.attr( 'tabindex', 1 );
		// Listen for blur events
		this.$body.on( 'blur', ve.bind( this.onPopupBlur, this ) );
	}
	this.$.hide()
		.addClass( 've-ui-popupWidget' )
		.append(
			this.$body.addClass( 've-ui-popupWidget-body' ),
			this.$callout.addClass( 've-ui-popupWidget-callout' )
		);
};

/* Inheritance */

ve.inheritClass( ve.ui.PopupWidget, ve.ui.Widget );

/* Events */

/**
 * @event hide
 */

/* Methods */

/**
 * Handle blur events.
 *
 * @param {jQuery.Event} e Blur event
 */
ve.ui.PopupWidget.prototype.onPopupBlur = function () {
	var $body = this.$body;

	// Find out what is focused after blur
	setTimeout( ve.bind( function () {
		var $focused = $body.find( ':focus' );
		// Is there a focused child element?
		if ( $focused.length > 0 ) {
			// Bind a one off blur event to that focused child element
			$focused.one( 'blur', ve.bind( function () {
				setTimeout( ve.bind( function () {
					if ( $body.find( ':focus' ).length === 0 ) {
						// Be sure focus is not the popup itself.
						if ( $body.is( ':focus' ) ) {
							return;
						}
						// Not a child and not the popup itself, so hide.
						this.hide();
					}
				}, this ), 0 );
			}, this ) );
		} else {
			this.hide();
		}
	}, this ), 0 );
};

/**
 * Check if the popup is visible.
 *
 * @method
 * @returns {boolean} Popup is visible
 */
ve.ui.PopupWidget.prototype.isVisible = function () {
	return this.visible;
};

/**
 * Show the context.
 *
 * @method
 * @chainable
 */
ve.ui.PopupWidget.prototype.show = function () {
	this.$.show();
	this.visible = true;
	if ( this.autoClose ) {
		// Focus body so that it may blur
		this.$body.focus();
	}
	return this;
};

/**
 * Hide the context.
 *
 * @method
 * @chainable
 */
ve.ui.PopupWidget.prototype.hide = function () {
	this.$.hide();
	this.visible = false;
	this.emit( 'hide' );
	return this;
};


/**
 * Updates the position and size.
 *
 * @method
 * @param {number} x Horizontal position
 * @param {number} y Vertical position
 * @param {number} width Width
 * @param {number} height Height
 * @param {boolean} [transition=false] Use a smooth transition
 * @chainable
 */
ve.ui.PopupWidget.prototype.display = function ( x, y, width, height, transition ) {
	var left, overlapLeft, overlapRight,
		overlapOffset = 0, padding = 7;

	switch ( this.align ) {
		case 'left':
			// Inset callout from left
			left = -padding;
			break;
		case 'right':
			// Inset callout from right
			left = -width + padding;
			break;
		default:
			// Place callout in center
			left = -width / 2;
			break;
	}

	// Prevent viewport clipping, using padding between body and popup edges
	overlapRight = this.$container.outerWidth( true ) - ( x + ( width + left + ( padding * 2 ) ) );
	overlapLeft = x + ( left - ( padding * 2 ) );
	if ( overlapRight < 0 ) {
		overlapOffset = overlapRight;
	} else if ( overlapLeft < 0 ) {
		overlapOffset -= overlapLeft;
	}

	// Prevent transition from being interrupted
	clearTimeout( this.transitionTimeout );
	if ( transition ) {
		// Enable transition
		this.$.addClass( 've-ui-popupWidget-transitioning' );
		// Prevent transitioning after transition is complete
		this.transitionTimeout = setTimeout( ve.bind( function () {
			this.$.removeClass( 've-ui-popupWidget-transitioning' );
		}, this ), 200 );
	} else {
		// Prevent transitioning immediately
		this.$.removeClass( 've-ui-popupWidget-transitioning' );
	}

	// Position body relative to anchor and adjust size
	this.$body.css( {
		'left': left + overlapOffset, 'width': width, 'height': height === undefined ? 'auto' : height
	} );

	return this;
};
