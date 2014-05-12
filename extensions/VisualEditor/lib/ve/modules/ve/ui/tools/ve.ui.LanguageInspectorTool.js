/*!
 * VisualEditor UserInterface language tool class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface language tool.
 *
 * @class
 * @extends ve.ui.InspectorTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.LanguageInspectorTool = function VeUiLanguageInspectorTool( toolGroup, config ) {
	ve.ui.InspectorTool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.LanguageInspectorTool, ve.ui.InspectorTool );
ve.ui.LanguageInspectorTool.static.name = 'language';
ve.ui.LanguageInspectorTool.static.group = 'meta';
ve.ui.LanguageInspectorTool.static.icon = 'language';
ve.ui.LanguageInspectorTool.static.title =
	OO.ui.deferMsg( 'visualeditor-annotationbutton-language-tooltip' );
ve.ui.LanguageInspectorTool.static.modelClasses = [ ve.dm.LanguageAnnotation ];
ve.ui.LanguageInspectorTool.static.commandName = 'language';
ve.ui.toolFactory.register( ve.ui.LanguageInspectorTool );
