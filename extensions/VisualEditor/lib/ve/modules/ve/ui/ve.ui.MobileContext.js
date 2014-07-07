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
		'open': 'show',
		'closing': 'hide'
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
	this.scrollPos = $( 'body' ).scrollTop();
	// overflow: hidden on 'body' alone is not enough for iOS Safari
	$( 'html, body' ).addClass( 've-ui-mobileContext-enabled' );
	this.$element.addClass( 've-ui-mobileContext-visible' );
};

/**
 * @inheritdoc
 */
ve.ui.MobileContext.prototype.hide = function () {
	var self = this;

	this.$element.removeClass( 've-ui-mobileContext-visible' );
	// Make sure that the global overlay is hidden only after the transition
	// of MobileContext finishes (see ve.ui.MobileContext.css).
	setTimeout( function () {
		$( 'html, body' ).removeClass( 've-ui-mobileContext-enabled' );
		$( 'body' ).scrollTop( self.scrollPos );
	}, 300 );
};
