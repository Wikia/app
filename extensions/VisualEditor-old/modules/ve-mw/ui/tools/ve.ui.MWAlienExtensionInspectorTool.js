/*!
 * VisualEditor Experimental MediaWiki UserInterface alien extension tool class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Modeless dialog for inspecting unsupported MediaWiki extension nodes.
 *
 * @class
 * @extends ve.ui.InspectorTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.MWAlienExtensionInspectorTool = function VeUiMWAlienExtensionInspectorTool( toolGroup, config ) {
	ve.ui.InspectorTool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.MWAlienExtensionInspectorTool, ve.ui.InspectorTool );
ve.ui.MWAlienExtensionInspectorTool.static.name = 'alienExtension';
ve.ui.MWAlienExtensionInspectorTool.static.group = 'object';
ve.ui.MWAlienExtensionInspectorTool.static.icon = 'alienextension';
ve.ui.MWAlienExtensionInspectorTool.static.title =
	OO.ui.deferMsg( 'visualeditor-mwalienextensioninspector-title' );
ve.ui.MWAlienExtensionInspectorTool.static.modelClasses = [ ve.dm.MWAlienExtensionNode ];
ve.ui.MWAlienExtensionInspectorTool.static.commandName = 'alienExtension';
ve.ui.MWAlienExtensionInspectorTool.static.autoAddToCatchall = false;
ve.ui.MWAlienExtensionInspectorTool.static.autoAddToGroup = false;
ve.ui.toolFactory.register( ve.ui.MWAlienExtensionInspectorTool );
