/*!
 * VisualEditor UserInterface MWReferenceButtonTool class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface MediaWiki reference button tool.
 *
 * @class
 * @extends ve.ui.DialogButtonTool
 *
 * @constructor
 * @param {ve.ui.Toolbar} toolbar
 * @param {Object} [config] Config options
 */
ve.ui.MWReferenceButtonTool = function VeUiMWReferenceButtonTool( toolbar, config ) {
	// Parent constructor
	ve.ui.DialogButtonTool.call( this, toolbar, config );
};

/* Inheritance */

ve.inheritClass( ve.ui.MWReferenceButtonTool, ve.ui.DialogButtonTool );

/* Static Properties */

ve.ui.MWReferenceButtonTool.static.name = 'object/reference/mw';

ve.ui.MWReferenceButtonTool.static.icon = 'reference';

ve.ui.MWReferenceButtonTool.static.titleMessage = 'visualeditor-dialogbutton-reference-tooltip';

ve.ui.MWReferenceButtonTool.static.dialog = 'mwReference';

ve.ui.MWReferenceButtonTool.static.modelClasses = [ ve.dm.MWReferenceNode ];

/* Registration */

ve.ui.toolFactory.register( 'object/reference/mw', ve.ui.MWReferenceButtonTool );
