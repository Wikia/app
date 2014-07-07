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
	OO.ui.SelectWidget.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaMediaSelectWidget, OO.ui.SelectWidget );

/* Events */

/**
 * @event nearingEnd
 */

/* Methods */

/**
 * Handle mouseup
 *
 * @method
 * @param {jQuery.Event} e The jQuery event Object.
 */
ve.ui.WikiaMediaSelectWidget.prototype.onMouseUp = function ( e ) {
	this.pressed = false;
	if ( !this.selecting ) {
		this.selecting = this.getTargetItem( e );
	}
	if ( !this.disabled && e.which === 1 && this.selecting ) {
		// What was clicked on?
		if ( $( e.target ).closest( '.ve-ui-wikiaMediaOptionWidget-check' ).length ) {
			this.emit( 'check', this.selecting );
		} else {
			this.selectItem( this.selecting );
		}
		this.selecting = null;
	}
	return false;
};

/**
 * Determines which icon to show for a search result item based on the cart
 *
 * @method
 * @param {Object} items Items to match against
 * @param {boolean} checked Should the item be checked?
 */
ve.ui.WikiaMediaSelectWidget.prototype.setChecked = function ( items, checked ) {
	var i, item;

	for ( i = 0; i < items.length ; i++ ) {
		item = this.getItemFromData( items[i].title );
		if ( item ) {
			item.setChecked( checked );
		}
	}
};
