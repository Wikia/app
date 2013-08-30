/*!
 * VisualEditor UserInterface BulletListButtonTool class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface bullet button tool.
 *
 * @class
 * @extends ve.ui.ListButtonTool
 * @constructor
 * @param {ve.ui.SurfaceToolbar} toolbar
 * @param {Object} [config] Config options
 */
ve.ui.BulletButtonTool = function VeUiBulletButtonTool( toolbar, config ) {
	// Parent constructor
	ve.ui.ListButtonTool.call( this, toolbar, config );
};

/* Inheritance */

ve.inheritClass( ve.ui.BulletButtonTool, ve.ui.ListButtonTool );

/* Static Properties */

ve.ui.BulletButtonTool.static.name = 'structure/bullet';

ve.ui.BulletButtonTool.static.icon = 'bullet-list';

ve.ui.BulletButtonTool.static.titleMessage = 'visualeditor-listbutton-bullet-tooltip';

ve.ui.BulletButtonTool.static.style = 'bullet';

/* Registration */

ve.ui.toolFactory.register( 'structure/bullet', ve.ui.BulletButtonTool );
