/*!
 * VisualEditor MediaWiki UserInterface edit mode tool classes.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * MediaWiki UserInterface edit mode tool.
 *
 * @class
 * @abstract
 * @extends ve.ui.Tool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Config options
 */
ve.ui.MWEditModeTool = function VeUiMWEditModeTool( toolGroup, config ) {
	ve.ui.Tool.call( this, toolGroup, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWEditModeTool, ve.ui.Tool );

/* Static Properties */

ve.ui.MWEditModeTool.static.group = 'editMode';

ve.ui.MWEditModeTool.static.autoAddToCatchall = false;

ve.ui.MWEditModeTool.static.autoAddToGroup = false;

/* Methods */

/** */
ve.ui.MWEditModeTool.prototype.onUpdateState = function () {
	// Parent method
	ve.ui.Tool.prototype.onUpdateState.apply( this, arguments );

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
ve.ui.MWEditModeSourceTool.static.title =
	OO.ui.deferMsg( 'visualeditor-mweditmodesource-tool' );
/**
 * @inheritdoc
 */
ve.ui.MWEditModeSourceTool.prototype.onSelect = function () {
	this.toolbar.getTarget().editSource();
	this.setActive( false );
};
ve.ui.toolFactory.register( ve.ui.MWEditModeSourceTool );
