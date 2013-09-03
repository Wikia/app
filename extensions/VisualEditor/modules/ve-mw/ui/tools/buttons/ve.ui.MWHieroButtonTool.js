/*!
 * VisualEditor UserInterface MWHieroButtonTool class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface MediaWiki hieroglyphics button tool.
 *
 * @class
 * @extends ve.ui.InspectorButtonTool
 * @constructor
 * @param {ve.ui.Toolbar} toolbar
 * @param {Object} [config] Config options
 */
ve.ui.MWHieroButtonTool = function VeUiMWHieroButtonTool( toolbar, config ) {
   // Parent constructor
   ve.ui.InspectorButtonTool.call( this, toolbar, config );
};

/* Inheritance */

ve.inheritClass( ve.ui.MWHieroButtonTool, ve.ui.InspectorButtonTool );

/* Static Properties */

ve.ui.MWHieroButtonTool.static.name = 'object/hiero/mw';

ve.ui.MWHieroButtonTool.static.icon = 'hiero';

ve.ui.MWHieroButtonTool.static.titleMessage = 'visualeditor-mwhieroinspector-title';

ve.ui.MWHieroButtonTool.static.inspector = 'mwHieroInspector';

ve.ui.MWHieroButtonTool.static.modelClasses = [ ve.dm.MWHieroNode ];

/* Registration */

ve.ui.toolFactory.register( 'object/hiero/mw', ve.ui.MWHieroButtonTool );
