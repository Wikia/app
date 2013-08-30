/*!
 * VisualEditor UserInterface MWAlienExtensionButtonTool class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface MediaWiki alien extension button tool.
 *
 * @class
 * @extends ve.ui.InspectorButtonTool
 * @constructor
 * @param {ve.ui.Toolbar} toolbar
 * @param {Object} [config] Config options
 */
ve.ui.MWAlienExtensionButtonTool = function VeUiMWAlienExtensionButtonTool( toolbar, config ) {
   // Parent constructor
   ve.ui.InspectorButtonTool.call( this, toolbar, config );
};

/* Inheritance */

ve.inheritClass( ve.ui.MWAlienExtensionButtonTool, ve.ui.InspectorButtonTool );

/* Static Properties */

ve.ui.MWAlienExtensionButtonTool.static.name = 'object/alienExtension/mw';

ve.ui.MWAlienExtensionButtonTool.static.icon = 'alienextension';

ve.ui.MWAlienExtensionButtonTool.static.titleMessage = 'visualeditor-mwalienextensioninspector-title';

ve.ui.MWAlienExtensionButtonTool.static.inspector = 'mwAlienExtensionInspector';

ve.ui.MWAlienExtensionButtonTool.static.modelClasses = [ ve.dm.MWAlienExtensionNode ];

ve.ui.MWAlienExtensionButtonTool.static.autoAdd = false;

/* Registration */

ve.ui.toolFactory.register( 'object/alienExtension/mw', ve.ui.MWAlienExtensionButtonTool );
