/*!
 * VisualEditor UserInterface WikiaMediaSelectWidget class.
 */

/**
 * @class
 * @extends OO.ui.SelectWidget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.WikiaMediaSelectWidget = function VeUiWikiaMediaSelectWidget( config ) {
	// Parent constructor
	ve.ui.WikiaMediaSelectWidget.super.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaMediaSelectWidget, OO.ui.SelectWidget );

/* Events */

/**
 * @event nearingEnd
 */

/* Methods */

/**
 * Determines which icon to show for a search result item based on the cart
 *
 * @method
 * @param {Object} items Items to match against
 * @param {boolean} checked Should the item be checked?
 */
ve.ui.WikiaMediaSelectWidget.prototype.setChecked = function ( items, checked ) {
	var i, j;
	for ( i = 0; i < items.length ; i++ ) {
		// TODO: Consider creating a method to retrieve widget (or its data) based on the title
		for ( j = 0; j < this.items.length; j++ ) {
			if ( this.items[j].getData().title === items[i].title ) {
				this.items[j].setChecked( checked );
				break;
			}
		}
	}
};
