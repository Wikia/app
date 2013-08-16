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

	// Properties
	this.$bar = this.$$( '<div>' );
	this.$tools = this.$$( '<div>' );
	this.$actions = this.$$( '<div>' );
	this.initialized = false;

	// Events
	this.$
		.add( this.$bar ).add( this.$tools ).add( this.$actions )
		.on( 'mousedown', false );

	// Initialization
	this.$tools.addClass( 've-ui-toolbar-tools' );
	this.$bar.addClass( 've-ui-toolbar-bar' ).append( this.$tools );
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

/* Methods */

/**
 * Initialize all tools and groups.
 *
 * @method
 * @param {Object[]} config List of tool group configurations
 */
ve.ui.Toolbar.prototype.setup = function ( config ) {
	var i, j, group, tools;

	for ( i = 0; i < config.length; i++ ) {
		tools = config[i].items;
		group = new ve.ui.ToolGroup( this, { '$$': this.$$ } );

		// Add tools
		for ( j = 0; j < tools.length; j++ ) {
			try {
				tools[j] = ve.ui.toolFactory.create( tools[j], this );
			} catch( e ) {}
		}
		group.addItems( tools );

		// Append group
		this.$tools.append( group.$ );
	}
};

/**
 * Sets up handles and preloads required information for the toolbar to work.
 * This must be called immediately after it is attached to a visible document.
 */
ve.ui.Toolbar.prototype.initialize = function () {
	this.initialized = true;
};

/**
 * Destroys toolbar, removing event handlers and DOM elements.
 *
 * Call this whenever you are done using a toolbar.
 */
ve.ui.Toolbar.prototype.destroy = function () {
	this.$.remove();
};
