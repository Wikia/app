/*!
 * VisualEditor UserInterface Context class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * UserInterface context.
 *
 * @class
 * @abstract
 * @extends OO.ui.Element
 *
 * @constructor
 * @param {ve.ui.Surface} surface
 * @param {Object} [config] Configuration options
 */
ve.ui.Context = function VeUiContext( surface, config ) {
	// Parent constructor
	OO.ui.Element.call( this, config );

	// Properties
	this.surface = surface;
	this.visible = false;
	this.inspector = null;
	this.inspectors = this.createInspectorWindowManager();
	this.menu = new ve.ui.ContextSelectWidget( { $: this.$ } );
	this.lastSelectedNode = null;
	this.afterContextChangeTimeout = null;
	this.afterContextChangeHandler = this.afterContextChange.bind( this );
	this.updateDimensionsDebounced = ve.debounce( this.updateDimensions.bind( this ) );

	// Events
	this.surface.getModel().connect( this, { contextChange: 'onContextChange' } );
	this.inspectors.connect( this, { opening: 'onInspectorOpening' } );
	this.menu.connect( this, { choose: 'onContextItemChoose' } );

	// Initialization
	// Hide element using $.hide() not this.toggle as child implementations
	// of toggle may require the instance to be fully constructed before running.
	this.$element.addClass( 've-ui-context' ).hide();
	this.menu.toggle( false );
	this.inspectors.$element.addClass( 've-ui-context-inspectors' );
};

/* Inheritance */

OO.inheritClass( ve.ui.Context, OO.ui.Element );

/* Methods */

/**
 * Handle context change event.
 *
 * While an inspector is opening or closing, all changes are ignored so as to prevent inspectors
 * that change the selection from within their setup or teardown processes changing context state.
 *
 * The response to selection changes is deferred to prevent teardown processes handlers that change
 * the selection from causing this function to recurse. These responses are also debounced for
 * efficiency, so that if there are three selection changes in the same tick, #afterContextChange only
 * runs once.
 *
 * @see #afterContextChange
 */
ve.ui.Context.prototype.onContextChange = function () {
	if ( this.inspector && ( this.inspector.isOpening() || this.inspector.isClosing() ) ) {
		// Cancel debounced change handler
		clearTimeout( this.afterContextChangeTimeout );
		this.afterContextChangeTimeout = null;
		this.lastSelectedNode = this.surface.getModel().getSelectedNode();
	} else {
		if ( this.afterContextChangeTimeout === null ) {
			// Ensure change is handled on next cycle
			this.afterContextChangeTimeout = setTimeout( this.afterContextChangeHandler );
		}
	}
	// Purge available tools cache
	this.availableTools = null;
};

/**
 * Handle debounced context change events.
 */
ve.ui.Context.prototype.afterContextChange = function () {
	var selectedNode = this.surface.getModel().getSelectedNode();

	// Reset debouncing state
	this.afterContextChangeTimeout = null;

	if ( this.isVisible() ) {
		if ( this.menu.isVisible() ) {
			if ( this.isInspectable() ) {
				// Change state: menu -> menu
				this.populateMenu();
				this.updateDimensionsDebounced();
			} else {
				// Change state: menu -> closed
				this.menu.toggle( false );
				this.toggle( false );
			}
		} else if ( this.inspector && ( !selectedNode || ( selectedNode !== this.lastSelectedNode ) ) ) {
			// Change state: inspector -> (closed|menu)
			// Unless there is a selectedNode that hasn't changed (e.g. your inspector is editing a node)
			this.inspector.close();
		}
	} else {
		if ( this.isInspectable() ) {
			// Change state: closed -> menu
			this.menu.toggle( true );
			this.populateMenu();
			this.toggle( true );
		}
	}

	this.lastSelectedNode = selectedNode;
};

/**
 * Handle an inspector opening event.
 *
 * @param {OO.ui.Window} win Window that's being opened
 * @param {jQuery.Promise} opening Promise resolved when window is opened; when the promise is
 *   resolved the first argument will be a promise which will be resolved when the window begins
 *   closing, the second argument will be the opening data
 * @param {Object} data Window opening data
 */
ve.ui.Context.prototype.onInspectorOpening = function ( win, opening ) {
	var context = this,
		observer = this.surface.getView().surfaceObserver;
	this.inspector = win;

	// Shut down the SurfaceObserver as soon as possible, so it doesn't get confused
	// by the selection moving around in IE. Will be reenabled when inspector closes.
	// FIXME this should be done in a nicer way, managed by the Surface classes
	observer.pollOnce();
	observer.stopTimerLoop();

	opening
		.progress( function ( data ) {
			if ( data.state === 'setup' ) {
				if ( context.menu.isVisible() ) {
					// Change state: menu -> inspector
					context.menu.toggle( false );
				} else if ( !context.isVisible() ) {
					// Change state: closed -> inspector
					context.toggle( true );
				}
			}
			context.updateDimensionsDebounced();
		} )
		.always( function ( opened ) {
			opened.always( function ( closed ) {
				closed.always( function () {
					var inspectable = !!context.getAvailableTools().length;

					context.inspector = null;

					// Reenable observer
					observer.startTimerLoop();

					if ( inspectable ) {
						// Change state: inspector -> menu
						context.menu.toggle( true );
						context.populateMenu();
						context.updateDimensionsDebounced();
					} else {
						// Change state: inspector -> closed
						context.toggle( false );
					}

					// Restore selection
					if ( context.getSurface().getModel().getSelection() ) {
						context.getSurface().getView().focus();
					}
				} );
			} );
		} );
};

/**
 * Handle context item choose events.
 *
 * @param {ve.ui.ContextOptionWidget} item Chosen item
 */
ve.ui.Context.prototype.onContextItemChoose = function ( item ) {
	if ( item ) {
		item.getCommand().execute( this.surface );
	}
};

/**
 * Check if context is visible.
 *
 * @return {boolean} Context is visible
 */
ve.ui.Context.prototype.isVisible = function () {
	return this.visible;
};

/**
 * Check if current content is inspectable.
 *
 * @return {boolean} Content is inspectable
 */
ve.ui.Context.prototype.isInspectable = function () {
	return !!this.getAvailableTools().length;
};

/**
 * Check if current content is inspectable.
 *
 * @return {boolean} Content is inspectable
 */
ve.ui.Context.prototype.hasInspector = function () {
	var i, availableTools = this.getAvailableTools();
	for ( i = availableTools.length - 1; i >= 0; i-- ) {
		if ( availableTools[i].tool.prototype instanceof ve.ui.InspectorTool ) {
			return true;
		}
	}
	return false;
};

/**
 * Get available tools.
 *
 * Result is cached, and cleared when the model or selection changes.
 *
 * @returns {Object[]} List of objects containing `tool` and `model` properties, representing each
 *   compatible tool and the node or annotation it is compatible with
 */
ve.ui.Context.prototype.getAvailableTools = function () {
	if ( !this.availableTools ) {
		if ( this.surface.getModel().getSelection() instanceof ve.dm.LinearSelection ) {
			this.availableTools = ve.ui.toolFactory.getToolsForFragment(
				this.surface.getModel().getFragment()
			);
		} else {
			this.availableTools = [];
		}
	}
	return this.availableTools;
};

/**
 * Get the surface the context is being used with.
 *
 * @return {ve.ui.Surface}
 */
ve.ui.Context.prototype.getSurface = function () {
	return this.surface;
};

/**
 * Get inspector window set.
 *
 * @return {ve.ui.WindowManager}
 */
ve.ui.Context.prototype.getInspectors = function () {
	return this.inspectors;
};

/**
 * Get context menu.
 *
 * @return {ve.ui.ContextSelectWidget}
 */
ve.ui.Context.prototype.getMenu = function () {
	return this.menu;
};

/**
 * Create a inspector window manager.
 *
 * @method
 * @abstract
 * @return {ve.ui.WindowManager} Inspector window manager
 * @throws {Error} If this method is not overridden in a concrete subclass
 */
ve.ui.Context.prototype.createInspectorWindowManager = function () {
	throw new Error( 've.ui.Context.createInspectorWindowManager must be overridden in subclass' );
};

/**
 * Create a context item widget
 *
 * @param {Object} tool Object containing tool and model properties.
 * @return {ve.ui.ContextOptionWidget} Context item widget
 */
ve.ui.Context.prototype.createItem = function ( tool ) {
	return new ve.ui.ContextOptionWidget(
		tool.tool, tool.model, { $: this.$, data: tool.tool.static.name }
	);
};

/**
 * Update the contents of the menu.
 *
 * @chainable
 */
ve.ui.Context.prototype.populateMenu = function () {
	var i, len,
		items = [],
		tools = this.getAvailableTools();

	this.menu.clearItems();
	if ( tools.length ) {
		for ( i = 0, len = tools.length; i < len; i++ ) {
			items.push( this.createItem( tools[i] ) );
		}
		this.menu.addItems( items );
	}

	return this;
};

/**
 * Toggle the visibility of the context.
 *
 * @param {boolean} [show] Show the context, omit to toggle
 * @return {jQuery.Promise} Promise resolved when context is finished showing/hiding
 */
ve.ui.Context.prototype.toggle = function ( show ) {
	show = show === undefined ? !this.visible : !!show;
	if ( show !== this.visible ) {
		this.visible = show;
		this.$element.toggle();
	}
	return $.Deferred().resolve().promise();
};

/**
 * Update the size and position of the context.
 *
 * @chainable
 */
ve.ui.Context.prototype.updateDimensions = function () {
	// Override in subclass if context is positioned relative to content
	return this;
};

/**
 * Destroy the context, removing all DOM elements.
 */
ve.ui.Context.prototype.destroy = function () {
	// Disconnect events
	this.surface.getModel().disconnect( this );
	this.inspectors.disconnect( this );
	this.menu.disconnect( this );

	// Destroy inspectors WindowManager
	this.inspectors.destroy();

	// Stop timers
	clearTimeout( this.afterContextChangeTimeout );

	this.$element.remove();
	return this;
};
