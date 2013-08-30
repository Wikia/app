/*!
 * VisualEditor UserInterface Toolbar class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface toolbar.
 *
 * @class
 * @extends ve.Element
 * @mixins ve.EventEmitter
 * @mixins ve.ui.GroupElement
 *
 * @constructor
 * @param {Object} [config] Config options
 * @cfg {boolean} [actions] Add an actions section opposite to the tools
 * @cfg {boolean} [shadow] Add a shadow below the toolbar
 */
ve.ui.Toolbar = function VeUiToolbar( options ) {
	// Configuration initialization
	options = options || {};

	// Parent constructor
	ve.Element.call( this, options );

	// Mixin constructors
	ve.EventEmitter.call( this );
	ve.ui.GroupElement.call( this, this.$$( '<div>' ) );

	// Properties
	this.groups = [];
	this.$bar = this.$$( '<div>' );
	this.$actions = this.$$( '<div>' );
	this.initialized = false;

	// Events
	this.$
		.add( this.$bar ).add( this.$group ).add( this.$actions )
		.on( 'mousedown', false );

	// Initialization
	this.$group.addClass( 've-ui-toolbar-tools' );
	this.$bar.addClass( 've-ui-toolbar-bar' ).append( this.$group );
	if ( options.actions ) {
		this.$actions.addClass( 've-ui-toolbar-actions' );
		this.$bar.append( this.$actions );
	}
	this.$bar.append( '<div style="clear:both"></div>' );
	if ( options.shadow ) {
		this.$bar.append( '<div class="ve-ui-toolbar-shadow"></div>' );
	}
	this.$.addClass( 've-ui-toolbar' ).append( this.$bar );
};

/* Inheritance */

ve.inheritClass( ve.ui.Toolbar, ve.Element );

ve.mixinClass( ve.ui.Toolbar, ve.EventEmitter );
ve.mixinClass( ve.ui.Toolbar, ve.ui.GroupElement );

/* Methods */

/**
 * Sets up handles and preloads required information for the toolbar to work.
 * This must be called immediately after it is attached to a visible document.
 */
ve.ui.Toolbar.prototype.initialize = function () {
	this.initialized = true;
};

/**
 * Setup toolbar.
 *
 * @method
 * @param {Object[]} groups List of tool group configurations
 */
ve.ui.Toolbar.prototype.setup = function ( groups ) {
	var i, len,
		items = [];

	for ( i = 0, len = groups.length; i < len; i++ ) {
		items.push( new ve.ui.ToolGroup( this, ve.extendObject( { '$$': this.$$ }, groups[i] ) ) );
	}
	this.addItems( items );
};

/**
 * Destroys toolbar, removing event handlers and DOM elements.
 *
 * Call this whenever you are done using a toolbar.
 */
ve.ui.Toolbar.prototype.destroy = function () {
	var i, len;

	this.clearItems();
	for ( i = 0, len = this.items.length; i < len; i++ ) {
		this.items[i].destroy();
	}
	this.$.remove();
};
