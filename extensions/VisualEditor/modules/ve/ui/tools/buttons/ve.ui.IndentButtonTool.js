/**
 * VisualEditor user interface IndentButtonTool class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.IndentButtonTool object.
 *
 * @class
 * @constructor
 * @extends {ve.ui.IndentationButtonTool}
 * @param {ve.ui.Toolbar} toolbar
 */
ve.ui.IndentButtonTool = function VeUiIndentButtonTool( toolbar ) {
	// Parent constructor
	ve.ui.IndentationButtonTool.call( this, toolbar );
};

/* Inheritance */

ve.inheritClass( ve.ui.IndentButtonTool, ve.ui.IndentationButtonTool );

/* Static Members */

ve.ui.IndentButtonTool.static.name = 'indent';

ve.ui.IndentButtonTool.static.titleMessage = 'visualeditor-indentationbutton-indent-tooltip';

ve.ui.IndentButtonTool.static.method = 'increase';

/* Registration */

ve.ui.toolFactory.register( 'indent', ve.ui.IndentButtonTool );
