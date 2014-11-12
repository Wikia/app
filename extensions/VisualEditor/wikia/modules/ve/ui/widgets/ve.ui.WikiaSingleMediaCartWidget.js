/*!
 * VisualEditor UserInterface WikiaSingleMediaCartWidget class.
 */

/**
 * @class
 * @extends OO.ui.Widget
 *
 * @constructor
 * @param {Object} config Configuration options
 * @cfg {Object} dialog Instance of parent dialog
 */
ve.ui.WikiaSingleMediaCartWidget = function VeUiWikiaSingleMediaCartWidget( config ) {
	// Parent constructor
	ve.ui.WikiaSingleMediaCartWidget.super.call( this, config );

	// Properties
	this.dialog = config.dialog;

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

	this.cartModel = new ve.dm.WikiaCart();
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

	// Temp stuff
	this.tempItem = new ve.dm.WikiaCartItem( 'Janice elton floyd.jpg', 'http://vignette.wikia-dev.com/muppet/images/3/31/Janice_elton_floyd.jpg/revision/latest?cb=20110101181243', 'photo', undefined, 'wikia' );
	this.cartModel.addItems( [ this.tempItem, this.tempItem, this.tempItem, this.tempItem, this.tempItem ] );
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
