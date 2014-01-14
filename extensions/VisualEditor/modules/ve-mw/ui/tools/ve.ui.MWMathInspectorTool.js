/*!
 * VisualEditor MediaWiki UserInterface math tool class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * MediaWiki UserInterface math tool.
 *
 * @class
 * @extends ve.ui.InspectorTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.MWMathInspectorTool = function VeUiMWMathInspectorTool( toolGroup, config ) {
	ve.ui.InspectorTool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.MWMathInspectorTool, ve.ui.InspectorTool );
ve.ui.MWMathInspectorTool.static.name = 'math';
ve.ui.MWMathInspectorTool.static.group = 'object';
ve.ui.MWMathInspectorTool.static.icon = 'math';
ve.ui.MWMathInspectorTool.static.titleMessage = 'visualeditor-mwmathinspector-title';
ve.ui.MWMathInspectorTool.static.inspector = 'math';
ve.ui.MWMathInspectorTool.static.modelClasses = [ ve.dm.MWMathNode ];
ve.ui.toolFactory.register( ve.ui.MWMathInspectorTool );
