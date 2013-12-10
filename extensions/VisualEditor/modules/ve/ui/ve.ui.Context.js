/*!
 * VisualEditor UserInterface Context class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface context.
 *
 * @class
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
	this.inspectors = {};
	this.visible = false;
	this.showing = false;
	this.hiding = false;
	this.selecting = false;
	this.inspectorOpening = false;
	this.inspectorClosing = false;
	this.relocating = false;
	this.embedded = false;
	this.selection = null;
	this.toolbar = null;
	this.afterModelSelectTimeout = null;
	this.popup = new OO.ui.PopupWidget( {
		'$': this.$,
		'$container': this.surface.getView().$element
	} );
	this.$menu = this.$( '<div>' );
	this.inspectors = new ve.ui.WindowSet( surface, ve.ui.inspectorFactory );

	// Initialization
	this.$element.addClass( 've-ui-context' ).append( this.popup.$element );
	this.inspectors.$element.addClass( 've-ui-context-inspectors' );
	this.popup.$body.append(
		this.$menu.addClass( 've-ui-context-menu' ),
		this.inspectors.$element.addClass( 've-ui-context-inspectors' )
	);

	// Events
	this.surface.getModel().connect( this, { 'select': 'onModelSelect' } );
	this.surface.getView().connect( this, {
		'selectionStart': 'onSelectionStart',
		'selectionEnd': 'onSelectionEnd',
		'relocationStart': 'onRelocationStart',
		'relocationEnd': 'onRelocationEnd',
		'focus': 'onSurfaceFocus'
	} );
	this.inspectors.connect( this, {
		'opening': 'onInspectorOpening',
		'open': 'onInspectorOpen',
		'closing': 'onInspectorClosing',
		'close': 'onInspectorClose'
	} );

	this.$( this.getElementWindow() ).on( {
		'resize': ve.bind( this.update, this )
	} );
	this.$element.add( this.$menu )
		.on( 'mousedown', false );
};

/* Inheritance */

OO.inheritClass( ve.ui.Context, OO.ui.Element );

/* Methods */

/**
 * Handle selection changes in the model.
 *
 * Changes are ignored while the user is selecting text or relocating content, apart from closing
 * the popup if it's open. While an inspector is opening or closing, all changes are ignored so as
 * to prevent inspectors that change the selection from within their open/close handlers from
 * causing issues.
 *
 * The response to selection changes is deferred to prevent close handlers that process
 * changes from causing this function to recurse. These responses are also batched for efficiency,
 * so that if there are three selection changes in the same tick, afterModelSelect() only runs once.
 *
 * @method
 * @see #afterModelSelect
 */
ve.ui.Context.prototype.onModelSelect = function () {
	if ( this.showing || this.hiding || this.inspectorOpening || this.inspectorClosing ) {
		clearTimeout( this.afterModelSelectTimeout );
	} else {
		if ( this.afterModelSelectTimeout === null ) {
			this.afterModelSelectTimeout = setTimeout( ve.bind( this.afterModelSelect, this ) );
		}
	}
};

/**
 * Deferred response to one or more select events.
 *
 * Update the context menu for the new selection, except if the user is selecting or relocating
 * content. If the popup is open, close it, even while selecting or relocating.
 */
ve.ui.Context.prototype.afterModelSelect = function () {
	this.afterModelSelectTimeout = null;
	if ( this.popup.isVisible() ) {
		this.hide();
	}
	// Bypass while dragging
	if ( this.selecting || this.relocating ) {
		return;
	}
	this.update();
};

/**
 * Respond to focus events on the surfaceView by hiding the context.
 *
 * If there's an inspector open and the user manages to drop the cursor in the surface such that
 * the selection doesn't change (i.e. the resulting model selection is equal to the previous model
 * selection), then #onModelSelect won't cause the inspector to be closed, so we do that here.
 *
 * Hiding the context immediately on focus also avoids flickering phenomena where the inspector
 * remains open or the context remains visible in the wrong place while the selection is visually
 * already moving somewhere else. We deliberately don't call #update to avoid drawing the context
 * in a place that the selection is about to move away from.
 *
 * However, we only do this when clicking out of an inspector. Hiding the context when the document
 * is focused through other means than closing an inspector is actually harmful.
 *
 * We don't have to defer the response to this event because there is no danger that inspectors'
 * close handlers will end up invoking this handler again.
 */
ve.ui.Context.prototype.onSurfaceFocus = function () {
	if ( this.inspectors.getCurrentWindow() ) {
		this.hide();
	}
};

/**
 * Handle selection start events on the view.
 *
 * @method
 */
ve.ui.Context.prototype.onSelectionStart = function () {
	this.selecting = true;
	this.hide();
};

/**
 * Handle selection end events on the view.
 *
 * @method
 */
ve.ui.Context.prototype.onSelectionEnd = function () {
	this.selecting = false;
	if ( !this.relocating ) {
		this.update();
	}
};

/**
 * Handle selection start events on the view.
 *
 * @method
 */
ve.ui.Context.prototype.onRelocationStart = function () {
	this.relocating = true;
	this.hide();
};

/**
 * Handle selection end events on the view.
 *
 * @method
 */
ve.ui.Context.prototype.onRelocationEnd = function () {
	this.relocating = false;
	this.update();
};

/**
 * Handle an inspector that's being opened.
 *
 * @method
 * @param {ve.ui.Inspector} inspector Inspector that's being opened
 * @param {Object} [config] Inspector opening information
 */
ve.ui.Context.prototype.onInspectorOpening = function () {
	this.selection = this.surface.getModel().getSelection();
	this.inspectorOpening = true;
};

/**
 * Handle an inspector that's been opened.
 *
 * @method
 * @param {ve.ui.Inspector} inspector Inspector that's been opened
 * @param {Object} [config] Inspector opening information
 */
ve.ui.Context.prototype.onInspectorOpen = function () {
	this.inspectorOpening = false;
	this.show( true );
};

/**
 * Handle an inspector that's being closed.
 *
 * @method
 * @param {ve.ui.Inspector} inspector Inspector that's being closed
 * @param {Object} [config] Inspector closing information
 */
ve.ui.Context.prototype.onInspectorClosing = function () {
	this.inspectorClosing = true;
};

/**
 * Handle an inspector that's been closed.
 *
 * @method
 * @param {ve.ui.Inspector} inspector Inspector that's been closed
 * @param {Object} [config] Inspector closing information
 */
ve.ui.Context.prototype.onInspectorClose = function () {
	this.inspectorClosing = false;
	this.update();
};

/**
 * Gets the surface the context is being used in.
 *
 * @method
 * @returns {ve.ui.Surface} Surface of context
 */
ve.ui.Context.prototype.getSurface = function () {
	return this.surface;
};

/**
 * Gets an inspector.
 *
 * @method
 * @param {string} Symbolic name of inspector
 * @returns {ve.ui.Inspector|undefined} Inspector or undefined if none exists by that name
 */
ve.ui.Context.prototype.getInspector = function ( name ) {
	return this.inspectors.getWindow( name );
};

/**
 * Destroy the context, removing all DOM elements.
 *
 * @method
 * @returns {ve.ui.Context} Context UserInterface
 * @chainable
 */
ve.ui.Context.prototype.destroy = function () {
	this.$element.remove();
	return this;
};

/**
 * Updates the context menu.
 *
 * @method
 * @param {boolean} [transition=false] Use a smooth transition
 * @param {boolean} [repositionOnly=false] The context is only being moved so don't fade in
 * @chainable
 */
ve.ui.Context.prototype.update = function ( transition, repositionOnly ) {
	var i, nodes, tools, tool,
		fragment = this.surface.getModel().getFragment( null, false ),
		selection = fragment.getRange(),
		inspector = this.inspectors.getCurrentWindow();

	if ( inspector && selection.equals( this.selection ) ) {
		// There's an inspector, and the selection hasn't changed, update the position
		this.show( transition, repositionOnly );
	} else {
		// No inspector is open, or the selection has changed, show a menu of available inspectors
		tools = ve.ui.toolFactory.getToolsForAnnotations( fragment.getAnnotations() );
		nodes = fragment.getCoveredNodes();
		for ( i = 0; i < nodes.length; i++ ) {
			if ( nodes[i].range && nodes[i].range.isCollapsed() ) {
				nodes.splice( i, 1 );
				i--;
			}
		}
		if ( nodes.length === 1 ) {
			tool = ve.ui.toolFactory.getToolForNode( nodes[0].node );
			if ( tool ) {
				tools.push( tool );
			}
		}
		if ( tools.length ) {
			// There's at least one inspectable annotation, build a menu and show it
			this.$menu.empty();
			if ( this.toolbar ) {
				this.toolbar.destroy();
			}
			this.toolbar = new ve.ui.Toolbar( this.surface );
			this.toolbar.setup( [ { 'include' : tools } ] );
			this.$menu.append( this.toolbar.$element );
			this.show( transition, repositionOnly );
			this.toolbar.initialize();
		} else if ( this.visible ) {
			// Nothing to inspect
			this.hide();
		}
	}

	// Remember selection for next time
	this.selection = selection.clone();

	return this;
};

/**
 * Updates the position and size.
 *
 * @method
 * @param {boolean} [transition=false] Use a smooth transition
 * @chainable
 */
ve.ui.Context.prototype.updateDimensions = function ( transition ) {
	var $node, $container, focusableOffset, focusableWidth, nodePosition, cursorPosition, position,
		documentOffset, nodeOffset,
		surface = this.surface.getView(),
		inspector = this.inspectors.getCurrentWindow(),
		focusedNode = surface.getFocusedNode(),
		surfaceOffset = surface.$element.offset(),
		rtl = this.surface.view.getDir() === 'rtl';

	$container = inspector ? this.inspectors.$element : this.$menu;
	if ( focusedNode ) {
		// We're on top of a node
		$node = focusedNode.$focusable || focusedNode.$element;
		if ( this.embedded ) {
			// Get the position relative to the surface it is embedded in
			focusableOffset = OO.ui.Element.getRelativePosition(
				$node, this.surface.$element
			);
			position = { 'y': focusableOffset.top };
			// When context is embedded in RTL, it requires adjustments to the relative
			// positioning (pop up on the other side):
			if ( rtl ) {
				position.x = focusableOffset.left;
				this.popup.align = 'left';
			} else {
				focusableWidth = $node.outerWidth();
				position.x = focusableOffset.left + focusableWidth;
				this.popup.align = 'right';
			}
		} else {
			// The focused node may be in a wrapper, so calculate the offset relative to the document
			documentOffset = surface.getDocument().documentNode.$element.offset();
			nodeOffset = $node.offset();
			nodePosition = {
				top: nodeOffset.top - documentOffset.top,
				left: nodeOffset.left - documentOffset.left
			};
			// Get the position of the focusedNode:
			position = { 'x': nodePosition.left, 'y': nodePosition.top + $node.outerHeight() };
			// When the context is displayed in LTR, it should be on the right of the node
			if ( !rtl ) {
				position.x += $node.outerWidth();
			}
			this.popup.align = 'center';
		}
	} else {
		// We're on top of a selected text
		// Get the position of the cursor
		cursorPosition = surface.getSelectionRect();
		if ( !cursorPosition ) {
			// The surface apparently isn't selected, so getSelectionRect() returned null.
			// This shouldn't happen because the context is only supposed to be displayed in
			// response to a selection, but for some reason this does happen in phantomjs.
			// We can't update the context position if we don't know where the selection is,
			// so just bail.
			return this;
		}

		// Correct for surface offset:
		position = {
			'x': cursorPosition.end.x - surfaceOffset.left,
			'y': cursorPosition.end.y - surfaceOffset.top
		};
		this.popup.align = 'center';
	}

	this.$element.css( { 'left': position.x, 'top': position.y } );

	this.popup.display(
		$container.outerWidth( true ),
		$container.outerHeight( true ),
		transition
	);

	return this;
};

/**
 * Shows the context menu.
 *
 * @method
 * @param {boolean} [transition=false] Use a smooth transition
 * @param {boolean} [repositionOnly=false] The context is only being moved so don't fade in
 * @chainable
 */
ve.ui.Context.prototype.show = function ( transition, repositionOnly ) {
	var inspector = this.inspectors.getCurrentWindow(),
		focusedNode = this.surface.getView().getFocusedNode();

	if ( !this.showing && !this.hiding ) {
		this.showing = true;

		this.$element.show();
		this.popup.show();

		// Show either inspector or menu
		if ( inspector ) {
			this.$menu.hide();
			this.inspectors.$element.show();
			if ( !repositionOnly ) {
				inspector.$element.css( 'opacity', 0 );
			}
			// Update size and fade the inspector in after animation is complete
			setTimeout( ve.bind( function () {
				inspector.fitHeightToContents();
				this.updateDimensions( transition );
				inspector.$element.css( 'opacity', 1 );
			}, this ), 200 );
		} else {
			this.inspectors.$element.hide();
			this.embedded = (
				focusedNode &&
				focusedNode.$focusable.outerHeight() > this.$menu.outerHeight() * 2 &&
				focusedNode.$focusable.outerWidth() > this.$menu.outerWidth() * 2
			);
			this.popup.useTail( !this.embedded );
			this.$menu.show();
		}

		this.updateDimensions( transition );

		this.visible = true;
		this.showing = false;
	}

	return this;
};

/**
 * Hides the context menu.
 *
 * @method
 * @chainable
 */
ve.ui.Context.prototype.hide = function () {
	var inspector = this.inspectors.getCurrentWindow();

	if ( !this.hiding && !this.showing ) {
		this.hiding = true;
		if ( inspector ) {
			inspector.close( { 'action': 'hide' } );
		}
		this.popup.hide();
		this.$element.hide();
		this.visible = false;
		this.hiding = false;
	}
	return this;
};
