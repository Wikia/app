/*!
 * VisualEditor UserInterface ListTool classes.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface list tool.
 *
 * @abstract
 * @class
 * @extends ve.ui.Tool
 * @constructor
 * @param {ve.ui.SurfaceToolbar} toolbar
 * @param {Object} [config] Configuration options
 */
ve.ui.ListTool = function VeUiListTool( toolbar, config ) {
	// Parent constructor
	ve.ui.Tool.call( this, toolbar, config );

	// Properties
	this.method = null;
};

/* Inheritance */

ve.inheritClass( ve.ui.ListTool, ve.ui.Tool );

/**
 * List style the tool applies.
 *
 * @abstract
 * @static
 * @property {string}
 * @inheritable
 */
ve.ui.ListTool.static.style = '';

/* Methods */

/**
 * Handle the tool being selected.
 *
 * @method
 */
ve.ui.ListTool.prototype.onSelect = function () {
	if ( this.method === 'wrap' ) {
		this.toolbar.surface.execute( 'list', 'wrap', this.constructor.static.style );
	} else if ( this.method === 'unwrap' ) {
		this.toolbar.surface.execute( 'list', 'unwrap' );
	}
};

/**
 * Handle the toolbar state being updated.
 *
 * @method
 * @param {ve.dm.Node[]} nodes List of nodes covered by the current selection
 * @param {ve.dm.AnnotationSet} full Annotations that cover all of the current selection
 * @param {ve.dm.AnnotationSet} partial Annotations that cover some or all of the current selection
 */
ve.ui.ListTool.prototype.onUpdateState = function ( nodes ) {
	var i, len,
		style = this.constructor.static.style,
		all = !!nodes.length;

	for ( i = 0, len = nodes.length; i < len; i++ ) {
		if ( !nodes[i].hasMatchingAncestor( 'list', { 'style': style } ) ) {
			all = false;
			break;
		}
	}
	this.method = all ? 'unwrap' : 'wrap';
	this.setActive( all );
};

/**
 * UserInterface bullet tool.
 *
 * @class
 * @extends ve.ui.ListTool
 * @constructor
 * @param {ve.ui.SurfaceToolbar} toolbar
 * @param {Object} [config] Configuration options
 */
ve.ui.BulletListTool = function VeUiBulletListTool( toolbar, config ) {
	ve.ui.ListTool.call( this, toolbar, config );
};
ve.inheritClass( ve.ui.BulletListTool, ve.ui.ListTool );
ve.ui.BulletListTool.static.name = 'bullet';
ve.ui.BulletListTool.static.group = 'structure';
ve.ui.BulletListTool.static.icon = 'bullet-list';
ve.ui.BulletListTool.static.titleMessage = 'visualeditor-listbutton-bullet-tooltip';
ve.ui.BulletListTool.static.style = 'bullet';
ve.ui.toolFactory.register( ve.ui.BulletListTool );

/**
 * UserInterface number tool.
 *
 * @class
 * @extends ve.ui.ListTool
 * @constructor
 * @param {ve.ui.SurfaceToolbar} toolbar
 * @param {Object} [config] Configuration options
 */
ve.ui.NumberListTool = function VeUiNumberListTool( toolbar, config ) {
	ve.ui.ListTool.call( this, toolbar, config );
};
ve.inheritClass( ve.ui.NumberListTool, ve.ui.ListTool );
ve.ui.NumberListTool.static.name = 'number';
ve.ui.NumberListTool.static.group = 'structure';
ve.ui.NumberListTool.static.icon = 'number-list';
ve.ui.NumberListTool.static.titleMessage = 'visualeditor-listbutton-number-tooltip';
ve.ui.NumberListTool.static.style = 'number';
ve.ui.toolFactory.register( ve.ui.NumberListTool );
