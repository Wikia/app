/*!
 * VisualEditor UserInterface NumberListButtonTool class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface number button tool.
 *
 * @class
 * @extends ve.ui.ListButtonTool
 * @constructor
 * @param {ve.ui.SurfaceToolbar} toolbar
 * @param {Object} [config] Config options
 */
ve.ui.NumberButtonTool = function VeUiNumberButtonTool( toolbar, config ) {
	// Parent constructor
	ve.ui.ListButtonTool.call( this, toolbar, config );
};

/* Inheritance */

ve.inheritClass( ve.ui.NumberButtonTool, ve.ui.ListButtonTool );

/* Static Properties */

ve.ui.NumberButtonTool.static.name = 'structure/number';

ve.ui.NumberButtonTool.static.icon = 'number-list';

ve.ui.NumberButtonTool.static.titleMessage = 'visualeditor-listbutton-number-tooltip';

ve.ui.NumberButtonTool.static.style = 'number';

/* Registration */

ve.ui.toolFactory.register( 'structure/number', ve.ui.NumberButtonTool );
