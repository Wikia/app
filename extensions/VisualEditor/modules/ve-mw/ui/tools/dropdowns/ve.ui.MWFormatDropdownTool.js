/*!
 * VisualEditor UserInterface MWFormatDropdownTool class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface format dropdown tool.
 *
 * @class
 * @extends ve.ui.FormatDropdownTool
 * @constructor
 * @param {ve.ui.Toolbar} toolbar
 */
ve.ui.MWFormatDropdownTool = function VeUiMWFormatDropdownTool( toolbar, config ) {
	// Parent constructor
	ve.ui.FormatDropdownTool.call( this, toolbar, config );
};

/* Inheritance */

ve.inheritClass( ve.ui.MWFormatDropdownTool, ve.ui.FormatDropdownTool );

/* Static Properties */

ve.ui.MWFormatDropdownTool.static.name = 'mwFormat';

ve.ui.MWFormatDropdownTool.static.cssName = 'format ve-ui-dropdownTool-mwFormat';

ve.ui.MWFormatDropdownTool.static.items[1].data.type = 'mwHeading';
ve.ui.MWFormatDropdownTool.static.items[1].label = 'visualeditor-formatdropdown-format-mw-heading1';
ve.ui.MWFormatDropdownTool.static.items[2].data.type = 'mwHeading';
ve.ui.MWFormatDropdownTool.static.items[2].label = 'visualeditor-formatdropdown-format-mw-heading2';
ve.ui.MWFormatDropdownTool.static.items[3].data.type = 'mwHeading';
ve.ui.MWFormatDropdownTool.static.items[3].label = 'visualeditor-formatdropdown-format-mw-heading3';
ve.ui.MWFormatDropdownTool.static.items[4].data.type = 'mwHeading';
ve.ui.MWFormatDropdownTool.static.items[4].label = 'visualeditor-formatdropdown-format-mw-heading4';
ve.ui.MWFormatDropdownTool.static.items[5].data.type = 'mwHeading';
ve.ui.MWFormatDropdownTool.static.items[5].label = 'visualeditor-formatdropdown-format-mw-heading5';
ve.ui.MWFormatDropdownTool.static.items[6].data.type = 'mwHeading';
ve.ui.MWFormatDropdownTool.static.items[6].label = 'visualeditor-formatdropdown-format-mw-heading6';
ve.ui.MWFormatDropdownTool.static.items[7].data.type = 'mwPreformatted';

// Move the H1 (item 1 in the list) to the end (7) so as to make it less prominent and tempting to users
ve.ui.MWFormatDropdownTool.static.items.splice( 7, 0, ve.ui.MWFormatDropdownTool.static.items.splice( 1, 1 )[0] );

/* Registration */

ve.ui.toolFactory.register( 'mwFormat', ve.ui.MWFormatDropdownTool );
