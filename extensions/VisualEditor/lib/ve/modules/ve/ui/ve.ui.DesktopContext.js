/*!
 * VisualEditor UserInterface DesktopContext class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface context that positions inspectors near the text cursor on
 * desktop.
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
	ve.ui.Context.call( this, surface, config );

	// Properties
	this.$window = this.$( this.getElementWindow() );
	this.floatThreshold = 10;
	this.floating = false;
	this.visible = false;
	this.showing = false;
	this.hiding = false;
	this.selecting = false;
	this.relocating = false;
	this.embedded = false;
	this.selection = null;
	this.context = new ve.ui.ContextWidget( { '$': this.$ } );
	this.afterModelChangeTimeout = null;
	this.afterModelChangeRange = null;
	this.$menu = this.$( '<div>' );
	this.popup = new OO.ui.PopupWidget( {
		'$': this.$,
		'$container': this.surface.getView().$element
	} );
	this.target = this.surface.getTarget() || null;

	// Events
	this.surface.getModel().connect( this, {
		'documentUpdate': 'onModelChange',
		'select': 'onModelChange'
	} );
	this.surface.getView().connect( this, {
		'selectionStart': 'onSelectionStart',
		'selectionEnd': 'onSelectionEnd',
		'relocationStart': 'onRelocationStart',
		'relocationEnd': 'onRelocationEnd',
		'focus': 'onSurfaceFocus',
		'blur': 'onSurfaceBlur',
		'position': 'onSurfacePosition'
	} );
	this.inspectors.connect( this, {
		'setup': 'onInspectorSetup',
		'teardown': 'onInspectorTeardown'
	} );
	this.surface.getView().getDocument().getDocumentNode().connect( this, {
		'teardown': 'onDocumentTeardown'
	} );
	this.context.connect( this, { 'choose': 'onContextItemChoose' } );

	this.$element.add( this.$menu )
		.on( 'mousedown', false );

	// Initialization
	this.$element.addClass( 've-ui-desktopContext' ).append( this.popup.$element );
	this.$menu.append( this.context.$element );
	this.popup.$body.append(
		this.$menu.addClass( 've-ui-desktopContext-menu' ),
		this.inspectors.$element.addClass( 've-ui-desktopContext-inspectors' )
	);
};

/* Inheritance */

OO.inheritClass( ve.ui.DesktopContext, ve.ui.Context );

/* Methods */

/**
 * Handle surface teardown.
 */
ve.ui.DesktopContext.prototype.onDocumentTeardown = function () {
	this.$window.off( '.ve-ui-desktopContext' );
};

/**
 * Handle context item choose events.
 *
 * @param {ve.ui.ContextItemWidget} item Chosen item
 */
ve.ui.DesktopContext.prototype.onContextItemChoose = function ( item ) {
	if ( item ) {
		item.getCommand().execute( this.surface );
	}
};

/**
 * @inheritdoc
 */
ve.ui.DesktopContext.prototype.destroy = function () {
	// Disconnect events
	this.surface.getModel().disconnect( this );
	this.surface.getView().disconnect( this );
	this.inspectors.disconnect( this );

	// Stop timers
	clearTimeout( this.afterModelChangeTimeout );

	// Parent method
	return ve.ui.Context.prototype.destroy.call( this );
};

/**
 * Handle window resize events.
 */
ve.ui.DesktopContext.prototype.onWindowResize = function () {
	// Update, no transition
	this.update( false );
};

/**
 * Handle window scroll events.
 */
ve.ui.DesktopContext.prototype.onWindowScroll = function () {
	// Context menu is visible and embedded
	if ( this.visible && this.embedded ) {
		this.handleFloat();
	}
};

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
 * so that if there are three selection changes in the same tick, afterModelChange() only runs once.
 *
 * @method
 * @param {ve.Range} range Range if triggered by selection change, null otherwise
 * @see #afterModelChange
 */
ve.ui.DesktopContext.prototype.onModelChange = function ( range ) {
	var win = this.inspectors.getCurrentWindow();

	if ( this.showing || this.hiding || ( win && ( win.isOpening() || win.isClosing() ) ) ) {
		clearTimeout( this.afterModelChangeTimeout );
		this.afterModelChangeTimeout = null;
		this.afterModelChangeRange = null;
	} else {
		if ( this.afterModelChangeTimeout === null ) {
			this.afterModelChangeTimeout = setTimeout( ve.bind( this.afterModelChange, this ) );
		}
		if ( range instanceof ve.Range ) {
			this.afterModelChangeRange = range;
		}
		if ( range instanceof ve.Range ) {
			this.afterModelChangeRange = range;
		}
	}
};

/**
 * Deferred response to one or more select events.
 *
 * Update the context menu for the new selection, except if the user is selecting or relocating
 * content. If the popup is open, close it, even while selecting or relocating.
 */
ve.ui.DesktopContext.prototype.afterModelChange = function () {
	var win = this.inspectors.getCurrentWindow(),
		selectionChange = !!this.afterModelChangeRange,
		moving = selectionChange && !( win && ( win.isOpening() || win.isClosing() ) );

	this.afterModelChangeTimeout = null;
	this.afterModelChangeRange = null;

	if ( this.popup.isVisible() && moving ) {
		this.hide();
	}

	// Bypass while dragging
	if ( this.selecting || this.relocating ) {
		return;
	}

	this.update( !moving  );
};

/**
 * Respond to focus events on the surfaceView by hiding the context.
 *
 * If there's an inspector open and the user manages to drop the cursor in the surface such that
 * the selection doesn't change (i.e. the resulting model selection is equal to the previous model
 * selection), then #onModelChange won't cause the inspector to be closed, so we do that here.
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
ve.ui.DesktopContext.prototype.onSurfaceFocus = function () {
	if ( this.inspectors.getCurrentWindow() ) {
		this.hide();
	}
};

/**
 * Response to blur events on the surface.
 */
ve.ui.DesktopContext.prototype.onSurfaceBlur = function () {
	if ( !this.surface.getModel().getSelection() ) {
		this.hide();
	}
};

/**
 * Response to position events on the surface.
 */
ve.ui.DesktopContext.prototype.onSurfacePosition = function () {
	this.update( false );
};

/**
 * Handle selection start events on the view.
 *
 * @method
 */
ve.ui.DesktopContext.prototype.onSelectionStart = function () {
	this.selecting = true;
	this.hide();
};

/**
 * Handle selection end events on the view.
 *
 * @method
 */
ve.ui.DesktopContext.prototype.onSelectionEnd = function () {
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
ve.ui.DesktopContext.prototype.onRelocationStart = function () {
	this.relocating = true;
	this.hide();
};

/**
 * Handle selection end events on the view.
 *
 * @method
 */
ve.ui.DesktopContext.prototype.onRelocationEnd = function () {
	this.relocating = false;
	this.update();
};

/**
 * Handle an inspector setup event.
 *
 * @method
 * @param {ve.ui.Inspector} inspector Inspector that's been setup
 * @param {Object} [config] Inspector opening information
 */
ve.ui.DesktopContext.prototype.onInspectorSetup = function () {
	this.selection = this.surface.getModel().getSelection();
	this.show( true );
};

/**
 * Handle an inspector teardown event.
 *
 * @method
 * @param {ve.ui.Inspector} inspector Inspector that's been torn down
 * @param {Object} [config] Inspector closing information
 */
ve.ui.DesktopContext.prototype.onInspectorTeardown = function () {
	this.update();
	if ( this.getSurface().getModel().getSelection() ) {
		this.getSurface().getView().focus();
	}
};

/**
 * Updates the context menu.
 *
 * @method
 * @param {boolean} [transition=false] Use a smooth transition
 * @chainable
 */
ve.ui.DesktopContext.prototype.update = function ( transition ) {
	var i, len, match, matches,
		items = [],
		fragment = this.surface.getModel().getFragment( null, false ),
		selection = fragment.getRange(),
		inspector = this.inspectors.getCurrentWindow();

	if ( inspector && selection && selection.equals( this.selection ) ) {
		// There's an inspector, and the selection hasn't changed, update the position
		this.show( transition );
	} else {
		// No inspector is open, or the selection has changed, show a menu of available inspectors
		matches = ve.ui.toolFactory.getToolsForFragment( fragment );
		if ( matches.length ) {
			// There's at least one inspectable annotation, build a menu and show it
			this.context.clearItems();
			for ( i = 0, len = matches.length; i < len; i++ ) {
				match = matches[i];
				items.push( new ve.ui.ContextItemWidget(
					match.tool.static.name, match.tool, match.model, { '$': this.$ }
				) );
			}
			this.context.addItems( items );
			this.show( transition );
		} else if ( this.visible ) {
			// Nothing to inspect
			this.hide();
		}
	}

	// Remember selection for next time
	this.selection = selection && selection.clone();

	return this;
};

/**
 * Updates the position and size.
 *
 * @method
 * @param {boolean} [transition=false] Use a smooth transition
 * @chainable
 */
ve.ui.DesktopContext.prototype.updateDimensions = function ( transition ) {
	var  $container, focusedOffset, focusedDimensions, cursorPosition, position,
		surface = this.surface.getView(),
		inspector = this.inspectors.getCurrentWindow(),
		focusedNode = surface.getFocusedNode(),
		surfaceOffset = surface.$element.offset(),
		rtl = this.surface.getModel().getDocument().getDir() === 'rtl';

	$container = inspector ? this.inspectors.$element : this.$menu;
	if ( focusedNode ) {
		// Get the position relative to the surface it is embedded in
		focusedOffset = focusedNode.getRelativeOffset();
		focusedDimensions = focusedNode.getDimensions();
		if ( this.embedded ) {
			position = { 'y': focusedOffset.top };
			// When context is embedded in RTL, it requires adjustments to the relative
			// positioning (pop up on the other side):
			if ( rtl ) {
				position.x = focusedOffset.left;
				this.popup.align = 'left';
			} else {
				position.x = focusedOffset.left + focusedDimensions.width;
				this.popup.align = 'right';
			}
		} else {
			// Get the position of the focusedNode:
			position = {
				'x': focusedOffset.left + focusedDimensions.width / 2,
				'y': focusedOffset.top + focusedDimensions.height
			};
			this.popup.align = 'center';
		}
	} else {
		// We're on top of a selected text
		// Get the position of the cursor
		cursorPosition = surface.getSelectionRect();
		if ( cursorPosition ) {
			// Correct for surface offset:
			position = {
				'x': cursorPosition.end.x - surfaceOffset.left + parseInt( surface.$element.css('margin-left'), 10 ),
				'y': cursorPosition.end.y - surfaceOffset.top
			};
		}
		// If !cursorPosition, the surface apparently isn't selected, so getSelectionRect()
		// returned null. This shouldn't happen because the context is only supposed to be
		// displayed in response to a selection, but for some reason this does happen when opening
		// an inspector without changing the selection.
		// Skip updating the cursor position, but still update the width and height.

		this.popup.align = 'center';
	}

	if ( position ) {
		if ( this.floating ) {
			position.x += surfaceOffset.left;
			position.y = this.target.getToolbar().$element.height() + this.floatThreshold;
		}
		this.$element.css( { 'left': position.x, 'top': position.y } );
	}

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
 * @chainable
 */
ve.ui.DesktopContext.prototype.show = function ( transition ) {
	var inspector = this.inspectors.getCurrentWindow(),
		focusedNode = this.surface.getView().getFocusedNode();

	if ( !this.showing && !this.hiding ) {
		this.showing = true;

		this.$window.on( {
			'resize.ve-ui-desktopContext': $.throttle( 250, ve.bind( this.onWindowResize, this ) ),
			'scroll.ve-ui-desktopContext': $.throttle( 100, ve.bind( this.onWindowScroll, this ) )
		} );

		// HACK: make the context and popup visibility: hidden; instead of display: none; because
		// they contain inspector iframes, and applying display: none; to those causes them to
		// not load in Firefox
		this.$element.css( 'visibility', '' );
		this.popup.$element.css( 'visibility', '' );
		this.popup.show();

		// Show either inspector or menu
		if ( inspector ) {
			this.$menu.hide();
			// Update size and fade the inspector in after animation is complete
			setTimeout( ve.bind( function () {
				inspector.fitHeightToContents();
				this.updateDimensions( transition );
			}, this ), 200 );
		} else {
			if ( focusedNode ) {
				this.embedded = this.shouldBeEmbedded( focusedNode );
			} else {
				this.embedded = false;
			}

			this.popup.useTail( !this.embedded );
			this.$menu.show();
		}

		this.updateDimensions( transition );

		if ( focusedNode ) {
			this.handleFloat();
		}

		this.visible = true;
		this.showing = false;
	}

	return this;
};

/**
 * @inheritdoc
 */
ve.ui.DesktopContext.prototype.hide = function () {
	var inspector = this.inspectors.getCurrentWindow();

	if ( !this.hiding && !this.showing ) {
		this.hiding = true;

		this.$window.off( '.ve-ui-desktopContext' );

		if ( inspector ) {
			inspector.close( { 'action': 'back', 'noSelect': true } );
		}
		// HACK: make the context and popup visibility: hidden; instead of display: none; because
		// they contain inspector iframes, and applying display: none; to those causes them to
		// not load in Firefox
		this.popup.hide();
		this.popup.$element.show().css( 'visibility', 'hidden' );
		this.$element.css( 'visibility', 'hidden' );
		this.visible = false;
		this.hiding = false;
		this.unfloat();
	}
	return this;
};

/**
 * Determine if the context menu should appear embedded.
 * Based on the size of the focused node and the size of the context menu.
 *
 * @param {ve.ce.Node} focusedNode
 * @return {boolean} Should the context menu be embedded
 */
ve.ui.DesktopContext.prototype.shouldBeEmbedded = function ( focusedNode ) {
	// FIXME: This calculation should be reconsidered.
	var targetHeight = this.$menu.outerHeight() + 30,
		targetWidth = this.$menu.outerWidth() + 30,
		// Name of this method (getDimensions) is pretty unfortunate - it actually returns
		// dimensions of highlights and not node itself.
		dimensions = focusedNode.getDimensions();
	return ( targetHeight < dimensions.height  && targetWidth < dimensions.width );
};

/**
 * Handle floating or unfloating the context menu.
 */
ve.ui.DesktopContext.prototype.handleFloat = function () {
	if ( this.target ) {
		if ( this.shouldFloat() ) {
			if ( !this.floating ) {
				this.float();
			}
		} else if ( this.floating ) {
			this.unfloat();
		}
	}
};

/**
 * Determine if the context menu should float or unfloat.
 * Based on the size of the focused node and the scroll position.
 *
 * @return {boolean} Should the context menu be floated
 */
ve.ui.DesktopContext.prototype.shouldFloat = function () {
	var toolbarHeight = this.surface.getTarget().getToolbar().$element.height(),
		focusedNode = this.surface.getView().getFocusedNode(),
		surfaceOffsetTop = this.surface.$element.offset().top,
		contextTop = this.$window.scrollTop() + toolbarHeight + this.floatThreshold - surfaceOffsetTop,
		contextBottom = contextTop + this.popup.getPopup().height(),
		focusedNodeTop = focusedNode.getRelativeOffset().top,
		focusedNodeBottom = focusedNodeTop + focusedNode.getDimensions().height;

	return ( focusedNodeTop <= contextTop && focusedNodeBottom >= contextBottom );
};

/*
 * Make the context menu float
 */
ve.ui.DesktopContext.prototype.float = function () {
	this.$element.css( {
		'position': 'fixed',
		'top': this.surface.getTarget().getToolbar().$element.height() + this.floatThreshold,
		'left': this.$element.offset().left
	} );
	this.floating = true;
};

/*
 * Make the context menu not float
 */
ve.ui.DesktopContext.prototype.unfloat = function () {
	this.$element.css( 'position', 'absolute' );
	this.floating = false;
	this.updateDimensions();
};
