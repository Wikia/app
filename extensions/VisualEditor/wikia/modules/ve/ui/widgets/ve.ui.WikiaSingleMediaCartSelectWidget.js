/*!
 * VisualEditor UserInterface WikiaSingleMediaCartSelectWidget class.
 */

/**
 * @class
 * @extends OO.ui.SelectWidget
 *
 * @constructor
 * @param {ve.dm.WikiaCart} model Cart item
 */
ve.ui.WikiaSingleMediaCartSelectWidget = function VeUiWikiaSingleMediaCartSelectWidget( model ) {
	ve.ui.WikiaSingleMediaCartSelectWidget.super.call( this );
	this.model = model;
	this.model.connect( this, { add: 'onAdd', remove: 'onRemove' } );
	this.$element.addClass( 've-ui-wikiaSingleMediaCartSelectWidget' );
};

OO.inheritClass( ve.ui.WikiaSingleMediaCartSelectWidget, OO.ui.SelectWidget );

ve.ui.WikiaSingleMediaCartSelectWidget.prototype.onAdd = function ( items, index ) {
	var i, widgetItems = [];
	for ( i = 0; i < items.length; i++ ) {
		widgetItems.push( new ve.ui.WikiaSingleMediaCartOptionWidget( {
			data: items[i].getId(),
			model: items[i]
		} ) );
	}
	this.addItems( widgetItems, index );
};

ve.ui.WikiaSingleMediaCartSelectWidget.prototype.onRemove = function ( items ) {
	var i, widgetItem, widgetItems = [];
	for ( i = 0; i < items.length; i++ ) {
		widgetItem = this.getItemFromData( items[i].getId() );
		if ( widgetItem ) {
			widgetItems.push( widgetItem );
		}
	}
	this.removeItems( widgetItems );
};
