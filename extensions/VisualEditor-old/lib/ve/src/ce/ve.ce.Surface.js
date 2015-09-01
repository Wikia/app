/*!
 * VisualEditor ContentEditable Surface class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * ContentEditable surface.
 *
 * @class
 * @extends OO.ui.Element
 * @mixins OO.EventEmitter
 *
 * @constructor
 * @param {jQuery} $container
 * @param {ve.dm.Surface} model Surface model to observe
 * @param {ve.ui.Surface} ui Surface user interface
 * @param {Object} [config] Configuration options
 */
ve.ce.Surface = function VeCeSurface( model, ui, options ) {
	var surface = this;

	// Parent constructor
	OO.ui.Element.call( this, options );

	// Mixin constructors
	OO.EventEmitter.call( this );

	// Properties
	this.surface = ui;
	this.model = model;
	this.documentView = new ve.ce.Document( model.getDocument(), this );
	this.surfaceObserver = new ve.ce.SurfaceObserver( this );
	this.selectionTimeout = null;
	this.$window = this.$( this.getElementWindow() );
	this.$document = this.$( this.getElementDocument() );
	this.$documentNode = this.getDocument().getDocumentNode().$element;
	// Window.getSelection returns a live singleton representing the document's selection
	this.nativeSelection = this.getElementWindow().getSelection();
	this.eventSequencer = new ve.EventSequencer( [
		'keydown', 'keypress', 'keyup',
		'compositionstart', 'compositionend',
		'input'
	] );
	this.clipboard = [];
	this.clipboardId = String( Math.random() );
	this.renderLocks = 0;
	this.dragging = false;
	this.relocatingNode = false;
	this.selecting = false;
	this.resizing = false;
	this.focused = false;
	this.deactivated = false;
	this.$deactivatedSelection = this.$( '<div>' );
	this.activeTableNode = null;
	this.contentBranchNodeChanged = false;
	this.$highlightsFocused = this.$( '<div>' );
	this.$highlightsBlurred = this.$( '<div>' );
	this.$highlights = this.$( '<div>' ).append(
		this.$highlightsFocused, this.$highlightsBlurred
	);
	this.$findResults = this.$( '<div>' );
	this.$dropMarker = this.$( '<div>' ).addClass( 've-ce-focusableNode-dropMarker' );
	this.$lastDropTarget = null;
	this.lastDropPosition = null;
	this.$pasteTarget = this.$( '<div>' );
	this.pasting = false;
	this.copying = false;
	this.pasteSpecial = false;
	this.focusedNode = null;
	// This is set on entering changeModel, then unset when leaving.
	// It is used to test whether a reflected change event is emitted.
	this.newModelSelection = null;
	// These are set during cursor moves (but not text additions/deletions at the cursor)
	this.cursorEvent = null;
	this.cursorStartRange = null;
	this.unicorningNode = null;
	this.setUnicorningRecursionGuard = false;

	this.hasSelectionChangeEvents = 'onselectionchange' in this.getElementDocument();

	// Events
	this.surfaceObserver.connect( this, {
		contentChange: 'onSurfaceObserverContentChange',
		rangeChange: 'onSurfaceObserverRangeChange',
		branchNodeChange: 'onSurfaceObserverBranchNodeChange',
		slugEnter: 'onSurfaceObserverSlugEnter'
	} );
	this.model.connect( this, {
		select: 'onModelSelect',
		documentUpdate: 'onModelDocumentUpdate',
		insertionAnnotationsChange: 'onInsertionAnnotationsChange'
	} );

	this.onDocumentMouseUpHandler = this.onDocumentMouseUp.bind( this );
	this.$documentNode.on( {
		// mouse events shouldn't be sequenced as the event sequencer
		// is detached on blur
		mousedown: this.onDocumentMouseDown.bind( this ),
		// mouseup is bound to the whole document on mousedown
		mousemove: this.onDocumentMouseMove.bind( this ),
		cut: this.onCut.bind( this ),
		copy: this.onCopy.bind( this )
	} );

	this.onWindowResizeHandler = this.onWindowResize.bind( this );
	this.$window.on( 'resize', this.onWindowResizeHandler );

	this.onDocumentFocusInOutHandler = this.onDocumentFocusInOut.bind( this );
	this.$document.on( 'focusin focusout', this.onDocumentFocusInOutHandler );
	// It is possible for a mousedown to clear the selection
	// without triggering a focus change event (e.g. if the
	// document has been programmatically blurred) so trigger
	// a focus change to check if we still have a selection
	this.debounceFocusChange = ve.debounce( this.onFocusChange ).bind( this );
	this.$document.on( 'mousedown', this.debounceFocusChange );

	this.$pasteTarget.on( {
		cut: this.onCut.bind( this ),
		copy: this.onCopy.bind( this ),
		paste: this.onPaste.bind( this )
	} );

	this.$documentNode
		// Bug 65714: MSIE possibly needs `beforepaste` to also be bound; to test.
		.on( 'paste', this.onPaste.bind( this ) )
		.on( 'focus', 'a', function () {
			// Opera <= 12 triggers 'blur' on document node before any link is
			// focused and we don't want that
			surface.$documentNode[0].focus();
		} );

	if ( this.hasSelectionChangeEvents ) {
		this.$document.on( 'selectionchange', this.onDocumentSelectionChange.bind( this ) );
	} else {
		this.$documentNode.on( 'mousemove', this.onDocumentSelectionChange.bind( this ) );
	}

	this.$element.on( {
		dragstart: this.onDocumentDragStart.bind( this ),
		dragover: this.onDocumentDragOver.bind( this ),
		drop: this.onDocumentDrop.bind( this )
	} );

	// Add listeners to the eventSequencer. They won't get called until
	// eventSequencer.attach(node) has been called.
	this.eventSequencer.on( {
		keydown: this.onDocumentKeyDown.bind( this ),
		keyup: this.onDocumentKeyUp.bind( this ),
		keypress: this.onDocumentKeyPress.bind( this ),
		input: this.onDocumentInput.bind( this )
	} ).after( {
		keydown: this.afterDocumentKeyDown.bind( this )
	} );

	// Initialization
	this.$element.addClass( 've-ce-surface' );
	this.$highlights.addClass( 've-ce-surface-highlights' );
	this.$highlightsFocused.addClass( 've-ce-surface-highlights-focused' );
	this.$highlightsBlurred.addClass( 've-ce-surface-highlights-blurred' );
	this.$deactivatedSelection.addClass( 've-ce-surface-deactivatedSelection' );
	this.$pasteTarget.addClass( 've-ce-surface-paste' )
		.attr( 'tabIndex', -1 )
		.prop( 'contentEditable', 'true' );

	// Add elements to the DOM
	this.$element.append( this.$documentNode, this.$pasteTarget );
	this.surface.$blockers.append( this.$highlights );
	this.surface.$selections.append( this.$deactivatedSelection );
};

/* Inheritance */

OO.inheritClass( ve.ce.Surface, OO.ui.Element );

OO.mixinClass( ve.ce.Surface, OO.EventEmitter );

/* Events */

/**
 * @event selectionStart
 */

/**
 * @event selectionEnd
 */

/**
 * @event relocationStart
 */

/**
 * @event relocationEnd
 */

/**
 * When the surface changes its position (only if it happens
 * after initialize has already been called).
 *
 * @event position
 */

/**
 * @event focus
 * Note that it's possible for a focus event to occur immediately after a blur event, if the focus
 * moves to or from a FocusableNode. In this case the surface doesn't lose focus conceptually, but
 * a pair of blur-focus events is emitted anyway.
 */

/**
 * @event blur
 * Note that it's possible for a focus event to occur immediately after a blur event, if the focus
 * moves to or from a FocusableNode. In this case the surface doesn't lose focus conceptually, but
 * a pair of blur-focus events is emitted anyway.
 */

/* Static properties */

/**
 * Attributes considered 'unsafe' for copy/paste
 *
 * These attributes may be dropped by the browser during copy/paste, so
 * any element containing these attributes will have them JSON encoded into
 * data-ve-attributes on copy.
 *
 * @type {string[]}
 */
ve.ce.Surface.static.unsafeAttributes = [
	// RDFa: Firefox ignores these
	'about',
	'content',
	'datatype',
	'property',
	'rel',
	'resource',
	'rev',
	'typeof',
	// CSS: Values are often added or modified
	'style'
];

/* Static methods */

/**
 * When pasting, browsers normalize HTML to varying degrees.
 * This hash creates a comparable string for validating clipboard contents.
 *
 * @param {Node[]} nodes Clipboard HTML nodes
 * @returns {string} Hash
 */
ve.ce.Surface.static.getClipboardHash = function ( nodes ) {
	var i, l, node, hash = '';
	// Collect text contents, or just node name for content-less nodes.
	for ( i = 0, l = nodes.length; i < l; i++ ) {
		node = nodes[i];
		// Only use node types which are know to copy (e.g. not comment nodes)
		if ( node.nodeType === Node.TEXT_NODE ) {
			hash += node.textContent;
		} else if ( node.nodeType === Node.ELEMENT_NODE ) {
			hash += '<' + node.nodeName + '>' + this.getClipboardHash( node.childNodes );
		}
	}
	// Whitespace may be added/removed, so strip it all
	return hash.replace( /\s/gm, '' );
};

/* Methods */

/**
 * Destroy the surface, removing all DOM elements.
 *
 * @method
 */
ve.ce.Surface.prototype.destroy = function () {
	var documentNode = this.documentView.getDocumentNode();

	// Detach observer and event sequencer
	this.surfaceObserver.detach();
	this.eventSequencer.detach();

	// Make document node not live
	documentNode.setLive( false );

	// Disconnect events
	this.surfaceObserver.disconnect( this );
	this.model.disconnect( this );

	// Disconnect DOM events on the document
	this.$document.off( 'focusin focusout', this.onDocumentFocusInOutHandler );
	this.$document.off( 'mousedown', this.documentFocusChangeHandler );

	// Disconnect DOM events on the window
	this.$window.off( 'resize', this.onWindowResizeHandler );

	// HACK: Blur to make selection/cursor disappear (needed in Firefox in some cases)
	this.$documentNode[0].blur();

	// Remove DOM elements (also disconnects their events)
	this.$element.remove();
	this.$highlights.remove();
};

/**
 * Get linear model offset from absolute coords
 *
 * @param {number} x X offset
 * @param {number} y Y offset
 * @return {number} Linear model offset, or -1 if coordinates are out of bounds
 */
ve.ce.Surface.prototype.getOffsetFromCoords = function ( x, y ) {
	var offset, caretPosition, range, textRange, $marker,
		doc = this.getElementDocument();

	try {
		if ( doc.caretPositionFromPoint ) {
			// Gecko
			// http://dev.w3.org/csswg/cssom-view/#extensions-to-the-document-interface
			caretPosition = document.caretPositionFromPoint( x, y );
			offset = ve.ce.getOffset( caretPosition.offsetNode, caretPosition.offset );
		} else if ( doc.caretRangeFromPoint ) {
			// Webkit
			// http://www.w3.org/TR/2009/WD-cssom-view-20090804/
			range = document.caretRangeFromPoint( x, y );
			offset = ve.ce.getOffset( range.startContainer, range.startOffset );
		} else if ( document.body.createTextRange ) {
			// Trident
			// http://msdn.microsoft.com/en-gb/library/ie/ms536632(v=vs.85).aspx
			textRange = document.body.createTextRange();
			textRange.moveToPoint( x, y );
			textRange.pasteHTML( '<span class="ve-ce-textRange-drop-marker">&nbsp;</span>' );
			$marker = this.$( '.ve-ce-textRange-drop-marker' );
			offset = ve.ce.getOffset( $marker.get( 0 ), 0 );
			$marker.remove();
		}
		return offset;
	} catch ( e ) {
		// Both ve.ce.getOffset and TextRange.moveToPoint can throw out of bounds exceptions
		return -1;
	}
};

/**
 * Get a client rect from the range's end node
 *
 * This function is used internally by getSelectionRects and
 * getSelectionBoundingRect as a fallback when Range.getClientRects
 * fails. The width is hard-coded to 0 as the function is used to
 * locate the selection focus position.
 *
 * @private
 * @param {Range} range Range to get client rect for
 * @return {Object} ClientRect-like object
 */
ve.ce.Surface.prototype.getNodeClientRectFromRange = function ( range ) {
	var rect, side, x, adjacentNode, unicornRect,
		node = range.endContainer;

	while ( node && node.nodeType !== Node.ELEMENT_NODE ) {
		node = node.parentNode;
	}

	if ( !node ) {
		return null;
	}

	// When possible, pretend the cursor is the left/right border of the node
	// (depending on directionality) as a fallback.

	// We would use getBoundingClientRect(), but in iOS7 that's relative to the
	// document rather than to the viewport
	rect = node.getClientRects()[0];
	if ( !rect ) {
		// FF can return null when focusNode is invisible
		return null;
	}

	side = this.getModel().getDocument().getDir() === 'rtl' ? 'right' : 'left';
	adjacentNode = range.endContainer.childNodes[ range.endOffset ];
	if ( range.collapsed && $( adjacentNode ).hasClass( 've-ce-unicorn' ) ) {
		// We're next to a unicorn; use its left/right position
		unicornRect = adjacentNode.getClientRects()[0];
		if ( !unicornRect ) {
			return null;
		}
		x = unicornRect[ side ];
	} else {
		x = rect[ side ];
	}

	return {
		top: rect.top,
		bottom: rect.bottom,
		left: x,
		right: x,
		width: 0,
		height: rect.height
	};
};

/**
 * Get the rectangles of the selection relative to the surface.
 *
 * @method
 * @param {ve.dm.Selection} [selection] Optional selection to get the rectangles for, defaults to current selection
 * @returns {Object[]|null} Selection rectangles
 */
ve.ce.Surface.prototype.getSelectionRects = function ( selection ) {
	var i, l, range, nativeRange, surfaceRect, focusedNode, rect,
		rects = [],
		relativeRects = [];

	selection = selection || this.getModel().getSelection();
	if ( !( selection instanceof ve.dm.LinearSelection ) ) {
		return null;
	}

	range = selection.getRange();
	focusedNode = this.getFocusedNode( range );

	if ( focusedNode ) {
		return focusedNode.getRects();
	}

	nativeRange = this.getNativeRange( range );
	if ( !nativeRange ) {
		return null;
	}

	// Calling getClientRects sometimes fails:
	// * in Firefox on page load when the address bar is still focused
	// * in empty paragraphs
	try {
		rects = RangeFix.getClientRects( nativeRange );
		if ( !rects.length ) {
			throw new Error( 'getClientRects returned empty list' );
		}
	} catch ( e ) {
		rect = this.getNodeClientRectFromRange( nativeRange );
		if ( rect ) {
			rects = [ rect ];
		}
	}

	surfaceRect = this.getSurface().getBoundingClientRect();
	if ( !rects || !surfaceRect ) {
		return null;
	}

	for ( i = 0, l = rects.length; i < l; i++ ) {
		relativeRects.push( ve.translateRect( rects[i], -surfaceRect.left, -surfaceRect.top ) );
	}
	return relativeRects;
};

/**
 * Get the start and end rectangles of the selection relative to the surface.
 *
 * @method
 * @param {ve.dm.Selection} [selection] Optional selection to get the rectangles for, defaults to current selection
 * @returns {Object|null} Start and end selection rectangles
 */
ve.ce.Surface.prototype.getSelectionStartAndEndRects = function ( selection ) {
	var range, focusedNode;

	selection = selection || this.getModel().getSelection();
	if ( !( selection instanceof ve.dm.LinearSelection ) ) {
		return null;
	}

	range = selection.getRange();
	focusedNode = this.getFocusedNode( range );

	if ( focusedNode ) {
		return focusedNode.getStartAndEndRects();
	}

	return ve.getStartAndEndRects( this.getSelectionRects() );
};

/**
 * Get the coordinates of the selection's bounding rectangle relative to the surface.
 *
 * Returned coordinates are relative to the surface.
 *
 * @method
 * @param {ve.dm.Selection} [selection] Optional selection to get the rectangles for, defaults to current selection
 * @returns {Object|null} Selection rectangle, with keys top, bottom, left, right, width, height
 */
ve.ce.Surface.prototype.getSelectionBoundingRect = function ( selection ) {
	var range, nativeRange, boundingRect, surfaceRect, focusedNode;

	selection = selection || this.getModel().getSelection();
	if ( !( selection instanceof ve.dm.LinearSelection ) ) {
		return null;
	}

	range = selection.getRange();
	focusedNode = this.getFocusedNode( range );

	if ( focusedNode ) {
		return focusedNode.getBoundingRect();
	}

	nativeRange = this.getNativeRange( range );
	if ( !nativeRange ) {
		return null;
	}

	try {
		boundingRect = RangeFix.getBoundingClientRect( nativeRange );
		if ( !boundingRect ) {
			throw new Error( 'getBoundingClientRect returned null' );
		}
	} catch ( e ) {
		boundingRect = this.getNodeClientRectFromRange( nativeRange );
	}

	surfaceRect = this.getSurface().getBoundingClientRect();
	if ( !boundingRect || !surfaceRect ) {
		return null;
	}
	return ve.translateRect( boundingRect, -surfaceRect.left, -surfaceRect.top );
};

/*! Initialization */

/**
 * Initialize surface.
 *
 * This should be called after the surface has been attached to the DOM.
 *
 * @method
 */
ve.ce.Surface.prototype.initialize = function () {
	this.documentView.getDocumentNode().setLive( true );
	// Turn off native object editing. This must be tried after the surface has been added to DOM.
	try {
		this.$document[0].execCommand( 'enableObjectResizing', false, false );
		this.$document[0].execCommand( 'enableInlineTableEditing', false, false );
	} catch ( e ) { /* Silently ignore */ }
};

/**
 * Enable editing.
 *
 * @method
 */
ve.ce.Surface.prototype.enable = function () {
	this.documentView.getDocumentNode().enable();
};

/**
 * Disable editing.
 *
 * @method
 */
ve.ce.Surface.prototype.disable = function () {
	this.documentView.getDocumentNode().disable();
};

/**
 * Give focus to the surface, reapplying the model selection, or selecting the first content offset
 * if the model selection is null.
 *
 * This is used when switching between surfaces, e.g. when closing a dialog window. Calling this
 * function will also reapply the selection, even if the surface is already focused.
 */
ve.ce.Surface.prototype.focus = function () {
	var node,
		surface = this,
		selection = this.getModel().getSelection();

	// Focus the documentNode for text selections, or the pasteTarget for focusedNode selections
	if ( this.focusedNode || selection instanceof ve.dm.TableSelection ) {
		this.$pasteTarget[0].focus();
	} else if ( selection instanceof ve.dm.LinearSelection ) {
		node = this.getDocument().getNodeAndOffset( selection.getRange().start ).node;
		$( node ).closest( '[contenteditable=true]' )[0].focus();
	} else if ( selection instanceof ve.dm.NullSelection ) {
		this.getModel().selectFirstContentOffset();
		return;
	}

	// If we are calling focus after replacing a node the selection may be gone
	// but onDocumentFocus won't fire so restore the selection here too.
	this.onModelSelect();
	setTimeout( function () {
		// In some browsers (e.g. Chrome) giving the document node focus doesn't
		// necessarily give you a selection (e.g. if the first child is a <figure>)
		// so if the surface isn't 'focused' (has no selection) give it a selection
		// manually
		// TODO: rename isFocused and other methods to something which reflects
		// the fact they actually mean "has a native selection"
		if ( !surface.isFocused() ) {
			surface.getModel().selectFirstContentOffset();
		}
	} );
	// onDocumentFocus takes care of the rest
};

/**
 * Handler for focusin and focusout events. Filters events and debounces to #onFocusChange.
 * @param {jQuery.Event} e focusin/out event
 */
ve.ce.Surface.prototype.onDocumentFocusInOut = function ( e ) {
	// Filter out focusin/out events on iframes
	// IE11 emits these when the focus moves into/out of an iframed document,
	// but these events are misleading because the focus in this document didn't
	// actually move.
	if ( e.target.nodeName.toLowerCase() === 'iframe' ) {
		return;
	}
	this.debounceFocusChange();
};

/**
 * Handle global focus change.
 */
ve.ce.Surface.prototype.onFocusChange = function () {
	var hasFocus = false;

	hasFocus = OO.ui.contains(
		[
			this.$documentNode[0],
			this.$pasteTarget[0]
		],
		this.nativeSelection.anchorNode,
		true
	);

	if ( this.deactivated ) {
		if ( OO.ui.contains( this.$documentNode[0], this.nativeSelection.anchorNode, true ) ) {
			this.onDocumentFocus();
		}
	} else {
		if ( hasFocus && !this.isFocused() ) {
			this.onDocumentFocus();
		}
		if ( !hasFocus && this.isFocused() ) {
			this.onDocumentBlur();
		}
	}
};

/**
 * Deactivate the surface, stopping the surface observer and replacing the native
 * range with a fake rendered one.
 *
 * Used by dialogs so they can take focus without losing the original document selection.
 */
ve.ce.Surface.prototype.deactivate = function () {
	if ( !this.deactivated ) {
		// Disable the surface observer, there can be no observeable changes
		// until the surface is activated
		this.surfaceObserver.disable();
		this.deactivated = true;
		// Remove ranges so the user can't accidentally type into the document
		this.nativeSelection.removeAllRanges();
		this.updateDeactivatedSelection();
	}
};

/**
 * Reactivate the surface and restore the native selection
 */
ve.ce.Surface.prototype.activate = function () {
	if ( this.deactivated ) {
		this.deactivated = false;
		this.updateDeactivatedSelection();
		this.surfaceObserver.enable();
		if ( OO.ui.contains( this.$documentNode[0], this.nativeSelection.anchorNode, true ) ) {
			// The selection has been placed back in the document, either by the user clicking
			// or by the closing window updating the model. Poll in case it was the user clicking.
			this.surfaceObserver.pollOnce();
		} else {
			// Clear focused node so onModelSelect re-selects it if necessary
			this.focusedNode = null;
			this.onModelSelect();
		}
	}
};

/**
 * Update the fake selection while the surface is deactivated.
 *
 * While the surface is deactivated, all calls to showSelection will get redirected here.
 */
ve.ce.Surface.prototype.updateDeactivatedSelection = function () {
	var i, l, rects,
		selection = this.getModel().getSelection();

	this.$deactivatedSelection.empty();

	if ( !this.deactivated || this.focusedNode || !( selection instanceof ve.dm.LinearSelection ) ) {
		return;
	}
	rects = this.getSelectionRects( selection );
	if ( rects ) {
		for ( i = 0, l = rects.length; i < l; i++ ) {
			this.$deactivatedSelection.append( this.$( '<div>' ).css( {
				top: rects[i].top,
				left: rects[i].left,
				width: rects[i].width,
				height: rects[i].height
			} ) );
		}
	}
};

/**
 * Handle document focus events.
 *
 * This is triggered by a global focusin/focusout event noticing a selection on the document.
 *
 * @method
 * @fires focus
 */
ve.ce.Surface.prototype.onDocumentFocus = function () {
	if ( this.getModel().getSelection().isNull() ) {
		// If the document is being focused by a non-mouse/non-touch user event,
		// find the first content offset and place the cursor there.
		this.getModel().selectFirstContentOffset();
	}
	this.eventSequencer.attach( this.$element );
	this.surfaceObserver.startTimerLoop();
	this.focused = true;
	this.activate();
	this.emit( 'focus' );
};

/**
 * Handle document blur events.
 *
 * This is triggered by a global focusin/focusout event noticing no selection on the document.
 *
 * @method
 * @fires blur
 */
ve.ce.Surface.prototype.onDocumentBlur = function () {
	this.eventSequencer.detach();
	this.surfaceObserver.stopTimerLoop();
	this.surfaceObserver.pollOnce();
	this.surfaceObserver.clear();
	this.dragging = false;
	this.focused = false;
	if ( this.focusedNode ) {
		this.focusedNode.setFocused( false );
		this.focusedNode = null;
	}
	this.getModel().setNullSelection();
	this.emit( 'blur' );
};

/**
 * Check if surface is focused.
 *
 * @returns {boolean} Surface is focused
 */
ve.ce.Surface.prototype.isFocused = function () {
	return this.focused;
};

/**
 * Handle document mouse down events.
 *
 * @method
 * @param {jQuery.Event} e Mouse down event
 */
ve.ce.Surface.prototype.onDocumentMouseDown = function ( e ) {
	if ( e.which !== 1 ) {
		return;
	}

	// Remember the mouse is down
	this.dragging = true;

	// Bind mouseup to the whole document in case of dragging out of the surface
	this.$document.on( 'mouseup', this.onDocumentMouseUpHandler );

	this.surfaceObserver.stopTimerLoop();
	// In some browsers the selection doesn't change until after the event
	// so poll in the 'after' function
	setTimeout( this.afterDocumentMouseDown.bind( this, e, this.getModel().getSelection() ) );

	// Handle triple click
	// HACK: do not do triple click handling in IE, because their click counting is broken
	if ( e.originalEvent.detail >= 3 && !ve.init.platform.constructor.static.isInternetExplorer() ) {
		// Browser default behaviour for triple click won't behave as we want
		e.preventDefault();

		this.getModel().getFragment().expandLinearSelection( 'closest', ve.dm.BranchNode ).adjustLinearSelection( 1, -1 ).select();
	}
};

/**
 * Deferred until after document mouse down
 *
 * @param {jQuery.Event} e Mouse down event
 * @param {ve.dm.Selection} selectionBefore Selection before the mouse event
 */
ve.ce.Surface.prototype.afterDocumentMouseDown = function ( e, selectionBefore ) {
	// TODO: guard with incRenderLock?
	this.surfaceObserver.pollOnce();
	if ( e.shiftKey ) {
		this.fixShiftClickSelect( selectionBefore );
	}
};

/**
 * Handle document mouse up events.
 *
 * @method
 * @param {jQuery.Event} e Mouse up event
 * @fires selectionEnd
 */
ve.ce.Surface.prototype.onDocumentMouseUp = function ( e ) {
	this.$document.off( 'mouseup', this.onDocumentMouseUpHandler );
	this.surfaceObserver.startTimerLoop();
	// In some browsers the selection doesn't change until after the event
	// so poll in the 'after' function
	setTimeout( this.afterDocumentMouseUp.bind( this, e, this.getModel().getSelection() ) );
};

/**
 * Deferred until after document mouse up
 *
 * @param {jQuery.Event} e Mouse up event
 * @param {ve.dm.Selection} selectionBefore Selection before the mouse event
 */
ve.ce.Surface.prototype.afterDocumentMouseUp = function ( e, selectionBefore ) {
	// TODO: guard with incRenderLock?
	this.surfaceObserver.pollOnce();
	if ( e.shiftKey ) {
		this.fixShiftClickSelect( selectionBefore );
	}
	if ( !e.shiftKey && this.selecting ) {
		this.emit( 'selectionEnd' );
		this.selecting = false;
	}
	this.dragging = false;
};

/**
 * Fix shift-click selection
 *
 * When shift-clicking on links Chrome tries to collapse the selection
 * so check for this and fix manually.
 *
 * This can occur on mousedown or, if the existing selection covers the
 * link, on mouseup.
 *
 * https://code.google.com/p/chromium/issues/detail?id=345745
 *
 * @param {ve.dm.Selection} selectionBefore Selection before the mouse event
 */
ve.ce.Surface.prototype.fixShiftClickSelect = function ( selectionBefore ) {
	if ( !( selectionBefore instanceof ve.dm.LinearSelection ) ) {
		return;
	}
	var newSelection = this.getModel().getSelection();
	if ( newSelection.isCollapsed() && !newSelection.equals( selectionBefore ) ) {
		this.getModel().setLinearSelection( new ve.Range( selectionBefore.getRange().from, newSelection.getRange().to ) );
	}
};

/**
 * Handle document mouse move events.
 *
 * @method
 * @param {jQuery.Event} e Mouse move event
 * @fires selectionStart
 */
ve.ce.Surface.prototype.onDocumentMouseMove = function () {
	// Detect beginning of selection by moving mouse while dragging
	if ( this.dragging && !this.selecting ) {
		this.selecting = true;
		this.emit( 'selectionStart' );
	}
};

/**
 * Handle document selection change events.
 *
 * @method
 * @param {jQuery.Event} e Selection change event
 */
ve.ce.Surface.prototype.onDocumentSelectionChange = function () {
	if ( !this.dragging ) {
		// Optimisation
		return;
	}

	this.surfaceObserver.pollOnceSelection();
};

/**
 * Handle document drag start events.
 *
 * @method
 * @param {jQuery.Event} e Drag start event
 */
ve.ce.Surface.prototype.onDocumentDragStart = function ( e ) {
	var dataTransfer = e.originalEvent.dataTransfer;
	try {
		dataTransfer.setData( 'application-x/VisualEditor', JSON.stringify( this.getModel().getSelection() ) );
	} catch ( err ) {
		// IE doesn't support custom data types, but overwriting the actual drag data should be avoided
		// TODO: Do this with an internal state to avoid overwriting drag data even in IE
		dataTransfer.setData( 'text', '__ve__' + JSON.stringify( this.getModel().getSelection() ) );
	}
};

/**
 * Handle document drag over events.
 *
 * @method
 * @param {jQuery.Event} e Drag over event
 */
ve.ce.Surface.prototype.onDocumentDragOver = function ( e ) {
	if ( !this.relocatingNode ) {
		return;
	}
	var $target, $dropTarget, node, dropPosition, nodeType, inHandlesOwnChildren;

	if ( !this.relocatingNode.isContent() ) {
		e.preventDefault();
		$target = $( e.target ).closest( '.ve-ce-branchNode, .ve-ce-leafNode' );
		if ( $target.length ) {
			// Find the nearest node which will accept this node type
			nodeType = this.relocatingNode.getType();
			node = $target.data( 'view' );
			while ( node.parent && !node.parent.isAllowedChildNodeType( nodeType ) ) {
				node = node.parent;
			}
			if ( node.parent ) {
				inHandlesOwnChildren = false;
				node.parent.traverseUpstream( function ( n ) {
					if ( n.handlesOwnChildren() ) {
						inHandlesOwnChildren = true;
						return false;
					}
				} );
			}
			if ( node.parent && !inHandlesOwnChildren ) {
				$dropTarget = node.$element;
				dropPosition = e.originalEvent.pageY - $dropTarget.offset().top > $dropTarget.outerHeight() / 2 ? 'bottom' : 'top';
			} else {
				$dropTarget = this.$lastDropTarget;
				dropPosition = this.lastDropPosition;
			}
		}
		if ( this.$lastDropTarget && (
			!this.$lastDropTarget.is( $dropTarget ) || dropPosition !== this.lastDropPosition
		) ) {
			this.$dropMarker.detach();
			$dropTarget = null;
		}
		if ( $dropTarget && (
			!$dropTarget.is( this.$lastDropTarget ) || dropPosition !== this.lastDropPosition
		) ) {
			this.$dropMarker.width( $dropTarget.width() );
			if ( dropPosition === 'top' ) {
				this.$dropMarker.insertBefore( $dropTarget );
			} else {
				this.$dropMarker.insertAfter( $dropTarget );
			}
		}
		if ( $dropTarget !== undefined ) {
			this.$lastDropTarget = $dropTarget;
			this.lastDropPosition = dropPosition;
		}
	}
	if ( this.selecting ) {
		this.emit( 'selectionEnd' );
		this.selecting = false;
		this.dragging = false;
	}
};

/**
 * Handle document drop events.
 *
 * Limits native drag and drop behaviour.
 *
 * @method
 * @param {jQuery.Event} e Drop event
 */
ve.ce.Surface.prototype.onDocumentDrop = function ( e ) {
	// Properties may be nullified by other events, so cache before setTimeout
	var selectionJSON, dragSelection, dragRange, originFragment, originData,
		targetRange, targetOffset, targetFragment, dragHtml, dragText,
		i, l, name, insert,
		fileHandlers = [],
		dataTransfer = e.originalEvent.dataTransfer,
		$dropTarget = this.$lastDropTarget,
		dropPosition = this.lastDropPosition;

	// Prevent native drop event from modifying view
	e.preventDefault();

	try {
		selectionJSON = dataTransfer.getData( 'application-x/VisualEditor' );
	} catch ( err ) {
		selectionJSON = dataTransfer.getData( 'text' );
		if ( selectionJSON.slice( 0, 6 ) === '__ve__' ) {
			selectionJSON = selectionJSON.slice( 6 );
		} else {
			selectionJSON = null;
		}
	}

	if ( this.relocatingNode ) {
		dragRange = this.relocatingNode.getModel().getOuterRange();
	} else if ( selectionJSON ) {
		dragSelection = ve.dm.Selection.static.newFromJSON( this.getModel().getDocument(), selectionJSON );
		if ( dragSelection instanceof ve.dm.LinearSelection ) {
			dragRange = dragSelection.getRange();
		}
	} else if ( dataTransfer.files.length ) {
		for ( i = 0, l = dataTransfer.files.length; i < l; i++ ) {
			name = ve.ui.fileDropHandlerFactory.getHandlerNameForType( dataTransfer.files[i].type );
			if ( name ) {
				fileHandlers.push(
					ve.ui.fileDropHandlerFactory.create( name, this.surface, dataTransfer.files[i] )
				);
			}
		}
	} else {
		try {
			dragHtml = dataTransfer.getData( 'text/html' );
			if ( !dragHtml ) {
				dragText = dataTransfer.getData( 'text/plain' );
			}
		} catch ( err ) {
			dragText = dataTransfer.getData( 'text' );
		}
	}

	if ( ( dragRange && !dragRange.isCollapsed() ) || fileHandlers.length || dragHtml || dragText  ) {
		if ( this.relocatingNode && !this.relocatingNode.getModel().isContent() ) {
			// Block level drag and drop: use the lastDropTarget to get the targetOffset
			if ( $dropTarget ) {
				targetRange = $dropTarget.data( 'view' ).getModel().getOuterRange();
				if ( dropPosition === 'top' ) {
					targetOffset = targetRange.start;
				} else {
					targetOffset = targetRange.end;
				}
			} else {
				return;
			}
		} else {
			targetOffset = this.getOffsetFromCoords(
				e.originalEvent.pageX - this.$document.scrollLeft(),
				e.originalEvent.pageY - this.$document.scrollTop()
			);
			if ( targetOffset === -1 ) {
				return;
			}
		}

		targetFragment = this.getModel().getLinearFragment( new ve.Range( targetOffset ) );

		if ( dragRange ) {
			// Get a fragment and data of the node being dragged
			originFragment = this.getModel().getLinearFragment( dragRange );
			originData = originFragment.getData();

			// Remove node from old location
			originFragment.removeContent();

			// Re-insert data at new location
			targetFragment.insertContent( originData );
		} else if ( fileHandlers.length ) {
			insert = function ( docOrData ) {
				if ( docOrData instanceof ve.dm.Document ) {
					targetFragment.collapseToEnd().insertDocument( docOrData );
				} else {
					targetFragment.collapseToEnd().insertContent( docOrData );
				}
			};
			for ( i = 0, l = fileHandlers.length; i < l; i++ ) {
				fileHandlers[i].getInsertableData().done( insert );
			}
		} else if ( dragHtml ) {
			targetFragment.insertHtml( dragHtml, this.getSurface().getImportRules() );
		} else if ( dragText ) {
			targetFragment.insertContent( dragText );
		}
	}
	this.endRelocation();
};

/**
 * Handle document key down events.
 *
 * @method
 * @param {jQuery.Event} e Key down event
 * @fires selectionStart
 */
ve.ce.Surface.prototype.onDocumentKeyDown = function ( e ) {
	var trigger, focusedNode,
		selection = this.getModel().getSelection(),
		updateFromModel = false;

	if ( selection instanceof ve.dm.NullSelection ) {
		return;
	}

	if ( e.which === 229 ) {
		// Ignore fake IME events (emitted in IE and Chromium)
		return;
	}

	this.surfaceObserver.stopTimerLoop();
	this.incRenderLock();
	try {
		// TODO: is this correct?
		this.surfaceObserver.pollOnce();
	} finally {
		this.decRenderLock();
	}

	this.storeKeyDownState( e );

	switch ( e.keyCode ) {
		case OO.ui.Keys.LEFT:
		case OO.ui.Keys.RIGHT:
		case OO.ui.Keys.UP:
		case OO.ui.Keys.DOWN:
			if ( !this.dragging && !this.selecting && e.shiftKey ) {
				this.selecting = true;
				this.emit( 'selectionStart' );
			}

			if ( selection instanceof ve.dm.LinearSelection ) {
				if ( e.keyCode === OO.ui.Keys.LEFT || e.keyCode === OO.ui.Keys.RIGHT ) {
					this.handleLinearLeftOrRightArrowKey( e );
				} else {
					this.handleLinearUpOrDownArrowKey( e );
					updateFromModel = true;
				}
			} else if ( selection instanceof ve.dm.TableSelection ) {
				this.handleTableArrowKey( e );
			}
			break;
		case OO.ui.Keys.END:
		case OO.ui.Keys.HOME:
		case OO.ui.Keys.PAGEUP:
		case OO.ui.Keys.PAGEDOWN:
			if ( selection instanceof ve.dm.TableSelection ) {
				this.handleTableArrowKey( e );
			}
			break;
		case OO.ui.Keys.ENTER:
			e.preventDefault();
			focusedNode = this.getFocusedNode();
			if ( focusedNode ) {
				focusedNode.executeCommand();
			} else if ( selection instanceof ve.dm.LinearSelection ) {
				this.handleLinearEnter( e );
				updateFromModel = true;
			} else if ( selection instanceof ve.dm.TableSelection ) {
				this.handleTableEnter( e );
			}
			break;
		case OO.ui.Keys.BACKSPACE:
		case OO.ui.Keys.DELETE:
			e.preventDefault();
			if ( selection instanceof ve.dm.LinearSelection ) {
				this.handleLinearDelete( e );
				updateFromModel = true;
			} else if ( selection instanceof ve.dm.TableSelection ) {
				this.handleTableDelete( e );
			}
			break;
		case OO.ui.Keys.ESCAPE:
			if ( this.getActiveTableNode() ) {
				this.handleTableEditingEscape( e );
			}
			break;
		default:
			trigger = new ve.ui.Trigger( e );
			if ( trigger.isComplete() && this.surface.execute( trigger ) ) {
				e.preventDefault();
				e.stopPropagation();
				updateFromModel = true;
			}
			break;
	}
	if ( !updateFromModel ) {
		this.incRenderLock();
	}
	try {
		this.surfaceObserver.pollOnce();
	} finally {
		if ( !updateFromModel ) {
			this.decRenderLock();
		}
	}
	this.surfaceObserver.startTimerLoop();
};

/**
 * Handle document key press events.
 *
 * @method
 * @param {jQuery.Event} e Key press event
 */
ve.ce.Surface.prototype.onDocumentKeyPress = function ( e ) {
	// Filter out non-character keys. Doing this prevents:
	// * Unexpected content deletion when selection is not collapsed and the user presses, for
	//   example, the Home key (Firefox fires 'keypress' for it)
	// TODO: Should be covered with Selenium tests.
	if (
		// Catches most keys that don't produce output (charCode === 0, thus no character)
		e.which === 0 || e.charCode === 0 ||
		// Opera 12 doesn't always adhere to that convention
		e.keyCode === OO.ui.Keys.TAB || e.keyCode === OO.ui.Keys.ESCAPE ||
		// Ignore all keypresses with Ctrl / Cmd modifier keys
		ve.ce.isShortcutKey( e )
	) {
		return;
	}

	this.handleInsertion();
};

/**
 * Deferred until after document key down event
 *
 * @param {jQuery.Event} e keydown event
 */
ve.ce.Surface.prototype.afterDocumentKeyDown = function ( e ) {
	var fixupCursor;
	if ( e !== this.cursorEvent ) {
		return;
	}
	fixupCursor = (
		!e.shiftKey &&
		( e.keyCode === OO.ui.Keys.LEFT || e.keyCode === OO.ui.Keys.RIGHT )
	);
	this.incRenderLock();
	try {
		this.surfaceObserver.pollOnce();
	} finally {
		this.decRenderLock();
	}
	this.checkUnicorns( fixupCursor );
};

/**
 * Check whether the selection has moved out of the unicorned area (i.e. is not currently between
 * two unicorns) and if so, destroy the unicorns. If there are no active unicorns, this function
 * does nothing.
 *
 * If the unicorns are destroyed as a consequence of the user moving the cursor across a unicorn
 * with the arrow keys, the cursor will have to be moved again to produce the cursor movement
 * the user expected. Set the fixupCursor parameter to true to enable this behavior.
 *
 * @param {boolean} fixupCursor If destroying unicorns, fix the cursor position for expected movement
 */
ve.ce.Surface.prototype.checkUnicorns = function ( fixupCursor ) {
	var preUnicorn, postUnicorn, range, node, fixup;
	if ( !this.unicorningNode || !this.unicorningNode.unicorns ) {
		return;
	}
	preUnicorn = this.unicorningNode.unicorns[ 0 ];
	postUnicorn = this.unicorningNode.unicorns[ 1 ];

	if ( this.nativeSelection.rangeCount === 0 ) {
		// XXX do we want to clear unicorns in this case?
		return;
	}
	range = this.nativeSelection.getRangeAt( 0 );

	// Test whether the selection endpoint is between unicorns. If so, do nothing.
	// Unicorns can only contain text, so just move backwards until we hit a non-text node.
	node = range.endContainer;
	if ( node.nodeType === Node.ELEMENT_NODE ) {
		node = range.endOffset > 0 ? node.childNodes[ range.endOffset - 1 ] : null;
	}
	while ( node !== null && node.nodeType === Node.TEXT_NODE ) {
		node = node.previousSibling;
	}
	if ( node === preUnicorn ) {
		return;
	}

	// Selection endpoint is not between unicorns.
	// Test whether it is before or after the pre-unicorn (i.e. before/after both unicorns)
	if ( ve.compareDocumentOrder(
		range.endContainer,
		range.endOffset,
		preUnicorn.parentNode,
		Array.prototype.indexOf.call( preUnicorn.parentNode.childNodes, preUnicorn )
	) < 0 ) {
		// before the pre-unicorn
		fixup = -1;
	} else {
		// at or after the pre-unicorn (actually must be after the post-unicorn)
		fixup = 1;
	}
	if ( fixupCursor ) {
		this.incRenderLock();
		try {
			this.moveModelCursor( fixup );
		} finally {
			this.decRenderLock();
		}
	}
	this.renderSelectedContentBranchNode();
	this.showSelection( this.getModel().getSelection() );
};

/**
 * Handle document key up events.
 *
 * @method
 * @param {jQuery.Event} e Key up event
 * @fires selectionEnd
 */
ve.ce.Surface.prototype.onDocumentKeyUp = function ( e ) {
	// Detect end of selecting by letting go of shift
	if ( !this.dragging && this.selecting && e.keyCode === OO.ui.Keys.SHIFT ) {
		this.selecting = false;
		this.emit( 'selectionEnd' );
	}

	var nativeRange, clientRect, scrollTo;

	if ( !this.surface.toolbarHeight ) {
		return;
	}

	nativeRange = this.getNativeRange();
	if ( !nativeRange ) {
		return null;
	}

	clientRect = RangeFix.getBoundingClientRect( nativeRange );

	if ( clientRect && clientRect.top < this.surface.toolbarHeight ) {
		scrollTo = this.$window.scrollTop() + clientRect.top - this.surface.toolbarHeight;
		this.$window.scrollTop( scrollTo );
	}
};

/**
 * Handle cut events.
 *
 * @method
 * @param {jQuery.Event} e Cut event
 */
ve.ce.Surface.prototype.onCut = function ( e ) {
	var surface = this;
	this.onCopy( e );
	setTimeout( function () {
		surface.getModel().getFragment().delete().select();
	} );
};

/**
 * Handle copy events.
 *
 * @method
 * @param {jQuery.Event} e Copy event
 */
ve.ce.Surface.prototype.onCopy = function ( e ) {
	var originalRange,
		clipboardIndex, clipboardItem, pasteData,
		scrollTop, unsafeSelector, range, slice,
		selection = this.getModel().getSelection(),
		view = this,
		htmlDoc = this.getModel().getDocument().getHtmlDocument(),
		clipboardData = e.originalEvent.clipboardData;

	if ( selection instanceof ve.dm.LinearSelection ||
		( selection instanceof ve.dm.TableSelection && selection.isSingleCell() )
	) {
		range = selection.getRanges()[0];
	} else {
		return;
	}

	slice = this.model.documentModel.cloneSliceFromRange( range );

	this.$pasteTarget.empty();

	pasteData = slice.data.clone();

	// Clone the elements in the slice
	slice.data.cloneElements( true );

	ve.dm.converter.getDomSubtreeFromModel( slice, this.$pasteTarget[0], true );

	// Some browsers strip out spans when they match the styling of the
	// paste target (e.g. plain spans) so we must protect against this
	// by adding a dummy class, which we can remove after paste.
	this.$pasteTarget.find( 'span' ).addClass( 've-pasteProtect' );

	// href absolutization either doesn't occur (because we copy HTML to the clipboard
	// directly with clipboardData#setData) or it resolves against the wrong document
	// (window.document instead of ve.dm.Document#getHtmlDocument) so do it manually
	// with ve#resolveUrl
	this.$pasteTarget.find( 'a' ).attr( 'href', function ( i, href ) {
		return ve.resolveUrl( href, htmlDoc );
	} );

	// Some attributes (e.g RDFa attributes in Firefox) aren't preserved by copy
	unsafeSelector = '[' + ve.ce.Surface.static.unsafeAttributes.join( '],[') + ']';
	this.$pasteTarget.find( unsafeSelector ).each( function () {
		var i, val,
			attrs = {}, ua = ve.ce.Surface.static.unsafeAttributes;

		i = ua.length;
		while ( i-- ) {
			val = this.getAttribute( ua[i] );
			if ( val !== null ) {
				attrs[ua[i]] = val;
			}
		}
		this.setAttribute( 'data-ve-attributes', JSON.stringify( attrs ) );
	} );

	clipboardItem = { slice: slice, hash: null };
	clipboardIndex = this.clipboard.push( clipboardItem ) - 1;

	// Check we have a W3C clipboardData API
	if (
		clipboardData && clipboardData.items
	) {
		// Webkit allows us to directly edit the clipboard
		// Disable the default event so we can override the data
		e.preventDefault();

		clipboardData.setData( 'text/xcustom', this.clipboardId + '-' + clipboardIndex );
		// As we've disabled the default event we need to set the normal clipboard data
		// It is apparently impossible to set text/xcustom without setting the other
		// types manually too.
		clipboardData.setData( 'text/html', this.$pasteTarget.html() );
		clipboardData.setData( 'text/plain', this.$pasteTarget.text() );
	} else {
		clipboardItem.hash = this.constructor.static.getClipboardHash( this.$pasteTarget.contents() );
		this.$pasteTarget.prepend(
			this.$( '<span>' ).attr( 'data-ve-clipboard-key', this.clipboardId + '-' + clipboardIndex ).html( '&nbsp;' )
		);

		// If direct clipboard editing is not allowed, we must use the pasteTarget to
		// select the data we want to go in the clipboard

		// If we have a range in the document, preserve it so it can restored
		originalRange = this.getNativeRange();
		if ( originalRange ) {
			// Save scroll position before changing focus to "offscreen" paste target
			scrollTop = this.$window.scrollTop();

			// Prevent surface observation due to native range changing
			this.surfaceObserver.disable();
			ve.selectElement( this.$pasteTarget[0] );

			// Restore scroll position after changing focus
			this.$window.scrollTop( scrollTop );

			setTimeout( function () {
				// Change focus back
				view.$documentNode[0].focus();
				view.nativeSelection.removeAllRanges();
				view.nativeSelection.addRange( originalRange.cloneRange() );
				// Restore scroll position
				view.$window.scrollTop( scrollTop );
				view.surfaceObserver.clear();
				view.surfaceObserver.enable();
			} );
		} else {
			// If nativeRange is null, the pasteTarget *should* already be selected...
			ve.selectElement( this.$pasteTarget[0] );
		}
	}
};

/**
 * Handle native paste event
 *
 * @param {jQuery.Event} e Paste event
 */
ve.ce.Surface.prototype.onPaste = function ( e ) {
	var surface = this;
	// Prevent pasting until after we are done
	if ( this.pasting ) {
		return false;
	}
	this.surfaceObserver.disable();
	this.pasting = true;
	this.beforePaste( e );
	setTimeout( function () {
		surface.afterPaste( e );
		surface.surfaceObserver.clear();
		surface.surfaceObserver.enable();

		// Allow pasting again
		surface.pasting = false;
		surface.pasteSpecial = false;
		surface.beforePasteData = null;
	} );
};

/**
 * Handle pre-paste events.
 *
 * @param {jQuery.Event} e Paste event
 */
ve.ce.Surface.prototype.beforePaste = function ( e ) {
	var tx, range, node, nodeRange, contextElement, nativeRange,
		context, leftText, rightText, textNode, textStart, textEnd,
		selection = this.getModel().getSelection(),
		clipboardData = e.originalEvent.clipboardData,
		doc = this.getModel().getDocument();

	if ( selection instanceof ve.dm.LinearSelection ||
		( selection instanceof ve.dm.TableSelection && selection.isSingleCell() )
	) {
		range = selection.getRanges()[0];
	} else {
		return;
	}

	this.beforePasteData = {};
	if ( clipboardData ) {
		this.beforePasteData.custom = clipboardData.getData( 'text/xcustom' );
		this.beforePasteData.html = clipboardData.getData( 'text/html' );
		if ( this.beforePasteData.html ) {
			// http://msdn.microsoft.com/en-US/en-%20us/library/ms649015(VS.85).aspx
			this.beforePasteData.html = this.beforePasteData.html
				.replace( /^[\s\S]*<!-- *StartFragment *-->/, '' )
				.replace( /<!-- *EndFragment *-->[\s\S]*$/, '' );
		}
	}

	// Pasting into a range? Remove first.
	if ( !range.isCollapsed() ) {
		tx = ve.dm.Transaction.newFromRemoval( doc, range );
		selection = selection.translateByTransaction( tx );
		this.model.change( tx, selection );
		range = selection.getRanges()[0];
	}

	// Save scroll position before changing focus to "offscreen" paste target
	this.beforePasteData.scrollTop = this.$window.scrollTop();

	this.$pasteTarget.empty();

	// Get node from cursor position
	node = doc.getBranchNodeFromOffset( range.start );
	if ( node.canContainContent() ) {
		// If this is a content branch node, then add its DM HTML
		// to the paste target to give CE some context.
		textStart = textEnd = 0;
		nodeRange = node.getRange();
		contextElement = node.getClonedElement();
		// Throw away inner whitespace and other internal properties
		// otherwise our textStart/End offsets may be wrong.
		delete contextElement.internal;
		context = [ contextElement ];
		// If there is content to the left of the cursor, put a placeholder
		// character to the left of the cursor
		if ( range.start > nodeRange.start ) {
			leftText = '☀';
			context.push( leftText );
			textStart = textEnd = 1;
		}
		// If there is content to the right of the cursor, put a placeholder
		// character to the right of the cursor
		if ( range.end < nodeRange.end ) {
			rightText = '☂';
			context.push( rightText );
		}
		// If there is no text context, select some text to be replaced
		if ( !leftText && !rightText ) {
			context.push( '☁' );
			textEnd = 1;
		}
		context.push( { type: '/' + context[0].type } );

		ve.dm.converter.getDomSubtreeFromModel(
			new ve.dm.Document(
				new ve.dm.ElementLinearData( doc.getStore(), context ),
				doc.getHtmlDocument(), undefined, doc.getInternalList(),
				doc.getLang(), doc.getDir()
			),
			this.$pasteTarget[0]
		);

		// Giving the paste target focus too late can cause problems in FF (!?)
		// so do it up here.
		this.$pasteTarget[0].focus();

		nativeRange = this.getElementDocument().createRange();
		// Assume that the DM node only generated one child
		textNode = this.$pasteTarget.children().contents()[0];
		// Place the cursor between the placeholder characters
		nativeRange.setStart( textNode, textStart );
		nativeRange.setEnd( textNode, textEnd );
		this.nativeSelection.removeAllRanges();
		this.nativeSelection.addRange( nativeRange );

		this.beforePasteData.context = context;
		this.beforePasteData.leftText = leftText;
		this.beforePasteData.rightText = rightText;
	} else {
		// If we're not in a content branch node, don't bother trying to do
		// anything clever with paste context
		this.$pasteTarget[0].focus();
	}

	// Restore scroll position after focusing the paste target
	this.$window.scrollTop( this.beforePasteData.scrollTop );

};

/**
 * Handle post-paste events.
 *
 * @param {jQuery.Event} e Paste event
 */
ve.ce.Surface.prototype.afterPaste = function () {
	var clipboardKey, clipboardId, clipboardIndex, range,
		$elements, parts, pasteData, slice, tx, internalListRange,
		data, doc, htmlDoc,
		context, left, right, contextRange,
		importantSpan = 'span[id],span[typeof],span[rel]',
		importRules = this.getSurface().getImportRules(),
		beforePasteData = this.beforePasteData || {},
		selection = this.model.getSelection(),
		view = this;

	// If the selection doesn't collapse after paste then nothing was inserted
	if ( !this.nativeSelection.isCollapsed ) {
		return;
	}

	if ( selection instanceof ve.dm.LinearSelection ||
		( selection instanceof ve.dm.TableSelection && selection.isSingleCell() )
	) {
		range = selection.getRanges()[0];
	} else {
		return;
	}

	// Remove the pasteProtect class. See #onCopy.
	this.$pasteTarget.find( 'span' ).removeClass( 've-pasteProtect' );

	// Remove style attributes. Any valid styles will be restored by data-ve-attributes.
	this.$pasteTarget.find( '[style]' ).removeAttr( 'style' );

	// Restore attributes. See #onCopy.
	this.$pasteTarget.find( '[data-ve-attributes]' ).each( function () {
		var attrs;
		try {
			attrs = JSON.parse( this.getAttribute( 'data-ve-attributes' ) );
		} catch ( e ) {
			// Invalid JSON
			return;
		}
		$( this ).attr( attrs );
		this.removeAttribute( 'data-ve-attributes' );
	} );

	// Find the clipboard key
	if ( beforePasteData.custom ) {
		clipboardKey = beforePasteData.custom;
	} else {
		if ( beforePasteData.html ) {
			$elements = this.$( $.parseHTML( beforePasteData.html ) );

			// Try to find the clipboard key hidden in the HTML
			$elements = $elements.filter( function () {
				var val = this.getAttribute && this.getAttribute( 'data-ve-clipboard-key' );
				if ( val ) {
					clipboardKey = val;
					// Remove the clipboard key span once read
					return false;
				}
				return true;
			} );
		} else {
			// HTML in pasteTarget my get wrapped, so use the recursive $.find to look for the clipboard key
			clipboardKey = this.$pasteTarget.find( 'span[data-ve-clipboard-key]' ).data( 've-clipboard-key' );
			// $elements is used by getClipboardHash so generate it too
			$elements = this.$pasteTarget.contents();
		}
	}

	// Remove the clipboard key
	this.$pasteTarget.find( 'span[data-ve-clipboard-key]' ).remove();

	// If we have a clipboard key, validate it and fetch data
	if ( clipboardKey ) {
		parts = clipboardKey.split( '-' );
		clipboardId = parts[0];
		clipboardIndex = parts[1];
		if ( clipboardId === this.clipboardId && this.clipboard[clipboardIndex] ) {
			// Hash validation: either text/xcustom was used or the hash must be
			// equal to the hash of the pasted HTML to assert that the HTML
			// hasn't been modified in another editor before being pasted back.
			if ( beforePasteData.custom ||
				this.clipboard[clipboardIndex].hash ===
					this.constructor.static.getClipboardHash( $elements.toArray() )
			) {
				slice = this.clipboard[clipboardIndex].slice;
			}
		}
	}

	if ( slice ) {
		// Internal paste
		try {
			// Try to paste in the original data
			// Take a copy to prevent the data being annotated a second time in the catch block
			// and to prevent actions in the data model affecting view.clipboard
			pasteData = new ve.dm.ElementLinearData(
				slice.getStore(),
				ve.copy( slice.getOriginalData() )
			);

			if ( importRules.all || this.pasteSpecial ) {
				pasteData.sanitize( importRules.all || {}, this.pasteSpecial );
			}

			// Annotate
			ve.dm.Document.static.addAnnotationsToData( pasteData.getData(), this.model.getInsertionAnnotations() );

			// Transaction
			tx = ve.dm.Transaction.newFromInsertion(
				this.documentView.model,
				range.start,
				pasteData.getData()
			);
		} catch ( err ) {
			// If that fails, use the balanced data
			// Take a copy to prevent actions in the data model affecting view.clipboard
			pasteData = new ve.dm.ElementLinearData(
				slice.getStore(),
				ve.copy( slice.getBalancedData() )
			);

			if ( importRules.all || this.pasteSpecial ) {
				pasteData.sanitize( importRules.all || {}, this.pasteSpecial );
			}

			// Annotate
			ve.dm.Document.static.addAnnotationsToData( pasteData.getData(), this.model.getInsertionAnnotations() );

			// Transaction
			tx = ve.dm.Transaction.newFromInsertion(
				this.documentView.model,
				range.start,
				pasteData.getData()
			);
		}
	} else {
		if ( clipboardKey && beforePasteData.html ) {
			// If the clipboardKey is set (paste from other VE instance), and clipboard
			// data is available, then make sure important spans haven't been dropped
			if ( !$elements ) {
				$elements = this.$( $.parseHTML( beforePasteData.html ) );
			}
			if (
				// HACK: Allow the test runner to force the use of clipboardData
				clipboardKey === 'useClipboardData-0' || (
					$elements.find( importantSpan ).andSelf().filter( importantSpan ).length > 0 &&
					this.$pasteTarget.find( importantSpan ).length === 0
				)
			) {
				// CE destroyed an important span, so revert to using clipboard data
				htmlDoc = ve.createDocumentFromHtml( beforePasteData.html );
				// Remove the pasteProtect class. See #onCopy.
				$( htmlDoc ).find( 'span' ).removeClass( 've-pasteProtect' );
				beforePasteData.context = null;
			}
		}
		if ( !htmlDoc ) {
			// If there were no problems, let CE do its sanitizing as it may
			// contain all sorts of horrible metadata (head tags etc.)
			// TODO: IE will always take this path, and so may have bugs with span unwrapping
			// in edge cases (e.g. pasting a single MWReference)
			htmlDoc = ve.createDocumentFromHtml( this.$pasteTarget.html() );
		}
		// External paste
		doc = ve.dm.converter.getModelFromDom( htmlDoc, this.getModel().getDocument().getHtmlDocument() );
		data = doc.data;
		// Clear metadata
		doc.metadata = new ve.dm.MetaLinearData( doc.getStore(), new Array( 1 + data.getLength() ) );
		// If the clipboardKey isn't set (paste from non-VE instance) use external import rules
		if ( !clipboardKey ) {
			data.sanitize( importRules.external, this.pasteSpecial );
			if ( importRules.all ) {
				data.sanitize( importRules.all );
			}
		} else if ( importRules.all || this.pasteSpecial ) {
			data.sanitize( importRules.all || {}, this.pasteSpecial );
		}
		data.remapInternalListKeys( this.model.getDocument().getInternalList() );

		// Initialize node tree
		doc.buildNodeTree();

		// If the paste was given context, calculate the range of the inserted data
		if ( beforePasteData.context ) {
			internalListRange = doc.getInternalList().getListNode().getOuterRange();
			context = new ve.dm.ElementLinearData(
				doc.getStore(),
				ve.copy( beforePasteData.context )
			);
			if ( this.pasteSpecial ) {
				// The context may have been sanitized, so sanitize here as well for comparison
				context.sanitize( importRules, this.pasteSpecial, true );
			}

			// Remove matching context from the left
			left = 0;
			while (
				context.getLength() &&
				ve.dm.ElementLinearData.static.compareUnannotated(
					data.getData( left ),
					data.isElementData( left ) ? context.getData( 0 ) : beforePasteData.leftText
				)
			) {
				left++;
				context.splice( 0, 1 );
			}

			// Remove matching context from the right
			right = internalListRange.start;
			while (
				context.getLength() &&
				ve.dm.ElementLinearData.static.compareUnannotated(
					data.getData( right - 1 ),
					data.isElementData( right - 1 ) ? context.getData( context.getLength() - 1 ) : beforePasteData.rightText
				)
			) {
				right--;
				context.splice( context.getLength() - 1, 1 );
			}
			// HACK: Strip trailing linebreaks probably introduced by Chrome bug
			while ( data.getType( right - 1 ) === 'break' ) {
				right--;
			}
			contextRange = new ve.Range( left, right );
		}

		tx = ve.dm.Transaction.newFromDocumentInsertion(
			this.documentView.model,
			range.start,
			doc,
			contextRange
		);
	}

	// Restore focus and scroll position
	this.$documentNode[0].focus();
	// Firefox sometimes doesn't change scrollTop immediately when pasting
	// line breaks so wait until we fix it.
	setTimeout( function () {
		view.$window.scrollTop( beforePasteData.scrollTop );
	} );

	selection = selection.translateByTransaction( tx );
	this.model.change( tx, selection.collapseToStart() );
	// Move cursor to end of selection
	this.model.setSelection( selection.collapseToEnd() );
};

/**
 * Select all the contents within the current context
 */
ve.ce.Surface.prototype.selectAll = function () {
	var internalListRange, range, matrix,
		selection = this.getModel().getSelection();

	if ( selection instanceof ve.dm.LinearSelection ) {
		if ( this.getActiveTableNode() && this.getActiveTableNode().getEditingFragment() ) {
			range = this.getActiveTableNode().getEditingRange();
			range = new ve.Range( range.from + 1, range.to - 1 );
		} else {
			internalListRange = this.getModel().getDocument().getInternalList().getListNode().getOuterRange();
			range = new ve.Range(
				this.getNearestCorrectOffset( 0, 1 ),
				this.getNearestCorrectOffset( internalListRange.start, -1 )
			);
		}
		this.getModel().setLinearSelection( range );
	} else if ( selection instanceof ve.dm.TableSelection ) {
		matrix = selection.getTableNode().getMatrix();
		this.getModel().setSelection(
			new ve.dm.TableSelection(
				selection.getDocument(), selection.tableRange,
				0, 0, matrix.getColCount() - 1, matrix.getRowCount() - 1
			)
		);

	}
};

/**
 * Handle document composition end events.
 *
 * @method
 * @param {jQuery.Event} e Input event
 */
ve.ce.Surface.prototype.onDocumentInput = function () {
	this.incRenderLock();
	try {
		this.surfaceObserver.pollOnce();
	} finally {
		this.decRenderLock();
	}
};

/*! Custom Events */

/**
 * Handle model select events.
 *
 * @see ve.dm.Surface#method-change
 */
ve.ce.Surface.prototype.onModelSelect = function () {
	var focusedNode,
		selection = this.getModel().getSelection();

	this.contentBranchNodeChanged = false;

	if ( selection instanceof ve.dm.LinearSelection ) {
		focusedNode = this.findFocusedNode( selection.getRange() );

		// If focus has changed, update nodes and this.focusedNode
		if ( focusedNode !== this.focusedNode ) {
			if ( this.focusedNode ) {
				this.focusedNode.setFocused( false );
				this.focusedNode = null;
			}
			if ( focusedNode ) {
				focusedNode.setFocused( true );
				this.focusedNode = focusedNode;

				// If dragging, we already have a native selection, so don't mess with it
				if ( !this.dragging ) {
					// As FF won't fire a copy event with nothing selected, make
					// a dummy selection of one space in the pasteTarget.
					// onCopy will ignore this native selection and use the DM selection
					this.$pasteTarget.text( ' ' );
					ve.selectElement( this.$pasteTarget[0] );
					this.$pasteTarget[0].focus();
					// Since the selection is no longer in the documentNode, clear the SurfaceObserver's
					// selection state. Otherwise, if the user places the selection back into the documentNode
					// in exactly the same place where it was before, the observer won't consider that a change.
					this.surfaceObserver.clear();
				}
			}
		}
	} else {
		if ( selection instanceof ve.dm.TableSelection ) {
			this.$pasteTarget.text( ' ' );
			ve.selectElement( this.$pasteTarget[0] );
			this.$pasteTarget[0].focus();
		}
		if ( this.focusedNode ) {
			this.focusedNode.setFocused( false );
		}
		this.focusedNode = null;
	}

	// Ignore the selection if changeModelSelection is currently being
	// called with the same (object-identical) selection object
	// (i.e. if the model is calling us back)
	if ( !this.isRenderingLocked() && selection !== this.newModelSelection ) {
		this.showSelection( selection );
		this.checkUnicorns( false );
	}
	// Update the selection state in the SurfaceObserver
	this.surfaceObserver.pollOnceNoEmit();
	// Check if we moved out of a slug
	this.updateSlug();
};

/**
 * Get the focused node (optionally at a specified range), or null if one is not present
 *
 * @param {ve.Range} [range] Optional range to check for focused node, defaults to current selection's range
 * @return {ve.ce.Node|null} Focused node
 */
ve.ce.Surface.prototype.getFocusedNode = function ( range ) {
	if ( !range ) {
		return this.focusedNode;
	}
	var selection = this.getModel().getSelection();
	if (
		selection instanceof ve.dm.LinearSelection &&
		range.equalsSelection( selection.getRange() )
	) {
		return this.focusedNode;
	}
	return this.findFocusedNode( range );
};

/**
 * Find the focusedNode at a specified range
 *
 * @param {ve.Range} range Range to search at for a focusable node
 * @return {ve.ce.Node|null} Focused node
 */
ve.ce.Surface.prototype.findFocusedNode = function ( range ) {
	var startNode, endNode,
		documentNode = this.documentView.getDocumentNode();
	// Detect when only a single focusable element is selected
	if ( !range.isCollapsed() ) {
		startNode = documentNode.getNodeFromOffset( range.start + 1 );
		if ( startNode && startNode.isFocusable() ) {
			endNode = documentNode.getNodeFromOffset( range.end - 1 );
			if ( startNode === endNode ) {
				return startNode;
			}
		}
	} else {
		// Check if the range is inside a focusable node with a collapsed selection
		startNode = documentNode.getNodeFromOffset( range.start );
		if ( startNode && startNode.isFocusable() ) {
			return startNode;
		}
	}
	return null;
};

/**
 * Handle documentUpdate events on the surface model.
 */
ve.ce.Surface.prototype.onModelDocumentUpdate = function () {
	var surface = this;
	if ( this.contentBranchNodeChanged ) {
		// Update the selection state from model
		this.onModelSelect();
	}
	// Update the state of the SurfaceObserver
	this.surfaceObserver.pollOnceNoEmit();
	// Wait for other documentUpdate listeners to run before emitting
	setTimeout( function () {
		surface.emit( 'position' );
	} );
};

/**
 * Handle insertionAnnotationsChange events on the surface model.
 * @param {ve.dm.AnnotationSet} insertionAnnotations
 */
ve.ce.Surface.prototype.onInsertionAnnotationsChange = function () {
	var changed = this.renderSelectedContentBranchNode();
	if ( !changed ) {
		return;
	}
	// Must re-apply the selection after re-rendering
	this.showSelection( this.surface.getModel().getSelection() );
	this.surfaceObserver.pollOnceNoEmit();
};

/**
 * Re-render the ContentBranchNode the selection is currently in.
 *
 * @return {boolean} Whether a re-render actually happened
 */
ve.ce.Surface.prototype.renderSelectedContentBranchNode = function () {
	var selection, ceNode;
	selection = this.model.getSelection();
	if ( !( selection instanceof ve.dm.LinearSelection ) ) {
		return false;
	}
	ceNode = this.documentView.getBranchNodeFromOffset( selection.getRange().start );
	if ( ceNode === null ) {
		return false;
	}
	if ( !( ceNode instanceof ve.ce.ContentBranchNode ) ) {
		// not a content branch node
		return false;
	}
	return ceNode.renderContents();
};

/**
 * Handle branch node change events.
 *
 * @see ve.ce.SurfaceObserver#pollOnce
 *
 * @method
 * @param {ve.ce.BranchNode} oldBranchNode Node from which the range anchor has just moved
 * @param {ve.ce.BranchNode} newBranchNode Node into which the range anchor has just moved
 */
ve.ce.Surface.prototype.onSurfaceObserverBranchNodeChange = function ( oldBranchNode ) {
	if ( oldBranchNode instanceof ve.ce.ContentBranchNode ) {
		oldBranchNode.renderContents();
	}
};

/**
 * Handle selection change events.
 *
 * @see ve.ce.SurfaceObserver#pollOnce
 *
 * @method
 * @param {ve.Range|null} oldRange
 * @param {ve.Range|null} newRange
 */
ve.ce.Surface.prototype.onSurfaceObserverRangeChange = function ( oldRange, newRange ) {
	if ( oldRange && oldRange.equalsSelection( newRange ) ) {
		// Ignore when the newRange is just a flipped oldRange
		return;
	}
	this.incRenderLock();
	try {
		this.changeModel(
			null,
			newRange ?
				new ve.dm.LinearSelection( this.getModel().getDocument(), newRange ) :
				new ve.dm.NullSelection( this.getModel().getDocument() )
		);
	} finally {
		this.decRenderLock();
	}
	this.checkUnicorns( false );
};

/**
 * Handle slug enter events.
 *
 * @see ve.ce.SurfaceObserver#pollOnce
 */
ve.ce.Surface.prototype.onSurfaceObserverSlugEnter = function () {
	var fragment, offset, $paragraph,
		model = this.getModel(),
		doc = model.getDocument();

	this.updateSlug();
	// Wait until after updateSlug() to get selection
	fragment = model.getFragment();
	if ( !( fragment.getSelection() instanceof ve.dm.LinearSelection ) ) {
		// This shouldn't happen
		return;
	}
	offset = fragment.getSelection().getRange().start;
	model.pushStaging( true );
	this.changeModel( ve.dm.Transaction.newFromInsertion(
		doc, offset, [
			{ type: 'paragraph', internal: { generated: 'slug' } },
			{ type: '/paragraph' }
		]
	), new ve.dm.LinearSelection( doc, new ve.Range( offset + 1 ) ) );
	this.slugFragment = fragment;

	// Fake a slug transition on the new paragraph
	// Clear wrappers from previous former slugs
	this.$element.find( '.ve-ce-branchNode-blockSlugWrapper-former' ).remove();
	// Style paragraph as an unfocused slug, then remove unfocused class to trigger transition
	// The order is important: if we set -former before -former-unfocused, we'll get two transitions
	$paragraph = this.getDocument().getBranchNodeFromOffset( offset + 1 ).$element;
	$paragraph.wrap( this.$( '<div>' ).addClass( 've-ce-branchNode-blockSlugWrapper-former-unfocused' ) );
	// Restore selection now that we've wrapped the node the selection was in
	this.onModelSelect();
	$paragraph.parent()
		// Enable transitions
		.addClass( 've-ce-branchNode-blockSlugWrapper-former' )
		// Remove unfocused again to trigger transition
		.removeClass( 've-ce-branchNode-blockSlugWrapper-former-unfocused' );
};

/**
 * Unslug if needed.
 *
 * If the slug is no longer empty, commit the staged changes.
 * If the slug is still empty and the cursor has moved out of it,
 * clear the staged changes.
 * If the slug is still empty and the cursor is still inside it,
 * or if there is no active slug, do nothing.
 */
ve.ce.Surface.prototype.updateSlug = function () {
	// Prevent recursion
	if ( this.updatingSlug ) {
		return;
	}
	this.updatingSlug = true;

	if ( this.slugFragment ) {
		var range, $slug, anchor,
			slugFragmentRange = this.slugFragment.getSelection().getRange(),
			model = this.getModel();

		if ( model.getSelection() instanceof ve.dm.LinearSelection ) {
			range = model.getSelection().getRange();
		}

		if ( slugFragmentRange.getLength() === 2 ) {
			if ( !range || !slugFragmentRange.containsOffset( range.start ) ) {
				model.popStaging();
				// After popStaging we may have removed a paragraph before our current
				// cursor position. Polling with the SurfaceObserver won't notice a change
				// in the rangy range as our cursor doesn't move within its node so we
				// need to clear it first.
				this.surfaceObserver.clear();
				this.surfaceObserver.pollOnceNoEmit();

				// Fake a transition on the slug that came back
				$slug = $( this.documentView.getSlugAtOffset( slugFragmentRange.start ) );
				anchor = $slug[0].previousSibling;
				$slug
					// Remove from the DOM temporarily (needed for Firefox)
					.detach()
					// Switch from unfocused to focused (no transition)
					.removeClass( 've-ce-branchNode-blockSlugWrapper-unfocused' )
					.addClass( 've-ce-branchNode-blockSlugWrapper-focused' )
					// Reattach to the DOM
					.insertAfter( anchor )
					// Force reflow (needed for Chrome)
					.height();
				$slug
					// Switch from focused to unfocused (with transition)
					.removeClass( 've-ce-branchNode-blockSlugWrapper-focused' )
					.addClass( 've-ce-branchNode-blockSlugWrapper-unfocused' );

				this.slugFragment = null;
			}
		} else {
			model.applyStaging();
			this.slugFragment = null;
		}
	}

	this.updatingSlug = false;
};

/**
 * Handle content change events.
 *
 * @see ve.ce.SurfaceObserver#pollOnce
 *
 * @method
 * @param {ve.ce.Node} node CE node the change occurred in
 * @param {Object} previous Old data
 * @param {Object} previous.text Old plain text content
 * @param {Object} previous.hash Old DOM hash
 * @param {ve.Range} previous.range Old selection
 * @param {Object} next New data
 * @param {Object} next.text New plain text content
 * @param {Object} next.hash New DOM hash
 * @param {ve.Range} next.range New selection
 */
ve.ce.Surface.prototype.onSurfaceObserverContentChange = function ( node, previous, next ) {
	var data, range, len, annotations, offsetDiff, sameLeadingAndTrailing,
		previousStart, nextStart, newRange, replacementRange,
		fromLeft = 0,
		fromRight = 0,
		nodeOffset = node.getModel().getOffset(),
		previousData = previous.text.split( '' ),
		nextData = next.text.split( '' ),
		lengthDiff = next.text.length - previous.text.length,
		nextDataString = new ve.dm.DataString( nextData ),
		surface = this;

	/**
	 * Given a naïvely computed set of annotations to apply to the content we're about to insert,
	 * this function will check if we're inserting at a word break, check if there are any
	 * annotations in the set that need to be split at a word break, and remove those.
	 *
	 * @private
	 * @param {ve.dm.AnnotationSet} annotations Annotations to apply. Will be modified.
	 * @param {ve.Range} range Range covering removed content, or collapsed range at insertion offset.
	 */
	function filterForWordbreak( annotations, range ) {
		var i, length, annotation, annotationIndex, annotationsLeft, annotationsRight,
			left = range.start,
			right = range.end,
			// - nodeOffset - 1 to adjust from absolute to relative
			// adjustment from prev to next not needed because we're before the replacement
			breakLeft = unicodeJS.wordbreak.isBreak( nextDataString, left - nodeOffset - 1 ),
			// - nodeOffset - 1 to adjust from absolute to relative
			// + lengthDiff to adjust from prev to next
			breakRight = unicodeJS.wordbreak.isBreak( nextDataString, right + lengthDiff - nodeOffset - 1 );

		if ( !breakLeft && !breakRight ) {
			// No word breaks either side, so nothing to do
			return;
		}

		annotationsLeft = surface.getModel().getDocument().data.getAnnotationsFromOffset( left - 1 );
		annotationsRight = surface.getModel().getDocument().data.getAnnotationsFromOffset( right );

		for ( i = 0, length = annotations.getLength(); i < length; i++ ) {
			annotation = annotations.get( i );
			annotationIndex = annotations.getIndex( i );
			if (
				// This annotation splits on wordbreak, and...
				annotation.constructor.static.splitOnWordbreak &&
				(
					// either we're at its right-hand boundary (its end is to our left) and
					// there's a wordbreak to our left
					( breakLeft && !annotationsRight.containsIndex( annotationIndex ) ) ||
					// or we're at its left-hand boundary (its beginning is to our right) and
					// there's a wordbreak to our right
					( breakRight && !annotationsLeft.containsIndex( annotationIndex ) )
				)
			) {
				annotations.removeAt( i );
				i--;
				length--;
			}
		}
	}

	if ( previous.range && next.range ) {
		offsetDiff = ( previous.range.isCollapsed() && next.range.isCollapsed() ) ?
			next.range.start - previous.range.start : null;
		previousStart = previous.range.start - nodeOffset - 1;
		nextStart = next.range.start - nodeOffset - 1;
		sameLeadingAndTrailing = offsetDiff !== null && (
			(
				lengthDiff > 0 &&
				previous.text.slice( 0, previousStart ) ===
					next.text.slice( 0, previousStart ) &&
				previous.text.slice( previousStart ) ===
					next.text.slice( nextStart )
			) ||
			(
				lengthDiff < 0 &&
				previous.text.slice( 0, nextStart ) ===
					next.text.slice( 0, nextStart ) &&
				previous.text.slice( previousStart - lengthDiff + offsetDiff ) ===
					next.text.slice( nextStart )
			)
		);

		// Simple insertion
		if ( lengthDiff > 0 && offsetDiff === lengthDiff && sameLeadingAndTrailing ) {
			data = nextData.slice( previousStart, nextStart );
			// Apply insertion annotations
			annotations = node.unicornAnnotations || this.model.getInsertionAnnotations();
			if ( annotations.getLength() ) {
				filterForWordbreak( annotations, new ve.Range( previous.range.start ) );
				ve.dm.Document.static.addAnnotationsToData( data, annotations );
			}

			this.incRenderLock();
			try {
				this.changeModel(
					ve.dm.Transaction.newFromInsertion(
						this.documentView.model, previous.range.start, data
					),
					new ve.dm.LinearSelection( this.documentView.model, next.range )
				);
			} finally {
				this.decRenderLock();
			}
			setTimeout( function () {
				surface.checkSequences();
			} );
			return;
		}

		// Simple deletion
		if ( ( offsetDiff === 0 || offsetDiff === lengthDiff ) && sameLeadingAndTrailing ) {
			if ( offsetDiff === 0 ) {
				range = new ve.Range( next.range.start, next.range.start - lengthDiff );
			} else {
				range = new ve.Range( next.range.start, previous.range.start );
			}
			this.incRenderLock();
			try {
				this.changeModel(
					ve.dm.Transaction.newFromRemoval( this.documentView.model,
						range ),
					new ve.dm.LinearSelection( this.documentView.model, next.range )
				);
			} finally {
				this.decRenderLock();
			}
			return;
		}
	}

	// Complex change

	len = Math.min( previousData.length, nextData.length );
	// Count same characters from left
	while ( fromLeft < len && previousData[fromLeft] === nextData[fromLeft] ) {
		++fromLeft;
	}
	// Count same characters from right
	while (
		fromRight < len - fromLeft &&
		previousData[previousData.length - 1 - fromRight] ===
		nextData[nextData.length - 1 - fromRight]
	) {
		++fromRight;
	}
	replacementRange = new ve.Range(
		nodeOffset + 1 + fromLeft,
		nodeOffset + 1 + previousData.length - fromRight
	);
	data = nextData.slice( fromLeft, nextData.length - fromRight );

	if ( node.unicornAnnotations ) {
		// This CBN is unicorned. Use the stored annotations.
		annotations = node.unicornAnnotations;
	} else {
		// Guess that we want to use the annotations from the first changed character
		// This could be wrong, e.g. slice->slide could happen by changing 'ic' to 'id'
		annotations = this.model.getDocument().data.getAnnotationsFromOffset( replacementRange.start );
	}
	if ( annotations.getLength() ) {
		filterForWordbreak( annotations, replacementRange );
		ve.dm.Document.static.addAnnotationsToData( data, annotations );
	}
	newRange = next.range;
	if ( newRange.isCollapsed() ) {
		newRange = new ve.Range( this.getNearestCorrectOffset( newRange.start, 1 ) );
	}

	this.changeModel(
		ve.dm.Transaction.newFromReplacement( this.documentView.model, replacementRange, data ),
		new ve.dm.LinearSelection( this.documentView.model, newRange )
	);
	this.queueCheckSequences = true;
	setTimeout( function () {
		surface.checkSequences();
	} );
};

/**
 * Check the current surface offset for sequence matches
 */
ve.ce.Surface.prototype.checkSequences = function () {
	var i, sequences,
		executed = false,
		surfaceModel = this.surface.getModel(),
		selection = surfaceModel.getSelection();

	if ( !( selection instanceof ve.dm.LinearSelection ) ) {
		return;
	}

	sequences = ve.ui.sequenceRegistry.findMatching( surfaceModel.getDocument().data, selection.getRange().end );

	// sequences.length will likely be 0 or 1 so don't cache
	for ( i = 0; i < sequences.length; i++ ) {
		executed = sequences[i].execute( this.surface ) || executed;
	}
	if ( executed ) {
		this.showSelection( this.surface.getModel().getSelection() );
	}
};

/**
 * Handle window resize event.
 *
 * @param {jQuery.Event} e Window resize event
 */
ve.ce.Surface.prototype.onWindowResize = ve.debounce( function () {
	this.emit( 'position' );
}, 50 );

/*! Relocation */

/**
 * Start a relocation action.
 *
 * @see ve.ce.FocusableNode
 *
 * @method
 * @param {ve.ce.Node} node Node being relocated
 */
ve.ce.Surface.prototype.startRelocation = function ( node ) {
	this.relocatingNode = node;
	this.emit( 'relocationStart', node );
};

/**
 * Complete a relocation action.
 *
 * @see ve.ce.FocusableNode
 *
 * @method
 * @param {ve.ce.Node} node Node being relocated
 */
ve.ce.Surface.prototype.endRelocation = function () {
	if ( this.relocatingNode ) {
		this.emit( 'relocationEnd', this.relocatingNode );
		this.relocatingNode = null;
		if ( this.$lastDropTarget ) {
			this.$dropMarker.detach();
			this.$lastDropTarget = null;
			this.lastDropPosition = null;
		}
	}
};

/**
 * Set the active table node
 *
 * @param {ve.ce.TableNode|null} tableNode Table node
 */
ve.ce.Surface.prototype.setActiveTableNode = function ( tableNode ) {
	this.activeTableNode = tableNode;
};

/**
 * Get the active table node
 *
 * @return {ve.ce.TableNode|null} Table node
 */
ve.ce.Surface.prototype.getActiveTableNode = function () {
	return this.activeTableNode;
};

/*! Utilities */

/**
 * Store the current selection range, and a key down event if relevant
 *
 * @param {jQuery.Event|null} e Key down event
 */
ve.ce.Surface.prototype.storeKeyDownState = function ( e ) {
	var range;
	// Store the key event / range, obliterating the old one if necessary.
	if ( this.nativeSelection.rangeCount === 0 ) {
		this.cursorEvent = null;
		this.cursorStartRange = null;
		return;
	}
	range = this.nativeSelection.getRangeAt( 0 );

	this.cursorEvent = e;
	this.cursorStartRange = range;
};

/**
 * Move the DM surface cursor
 *
 * @param {number} offset Distance to move (negative = toward document start)
 */
ve.ce.Surface.prototype.moveModelCursor = function ( offset ) {
	var selection = this.model.getSelection();
	if ( selection instanceof ve.dm.LinearSelection ) {
		this.model.setLinearSelection( this.model.getDocument().getRelativeRange(
			selection.getRange(),
			offset,
			'character',
			false
		) );
	}
};

/**
 * Handle left or right arrow key events with a linear selection.
 *
 * @param {jQuery.Event} e Left or right key down event
 */
ve.ce.Surface.prototype.handleLinearLeftOrRightArrowKey = function ( e ) {
	var direction, range = this.getModel().getSelection().getRange();

	// On Mac OS pressing Command (metaKey) + Left/Right is same as pressing Home/End.
	// As we are not able to handle it programmatically (because we don't know at which offsets
	// lines starts and ends) let it happen natively.
	if ( e.metaKey ) {
		return;
	}
	// Selection is going to be displayed programmatically so prevent default browser behaviour
	e.preventDefault();
	// TODO: onDocumentKeyDown did this already
	this.surfaceObserver.stopTimerLoop();
	this.incRenderLock();
	try {
		// TODO: onDocumentKeyDown did this already
		this.surfaceObserver.pollOnce();
	} finally {
		this.decRenderLock();
	}
	if ( this.$( e.target ).css( 'direction' ) === 'rtl' ) {
		// If the language direction is RTL, switch left/right directions:
		direction = e.keyCode === OO.ui.Keys.LEFT ? 1 : -1;
	} else {
		direction = e.keyCode === OO.ui.Keys.LEFT ? -1 : 1;
	}

	range = this.model.getDocument().getRelativeRange(
		range,
		direction,
		( e.altKey === true || e.ctrlKey === true ) ? 'word' : 'character',
		e.shiftKey,
		this.getActiveTableNode() ? this.getActiveTableNode().getEditingRange() : null
	);
	this.model.setLinearSelection( range );
	// TODO: onDocumentKeyDown does this anyway
	this.surfaceObserver.startTimerLoop();
	this.surfaceObserver.pollOnce();
};

/**
 * Handle up or down arrow key events with a linear selection.
 *
 * @param {jQuery.Event} e Up or down key down event
 */
ve.ce.Surface.prototype.handleLinearUpOrDownArrowKey = function ( e ) {
	var nativeRange, endNode, endOffset,
		range = this.model.getSelection().getRange(),
		tableEditingRange = this.getActiveTableNode() ? this.getActiveTableNode().getEditingRange() : null,
		direction = e.keyCode === OO.ui.Keys.DOWN ? 1 : -1,
		surface = this;

	// TODO: onDocumentKeyDown did this already
	this.surfaceObserver.stopTimerLoop();
	// TODO: onDocumentKeyDown did this already
	this.surfaceObserver.pollOnce();

	if ( this.focusedNode ) {
		if ( !this.focusedNode.isContent() ) {
			// Block focusable node, just move back/forward in the model
			e.preventDefault();
			range = this.model.getDocument().getRelativeRange(
				range,
				direction,
				'character',
				e.shiftKey,
				this.getActiveTableNode() ? this.getActiveTableNode().getEditingRange() : null
			);
			this.model.setLinearSelection( range );
			return;
		} else {
			// Inline focusable node, move to end of node in model, then let up/down happen natively
			this.model.setLinearSelection( new ve.Range( direction === 1 ? range.end : range.start ) );
		}
	} else if ( !range.isCollapsed() ) {
		// Perform programmatic handling for a selection that is expanded because CE
		// behaviour is inconsistent
		if ( !this.nativeSelection.extend && range.isBackwards() ) {
			// If the browser doesn't support backwards selections, but the dm range
			// is backwards, then use anchorNode/Offset to compensate
			endNode = this.nativeSelection.anchorNode;
			endOffset = this.nativeSelection.anchorOffset;
		} else {
			endNode = this.nativeSelection.focusNode;
			endOffset = this.nativeSelection.focusOffset;
		}
	}
	if ( endNode ) {
		nativeRange = this.getElementDocument().createRange();
		nativeRange.setStart( endNode, endOffset );
		nativeRange.setEnd( endNode, endOffset );
		this.nativeSelection.removeAllRanges();
		this.nativeSelection.addRange( nativeRange );
	}

	setTimeout( function () {
		var viewNode, newRange;
		// Chrome bug lets you cursor into a multi-line contentEditable=false with up/down...
		viewNode = $( surface.nativeSelection.anchorNode ).closest( '.ve-ce-leafNode,.ve-ce-branchNode' ).data( 'view' );
		if ( viewNode.isFocusable() ) {
			newRange = direction === 1 ? viewNode.getOuterRange() : viewNode.getOuterRange().flip();
		} else {
			// Check where the range is about to move to
			surface.surfaceObserver.pollOnceNoEmit();
			newRange = new ve.Range( surface.surfaceObserver.getRange().to );
		}
		// Expand range
		if ( e.shiftKey === true ) {
			newRange = new ve.Range( range.from, newRange.to );
		}
		if ( tableEditingRange && !tableEditingRange.containsRange( newRange ) ) {
			// The cursor moved outside the editing cell, move it back
			surface.showSelection( surface.getModel().getSelection() );
		} else {
			surface.getModel().setLinearSelection( newRange );
		}
		surface.surfaceObserver.pollOnce();
	} );
};

/**
 * Handle arrow key events with a table selection.
 *
 * @param {jQuery.Event} e Arrow key down event
 */
ve.ce.Surface.prototype.handleTableArrowKey = function ( e ) {
	var tableNode, newSelection,
		checkDir = false,
		selection = this.getModel().getSelection(),
		colOffset = 0,
		rowOffset = 0;

	switch ( e.keyCode ) {
		case OO.ui.Keys.LEFT:
			colOffset = -1;
			checkDir = true;
			break;
		case OO.ui.Keys.RIGHT:
			colOffset = 1;
			checkDir = true;
			break;
		case OO.ui.Keys.UP:
			rowOffset = -1;
			break;
		case OO.ui.Keys.DOWN:
			rowOffset = 1;
			break;
		case OO.ui.Keys.HOME:
			colOffset = -Infinity;
			break;
		case OO.ui.Keys.END:
			colOffset = Infinity;
			break;
		case OO.ui.Keys.PAGEUP:
			rowOffset = -Infinity;
			break;
		case OO.ui.Keys.PAGEDOWN:
			rowOffset = Infinity;
			break;
	}

	e.preventDefault();

	if ( colOffset && checkDir ) {
		tableNode = this.documentView.getBranchNodeFromOffset( selection.tableRange.start + 1 );
		if ( tableNode.$element.css( 'direction' ) !== 'ltr' ) {
			colOffset *= -1;
		}
	}
	if ( !e.shiftKey && !selection.isSingleCell() ) {
		selection = selection.collapseToFrom();
	}
	newSelection = selection.newFromAdjustment(
		e.shiftKey ? 0 : colOffset,
		e.shiftKey ? 0 : rowOffset,
		colOffset,
		rowOffset
	);
	this.getModel().setSelection( newSelection );
};

/**
 * Handle insertion of content.
 */
ve.ce.Surface.prototype.handleInsertion = function () {
	// Don't allow a user to delete a focusable node just by typing
	if ( this.focusedNode ) {
		return;
	}

	var range, annotations,
		cellSelection,
		hasChanged = false,
		selection = this.model.getSelection(),
		documentModel = this.model.getDocument();

	if ( selection instanceof ve.dm.TableSelection ) {
		cellSelection = selection.collapseToFrom();
		annotations = documentModel.data.getAnnotationsFromRange( cellSelection.getRanges()[0] );
		this.model.setSelection( cellSelection );
		this.handleTableDelete();
		this.documentView.getBranchNodeFromOffset( selection.tableRange.start + 1 ).setEditing( true );
		this.model.setInsertionAnnotations( annotations );
		selection = this.model.getSelection();
	}

	if ( !( selection instanceof ve.dm.LinearSelection ) ) {
		return;
	}

	range = selection.getRange();

	// Handles removing expanded selection before inserting new text
	if ( !range.isCollapsed() ) {
		// Pull annotations from the first character in the selection
		annotations = documentModel.data.getAnnotationsFromRange(
			new ve.Range( range.start, range.start + 1 )
		);
		if ( !this.rangeInsideOneLeafNode( range ) ) {
			this.model.change(
				ve.dm.Transaction.newFromRemoval(
					this.documentView.model,
					range
				),
				new ve.dm.LinearSelection( documentModel, new ve.Range( range.start ) )
			);
			hasChanged = true;
			this.surfaceObserver.clear();
			range = this.model.getSelection().getRange();
		}
		this.model.setInsertionAnnotations( annotations );
	}

	if ( hasChanged ) {
		this.surfaceObserver.stopTimerLoop();
		this.surfaceObserver.pollOnce();
	}
};

/**
 * Test whether a range lies within a single leaf node.
 *
 * @param {ve.Range} range The range to test
 * @returns {boolean} Whether the range lies within a single node
 */
ve.ce.Surface.prototype.rangeInsideOneLeafNode = function ( range ) {
	var selected = this.documentView.selectNodes( range, 'leaves' );
	return selected.length === 1;
};

/**
 * Handle enter key down events with a linear selection.
 *
 * @param {jQuery.Event} e Enter key down event
 */
ve.ce.Surface.prototype.handleLinearEnter = function ( e ) {
	var txRemove, txInsert, outerParent, outerChildrenCount, list, prevContentOffset,
		insertEmptyParagraph, node,
		range = this.model.getSelection().getRange(),
		cursor = range.from,
		documentModel = this.model.getDocument(),
		emptyParagraph = [{ type: 'paragraph' }, { type: '/paragraph' }],
		advanceCursor = true,
		stack = [],
		outermostNode = null,
		nodeModel = null,
		nodeModelRange = null;

	// Handle removal first
	if ( !range.isCollapsed() ) {
		txRemove = ve.dm.Transaction.newFromRemoval( documentModel, range );
		range = txRemove.translateRange( range );
		// We do want this to propagate to the surface
		this.model.change( txRemove, new ve.dm.LinearSelection( documentModel, range ) );
	}

	node = this.documentView.getBranchNodeFromOffset( range.from );
	if ( node !== null ) {
		// assertion: node is certainly a contentBranchNode
		nodeModel = node.getModel();
		nodeModelRange = nodeModel.getRange();
	}

	// Handle insertion
	if ( node === null ) {
		throw new Error( 'node === null' );
	} else if (
		nodeModel.getType() !== 'paragraph' &&
		(
			cursor === nodeModelRange.from ||
			cursor === nodeModelRange.to
		)
	) {
		// If we're at the start/end of something that's not a paragraph, insert a paragraph
		// before/after. Insert after for empty nodes (from === to).
		if ( cursor === nodeModelRange.to ) {
			txInsert = ve.dm.Transaction.newFromInsertion(
				documentModel, nodeModel.getOuterRange().to, emptyParagraph
			);
		} else if ( cursor === nodeModelRange.from ) {
			txInsert = ve.dm.Transaction.newFromInsertion(
				documentModel, nodeModel.getOuterRange().from, emptyParagraph
			);
			advanceCursor = false;
		}
	} else if ( e.shiftKey && nodeModel.hasSignificantWhitespace() ) {
		// Insert newline
		txInsert = ve.dm.Transaction.newFromInsertion( documentModel, range.from, '\n' );
	} else if ( !node.splitOnEnter() ) {
		// Cannot split, so insert some appropriate node

		insertEmptyParagraph = false;
		if ( documentModel.hasSlugAtOffset( range.from ) ) {
			insertEmptyParagraph = true;
		} else {
			prevContentOffset = documentModel.data.getNearestContentOffset(
				cursor,
				-1
			);
			if ( prevContentOffset === -1 ) {
				insertEmptyParagraph = true;
			}
		}

		if ( insertEmptyParagraph ) {
			txInsert = ve.dm.Transaction.newFromInsertion(
				documentModel, cursor, emptyParagraph
			);
		} else {
			// Act as if cursor were at previous content offset
			cursor = prevContentOffset;
			node = this.documentView.getBranchNodeFromOffset( cursor );
			txInsert = undefined;
			// Continue to traverseUpstream below. That will succeed because all
			// ContentBranchNodes have splitOnEnter === true.
		}
		insertEmptyParagraph = undefined;
	}

	// Assertion: if txInsert === undefined then node.splitOnEnter() === true

	if ( txInsert === undefined ) {
		// This node has splitOnEnter = true. Traverse upstream until the first node
		// that has splitOnEnter = false, splitting each node as it is reached. Set
		// outermostNode to the last splittable node.

		node.traverseUpstream( function ( node ) {
			if ( !node.splitOnEnter() ) {
				return false;
			}
			stack.splice(
				stack.length / 2,
				0,
				{ type: '/' + node.type },
				node.getModel().getClonedElement()
			);
			outermostNode = node;
			if ( e.shiftKey ) {
				return false;
			} else {
				return true;
			}
		} );

		outerParent = outermostNode.getModel().getParent();
		outerChildrenCount = outerParent.getChildren().length;

		if (
			// This is a list item
			outermostNode.type === 'listItem' &&
			// This is the last list item
			outerParent.getChildren()[outerChildrenCount - 1] === outermostNode.getModel() &&
			// There is one child
			outermostNode.children.length === 1 &&
			// The child is empty
			node.getModel().length === 0
		) {
			// Enter was pressed in an empty list item.
			list = outermostNode.getModel().getParent();
			if ( list.getChildren().length === 1 ) {
				// The list item we're about to remove is the only child of the list
				// Remove the list
				txInsert = ve.dm.Transaction.newFromRemoval(
					documentModel, list.getOuterRange()
				);
			} else {
				// Remove the list item
				txInsert = ve.dm.Transaction.newFromRemoval(
					documentModel, outermostNode.getModel().getOuterRange()
				);
				this.model.change( txInsert );
				range = txInsert.translateRange( range );
				// Insert a paragraph
				txInsert = ve.dm.Transaction.newFromInsertion(
					documentModel, list.getOuterRange().to, emptyParagraph
				);
			}
			advanceCursor = false;
		} else {
			// We must process the transaction first because getRelativeContentOffset can't help us yet
			txInsert = ve.dm.Transaction.newFromInsertion( documentModel, range.from, stack );
		}
	}

	// Commit the transaction
	this.model.change( txInsert );
	range = txInsert.translateRange( range );

	// Now we can move the cursor forward
	if ( advanceCursor ) {
		cursor = documentModel.data.getRelativeContentOffset( range.from, 1 );
	} else {
		cursor = documentModel.data.getNearestContentOffset( range.from );
	}
	if ( cursor === -1 ) {
		// Cursor couldn't be placed in a nearby content node, so create an empty paragraph
		this.model.change(
			ve.dm.Transaction.newFromInsertion(
				documentModel, range.from, emptyParagraph
			)
		);
		this.model.setLinearSelection( new ve.Range( range.from + 1 ) );
	} else {
		this.model.setLinearSelection( new ve.Range( cursor ) );
	}
	// Reset and resume polling
	this.surfaceObserver.clear();
};

/**
 * Handle enter key down events with a table selection.
 *
 * @param {jQuery.Event} e Enter key down event
 */
ve.ce.Surface.prototype.handleTableEnter = function ( e ) {
	var selection = this.getModel().getSelection(),
		tableNode = this.documentView.getBranchNodeFromOffset( selection.tableRange.start + 1 );

	e.preventDefault();
	tableNode.setEditing( true );
};

/**
 * Handle delete and backspace key down events with a linear selection.
 *
 * @param {jQuery.Event} e Delete key down event
 */
ve.ce.Surface.prototype.handleLinearDelete = function ( e ) {
	var docLength, startNode, tableEditingRange,
		direction = e.keyCode === OO.ui.Keys.DELETE ? 1 : -1,
		unit = ( e.altKey === true || e.ctrlKey === true ) ? 'word' : 'character',
		offset = 0,
		rangeToRemove = this.getModel().getSelection().getRange(),
		documentModel = this.getModel().getDocument(),
		data = documentModel.data;

	if ( rangeToRemove.isCollapsed() ) {
		// In case when the range is collapsed use the same logic that is used for cursor left and
		// right movement in order to figure out range to remove.
		rangeToRemove = documentModel.getRelativeRange( rangeToRemove, direction, unit, true );
		tableEditingRange = this.getActiveTableNode() ? this.getActiveTableNode().getEditingRange() : null;
		if ( tableEditingRange && !tableEditingRange.containsRange( rangeToRemove ) ) {
			return;
		}
		offset = rangeToRemove.start;
		docLength = data.getLength();
		if ( offset < docLength ) {
			while ( offset < docLength && data.isCloseElementData( offset ) ) {
				offset++;
			}
			// If the user tries to delete a focusable node from a collapsed selection,
			// just select the node and cancel the deletion.
			startNode = documentModel.getDocumentNode().getNodeFromOffset( offset + 1 );
			if ( startNode.isFocusable() ) {
				this.getModel().setLinearSelection( startNode.getOuterRange() );
				return;
			}
		}
		if ( rangeToRemove.isCollapsed() ) {
			// For instance beginning or end of the document.
			return;
		}
	}

	this.getModel().getLinearFragment( rangeToRemove ).delete( direction );
	// Rerender selection even if it didn't change
	// TODO: is any of this necessary?
	this.focus();
	this.surfaceObserver.clear();
};

/**
 * Handle delete and backspace key down events with a table selection.
 *
 * Performs a strip-delete removing all the cell contents but not altering the structure.
 *
 * @param {jQuery.Event} e Delete key down event
 */
ve.ce.Surface.prototype.handleTableDelete = function () {
	var i, l,
		surfaceModel = this.getModel(),
		fragments = [],
		ranges = surfaceModel.getSelection().getRanges();

	for ( i = 0, l = ranges.length; i < l; i++ ) {
		// Create auto-updating fragments from ranges
		fragments.push( surfaceModel.getLinearFragment( ranges[i], true ) );
	}

	for ( i = 0, l = fragments.length; i < l; i++ ) {
		// Replace contents with empty wrapper paragraphs
		fragments[i].insertContent( [
			{ type: 'paragraph', internal: { generated: 'wrapper' } },
			{ type: '/paragraph' }
		] );
	}
};

/**
 * Handle escape key down events with a linear selection while table editing.
 *
 * @param {jQuery.Event} e Delete key down event
 */
ve.ce.Surface.prototype.handleTableEditingEscape = function ( e ) {
	e.preventDefault();
	e.stopPropagation();
	this.getActiveTableNode().setEditing( false );
};

/**
 * Show selection
 *
 * @method
 * @param {ve.dm.Selection} selection Selection to show
 */
ve.ce.Surface.prototype.showSelection = function ( selection ) {
	if ( this.deactivated ) {
		// Defer until view has updated
		setTimeout( this.updateDeactivatedSelection.bind( this ) );
		return;
	}

	if ( !( selection instanceof ve.dm.LinearSelection ) || this.focusedNode ) {
		return;
	}

	var endRange,
		range = selection.getRange(),
		rangeSelection = this.getRangeSelection( range ),
		nativeRange = this.getElementDocument().createRange();

	this.nativeSelection.removeAllRanges();
	if ( rangeSelection.end ) {
		nativeRange.setStart( rangeSelection.start.node, rangeSelection.start.offset );
		nativeRange.setEnd( rangeSelection.end.node, rangeSelection.end.offset );
		if ( rangeSelection.isBackwards && this.nativeSelection.extend ) {
			endRange = nativeRange.cloneRange();
			endRange.collapse( false );
			this.nativeSelection.addRange( endRange );
			try {
				this.nativeSelection.extend( nativeRange.startContainer, nativeRange.startOffset );
			} catch ( e ) {
				// Firefox sometimes fails when nodes are different,
				// see https://bugzilla.mozilla.org/show_bug.cgi?id=921444
				this.nativeSelection.addRange( nativeRange );
			}
		} else {
			this.nativeSelection.addRange( nativeRange );
		}
	} else {
		nativeRange.setStart( rangeSelection.start.node, rangeSelection.start.offset );
		this.nativeSelection.addRange( nativeRange );
	}
	// Setting a range doesn't give focus in all browsers so make sure this happens
	// Also set focus after range to prevent scrolling to top
	if ( !OO.ui.contains( this.getElementDocument().activeElement, rangeSelection.start.node, true ) ) {
		$( rangeSelection.start.node ).closest( '[contenteditable=true]' ).focus();
	}
};

/**
 * Get selection for a range.
 *
 * @method
 * @param {ve.Range} range Range to get selection for
 * @returns {Object} Object containing start and end node/offset selections, and an isBackwards flag.
 */
ve.ce.Surface.prototype.getRangeSelection = function ( range ) {
	range = new ve.Range(
		this.getNearestCorrectOffset( range.from, -1 ),
		this.getNearestCorrectOffset( range.to, 1 )
	);

	if ( !range.isCollapsed() ) {
		return {
			start: this.documentView.getNodeAndOffset( range.start ),
			end: this.documentView.getNodeAndOffset( range.end ),
			isBackwards: range.isBackwards()
		};
	} else {
		return {
			start: this.documentView.getNodeAndOffset( range.start )
		};
	}
};

/**
 * Get a native range object for a specified range
 *
 * Native ranges are only used by linear selections.
 *
 * Doesn't correct backwards selection so should be used for measurement only.
 *
 * @param {ve.Range} [range] Optional range to get the native range for, defaults to current selection's range
 * @return {Range|null} Native range object, or null if there is no suitable selection
 */
ve.ce.Surface.prototype.getNativeRange = function ( range ) {
	var nativeRange, rangeSelection,
		selection = this.getModel().getSelection();

	if (
		range && !this.deactivated &&
		selection instanceof ve.dm.LinearSelection && selection.getRange().equalsSelection( range )
	) {
		// Range requested is equivalent to native selection so reset
		range = null;
	}
	if ( !range ) {
		// Use native range, unless selection is null
		if ( !( selection instanceof ve.dm.LinearSelection ) ) {
			return null;
		}
		if ( this.nativeSelection.rangeCount > 0 ) {
			try {
				return this.nativeSelection.getRangeAt( 0 );
			} catch ( e ) {}
		}
		return null;
	}

	nativeRange = document.createRange();
	rangeSelection = this.getRangeSelection( range );

	nativeRange.setStart( rangeSelection.start.node, rangeSelection.start.offset );
	if ( rangeSelection.end ) {
		nativeRange.setEnd( rangeSelection.end.node, rangeSelection.end.offset );
	}
	return nativeRange;
};

/**
 * Append passed highlights to highlight container.
 *
 * @method
 * @param {jQuery} $highlights Highlights to append
 * @param {boolean} focused Highlights are currently focused
 */
ve.ce.Surface.prototype.appendHighlights = function ( $highlights, focused ) {
	// Only one item can be blurred-highlighted at a time, so remove the others.
	// Remove by detaching so they don't lose their event handlers, in case they
	// are attached again.
	this.$highlightsBlurred.children().detach();
	if ( focused ) {
		this.$highlightsFocused.append( $highlights );
	} else {
		this.$highlightsBlurred.append( $highlights );
	}
};

/*! Helpers */

/**
 * Get the nearest offset that a cursor can be placed at.
 *
 * TODO: Find a better name and a better place for this method
 *
 * @method
 * @param {number} offset Offset to start looking at
 * @param {number} [direction=-1] Direction to look in, +1 or -1
 * @returns {number} Nearest offset a cursor can be placed at
 */
ve.ce.Surface.prototype.getNearestCorrectOffset = function ( offset, direction ) {
	var contentOffset, structuralOffset,
		documentModel = this.getModel().getDocument(),
		data = documentModel.data;

	direction = direction > 0 ? 1 : -1;
	if (
		data.isContentOffset( offset ) ||
		documentModel.hasSlugAtOffset( offset )
	) {
		return offset;
	}

	contentOffset = data.getNearestContentOffset( offset, direction );
	structuralOffset = data.getNearestStructuralOffset( offset, direction, true );

	if ( !documentModel.hasSlugAtOffset( structuralOffset ) && contentOffset !== -1 ) {
		return contentOffset;
	}

	if ( direction === 1 ) {
		if ( contentOffset < offset ) {
			return structuralOffset;
		} else {
			return Math.min( contentOffset, structuralOffset );
		}
	} else {
		if ( contentOffset > offset ) {
			return structuralOffset;
		} else {
			return Math.max( contentOffset, structuralOffset );
		}
	}
};

/*! Getters */

/**
 * Get the top-level surface.
 *
 * @method
 * @returns {ve.ui.Surface} Surface
 */
ve.ce.Surface.prototype.getSurface = function () {
	return this.surface;
};

/**
 * Get the surface model.
 *
 * @method
 * @returns {ve.dm.Surface} Surface model
 */
ve.ce.Surface.prototype.getModel = function () {
	return this.model;
};

/**
 * Get the document view.
 *
 * @method
 * @returns {ve.ce.Document} Document view
 */
ve.ce.Surface.prototype.getDocument = function () {
	return this.documentView;
};

/**
 * Check whether there are any render locks
 *
 * @method
 * @returns {boolean} Render is locked
 */
ve.ce.Surface.prototype.isRenderingLocked = function () {
	return this.renderLocks > 0;
};

/**
 * Add a single render lock (to disable rendering)
 *
 * @method
 */
ve.ce.Surface.prototype.incRenderLock = function () {
	this.renderLocks++;
};

/**
 * Remove a single render lock
 *
 * @method
 */
ve.ce.Surface.prototype.decRenderLock = function () {
	this.renderLocks--;
};

/**
 * Change the model only, not the CE surface
 *
 * This avoids event storms when the CE surface is already correct
 *
 * @method
 * @param {ve.dm.Transaction|ve.dm.Transaction[]|null} transactions One or more transactions to
 * process, or null to process none
 * @param {ve.dm.Selection} selection New selection
 * @throws {Error} If calls to this method are nested
 */
ve.ce.Surface.prototype.changeModel = function ( transaction, selection ) {
	if ( this.newModelSelection !== null ) {
		throw new Error( 'Nested change of newModelSelection' );
	}
	this.newModelSelection = selection;
	try {
		this.model.change( transaction, selection );
	} finally {
		this.newModelSelection = null;
	}
};

/**
 * Inform the surface that one of its ContentBranchNodes' rendering has changed.
 * @see ve.ce.ContentBranchNode#renderContents
 */
ve.ce.Surface.prototype.setContentBranchNodeChanged = function () {
	this.contentBranchNodeChanged = true;
	this.cursorEvent = null;
	this.cursorStartRange = null;
};

/**
 * Set the node that has the current unicorn.
 *
 * If another node currently has a unicorn, it will be rerendered, which will
 * cause it to release its unicorn.
 *
 * @param {ve.ce.ContentBranchNode} node The node claiming the unicorn
 */
ve.ce.Surface.prototype.setUnicorning = function ( node ) {
	if ( this.setUnicorningRecursionGuard ) {
		throw new Error( 'setUnicorning recursing' );
	}
	if ( this.unicorningNode && this.unicorningNode !== node ) {
		this.setUnicorningRecursionGuard = true;
		try {
			this.unicorningNode.renderContents();
		} finally {
			this.setUnicorningRecursionGuard = false;
		}
	}
	this.unicorningNode = node;
};

/**
 * Release the current unicorn held by a given node.
 *
 * If the node doesn't hold the current unicorn, nothing happens.
 * This function does not cause any node to be rerendered.
 *
 * @param {ve.ce.ContentBranchNode} node The node releasing the unicorn
 */
ve.ce.Surface.prototype.setNotUnicorning = function ( node ) {
	if ( this.unicorningNode === node ) {
		this.unicorningNode = null;
	}
};

/**
 * Ensure that no node has a unicorn.
 *
 * If the given node currently has the unicorn, it will be released and
 * no rerender will happen. If another node has the unicorn, that node
 * will be rerendered to get rid of the unicorn.
 *
 * @param {ve.ce.ContentBranchNode} node The node releasing the unicorn
 */
ve.ce.Surface.prototype.setNotUnicorningAll = function ( node ) {
	if ( this.unicorningNode === node ) {
		// Don't call back node.renderContents()
		this.unicorningNode = null;
	}
	this.setUnicorning( null );
};
