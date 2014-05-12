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
ve.ui.MWLinkInspectorTool = function VeUiMWLinkInspectorTool( toolGroup, config ) {
	ve.ui.LinkInspectorTool.call( this, toolGroup, config );
};

OO.inheritClass( ve.ui.MWLinkInspectorTool, ve.ui.LinkInspectorTool );

ve.ui.MWLinkInspectorTool.static.modelClasses =
	ve.ui.MWLinkInspectorTool.static.modelClasses.concat(
		[ ve.dm.MWNumberedExternalLinkNode ]
	);

ve.ui.toolFactory.register( ve.ui.MWLinkInspectorTool );
