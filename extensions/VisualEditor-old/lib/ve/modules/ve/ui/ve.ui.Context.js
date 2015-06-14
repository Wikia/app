/*!
 * VisualEditor UserInterface Context class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
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
	this.inspectors = new ve.ui.WindowSet(
		ve.ui.windowFactory, { '$': this.$, '$contextOverlay': this.$element }
	);
};

/* Inheritance */

OO.inheritClass( ve.ui.Context, OO.ui.Element );

/* Methods */

/**
 * Get the surface the context is being used in.
 *
 * @method
 * @returns {ve.ui.Surface} Surface of context
 */
ve.ui.Context.prototype.getSurface = function () {
	return this.surface;
};

/**
 * Get an inspector.
 *
 * @method
 * @param {string} Symbolic name of inspector
 * @returns {ve.ui.Inspector|undefined} Inspector or undefined if none exists by that name
 */
ve.ui.Context.prototype.getInspector = function ( name ) {
	return this.inspectors.getWindow( name );
};

/**
 * Close the current inspector if there is one.
 *
 * @method
 */
ve.ui.Context.prototype.closeCurrentInspector = function () {
	if ( this.inspectors.getCurrentWindow() ) {
		this.inspectors.getCurrentWindow().close( { 'action': 'back' } );
	}
};

/**
 * Close the current inspector if there is one.
 *
 * @method
 */
ve.ui.Context.prototype.closeCurrentInspector = function () {
	if ( this.inspectors.getCurrentWindow() ) {
		this.inspectors.getCurrentWindow().close( { 'action': 'back' } );
	}
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
 * Hide the context.
 *
 * @method
 * @abstract
 * @chainable
 * @throws {Error} If this method is not overridden in a concrete subclass
 */
ve.ui.Context.prototype.hide = function () {
	throw new Error( 've.ui.Context.hide must be overridden in subclass' );
};
