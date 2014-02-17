/*!
 * VisualEditor MediaWiki UserInterface edit mode tool classes.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * MediaWiki UserInterface media edit tool.
 *
 * @class
 * @abstract
 * @extends OO.ui.Tool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Config options
 */
ve.ui.MWEditModeTool = function VeUiMWEditModeTool( toolGroup, config ) {
	OO.ui.Tool.call( this, toolGroup, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWEditModeTool, OO.ui.Tool );

/* Static Properties */

ve.ui.MWEditModeTool.static.group = 'editMode';
ve.ui.MWEditModeTool.static.autoAdd = false;

/* Methods */

ve.ui.MWEditModeTool.prototype.onUpdateState = function () {
	this.setActive( false );
};

/**
 * MediaWiki UserInterface edit mode source tool.
 *
 * @class
 * @extends ve.ui.MWEditModeTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Config options
 */
ve.ui.MWEditModeSourceTool = function VeUiMWEditModeSourceTool( toolGroup, config ) {
	ve.ui.MWEditModeTool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.MWEditModeSourceTool, ve.ui.MWEditModeTool );
ve.ui.MWEditModeSourceTool.static.name = 'editModeSource';
ve.ui.MWEditModeSourceTool.static.icon = 'source';
ve.ui.MWEditModeSourceTool.static.titleMessage = 'visualeditor-mweditmodesource-title';

ve.ui.MWEditModeSourceTool.prototype.onSelect = function () {
	this.setActive( false );
	this.toolbar.getTarget().editSource();
};

ve.ui.toolFactory.register( ve.ui.MWEditModeSourceTool );
