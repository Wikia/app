/*!
 * VisualEditor UserInterface Toolbar class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * UserInterface surface toolbar.
 *
 * @class
 * @extends OO.ui.Toolbar
 *
 * @constructor
 * @param {Object} [options] Configuration options
 * @cfg {boolean} [floatable] Toolbar floats when scrolled off the page
 */
ve.ui.Toolbar = function VeUiToolbar( config ) {
	config = config || {};

	// Parent constructor
	OO.ui.Toolbar.call( this, ve.ui.toolFactory, ve.ui.toolGroupFactory, config );

	// Properties
	this.floating = false;
	this.floatable = !!config.floatable;
	this.$window = null;
	this.elementOffset = null;
	this.windowEvents = {
		// Must use Function#bind (or a closure) instead of direct reference
		// because we need a unique function references for each Toolbar instance
		// to avoid $window.off() from unbinding other toolbars' event handlers.
		resize: this.onWindowResize.bind( this ),
		scroll: this.onWindowScroll.bind( this )
	};
	// Default directions
	this.contextDirection = { inline: 'ltr', block: 'ltr' };
	// The following classes can be used here:
	// ve-ui-dir-inline-ltr
	// ve-ui-dir-inline-rtl
	// ve-ui-dir-block-ltr
	// ve-ui-dir-block-rtl
	this.$element
		.addClass( 've-ui-toolbar' )
		.addClass( 've-ui-dir-inline-' + this.contextDirection.inline )
		.addClass( 've-ui-dir-block-' + this.contextDirection.block );
};

/* Inheritance */

OO.inheritClass( ve.ui.Toolbar, OO.ui.Toolbar );

/* Events */

/**
 * @event updateState
 * @param {ve.dm.SurfaceFragment|null} fragment Surface fragment. Null if no surface is active.
 * @param {Object|null} direction Context direction with 'inline' & 'block' properties if a surface exists. Null if no surface is active.
 */

/* Methods */

/**
 * inheritdoc
 */
ve.ui.Toolbar.prototype.setup = function ( groups, surface ) {
	this.detach();

	this.surface = surface;

	// Parent method
	ve.ui.Toolbar.super.prototype.setup.call( this, groups );

	// Events
	this.getSurface().getModel().connect( this, { contextChange: 'onContextChange' } );
	this.getSurface().toolbarDialogs.connect( this, {
		opening: 'onToolbarWindowOpeningOrClosing',
		closing: 'onToolbarWindowOpeningOrClosing'
	} );
};

/**
 * inheritdoc
 */
ve.ui.Toolbar.prototype.isToolAvailable = function ( name ) {
	if ( !ve.ui.Toolbar.super.prototype.isToolAvailable.apply( this, arguments ) ) {
		return false;
	}
	// Check the tool's command is available on the surface
	var commandName,
		tool = this.getToolFactory().lookup( name );
	if ( !tool ) {
		return false;
	}
	// FIXME should use .static.getCommandName(), but we have tools that aren't ve.ui.Tool subclasses :(
	commandName = tool.static.commandName;
	return !commandName || ve.indexOf( commandName, this.getCommands() ) !== -1;
};

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
 * @param {jQuery.Event} e Window scroll event
 */
ve.ui.Toolbar.prototype.onWindowResize = function () {
	// Update offsets after resize (see #float)
	this.calculateOffset();

	if ( this.floating ) {
		this.$bar.css( {
			left: this.elementOffset.left,
			right: this.elementOffset.right
		} );
	}
};

/**
 * Handle windows opening or closing in the toolbar window manager.
 *
 * @param {OO.ui.Window} win
 * @param {jQuery.Promise} openingOrClosing
 * @param {Object} data
 */
ve.ui.Toolbar.prototype.onToolbarWindowOpeningOrClosing = function ( win, openingOrClosing ) {
	var toolbar = this;
	openingOrClosing.then( function () {
		// Wait for window transition
		setTimeout( function () {
			if ( toolbar.floating ) {
				// Re-calculate height
				toolbar.unfloat();
				toolbar.float();
			}
		}, 250 );
	} );
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
	if ( !this.getSurface() ) {
		this.emit( 'updateState', null, null );
		return;
	}

	var dirInline, dirBlock, fragmentAnnotation,
		fragment = this.getSurface().getModel().getFragment();

	// Update context direction for button icons UI.
	// By default, inline and block directions are the same.
	// If no context direction is available, use document model direction.
	dirInline = dirBlock = this.surface.getView().documentView.getDirectionFromSelection( fragment.getSelection() ) ||
		fragment.getDocument().getDir();

	// 'inline' direction is different only if we are inside a language annotation
	fragmentAnnotation = fragment.getAnnotations();
	if ( fragmentAnnotation.hasAnnotationWithName( 'meta/language' ) ) {
		dirInline = fragmentAnnotation.getAnnotationsByName( 'meta/language' ).get( 0 ).getAttribute( 'dir' );
	}

	if ( dirInline !== this.contextDirection.inline ) {
		// remove previous class:
		this.$element.removeClass( 've-ui-dir-inline-rtl ve-ui-dir-inline-ltr' );
		// The following classes can be used here:
		// ve-ui-dir-inline-ltr
		// ve-ui-dir-inline-rtl
		this.$element.addClass( 've-ui-dir-inline-' + dirInline );
		this.contextDirection.inline = dirInline;
	}
	if ( dirBlock !== this.contextDirection.block ) {
		this.$element.removeClass( 've-ui-dir-block-rtl ve-ui-dir-block-ltr' );
		// The following classes can be used here:
		// ve-ui-dir-block-ltr
		// ve-ui-dir-block-rtl
		this.$element.addClass( 've-ui-dir-block-' + dirBlock );
		this.contextDirection.block = dirBlock;
	}
	this.emit( 'updateState', fragment, this.contextDirection );
};

/**
 * Get triggers for a specified name.
 *
 * @param {string} name Trigger name
 * @returns {ve.ui.Trigger[]|undefined} Triggers
 */
ve.ui.Toolbar.prototype.getTriggers = function ( name ) {
	return this.getSurface().triggerListener.getTriggers( name );
};

/**
 * Get a list of commands available to this toolbar's surface
 *
 * @return {string[]} Command names
 */
ve.ui.Toolbar.prototype.getCommands = function () {
	return this.getSurface().triggerListener.getCommands();
};

/**
 * @inheritdoc
 */
ve.ui.Toolbar.prototype.getToolAccelerator = function ( name ) {
	var i, l, triggers = this.getTriggers( name ), shortcuts = [];

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
	this.calculateOffset();

	// Initial state
	this.updateToolState();

	if ( this.floatable ) {
		this.$window.on( this.windowEvents );
		// The page may start with a non-zero scroll position
		this.onWindowScroll();
	}
};

/**
 * Calculate the left and right offsets of the toolbar
 */
ve.ui.Toolbar.prototype.calculateOffset = function () {
	this.elementOffset = this.$element.offset();
	this.elementOffset.right = this.$window.width() - this.$element.outerWidth() - this.elementOffset.left;
};

/**
 * Detach toolbar from surface and all event listeners
 */
ve.ui.Toolbar.prototype.detach = function () {
	this.unfloat();

	// Events
	if ( this.$window ) {
		this.$window.off( this.windowEvents );
	}
	if ( this.getSurface() ) {
		this.getSurface().getModel().disconnect( this );
		this.getSurface().toolbarDialogs.disconnect( this );
		this.getSurface().toolbarDialogs.clearWindows();
		this.surface = null;
	}
};

/**
 * Destroys toolbar, removing event handlers and DOM elements.
 *
 * Call this whenever you are done using a toolbar.
 */
ve.ui.Toolbar.prototype.destroy = function () {
	// Parent method
	OO.ui.Toolbar.prototype.destroy.call( this );

	// Detach surface last, because tool destructors need getSurface()
	this.detach();
};

/**
 * Float the toolbar.
 */
ve.ui.Toolbar.prototype.float = function () {
	if ( !this.floating ) {
		var height = this.$element.height();
		// When switching into floating mode, set the height of the wrapper and
		// move the bar to the same offset as the in-flow element
		this.$element
			.css( 'height', height )
			.addClass( 've-ui-toolbar-floating' );
		this.$bar.css( {
			left: this.elementOffset.left,
			right: this.elementOffset.right
		} );
		this.floating = true;
		this.surface.setToolbarHeight( height );
	}
};

/**
 * Reset the toolbar to it's default non-floating position.
 */
ve.ui.Toolbar.prototype.unfloat = function () {
	if ( this.floating ) {
		this.$element
			.css( 'height', '' )
			.removeClass( 've-ui-toolbar-floating' );
		this.$bar.css( { left: '', right: '' } );
		this.floating = false;
		this.surface.setToolbarHeight( 0 );
	}
};
