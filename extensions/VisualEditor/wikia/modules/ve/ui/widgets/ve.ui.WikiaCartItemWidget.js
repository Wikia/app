/*
 * VisualEditor UserInterface WikiaCartItemWidget class.
 */

/* global require */

/**
 * @class
 * @extends OO.ui.OptionWidget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.WikiaCartItemWidget = function VeUiWikiaCartItemWidget( config ) {
	var size = 80, $image;

	ve.ui.WikiaCartItemWidget.super.call( this, config );

	this.model = config.model;
	this.$element.addClass( 've-ui-texture-pending' );

	$image = this.$( '<img>' )
		.attr( {
			height: size,
			width: size
		} )
		.addClass( 've-ui-wikiaCartImage' )
		.load( function () {
			this.$element
				.prepend( $image )
				.removeClass( 've-ui-texture-pending' );
		}.bind( this ) );

	require( ['wikia.thumbnailer'], function ( thumbnailer ) {
		$image.attr( 'src', thumbnailer.getThumbURL( this.model.url, 'image', size, size ) );
	}.bind( this ) );
};

OO.inheritClass( ve.ui.WikiaCartItemWidget, OO.ui.OptionWidget );

ve.ui.WikiaCartItemWidget.prototype.getModel = function () {
	return this.model;
};
