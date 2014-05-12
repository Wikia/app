/*!
 * VisualEditor UserInterface MWCategoryItemWidget class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.MWCategoryItemWidget object.
 *
 * @class
 * @abstract
 * @extends OO.ui.Widget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @cfg {Object} [item] Category item
 */
ve.ui.MWCategoryItemWidget = function VeUiMWCategoryItemWidget( config ) {
	// Config intialization
	config = config || {};

	// Parent constructor
	OO.ui.Widget.call( this, config );

	// Properties
	this.name = config.item.name;
	this.value = config.item.value;
	this.sortKey = config.item.sortKey || '';
	this.metaItem = config.item.metaItem;
	this.menuOpen = false;
	this.$label = this.$( '<span>' );
	this.$arrow = this.$( '<div>' );
	this.$categoryItem = this.$( '<div>' );

	// Events
	this.$categoryItem.on( {
		'click': ve.bind( this.onClick, this ),
		'mounsedown': ve.bind( this.onMouseDown, this )
	} );

	// Initialization
	this.$label.text( this.value );
	this.$arrow.addClass( 've-ui-mwCategoryItemControl oo-ui-icon-down' );
	this.$categoryItem
		.addClass( 've-ui-mwCategoryItemButton' )
		.append( this.$label, this.$arrow, this.$( '<div>' ).css( 'clear', 'both' ) );
	this.$element
		.addClass( 've-ui-mwCategoryItemWidget' )
		.append( this.$categoryItem );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWCategoryItemWidget, OO.ui.Widget );

/* Events */

/**
 * @event savePopupState
 */

/**
 * @event togglePopupMenu
 * @param {ve.ui.MWCategoryItemWidget} item Item to load into popup
 */

/* Methods */

/**
 * Handle mouse down events.
 *
 * @method
 * @param {jQuery.Event} e Mouse down event
 * @fires savePopupState on mousedown.
 */
ve.ui.MWCategoryItemWidget.prototype.onMouseDown = function () {
	this.emit( 'savePopupState' );
};

/**
 * Handle mouse click events.
 *
 * @method
 * @param {jQuery.Event} e Mouse click event
 * @fires togglePopupMenu on mousedown.
 */
ve.ui.MWCategoryItemWidget.prototype.onClick = function () {
	this.emit( 'togglePopupMenu', this );
};
