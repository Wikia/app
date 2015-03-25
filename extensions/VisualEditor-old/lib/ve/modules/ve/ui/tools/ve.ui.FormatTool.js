/*!
 * VisualEditor UserInterface FormatTool classes.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface format tool.
 *
 * @abstract
 * @class
 * @extends ve.ui.Tool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.FormatTool = function VeUiFormatTool( toolGroup, config ) {
	// Parent constructor
	ve.ui.Tool.call( this, toolGroup, config );

	// Properties
	this.convertible = false;
};

/* Inheritance */

OO.inheritClass( ve.ui.FormatTool, ve.ui.Tool );

/* Static Properties */

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

ve.ui.FormatTool.static.requiresRange = true;

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.FormatTool.prototype.onSelect = function () {
	ve.track( 'tool.format.select', { name: this.constructor.static.name } );
	ve.ui.Tool.prototype.onSelect.apply( this, arguments );
};

/**
 * @inheritdoc
 */
ve.ui.FormatTool.prototype.onUpdateState = function ( fragment ) {
	// Parent method
	ve.ui.Tool.prototype.onUpdateState.apply( this, arguments );

	var i, len,
		nodes = fragment.getSelectedLeafNodes(),
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
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.ParagraphFormatTool = function VeUiParagraphFormatTool( toolGroup, config ) {
	ve.ui.FormatTool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.ParagraphFormatTool, ve.ui.FormatTool );
ve.ui.ParagraphFormatTool.static.name = 'paragraph';
ve.ui.ParagraphFormatTool.static.group = 'format';
ve.ui.ParagraphFormatTool.static.title =
	OO.ui.deferMsg( 'visualeditor-formatdropdown-format-paragraph' );
ve.ui.ParagraphFormatTool.static.format = { 'type': 'paragraph' };
ve.ui.ParagraphFormatTool.static.commandName = 'paragraph';
ve.ui.toolFactory.register( ve.ui.ParagraphFormatTool );

/**
 * UserInterface heading 1 tool.
 *
 * @class
 * @extends ve.ui.FormatTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.Heading1FormatTool = function VeUiHeading1FormatTool( toolGroup, config ) {
	ve.ui.FormatTool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.Heading1FormatTool, ve.ui.FormatTool );
ve.ui.Heading1FormatTool.static.name = 'heading1';
ve.ui.Heading1FormatTool.static.group = 'format';
ve.ui.Heading1FormatTool.static.title =
	OO.ui.deferMsg( 'visualeditor-formatdropdown-format-heading1' );
ve.ui.Heading1FormatTool.static.format = { 'type': 'heading', 'attributes': { 'level': 1 } };
ve.ui.Heading1FormatTool.static.commandName = 'heading1';
ve.ui.toolFactory.register( ve.ui.Heading1FormatTool );

/**
 * UserInterface heading 2 tool.
 *
 * @class
 * @extends ve.ui.FormatTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.Heading2FormatTool = function VeUiHeading2FormatTool( toolGroup, config ) {
	ve.ui.FormatTool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.Heading2FormatTool, ve.ui.FormatTool );
ve.ui.Heading2FormatTool.static.name = 'heading2';
ve.ui.Heading2FormatTool.static.group = 'format';
ve.ui.Heading2FormatTool.static.title =
	OO.ui.deferMsg( 'visualeditor-formatdropdown-format-heading2' );
ve.ui.Heading2FormatTool.static.format = { 'type': 'heading', 'attributes': { 'level': 2 } };
ve.ui.Heading2FormatTool.static.commandName = 'heading2';
ve.ui.toolFactory.register( ve.ui.Heading2FormatTool );

/**
 * UserInterface heading 3 tool.
 *
 * @class
 * @extends ve.ui.FormatTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.Heading3FormatTool = function VeUiHeading3FormatTool( toolGroup, config ) {
	ve.ui.FormatTool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.Heading3FormatTool, ve.ui.FormatTool );
ve.ui.Heading3FormatTool.static.name = 'heading3';
ve.ui.Heading3FormatTool.static.group = 'format';
ve.ui.Heading3FormatTool.static.title =
	OO.ui.deferMsg( 'visualeditor-formatdropdown-format-heading3' );
ve.ui.Heading3FormatTool.static.format = { 'type': 'heading', 'attributes': { 'level': 3 } };
ve.ui.Heading3FormatTool.static.commandName = 'heading3';
ve.ui.toolFactory.register( ve.ui.Heading3FormatTool );

/**
 * UserInterface heading 4 tool.
 *
 * @class
 * @extends ve.ui.FormatTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.Heading4FormatTool = function VeUiHeading4FormatTool( toolGroup, config ) {
	ve.ui.FormatTool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.Heading4FormatTool, ve.ui.FormatTool );
ve.ui.Heading4FormatTool.static.name = 'heading4';
ve.ui.Heading4FormatTool.static.group = 'format';
ve.ui.Heading4FormatTool.static.title =
	OO.ui.deferMsg( 'visualeditor-formatdropdown-format-heading4' );
ve.ui.Heading4FormatTool.static.format = { 'type': 'heading', 'attributes': { 'level': 4 } };
ve.ui.Heading4FormatTool.static.commandName = 'heading4';
ve.ui.toolFactory.register( ve.ui.Heading4FormatTool );

/**
 * UserInterface heading 5 tool.
 *
 * @class
 * @extends ve.ui.FormatTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.Heading5FormatTool = function VeUiHeading5FormatTool( toolGroup, config ) {
	ve.ui.FormatTool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.Heading5FormatTool, ve.ui.FormatTool );
ve.ui.Heading5FormatTool.static.name = 'heading5';
ve.ui.Heading5FormatTool.static.group = 'format';
ve.ui.Heading5FormatTool.static.title =
	OO.ui.deferMsg( 'visualeditor-formatdropdown-format-heading5' );
ve.ui.Heading5FormatTool.static.format = { 'type': 'heading', 'attributes': { 'level': 5 } };
ve.ui.Heading5FormatTool.static.commandName = 'heading5';
ve.ui.toolFactory.register( ve.ui.Heading5FormatTool );

/**
 * UserInterface heading 6 tool.
 *
 * @class
 * @extends ve.ui.FormatTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.Heading6FormatTool = function VeUiHeading6FormatTool( toolGroup, config ) {
	ve.ui.FormatTool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.Heading6FormatTool, ve.ui.FormatTool );
ve.ui.Heading6FormatTool.static.name = 'heading6';
ve.ui.Heading6FormatTool.static.group = 'format';
ve.ui.Heading6FormatTool.static.title =
	OO.ui.deferMsg( 'visualeditor-formatdropdown-format-heading6' );
ve.ui.Heading6FormatTool.static.format = { 'type': 'heading', 'attributes': { 'level': 6 } };
ve.ui.Heading6FormatTool.static.commandName = 'heading6';
ve.ui.toolFactory.register( ve.ui.Heading6FormatTool );

/**
 * UserInterface preformatted tool.
 *
 * @class
 * @extends ve.ui.FormatTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.PreformattedFormatTool = function VeUiPreformattedFormatTool( toolGroup, config ) {
	ve.ui.FormatTool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.PreformattedFormatTool, ve.ui.FormatTool );
ve.ui.PreformattedFormatTool.static.name = 'preformatted';
ve.ui.PreformattedFormatTool.static.group = 'format';
ve.ui.PreformattedFormatTool.static.title =
	OO.ui.deferMsg( 'visualeditor-formatdropdown-format-preformatted' );
ve.ui.PreformattedFormatTool.static.format = { 'type': 'preformatted' };
ve.ui.PreformattedFormatTool.static.commandName = 'preformatted';
ve.ui.toolFactory.register( ve.ui.PreformattedFormatTool );
