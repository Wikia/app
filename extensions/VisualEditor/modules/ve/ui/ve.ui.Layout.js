/*!
 * VisualEditor UserInterface Layout class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.Layout object.
 *
 * @class
 * @abstract
 * @extends ve.Element
 * @mixin ve.EventEmitter
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.Layout = function VeUiLayout( config ) {
	// Initialize config
	config = config || {};

	// Parent constructor
	ve.Element.call( this, config );

	// Mixin constructors
	ve.EventEmitter.call( this );

	// Initialization
	this.$.addClass( 've-ui-layout' );
};

/* Inheritance */

ve.inheritClass( ve.ui.Layout, ve.Element );

ve.mixinClass( ve.ui.Layout, ve.EventEmitter );
