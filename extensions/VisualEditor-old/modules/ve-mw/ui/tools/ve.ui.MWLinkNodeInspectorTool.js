/*!
 * VisualEditor UserInterface MediaWiki LinkInspectorTool classes.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface link tool.
 *
 * @class
 * @extends ve.ui.LinkInspectorTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.MWLinkNodeInspectorTool = function VeUiMWLinkNodeInspectorTool( toolGroup, config ) {
	ve.ui.LinkInspectorTool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.MWLinkNodeInspectorTool, ve.ui.LinkInspectorTool );
ve.ui.MWLinkNodeInspectorTool.static.name = 'linkNode';
ve.ui.MWLinkNodeInspectorTool.static.title =
	OO.ui.deferMsg( 'visualeditor-annotationbutton-linknode-tooltip' );
ve.ui.MWLinkNodeInspectorTool.static.modelClasses = [ ve.dm.MWNumberedExternalLinkNode ];
ve.ui.MWLinkNodeInspectorTool.static.commandName = 'linkNode';
ve.ui.MWLinkNodeInspectorTool.static.autoAddToGroup = false;
ve.ui.MWLinkNodeInspectorTool.static.autoAddToCatchall = false;
ve.ui.toolFactory.register( ve.ui.MWLinkNodeInspectorTool );
