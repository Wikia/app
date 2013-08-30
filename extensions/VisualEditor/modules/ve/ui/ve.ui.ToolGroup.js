/*!
 * VisualEditor UserInterface ToolGroup class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface tool group.
 *
 * @class
 * @abstract
 * @extends ve.ui.Widget
 * @mixins ve.ui.GroupElement
 *
 * Patterns can be either:
 *  - All tools in a category: 'category'
 *  - A specific tool: 'category/name'
 *
 * @constructor
 * @param {ve.ui.Toolbar} toolbar
 * @param {Object} [config] Config options
 * @cfg {string[]} [include=[]] Patterns of tools to automatically include
 * @cfg {string[]} [exclude=[]] Patterns of tools to automatically exclude
 * @cfg {string[]} [promote=[]] Patterns of tools to promote to the beginning
 * @cfg {string[]} [demote=[]] Patterns of tools to demote to the end
 */
ve.ui.ToolGroup = function VeUiToolGroup( toolbar, config ) {
	// Configuration initialization
	config = config || {};

	// Parent constructor
	ve.ui.Widget.call( this, config );

	// Mixin constructors
	ve.ui.GroupElement.call( this, this.$ );

	// Properties
	this.toolbar = toolbar;
	this.tools = {};
	this.include = config.include || [];
	this.exclude = config.exclude || [];
	this.promote = config.promote || [];
	this.demote = config.demote || [];

	// Events
	this.$.on( { 'mousedown': false } );
	ve.ui.toolFactory.connect( this, { 'register': 'onToolFactoryRegister' } );

	// Initialization
	this.$.addClass( 've-ui-toolGroup' );
	this.populateTools();
};

/* Inheritance */

ve.inheritClass( ve.ui.ToolGroup, ve.ui.Widget );

ve.mixinClass( ve.ui.ToolGroup, ve.ui.GroupElement );

/* Methods */

/**
 * Handle tool registry register events.
 *
 * If a tool is registered after the group is created, this handler will ensure the tool is included
 * as if it were present at the time of the group being created.
 *
 * @param {string} name Symbolic name of tool
 */
ve.ui.ToolGroup.prototype.onToolFactoryRegister = function () {
	this.populateTools();
};

/**
 * Add and remove tools based on configuration.
 *
 * @method
 */
ve.ui.ToolGroup.prototype.populateTools = function () {
	var i, len, name, tool,
		names = {},
		tools = [],
		list = ve.ui.toolFactory.getTools(
			this.include, this.exclude, this.promote, this.demote
		);

	// Build a list of needed tools
	for ( i = 0, len = list.length; i < len; i++ ) {
		name = list[i];
		tool = this.tools[name];
		if ( !tool ) {
			// Auto-initialize tools on first use
			tool = ve.ui.toolFactory.create( name, this.toolbar );
			this.tools[name] = tool;
		}
		tools.push( tool );
		names[name] = true;
	}
	// Remove tools that are no longer needed
	for ( name in this.tools ) {
		if ( !names[name] ) {
			this.tools[name].destroy();
			this.removeItem( this.tools[name] );
			delete this.tools[name];
		}
	}
	// Re-add tools (moving existing ones to new locations)
	this.addItems( tools );
};

/**
 * Destroy tool group.
 *
 * @method
 */
ve.ui.ToolGroup.prototype.destroy = function () {
	var name;

	this.clearItems();
	ve.ui.toolFactory.disconnect( this );
	for ( name in this.tools ) {
		this.tools[name].destroy();
	}
	this.$.remove();
};
