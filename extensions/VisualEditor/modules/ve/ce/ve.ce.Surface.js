/*!
 * VisualEditor ContentEditable Surface class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */
/*global rangy */

/**
 * ContentEditable surface.
 *
 * @class
 * @extends ve.Element
 * @mixins ve.EventEmitter
 *
 * @constructor
 * @param {jQuery} $container
 * @param {ve.dm.Surface} model Surface model to observe
 * @param {ve.ui.Surface} surface Surface user interface
 * @param {Object} [config] Configuration options
 */
ve.ce.Surface = function VeCeSurface( model, surface, options ) {
	var $documentNode;
	// Parent constructor
	ve.Element.call( this, options );

	// Mixin constructors
	ve.EventEmitter.call( this );

	// Properties
	this.surface = surface;
	this.inIme = false;
	this.model = model;
	this.documentView = new ve.ce.Document( model.getDocument(), this );
	this.surfaceObserver = new ve.ce.SurfaceObserver( this.documentView );
	this.selectionTimeout = null;
	this.$document = $( this.getElementDocument() );
	this.eventSequencer = new ve.EventSequencer( [
		'keydown', 'keypress', 'keyup', 'mousedown', 'mouseup',
		'mousemove', 'compositionstart', 'compositionend'
	] );
	this.clipboard = [];
	this.clipboardId = String( Math.random() );
	this.renderLocks = 0;
	this.dragging = false;
	this.relocating = false;
	this.selecting = false;
	this.$phantoms = this.$$( '<div>' );
	this.$highlights = this.$$( '<div>' );
	this.$pasteTarget = this.$$( '<div>' );
	this.pasting = false;
	this.clickHistory = [];
	this.focusedNode = null;
	// This is set on entering changeModelSelection, then unset when leaving.
	// It is used to test whether a reflected change event is emitted.
	this.newModelSelection = null;

	// Events
	this.surfaceObserver.connect(
		this, { 'contentChange': 'onContentChange', 'selectionChange': 'onSelectionChange' }
	);
	this.model.connect( this, { 'change': 'onChange', 'lock': 'onLock', 'unlock': 'onUnlock' } );

	$documentNode = this.documentView.getDocumentNode().$;
	$documentNode.on( {
		'cut': ve.bind( this.onCut, this ),
		'copy': ve.bind( this.onCopy, this )
	} );
	this.$pasteTarget.on( {
		'cut': ve.bind( this.onCut, this ),
		'copy': ve.bind( this.onCopy, this )
	} );

	// blur and focus fire in the wrong order in jQuery 1.8 . Bind to the native events which do
	// fire in the correct order.
	$documentNode[0].addEventListener( 'focus', ve.bind( this.documentOnFocus, this ) );
	$documentNode[0].addEventListener( 'blur', ve.bind( this.documentOnBlur, this ) );
	// $pasteTarget is focused when selecting a FocusableNode
	this.$pasteTarget[0].addEventListener( 'focus', ve.bind( this.documentOnFocus, this ) );
	this.$pasteTarget[0].addEventListener( 'blur', ve.bind( this.documentOnBlur, this ) );

	$documentNode.on( $.browser.msie ? 'beforepaste' : 'paste', ve.bind( this.onPaste, this ) );
	$documentNode.on( 'focus', 'a', function () {
		// Opera triggers 'blur' on document node before any link is
		// focused and we don't want that
		$documentNode.focus();
	} );

	this.$.on( {
		'dragover': ve.bind( this.onDocumentDragOver, this ),
		'drop': ve.bind( this.onDocumentDrop, this )
	} );

	// Add listeners to the eventSequencer. They won't get called until
	// eventSequencer.attach(node) has been called.
	this.eventSequencer.on( {
		'keydown': ve.bind( this.onDocumentKeyDown, this ),
		'keyup': ve.bind( this.onDocumentKeyUp, this ),
		'keypress': ve.bind( this.onDocumentKeyPress, this ),
		'mousedown': ve.bind( this.onDocumentMouseDown, this ),
		'mouseup': ve.bind( this.onDocumentMouseUp, this ),
		'mousemove': ve.bind( this.onDocumentMouseMove, this ),
		'compositionstart': ve.bind( this.onDocumentCompositionStart, this ),
		'compositionend': ve.bind( this.onDocumentCompositionEnd, this )
	} );
	this.eventSequencer.after( {
		'keypress': ve.bind( this.afterDocumentKeyPress, this )
	} );

	// Initialization
	this.$.addClass( 've-ce-surface' );
	this.$phantoms.addClass( 've-ce-surface-phantoms' );
	this.$highlights.addClass( 've-ce-surface-highlights' );
	this.$pasteTarget.addClass( 've-ce-surface-paste' ).prop( 'contentEditable', 'true' );

	// Add elements to the DOM
	this.$.append( this.documentView.getDocumentNode().$, this.$pasteTarget );
	this.surface.$localOverlayBlockers.append( this.$phantoms, this.$highlights );
};

/* Inheritance */

ve.inheritClass( ve.ce.Surface, ve.Element );

ve.mixinClass( ve.ce.Surface, ve.EventEmitter );

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

/* Static Properties */

/**
 * Pattern matching "normal" characters which we can let the browser handle natively.
 *
 * @static
 * @property {RegExp}
 */
ve.ce.Surface.static.textPattern = new RegExp(
	'[a-zA-Z\\-_’\'‘ÆÐƎƏƐƔĲŊŒẞÞǷȜæðǝəɛɣĳŋœĸſßþƿȝĄƁÇĐƊĘĦĮƘŁØƠŞȘŢȚŦŲƯY̨Ƴąɓçđɗęħįƙłøơşșţțŧųưy̨ƴÁÀÂÄ' +
	'ǍĂĀÃÅǺĄÆǼǢƁĆĊĈČÇĎḌĐƊÐÉÈĖÊËĚĔĒĘẸƎƏƐĠĜǦĞĢƔáàâäǎăāãåǻąæǽǣɓćċĉčçďḍđɗðéèėêëěĕēęẹǝəɛġĝǧğģɣĤḤĦIÍÌİ' +
	'ÎÏǏĬĪĨĮỊĲĴĶƘĹĻŁĽĿʼNŃN̈ŇÑŅŊÓÒÔÖǑŎŌÕŐỌØǾƠŒĥḥħıíìiîïǐĭīĩįịĳĵķƙĸĺļłľŀŉńn̈ňñņŋóòôöǒŏōõőọøǿơœŔŘŖŚŜ' +
	'ŠŞȘṢẞŤŢṬŦÞÚÙÛÜǓŬŪŨŰŮŲỤƯẂẀŴẄǷÝỲŶŸȲỸƳŹŻŽẒŕřŗſśŝšşșṣßťţṭŧþúùûüǔŭūũűůųụưẃẁŵẅƿýỳŷÿȳỹƴźżžẓ]',
	'g'
);

/* Static methods */

/**
 * When pasting, browsers normalize HTML to varying degrees.
 * This hash creates a comparable string for validating clipboard contents.
 *
 * @param {jQuery} $elements Clipboard HTML elements
 * @returns {string} Hash
 */
ve.ce.Surface.static.getClipboardHash = function ( $elements ) {
	var hash = '';
	// Collect text contents, or just node name for content-less nodes.
	$elements.each( function () {
		hash += this.textContent || '<' + this.nodeName + '>';
	} );
	// Whitespace may be added/removed, so strip it all
	return hash.replace( /\s/gm, '' );
};


/* Methods */

/**
 * Get the coordinates of the selection anchor.
 *
 * @method
 */
ve.ce.Surface.prototype.getSelectionRect = function () {
	var sel, rect, $span, lineHeight, startRange, startOffset, endRange, endOffset, focusedOffset;

	if ( this.focusedNode ) {
		focusedOffset = this.focusedNode.$.offset();
		return {
			'start': {
				'x': focusedOffset.left,
				'y': focusedOffset.top
			},
			'end': {
				'x': focusedOffset.left + this.focusedNode.$.width(),
				'y': focusedOffset.top + this.focusedNode.$.height()
			}
		};
	}

	if ( !rangy.initialized ) {
		rangy.init();
	}

	sel = rangy.getSelection( this.getElementDocument() );

	// We can't do anything if there's no selection
	if ( sel.rangeCount === 0 ) {
		return null;
	}

	rect = sel.getBoundingDocumentRect();

	// Sometimes the selection will have invalid bounding rect information, which presents as all
	// rectangle dimensions being 0 which causes #getStartDocumentPos and #getEndDocumentPos to
	// throw exceptions
	if ( rect.top === 0 || rect.bottom === 0 || rect.left === 0 || rect.right === 0 ) {
		// Calculate starting range position
		startRange = sel.getRangeAt( 0 );
		$span = $( '<span>|</span>', startRange.startContainer.ownerDocument );
		startRange.insertNode( $span[0] );
		startOffset = $span.offset();
		$span.detach();

		// Calculate ending range position
		endRange = startRange.cloneRange();
		endRange.collapse( false );
		endRange.insertNode( $span[0] );
		endOffset = $span.offset();
		lineHeight = $span.height();
		$span.detach();

		// Restore the selection
		startRange.refresh();

		// Return the selection bounding rectangle
		return {
			'start': {
				'x': startOffset.left,
				'y': startOffset.top
			},
			'end': {
				'x': endOffset.left,
				// Adjust the vertical position by the line-height to get the bottom dimension
				'y': endOffset.top + lineHeight
			}
		};
	} else {
		return {
			'start': sel.getStartDocumentPos(),
			'end': sel.getEndDocumentPos()
		};
	}
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
	if ( !rangy.initialized ) {
		rangy.init();
	}
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
 * Destroy the surface, removing all DOM elements.
 *
 * @method
 */
ve.ce.Surface.prototype.destroy = function () {
	this.documentView.getDocumentNode().setLive( false );
	this.$.remove();
	this.$phantoms.remove();
};

/**
 * Give focus to the surface, preserving the previous selection.
 *
 * This is used when switching between surfaces, e.g. when closing a dialog window.
 */
ve.ce.Surface.prototype.focus = function () {
	var $document = this.documentView.getDocumentNode().$,
		$window = $( ve.Element.getWindow( $document ) ),
		scrollTop = $window.scrollTop();

	$document[0].focus();
	// Calling focus sets the cursor to zero offset, so we need to restore scrollTop
	$window.scrollTop( scrollTop );
	this.focusedNode = null;
	this.onChange( null, this.surface.getModel().selection );
};

/*! Native Browser Events */

/**
 * Handle document focus events.
 *
 * @method
 * @param {Event} e Focus event (native event, NOT a jQuery event!)
 */
ve.ce.Surface.prototype.documentOnFocus = function () {
	this.eventSequencer.attach( this.$ );
	this.surfaceObserver.startTimerLoop();
};

/**
 * Handle document blur events.
 *
 * @method
 * @param {Event} e Blur event (native event, NOT a jQuery event!)
 */
ve.ce.Surface.prototype.documentOnBlur = function () {
	this.eventSequencer.detach();
	this.surfaceObserver.stopTimerLoop();
	this.surfaceObserver.pollOnce();
	this.dragging = false;
};

/**
 * Handle document mouse down events.
 *
 * @method
 * @param {jQuery.Event} e Mouse down event
 */
ve.ce.Surface.prototype.onDocumentMouseDown = function ( e ) {
	var selection, node;

	// Remember the mouse is down
	this.dragging = true;

	// Old code to figure out if user clicked inside the document or not - leave it here for now
	// this.$$( e.target ).closest( '.ve-ce-documentNode' ).length === 0

	if ( e.which === 1 ) {
		this.surfaceObserver.stopTimerLoop();
		// TODO: guard with incRenderLock?
		this.surfaceObserver.pollOnce();
	}

	// Handle triple click
	if ( this.getClickCount( e.originalEvent ) >= 3 ) {
		// Browser default behaviour for triple click won't behave as we want
		e.preventDefault();

		selection = this.model.getSelection();
		node = this.documentView.getDocumentNode().getNodeFromOffset( selection.start );
		// Find the nearest non-content node
		while ( node.parent !== null && node.model.isContent() ) {
			node = node.parent;
		}
		this.model.change( null, node.model.getRange() );
	}
};

/**
 * Handle document mouse up events.
 *
 * @method
 * @param {jQuery.Event} e Mouse up event
 * @emits selectionEnd
 */
ve.ce.Surface.prototype.onDocumentMouseUp = function ( e ) {
	this.surfaceObserver.startTimerLoop();
	// TODO: guard with incRenderLock?
	this.surfaceObserver.pollOnce();
	if ( !e.shiftKey && this.selecting ) {
		this.emit( 'selectionEnd' );
		this.selecting = false;
	}
	this.dragging = false;
};

/**
 * Handle document mouse move events.
 *
 * @method
 * @param {jQuery.Event} e Mouse move event
 * @emits selectionStart
 */
ve.ce.Surface.prototype.onDocumentMouseMove = function () {
	// Detect beginning of selection by moving mouse while dragging
	if ( this.dragging && !this.selecting ) {
		this.selecting = true;
		this.emit( 'selectionStart' );
	}
};

/**
 * Handle document dragover events.
 *
 * Limits native drag and drop behavior.
 *
 * @method
 * @param {jQuery.Event} e Drag over event
 */
ve.ce.Surface.prototype.onDocumentDragOver = function () {
	if ( !this.relocating ) {
		return false;
	} else if ( this.selecting ) {
		this.emit( 'selectionEnd' );
		this.selecting = false;
		this.dragging = false;
	}
};

/**
 * Handle document drop events.
 *
 * Limits native drag and drop behavior.
 *
 * TODO: Look into using drag and drop data transfer to embed the dragged element's original range
 * (for dragging within one document) and serialized linear model data (for dragging between
 * multiple documents) and use a special mimetype, like application-x/VisualEditor, to allow
 * dragover and drop events on the surface, removing the need to give the surface explicit
 * instructions to allow and prevent dragging and dropping a certain node.
 *
 * @method
 * @param {jQuery.Event} e Drag drop event
 */
ve.ce.Surface.prototype.onDocumentDrop = function ( e ) {
	var node = this.relocating;

	if ( node ) {
		// Process drop operation after native drop has been prevented below
		setTimeout( ve.bind( function () {
			var dropPoint, nodeData, originFragment, targetFragment,
				nodeRange = node.getModel().getOuterRange();

			// Get a fragment from the drop point
			dropPoint = rangy.positionFromPoint(
				e.originalEvent.pageX - this.$document.scrollLeft(),
				e.originalEvent.pageY - this.$document.scrollTop()
			);
			if ( !dropPoint ) {
				// Getting position from point supported
				return false;
			}
			targetFragment = this.model.getFragment(
				new ve.Range( ve.ce.getOffset( dropPoint.node, dropPoint.offset ) ), false
			);

			// Get a fragment and data of the node being dragged
			originFragment = this.model.getFragment( nodeRange, false );
			nodeData = originFragment.getData();

			// Remove node from old location (auto-updates targetFragment's range)
			originFragment.removeContent();

			// Re-insert node at new location and re-select it
			targetFragment.insertContent( nodeData ).select();
		}, this ) );
	}

	return false;
};

/**
 * Handle document key down events.
 *
 * @method
 * @param {jQuery.Event} e Key down event
 * @emits selectionStart
 */
ve.ce.Surface.prototype.onDocumentKeyDown = function ( e ) {
	var trigger;

	// Ignore keydowns while in IME mode but do not preventDefault them (so text actually appear on
	// the screen).
	if ( this.inIme === true ) {
		return;
	}

	// When entering IME mode IE first keydown (e.which = 229) before it fires compositionstart, so
	// IME detection have to happen here instead of onDocumentCompositionStart.
	// TODO: This code and code in onDocumentCompositionStart are very similar, consider moving them
	// to one method.
	if ( $.browser.msie === true && e.which === 229 ) {
		this.inIme = true;
		this.handleInsertion();
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
	switch ( e.keyCode ) {
		case ve.Keys.LEFT:
		case ve.Keys.RIGHT:
		case ve.Keys.UP:
		case ve.Keys.DOWN:
			if ( !this.dragging && !this.selecting && e.shiftKey ) {
				this.selecting = true;
				this.emit( 'selectionStart' );
			}
			if ( ve.ce.isLeftOrRightArrowKey( e.keyCode ) ) {
				this.handleLeftOrRightArrowKey( e );
			} else {
				this.handleUpOrDownArrowKey( e );
			}
			break;
		case ve.Keys.ENTER:
			e.preventDefault();
			this.handleEnter( e );
			break;
		case ve.Keys.BACKSPACE:
			e.preventDefault();
			this.handleDelete( e, true );
			break;
		case ve.Keys.DELETE:
			e.preventDefault();
			this.handleDelete( e, false );
			break;
		default:
			trigger = new ve.ui.Trigger( e );
			if ( trigger.isComplete() && this.surface.execute( trigger ) ) {
				e.preventDefault();
			}
			break;
	}
	this.incRenderLock();
	try {
		this.surfaceObserver.pollOnce();
	} finally {
		this.decRenderLock();
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
	var selection, prevNode, documentModel = this.model.getDocument();

	// Prevent IE from editing Aliens/Entities
	// TODO: Better comment about what's going on here is needed.
	if ( $.browser.msie === true ) {
		selection = this.model.getSelection();
		if ( selection.start !== 0 && selection.isCollapsed() ) {
			prevNode = documentModel.getDocumentNode().getNodeFromOffset( selection.start - 1 );
			if (
				!this.documentView.getSlugAtOffset( selection.start ) &&
				prevNode.isContent() &&
				documentModel.data.isCloseElementData( selection.start - 1 )
			) {
				this.model.change( null, new ve.Range( selection.start ) );
			}
		}
	}

	// Filter out non-character keys. If those keys wouldn't be filtered out unexpected content
	// deletion would occur in case when selection is not collapsed and user press home key for
	// instance (Firefox fires keypress for home key).
	// TODO: Should be covered with Selenium tests.
	if ( e.which === 0 || e.charCode === 0 || ve.ce.isShortcutKey( e ) ) {
		return;
	}

	this.handleInsertion();
};

/**
 * Poll again after the native key press
 * @param {jQuery.Event} ev
 */
ve.ce.Surface.prototype.afterDocumentKeyPress = function () {
	this.surfaceObserver.pollOnce();
};

/**
 * Handle document key up events.
 *
 * @method
 * @param {jQuery.Event} e Key up event
 * @emits selectionEnd
 */
ve.ce.Surface.prototype.onDocumentKeyUp = function ( e ) {
	// Detect end of selecting by letting go of shift
	if ( !this.dragging && this.selecting && e.keyCode === ve.Keys.SHIFT ) {
		this.selecting = false;
		this.emit( 'selectionEnd' );
	}
};

/**
 * Handle cut events.
 *
 * @method
 * @param {jQuery.Event} e Cut event
 */
ve.ce.Surface.prototype.onCut = function ( e ) {
	// TODO: no pollOnce here: but should we add one?
	this.surfaceObserver.stopTimerLoop();
	this.onCopy( e );
	setTimeout( ve.bind( function () {
		var selection, tx;

		// We don't like how browsers cut, so let's undo it and do it ourselves.
		this.$document[0].execCommand( 'undo', false, false );
		selection = this.model.getSelection();

		// Transact
		tx = ve.dm.Transaction.newFromRemoval( this.documentView.model, selection );

		// Document may not have had real focus (e.g. with a FocusableNode)
		this.documentView.documentNode.$[0].focus();

		this.model.change( tx, new ve.Range( selection.start ) );
		this.surfaceObserver.clear();
		this.surfaceObserver.startTimerLoop();
		this.surfaceObserver.pollOnce();
	}, this ) );
};

/**
 * Handle copy events.
 *
 * @method
 * @param {jQuery.Event} e Copy event
 */
ve.ce.Surface.prototype.onCopy = function ( e ) {
	var rangyRange, sel, originalRange,
		clipboardIndex, clipboardItem,
		scrollTop,
		view = this,
		slice = this.documentView.model.getSlicedLinearData( this.model.getSelection() ),
		clipboardData = e.originalEvent.clipboardData,
		$window = $( ve.Element.getWindow( this.$$.context ) );

	// Clone the elements in the slice
	slice.cloneElements();

	this.$pasteTarget.empty();

	ve.dm.converter.store = this.documentView.model.getStore();
	ve.dm.converter.internalList = this.documentView.model.getInternalList();
	ve.dm.converter.getDomSubtreeFromData( slice.getData(), this.$pasteTarget[0] );

	clipboardItem = { 'data': slice, 'hash': null };
	clipboardIndex = this.clipboard.push( clipboardItem ) - 1;

	// Check we have setData and that it actually works (returns true)
	if (
		clipboardData && clipboardData.setData &&
		clipboardData.setData( 'text/xcustom', '' ) &&
		clipboardData.setData( 'text/html', '' )
	) {
		// Webkit allows us to directly edit the clipboard
		// Disable the default event so we can override the data
		e.preventDefault();
		clipboardData.setData( 'text/xcustom', this.clipboardId + '-' + clipboardIndex );
		// As we've disabled the default event we need to set the normal clipboard data
		clipboardData.setData( 'text/html', this.$pasteTarget.html() );
		clipboardData.setData( 'text/plain', this.$pasteTarget.text() );
	} else {
		this.$pasteTarget.prepend(
			$( '<span>' ).attr( 'data-ve-clipboard-key', this.clipboardId + '-' + clipboardIndex )
		);
		clipboardItem.hash = this.constructor.static.getClipboardHash( this.$pasteTarget.contents() );
		// If direct clipboard editing is not allowed, we must use the pasteTarget to
		// select the data we want to go in the clipboard
		rangyRange = rangy.createRange( this.getElementDocument() );
		rangyRange.setStart( this.$pasteTarget[0], 0 );
		rangyRange.setEnd( this.$pasteTarget[0], this.$pasteTarget[0].childNodes.length );

		// Save scroll position before changing focus to "offscreen" paste target
		scrollTop = $window.scrollTop();

		sel = rangy.getSelection( this.getElementDocument() );
		originalRange = sel.getRangeAt( 0 ).cloneRange();
		sel.removeAllRanges();
		this.$pasteTarget[0].focus();
		sel.addRange( rangyRange, false );

		setTimeout( function () {
			sel = rangy.getSelection( view.getElementDocument() );
			sel.removeAllRanges();
			view.documentView.documentNode.$[0].focus();
			sel.addRange( originalRange );

			$window.scrollTop( scrollTop );
		} );
	}
};

/**
 * Handle native paste event
 *
 * @param {jQuery.Event} e Paste event
 */
ve.ce.Surface.prototype.onPaste = function ( e ) {
	// Prevent pasting until after we are done
	if ( this.pasting ) {
		return false;
	}
	this.pasting = true;
	this.beforePaste( e );
	setTimeout( ve.bind( this.afterPaste, this, e ) );
};

/**
 * Handle pre-paste events.
 *
 * @param {jQuery.Event} e Paste event
 */
ve.ce.Surface.prototype.beforePaste = function ( e ) {
	var tx,
		$window = $( ve.Element.getWindow( this.$$.context ) ),
		selection = this.model.getSelection(),
		clipboardData = e.originalEvent.clipboardData;

	this.beforePasteData = {};
	if ( clipboardData ) {
		this.beforePasteData.custom = clipboardData.getData( 'text/xcustom' );
		this.beforePasteData.html = clipboardData.getData( 'text/html' );
		this.beforePasteData.plain = clipboardData.getData( 'text/plain' );
	}

	// TODO: no pollOnce here: but should we add one?
	this.surfaceObserver.stopTimerLoop();

	// Pasting into a range? Remove first.
	if ( !rangy.getSelection( this.$document[0] ).isCollapsed ) {
		tx = ve.dm.Transaction.newFromRemoval( this.documentView.model, selection );
		selection = tx.translateRange( selection );
		this.model.change( tx, selection );
	}

	// Save scroll position before changing focus to "offscreen" paste target
	this.beforePasteData.scrollTop = $window.scrollTop();
	this.$pasteTarget.empty();
	this.$pasteTarget[0].focus();
};

/**
 * Handle post-paste events.
 *
 * @param {jQuery.Event} e Paste event
 */
ve.ce.Surface.prototype.afterPaste = function () {
	var clipboardKey, clipboardId, clipboardIndex,
		$elements, parts, pasteData, slice, tx,
		beforePasteData = this.beforePasteData || {},
		$window = $( ve.Element.getWindow( this.$$.context ) ),
		selection = this.model.getSelection();

	if ( beforePasteData.custom ) {
		clipboardKey = beforePasteData.custom;
	} else {
		$elements = beforePasteData.html ? $( $.parseHTML( beforePasteData.html ) ) : this.$pasteTarget.contents();

		// Try to find the clipboard key hidden in the HTML
		$elements.each( function () {
			var val = this.getAttribute && this.getAttribute( 'data-ve-clipboard-key' );
			if ( val ) {
				clipboardKey = val;
				return false;
			}
		} );

	}
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
					this.constructor.static.getClipboardHash( $elements )
			) {
				slice = this.clipboard[clipboardIndex].data;
			}
		}
	}

	if ( !slice ) {
		// TODO: try to convert the HTML
		if ( !beforePasteData.plain ) {
			beforePasteData.plain = this.$pasteTarget.text();
		}
		slice = new ve.dm.ElementLinearDataSlice(
			new ve.dm.IndexValueStore(),
			ve.splitClusters(
				// TODO: handle plain text line breaks better
				beforePasteData.plain.replace( /\n+/gm, ' ' )
			)
		);
	}

	try {
		// Try to paste in the orignal data
		// Take a copy to prevent the data being annotated a second time in the catch block
		// and to prevent actions in the data model affecting view.clipboard
		pasteData = ve.copy( slice.getOriginalData() );

		// Annotate
		ve.dm.Document.addAnnotationsToData( pasteData, this.model.getInsertionAnnotations() );

		// Transaction
		tx = ve.dm.Transaction.newFromInsertion(
			this.documentView.model,
			selection.start,
			pasteData
		);
	} catch ( err ) {
		// If that fails, balance the data before pasting
		// Take a copy to prevent actions in the data model affecting view.clipboard
		pasteData = ve.copy( slice.getData() );

		// Annotate
		ve.dm.Document.addAnnotationsToData( pasteData, this.model.getInsertionAnnotations() );

		// Transaction
		tx = ve.dm.Transaction.newFromInsertion(
			this.documentView.model,
			selection.start,
			pasteData
		);
	}

	// Restore focus and scroll position
	this.documentView.documentNode.$[0].focus();
	$window.scrollTop( beforePasteData.scrollTop );

	selection = tx.translateRange( selection );
	this.model.change( tx, new ve.Range( selection.start ) );
	// Move cursor to end of selection
	this.model.change( null, new ve.Range( selection.end ) );

	// Allow pasting again
	this.pasting = false;
	this.beforePasteData = null;
};

/**
 * Handle document composition start events.
 *
 * @method
 * @param {jQuery.Event} e Composition start event
 */
ve.ce.Surface.prototype.onDocumentCompositionStart = function () {
	if ( $.browser.msie === true ) {
		return;
	}
	this.inIme = true;
	this.handleInsertion();
};

/**
 * Handle document composition end events.
 *
 * @method
 * @param {jQuery.Event} e Composition end event
 */
ve.ce.Surface.prototype.onDocumentCompositionEnd = function () {
	this.inIme = false;
	this.incRenderLock();
	try {
		this.surfaceObserver.pollOnce();
	} finally {
		this.decRenderLock();
	}
	this.surfaceObserver.startTimerLoop();
};

/*! Custom Events */

/**
 * Handle change events.
 *
 * @see ve.dm.Surface#method-change
 *
 * @method
 * @param {ve.dm.Transaction|null} transaction
 * @param {ve.Range|undefined} selection
 */
ve.ce.Surface.prototype.onChange = function ( transaction, selection ) {
	var start, end, rangySel, rangyRange,
		next = null,
		previous = this.focusedNode;

	if ( selection ) {
		// Detect when only a single inline element is selected
		if ( !selection.isCollapsed() ) {
			start = this.documentView.getDocumentNode().getNodeFromOffset( selection.start + 1 );
			if ( ve.isMixedIn( start, ve.ce.FocusableNode ) ) {
				end = this.documentView.getDocumentNode().getNodeFromOffset( selection.end - 1 );
				if ( start === end ) {
					next = start;
				}
			}
		} else {
			// Check we haven't been programmatically placed inside a focusable node with a collapsed selection
			start = this.documentView.getDocumentNode().getNodeFromOffset( selection.start );
			if ( ve.isMixedIn( start, ve.ce.FocusableNode ) ) {
				next = start;
			}
		}
		// Update nodes if something changed
		if ( previous !== next ) {
			if ( previous ) {
				previous.setFocused( false );
				this.focusedNode = null;
			}
			if ( next ) {
				next.setFocused( true );
				this.focusedNode = start;
				// As FF won't fire a copy event with nothing selected, make
				// a dummy selection of one space in the pasteTarget.
				// onCopy will ignore this native selection and use the DM selection
				this.$pasteTarget.text( ' ' );
				rangySel = rangy.getSelection( this.getElementDocument() );
				rangyRange = rangy.createRange( this.getElementDocument() );
				rangyRange.setStart( this.$pasteTarget[0], 0 );
				rangyRange.setEnd( this.$pasteTarget[0], 1 );
				rangySel.removeAllRanges();
				this.$pasteTarget[0].focus();
				rangySel.addRange( rangyRange, false );
			}
		}

		// If there is no focused node, use native selection, but ignore the selection if
		// changeModelSelection is currently being called with the same (object-identical)
		// selection object (i.e. if the model is calling us back)
		if ( !this.focusedNode && !this.isRenderingLocked() && selection !== this.newModelSelection ) {
			this.showSelection( selection );
		}
	}
};

/**
 * Handle selection change events.
 *
 * @see ve.ce.SurfaceObserver#pollOnce
 *
 * @method
 * @param {ve.Range} oldRange
 * @param {ve.Range} newRange
 */
ve.ce.Surface.prototype.onSelectionChange = function ( oldRange, newRange ) {
	if ( oldRange && newRange.flip().equals( oldRange ) ) {
		// Ignore when the newRange is just a flipped oldRange
		return;
	}
	this.incRenderLock();
	try {
		this.changeModelSelection( newRange );
	} finally {
		this.decRenderLock();
	}
};

/**
 * Handle content change events.
 *
 * @see ve.ce.SurfaceObserver#pollOnce
 *
 * @method
 * @param {ve.ce.Node} node CE node the change occured in
 * @param {Object} previous Old data
 * @param {Object} previous.text Old plain text content
 * @param {Object} previous.hash Old DOM hash
 * @param {ve.Range} previous.range Old selection
 * @param {Object} next New data
 * @param {Object} next.text New plain text content
 * @param {Object} next.hash New DOM hash
 * @param {ve.Range} next.range New selection
 */
ve.ce.Surface.prototype.onContentChange = function ( node, previous, next ) {
	var data, range, len, annotations, offsetDiff, lengthDiff, sameLeadingAndTrailing,
		previousStart, nextStart, newRange,
		previousData, nextData,
		i, length, annotation, annotationIndex, dataString,
		annotationsLeft, annotationsRight,
		fromLeft = 0,
		fromRight = 0,
		nodeOffset = node.getModel().getOffset();

	if ( previous.range && next.range ) {
		offsetDiff = ( previous.range.isCollapsed() && next.range.isCollapsed() ) ?
			next.range.start - previous.range.start : null;
		lengthDiff = next.text.length - previous.text.length;
		previousStart = previous.range.start - nodeOffset - 1;
		nextStart = next.range.start - nodeOffset - 1;
		sameLeadingAndTrailing = offsetDiff !== null && (
			// TODO: rewrite to static method with tests
			(
				lengthDiff > 0 &&
				previous.text.substring( 0, previousStart ) ===
					next.text.substring( 0, previousStart ) &&
				previous.text.substring( previousStart ) ===
					next.text.substring( nextStart )
			) ||
			(
				lengthDiff < 0 &&
				previous.text.substring( 0, nextStart ) ===
					next.text.substring( 0, nextStart ) &&
				previous.text.substring( previousStart - lengthDiff + offsetDiff ) ===
					next.text.substring( nextStart )
			)
		);

		// Simple insertion
		if ( lengthDiff > 0 && offsetDiff === lengthDiff /* && sameLeadingAndTrailing */) {
			data = ve.splitClusters( next.text ).slice(
				previous.range.start - nodeOffset - 1,
				next.range.start - nodeOffset - 1
			);
			// Apply insertion annotations
			annotations = this.model.getInsertionAnnotations();
			if ( annotations instanceof ve.dm.AnnotationSet ) {
				ve.dm.Document.addAnnotationsToData( data, this.model.getInsertionAnnotations() );
			}
			this.incRenderLock();
			try {
				this.model.change(
					ve.dm.Transaction.newFromInsertion(
						this.documentView.model, previous.range.start, data
					),
					next.range
				);
			} finally {
				this.decRenderLock();
			}
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
				this.model.change(
					ve.dm.Transaction.newFromRemoval( this.documentView.model,
						range ),
					next.range
				);
			} finally {
				this.decRenderLock();
			}
			return;
		}
	}

	// Complex change

	previousData = ve.splitClusters( previous.text );
	nextData = ve.splitClusters( next.text );
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
	data = nextData.slice( fromLeft, nextData.length - fromRight );
	// Get annotations to the left of new content and apply
	annotations = this.model.getDocument().data.getAnnotationsFromOffset( nodeOffset + 1 + fromLeft );
	if ( annotations.getLength() ) {
		annotationsLeft = this.model.getDocument().data.getAnnotationsFromOffset( nodeOffset + fromLeft );
		annotationsRight = this.model.getDocument().data.getAnnotationsFromOffset( nodeOffset + 1 + previousData.length - fromRight );
		for ( i = 0, length = annotations.getLength(); i < length; i++ ) {
			annotation = annotations.get( i );
			annotationIndex = annotations.getIndex( i );
			if ( annotation.constructor.static.splitOnWordbreak ) {
				dataString = new ve.dm.DataString( nextData );
				if (
					// if no annotation to the right, check for wordbreak
					(
						!annotationsRight.containsIndex( annotationIndex ) &&
						unicodeJS.wordbreak.isBreak( dataString, fromLeft )
					) ||
					// if no annotation to the left, check for wordbreak
					(
						!annotationsLeft.containsIndex( annotationIndex ) &&
						unicodeJS.wordbreak.isBreak( dataString, nextData.length - fromRight )
					)
				) {
					annotations.removeAt( i );
				}
			}
		}
		ve.dm.Document.addAnnotationsToData( data, annotations );
	}
	newRange = next.range;
	if ( newRange.isCollapsed() ) {
		newRange = new ve.Range( this.getNearestCorrectOffset( newRange.start, 1 ) );
	}

	if ( data.length > 0 ) {
			this.model.change(
				ve.dm.Transaction.newFromInsertion(
					this.documentView.model, nodeOffset + 1 + fromLeft,
					data
				),
				newRange
			);
	}
	if ( fromLeft + fromRight < previousData.length ) {
		this.model.change(
			ve.dm.Transaction.newFromRemoval(
				this.documentView.model,
				new ve.Range(
					data.length + nodeOffset + 1 + fromLeft,
					data.length + nodeOffset + 1 +
						previousData.length - fromRight
				)
			),
			newRange
		);
	}
};

/**
 * Handle surface lock events.
 *
 * @method
 */
ve.ce.Surface.prototype.onLock = function () {
	this.surfaceObserver.locked = true;
};

/**
 * Handle surface unlock events.
 *
 * @method
 */
ve.ce.Surface.prototype.onUnlock = function () {
	this.surfaceObserver.locked = false;
	this.surfaceObserver.pollOnceNoEmit();
};

/*! Relocation */

/**
 * Start a relocation action.
 *
 * @see ve.ce.RelocatableNode
 *
 * @method
 * @param {ve.ce.Node} node Node being relocated
 */
ve.ce.Surface.prototype.startRelocation = function ( node ) {
	this.relocating = node;
	this.emit( 'relocationStart', node );
};

/**
 * Complete a relocation action.
 *
 * @see ve.ce.RelocatableNode
 *
 * @method
 * @param {ve.ce.Node} node Node being relocated
 */
ve.ce.Surface.prototype.endRelocation = function () {
	this.emit( 'relocationEnd', this.relocating );
	this.relocating = null;
};

/*! Utilities */

/**
 * @method
 */
ve.ce.Surface.prototype.handleLeftOrRightArrowKey = function ( e ) {
	var selection, range, direction;
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
	selection = this.model.getSelection();
	if ( this.$$( e.target ).css( 'direction' ) === 'rtl' ) {
		// If the language direction is RTL, switch left/right directions:
		direction = e.keyCode === ve.Keys.LEFT ? 1 : -1;
	} else {
		direction = e.keyCode === ve.Keys.LEFT ? -1 : 1;
	}

	range = this.getDocument().getRelativeRange(
		selection,
		direction,
		( e.altKey === true || e.ctrlKey === true ) ? 'word' : 'character',
		e.shiftKey
	);
	this.model.change( null, range );
	// TODO: onDocumentKeyDown does this anyway
	this.surfaceObserver.startTimerLoop();
	this.surfaceObserver.pollOnce();
};

/**
 * @method
 */
ve.ce.Surface.prototype.handleUpOrDownArrowKey = function ( e ) {
	var selection, rangySelection, rangyRange, range, $element, nativeSel;
	if ( !$.browser.msie ) {
		// Firefox doesn't update its internal reference of the appropriate cursor position
		// on the next or previous lines when the cursor is moved programmatically.
		// By wiggling the selection, Firefox scraps its internal reference.
		nativeSel = window.getSelection();
		nativeSel.modify( 'extend', 'right', 'character' );
		nativeSel.modify( 'extend', 'left', 'character' );
		return;
	}
	// TODO: onDocumentKeyDown did this already
	this.surfaceObserver.stopTimerLoop();
	// TODO: onDocumentKeyDown did this already
	this.surfaceObserver.pollOnce();

	selection = this.model.getSelection();
	rangySelection = rangy.getSelection( this.$document[0] );
	// Perform programatic handling only for selection that is expanded and backwards according to
	// model data but not according to browser data.
	if ( !selection.isCollapsed() && selection.isBackwards() && !rangySelection.isBackwards() ) {
		$element = $( this.documentView.getSlugAtOffset( selection.to ) );
		if ( !$element ) {
			$element = this.$$( '<span>' )
				.html( ' ' )
				.css( { 'width' : '0px', 'display' : 'none' } );
			rangySelection.anchorNode.splitText( rangySelection.anchorOffset );
			rangySelection.anchorNode.parentNode.insertBefore(
				$element[0],
				rangySelection.anchorNode.nextSibling
			);
		}
		rangyRange = rangy.createRange( this.$document[0] );
		rangyRange.selectNode( $element[0] );
		rangySelection.setSingleRange( rangyRange );
		setTimeout( ve.bind( function () {
			if ( !$element.hasClass( 've-ce-branchNode-slug' ) ) {
				$element.remove();
			}
			this.surfaceObserver.pollOnce();
			if ( e.shiftKey === true ) { // expanded range
				range = new ve.Range( selection.from, this.model.getSelection().to );
			} else { // collapsed range (just a cursor)
				range = new ve.Range( this.model.getSelection().to );
			}
			this.model.change( null, range );
			this.surfaceObserver.pollOnce();
		}, this ), 0 );
	} else {
		// TODO: onDocumentKeyDown does this anyway
		this.surfaceObserver.startTimerLoop();

		this.surfaceObserver.pollOnce();
	}
};

/**
 * Handle insertion of content.
 *
 * @method
 */
ve.ce.Surface.prototype.handleInsertion = function () {
	var slug, data, range, annotations, insertionAnnotations, placeholder,
		selection = this.model.getSelection(), documentModel = this.model.getDocument();

	// Handles removing expanded selection before inserting new text
	if ( !selection.isCollapsed() ) {
		// Pull annotations from the first character in the selection
		annotations = documentModel.data.getAnnotationsFromRange(
			new ve.Range( selection.start, selection.start + 1 )
		);
		this.model.change(
			ve.dm.Transaction.newFromRemoval( this.documentView.model, selection ),
			new ve.Range( selection.start )
		);
		this.surfaceObserver.clear();
		selection = this.model.getSelection();
		this.model.setInsertionAnnotations( annotations );
	}

	insertionAnnotations = this.model.getInsertionAnnotations() ||
		new ve.dm.AnnotationSet( documentModel.getStore() );

	if ( selection.isCollapsed() ) {
		slug = this.documentView.getSlugAtOffset( selection.start );
		// Always pawn in a slug
		if ( slug || this.needsPawn( selection, insertionAnnotations ) ) {
			placeholder = '♙';
			if ( !insertionAnnotations.isEmpty() ) {
				placeholder = [placeholder, insertionAnnotations.getIndexes()];
			}
			// is this a slug and if so, is this a block slug?
			if ( slug && documentModel.data.isStructuralOffset( selection.start ) ) {
				range = new ve.Range( selection.start + 1, selection.start + 2 );
				data = [{ 'type' : 'paragraph' }, placeholder, { 'type' : '/paragraph' }];
			} else {
				range = new ve.Range( selection.start, selection.start + 1 );
				data = [placeholder];
			}
			this.model.change(
				ve.dm.Transaction.newFromInsertion(
					this.documentView.model, selection.start, data
				),
				range
			);
		}
	}

	this.surfaceObserver.stopTimerLoop();
	this.surfaceObserver.pollOnce();
};

/**
 * Handle enter key down events.
 *
 * @method
 * @param {jQuery.Event} e Enter key down event
 */
ve.ce.Surface.prototype.handleEnter = function ( e ) {
	var tx, outerParent, outerChildrenCount, list,
		selection = this.model.getSelection(),
		documentModel = this.model.getDocument(),
		emptyParagraph = [{ 'type': 'paragraph' }, { 'type': '/paragraph' }],
		advanceCursor = true,
		node = this.documentView.getNodeFromOffset( selection.from ),
		nodeModel = node.getModel(),
		cursor = selection.from,
		contentBranchModel = nodeModel.isContent() ? nodeModel.getParent() : nodeModel,
		contentBranchModelRange = contentBranchModel.getRange(),
		stack = [],
		outermostNode = null;

	// Handle removal first
	if ( selection.from !== selection.to ) {
		tx = ve.dm.Transaction.newFromRemoval( documentModel, selection );
		selection = tx.translateRange( selection );
		this.model.change( tx, selection );
	}

	// Handle insertion
	if (
		contentBranchModel.getType() !== 'paragraph' &&
		(
			cursor === contentBranchModelRange.from ||
			cursor === contentBranchModelRange.to
		)
	) {
		// If we're at the start/end of something that's not a paragraph, insert a paragraph
		// before/after
		if ( cursor === contentBranchModelRange.from ) {
			tx = ve.dm.Transaction.newFromInsertion(
				documentModel, contentBranchModel.getOuterRange().from, emptyParagraph
			);
			advanceCursor = false;
		} else if ( cursor === contentBranchModelRange.to ) {
			tx = ve.dm.Transaction.newFromInsertion(
				documentModel, contentBranchModel.getOuterRange().to, emptyParagraph
			);
		}
	} else if ( e.shiftKey && contentBranchModel.hasSignificantWhitespace() ) {
		// Insert newline
		tx = ve.dm.Transaction.newFromInsertion( documentModel, selection.from, '\n' );
	} else {
		// Split
		node.traverseUpstream( function ( node ) {
			if ( !node.canBeSplit() ) {
				return false;
			}
			stack.splice(
				stack.length / 2,
				0,
				{ 'type': '/' + node.type },
				node.model.getClonedElement()
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
			node.model.length === 0
		) {
			// Enter was pressed in an empty list item.
			list = outermostNode.getModel().getParent();
			if ( list.getChildren().length === 1 ) {
				// The list item we're about to remove is the only child of the list
				// Remove the list
				tx = ve.dm.Transaction.newFromRemoval(
					documentModel, list.getOuterRange()
				);
			} else {
				// Remove the list item
				tx = ve.dm.Transaction.newFromRemoval(
					documentModel, outermostNode.getModel().getOuterRange()
				);
				this.model.change( tx );
				selection = tx.translateRange( selection );
				// Insert a paragraph
				tx = ve.dm.Transaction.newFromInsertion(
					documentModel, list.getOuterRange().to, emptyParagraph
				);
			}
			advanceCursor = false;
		} else {
			// We must process the transaction first because getRelativeContentOffset can't help us
			// yet
			tx = ve.dm.Transaction.newFromInsertion( documentModel, selection.from, stack );
		}
	}

	// Commit the transaction
	this.model.change( tx );
	selection = tx.translateRange( selection );

	// Now we can move the cursor forward
	if ( advanceCursor ) {
		this.model.change(
			null, new ve.Range( documentModel.data.getRelativeContentOffset( selection.from, 1 ) )
		);
	} else {
		this.model.change(
			null, new ve.Range( documentModel.data.getNearestContentOffset( selection.from ) )
		);
	}
	// Reset and resume polling
	this.surfaceObserver.clear();
};

/**
 * Handle delete and backspace key down events.
 *
 * @method
 * @param {jQuery.Event} e Delete key down event
 * @param {boolean} backspace Key was a backspace
 */
ve.ce.Surface.prototype.handleDelete = function ( e, backspace ) {
	var rangeToRemove = this.model.getSelection(),
		tx, startNode, endNode, endNodeData, nodeToDelete;

	if ( rangeToRemove.isCollapsed() ) {
		// In case when the range is collapsed use the same logic that is used for cursor left and
		// right movement in order to figure out range to remove.
		rangeToRemove = this.getDocument().getRelativeRange(
			rangeToRemove,
			backspace ? -1 : 1,
			( e.altKey === true || e.ctrlKey === true ) ? 'word' : 'character',
			true
		);
		if ( rangeToRemove.isCollapsed() ) {
			// For instance beginning or end of the document.
			return;
		}
	}
	tx = ve.dm.Transaction.newFromRemoval( this.documentView.model, rangeToRemove );
	this.model.change( tx );
	rangeToRemove = tx.translateRange( rangeToRemove );
	if ( !rangeToRemove.isCollapsed() ) {
		// If after processing removal transaction range is not collapsed it means that not
		// everything got merged nicely (at this moment transaction processor is capable of merging
		// nodes of the same type and at the same depth level only), so we process with another
		// merging that takes remaing data from endNode and inserts it at the end of startNode,
		// endNode or recrusivly its parent (if have only one child) gets removed.
		//
		// If startNode has no content then we just delete that node instead of merging.
		// This prevents content being inserted into empty structure which, e.g. and empty heading
		// will be deleted, rather than "converting" the paragraph beneath to a heading.

		endNode = this.documentView.getNodeFromOffset( rangeToRemove.end, false );

		// If endNode is within our rangeToRemove, then we shouldn't delete it
		if ( endNode.getModel().getRange().start >= rangeToRemove.end ) {
			startNode = this.documentView.getNodeFromOffset( rangeToRemove.start, false );
			if ( startNode.getModel().getRange().isCollapsed() ) {
				// Remove startNode
				this.model.change( [
					ve.dm.Transaction.newFromRemoval(
						this.documentView.model, startNode.getModel().getOuterRange()
					)
				] );
			} else {
				endNodeData = this.documentView.model.getData( endNode.getModel().getRange() );
				nodeToDelete = endNode;
				nodeToDelete.traverseUpstream( function ( node ) {
					var parent = node.getParent();
					if ( parent.children.length === 1 ) {
						nodeToDelete = parent;
						return true;
					} else {
						return false;
					}
				} );
				// Move contents of endNode into startNode, and delete nodeToDelete
				this.model.change( [
					ve.dm.Transaction.newFromRemoval(
						this.documentView.model, nodeToDelete.getModel().getOuterRange()
					),
					ve.dm.Transaction.newFromInsertion(
						this.documentView.model, rangeToRemove.start, endNodeData
					)
				] );
			}
		}
	}
	this.model.change( null, new ve.Range( rangeToRemove.start ) );
	this.surfaceObserver.clear();
};

/**
 * Show selection on a range.
 *
 * @method
 * @param {ve.Range} range Range to show selection on
 */
ve.ce.Surface.prototype.showSelection = function ( range ) {
	var start, end,
		rangySel = rangy.getSelection( this.$document[0] ),
		rangyRange = rangy.createRange( this.$document[0] );

		range = new ve.Range(
			this.getNearestCorrectOffset( range.from, -1 ),
			this.getNearestCorrectOffset( range.to, 1 )
		);

	if ( !range.isCollapsed() ) {
		start = this.documentView.getNodeAndOffset( range.start );
		end = this.documentView.getNodeAndOffset( range.end );
		rangyRange.setStart( start.node, start.offset );
		rangyRange.setEnd( end.node, end.offset );
		rangySel.removeAllRanges();
		rangySel.addRange( rangyRange, range.start !== range.from );
	} else {
		start = this.documentView.getNodeAndOffset( range.start );
		rangyRange.setStart( start.node, start.offset );
		rangySel.setSingleRange( rangyRange );
	}
};

/**
 * Append passed phantoms to phantoms container after emptying it first.
 *
 * @method
 * @param {jQuery} $phantoms Phantoms to append
 */
ve.ce.Surface.prototype.replacePhantoms = function ( $phantoms ) {
	this.$phantoms.empty().append( $phantoms );
};

/**
 * Append passed highlights to highlight container after emptying it first.
 *
 * @method
 * @param {jQuery} $highlights Highlights to append
 */
ve.ce.Surface.prototype.replaceHighlight = function ( $highlights ) {
	this.$highlights.empty().append( $highlights );
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
 */
ve.ce.Surface.prototype.getNearestCorrectOffset = function ( offset, direction ) {
	var contentOffset, structuralOffset;

	direction = direction > 0 ? 1 : -1;
	if (
		this.documentView.model.data.isContentOffset( offset ) ||
		this.hasSlugAtOffset( offset )
	) {
		return offset;
	}

	contentOffset = this.documentView.model.data.getNearestContentOffset( offset, direction );
	structuralOffset =
		this.documentView.model.data.getNearestStructuralOffset( offset, direction, true );

	if ( !this.hasSlugAtOffset( structuralOffset ) ) {
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

/**
 * Check if an offset is inside a slug.
 *
 * TODO: Find a better name and a better place for this method - probably in a document view?
 *
 * @method
 * @param {number} offset Offset to check for a slug at
 * @returns {boolean} A slug exists at the given offset
 */
ve.ce.Surface.prototype.hasSlugAtOffset = function ( offset ) {
	return !!this.documentView.getSlugAtOffset( offset );
};

/**
 * Get the number of consecutive clicks the user has performed.
 *
 * This is required for supporting double, tripple, etc. clicking across all browsers.
 *
 * @method
 * @param {Event} e Native event object
 * @returns {number} Number of clicks detected
 */
ve.ce.Surface.prototype.getClickCount = function ( e ) {
	if ( !$.browser.msie ) {
		return e.detail;
	}

	var i, response = 1;

	// Add select MouseEvent properties to the beginning of the clickHistory
	this.clickHistory.unshift( {
		x: e.x,
		y: e.y,
		timeStamp: e.timeStamp
	} );

	// Compare history
	if ( this.clickHistory.length > 1 ) {
		for ( i = 0; i < this.clickHistory.length - 1; i++ ) {
			if (
				this.clickHistory[i].x === this.clickHistory[i + 1].x &&
				this.clickHistory[i].y === this.clickHistory[i + 1].y &&
				this.clickHistory[i].timeStamp - this.clickHistory[i + 1].timeStamp < 500
			) {
				response++;
			} else {
				break;
			}
		}
	}

	// Trim old history if necessary
	if ( this.clickHistory.length > 3 ) {
		this.clickHistory.pop();
	}

	return response;
};

/**
 * Checks if we need to pawn for insertionAnnotations based on the related annotationSet.
 *
 * "Related" is typically to the left, unless at the beginning of a node.
 *
 * We choose to pawn if the related annotationSet doesn't match insertionAnnotations, or if
 * we are at the edge of an annotation that requires pawning (i.e. an annotation requiring pawning
 * is present on the left but not on the right, or vice versa).
 *
 * @method
 * @param {ve.Range} selection
 * @param {ve.dm.AnnotationSet} insertionAnnotations
 * @returns {boolean} Whether we need to pawn
 */
ve.ce.Surface.prototype.needsPawn = function ( selection, insertionAnnotations ) {
	var leftAnnotations, rightAnnotations, documentModel = this.model.documentModel;

	function isForced( annotation ) {
		return ve.ce.annotationFactory.isAnnotationContinuationForced( annotation.constructor.static.name );
	}

	if ( selection.start > 0 ) {
		leftAnnotations = documentModel.data.getAnnotationsFromOffset( selection.start - 1 );
	}
	if ( selection.start < documentModel.data.getLength() ) {
		rightAnnotations = documentModel.data.getAnnotationsFromOffset( selection.start + 1 );
	}

	// Take annotations from the left
	// TODO reorganize the logic in this function
	if ( leftAnnotations && !leftAnnotations.compareTo( insertionAnnotations ) ) {
			return true;
	}
	// At the beginning of a node, take from the right
	if (
		rangy.getSelection( this.$document[0] ).anchorOffset === 0 &&
		rightAnnotations &&
		!rightAnnotations.compareTo( insertionAnnotations )
	) {
		return true;
	}

	if (
		leftAnnotations && rightAnnotations &&
		!leftAnnotations.filter( isForced ).compareTo( rightAnnotations.filter( isForced ) )
	) {
		return true;
	}

	return false;
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
 * Get the currently focused node.
 *
 * @method
 * @returns {ve.ce.Node|undefined} Focused node
 */
ve.ce.Surface.prototype.getFocusedNode = function () {
	return this.focusedNode;
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
 * Surface 'dir' property (Content-Level Direction)
 * @returns {string} 'ltr' or 'rtl'
 */
ve.ce.Surface.prototype.getDir = function () {
	return this.$.css( 'direction' );
};

/**
 * Change selection in the model only, not the CE surface
 *
 * This avoids event storms when the CE surface is already correct
 *
 * @method
 * @param {ve.Range} range New selection for model
 * @throws {Error} If calls to the method are nested
 */
ve.ce.Surface.prototype.changeModelSelection = function ( range ) {
	if ( this.newModelSelection !== null ) {
		throw new Error( 'Nested changeModelSelection' );
	}
	this.newModelSelection = range;
	try {
		this.model.change( null, range );
	} finally {
		this.newModelSelection = null;
	}
};
