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
 * Tools can be specified in the following ways:
 *  - A specific tool: `{ 'name': 'tool-name' }` or `'tool-name'`
 *  - All tools in a group: `{ 'group': 'group-name' }`
 *  - All tools: `'*'`
 *
 * @constructor
 * @param {ve.ui.Toolbar} toolbar
 * @param {Object} [config] Configuration options
 * @cfg {Array|string} [include=[]] List of tools to include
 * @cfg {Array|string} [exclude=[]] List of tools to exclude
 * @cfg {Array|string} [promote=[]] List of tools to promote to the beginning
 * @cfg {Array|string} [demote=[]] List of tools to demote to the end
 */
ve.ui.ToolGroup = function VeUiToolGroup( toolbar, config ) {
	// Configuration initialization
	config = config || {};

	// Parent constructor
	ve.ui.Widget.call( this, config );

	// Mixin constructors
	ve.ui.GroupElement.call( this, this.$$( '<div>' ) );

	// Properties
	this.toolbar = toolbar;
	this.tools = {};
	this.pressed = null;
	this.include = config.include || [];
	this.exclude = config.exclude || [];
	this.promote = config.promote || [];
	this.demote = config.demote || [];
	this.onCapturedMouseUpHandler = ve.bind( this.onCapturedMouseUp, this );

	// Events
	this.$.on( {
		'mousedown': ve.bind( this.onMouseDown, this ),
		'mouseup': ve.bind( this.onMouseUp, this ),
		'mouseover': ve.bind( this.onMouseOver, this ),
		'mouseout': ve.bind( this.onMouseOut, this )
	} );
	this.toolbar.getToolFactory().connect( this, { 'register': 'onToolFactoryRegister' } );
	ve.ui.triggerRegistry.connect( this, { 'register': 'onTriggerRegistryRegister' } );

	// Initialization
	this.$group.addClass( 've-ui-toolGroup-tools' );
	this.$
		.addClass( 've-ui-toolGroup' )
		.append( this.$group );
	this.populate();
};

/* Inheritance */

ve.inheritClass( ve.ui.ToolGroup, ve.ui.Widget );

ve.mixinClass( ve.ui.ToolGroup, ve.ui.GroupElement );

/* Events */

/**
 * @event update
 */

/* Static Properties */

/**
 * Show title in tooltip.
 *
 * @static
 * @property {string}
 * @inheritable
 */
ve.ui.ToolGroup.static.showTitle = false;

/**
 * Show trigger in tooltip.
 *
 * @static
 * @property {string}
 * @inheritable
 */
ve.ui.ToolGroup.static.showTrigger = false;

/* Methods */

/**
 * Handle mouse down events.
 *
 * @method
 * @param {jQuery.Event} e Mouse down event
 */
ve.ui.ToolGroup.prototype.onMouseDown = function ( e ) {
	if ( !this.disabled && e.which === 1 ) {
		this.pressed = this.getTargetTool( e );
		if ( this.pressed ) {
			this.pressed.setActive( true );
			this.getElementDocument().addEventListener(
				'mouseup', this.onCapturedMouseUpHandler, true
			);
		}
	}
};

/**
 * Handle captured mouse up events.
 *
 * @method
 * @param {Event} e Mouse up event
 */
ve.ui.ToolGroup.prototype.onCapturedMouseUp = function ( e ) {
	this.getElementDocument().removeEventListener( 'mouseup', this.onCapturedMouseUpHandler, true );
	// onMouseUp may be called a second time, depending on where the mouse is when the button is
	// released, but since `this.pressed` will no longer be true, the second call will be ignored.
	this.onMouseUp( e );
};

/**
 * Handle mouse up events.
 *
 * @method
 * @param {jQuery.Event} e Mouse up event
 */
ve.ui.ToolGroup.prototype.onMouseUp = function ( e ) {
	var tool = this.getTargetTool( e );

	if ( !this.disabled && e.which === 1 && this.pressed && this.pressed === tool ) {
		this.pressed.onSelect();
	}

	this.pressed = null;
	return false;
};

/**
 * Handle mouse over events.
 *
 * @method
 * @param {jQuery.Event} e Mouse over event
 */
ve.ui.ToolGroup.prototype.onMouseOver = function ( e ) {
	var tool = this.getTargetTool( e );

	if ( this.pressed && this.pressed === tool ) {
		this.pressed.setActive( true );
	}
};

/**
 * Handle mouse out events.
 *
 * @method
 * @param {jQuery.Event} e Mouse out event
 */
ve.ui.ToolGroup.prototype.onMouseOut = function ( e ) {
	var tool = this.getTargetTool( e );

	if ( this.pressed && this.pressed === tool ) {
		this.pressed.setActive( false );
	}
};

/**
 * Get the closest tool to a jQuery.Event.
 *
 * @method
 * @private
 * @param {jQuery.Event} e
 * @returns {ve.ui.Tool|null} Tool, `null` if none was found
 */
ve.ui.ToolGroup.prototype.getTargetTool = function ( e ) {
	var $item = $( e.target ).closest( '.ve-ui-tool' );
	if ( $item.length ) {
		return $item.data( 've-ui-tool' );
	}
	return null;
};

/**
 * Handle tool registry register events.
 *
 * If a tool is registered after the group is created, we must repopulate the list to account for:
 * - a tool being added that may be included
 * - a tool already included being overridden
 *
 * @param {string} name Symbolic name of tool
 */
ve.ui.ToolGroup.prototype.onToolFactoryRegister = function () {
	this.populate();
};

/**
 * Handle trigger registry register events.
 *
 * If a trigger is registered after the tool is loaded, this handler will ensure matching tools'
 * titles are updated to reflect the available key command for the tool.
 *
 * @param {string} name Symbolic name of trigger
 */
ve.ui.ToolGroup.prototype.onTriggerRegistryRegister = function ( name ) {
	if ( this.tools[name] ) {
		this.updateToolTitle( name );
	}
};

/**
 * Update the title of a tool.
 *
 * @param {string} name Tool name
 * @chainable
 */
ve.ui.ToolGroup.prototype.updateToolTitle = function ( name ) {
	var tool, trigger, labelMessage, labelText,
		showTitle = this.constructor.static.showTitle,
		showTrigger = this.constructor.static.showTrigger;

	tool = this.tools[name];
	if ( tool ) {
		labelText = '';
		if ( showTitle ) {
			labelMessage = tool.constructor.static.titleMessage;
			if ( labelMessage ) {
				labelText += ve.msg( labelMessage );
			}
		}
		if ( showTrigger ) {
			trigger = ve.ui.triggerRegistry.lookup( tool.constructor.static.name );
			if ( trigger ) {
				labelText += ' [' + trigger.getMessage() + ']';
			}
		}
		tool.setTitle( labelText );
	}
	return this;
};

/**
 * Get the toolbar this group is in.
 *
 * @return {ve.ui.Toolbar} Toolbar of group
 */
ve.ui.ToolGroup.prototype.getToolbar = function () {
	return this.toolbar;
};

/**
 * Add and remove tools based on configuration.
 *
 * @method
 */
ve.ui.ToolGroup.prototype.populate = function () {
	var i, len, name, tool,
		names = {},
		add = [],
		remove = [],
		list = this.toolbar.getToolFactory().getTools(
			this.include, this.exclude, this.promote, this.demote
		);

	// Build a list of needed tools
	for ( i = 0, len = list.length; i < len; i++ ) {
		name = list[i];
		if ( this.toolbar.isToolAvailable( name ) ) {
			tool = this.tools[name];
			if ( !tool ) {
				// Auto-initialize tools on first use
				this.tools[name] = tool =
					this.toolbar.getToolFactory().create( name, this.toolbar );
				this.updateToolTitle( name );
			}
			this.toolbar.reserveTool( name );
			add.push( tool );
			names[name] = true;
		}
	}
	// Remove tools that are no longer needed
	for ( name in this.tools ) {
		if ( !names[name] ) {
			this.tools[name].destroy();
			this.toolbar.releaseTool( name );
			remove.push( this.tools[name] );
			delete this.tools[name];
		}
	}
	if ( remove.length ) {
		this.removeItems( remove );
	}
	// Update emptiness state
	if ( add.length ) {
		this.$.removeClass( 've-ui-toolGroup-empty' );
	} else {
		this.$.addClass( 've-ui-toolGroup-empty' );
	}
	// Re-add tools (moving existing ones to new locations)
	this.addItems( add );
};

/**
 * Destroy tool group.
 *
 * @method
 */
ve.ui.ToolGroup.prototype.destroy = function () {
	var name;

	this.clearItems();
	this.toolbar.getToolFactory().disconnect( this );
	for ( name in this.tools ) {
		this.toolbar.releaseTool( name );
		this.tools[name].disconnect( this ).destroy();
		delete this.tools[name];
	}
	this.$.remove();
};
