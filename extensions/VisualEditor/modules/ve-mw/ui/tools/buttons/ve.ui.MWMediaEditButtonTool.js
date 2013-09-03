/*!
 * VisualEditor UserInterface MWMediaEditButtonTool class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface MediaWiki media edit button tool.
 *
 * @class
 * @extends ve.ui.DialogButtonTool
 * @constructor
 * @param {ve.ui.Toolbar} toolbar
 * @param {Object} [config] Config options
 */
ve.ui.MWMediaEditButtonTool = function VeUiMWMediaEditButtonTool( toolbar, config ) {
	// Parent constructor
	ve.ui.DialogButtonTool.call( this, toolbar, config );
};

/* Inheritance */

ve.inheritClass( ve.ui.MWMediaEditButtonTool, ve.ui.DialogButtonTool );

/* Static Properties */

ve.ui.MWMediaEditButtonTool.static.name = 'object/mediaEdit/mw';

ve.ui.MWMediaEditButtonTool.static.icon = 'picture';

ve.ui.MWMediaEditButtonTool.static.titleMessage = 'visualeditor-dialogbutton-media-tooltip';

ve.ui.MWMediaEditButtonTool.static.dialog = 'mwMediaEdit';

ve.ui.MWMediaEditButtonTool.static.modelClasses = [ ve.dm.MWBlockImageNode ];

ve.ui.MWMediaEditButtonTool.static.autoAdd = false;

/* Registration */

ve.ui.toolFactory.register( 'object/mediaEdit/mw', ve.ui.MWMediaEditButtonTool );
