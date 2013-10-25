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

ve.ui.WikiaMediaResultsSelectWidget.prototype.onMouseUp = function ( e ) {
	this.pressed = false;
	if ( !this.selecting ) {
		this.selecting = this.getTargetItem( e );
	}
	if ( !this.disabled && e.which === 1 && this.selecting ) {
		// What was clicked on?
		if ( $( e.target ).hasClass( 've-ui-wikiaMediaResultWidget-cartState' ) ) {
			this.emit( 'cartState', this.selecting );
		} else {
			this.selectItem( this.selecting );
		}
		this.selecting = null;
	}
	return false;
};
