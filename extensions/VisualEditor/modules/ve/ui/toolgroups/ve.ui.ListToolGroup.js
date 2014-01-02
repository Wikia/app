/*!
 * VisualEditor UserInterface ListToolGroup class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface bar tool group.
 *
 * @class
 * @abstract
 * @extends ve.ui.PopupToolGroup
 *
 * @constructor
 * @param {ve.ui.Toolbar} toolbar
 * @param {Object} [config] Configuration options
 */
ve.ui.ListToolGroup = function VeUiListToolGroup( toolbar, config ) {
	// Parent constructor
	ve.ui.PopupToolGroup.call( this, toolbar, config );

	// Initialization
	this.$.addClass( 've-ui-listToolGroup' );
};

/* Inheritance */

ve.inheritClass( ve.ui.ListToolGroup, ve.ui.PopupToolGroup );

/* Static Properties */

ve.ui.ListToolGroup.static.showTrigger = true;
