/*!
 * VisualEditor loading indicator
 */

/* global mw */

// Gracefully make sure this object exists.
mw.libs.ve = $.extend( mw.libs.ve, {} );

/**
 * Create and initialize the indicator. This method does not yet display the indicator.
 *
 * @class
 * @constructor
 * @param {string} Icon class
 * @param {string} Message label
 */
mw.libs.ve.progressIndicator = function( icon, message ) {
	var $content = $( '<div>' ).addClass( 'content' );
	this.$indicator = $( '<div>' ).addClass( 've-indicator visible' );
	this.$icon = $( '<div>' ).addClass( 'icon ' + icon );
	this.$message = $( '<p>' )
		.addClass( 'message' )
		.text( mw.message( message ).plain() )
		.show();

	$content
		.append( this.$icon )
		.append( this.$message );

	this.$indicator
		.append( $content )
		.appendTo( $( 'body' ) )
		.css( { 'opacity': 1, 'z-index': 99999999 } )
		.hide();

	this.messageTimeoutId = null;
};

/**
 * Set the icon class for the indicator.
 *
 * @method
 * @param {string} Icon class
 * @returns {void}
 */
mw.libs.ve.progressIndicator.prototype.setIcon = function ( icon ) {
	this.$icon.attr( 'class', 'icon ' + icon );
};

/**
 * Set the message for the indicator.
 *
 * @method
 * @param {string} Message key
 * @returns {void}
 */
mw.libs.ve.progressIndicator.prototype.setMessage = function ( messageKey ) {
	this.$message.text( mw.message( messageKey ).plain() );
};

/**
 * Show the indicator using jQuery's fade-in effect.
 *
 * @method
 * @param {number} [messageDelay] Optional delay, in milliseconds, when displaying the indicator message
 * @returns {void}
 */
mw.libs.ve.progressIndicator.prototype.show = function( messageDelay ) {
	if ( typeof messageDelay === 'number' ) {
		this.$message.hide();
		// The ve.bind() method might not be available to use yet, so use native bind() instead.
		this.messageTimeoutId = setTimeout( this.slideMessage.bind( this ), messageDelay );
	}
	this.$indicator.fadeIn();
};

/**
 * Show the indicator message using slide-down effect.
 *
 * @method
 * @returns {void}
 */
mw.libs.ve.progressIndicator.prototype.slideMessage = function( ) {
	if ( this.$indicator.is( ':visible' ) ) {
		this.$message.slideDown( 400 );
	}
};

/**
 * Hide the indicator using jQuery's fade-out effect.
 *
 * @method
 * @param {number} [delay] Optional delay, in milliseconds, to wait until hiding the indicator.
 * @returns {void}
 */
mw.libs.ve.progressIndicator.prototype.hide = function( delay ) {
	if ( typeof delay === 'number' ) {
		setTimeout( this.hide.bind( this ), delay );
	}
	else {
		this.$indicator.fadeOut();
	}
};
