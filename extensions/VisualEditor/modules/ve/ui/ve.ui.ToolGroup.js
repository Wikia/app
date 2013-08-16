/*!
 * VisualEditor UserInterface ToolGroup class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface tool group.
 *
 * @class
 * @abstract
 * @extends ve.ui.Widget
 * @mixins ve.ui.GroupElement
 *
 * @constructor
 * @param {ve.ui.Toolbar} toolbar
 * @param {Object} [config] Config options
 */
ve.ui.ToolGroup = function VeUiToolGroup( toolbar, config ) {
	// Parent constructor
	ve.ui.Widget.call( this, config );

	// Mixin constructors
	ve.ui.GroupElement.call( this, this.$ );

	// Properties
	this.toolbar = toolbar;

	// Events
	this.$.on( { 'mousedown': false } );

	// Initialization
	this.$.addClass( 've-ui-toolGroup' );
};

/* Inheritance */

ve.inheritClass( ve.ui.ToolGroup, ve.ui.Widget );

ve.mixinClass( ve.ui.ToolGroup, ve.ui.GroupElement );
