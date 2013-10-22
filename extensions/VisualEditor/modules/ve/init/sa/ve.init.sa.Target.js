/*!
 * VisualEditor Standalone Initialization Target class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Initialization Standalone target.
 *
 *     @example
 *     new ve.init.sa.Target(
 *         $( '<div>' ).appendTo( 'body' ), ve.createDocumentFromHtml( '<p>Hello world.</p>' )
 *     );
 *
 * @class
 * @extends ve.init.Target
 *
 * @constructor
 * @param {jQuery} $container Container to render target into
 * @param {ve.dm.Document} doc Document model
 */
ve.init.sa.Target = function VeInitSaTarget( $container, doc ) {
	// Parent constructor
	ve.init.Target.call( this, $container );

	// Properties
	this.surface = new ve.ui.Surface( doc );
	this.toolbar = new ve.ui.TargetToolbar( this, this.surface, { 'shadow': true } );

	// Initialization
	this.toolbar.$.addClass( 've-init-sa-target-toolbar' );
	this.toolbar.setup( this.constructor.static.toolbarGroups );
	this.toolbar.enableFloatable();

	this.$.append( this.toolbar.$, this.surface.$ );

	this.toolbar.initialize();
	this.surface.addCommands( this.constructor.static.surfaceCommands );
	this.surface.initialize();
};

/* Inheritance */

ve.inheritClass( ve.init.sa.Target, ve.init.Target );
