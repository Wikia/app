/* global require */

ve.ui.WikiaCartItemWidget = function VeUiWikiaCartItemWidget( model, config ) {
	this.model = model;
	ve.ui.OptionWidget.call( this, this.model.title, config );

	var size = 60;
	var $image = this.$$( '<img>' )
		.attr( {
			'height': size,
			'width': size
		} )
		.addClass( 've-ui-wikiaCartImage ve-ui-texture-pending' )
		.prependTo( this.$ )
		.load( function() {
			$image.removeClass( 've-ui-texture-pending' );
		} );

	require( ['wikia.thumbnailer'], ve.bind( function ( thumbnailer ) {
		$image.attr( 'src', thumbnailer.getThumbURL( this.model.url, 'image', size, size ) )
	}, this ) );
};

ve.inheritClass( ve.ui.WikiaCartItemWidget, ve.ui.OptionWidget );

ve.ui.WikiaCartItemWidget.prototype.getModel = function() {
	return this.model;
};