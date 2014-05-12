/*!
 * VisualEditor UserInterface LanguageInspector class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * MWLanguage inspector.
 *
 * @class
 * @extends ve.ui.LanguageInspector
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.MWLanguageInspector = function VeUiMWLanguageInspector( config ) {
	// Parent constructor
	ve.ui.LanguageInspector.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWLanguageInspector, ve.ui.LanguageInspector );

/* Static Properties */

ve.ui.MWLanguageInspector.static.languageInputWidget = ve.ui.MWLanguageInputWidget;

/* Registration */

ve.ui.inspectorFactory.register( ve.ui.MWLanguageInspector );
