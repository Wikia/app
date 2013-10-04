/*!
 * VisualEditor UserInterface SurfaceToolbar class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface surface toolbar.
 *
 * @class
 * @extends ve.ui.Toolbar
 *
 * @constructor
 * @param {ve.ui.Surface} surface Surface to control
 * @param {Object} [options] Configuration options
 */
ve.ui.SurfaceToolbar = function VeUiSurfaceToolbar( surface, options ) {
	var toolbar = this;

	// Configuration initialization
	options = options || {};

	// Parent constructor
	ve.ui.Toolbar.call( this, ve.ui.toolFactory, options );

	// Properties
	this.surface = surface;
	this.floating = false;
	this.floatable = false;
	this.$window = null;
	this.$surfaceView = null;
	this.elementOffset = null;
	this.windowEvents = {
		// jQuery puts a guid on our prototype function when we use ve.bind,
		// we don't want that because that means calling $window.off( toolbarB.windowEvents )
		// will effectively also unbind toolbarA.windowEvents as they would share a guid.
		// Though jQuery does not share the reference (both A and B have the correct context
		// bound), it does unbind them. Use a regular closure instead.
		'resize': function () {
			return toolbar.onWindowResize.apply( toolbar, arguments );
		},
		'scroll': function () {
			return toolbar.onWindowScroll.apply( toolbar, arguments );
		}
	};
	this.surfaceViewEvents = {
		'keyup': function () {
			return toolbar.onSurfaceViewKeyUp.apply( toolbar, arguments );
		}
	};

	// Events
	this.surface.getModel().connect( this, { 'contextChange': 'onContextChange' } );
};

/* Inheritance */

ve.inheritClass( ve.ui.SurfaceToolbar, ve.ui.Toolbar );

/* Events */

/**
 * @event updateState
 * @see ve.dm.SurfaceFragment#getAnnotations
 * @param {ve.dm.Node[]} nodes List of nodes covered by the current selection
 * @param {ve.dm.AnnotationSet} full Annotations that cover all of the current selection
 * @param {ve.dm.AnnotationSet} partial Annotations that cover some or all of the current selection
 */

/**
 * Whenever the toolbar $bar position is updated, the changes that took place.
 *
 * @event position
 * @param {jQuery} $bar Toolbar bar
 * @param {Object} update
 * @param {boolean} [update.floating] Whether the toolbar is in floating mode
 * @param {Object} [update.css] One or more css properties that changed
 * @param {Object} [update.offset] Updated offset object (from jQuery.fn.offset, though
 *  it also includes `offset.right`)
 */

/* Methods */

/**
 * Handle window resize events while toolbar floating is enabled.
 *
 * @param {jQuery.Event} e Window resize event
 */
ve.ui.SurfaceToolbar.prototype.onWindowScroll = function () {
	var scrollTop = this.$window.scrollTop();

	if ( scrollTop > this.elementOffset.top ) {
		this.float();
	} else if ( this.floating ) {
		this.unfloat();
	}
};

/**
 * Handle window resize events while toolbar floating is enabled.
 *
 * Toolbar will stick to the top of the screen unless it would be over or under the last visible
 * branch node in the root of the document being edited, at which point it will stop just above it.
 *
 * @emits position
 * @param {jQuery.Event} e Window scroll event
 */
ve.ui.SurfaceToolbar.prototype.onWindowResize = function () {
	var update = {},
		offset = this.elementOffset;

	// Update right offset after resize (see #float)
	offset.right = this.$window.width() - this.$.outerWidth() - offset.left;
	update.offset = offset;

	if ( this.floating ) {
		update.css = { 'right': offset.right };
		this.$bar.css( update.css );
	}

	// If we're not floating, toolbar position didn't change.
	// But the dimensions did naturally change on resize, as did the right offset.
	// Which e.g. mw.ViewPageTarget's toolbarTracker needs.
	this.emit( 'position', this.$bar, update );
};

/**
 * Method to scroll to the cursor position while toolbar is floating on keyup only if
 * the cursor is obscured by the toolbar.
 */
ve.ui.SurfaceToolbar.prototype.onSurfaceViewKeyUp = function () {
	var cursorPos = this.surface.view.getSelectionRect(),
		barHeight = this.$bar.height(),
		scrollTo = this.$bar.offset().top - barHeight + ( cursorPos.end.y - cursorPos.start.y ),
		obscured = cursorPos.start.y - this.$window.scrollTop() < barHeight;

	// If toolbar is floating and cursor is obscured, scroll cursor into view
	if ( obscured && this.floating ) {
		$( 'html, body' ).animate( { scrollTop: scrollTo }, 0 );
	}
};

/**
 * Gets the surface which the toolbar controls.
 *
 * @returns {ve.ui.Surface} Surface being controlled
 */
ve.ui.SurfaceToolbar.prototype.getSurface = function () {
	return this.surface;
};

/**
 * Handle context changes on the surface.
 *
 * @emits updateState
 */
ve.ui.SurfaceToolbar.prototype.onContextChange = function () {
	var i, len, leafNodes,
		fragment = this.surface.getModel().getFragment( null, false ),
		nodes = [];

	leafNodes = fragment.getLeafNodes();
	for ( i = 0, len = leafNodes.length; i < len; i++ ) {
		if ( len === 1 || !leafNodes[i].range || leafNodes[i].range.getLength() ) {
			nodes.push( leafNodes[i].node );
		}
	}
	this.emit( 'updateState', nodes, fragment.getAnnotations(), fragment.getAnnotations( true ) );
};


/**
 * Sets up handles and preloads required information for the toolbar to work.
 * This must be called immediately after it is attached to a visible document.
 */
ve.ui.SurfaceToolbar.prototype.initialize = function () {
	// Parent method
	ve.ui.Toolbar.prototype.initialize.call( this );

	// Properties
	this.$window = $( this.getElementWindow() );
	this.$surfaceView = this.surface.getView().$;
	this.elementOffset = this.$.offset();
	this.elementOffset.right = this.$window.width() - this.$.outerWidth() - this.elementOffset.left;

	// Initial position. Could be invalidated by the first
	// call to onWindowScroll, but users of this event (e.g toolbarTracking)
	// need to also now the non-floating position.
	this.emit( 'position', this.$bar, {
		'floating': false,
		'offset': this.elementOffset
	} );

	if ( this.floatable ) {
		this.$window.on( this.windowEvents );
		this.$surfaceView.on( this.surfaceViewEvents );
		// The page may start with a non-zero scroll position
		this.onWindowScroll();
	}
};

/**
 * Destroys toolbar, removing event handlers and DOM elements.
 *
 * Call this whenever you are done using a toolbar.
 */
ve.ui.SurfaceToolbar.prototype.destroy = function () {
	this.disableFloatable();
	this.surface.getModel().disconnect( this, { 'contextChange': 'onContextChange' } );

	// Parent method
	ve.ui.Toolbar.prototype.destroy.call( this );
};

/**
 * Float the toolbar.
 *
 * @emits position
 */
ve.ui.SurfaceToolbar.prototype.float = function () {
	var update;
	if ( !this.floating ) {
		// When switching into floating mode, set the height of the wrapper and
		// move the bar to the same offset as the in-flow element
		update = {
			'css': { 'left': this.elementOffset.left, 'right': this.elementOffset.right },
			'floating': true
		};
		this.$
			.css( 'height', this.$.height() )
			.addClass( 've-ui-toolbar-floating' );
		this.$bar.css( update.css );
		this.floating = true;

		this.emit( 'position', this.$bar, update );
	}
};

/**
 * Reset the toolbar to it's default non-floating position.
 *
 * @emits position
 */
ve.ui.SurfaceToolbar.prototype.unfloat = function () {
	if ( this.floating ) {
		this.$
			.css( 'height', '' )
			.removeClass( 've-ui-toolbar-floating' );
		this.$bar.css( { 'left': '', 'right': '' } );
		this.floating = false;

		this.emit( 'position', this.$bar, { 'floating': false } );
	}
};

/**
 * Set automatic floating behavior to the toolbar.
 *
 * Toolbar floating is not enabled by default, call this on setup to enable it.
 * This will not make it float, but it will start listening for events that
 * will result in it potentially being floated and defloated accordingly.
 */
ve.ui.SurfaceToolbar.prototype.enableFloatable = function () {
	this.floatable = true;

	if ( this.initialized ) {
		this.$window.on( this.windowEvents );
		this.$surfaceView.on( this.surfaceViewEvents );
	}
};

/**
 * Remove automatic floating behavior to the toolbar.
 */
ve.ui.SurfaceToolbar.prototype.disableFloatable = function () {
	if ( this.$window ) {
		this.$window.off( this.windowEvents );
	}

	if ( this.$surfaceView ) {
		this.$surfaceView.off( this.surfaceViewEvents );
	}

	if ( this.floating ) {
		this.unfloat();
	}

	this.floatable = false;
};
