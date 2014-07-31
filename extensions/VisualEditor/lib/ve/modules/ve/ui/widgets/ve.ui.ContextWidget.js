/**
 * List of context items, displaying information about the current context.
 *
 * Use with ve.ui.ContextItemWidget.
 *
 * @class
 * @extends OO.ui.SelectWidget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.ContextWidget = function VeUiContextWidget( config ) {
	// Config intialization
	config = config || {};

	// Parent constructor
	ve.ui.ContextWidget.super.call( this, config );

	this.connect( this, { 'choose': 'onChooseItem' } );

	// Initialization
	this.$element.addClass( 've-ui-contextWidget' );
};

/* Setup */

OO.inheritClass( ve.ui.ContextWidget, OO.ui.SelectWidget );

/* Methods */

/**
 * Handle choose item events.
 */
ve.ui.ContextWidget.prototype.onChooseItem = function () {
	// Auto-deselect
	this.selectItem( null );
};
