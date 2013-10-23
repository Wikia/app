/*!
 * VisualEditor UserInterface WikiaMediaPageWidget class.
 */

/**
 * @class
 * @extends ve.ui.Widget
 *
 * @constructor
 * @param {Object} model Page item model
 * @param {Object} [config] Configuration options
 */
ve.ui.WikiaMediaPageWidget = function VeUiWikiaMediaPageWidget( model, config ) {
	// Configuration initialization
	config = config || {};

	// Parent constructor
	ve.ui.Widget.call( this, config );

	// Properties
	this.model = model;
	this.removeButton = new ve.ui.ButtonWidget( {
		'$$': this.$$,
		'label': 'Remove from the cart', //TODO: i18n
		'flags': ['destructive']
	} );

	// Events
	this.removeButton.connect( this, { 'click': 'onRemoveButtonClick' } );

	// Initialization
	this.$
		.addClass( 've-ui-wikiaMediaInformationPage' )
		// FIXME: temporary
		.append( this.$$( '<div>' ).text( model.title ) )
		.append( this.removeButton.$ );
};

/* Inheritance */

ve.inheritClass( ve.ui.WikiaMediaPageWidget, ve.ui.Widget );

/* Events */

/**
 * @event remove
 * @param {ve.dm.WikiaCartItem} item The cart item to be removed.
 */

/* Methods */

/**
 * Get the page item model.
 *
 * @method
 * @returns {ve.dm.WikiaCartItem} The page item model.
 */
ve.ui.WikiaMediaPageWidget.prototype.getModel = function () {
	return this.model;
};

/**
 * Handle clicks on the remove button
 *
 * @method
 * @fires remove
 */
ve.ui.WikiaMediaPageWidget.prototype.onRemoveButtonClick = function () {
	this.emit( 'remove', this.model );
};
