/*!
 * VisualEditor MediaWiki UserInterface gallery tool class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * MediaWiki UserInterface gallery tool.
 *
 * @class
 * @extends ve.ui.InspectorTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.MWGalleryInspectorTool = function VeUiMWGalleryInspectorTool( toolGroup, config ) {
	ve.ui.InspectorTool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.MWGalleryInspectorTool, ve.ui.InspectorTool );
ve.ui.MWGalleryInspectorTool.static.name = 'gallery';
ve.ui.MWGalleryInspectorTool.static.group = 'object';
ve.ui.MWGalleryInspectorTool.static.icon = 'gallery';
ve.ui.MWGalleryInspectorTool.static.title =
	OO.ui.deferMsg( 'visualeditor-mwgalleryinspector-title' );
ve.ui.MWGalleryInspectorTool.static.modelClasses = [ ve.dm.MWGalleryNode ];
ve.ui.MWGalleryInspectorTool.static.autoAddToGroup = false;
ve.ui.MWGalleryInspectorTool.static.autoAddToCatchall = false;
ve.ui.MWGalleryInspectorTool.static.commandName = 'gallery';
ve.ui.toolFactory.register( ve.ui.MWGalleryInspectorTool );
