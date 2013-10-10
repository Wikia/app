ve.ui.WikiaCartItemWidget = function VeUiWikiaCartItemWidget( model, config ) {
	this.model = model;
	ve.ui.OptionWidget.call( this, this.model.id, config );
	this.setLabel( this.model.name );
};

ve.inheritClass( ve.ui.WikiaCartItemWidget, ve.ui.OptionWidget );

ve.ui.WikiaCartItemWidget.prototype.getModel = function() {
	return this.model;
};