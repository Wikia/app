/*!
 * VisualEditor MediaWiki UserInterface format tool classes.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * MediaWiki UserInterface heading 1 tool.
 *
 * @class
 * @extends ve.ui.Heading1FormatTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.MWHeading1FormatTool = function VeUiMWHeading1FormatTool( toolGroup, config ) {
	ve.ui.Heading1FormatTool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.MWHeading1FormatTool, ve.ui.Heading1FormatTool );
ve.ui.MWHeading1FormatTool.static.titleMessage = 'visualeditor-formatdropdown-format-mw-heading1';
ve.ui.MWHeading1FormatTool.static.format = { 'type' : 'mwHeading', 'attributes': { 'level': 1 } };
ve.ui.toolFactory.register( ve.ui.MWHeading1FormatTool );
ve.ui.commandRegistry.register( 'heading1', new ve.ui.Command( 'format', 'convert', 'mwHeading', { 'level': 1 } ) );

/**
 * MediaWiki UserInterface heading 2 tool.
 *
 * @class
 * @extends ve.ui.Heading2FormatTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.MWHeading2FormatTool = function VeUiMWHeading2FormatTool( toolGroup, config ) {
	ve.ui.Heading2FormatTool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.MWHeading2FormatTool, ve.ui.Heading2FormatTool );
ve.ui.MWHeading2FormatTool.static.titleMessage = 'visualeditor-formatdropdown-format-mw-heading2';
ve.ui.MWHeading2FormatTool.static.format = { 'type' : 'mwHeading', 'attributes': { 'level': 2 } };
ve.ui.toolFactory.register( ve.ui.MWHeading2FormatTool );
ve.ui.commandRegistry.register( 'heading2', new ve.ui.Command( 'format', 'convert', 'mwHeading', { 'level': 2 } ) );

/**
 * MediaWiki UserInterface heading 3 tool.
 *
 * @class
 * @extends ve.ui.Heading3FormatTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.MWHeading3FormatTool = function VeUiMWHeading3FormatTool( toolGroup, config ) {
	ve.ui.Heading3FormatTool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.MWHeading3FormatTool, ve.ui.Heading3FormatTool );
ve.ui.MWHeading3FormatTool.static.titleMessage = 'visualeditor-formatdropdown-format-mw-heading3';
ve.ui.MWHeading3FormatTool.static.format = { 'type' : 'mwHeading', 'attributes': { 'level': 3 } };
ve.ui.toolFactory.register( ve.ui.MWHeading3FormatTool );
ve.ui.commandRegistry.register( 'heading3', new ve.ui.Command( 'format', 'convert', 'mwHeading', { 'level': 3 } ) );

/**
 * MediaWiki UserInterface heading 4 tool.
 *
 * @class
 * @extends ve.ui.Heading4FormatTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.MWHeading4FormatTool = function VeUiMWHeading4FormatTool( toolGroup, config ) {
	ve.ui.Heading4FormatTool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.MWHeading4FormatTool, ve.ui.Heading4FormatTool );
ve.ui.MWHeading4FormatTool.static.titleMessage = 'visualeditor-formatdropdown-format-mw-heading4';
ve.ui.MWHeading4FormatTool.static.format = { 'type' : 'mwHeading', 'attributes': { 'level': 4 } };
ve.ui.toolFactory.register( ve.ui.MWHeading4FormatTool );
ve.ui.commandRegistry.register( 'heading4', new ve.ui.Command( 'format', 'convert', 'mwHeading', { 'level': 4 } ) );

/**
 * MediaWiki UserInterface heading 5 tool.
 *
 * @class
 * @extends ve.ui.Heading5FormatTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.MWHeading5FormatTool = function VeUiMWHeading5FormatTool( toolGroup, config ) {
	ve.ui.Heading5FormatTool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.MWHeading5FormatTool, ve.ui.Heading5FormatTool );
ve.ui.MWHeading5FormatTool.static.titleMessage = 'visualeditor-formatdropdown-format-mw-heading5';
ve.ui.MWHeading5FormatTool.static.format = { 'type' : 'mwHeading', 'attributes': { 'level': 5 } };
ve.ui.toolFactory.register( ve.ui.MWHeading5FormatTool );
ve.ui.commandRegistry.register( 'heading5', new ve.ui.Command( 'format', 'convert', 'mwHeading', { 'level': 5 } ) );

/**
 * MediaWiki UserInterface heading 6 tool.
 *
 * @class
 * @extends ve.ui.Heading6FormatTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.MWHeading6FormatTool = function VeUiMWHeading6FormatTool( toolGroup, config ) {
	ve.ui.Heading6FormatTool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.MWHeading6FormatTool, ve.ui.Heading6FormatTool );
ve.ui.MWHeading6FormatTool.static.titleMessage = 'visualeditor-formatdropdown-format-mw-heading6';
ve.ui.MWHeading6FormatTool.static.format = { 'type' : 'mwHeading', 'attributes': { 'level': 6 } };
ve.ui.toolFactory.register( ve.ui.MWHeading6FormatTool );
ve.ui.commandRegistry.register( 'heading6', new ve.ui.Command( 'format', 'convert', 'mwHeading', { 'level': 6 } ) );

/**
 * MediaWiki UserInterface preformatted tool.
 *
 * @class
 * @extends ve.ui.PreformattedFormatTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.MWPreformattedFormatTool = function VeUiMWPreformattedFormatTool( toolGroup, config ) {
	ve.ui.FormatTool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.MWPreformattedFormatTool, ve.ui.PreformattedFormatTool );
ve.ui.MWPreformattedFormatTool.static.format = { 'type' : 'mwPreformatted' };
ve.ui.toolFactory.register( ve.ui.MWPreformattedFormatTool );
ve.ui.commandRegistry.register( 'preformatted', new ve.ui.Command( 'format', 'convert', 'mwPreformatted' ) );
