/*global rangy */

/*!
 * VisualEditor ContentEditable Surface class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable surface observer.
 *
 * @class
 * @mixins OO.EventEmitter
 *
 * @constructor
 * @param {ve.ce.Document} documentView Document to observe
 */
ve.ce.SurfaceObserver = function VeCeSurfaceObserver( documentView ) {
	// Mixin constructors
	OO.EventEmitter.call( this );

	// Properties
	this.documentView = documentView;
	this.domDocument = null;
	this.polling = false;
	this.timeoutId = null;
	this.frequency = 250; // ms

	// Initialization
	this.clear();
};

/* Inheritance */

OO.mixinClass( ve.ce.SurfaceObserver, OO.EventEmitter );

/* Events */

/**
 * When #poll sees a change this event is emitted (before the
 * properties are updated).
 *
 * @event contentChange
 * @param {HTMLElement} node DOM node the change occured in
 * @param {Object} previous Old data
 * @param {Object} previous.text Old plain text content
 * @param {Object} previous.hash Old DOM hash
 * @param {ve.Range} previous.range Old selection
 * @param {Object} next New data
 * @param {Object} next.text New plain text content
 * @param {Object} next.hash New DOM hash
 * @param {ve.Range} next.range New selection
 */

/**
 * When #poll observes a change in the document and the new
 * selection does not equal as the last known selection, this event
 * is emitted (before the properties are updated).
 *
 * @event selectionChange
 * @param {ve.Range|null} oldRange
 * @param {ve.Range|null} newRange
 */

/* Methods */

/**
 * Clear polling data.
 *
 * @method
 * @param {ve.Range} range Initial range to use
 */
ve.ce.SurfaceObserver.prototype.clear = function ( range ) {
	this.rangyRange = null;
	this.range = range || null;
	this.node = null;
	this.text = null;
	this.hash = null;
};

/**
 * Detach from the document view
 *
 * @method
 */
ve.ce.SurfaceObserver.prototype.detach = function () {
	this.documentView = null;
	this.domDocument = null;
};

/**
 * Start the setTimeout synchronisation loop
 *
 * @method
 */
ve.ce.SurfaceObserver.prototype.startTimerLoop = function () {
	this.domDocument = this.documentView.getDocumentNode().getElementDocument();
	this.polling = true;
	this.timerLoop( true ); // will not sync immediately, because timeoutId should be null
};

/**
 * Loop once with `setTimeout`
 * @method
 * @param {boolean} firstTime Wait before polling
 */
ve.ce.SurfaceObserver.prototype.timerLoop = function ( firstTime ) {
	if ( this.timeoutId ) {
		// in case we're not running from setTimeout
		clearTimeout( this.timeoutId );
		this.timeoutId = null;
	}
	if ( !firstTime ) {
		this.pollOnce();
	}
	// only reach this point if pollOnce does not throw an exception
	if ( this.frequency !== null ) {
		this.timeoutId = setTimeout( ve.bind( this.timerLoop, this ), this.frequency );
	}
};

/**
 * Stop polling
 *
 * @method
 */
ve.ce.SurfaceObserver.prototype.stopTimerLoop = function () {
	if ( this.polling === true ) {
		this.polling = false;
		clearTimeout( this.timeoutId );
		this.timeoutId = null;
	}
};

/**
 * Poll for changes.
 *
 * TODO: fixing selection in certain cases, handling selection across multiple nodes in Firefox
 *
 * FIXME: Does not work well (selectionChange is not emitted) when cursor is placed inside a slug
 * with a mouse.
 *
 * @method
 * @fires contentChange
 * @fires selectionChange
 */
ve.ce.SurfaceObserver.prototype.pollOnce = function () {
	this.pollOnceInternal( true );
};

/**
 * Poll to update SurfaceObserver, but don't emit change events
 *
 * @method
 */
ve.ce.SurfaceObserver.prototype.pollOnceNoEmit = function () {
	this.pollOnceInternal( false );
};

/**
 * Poll for changes.
 *
 * TODO: fixing selection in certain cases, handling selection across multiple nodes in Firefox
 *
 * FIXME: Does not work well (selectionChange is not emitted) when cursor is placed inside a slug
 * with a mouse.
 *
 * @method
 * @private
 * @param {boolean} emitChanges Emit change events if selection changed
 * @fires contentChange
 * @fires selectionChange
 */
ve.ce.SurfaceObserver.prototype.pollOnceInternal = function ( emitChanges ) {
	var $nodeOrSlug, node, text, hash, range, rangyRange, $slugWrapper, observer = this;

	if ( !this.domDocument ) {
		return;
	}

	range = this.range;
	node = this.node;
	rangyRange = ve.ce.DomRange.newFromDomSelection( rangy.getSelection( this.domDocument ) );

	if ( !rangyRange.equals( this.rangyRange ) ) {
		this.rangyRange = rangyRange;
		node = null;
		$nodeOrSlug = $( rangyRange.anchorNode ).closest( '.ve-ce-branchNode, .ve-ce-branchNode-slug' );
		if ( $nodeOrSlug.length ) {
			range = rangyRange.getRange();
			if ( $nodeOrSlug.hasClass( 've-ce-branchNode-slug' ) ) {
				$slugWrapper = $nodeOrSlug.closest( '.ve-ce-branchNode-blockSlugWrapper' );
			} else {
				node = $nodeOrSlug.data( 'view' );
				// Check this node belongs to our document
				if ( node && node.root !== this.documentView.getDocumentNode() ) {
					node = null;
					range = null;
				}
			}
		}

		if ( this.$slugWrapper && !this.$slugWrapper.is( $slugWrapper ) ) {
			this.$slugWrapper
				.addClass( 've-ce-branchNode-blockSlugWrapper-unfocused' )
				.removeClass( 've-ce-branchNode-blockSlugWrapper-focused' );
			this.$slugWrapper = null;
			// Emit 'position' on the surface view after the animation completes
			setTimeout( function () {
				if ( observer.documentView ) {
					observer.documentView.documentNode.surface.emit( 'position' );
				}
			}, 200 );
		}

		if ( $slugWrapper && !$slugWrapper.is( this.$slugWrapper) ) {
			this.$slugWrapper = $slugWrapper
				.addClass( 've-ce-branchNode-blockSlugWrapper-focused' )
				.removeClass( 've-ce-branchNode-blockSlugWrapper-unfocused' );
		}

	}

	if ( this.node !== node ) {
		if ( node === null ) {
			this.text = null;
			this.hash = null;
			this.node = null;
		} else {
			this.text = ve.ce.getDomText( node.$element[0] );
			this.hash = ve.ce.getDomHash( node.$element[0] );
			this.node = node;
		}
	} else if ( node !== null ) {
		text = ve.ce.getDomText( node.$element[0] );
		hash = ve.ce.getDomHash( node.$element[0] );
		if ( this.text !== text || this.hash !== hash ) {
			if ( emitChanges ) {
				this.emit(
					'contentChange',
					node,
					{
						'text': this.text,
						'hash': this.hash,
						'range': this.range
					},
					{ 'text': text, 'hash': hash, 'range': range }
				);
			}
			this.text = text;
			this.hash = hash;
		}
	}

	// Only emit selectionChange event if there's a meaningful range difference
	if ( ( this.range && range ) ? !this.range.equals( range ) : ( this.range !== range ) ) {
		if ( emitChanges ) {
			this.emit(
				'selectionChange',
				this.range,
				range
			);
		}
		this.range = range;
	}
};
