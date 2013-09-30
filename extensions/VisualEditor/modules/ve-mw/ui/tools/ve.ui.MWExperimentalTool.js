/*!
 * VisualEditor Experimental MediaWiki UserInterface tool classes.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * MediaWiki UserInterface hieroglyphics tool.
 *
 * @class
 * @extends ve.ui.InspectorTool
 * @constructor
 * @param {ve.ui.SurfaceToolbar} toolbar
 * @param {Object} [config] Configuration options
 */
ve.ui.MWHieroInspectorTool = function VeUiMWHieroInspectorTool( toolbar, config ) {
	ve.ui.InspectorTool.call( this, toolbar, config );
};
ve.inheritClass( ve.ui.MWHieroInspectorTool, ve.ui.InspectorTool );
ve.ui.MWHieroInspectorTool.static.name = 'hiero';
ve.ui.MWHieroInspectorTool.static.group = 'object';
ve.ui.MWHieroInspectorTool.static.icon = 'hiero';
ve.ui.MWHieroInspectorTool.static.titleMessage = 'visualeditor-mwhieroinspector-title';
ve.ui.MWHieroInspectorTool.static.inspector = 'hiero';
ve.ui.MWHieroInspectorTool.static.modelClasses = [ ve.dm.MWHieroNode ];
ve.ui.toolFactory.register( ve.ui.MWHieroInspectorTool );

/**
 * MediaWiki UserInterface alien extension tool.
 *
 * @class
 * @extends ve.ui.InspectorTool
 * @constructor
 * @param {ve.ui.SurfaceToolbar} toolbar
 * @param {Object} [config] Configuration options
 */
ve.ui.MWAlienExtensionInspectorTool = function VeUiMWAlienExtensionInspectorTool( toolbar, config ) {
	ve.ui.InspectorTool.call( this, toolbar, config );
};
ve.inheritClass( ve.ui.MWAlienExtensionInspectorTool, ve.ui.InspectorTool );
ve.ui.MWAlienExtensionInspectorTool.static.name = 'alienExtension';
ve.ui.MWAlienExtensionInspectorTool.static.group = 'object';
ve.ui.MWAlienExtensionInspectorTool.static.icon = 'alienextension';
ve.ui.MWAlienExtensionInspectorTool.static.titleMessage =
	'visualeditor-mwalienextensioninspector-title';
ve.ui.MWAlienExtensionInspectorTool.static.inspector = 'alienExtension';
ve.ui.MWAlienExtensionInspectorTool.static.modelClasses = [ ve.dm.MWAlienExtensionNode ];
ve.ui.MWAlienExtensionInspectorTool.static.autoAdd = false;
ve.ui.toolFactory.register( ve.ui.MWAlienExtensionInspectorTool );

/**
 * MediaWiki UserInterface math tool.
 *
 * @class
 * @extends ve.ui.InspectorTool
 * @constructor
 * @param {ve.ui.SurfaceToolbar} toolbar
 * @param {Object} [config] Configuration options
 */
ve.ui.MWMathInspectorTool = function VeUiMWMathInspectorTool( toolbar, config ) {
	ve.ui.InspectorTool.call( this, toolbar, config );
};
ve.inheritClass( ve.ui.MWMathInspectorTool, ve.ui.InspectorTool );
ve.ui.MWMathInspectorTool.static.name = 'math';
ve.ui.MWMathInspectorTool.static.group = 'object';
ve.ui.MWMathInspectorTool.static.icon = 'math';
ve.ui.MWMathInspectorTool.static.titleMessage = 'visualeditor-mwmathinspector-title';
ve.ui.MWMathInspectorTool.static.inspector = 'math';
ve.ui.MWMathInspectorTool.static.modelClasses = [ ve.dm.MWMathNode ];
ve.ui.toolFactory.register( ve.ui.MWMathInspectorTool );
