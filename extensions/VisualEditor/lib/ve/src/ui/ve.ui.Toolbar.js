/*!
 * VisualEditor UserInterface Toolbar class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * UserInterface surface toolbar.
 *
 * @class
 * @extends OO.ui.Toolbar
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @cfg {boolean} [floatable] Toolbar can float when scrolled off the page
 */
ve.ui.Toolbar = function VeUiToolbar( config ) {
	config = config || {};

	// Parent constructor
	OO.ui.Toolbar.call( this, ve.ui.toolFactory, ve.ui.toolGroupFactory, config );

	// Properties
	this.floating = false;
	this.floatable = !!config.floatable;
	this.$window = $( this.getElementWindow() );
	this.elementOffset = null;
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
 * @param {string[]} activeDialogs List of names of currently open dialogs.
 */

/**
 * @event resize
 */

/* Methods */

/**
 * Setup toolbar
 *
 * @param {Object} groups List of tool group configurations
 * @param {ve.ui.Surface} [surface] Surface to attach to
 */
ve.ui.Toolbar.prototype.setup = function ( groups, surface ) {
	this.detach();

	this.surface = surface;

	// Parent method
	ve.ui.Toolbar.super.prototype.setup.call( this, groups );

	// Events
	this.getSurface().getModel().connect( this, { contextChange: 'onContextChange' } );
	this.getSurface().getToolbarDialogs().connect( this, {
		opening: 'onToolbarDialogsOpeningOrClosing',
		closing: 'onToolbarDialogsOpeningOrClosing'
	} );
	this.getSurface().getDialogs().connect( this, {
		opening: 'onInspectorOrDialogOpeningOrClosing',
		closing: 'onInspectorOrDialogOpeningOrClosing'
	} );
	this.getSurface().getContext().getInspectors().connect( this, {
		opening: 'onInspectorOrDialogOpeningOrClosing',
		closing: 'onInspectorOrDialogOpeningOrClosing'
	} );
};

/**
 * @inheritdoc
 */
ve.ui.Toolbar.prototype.isToolAvailable = function ( name ) {
	var commandName, tool;

	if ( !ve.ui.Toolbar.super.prototype.isToolAvailable.apply( this, arguments ) ) {
		return false;
	}
	// Check the tool's command is available on the surface
	tool = this.getToolFactory().lookup( name );
	if ( !tool ) {
		return false;
	}
	// FIXME should use .static.getCommandName(), but we have tools that aren't ve.ui.Tool subclasses :(
	commandName = tool.static.commandName;
	return !commandName || this.getCommands().indexOf( commandName ) !== -1;
};

/**
 * @inheritdoc
 *
 * While toolbar floating is enabled,
 * the toolbar will stick to the top of the screen unless it would be over or under the last visible
 * branch node in the root of the document being edited, at which point it will stop just above it.
 */
ve.ui.Toolbar.prototype.onWindowResize = function () {
	ve.ui.Toolbar.super.prototype.onWindowResize.call( this );

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
ve.ui.Toolbar.prototype.onToolbarDialogsOpeningOrClosing = function ( win, openingOrClosing ) {
	var toolbar = this;
	openingOrClosing.then( function () {
		toolbar.updateToolState();
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
 * Handle windows opening or closing in the dialogs' or inspectors' window manager.
 *
 * @param {OO.ui.Window} win
 * @param {jQuery.Promise} openingOrClosing
 * @param {Object} data
 */
ve.ui.Toolbar.prototype.onInspectorOrDialogOpeningOrClosing = function ( win, openingOrClosing ) {
	var toolbar = this;
	openingOrClosing.then( function () {
		toolbar.updateToolState();
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
	var dirInline, dirBlock, fragmentAnnotation, activeDialogs, fragment;

	if ( !this.getSurface() ) {
		this.emit( 'updateState', null, null );
		return;
	}

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

	activeDialogs = $.map(
		[
			this.surface.getDialogs(),
			this.surface.getContext().getInspectors(),
			this.surface.getToolbarDialogs()
		],
		function ( windowManager ) {
			if ( windowManager.getCurrentWindow() ) {
				return windowManager.getCurrentWindow().constructor.static.name;
			}
			return null;
		}
	);

	this.emit( 'updateState', fragment, this.contextDirection, activeDialogs );
};

/**
 * Get triggers for a specified name.
 *
 * @param {string} name Trigger name
 * @return {ve.ui.Trigger[]|undefined} Triggers
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
	var messages = ve.ui.triggerRegistry.getMessages( name );

	return messages ? messages.join( ', ' ) : undefined;
};

/**
 * Gets the surface which the toolbar controls.
 *
 * @return {ve.ui.Surface} Surface being controlled
 */
ve.ui.Toolbar.prototype.getSurface = function () {
	return this.surface;
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
	if ( this.getSurface() ) {
		this.getSurface().getModel().disconnect( this );
		this.getSurface().getToolbarDialogs().disconnect( this );
		this.getSurface().getToolbarDialogs().clearWindows();
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
 * Get height of the toolbar while floating
 *
 * @return {number} Height of the toolbar
 */
ve.ui.Toolbar.prototype.getHeight = function () {
	return this.height;
};

/**
 * Get toolbar element's offsets
 *
 * @return {Object} Toolbar element's offsets
 */
ve.ui.Toolbar.prototype.getElementOffset = function () {
	if ( !this.elementOffset ) {
		this.calculateOffset();
	}
	return this.elementOffset;
};

/**
 * Float the toolbar.
 */
ve.ui.Toolbar.prototype.float = function () {
	if ( !this.floating ) {
		this.height = this.$element.height();
		// When switching into floating mode, set the height of the wrapper and
		// move the bar to the same offset as the in-flow element
		this.$element
			.css( 'height', this.height )
			.addClass( 've-ui-toolbar-floating' );
		this.$bar.css( {
			left: this.elementOffset.left,
			right: this.elementOffset.right
		} );
		this.floating = true;
		this.emit( 'resize' );
	}
};

/**
 * Reset the toolbar to it's default non-floating position.
 */
ve.ui.Toolbar.prototype.unfloat = function () {
	if ( this.floating ) {
		this.height = 0;
		this.$element
			.css( 'height', '' )
			.removeClass( 've-ui-toolbar-floating' );
		this.$bar.css( { left: '', right: '' } );
		this.floating = false;
		this.emit( 'resize' );
	}
};

/**
 * Check if the toolbar is floating
 *
 * @return {boolean} The toolbar is floating
 */
ve.ui.Toolbar.prototype.isFloating = function () {
	return this.floating;
};

/**
 * Check if the toolbar can float
 *
 * @return {boolean} The toolbar can float
 */
ve.ui.Toolbar.prototype.isFloatable = function () {
	return this.floatable;
};
