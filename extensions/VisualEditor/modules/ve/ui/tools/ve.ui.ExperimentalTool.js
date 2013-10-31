/*!
 * VisualEditor Experimental UserInterface tool classes.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface language tool.
 *
 * @class
 * @extends ve.ui.InspectorTool
 * @constructor
 * @param {ve.ui.SurfaceToolbar} toolbar
 * @param {Object} [config] Configuration options
 */
ve.ui.LanguageInspectorTool = function VeUiLanguageInspectorTool( toolbar, config ) {
	ve.ui.InspectorTool.call( this, toolbar, config );
};
ve.inheritClass( ve.ui.LanguageInspectorTool, ve.ui.InspectorTool );
ve.ui.LanguageInspectorTool.static.name = 'language';
ve.ui.LanguageInspectorTool.static.group = 'meta';
ve.ui.LanguageInspectorTool.static.icon = 'language';
ve.ui.LanguageInspectorTool.static.titleMessage = 'visualeditor-annotationbutton-language-tooltip';
ve.ui.LanguageInspectorTool.static.inspector = 'language';
ve.ui.LanguageInspectorTool.static.modelClasses = [ ve.dm.LanguageAnnotation ];
ve.ui.toolFactory.register( ve.ui.LanguageInspectorTool );
