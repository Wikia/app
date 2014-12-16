/*
 * VisualEditor UserInterface WikiaSingleMediaCartOptionWidget class.
 */

/* global require */

/**
 * @class
 * @extends OO.ui.OptionWidget
 *
 * @constructor
 * @param {ve.dm.WikiaCartItem} model Cart item
 */
ve.ui.WikiaSingleMediaCartOptionWidget = function VeUiWikiaSingleMediaCartOptionWidget( model ) {
	var size = 120, $image, $details;

	ve.ui.WikiaSingleMediaCartOptionWidget.super.call( this, model.getId() );

	this.model = model;
	this.$element.addClass( 've-ui-texture-pending ve-ui-wikiaSingleMediaCartOptionWidget' );

	$details = this.$( '<div>' ).addClass( 've-ui-wikiaSingleMediaCartOptionDetails' );

	$image = this.$( '<img>' )
		.attr( {
			'height': size,
			'width': size
		} )
		.addClass( 've-ui-wikiaSingleMediaCartOptionImage' )
		.load( ve.bind( function () {
			this.$element
				.prepend( $image, $details )
				.removeClass( 've-ui-texture-pending' );
		}, this ) );

	require( ['wikia.thumbnailer'], ve.bind( function ( thumbnailer ) {
		$image.attr( 'src', thumbnailer.getThumbURL( this.model.url, 'image', size, size ) );
	}, this ) );
};

OO.inheritClass( ve.ui.WikiaSingleMediaCartOptionWidget, OO.ui.OptionWidget );

ve.ui.WikiaSingleMediaCartOptionWidget.prototype.getModel = function () {
	return this.model;
};
