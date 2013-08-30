/*!
 * VisualEditor UserInterface MWReferenceListButtonTool class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface MediaWiki reference list button tool.
 *
 * @class
 * @extends ve.ui.DialogButtonTool
 * @constructor
 * @param {ve.ui.Toolbar} toolbar
 * @param {Object} [config] Config options
 */
ve.ui.MWReferenceListButtonTool = function VeUiMWReferenceListButtonTool( toolbar, config ) {
	// Parent constructor
	ve.ui.DialogButtonTool.call( this, toolbar, config );
};

/* Inheritance */

ve.inheritClass( ve.ui.MWReferenceListButtonTool, ve.ui.DialogButtonTool );

/* Static Properties */

ve.ui.MWReferenceListButtonTool.static.name = 'object/referenceList/mw';

ve.ui.MWReferenceListButtonTool.static.icon = 'references';

ve.ui.MWReferenceListButtonTool.static.titleMessage = 'visualeditor-dialogbutton-referencelist-tooltip';

ve.ui.MWReferenceListButtonTool.static.dialog = 'mwReferenceList';

ve.ui.MWReferenceListButtonTool.static.modelClasses = [ ve.dm.MWReferenceListNode ];

/* Registration */

ve.ui.toolFactory.register( 'object/referenceList/mw', ve.ui.MWReferenceListButtonTool );
