/*!
 * VisualEditor UserInterface SurfaceWidget class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Creates an ve.ui.SurfaceWidget object.
 *
 * @class
 * @abstract
 * @extends OO.ui.Widget
 *
 * @constructor
 * @param {ve.dm.Document} doc Document model
 * @param {Object} [config] Configuration options
 * @cfg {Object[]} [tools] Toolbar configuration
 * @cfg {string[]} [excludeCommands] List of commands to exclude
 * @cfg {Object} [importRules] Import rules
 */
ve.ui.SurfaceWidget = function VeUiSurfaceWidget( doc, config ) {
	// Config initialization
	config = config || {};

	// Parent constructor
	OO.ui.Widget.call( this, config );

	// Properties
	this.surface = ve.init.target.createSurface( doc, {
		$: this.$,
		excludeCommands: config.excludeCommands,
		importRules: config.importRules
	} );
	this.toolbar = new ve.ui.Toolbar( this.surface, { $: this.$ } );

	// Initialization
	this.surface.$element.addClass( 've-ui-surfaceWidget-surface' );
	this.toolbar.$element.addClass( 've-ui-surfaceWidget-toolbar' );
	this.$element
		.addClass( 've-ui-surfaceWidget' )
		.append( this.toolbar.$element, this.surface.$element );
	if ( config.tools ) {
		this.toolbar.setup( config.tools, this.surface );
	}
};

/* Inheritance */

OO.inheritClass( ve.ui.SurfaceWidget, OO.ui.Widget );

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
 * @returns {OO.ui.Toolbar} Toolbar
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
	this.$element.remove();
};

/**
 * Focus the surface.
 */
ve.ui.SurfaceWidget.prototype.focus = function () {
	this.surface.getView().focus();
};
