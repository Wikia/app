/*!
 * VisualEditor UserInterface TextInputMenuWidget class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.TextInputMenuWidget object.
 *
 * @class
 * @extends ve.ui.MenuWidget
 *
 * @constructor
 * @param {ve.ui.TextInputWidget} input Text input widget to provide menu for
 * @param {Object} [config] Configuration options
 * @cfg {jQuery} [$container=input.$] Element to render menu under
 */
ve.ui.TextInputMenuWidget = function VeUiTextInputMenuWidget( input, config ) {
	// Parent constructor
	ve.ui.MenuWidget.call( this, config );

	// Properties
	this.input = input;
	this.$container = config.$container || this.input.$;
	this.onWindowResizeHandler = ve.bind( this.onWindowResize, this );

	// Initialization
	this.$.addClass( 've-ui-textInputMenuWidget' );
};

/* Inheritance */

ve.inheritClass( ve.ui.TextInputMenuWidget, ve.ui.MenuWidget );

/* Methods */

/**
 * Handle window resize event.
 *
 * @method
 * @param {jQuery.Event} e Window resize event
 */
ve.ui.TextInputMenuWidget.prototype.onWindowResize = function () {
	this.position();
};

/**
 * Shows the menu.
 *
 * @method
 * @chainable
 */
ve.ui.TextInputMenuWidget.prototype.show = function () {
	// Parent method
	ve.ui.MenuWidget.prototype.show.call( this );

	this.position();
	$( this.getElementWindow() ).on( 'resize', this.onWindowResizeHandler );
	return this;
};

/**
 * Hides the menu.
 *
 * @method
 * @chainable
 */
ve.ui.TextInputMenuWidget.prototype.hide = function () {
	// Parent method
	ve.ui.MenuWidget.prototype.hide.call( this );

	$( this.getElementWindow() ).off( 'resize', this.onWindowResizeHandler );
	return this;
};

/**
 * Positions the menu.
 *
 * @method
 * @chainable
 */
ve.ui.TextInputMenuWidget.prototype.position = function () {
	var frameOffset,
		$container = this.$container,
		dimensions = $container.offset();

	// Position under input
	dimensions.top += $container.height();
	dimensions.width = $container.width();

	// Compensate for frame position if in a differnt frame
	if ( this.input.$$.frame && this.input.$$.context !== this.$[0].ownerDocument ) {
		frameOffset = ve.Element.getRelativePosition(
			this.input.$$.frame.$, this.$.offsetParent()
		);
		dimensions.left += frameOffset.left;
		dimensions.top += frameOffset.top;
	} else {
		// Fix for RTL (for some reason, no need to fix if the frameoffset is set)
		if ( this.$.css( 'direction' ) === 'rtl' ) {
			dimensions.right = this.$.parent().position().left - dimensions.width - dimensions.left;
			// Erase the value for 'left':
			delete dimensions.left;
		}
	}

	this.$.css( dimensions );
	return this;
};
