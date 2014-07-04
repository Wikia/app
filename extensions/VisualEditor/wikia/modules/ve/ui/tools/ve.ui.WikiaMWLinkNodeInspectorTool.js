/*!
 * VisualEditor Wikia UserInterface LinkNodeInspectorTool class.
 */

/**
 * UserInterface WikiaMWLinkInspector tool.
 *
 * @class
 * @extends ve.ui.MWLinkNodeInspectorTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.WikiaMWLinkNodeInspectorTool = function VEUIWikiaMWLinkNodeInspectorTool( toolGroup, config ) {
	ve.ui.MWLinkNodeInspectorTool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.WikiaMWLinkNodeInspectorTool, ve.ui.MWLinkNodeInspectorTool );
ve.ui.WikiaMWLinkNodeInspectorTool.static.contextIcon = 'edit';
ve.ui.toolFactory.register( ve.ui.WikiaMWLinkNodeInspectorTool );
