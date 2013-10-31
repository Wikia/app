/*!
 * VisualEditor UserInterface WikiaMediaResultsSelectWidget class.
 */

/**
 * @class
 * @extends ve.ui.SelectWidget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.WikiaMediaResultsSelectWidget = function VeUiWikiaMediaResultsSelectWidget( config ) {
	// Parent constructor
	ve.ui.SelectWidget.call( this, config );

	// Properties

	// Events

	// Initialization
};

/* Inheritance */

ve.inheritClass( ve.ui.WikiaMediaResultsSelectWidget, ve.ui.SelectWidget );

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
ve.ui.WikiaMediaResultsSelectWidget.prototype.onMouseUp = function ( e ) {
	this.pressed = false;
	if ( !this.selecting ) {
		this.selecting = this.getTargetItem( e );
	}
	if ( !this.disabled && e.which === 1 && this.selecting ) {
		// What was clicked on?
		if ( $( e.target ).hasClass( 've-ui-wikiaMediaResultWidget-state' ) ) {
			this.emit( 'state', this.selecting );
		} else {
			// TODO: When preview is ready, this should call this.selectItem.
			//this.selectItem( this.selecting );
			this.emit( 'state', this.selecting );
		}
		this.selecting = null;
	}
	return false;
};

/**
 * Determines which icon to show for a search result item based on the cart
 *
 * @method
 * @param {Object} cartItems Items in the cart
 * @param {Object} items Items that are being affected
 * @param {Object} state The state to set
 */
ve.ui.WikiaMediaResultsSelectWidget.prototype.updateState = function ( cartItems, items, state ) {
	var i, j;

	/*
	 * this.items = search results shown in widget
	 * items = items whose state needs updating
	 * state = the state to set on the items
	 */

	if ( items && state ) {
		// Sync a particular item
		for ( i = 0; i < this.items.length; i++ ) {
			for ( j = 0; j < items.length ; j++ ) {
				if ( this.items[i].data.title === items[j].title ) {
					this.items[i].setState( state );
				}
			}
		}
	} else {
		// Compare all search results to the cart and set the state of the ones that are there
		for ( i = 0; i < cartItems.length; i++ ) {
			for ( j = 0; j < this.items.length; j++ ) {
				if ( cartItems[i].title === this.items[j].data.title ) {
					this.items[j].setState( 'selected' );
				}
			}
		}
	}
};
