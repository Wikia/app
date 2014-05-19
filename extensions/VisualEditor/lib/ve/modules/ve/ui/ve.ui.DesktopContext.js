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
	this.focusedNodeContentsHeight = null;
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
	this.afterModelChangeTimeout = null;
	this.afterModelChangeRange = null;
	this.$menu = this.$( '<div>' );
	this.popup = new OO.ui.PopupWidget( {
		'$': this.$,
		'$container': this.surface.getView().$element
	} );

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
		'blur': 'onSurfaceBlur'
	} );
	this.inspectors.connect( this, {
		'opening': 'onInspectorOpening',
		'open': 'onInspectorOpen',
		'closing': 'onInspectorClosing',
		'close': 'onInspectorClose'
	} );
	this.surface.getView().getDocument().getDocumentNode().connect( this, {
		'teardown': 'onSurfaceTeardown'
	} );

	this.$window.on( {
		'resize.ve-ui-desktopContext': $.throttle( 500, ve.bind( this.onWindowResize, this ) ),
		'scroll.ve-ui-desktopContext': $.throttle( 100, ve.bind( this.onWindowScroll, this ) )
	} );
	this.$element.add( this.$menu )
		.on( 'mousedown', false );

	// Initialization
	this.$element.addClass( 've-ui-desktopContext' ).append( this.popup.$element );
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
ve.ui.DesktopContext.prototype.onSurfaceTeardown = function () {
	this.$window.off('.ve-ui-desktopContext');
};

/**
 * Handle window resize events.
 */
ve.ui.DesktopContext.prototype.onWindowResize = function () {
	// Update, no transition, reposition only
	this.update( false, true );
};

/**
 * Handle window scroll events.
 */
ve.ui.DesktopContext.prototype.onWindowScroll = function () {
	var toolbar = this.surface.target.toolbar;

	// Context menu is visible and embedded and the toolbar is floating
	if ( this.visible && this.embedded && toolbar.floating ) {
		this.determineFloat();
	}

	// Context menu is floating but toolbar is not. Stop floating!
	if ( this.visible && this.embedded && this.floating && !toolbar.floating ) {
		this.unfloat();
	}
};

ve.ui.DesktopContext.prototype.determineFloat = function () {
	var toolbar = this.surface.target.toolbar,
		offset = this.$element.offset(),
		focusedNode = this.surface.getView().getFocusedNode(),
		windowScrollTop = this.$window.scrollTop(),
		focusedNodeBounds = {
			'top': focusedNode.$element.offset().top,
			'bottom': this.focusedNodeContentsHeight + focusedNode.$element.offset().top
		},
		contextBounds = {
			'top': windowScrollTop + toolbar.$element.height() + this.floatThreshold,
			'bottom': windowScrollTop + toolbar.$element.height() + this.floatThreshold + this.popup.$popup.height()
		};

	if (
		this.floating &&
		// Scrolling below bottom of focused node
		( focusedNodeBounds.bottom < contextBounds.bottom ) ||
		// Scrolling above top of focused node
		( focusedNodeBounds.top > contextBounds.top )
	) {
		this.unfloat();
	}

	if (
		!this.floating &&
		( focusedNodeBounds.top <= contextBounds.top ) &&
		( focusedNodeBounds.bottom >= contextBounds.bottom )
	) {
		this.float();
	}
};

ve.ui.DesktopContext.prototype.float = function () {
	if ( !this.floating ) {
		this.$element
			.css( {
				'position': 'fixed',
				'top': this.surface.target.toolbar.$element.height() + this.floatThreshold,
				'left': this.$element.offset().left
			} );

		this.floating = true;
	}
};

ve.ui.DesktopContext.prototype.unfloat = function () {
	if ( this.floating ) {
		this.$element.css( 'position', 'absolute' );
		this.floating = false;
		this.update();
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
	if ( this.showing || this.hiding || this.inspectorOpening || this.inspectorClosing ) {
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
	}
};

/**
 * Deferred response to one or more select events.
 *
 * Update the context menu for the new selection, except if the user is selecting or relocating
 * content. If the popup is open, close it, even while selecting or relocating.
 */
ve.ui.DesktopContext.prototype.afterModelChange = function () {
	var selectionChange = !!this.afterModelChangeRange;
	this.afterModelChangeTimeout = null;
	this.afterModelChangeRange = null;

	if ( this.popup.isVisible() && selectionChange ) {
		this.hide();
	}

	// Bypass while dragging
	if ( this.selecting || this.relocating ) {
		return;
	}
	this.update( false, !selectionChange );
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
 * Handle an inspector that's being opened.
 *
 * @method
 * @param {ve.ui.Inspector} inspector Inspector that's being opened
 * @param {Object} [config] Inspector opening information
 */
ve.ui.DesktopContext.prototype.onInspectorOpening = function () {
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
ve.ui.DesktopContext.prototype.onInspectorOpen = function () {
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
ve.ui.DesktopContext.prototype.onInspectorClosing = function () {
	this.inspectorClosing = true;
};

/**
 * Handle an inspector that's been closed.
 *
 * @method
 * @param {ve.ui.Inspector} inspector Inspector that's been closed
 * @param {Object} [config] Inspector closing information
 */
ve.ui.DesktopContext.prototype.onInspectorClose = function () {
	this.inspectorClosing = false;
	this.update();
	this.getSurface().getView().focus();
};

/**
 * Updates the context menu.
 *
 * @method
 * @param {boolean} [transition=false] Use a smooth transition
 * @param {boolean} [repositionOnly=false] The context is only being moved so don't fade in
 * @chainable
 */
ve.ui.DesktopContext.prototype.update = function ( transition, repositionOnly ) {
	var i, nodes, tools,
		fragment = this.surface.getModel().getFragment( null, false ),
		selection = fragment.getRange(),
		inspector = this.inspectors.getCurrentWindow();

	if ( inspector && selection && selection.equals( this.selection ) ) {
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
			tools = tools.concat( ve.ui.toolFactory.getToolsForNode( nodes[0].node ) );
		}
		if ( tools.length ) {
			// There's at least one inspectable annotation, build a menu and show it
			this.$menu.empty();
			if ( this.toolbar ) {
				this.toolbar.destroy();
			}
			this.toolbar = new ve.ui.Toolbar( this.surface );
			this.toolbar.setup( [ { 'include': tools } ] );
			this.$menu.append( this.toolbar.$element );
			this.show( transition, repositionOnly );
			this.toolbar.initialize();
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
	var $node, $container, focusableOffset, focusableWidth, nodePosition, cursorPosition, position,
		documentOffset, nodeOffset,
		surface = this.surface.getView(),
		inspector = this.inspectors.getCurrentWindow(),
		focusedNode = surface.getFocusedNode(),
		surfaceOffset = surface.$element.offset(),
		rtl = this.surface.getModel().getDocument().getDir() === 'rtl';

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
			documentOffset = surface.getDocument().getDocumentNode().$element.offset();
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
		if ( cursorPosition ) {
			// Correct for surface offset:
			position = {
				'x': cursorPosition.end.x - surfaceOffset.left,
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
			position.y = this.surface.target.toolbar.$element.height() + this.floatThreshold;
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
 * @param {boolean} [repositionOnly=false] The context is only being moved so don't fade in
 * @chainable
 */
ve.ui.DesktopContext.prototype.show = function ( transition, repositionOnly ) {
	var inspector = this.inspectors.getCurrentWindow(),
		focusedNode = this.surface.getView().getFocusedNode();

	if ( !this.showing && !this.hiding ) {
		this.showing = true;

		// HACK: make the context and popup visibility: hidden; instead of display: none; because
		// they contain inspector iframes, and applying display: none; to those causes them to
		// not load in Firefox
		this.$element.css( 'visibility', '' );
		this.popup.$element.css( 'visibility', '' );
		this.popup.show();

		// Show either inspector or menu
		if ( inspector ) {
			this.$menu.hide();
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
			this.setEmbedded( focusedNode );
			this.popup.useTail( !this.embedded );
			this.$menu.show();
		}

		this.updateDimensions( transition );

		if ( focusedNode ) {
			this.determineFloat();
			this.focusedNodeContentsHeight = focusedNode.getContentsHeight();
		}

		this.visible = true;
		this.showing = false;
	}

	return this;
};

ve.ui.DesktopContext.prototype.setEmbedded = function ( focusedNode ) {
	var targetHeight = this.$menu.outerHeight() * 2,
		targetWidth = this.$menu.outerWidth() * 2,
		embedded = false;

	if (
		focusedNode &&
		targetHeight < Math.max( focusedNode.$focusable.outerHeight(), focusedNode.$shields.height() ) &&
		targetWidth < Math.max( focusedNode.$focusable.outerWidth(),  focusedNode.$shields.width() )
	) {
		embedded = true;
	}

	this.embedded = embedded;
};

/**
 * @inheritdoc
 */
ve.ui.DesktopContext.prototype.hide = function () {
	var inspector = this.inspectors.getCurrentWindow();

	if ( !this.hiding && !this.showing ) {
		this.hiding = true;
		if ( inspector ) {
			inspector.close( { 'action': 'back' } );
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
