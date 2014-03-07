/*!
 * VisualEditor loading indicator
 */

/* global mw */

/**
 * Loading indicator with icon and message.
 *
 * @class
 * @constructor
 * @param {string} Icon class
 * @param {string} Message label
 */
veIndicator = function( icon, message ) {
	this.initialize( icon, message );
};


/**
 * Create and initialize the indicator. This method does not yet display the indicator.
 *
 * @method
 * @param {string} Icon class
 * @param {string} Message label
 */
veIndicator.prototype.initialize = function( icon, message ) {
	this.$indicator = $( '<div>' ).addClass( 've-indicator visible' );
	var $content = $( '<div>' ).addClass( 'content' ),
		$icon = $( '<div>' ).addClass( 'icon ' + icon ),
		$message = $( '<p>' )
			.addClass( 'message' )
			.text( mw.message( message ).plain() )
			.show();

	$content
		.append( $icon )
		.append( $message );

	this.$indicator
		.append( $content )
		.appendTo( $( 'body' ) )
		.css( { 'opacity': 1, 'z-index': 99999999 } )
		.hide();
};

/**
 * Set the icon class for the indicator.
 *
 * @method
 * @param {string} Icon class
 * @returns {void}
 */
veIndicator.prototype.setIcon = function ( icon ) {
	this.$indicator.find( 'div.icon' ).attr( 'class', 'icon ' + icon );
};

/**
 * Set the message for the indicator.
 *
 * @method
 * @param {string} Message label
 * @returns {void}
 */
veIndicator.prototype.setMessage = function ( message ) {
	this.$indicator.find( 'p.message' ).text( mw.message( message ).plain() );
};

/**
 * Show the indicator using jQuery's fade-in effect.
 *
 * @method
 * @returns {void}
 */
veIndicator.prototype.show = function() {
	this.$indicator.fadeIn();
};

/**
 * Hide the indicator using jQuery's fade-out effect.
 *
 * @method
 * @returns {void}
 */
veIndicator.prototype.hide = function() {
	this.$indicator.fadeOut();
};

/**
 * Access the jQuery object for direct manipulation.
 *
 * @method
 * @returns {jQuery}
 */
veIndicator.prototype.getIndicator = function() {
	return this.$indicator;
};
