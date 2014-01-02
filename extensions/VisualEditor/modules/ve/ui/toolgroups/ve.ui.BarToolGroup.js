/*!
 * VisualEditor UserInterface BarToolGroup class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface bar tool group.
 *
 * @class
 * @abstract
 * @extends ve.ui.ToolGroup
 *
 * @constructor
 * @param {ve.ui.Toolbar} toolbar
 * @param {Object} [config] Configuration options
 */
ve.ui.BarToolGroup = function VeUiBarToolGroup( toolbar, config ) {
	// Parent constructor
	ve.ui.ToolGroup.call( this, toolbar, config );

	// Initialization
	this.$.addClass( 've-ui-barToolGroup' );
};

/* Inheritance */

ve.inheritClass( ve.ui.BarToolGroup, ve.ui.ToolGroup );

/* Static Properties */

ve.ui.BarToolGroup.static.showTitle = true;

ve.ui.BarToolGroup.static.showTrigger = true;
