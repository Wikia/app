/**
 * VisualEditor user interface BulletListButtonTool class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.BulletButtonTool object.
 *
 * @class
 * @constructor
 * @extends {ve.ui.ListButtonTool}
 * @param {ve.ui.Toolbar} toolbar
 */
ve.ui.BulletButtonTool = function VeUiBulletListButtonTool( toolbar ) {
	// Parent constructor
	ve.ui.ListButtonTool.call( this, toolbar, 'bullet' );
};

/* Inheritance */

ve.inheritClass( ve.ui.BulletButtonTool, ve.ui.ListButtonTool );

/* Static Members */

ve.ui.BulletButtonTool.static.name = 'bullet';

ve.ui.BulletButtonTool.static.titleMessage = 'visualeditor-listbutton-bullet-tooltip';

ve.ui.BulletButtonTool.static.style = 'bullet';

/* Registration */

ve.ui.toolFactory.register( 'bullet', ve.ui.BulletButtonTool );
