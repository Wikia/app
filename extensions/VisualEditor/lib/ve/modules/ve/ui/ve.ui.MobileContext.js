/*!
 * VisualEditor UserInterface MobileContext class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface context that displays inspector full screen.
 *
 * @class
 * @extends ve.ui.Context
 *
 * @constructor
 * @param {ve.ui.Surface} surface
 * @param {Object} [config] Configuration options
 */
ve.ui.MobileContext = function VeUiMobileContext( surface, config ) {
	// Parent constructor
	ve.ui.Context.call( this, surface, config );

	// Events
	this.inspectors.connect( this, {
		'setup': 'show',
		'teardown': 'hide'
	} );

	// Initialization
	this.$element
		.addClass( 've-ui-mobileContext' )
		.append( this.inspectors.$element );
};

/* Inheritance */

OO.inheritClass( ve.ui.MobileContext, ve.ui.Context );

/* Methods */

/**
 * Shows the context.
 *
 * @method
 * @chainable
 */
ve.ui.MobileContext.prototype.show = function () {
	this.$element.addClass( 've-ui-mobileContext-visible' );
	this.surface.showGlobalOverlay();
};

/**
 * @inheritdoc
 */
ve.ui.MobileContext.prototype.hide = function () {
	var self = this;

	this.surface.hideGlobalOverlay();
	// Make sure that the context is hidden only after the transition
	// of global overlay finishes (see ve.ui.MobileSurface.css).
	setTimeout( function () {
		self.$element.removeClass( 've-ui-mobileContext-visible' );
	}, 300 );
};
