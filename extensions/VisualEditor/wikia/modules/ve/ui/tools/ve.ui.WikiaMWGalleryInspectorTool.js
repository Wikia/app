/*!
 * VisualEditor Wikia UserInterface gallery tool class.
 */

/**
 * UserInterface WikiaMWGalleryInspector tool.
 *
 * @class
 * @extends ve.ui.MWGalleryInspectorTool
 * @constructor
 * @param {OO.ui.Toolgroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.WikiaMWGalleryInspectorTool = function VEUIWikiaMWGalleryInspectorTool( toolGroup, config ) {
	ve.ui.MWGalleryInspectorTool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.WikiaMWGalleryInspectorTool, ve.ui.MWGalleryInspectorTool );
ve.ui.WikiaMWGalleryInspectorTool.static.contextIcon = 'edit';
ve.ui.toolFactory.register( ve.ui.WikiaMWGalleryInspectorTool );
