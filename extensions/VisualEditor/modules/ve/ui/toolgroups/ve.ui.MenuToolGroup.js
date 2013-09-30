/*!
 * VisualEditor UserInterface MenuToolGroup class.
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
ve.ui.MenuToolGroup = function VeUiMenuToolGroup( toolbar, config ) {
	// Parent constructor
	ve.ui.PopupToolGroup.call( this, toolbar, config );

	// Events
	this.toolbar.connect( this, { 'updateState': 'onUpdateState' } );

	// Initialization
	this.$.addClass( 've-ui-menuToolGroup' );
};

/* Inheritance */

ve.inheritClass( ve.ui.MenuToolGroup, ve.ui.PopupToolGroup );

/* Static Properties */

ve.ui.MenuToolGroup.static.showTrigger = true;

/* Methods */

/**
 * Handle the toolbar state being updated.
 *
 * When the state changes, the title of each active item in the menu will be joined together and
 * used as a label for the group. The label will be empty if none of the items are active.
 *
 * @method
 */
ve.ui.MenuToolGroup.prototype.onUpdateState = function () {
	var name,
		labelTexts = [];

	for ( name in this.tools ) {
		if ( this.tools[name].isActive() ) {
			labelTexts.push( this.tools[name].getLabelText() );
		}
	}

	this.setLabel( labelTexts.join( ', ' ) );
};
