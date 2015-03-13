/*
 * VisualEditor UserInterface WikiaSingleMediaCartOptionWidget class.
 */

/* global require */

/**
 * @class
 * @extends OO.ui.OptionWidget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.WikiaSingleMediaCartOptionWidget = function VeUiWikiaSingleMediaCartOptionWidget( config ) {
	var size = 120, $image, $details;

	ve.ui.WikiaSingleMediaCartOptionWidget.super.call( this, config );

	this.model = config.model;
	this.$element.addClass( 've-ui-texture-pending ve-ui-wikiaSingleMediaCartOptionWidget' );

	$details = this.$( '<div>' ).addClass( 've-ui-wikiaSingleMediaCartOptionDetails' );

	$image = this.$( '<img>' )
		.attr( {
			height: size,
			width: size
		} )
		.addClass( 've-ui-wikiaSingleMediaCartOptionImage' )
		.load( function () {
			this.$element
				.prepend( $image, $details )
				.removeClass( 've-ui-texture-pending' );
		}.bind( this ) );

	require( ['wikia.thumbnailer'], function ( thumbnailer ) {
		$image.attr( 'src', thumbnailer.getThumbURL( this.model.url, 'image', size, size ) );
	}.bind( this ) );
};

OO.inheritClass( ve.ui.WikiaSingleMediaCartOptionWidget, OO.ui.OptionWidget );

ve.ui.WikiaSingleMediaCartOptionWidget.prototype.getModel = function () {
	return this.model;
};
