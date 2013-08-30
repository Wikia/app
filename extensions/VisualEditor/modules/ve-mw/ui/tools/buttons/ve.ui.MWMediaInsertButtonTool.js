/*!
 * VisualEditor UserInterface MWMediaInsertButtonTool class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface MediaWiki media insert button tool.
 *
 * @class
 * @extends ve.ui.DialogButtonTool
 *
 * @constructor
 * @param {ve.ui.Toolbar} toolbar
 * @param {Object} [config] Config options
 */
ve.ui.MWMediaInsertButtonTool = function VeUiMWMediaInsertButtonTool( toolbar, config ) {
	// Parent constructor
	ve.ui.DialogButtonTool.call( this, toolbar, config );
};

/* Inheritance */

ve.inheritClass( ve.ui.MWMediaInsertButtonTool, ve.ui.DialogButtonTool );

/* Static Properties */

ve.ui.MWMediaInsertButtonTool.static.name = 'object/mediaInsert/mw';

ve.ui.MWMediaInsertButtonTool.static.icon = 'picture';

ve.ui.MWMediaInsertButtonTool.static.titleMessage = 'visualeditor-dialogbutton-media-tooltip';

ve.ui.MWMediaInsertButtonTool.static.dialog = 'mwMediaInsert';

/* Registration */

ve.ui.toolFactory.register( 'object/mediaInsert/mw', ve.ui.MWMediaInsertButtonTool );
