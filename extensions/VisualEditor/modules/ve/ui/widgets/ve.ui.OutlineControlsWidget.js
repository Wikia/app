/*!
 * VisualEditor UserInterface OutlineControlsWidget class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.OutlineControlsWidget object.
 *
 * @class
 *
 * @constructor
 * @param {ve.ui.OutlineWidget} outline Outline to control
 * @param {Object} [config] Configuration options
 * @cfg {Object[]} [adders] List of icons to show as addable item types, each an object with
 *  name, title and icon properties
 */
ve.ui.OutlineControlsWidget = function VeUiOutlineControlsWidget( outline, config ) {
	// Configuration initialization
	config = config || {};

	// Parent constructor
	ve.ui.Widget.call( this, config );

	// Properties
	this.outline = outline;
	this.adders = {};
	this.$adders = this.$$( '<div>' );
	this.$movers = this.$$( '<div>' );
	this.addButton = new ve.ui.IconButtonWidget( { '$$': this.$$, 'icon': 'add-item' } );
	this.upButton = new ve.ui.IconButtonWidget( {
		'$$': this.$$, 'icon': 'collapse', 'title': ve.msg( 'visualeditor-outline-control-move-up' )
	} );
	this.downButton = new ve.ui.IconButtonWidget( {
		'$$': this.$$, 'icon': 'expand', 'title': ve.msg( 'visualeditor-outline-control-move-down' )
	} );

	// Events
	outline.connect( this, {
		'select': 'onOutlineChange',
		'add': 'onOutlineChange',
		'remove': 'onOutlineChange'
	} );
	this.upButton.connect( this, { 'click': ['emit', 'move', -1] } );
	this.downButton.connect( this, { 'click': ['emit', 'move', 1] } );

	// Initialization
	this.$.addClass( 've-ui-outlineControlsWidget' );
	this.$adders.addClass( 've-ui-outlineControlsWidget-adders' );
	this.$movers
		.addClass( 've-ui-outlineControlsWidget-movers' )
		.append( this.upButton.$, this.downButton.$ );
	this.$.append( this.$adders, this.$movers );
	if ( config.adders && config.adders.length ) {
		this.setupAdders( config.adders );
	}
};

/* Inheritance */

ve.inheritClass( ve.ui.OutlineControlsWidget, ve.ui.Widget );

/* Events */

/**
 * @event move
 * @param {number} places Number of places to move
 */

/* Methods */

/**
 * Handle outline change events.
 *
 * @method
 */
ve.ui.OutlineControlsWidget.prototype.onOutlineChange = function () {
	var i, len, firstMoveable, lastMoveable,
		moveable = false,
		items = this.outline.getItems(),
		selectedItem = this.outline.getSelectedItem();

	if ( selectedItem && selectedItem.isMoveable() ) {
		moveable = true;
		i = -1;
		len = items.length;
		while ( ++i < len ) {
			if ( items[i].isMoveable() ) {
				firstMoveable = items[i];
				break;
			}
		}
		i = len;
		while ( i-- ) {
			if ( items[i].isMoveable() ) {
				lastMoveable = items[i];
				break;
			}
		}
	}
	this.upButton.setDisabled( !moveable || selectedItem === firstMoveable );
	this.downButton.setDisabled( !moveable || selectedItem === lastMoveable );
};

/**
 * Setup adders icons.
 *
 * @method
 * @param {Object[]} adders List of configuations for adder buttons, each containing a name, title
 *  and icon property
 */
ve.ui.OutlineControlsWidget.prototype.setupAdders = function ( adders ) {
	var i, len, addition, button,
		$buttons = this.$$( [] );

	this.$adders.append( this.addButton.$ );
	for ( i = 0, len = adders.length; i < len; i++ ) {
		addition = adders[i];
		button = new ve.ui.IconButtonWidget( {
			'$$': this.$$, 'icon': addition.icon, 'title': addition.title
		} );
		button.connect( this, { 'click': ['emit', 'add', addition.name] } );
		this.adders[addition.name] = button;
		this.$adders.append( button.$ );
		$buttons = $buttons.add( button.$ );
	}
};
