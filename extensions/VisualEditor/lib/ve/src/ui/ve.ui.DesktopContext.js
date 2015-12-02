/*!
 * VisualEditor UserInterface DesktopContext class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Context menu and inspectors.
 *
 * @class
 * @extends ve.ui.Context
 *
 * @constructor
 * @param {ve.ui.Surface} surface
 * @param {Object} [config] Configuration options
 */
ve.ui.DesktopContext = function VeUiDesktopContext( surface, config ) {
	// Parent constructor
	ve.ui.DesktopContext.super.call( this, surface, config );

	// Properties
	this.popup = new OO.ui.PopupWidget( { $: this.$, $container: this.surface.$element } );
	this.transitioning = null;
	this.suppressed = false;
	this.onWindowResizeHandler = this.onPosition.bind( this );
	this.$window = this.$( this.getElementWindow() );

	// Events
	this.surface.getView().connect( this, {
		relocationStart: 'onSuppress',
		relocationEnd: 'onUnsuppress',
		blur: 'onSuppress',
		focus: 'onUnsuppress',
		position: 'onPosition'
	} );
	this.surface.getModel().connect( this, {
		select: 'onModelSelect'
	} );
	this.inspectors.connect( this, {
		resize: 'setPopupSize'
	} );
	this.$window.on( 'resize', this.onWindowResizeHandler );

	// Initialization
	this.$element
		.addClass( 've-ui-desktopContext' )
		.append( this.popup.$element );
	this.menu.$element.addClass( 've-ui-desktopContext-menu' );
	this.inspectors.$element.addClass( 've-ui-desktopContext-inspectors' );
	this.popup.$body.append( this.menu.$element, this.inspectors.$element );

	// HACK: hide the popup with visibility: hidden; rather than display: none;, because
	// the popup contains inspector iframes, and applying display: none; to those causes them to
	// not load in Firefox
	this.popup.$element.css( { visibility: 'hidden', display: '' } );
};

/* Inheritance */

OO.inheritClass( ve.ui.DesktopContext, ve.ui.Context );

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.DesktopContext.prototype.afterContextChange = function () {
	// Parent method
	ve.ui.DesktopContext.super.prototype.afterContextChange.call( this );

	// Bypass while dragging
	if ( this.suppressed ) {
		return;
	}
};

/**
 * Handle context suppression event.
 */
ve.ui.DesktopContext.prototype.onSuppress = function () {
	this.suppressed = true;

	if ( this.isVisible() ) {
		if ( this.menu.isVisible() ) {
			// Change state: menu -> closed
			this.menu.toggle( false );
			this.toggle( false );
		} else if ( this.inspector ) {
			// Change state: inspector -> closed
			this.inspector.close();
		}
	}
};

/**
 * Handle context unsuppression event.
 */
ve.ui.DesktopContext.prototype.onUnsuppress = function () {
	var inspectable = !!this.getAvailableTools().length;

	this.suppressed = false;

	if ( inspectable ) {
		// Change state: closed -> menu
		this.menu.toggle( true );
		this.populateMenu();
		this.toggle( true );
	}
};

/**
 * Handle model select event.
 */
ve.ui.DesktopContext.prototype.onModelSelect = function () {
	if ( this.isVisible() ) {
		if ( this.inspector && this.inspector.isOpened() ) {
			this.inspector.close();
		}
		this.updateDimensionsDebounced();
	}
};

/**
 * Handle cursor position change event.
 */
ve.ui.DesktopContext.prototype.onPosition = function () {
	if ( this.isVisible() ) {
		this.updateDimensionsDebounced();
	}
};

/**
 * @inheritdoc
 */
ve.ui.DesktopContext.prototype.createInspectorWindowManager = function () {
	return new ve.ui.DesktopInspectorWindowManager( {
		$: this.$,
		factory: ve.ui.windowFactory,
		overlay: this.surface.getLocalOverlay(),
		modal: false
	} );
};

/**
 * @inheritdoc
 */
ve.ui.DesktopContext.prototype.onInspectorOpening = function () {
	ve.ui.DesktopContext.super.prototype.onInspectorOpening.apply( this, arguments );
	// Resize the popup before opening so the body height of the window is measured correctly
	this.setPopupSize();
};

/**
 * @inheritdoc
 */
ve.ui.DesktopContext.prototype.toggle = function ( show ) {
	var promise;

	if ( this.transitioning ) {
		return this.transitioning;
	}
	show = show === undefined ? !this.visible : !!show;
	if ( show === this.visible ) {
		return $.Deferred().resolve().promise();
	}

	this.visible = show;
	this.transitioning = $.Deferred();
	promise = this.transitioning.promise();

	this.popup.toggle( show );
	// HACK: make the context and popup visibility: hidden; instead of display: none; because
	// they contain inspector iframes, and applying display: none; to those causes them to
	// not load in Firefox
	this.$element.add( this.popup.$element ).css( {
		visibility: show ? '' : 'hidden',
		display: ''
	} );

	this.transitioning.resolve();
	this.transitioning = null;
	this.visible = show;

	if ( show ) {
		if ( this.inspector ) {
			this.inspectors.updateWindowSize( this.inspector );
		}
		// updateDimensionsDebounced is not necessary here and causes a movement flicker
		this.updateDimensions();
	} else if ( this.inspector ) {
		this.inspector.close();
	}

	return promise;
};

/**
 * @inheritdoc
 */
ve.ui.DesktopContext.prototype.updateDimensions = function () {
	var startAndEndRects, position, embeddable, middle,
		rtl = this.surface.getModel().getDocument().getDir() === 'rtl',
		surface = this.surface.getView(),
		focusedNode = surface.getFocusedNode(),
		boundingRect = surface.getSelectionBoundingRect();

	if ( !boundingRect ) {
		// If !boundingRect, the surface apparently isn't selected.
		// This shouldn't happen because the context is only supposed to be
		// displayed in response to a selection, but it sometimes does happen due
		// to browser weirdness.
		// Skip updating the cursor position, but still update the width and height.
		this.popup.toggleAnchor( true );
		this.popup.align = 'center';
	} else if ( focusedNode && !focusedNode.isContent() ) {
		embeddable = !this.hasInspector() &&
			boundingRect.height > this.menu.$element.outerHeight() + 5 &&
			boundingRect.width > this.menu.$element.outerWidth() + 10;
		this.popup.toggleAnchor( !embeddable );
		if ( embeddable ) {
			// Embedded context position depends on directionality
			position = {
				x: rtl ? boundingRect.left : boundingRect.right,
				y: boundingRect.top
			};
			this.popup.align = rtl ? 'left' : 'right';
		} else {
			// Position the context underneath the center of the node
			middle = ( boundingRect.left + boundingRect.right ) / 2;
			position = {
				x: middle,
				y: boundingRect.bottom
			};
			this.popup.align = 'center';
		}
	} else {
		// The selection is text or an inline focused node
		startAndEndRects = surface.getSelectionStartAndEndRects();
		if ( startAndEndRects ) {
			middle = ( boundingRect.left + boundingRect.right ) / 2;
			if (
				( !rtl && startAndEndRects.end.right > middle ) ||
				( rtl && startAndEndRects.end.left < middle )
			) {
				// If the middle position is within the end rect, use it
				position = {
					x: middle,
					y: boundingRect.bottom
				};
			} else {
				// ..otherwise use the side of the end rect
				position = {
					x: rtl ? startAndEndRects.end.left : startAndEndRects.end.right,
					y: startAndEndRects.end.bottom
				};
			}
		}

		this.popup.toggleAnchor( true );
		this.popup.align = 'center';
	}

	if ( position ) {
		this.$element.css( { left: position.x, top: position.y } );
	}

	// HACK: setPopupSize() has to be called at the end because it reads this.popup.align,
	// which we set directly in the code above
	this.setPopupSize();

	return this;
};

/**
 * Resize the popup to match the size of its contents (menu or inspector).
 */
ve.ui.DesktopContext.prototype.setPopupSize = function () {
	var $container = this.inspector ? this.inspector.$frame : this.menu.$element;

	// PopupWidget normally is clippable, suppress that to be able to resize and scroll it into view.
	// Needs to be repeated before every call, as it resets itself when the popup is shown or hidden.
	this.popup.toggleClipping( false );

	this.popup.setSize(
		$container.outerWidth( true ),
		$container.outerHeight( true )
	);

	this.popup.scrollElementIntoView();
};

/**
 * @inheritdoc
 */
ve.ui.DesktopContext.prototype.destroy = function () {
	// Disconnect
	this.surface.getView().disconnect( this );
	this.surface.getModel().disconnect( this );
	this.$window.off( 'resize', this.onWindowResizeHandler );

	// Parent method
	return ve.ui.DesktopContext.super.prototype.destroy.call( this );
};
