ve.ui.WikiaCartItemWidget = function VeUiWikiaCartItemWidget( model, config ) {
	this.model = model;
	ve.ui.OptionWidget.call( this, this.model.title, config );

	var size = 60;

	require( ['wikia.thumbnailer'], ve.bind( function ( thumbnailer ) {
		this.$$( '<img>' )
			.attr( {
				'src': thumbnailer.getThumbURL( this.model.url, 'image', size, size ),
				'height': size,
				'width': size
			} )
			.addClass( 've-ui-wikiaCartImage' )
			.prependTo( this.$ );
	}, this ) );
};

ve.inheritClass( ve.ui.WikiaCartItemWidget, ve.ui.OptionWidget );

ve.ui.WikiaCartItemWidget.prototype.getModel = function() {
	return this.model;
};