/*
 * VisualEditor UserInterface WikiaCartItemWidget class.
 */

/* global require */

/**
 * @class
 * @extends OO.ui.OptionWidget
 *
 * @constructor
 * @param {ve.dm.WikiaCartItem} model Cart item
 */
ve.ui.WikiaCartItemWidget = function VeUiWikiaCartItemWidget( model ) {
	var size = 80, $image;

	ve.ui.WikiaCartItemWidget.super.call( this, model.getId() );

	this.model = model;
	this.$element.addClass( 've-ui-texture-pending' );

	$image = this.$( '<img>' )
		.attr( {
			'height': size,
			'width': size
		} )
		.addClass( 've-ui-wikiaCartImage' )
		.load( ve.bind( function () {
			this.$element
				.prepend( $image )
				.removeClass( 've-ui-texture-pending' );
		}, this ) );

	require( ['wikia.thumbnailer'], ve.bind( function ( thumbnailer ) {
		$image.attr( 'src', thumbnailer.getThumbURL( this.model.url, 'image', size, size ) );
	}, this ) );
};

OO.inheritClass( ve.ui.WikiaCartItemWidget, OO.ui.OptionWidget );

ve.ui.WikiaCartItemWidget.prototype.getModel = function () {
	return this.model;
};
