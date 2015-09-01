/*!
 * VisualEditor Standalone Initialization Target class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Initialization Standalone target.
 *
 * A platform must be constructed first. See ve.init.sa.Platform for an example.
 *
 *     @example
 *     ve.init.platform.initialize().done( function () {
 *         var target = new ve.init.sa.DesktopTarget();
 *         target.addSurface(
 *             ve.dm.converter.getModelFromDom(
 *                 ve.createDocumentFromHtml( '<p>Hello, World!</p>' )
 *             )
 *         );
 *         $( 'body' ).append( target.$element );
 *     } );
 *
 * @abstract
 * @class
 * @extends ve.init.Target
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @cfg {Object} [toolbarConfig] Configuration options for the toolbar
 */
ve.init.sa.Target = function VeInitSaTarget( config ) {
	config = config || {};
	config.toolbarConfig = $.extend( { shadow: true, actions: true, floatable: true }, config.toolbarConfig );

	// Parent constructor
	ve.init.sa.Target.super.call( this, config );

	this.actions = null;

	this.$element.addClass( 've-init-sa-target' );
};

/* Inheritance */

OO.inheritClass( ve.init.sa.Target, ve.init.Target );

/* Static properties */

ve.init.sa.Target.static.actionGroups = [
	{
		type: 'list',
		icon: 'menu',
		title: OO.ui.deferMsg( 'visualeditor-pagemenu-tooltip' ),
		include: [ 'findAndReplace', 'commandHelp' ]
	}
];

/* Methods */

/**
 * @inheritdoc
 */
ve.init.sa.Target.prototype.addSurface = function () {
	var surface = ve.init.sa.Target.super.prototype.addSurface.apply( this, arguments );
	this.$element.append( $( '<div>' ).addClass( 've-init-sa-target-surfaceWrapper' ).append( surface.$element ) );
	if ( !this.getSurface() ) {
		this.setSurface( surface );
	}
	surface.initialize();
	return surface;
};

/**
 * @inheritdoc
 */
ve.init.sa.Target.prototype.setupToolbar = function ( surface ) {
	// Parent method
	ve.init.sa.Target.super.prototype.setupToolbar.call( this, surface );

	this.getToolbar().$element.addClass( 've-init-sa-target-toolbar' );
};
