/*!
 * VisualEditor UserInterface TargetWidget class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Creates an ve.ui.TargetWidget object.
 *
 * @class
 * @abstract
 * @extends OO.ui.Widget
 *
 * @constructor
 * @param {ve.dm.Document} doc Document model
 * @param {Object} [config] Configuration options
 * @cfg {Object[]} [tools] Toolbar configuration
 * @cfg {string[]|null} [includeCommands] List of commands to include, null for all registered commands
 * @cfg {string[]} [excludeCommands] List of commands to exclude
 * @cfg {Object} [importRules] Import rules
 * @cfg {string} [inDialog] The name of the dialog this surface widget is in
 */
ve.ui.TargetWidget = function VeUiTargetWidget( doc, config ) {
	// Config initialization
	config = config || {};

	// Parent constructor
	OO.ui.Widget.call( this, config );

	// Properties
	this.surface = ve.init.target.createSurface( doc, {
		includeCommands: config.includeCommands,
		excludeCommands: config.excludeCommands,
		importRules: config.importRules,
		inDialog: config.inDialog
	} );
	this.toolbar = new ve.ui.Toolbar();

	// Initialization
	this.surface.$element.addClass( 've-ui-targetWidget-surface' );
	this.toolbar.$element.addClass( 've-ui-targetWidget-toolbar' );
	this.toolbar.$bar.append( this.surface.getToolbarDialogs().$element );
	this.$element
		.addClass( 've-ui-targetWidget' )
		.append( this.toolbar.$element, this.surface.$element );
	if ( config.tools ) {
		this.toolbar.setup( config.tools, this.surface );
	}
};

/* Inheritance */

OO.inheritClass( ve.ui.TargetWidget, OO.ui.Widget );

/* Methods */

/**
 * Get surface.
 *
 * @method
 * @return {ve.ui.Surface} Surface
 */
ve.ui.TargetWidget.prototype.getSurface = function () {
	return this.surface;
};

/**
 * Get toolbar.
 *
 * @method
 * @return {OO.ui.Toolbar} Toolbar
 */
ve.ui.TargetWidget.prototype.getToolbar = function () {
	return this.toolbar;
};

/**
 * Get content data.
 *
 * @method
 * @return {ve.dm.ElementLinearData} Content data
 */
ve.ui.TargetWidget.prototype.getContent = function () {
	return this.surface.getModel().getDocument().getData();
};

/**
 * Initialize surface and toolbar.
 *
 * Widget must be attached to DOM before initializing.
 *
 * @method
 */
ve.ui.TargetWidget.prototype.initialize = function () {
	this.toolbar.initialize();
	this.surface.initialize();
};

/**
 * Destroy surface and toolbar.
 *
 * @method
 */
ve.ui.TargetWidget.prototype.destroy = function () {
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
ve.ui.TargetWidget.prototype.focus = function () {
	this.surface.getView().focus();
};
