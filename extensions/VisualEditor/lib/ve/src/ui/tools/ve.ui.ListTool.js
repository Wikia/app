/*!
 * VisualEditor UserInterface ListTool classes.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * UserInterface list tool.
 *
 * @abstract
 * @class
 * @extends ve.ui.Tool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.ListTool = function VeUiListTool( toolGroup, config ) {
	// Parent constructor
	ve.ui.Tool.call( this, toolGroup, config );

	// Properties
	this.method = null;
};

/* Inheritance */

OO.inheritClass( ve.ui.ListTool, ve.ui.Tool );

/* Static Properties */

/**
 * List style the tool applies.
 *
 * @abstract
 * @static
 * @property {string}
 * @inheritable
 */
ve.ui.ListTool.static.style = '';

ve.ui.ListTool.static.deactivateOnSelect = false;

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.ListTool.prototype.onUpdateState = function ( fragment ) {
	// Parent method
	ve.ui.Tool.prototype.onUpdateState.apply( this, arguments );

	var i, len,
		nodes = fragment ? fragment.getSelectedLeafNodes() : [],
		style = this.constructor.static.style,
		all = !!nodes.length;

	for ( i = 0, len = nodes.length; i < len; i++ ) {
		if ( !nodes[i].hasMatchingAncestor( 'list', { style: style } ) ) {
			all = false;
			break;
		}
	}
	this.setActive( all );
};

/**
 * UserInterface bullet tool.
 *
 * @class
 * @extends ve.ui.ListTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.BulletListTool = function VeUiBulletListTool( toolGroup, config ) {
	ve.ui.ListTool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.BulletListTool, ve.ui.ListTool );
ve.ui.BulletListTool.static.name = 'bullet';
ve.ui.BulletListTool.static.group = 'structure';
ve.ui.BulletListTool.static.icon = 'bullet-list';
ve.ui.BulletListTool.static.title =
	OO.ui.deferMsg( 'visualeditor-listbutton-bullet-tooltip' );
ve.ui.BulletListTool.static.style = 'bullet';
ve.ui.BulletListTool.static.commandName = 'bullet';
ve.ui.toolFactory.register( ve.ui.BulletListTool );

/**
 * UserInterface number tool.
 *
 * @class
 * @extends ve.ui.ListTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.NumberListTool = function VeUiNumberListTool( toolGroup, config ) {
	ve.ui.ListTool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.NumberListTool, ve.ui.ListTool );
ve.ui.NumberListTool.static.name = 'number';
ve.ui.NumberListTool.static.group = 'structure';
ve.ui.NumberListTool.static.icon = 'number-list';
ve.ui.NumberListTool.static.title =
	OO.ui.deferMsg( 'visualeditor-listbutton-number-tooltip' );
ve.ui.NumberListTool.static.style = 'number';
ve.ui.NumberListTool.static.commandName = 'number';
ve.ui.toolFactory.register( ve.ui.NumberListTool );
