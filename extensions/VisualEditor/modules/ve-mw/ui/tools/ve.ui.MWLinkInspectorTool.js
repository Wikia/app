/*!
 * VisualEditor UserInterface MediaWiki LinkInspectorTool classes.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface link tool. Overrides link tool from core.
 *
 * Works for both link annotations and link nodes, and fires the 'link' command
 * which works for both as well.
 *
 * @class
 * @extends ve.ui.LinkInspectorTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.MWLinkInspectorTool = function VeUiMWLinkInspectorTool( toolGroup, config ) {
	ve.ui.LinkInspectorTool.call( this, toolGroup, config );
};

OO.inheritClass( ve.ui.MWLinkInspectorTool, ve.ui.LinkInspectorTool );

// FIXME should eventually vary title based on link type
// Use message visualeditor-annotationbutton-linknode-tooltip

ve.ui.MWLinkInspectorTool.static.modelClasses =
	ve.ui.MWLinkInspectorTool.super.static.modelClasses.concat( [
		ve.dm.MWNumberedExternalLinkNode
	] );

ve.ui.toolFactory.register( ve.ui.MWLinkInspectorTool );
