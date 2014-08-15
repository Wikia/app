/*!
 * VisualEditor UserInterface Toolbar class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface surface toolbar.
 *
 * @class
 * @extends OO.ui.Toolbar
 *
 * @constructor
 * @param {ve.ui.Surface} surface Surface to control
 * @param {Object} [options] Configuration options
 */
ve.ui.Toolbar = function VeUiToolbar( surface, options ) {
	var toolbar = this;

	// Configuration initialization
	options = options || {};

	// Parent constructor
	OO.ui.Toolbar.call( this, ve.ui.toolFactory, ve.ui.toolGroupFactory, options );

	// Properties
	this.inContextMenu = options.inContextMenu || false;
	this.surface = surface;
	this.floating = false;
	this.floatable = false;
	this.$window = null;
	this.$surfaceView = null;
	this.elementOffset = null;
	// isMobileDevice logic copied from ve.init.mw.Target.js:
	this.isMobileDevice = (
		'ontouchstart' in window ||
			( window.DocumentTouch && document instanceof window.DocumentTouch )
	);
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
	// default directions:
	this.contextDirection = { 'inline': 'ltr', 'block': 'ltr' };
	this.$element
		.addClass( 've-ui-dir-inline-' + this.contextDirection.inline )
		.addClass( 've-ui-dir-block-' + this.contextDirection.block );
	// Events
	this.surface.getModel().connect( this, { 'contextChange': 'onContextChange' } );
	this.surface.connect( this, { 'addCommand': 'onSurfaceAddCommand' } );
};

/* Inheritance */

OO.inheritClass( ve.ui.Toolbar, OO.ui.Toolbar );

/* Events */

/**
 * @event updateState
 * @param {ve.dm.SurfaceFragment} fragment Surface fragment
 * @param {Object} direction Context direction with 'inline' & 'block' properties
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
ve.ui.Toolbar.prototype.onWindowScroll = function () {
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
 * @fires position
 * @param {jQuery.Event} e Window scroll event
 */
ve.ui.Toolbar.prototype.onWindowResize = function () {
	var $parent, parentOffset, update = {}, offset = this.elementOffset;

	// Update right offset after resize (see #float)
	offset.right = this.$window.width() - this.$element.outerWidth() - offset.left;
	update.offset = offset;

	if ( this.floating ) {
		$parent = this.$element.parent();
		parentOffset = $parent.offset();
		update.css = {
			'left': parentOffset.left,
			'right': this.$window.width() - $parent.outerWidth() - parentOffset.left
		};
		this.$bar.css( update.css );
	}

	// If we're not floating, toolbar position didn't change.
	// But the dimensions did naturally change on resize, as did the right offset.
	this.emit( 'position', this.$bar, update );
};

/**
 * Method to scroll to the cursor position while toolbar is floating on keyup only if
 * the cursor is obscured by the toolbar.
 */
ve.ui.Toolbar.prototype.onSurfaceViewKeyUp = function () {
	var barHeight, scrollTo, obscured, cursorPos = this.surface.view.getSelectionRect();
	if ( !cursorPos ) {
		return;
	}

	barHeight = this.$bar.height();
	scrollTo = this.$bar.offset().top - barHeight + ( cursorPos.end.y - cursorPos.start.y );
	obscured = cursorPos.start.y - this.$window.scrollTop() < barHeight;

	// If toolbar is floating and cursor is obscured, scroll cursor into view
	if ( obscured && this.floating ) {
		this.$( 'html, body' ).animate( { scrollTop: scrollTo }, 0 );
	}
};

/**
 * Handle context changes on the surface.
 *
 * @fires updateState
 */
ve.ui.Toolbar.prototype.onContextChange = function () {
	this.updateToolState();
};

/**
 * Update the state of the tools
 */
ve.ui.Toolbar.prototype.updateToolState = function () {
	var dirInline, dirBlock, fragmentAnnotation,
		fragment = this.surface.getModel().getFragment( null, false );

	// Update context direction for button icons UI
	// by default, inline and block directions are the same
	if ( !fragment.isNull() ) {
		dirInline = dirBlock = this.surface.getView().documentView.getDirectionFromRange( fragment.getRange() );

		// 'inline' direction is different only if we are inside a language annotation
		fragmentAnnotation = fragment.getAnnotations();
		if ( fragmentAnnotation.hasAnnotationWithName( 'meta/language' ) ) {
			dirInline = fragmentAnnotation.getAnnotationsByName( 'meta/language' ).get( 0 ).getAttribute( 'dir' );
		}

		if ( dirInline !== this.contextDirection.inline ) {
			// remove previous class:
			this.$element.removeClass( 've-ui-dir-inline-rtl ve-ui-dir-inline-ltr' );
			this.$element.addClass( 've-ui-dir-inline-' + dirInline );
			this.contextDirection.inline = dirInline;
		}
		if ( dirBlock !== this.contextDirection.block ) {
			this.$element.removeClass( 've-ui-dir-block-rtl ve-ui-dir-block-ltr' );
			this.$element.addClass( 've-ui-dir-block-' + dirBlock );
			this.contextDirection.block = dirBlock;
		}
	}
	this.emit( 'updateState', fragment, this.contextDirection );
};

/**
 * Handle command being added to surface.
 *
 * If a matching tool is present, it's label will be updated.
 *
 * @param {string} name Symbolic name of command and trigger
 * @param {ve.ui.Command} command Command that's been registered
 * @param {ve.ui.Trigger} trigger Trigger to associate with command
 */
ve.ui.Toolbar.prototype.onSurfaceAddCommand = function ( name ) {
	if ( this.tools[name] ) {
		this.tools[name].updateTitle();
	}
};

/**
 * @inheritdoc
 */
ve.ui.Toolbar.prototype.getToolAccelerator = function ( name ) {
	var i, l, triggers = this.surface.getTriggers( name ), shortcuts = [];

	if ( triggers ) {
		for ( i = 0, l = triggers.length; i < l; i++ ) {
			shortcuts.push( triggers[i].getMessage() );
		}
		return shortcuts.join( ', ' );
	} else {
		return undefined;
	}
};

/**
 * Gets the surface which the toolbar controls.
 *
 * @returns {ve.ui.Surface} Surface being controlled
 */
ve.ui.Toolbar.prototype.getSurface = function () {
	return this.surface;
};

/**
 * Sets up handles and preloads required information for the toolbar to work.
 * This must be called immediately after it is attached to a visible document.
 */
ve.ui.Toolbar.prototype.initialize = function () {
	// Parent method
	OO.ui.Toolbar.prototype.initialize.call( this );

	// Properties
	this.$window = this.$( this.getElementWindow() );
	this.$surfaceView = this.surface.getView().$element;
	this.elementOffset = this.$element.offset();
	this.elementOffset.right = this.$window.width() - this.$element.outerWidth() - this.elementOffset.left;

	// Initial position. Could be invalidated by the first
	// call to onWindowScroll, but users of this event (e.g toolbarTracking)
	// need to also now the non-floating position.
	this.emit( 'position', this.$bar, {
		'floating': false,
		'offset': this.elementOffset
	} );
	// Initial state
	this.updateToolState();

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
ve.ui.Toolbar.prototype.destroy = function () {
	this.disableFloatable();
	this.surface.getModel().disconnect( this, { 'contextChange': 'onContextChange' } );

	// Parent method
	OO.ui.Toolbar.prototype.destroy.call( this );
};

/**
 * Float the toolbar.
 *
 * @fires position
 */
ve.ui.Toolbar.prototype.float = function () {
	var update, $parent, parentOffset;

	if ( !this.floating || this.isMobileDevice ) {
		// When switching into floating mode, set the height of the wrapper and
		// move the bar to the same offset as the in-flow element
		$parent = this.$element.parent();
		parentOffset = $parent.offset();

		if ( this.isMobileDevice ) {
			update = {
				'css': {
					'left': parentOffset.left,
					'position': 'absolute',
					'top': this.$window.scrollTop() - this.$element.offset().top,
					'width': this.$element.width()
				}
			};
		} else {
			update = {
				'css': {
					'left': parentOffset.left,
					'right': this.$window.width() - $parent.outerWidth() - parentOffset.left
				}
			};
		}

		this.$element
			.css( 'height', this.$element.height() )
			.addClass( 've-ui-toolbar-floating' );
		this.$bar.css( update.css );
		this.floating = update.floating = true;

		this.emit( 'position', this.$bar, update );
	}
};

/**
 * Reset the toolbar to it's default non-floating position.
 *
 * @fires position
 */
ve.ui.Toolbar.prototype.unfloat = function () {
	if ( this.floating ) {
		this.$element
			.css( 'height', '' )
			.removeClass( 've-ui-toolbar-floating' );
		if ( this.isMobileDevice ) {
			this.$bar.css( { 'left': '', 'position': '', 'top': '', 'width': '' } );
		} else {
			this.$bar.css( { 'left': '', 'right': '' } );
		}
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
ve.ui.Toolbar.prototype.enableFloatable = function () {
	this.floatable = true;

	if ( this.initialized ) {
		this.$window.on( this.windowEvents );
		this.$surfaceView.on( this.surfaceViewEvents );
	}
};

/**
 * Remove automatic floating behavior to the toolbar.
 */
ve.ui.Toolbar.prototype.disableFloatable = function () {
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

/**
 * Gets value of this.inContextMenu
 * @returns {boolean}
 */
ve.ui.Toolbar.prototype.isInContextMenu = function () {
	return this.inContextMenu;
};

/**
 * Return floating state
 * @returns {boolean}
 */
ve.ui.Toolbar.prototype.isFloating = function () {
	return this.floating;
};
