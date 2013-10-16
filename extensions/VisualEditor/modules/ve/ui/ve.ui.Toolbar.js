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
 * @param {ve.Factory} toolFactory Factory for creating tools
 * @param {Object} [options] Configuration options
 * @cfg {boolean} [actions] Add an actions section opposite to the tools
 * @cfg {boolean} [shadow] Add a shadow below the toolbar
 */
ve.ui.Toolbar = function VeUiToolbar( toolFactory, options ) {
	// Configuration initialization
	options = options || {};

	// Parent constructor
	ve.Element.call( this, options );

	// Mixin constructors
	ve.EventEmitter.call( this );
	ve.ui.GroupElement.call( this, this.$$( '<div>' ) );

	// Properties
	this.toolFactory = toolFactory;
	this.groups = [];
	this.tools = {};
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
 * Get the tool factory.
 *
 * @method
 * @returns {ve.Factory} Tool factory
 */
ve.ui.Toolbar.prototype.getToolFactory = function () {
	return this.toolFactory;
};

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
 * Tools can be specified in the following ways:
 *  - A specific tool: `{ 'name': 'tool-name' }` or `'tool-name'`
 *  - All tools in a group: `{ 'group': 'group-name' }`
 *  - All tools: `'*'` - Using this will make the group a list with a "More" label by default
 *
 * @method
 * @param {Object.<string,Array>} groups List of tool group configurations
 * @param {Array|string} [groups.include] Tools to include
 * @param {Array|string} [groups.exclude] Tools to exclude
 * @param {Array|string} [groups.promote] Tools to promote to the beginning
 * @param {Array|string} [groups.demote] Tools to demote to the end
 */
ve.ui.Toolbar.prototype.setup = function ( groups ) {
	var i, len, type, group,
		items = [],
		// TODO: Use a registry instead
		defaultType = 'bar',
		constructors = {
			'bar': ve.ui.BarToolGroup,
			'list': ve.ui.ListToolGroup,
			'menu': ve.ui.MenuToolGroup
		};

	for ( i = 0, len = groups.length; i < len; i++ ) {
		group = groups[i];
		if ( group.include === '*' ) {
			// Apply defaults to catch-all groups
			if ( !group.type ) {
				group.type = 'list';
			}
			if ( !group.label ) {
				group.label = 'visualeditor-toolbar-more';
			}
		}
		type = constructors[group.type] ? group.type : defaultType;
		items.push( new constructors[type]( this, ve.extendObject( { '$$': this.$$ }, group ) ) );
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

ve.ui.Toolbar.prototype.isToolAvailable = function ( name ) {
	return !this.tools[name];
};

ve.ui.Toolbar.prototype.reserveTool = function ( name ) {
	this.tools[name] = true;
};

ve.ui.Toolbar.prototype.releaseTool = function ( name ) {
	delete this.tools[name];
};
