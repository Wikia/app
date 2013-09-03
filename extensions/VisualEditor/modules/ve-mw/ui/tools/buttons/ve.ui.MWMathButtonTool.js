/*!
 * VisualEditor UserInterface MWMathButtonTool class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface MediaWiki math button tool.
 *
 * @class
 * @extends ve.ui.InspectorButtonTool
 * @constructor
 * @param {ve.ui.Toolbar} toolbar
 * @param {Object} [config] Config options
 */
ve.ui.MWMathButtonTool = function VeUiMWMathButtonTool( toolbar, config ) {
   // Parent constructor
   ve.ui.InspectorButtonTool.call( this, toolbar, config );
};

/* Inheritance */

ve.inheritClass( ve.ui.MWMathButtonTool, ve.ui.InspectorButtonTool );

/* Static Properties */

ve.ui.MWMathButtonTool.static.name = 'object/math/mw';

ve.ui.MWMathButtonTool.static.icon = 'math';

ve.ui.MWMathButtonTool.static.titleMessage = 'visualeditor-mwmathinspector-title';

ve.ui.MWMathButtonTool.static.inspector = 'mwMathInspector';

ve.ui.MWMathButtonTool.static.modelClasses = [ ve.dm.MWMathNode ];

/* Registration */

ve.ui.toolFactory.register( 'object/math/mw', ve.ui.MWMathButtonTool );
