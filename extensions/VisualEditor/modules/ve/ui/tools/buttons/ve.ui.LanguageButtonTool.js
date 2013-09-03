/*!
 * VisualEditor UserInterface LanguageButtonTool class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface language button tool.
 *
 * @class
 * @extends ve.ui.InspectorButtonTool
 * @constructor
 * @param {ve.ui.SurfaceToolbar} toolbar
 * @param {Object} [config] Config options
 */
ve.ui.LanguageButtonTool = function VeUiLanguageButtonTool( toolbar, config ) {
	// Parent constructor
	ve.ui.InspectorButtonTool.call( this, toolbar, config );
};

/* Inheritance */

ve.inheritClass( ve.ui.LanguageButtonTool, ve.ui.InspectorButtonTool );

/* Static Properties */

ve.ui.LanguageButtonTool.static.name = 'meta/language';

ve.ui.LanguageButtonTool.static.icon = 'language';

ve.ui.LanguageButtonTool.static.titleMessage = 'visualeditor-annotationbutton-language-tooltip';

ve.ui.LanguageButtonTool.static.inspector = 'language';

ve.ui.LanguageButtonTool.static.modelClasses = [ ve.dm.LanguageAnnotation ];

/* Registration */

ve.ui.toolFactory.register( 'meta/language', ve.ui.LanguageButtonTool );

ve.ui.commandRegistry.register( 'meta/language', 'inspector', 'open', 'language' );