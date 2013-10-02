/*!
 * VisualEditor UserInterface SurfaceWidget class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.SurfaceWidget object.
 *
 * @class
 * @abstract
 * @extends ve.ui.Widget
 *
 * @constructor
 * @param {ve.dm.ElementLinearData} data Content data
 * @param {Object} [config] Configuration options
 * @cfg {Object[]} [tools] Toolbar configuration
 * @cfg {string[]} [commands] List of supported commands
 */
ve.ui.SurfaceWidget = function VeUiSurfaceWidget( data, config ) {
	// Config intialization
	config = config || {};

	// Parent constructor
	ve.ui.Widget.call( this, config );

	// Properties
	this.surface = new ve.ui.Surface( data, { '$$': this.$$ } );
	this.toolbar = new ve.ui.SurfaceToolbar( this.surface, { '$$': this.$$ } );

	// Initialization
	this.surface.$.addClass( 've-ui-surfaceWidget-surface' );
	this.toolbar.$.addClass( 've-ui-surfaceWidget-toolbar' );
	this.$
		.addClass( 've-ui-surfaceWidget' )
		.append( this.toolbar.$, this.surface.$ );
	if ( config.tools ) {
		this.toolbar.setup( config.tools );
	}
	if ( config.commands ) {
		this.surface.addCommands( config.commands );
	}
};

/* Inheritance */

ve.inheritClass( ve.ui.SurfaceWidget, ve.ui.Widget );

/* Methods */

/**
 * Get surface.
 *
 * @method
 * @returns {ve.ui.Surface} Surface
 */
ve.ui.SurfaceWidget.prototype.getSurface = function () {
	return this.surface;
};

/**
 * Get toolbar.
 *
 * @method
 * @returns {ve.ui.Toolbar} Toolbar
 */
ve.ui.SurfaceWidget.prototype.getToolbar = function () {
	return this.toolbar;
};

/**
 * Get content data.
 *
 * @method
 * @returns {ve.dm.ElementLinearData} Content data
 */
ve.ui.SurfaceWidget.prototype.getContent = function () {
	return this.surface.getModel().getDocument().getData();
};

/**
 * Initialize surface and toolbar.
 *
 * Widget must be attached to DOM before initializing.
 *
 * @method
 */
ve.ui.SurfaceWidget.prototype.initialize = function () {
	this.toolbar.initialize();
	this.surface.initialize();
	this.surface.view.documentView.documentNode.$.focus();
};

/**
 * Destroy surface and toolbar.
 *
 * @method
 */
ve.ui.SurfaceWidget.prototype.destroy = function () {
	if ( this.surface ) {
		this.surface.destroy();
	}
	if ( this.toolbar ) {
		this.toolbar.destroy();
	}
	this.$.remove();
};
