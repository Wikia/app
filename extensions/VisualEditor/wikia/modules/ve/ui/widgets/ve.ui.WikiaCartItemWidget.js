/* global require */

ve.ui.WikiaCartItemWidget = function VeUiWikiaCartItemWidget( model, config ) {
	var size = 60, $image;
	this.model = model;
	ve.ui.OptionWidget.call( this, this.model.title, config );

	this.$.addClass( 've-ui-texture-pending' );

	$image = this.$$( '<img>' )
		.attr( {
			'height': size,
			'width': size
		} )
		.addClass( 've-ui-wikiaCartImage' )
		.load( ve.bind( function() {
			this.$
				.prepend( $image )
				.removeClass( 've-ui-texture-pending' );
		}, this ) );

	require( ['wikia.thumbnailer'], ve.bind( function ( thumbnailer ) {
		$image.attr( 'src', thumbnailer.getThumbURL( this.model.url, 'image', size, size ) );
	}, this ) );
};

ve.inheritClass( ve.ui.WikiaCartItemWidget, ve.ui.OptionWidget );

ve.ui.WikiaCartItemWidget.prototype.getModel = function() {
	return this.model;
};
