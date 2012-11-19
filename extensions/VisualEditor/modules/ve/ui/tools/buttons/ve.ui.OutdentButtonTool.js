/**
 * VisualEditor user interface OutdentButtonTool class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.OutdentButtonTool object.
 *
 * @class
 * @constructor
 * @extends {ve.ui.IndentationButtonTool}
 * @param {ve.ui.Toolbar} toolbar
 */
ve.ui.OutdentButtonTool = function VeUiOutdentButtonTool( toolbar ) {
	// Parent constructor
	ve.ui.IndentationButtonTool.call( this, toolbar );
};

/* Inheritance */

ve.inheritClass( ve.ui.OutdentButtonTool, ve.ui.IndentationButtonTool );

/* Static Members */

ve.ui.OutdentButtonTool.static.name = 'outdent';

ve.ui.OutdentButtonTool.static.titleMessage = 'visualeditor-outdentationbutton-outdent-tooltip';

ve.ui.OutdentButtonTool.static.method = 'decrease';

/* Registration */

ve.ui.toolFactory.register( 'outdent', ve.ui.OutdentButtonTool );
