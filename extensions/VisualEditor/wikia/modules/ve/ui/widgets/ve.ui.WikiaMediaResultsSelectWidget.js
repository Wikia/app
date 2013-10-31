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
 * @param {Object} changedItems Items whose state is being changed
 * @param {Object} state The state to set
 */
ve.ui.WikiaMediaResultsSelectWidget.prototype.updateState = function ( cartItems, changedItems, state ) {
	var i, item;

	if ( changedItems && state ) {
		// Sync a particular item
		for ( i = 0; i < changedItems.length ; i++ ) {
			item = this.getItemFromData( changedItems[i] );
			if ( item ) {
				item.setState( state );
			}
		}
	} else {
		// Compare all search results to the cart and set the state of the ones that are there
		for ( i = 0; i < cartItems.length; i++ ) {
			item = this.getItemFromData( cartItems[i] );
			if ( item ) {
				item.setState( 'selected' );
			}
		}
	}
};
