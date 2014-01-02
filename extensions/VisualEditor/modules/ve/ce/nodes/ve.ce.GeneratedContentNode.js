/*!
 * VisualEditor ContentEditable GeneratedContentNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
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

	// DOM changes
	this.$.addClass( 've-ce-generatedContentNode' );

	// Events
	this.model.connect( this, { 'update': 'onGeneratedContentNodeUpdate' } );

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

// this.$ is just a wrapper for the real content, so don't duplicate attributes on it
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
 * Rerender the contents of this node.
 *
 * @param {HTMLElement[]} domElements Array of DOM elements
 * @emits setup
 * @emits teardown
 */
ve.ce.GeneratedContentNode.prototype.render = function ( domElements ) {
	var $rendering, doc = this.getElementDocument();
	if ( this.live ) {
		this.emit( 'teardown' );
	}
	// Filter out link, meta and style tags for bug 50043
	$rendering = $( ve.copyDomElements( domElements, doc ) ).not( 'link, meta, style' );
	// Also remove link, meta and style tags nested inside other tags
	$rendering.find( 'link, meta, style' ).remove();
	this.$.empty().append( $rendering );
	if ( this.live ) {
		this.emit( 'setup' );
		this.afterRender( domElements );
	}
};

/**
 * Trigger rerender events after rendering the contents of the node.
 *
 * Nodes may override this method if the rerender event needs to be deferred (e.g. until images have loaded)
 *
 * @param {HTMLElement[]} domElements Array of DOM elements
 * @emits rerender
 */
ve.ce.GeneratedContentNode.prototype.afterRender = function () {
	this.emit( 'rerender' );
};

/**
 * Update the contents of this node based on the model and config data. If this combination of
 * model and config data has been rendered before, the cached rendering in the store will be used.
 *
 * @param {Object} [config] Optional additional data to pass to generateContents()
 */
ve.ce.GeneratedContentNode.prototype.update = function ( config ) {
	var store = this.model.doc.getStore(),
		index = store.indexOfHash( ve.getHash( [ this.model, config ] ) );
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
		// Unset this.generatingPromise first so that if the promise is resolved or rejected
		// when we abort, this is ignored as it should be
		promise = this.generatingPromise;
		this.generatingPromise = null;
		if ( $.isFunction( promise.abort ) ) {
			promise.abort();
		}
	} else {
		// Only call startGenerating() if we weren't generating before
		this.startGenerating();
	}

	// Create a new promise
	promise = this.generatingPromise = this.generateContents( config );
	promise
		// If this promise is no longer the currently pending one, ignore it completely
		.done( function ( domElements ) {
			if ( node.generatingPromise === promise ) {
				node.doneGenerating( domElements, config );
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
	this.$.addClass( 've-ce-generatedContentNode-generating' );
};

/**
 * Called when the node successfully finishes generating new content.
 *
 * @method
 * @param {HTMLElement[]} domElements Generated content
 * @param {Object} [config] Config object passed to forceUpdate()
 */
ve.ce.GeneratedContentNode.prototype.doneGenerating = function ( domElements, config ) {
	var store = this.model.doc.getStore(),
		hash = ve.getHash( [ this.model, config ] );
	store.index( domElements, hash );
	this.$.removeClass( 've-ce-generatedContentNode-generating' );
	this.generatingPromise = null;
	this.render( domElements );
};

/**
 * Called when the has failed to generate new content.
 *
 * @method
 */
ve.ce.GeneratedContentNode.prototype.failGenerating = function () {
	this.$.removeClass( 've-ce-generatedContentNode-generating' );
	this.generatingPromise = null;
};
