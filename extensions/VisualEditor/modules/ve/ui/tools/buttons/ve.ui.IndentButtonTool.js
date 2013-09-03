/*!
 * VisualEditor UserInterface IndentButtonTool class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface indent button tool.
 *
 * @class
 * @extends ve.ui.IndentationButtonTool
 * @constructor
 * @param {ve.ui.SurfaceToolbar} toolbar
 * @param {Object} [config] Config options
 */
ve.ui.IndentButtonTool = function VeUiIndentButtonTool( toolbar, config ) {
	// Parent constructor
	ve.ui.IndentationButtonTool.call( this, toolbar, config );
};

/* Inheritance */

ve.inheritClass( ve.ui.IndentButtonTool, ve.ui.IndentationButtonTool );

/* Static Properties */

ve.ui.IndentButtonTool.static.name = 'structure/indent';

ve.ui.IndentButtonTool.static.icon = 'indent-list';

ve.ui.IndentButtonTool.static.titleMessage = 'visualeditor-indentationbutton-indent-tooltip';

ve.ui.IndentButtonTool.static.method = 'increase';

/* Registration */

ve.ui.toolFactory.register( 'structure/indent', ve.ui.IndentButtonTool );

ve.ui.commandRegistry.register( 'structure/indent', 'indentation', 'increase' );

ve.ui.triggerRegistry.register( 'structure/indent', new ve.ui.Trigger( 'tab' ) );
