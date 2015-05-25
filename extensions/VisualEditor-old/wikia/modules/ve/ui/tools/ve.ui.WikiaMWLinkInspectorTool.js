/*!
 * VisualEditor Wikia UserInterface LinkInspectorTool class.
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
ve.ui.WikiaMWLinkInspectorTool = function VEUIWikiaMWLinkInspectorTool( toolGroup, config ) {
	ve.ui.WikiaMWLinkInspectorTool.super.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.WikiaMWLinkInspectorTool, ve.ui.MWLinkNodeInspectorTool );
ve.ui.WikiaMWLinkInspectorTool.static.contextIcon = 'edit';
ve.ui.toolFactory.register( ve.ui.WikiaMWLinkInspectorTool );
