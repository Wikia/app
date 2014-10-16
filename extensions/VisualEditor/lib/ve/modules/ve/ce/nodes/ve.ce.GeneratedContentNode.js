/*!
 * VisualEditor ContentEditable GeneratedContentNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable generated content node.
 *
 * @class
 * @abstract
 *
 * @constructor
 */
ve.ce.GeneratedContentNode = function VeCeGeneratedContentNode() {
	// Properties
	this.generatingPromise = null;

	// Events
	this.model.connect( this, { 'update': 'onGeneratedContentNodeUpdate' } );
	this.connect( this, {
		'setup': 'onGeneratedContentSetup',
		'teardown': 'onGeneratedContentTeardown'
	} );

	// Initialization
	this.update();
};

/* Events */

/**
 * @event setup
 */

/**
 * @event teardown
 */

/**
 * @event rerender
 */

/* Static members */

ve.ce.GeneratedContentNode.static = {};

// this.$element is just a wrapper for the real content, so don't duplicate attributes on it
ve.ce.GeneratedContentNode.static.renderHtmlAttributes = false;

/* Abstract methods */

/**
 * Start a deferred process to generate the contents of the node.
 *
 * If successful, the returned promise must be resolved with the generated DOM elements passed
 * in as the first parameter, i.e. promise.resolve( domElements ); . Any other parameters to
 * .resolve() are ignored.
 *
 * If the returned promise object is abortable (has an .abort() method), .abort() will be called if
 * a newer update is started before the current update has finished. When a promise is aborted, it
 * should cease its work and shouldn't be resolved or rejected. If an outdated update's promise
 * is resolved or rejected anyway (which may happen if an aborted promise misbehaves, or if the
 * promise wasn't abortable), this is ignored and doneGenerating()/failGenerating() is not called.
 *
 * Additional data may be passed in the config object to instruct this function to render something
 * different than what's in the model. This data is implementation-specific and is passed through
 * by forceUpdate().
 *
 * @abstract
 * @param {Object} [config] Optional additional data
 * @returns {jQuery.Promise} Promise object, may be abortable
 */
ve.ce.GeneratedContentNode.prototype.generateContents = function () {
	throw new Error( 've.ce.GeneratedContentNode subclass must implement generateContents' );
};

/* Methods */

/**
 * Handler for the update event
 */
ve.ce.GeneratedContentNode.prototype.onGeneratedContentNodeUpdate = function () {
	this.update();
};

/**
 * Handler for the setup event
 */
ve.ce.GeneratedContentNode.prototype.onGeneratedContentSetup = function () {
	this.$element.addClass( 've-ce-generatedContentNode ve-ce-noHighlight' );
};

/**
 * Handler for the teardown event
 */
ve.ce.GeneratedContentNode.prototype.onGeneratedContentTeardown = function () {
	this.$element.removeClass( 've-ce-generatedContentNode ve-ce-noHighlight' );
	this.abortGenerating();
};

/**
 * Make an array of DOM elements suitable for rendering.
 *
 * Subclasses can override this to provide their own cleanup steps. This function takes an
 * array of DOM elements cloned within the source document and returns an array of DOM elements
 * cloned into the target document. If it's important that the DOM elements still be associated
 * with the original document, you should modify domElements before calling the parent
 * implementation, otherwise you should call the parent implementation first and modify its
 * return value.
 *
 * @param {HTMLElement[]} domElements Clones of the DOM elements from the store
 * @returns {HTMLElement[]} Clones of the DOM elements in the right document, with modifications
 */
ve.ce.GeneratedContentNode.prototype.getRenderedDomElements = function ( domElements ) {
	var i, len, attr, $rendering,
		doc = this.getElementDocument();

	/**
	 * Callback for jQuery.fn.each that resolves the value of attr to the computed
	 * property value. Called in the context of an HTMLElement.
	 * @private
	 */
	function resolveAttribute() {
		this.setAttribute( attr, this[attr] );
	}

	// Copy domElements so we can modify the elements
	// Filter out link, meta and style tags for bug 50043
	$rendering = this.$( domElements ).not( 'link, meta, style' );
	// Also remove link, meta and style tags nested inside other tags
	$rendering.find( 'link, meta, style' ).remove();

	// Render the computed values of some attributes
	for ( i = 0, len = ve.dm.Converter.computedAttributes.length; i < len; i++ ) {
		attr = ve.dm.Converter.computedAttributes[i];
		$rendering.find( '[' + attr + ']' )
			.add( $rendering.filter( '[' + attr + ']' ) )
			.each( resolveAttribute );
	}

	// Clone the elements into the target document
	return ve.copyDomElements( $rendering.toArray(), doc );
};

/**
 * Rerender the contents of this node.
 *
 * @param {Object|string|Array} generatedContents Generated contents, in the default case an HTMLElement array
 * @fires setup
 * @fires teardown
 */
ve.ce.GeneratedContentNode.prototype.render = function ( generatedContents ) {
	if ( this.live ) {
		this.emit( 'teardown' );
	}
	this.$element.empty().append( this.getRenderedDomElements( ve.copyDomElements( generatedContents ) ) );
	if ( this.live ) {
		this.emit( 'setup' );
		this.afterRender( generatedContents );
	}
};

/**
 * Trigger rerender events after rendering the contents of the node.
 *
 * Nodes may override this method if the rerender event needs to be deferred (e.g. until images have loaded)
 *
 * @param {Object|string|Array} generatedContents Generated contents
 * @fires rerender
 */
ve.ce.GeneratedContentNode.prototype.afterRender = function () {
	var focusWidget;
	this.emit( 'rerender' );
	// Wikia change: Adjust focus widget size after node is rerendered
	// TODO: Find a more elegant way to do this, perhaps using a re-emitted event. Focus widget should
	// preferably not be manipulated from this class.
	focusWidget = this.surface.getSurface().getFocusWidget();
	if ( focusWidget ) {
		focusWidget.adjustLayout();
	}
};

/**
 * Update the contents of this node based on the model and config data. If this combination of
 * model and config data has been rendered before, the cached rendering in the store will be used.
 *
 * @param {Object} [config] Optional additional data to pass to generateContents()
 */
ve.ce.GeneratedContentNode.prototype.update = function ( config ) {
	var store = this.model.doc.getStore(),
		index = store.indexOfHash( OO.getHash( [ this.model, config ] ) );
	if ( index !== null ) {
		this.render( store.value( index ) );
	} else {
		this.forceUpdate( config );
	}
};

/**
 * Force the contents to be updated. Like update(), but bypasses the store.
 *
 * @param {Object} [config] Optional additional data to pass to generateContents()
 */
ve.ce.GeneratedContentNode.prototype.forceUpdate = function ( config ) {
	var promise, node = this;

	if ( this.generatingPromise ) {
		// Abort the currently pending generation process if possible
		this.abortGenerating();
	} else {
		// Only call startGenerating if we weren't generating before
		this.startGenerating();
	}

	// Create a new promise
	promise = this.generatingPromise = this.generateContents( config );
	promise
		// If this promise is no longer the currently pending one, ignore it completely
		.done( function ( generatedContents ) {
			if ( node.generatingPromise === promise ) {
				node.doneGenerating( generatedContents, config );
			}
		} )
		.fail( function () {
			if ( node.generatingPromise === promise ) {
				node.failGenerating();
			}
		} );
};

/**
 * Called when the node starts generating new content.
 *
 * This function is only called when the node wasn't already generating content. If a second update
 * comes in, this function will only be called if the first update has already finished (i.e.
 * doneGenerating or failGenerating has already been called).
 *
 * @method
 */
ve.ce.GeneratedContentNode.prototype.startGenerating = function () {
	this.$element.addClass( 've-ce-generatedContentNode-generating' );
};

/**
 * Abort the currently pending generation, if any, and remove the generating CSS class.
 *
 * This invokes .abort() on the pending promise if the promise has that method. It also ensures
 * that if the promise does get resolved or rejected later, this is ignored.
 */
ve.ce.GeneratedContentNode.prototype.abortGenerating = function () {
	var promise = this.generatingPromise;
	if ( promise ) {
		// Unset this.generatingPromise first so that if the promise is resolved or rejected
		// from within .abort(), this is ignored as it should be
		this.generatingPromise = null;
		if ( $.isFunction( promise.abort ) ) {
			promise.abort();
		}
	}
	this.$element.removeClass( 've-ce-generatedContentNode-generating' );
};

/**
 * Called when the node successfully finishes generating new content.
 *
 * @method
 * @param {Object|string|Array} generatedContents Generated contents
 * @param {Object} [config] Config object passed to forceUpdate()
 */
ve.ce.GeneratedContentNode.prototype.doneGenerating = function ( generatedContents, config ) {
	var store, hash;

	// Because doneGenerating is invoked asynchronously, the model node may have become detached
	// in the meantime. Handle this gracefully.
	if ( this.model.doc ) {
		store = this.model.doc.getStore();
		hash = OO.getHash( [ this.model, config ] );
		store.index( generatedContents, hash );
	}

	this.$element.removeClass( 've-ce-generatedContentNode-generating' );
	this.generatingPromise = null;
	this.render( generatedContents );
};

/**
 * Called when the has failed to generate new content.
 *
 * @method
 */
ve.ce.GeneratedContentNode.prototype.failGenerating = function () {
	this.$element.removeClass( 've-ce-generatedContentNode-generating' );
	this.generatingPromise = null;
};
