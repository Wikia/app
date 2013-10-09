ve.ui.WikiaCartItemWidget = function VeUiWikiaCartItemWidget( model, config ) {
	this.model = model;
	ve.ui.OptionWidget.call( this, this.model.title, config );

	var imgDimension = 60;
	var $img = this.$$( '<img>' );
	$img
		.attr( {
			'src': Wikia.Thumbnailer.getThumbURL( model.url, 'image', imgDimension, imgDimension ),
			'height': imgDimension,
			'width': imgDimension
		} )
		.addClass( 've-ui-wikiaCartImage' );
	this.$.prepend( $img );
};

ve.inheritClass( ve.ui.WikiaCartItemWidget, ve.ui.OptionWidget );

ve.ui.WikiaCartItemWidget.prototype.getModel = function() {
	return this.model;
};