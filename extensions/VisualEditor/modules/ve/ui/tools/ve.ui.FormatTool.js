/*!
 * VisualEditor UserInterface FormatTool classes.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface format tool.
 *
 * @abstract
 * @class
 * @extends ve.ui.Tool
 * @constructor
 * @param {ve.ui.SurfaceToolbar} toolbar
 * @param {Object} [config] Configuration options
 */
ve.ui.FormatTool = function VeUiFormatTool( toolbar, config ) {
	// Parent constructor
	ve.ui.Tool.call( this, toolbar, config );

	// Properties
	this.convertible = false;
};

/* Inheritance */

ve.inheritClass( ve.ui.FormatTool, ve.ui.Tool );

/**
 * Format the tool applies.
 *
 * Object should contain a required `type` and optional `attributes` property.
 *
 * @abstract
 * @static
 * @property {Object}
 * @inheritable
 */
ve.ui.FormatTool.static.format = null;

/* Methods */

/**
 * Handle the tool being selected.
 *
 * @method
 */
ve.ui.FormatTool.prototype.onSelect = function () {
	var format = this.constructor.static.format;

	if ( this.convertible ) {
		this.toolbar.getSurface().execute( 'format', 'convert', format.type, format.attributes );
	}
};

/**
 * Handle the toolbar state being updated.
 *
 * @method
 * @param {ve.dm.Node[]} nodes Format of nodes covered by the current selection
 * @param {ve.dm.AnnotationSet} full Annotations that cover all of the current selection
 * @param {ve.dm.AnnotationSet} partial Annotations that cover some or all of the current selection
 */
ve.ui.FormatTool.prototype.onUpdateState = function ( nodes ) {
	var i, len,
		format = this.constructor.static.format,
		all = !!nodes.length;

	for ( i = 0, len = nodes.length; i < len; i++ ) {
		if ( !nodes[i].hasMatchingAncestor( format.type, format.attributes ) ) {
			all = false;
			break;
		}
	}
	this.convertible = !all;
	this.setActive( all );
};

/**
 * UserInterface paragraph tool.
 *
 * @class
 * @extends ve.ui.FormatTool
 * @constructor
 * @param {ve.ui.SurfaceToolbar} toolbar
 * @param {Object} [config] Configuration options
 */
ve.ui.ParagraphFormatTool = function VeUiParagraphFormatTool( toolbar, config ) {
	ve.ui.FormatTool.call( this, toolbar, config );
};
ve.inheritClass( ve.ui.ParagraphFormatTool, ve.ui.FormatTool );
ve.ui.ParagraphFormatTool.static.name = 'paragraph';
ve.ui.ParagraphFormatTool.static.group = 'format';
ve.ui.ParagraphFormatTool.static.titleMessage = 'visualeditor-formatdropdown-format-paragraph';
ve.ui.ParagraphFormatTool.static.format = { 'type' : 'paragraph' };
ve.ui.toolFactory.register( ve.ui.ParagraphFormatTool );

/**
 * UserInterface heading 1 tool.
 *
 * @class
 * @extends ve.ui.FormatTool
 * @constructor
 * @param {ve.ui.SurfaceToolbar} toolbar
 * @param {Object} [config] Configuration options
 */
ve.ui.Heading1FormatTool = function VeUiHeading1FormatTool( toolbar, config ) {
	ve.ui.FormatTool.call( this, toolbar, config );
};
ve.inheritClass( ve.ui.Heading1FormatTool, ve.ui.FormatTool );
ve.ui.Heading1FormatTool.static.name = 'heading1';
ve.ui.Heading1FormatTool.static.group = 'format';
ve.ui.Heading1FormatTool.static.titleMessage = 'visualeditor-formatdropdown-format-heading1';
ve.ui.Heading1FormatTool.static.format = { 'type' : 'heading', 'attributes': { 'level': 1 } };
ve.ui.toolFactory.register( ve.ui.Heading1FormatTool );

/**
 * UserInterface heading 2 tool.
 *
 * @class
 * @extends ve.ui.FormatTool
 * @constructor
 * @param {ve.ui.SurfaceToolbar} toolbar
 * @param {Object} [config] Configuration options
 */
ve.ui.Heading2FormatTool = function VeUiHeading2FormatTool( toolbar, config ) {
	ve.ui.FormatTool.call( this, toolbar, config );
};
ve.inheritClass( ve.ui.Heading2FormatTool, ve.ui.FormatTool );
ve.ui.Heading2FormatTool.static.name = 'heading2';
ve.ui.Heading2FormatTool.static.group = 'format';
ve.ui.Heading2FormatTool.static.titleMessage = 'visualeditor-formatdropdown-format-heading2';
ve.ui.Heading2FormatTool.static.format = { 'type' : 'heading', 'attributes': { 'level': 2 } };
ve.ui.toolFactory.register( ve.ui.Heading2FormatTool );

/**
 * UserInterface heading 3 tool.
 *
 * @class
 * @extends ve.ui.FormatTool
 * @constructor
 * @param {ve.ui.SurfaceToolbar} toolbar
 * @param {Object} [config] Configuration options
 */
ve.ui.Heading3FormatTool = function VeUiHeading3FormatTool( toolbar, config ) {
	ve.ui.FormatTool.call( this, toolbar, config );
};
ve.inheritClass( ve.ui.Heading3FormatTool, ve.ui.FormatTool );
ve.ui.Heading3FormatTool.static.name = 'heading3';
ve.ui.Heading3FormatTool.static.group = 'format';
ve.ui.Heading3FormatTool.static.titleMessage = 'visualeditor-formatdropdown-format-heading3';
ve.ui.Heading3FormatTool.static.format = { 'type' : 'heading', 'attributes': { 'level': 3 } };
ve.ui.toolFactory.register( ve.ui.Heading3FormatTool );

/**
 * UserInterface heading 4 tool.
 *
 * @class
 * @extends ve.ui.FormatTool
 * @constructor
 * @param {ve.ui.SurfaceToolbar} toolbar
 * @param {Object} [config] Configuration options
 */
ve.ui.Heading4FormatTool = function VeUiHeading4FormatTool( toolbar, config ) {
	ve.ui.FormatTool.call( this, toolbar, config );
};
ve.inheritClass( ve.ui.Heading4FormatTool, ve.ui.FormatTool );
ve.ui.Heading4FormatTool.static.name = 'heading4';
ve.ui.Heading4FormatTool.static.group = 'format';
ve.ui.Heading4FormatTool.static.titleMessage = 'visualeditor-formatdropdown-format-heading4';
ve.ui.Heading4FormatTool.static.format = { 'type' : 'heading', 'attributes': { 'level': 4 } };
ve.ui.toolFactory.register( ve.ui.Heading4FormatTool );

/**
 * UserInterface heading 5 tool.
 *
 * @class
 * @extends ve.ui.FormatTool
 * @constructor
 * @param {ve.ui.SurfaceToolbar} toolbar
 * @param {Object} [config] Configuration options
 */
ve.ui.Heading5FormatTool = function VeUiHeading5FormatTool( toolbar, config ) {
	ve.ui.FormatTool.call( this, toolbar, config );
};
ve.inheritClass( ve.ui.Heading5FormatTool, ve.ui.FormatTool );
ve.ui.Heading5FormatTool.static.name = 'heading5';
ve.ui.Heading5FormatTool.static.group = 'format';
ve.ui.Heading5FormatTool.static.titleMessage = 'visualeditor-formatdropdown-format-heading5';
ve.ui.Heading5FormatTool.static.format = { 'type' : 'heading', 'attributes': { 'level': 5 } };
ve.ui.toolFactory.register( ve.ui.Heading5FormatTool );

/**
 * UserInterface heading 6 tool.
 *
 * @class
 * @extends ve.ui.FormatTool
 * @constructor
 * @param {ve.ui.SurfaceToolbar} toolbar
 * @param {Object} [config] Configuration options
 */
ve.ui.Heading6FormatTool = function VeUiHeading6FormatTool( toolbar, config ) {
	ve.ui.FormatTool.call( this, toolbar, config );
};
ve.inheritClass( ve.ui.Heading6FormatTool, ve.ui.FormatTool );
ve.ui.Heading6FormatTool.static.name = 'heading6';
ve.ui.Heading6FormatTool.static.group = 'format';
ve.ui.Heading6FormatTool.static.titleMessage = 'visualeditor-formatdropdown-format-heading6';
ve.ui.Heading6FormatTool.static.format = { 'type' : 'heading', 'attributes': { 'level': 6 } };
ve.ui.toolFactory.register( ve.ui.Heading6FormatTool );

/**
 * UserInterface preformatted tool.
 *
 * @class
 * @extends ve.ui.FormatTool
 * @constructor
 * @param {ve.ui.SurfaceToolbar} toolbar
 * @param {Object} [config] Configuration options
 */
ve.ui.PreformattedFormatTool = function VeUiPreformattedFormatTool( toolbar, config ) {
	ve.ui.FormatTool.call( this, toolbar, config );
};
ve.inheritClass( ve.ui.PreformattedFormatTool, ve.ui.FormatTool );
ve.ui.PreformattedFormatTool.static.name = 'preformatted';
ve.ui.PreformattedFormatTool.static.group = 'format';
ve.ui.PreformattedFormatTool.static.titleMessage =
	'visualeditor-formatdropdown-format-preformatted';
ve.ui.PreformattedFormatTool.static.format = { 'type' : 'preformatted' };
ve.ui.toolFactory.register( ve.ui.PreformattedFormatTool );
