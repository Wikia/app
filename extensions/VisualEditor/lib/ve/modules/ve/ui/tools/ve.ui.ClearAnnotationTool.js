/*!
 * VisualEditor UserInterface ClearAnnotationTool class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface clear tool.
 *
 * @class
 * @extends ve.ui.Tool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.ClearAnnotationTool = function VeUiClearAnnotationTool( toolGroup, config ) {
	// Parent constructor
	ve.ui.Tool.call( this, toolGroup, config );

	// Initialization
	this.setDisabled( true );
};

/* Inheritance */

OO.inheritClass( ve.ui.ClearAnnotationTool, ve.ui.Tool );

/* Static Properties */

ve.ui.ClearAnnotationTool.static.name = 'clear';

ve.ui.ClearAnnotationTool.static.group = 'utility';

ve.ui.ClearAnnotationTool.static.icon = 'clear';

ve.ui.ClearAnnotationTool.static.title =
	OO.ui.deferMsg( 'visualeditor-clearbutton-tooltip' );

ve.ui.ClearAnnotationTool.static.requiresRange = true;

ve.ui.ClearAnnotationTool.static.commandName = 'clear';

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.ClearAnnotationTool.prototype.onSelect = function () {
	ve.track( 'tool.annotation.select', { name: this.constructor.static.name } );
	ve.ui.Tool.prototype.onSelect.apply( this, arguments );
};

/**
 * @inheritdoc
 */
ve.ui.ClearAnnotationTool.prototype.onUpdateState = function ( fragment ) {
	// Parent method
	ve.ui.Tool.prototype.onUpdateState.apply( this, arguments );

	if ( !this.isDisabled() ) {
		this.setDisabled( fragment.getAnnotations( true ).isEmpty() );
	}
};

/* Registration */

ve.ui.toolFactory.register( ve.ui.ClearAnnotationTool );
