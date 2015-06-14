/*!
 * VisualEditor UserInterface WikiaSingleMediaCartWidget class.
 */

/**
 * @class
 * @extends OO.ui.Widget
 *
 * @constructor
 * @param {ve.dm.WikiaCart} model Cart
 * @param {Object} dialog Instance of parent dialog
 */
ve.ui.WikiaSingleMediaCartWidget = function VeUiWikiaSingleMediaCartWidget( model, dialog ) {
	// Parent constructor
	ve.ui.WikiaSingleMediaCartWidget.super.call( this );

	// Properties
	this.dialog = dialog;

	this.$cartControls = this.$( '<div>' )
		.addClass( 've-ui-wikiaSingleMediaDialog-cartControls' );
	this.$cartViewButtons = this.$( '<div>' )
		.addClass( 've-ui-wikiaSingleMediaDialog-cartToggle' );
	this.cartGridButton = new OO.ui.ButtonWidget( {
		'$': this.$,
		'frameless': true,
		'icon': 'cart-grid',
		'classes': [ 've-ui-wikiaSingleMediaDialog-cartGridButton' ]
	} );
	this.cartListButton = new OO.ui.ButtonWidget( {
		'$': this.$,
		'frameless': true,
		'icon': 'cart-list',
		'classes': [ 've-ui-wikiaSingleMediaDialog-cartListButton' ]
	} );

	this.cartModel = model;
	this.cartSelect = new ve.ui.WikiaSingleMediaCartSelectWidget( this.cartModel );

	// Events
	this.dialog.connect( this, { 'layout': 'onLayout' } );
	this.cartGridButton.connect( this, { 'click': [ this.emit, 'layout', 'grid' ] } );
	this.cartListButton.connect( this, { 'click': [ this.emit, 'layout', 'list' ] } );

	// Initialization
	this.$cartControls.append( this.$cartViewButtons.append( [
		this.cartGridButton.$element,
		this.cartListButton.$element
	] ) );
	this.$element
		.addClass( 've-ui-wikiaSingleMediaCartWidget' )
		.append( this.$cartControls, this.cartSelect.$element );
};

OO.inheritClass( ve.ui.WikiaSingleMediaCartWidget, OO.ui.Widget );

/* Methods */

/*
 * Handles layout changes of parent dialog.
 *
 * @param {string} layout Either 'list' or 'grid'.
 */
ve.ui.WikiaSingleMediaCartWidget.prototype.onLayout = function ( layout ) {
	if ( layout === 'grid' ) {
		this.cartGridButton.setActive( true );
		this.cartListButton.setActive( false );
	} else if ( layout === 'list' ) {
		this.cartGridButton.setActive( false );
		this.cartListButton.setActive( true );
	}
};
