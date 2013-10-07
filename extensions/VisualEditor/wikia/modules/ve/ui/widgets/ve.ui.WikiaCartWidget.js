ve.ui.WikiaCartWidget = function VeUiWikiaCartWidget( model, config ) {
	ve.ui.SelectWidget.call( this, config );
	this.model = model;
	this.model.connect( this, { 'add': 'onAdd', 'remove': 'onRemove' } );
	this.$.addClass( 've-ui-wikiaCartWidget' );
};

ve.inheritClass( ve.ui.WikiaCartWidget, ve.ui.SelectWidget );

ve.ui.WikiaCartWidget.prototype.onAdd = function ( items, index ) {
	var i, widgetItems = [];
	for ( i = 0; i < items.length; i++ ) {
		widgetItems.push( new ve.ui.WikiaCartItemWidget( items[i] ) );
	}
	this.addItems( widgetItems, index );
};

ve.ui.WikiaCartWidget.prototype.onRemove = function ( items ) {
	var i, widgetItem, widgetItems = [];
	for ( i = 0; i < items.length; i++ ) {
		widgetItem = this.getItemFromData( items[i].id );
		if ( widgetItem ) {
			widgetItems.push( widgetItem );
		}
	}
	this.removeItems( widgetItems );
};
