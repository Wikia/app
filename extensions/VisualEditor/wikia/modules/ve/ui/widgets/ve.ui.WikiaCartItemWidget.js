ve.ui.WikiaCartItemWidget = function VeUiWikiaCartItemWidget( model, config ) {
	this.model = model;
	ve.ui.OptionWidget.call( this, this.model.title, config );
	this.setLabel( this.model.title );

	var $img = this.$$( '<img>' );
	$img.attr( 'src', Wikia.Thumbnailer.getThumbURL(model.url, 'image', 60, 60) ); 
	this.$.prepend( $img );
};

ve.inheritClass( ve.ui.WikiaCartItemWidget, ve.ui.OptionWidget );

ve.ui.WikiaCartItemWidget.prototype.getModel = function() {
	return this.model;
};