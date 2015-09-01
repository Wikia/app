/*!
 * VisualEditor UserInterface MobileContext class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * UserInterface context that displays inspector full screen.
 *
 * @class
 * @extends ve.ui.LinearContext
 *
 * @constructor
 * @param {ve.ui.Surface} surface
 * @param {Object} [config] Configuration options
 */
ve.ui.MobileContext = function VeUiMobileContext() {
	// Parent constructor
	ve.ui.MobileContext.super.apply( this, arguments );

	// Properties
	this.transitioning = null;

	// Events
	this.inspectors.connect( this, {
		setup: [ 'toggle', true ],
		teardown: [ 'toggle', false ]
	} );

	// Initialization
	this.$element.addClass( 've-ui-mobileContext' );
	this.$group.addClass( 've-ui-mobileContext-menu' );
	this.surface.getGlobalOverlay().$element.append( this.inspectors.$element );
};

/* Inheritance */

OO.inheritClass( ve.ui.MobileContext, ve.ui.LinearContext );

/* Static Properties */

ve.ui.MobileContext.static.isMobile = true;

ve.ui.MobileContext.static.showDeleteButton = true;

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.MobileContext.prototype.createInspectorWindowManager = function () {
	return new ve.ui.MobileWindowManager( this.surface, {
		factory: ve.ui.windowFactory,
		overlay: this.surface.getGlobalOverlay()
	} );
};
