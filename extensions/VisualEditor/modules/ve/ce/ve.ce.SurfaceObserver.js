/*global rangy */

/*!
 * VisualEditor ContentEditable Surface class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable surface observer.
 *
 * @class
 * @mixins ve.EventEmitter
 *
 * @constructor
 * @param {ve.ce.Document} documentView Document to observe
 */
ve.ce.SurfaceObserver = function VeCeSurfaceObserver( documentView ) {
	// Mixin constructors
	ve.EventEmitter.call( this );

	// Properties
	this.documentView = documentView;
	this.domDocument = null;
	this.polling = false;
	this.timeoutId = null;
	this.frequency = 250; //ms

	// Initialization
	this.clear();
};

/* Inheritance */

ve.mixinClass( ve.ce.SurfaceObserver, ve.EventEmitter );

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
 * @param {ve.Range} oldRange
 * @param {ve.Range} newRange
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
 * Start polling.
 *
 * If {async} is false or undefined the first poll cycle will occur immediately and synchronously.
 *
 * @method
 * @param {boolean} async Poll the first time asynchronously
 */
ve.ce.SurfaceObserver.prototype.start = function ( async ) {
	this.domDocument = this.documentView.getDocumentNode().getElementDocument();
	this.polling = true;
	this.poll( async );
};

/**
 * Stop polling.
 *
 * If {poll} is false or undefined than no final poll cycle will occur and changes can be lost. If
 * it's true then a final poll cycle will occur immediately and synchronously.
 *
 * @method
 * @param {boolean} poll Poll one last time before stopping future polling
 */
ve.ce.SurfaceObserver.prototype.stop = function ( poll ) {
	if ( this.polling === true ) {
		if ( poll === true ) {
			this.poll();
		}
		this.polling = false;
		clearTimeout( this.timeoutId );
		this.timeoutId = null;
	}
};

/**
 * Poll for changes.
 *
 * If `async` is false or undefined then polling will occcur asynchronously.
 *
 * TODO: fixing selection in certain cases, handling selection across multiple nodes in Firefox
 *
 * FIXME: Does not work well (selectionChange is not emited) when cursor is placed inside a slug
 * with a mouse.
 *
 * @method
 * @param {boolean} async Poll asynchronously
 * @emits contentChange
 * @emits selectionChange
 */
ve.ce.SurfaceObserver.prototype.poll = function ( async ) {
	var delayPoll, $nodeOrSlug, node, text, hash, range, rangyRange;

	if ( this.polling === false ) {
		return;
	}

	if ( this.timeoutId !== null ) {
		clearTimeout( this.timeoutId );
		this.timeoutId = null;
	}

	delayPoll = ve.bind( function ( async ) {
		this.timeoutId = setTimeout(
			ve.bind( this.poll, this ),
			async === true ? 0 : this.frequency
		);
	}, this );

	if ( async === true ) {
		delayPoll( true );
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
			if ( !$nodeOrSlug.hasClass( 've-ce-branchNode-slug' ) ) {
				node = $nodeOrSlug.data( 'view' );
			}
		}
	}

	if ( this.node !== node ) {
		if ( node === null ) {
			this.text = null;
			this.hash = null;
			this.node = null;
		} else {
			this.text = ve.ce.getDomText( node.$[0] );
			this.hash = ve.ce.getDomHash( node.$[0] );
			this.node = node;
		}
	} else {
		if ( node !== null ) {
			text = ve.ce.getDomText( node.$[0] );
			hash = ve.ce.getDomHash( node.$[0] );
			if ( this.text !== text || this.hash !== hash ) {
				this.emit(
					'contentChange',
					node,
					{ 'text': this.text, 'hash': this.hash, 'range': this.range },
					{ 'text': text, 'hash': hash, 'range': range }
				);
				this.text = text;
				this.hash = hash;
			}
		}
	}

	// Only emit selectionChange event if there's a meaningful range difference
	if ( ( this.range && range ) ? !this.range.equals( range ) : ( this.range !== range ) ) {
		this.emit(
			'selectionChange',
			this.range,
			range
		);
		this.range = range;
	}

	delayPoll();
};
