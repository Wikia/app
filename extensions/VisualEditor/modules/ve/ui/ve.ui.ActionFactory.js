/*!
 * VisualEditor UserInterface ActionFactory class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Action factory.
 *
 * @class
 * @extends ve.Factory
 * @constructor
 */
ve.ui.ActionFactory = function VeUiActionFactory() {
	// Parent constructor
	ve.Factory.call( this );
};

/* Inheritance */

ve.inheritClass( ve.ui.ActionFactory, ve.Factory );

/* Methods */

/**
 * Check if an action supports a method.
 *
 * @method
 * @param {string} action Name of action
 * @param {string} method Name of method
 * @returns {boolean} The action supports the method
 */
ve.ui.ActionFactory.prototype.doesActionSupportMethod = function ( action, method ) {
	if ( action in this.registry ) {
		return this.registry[action].static.methods.indexOf( method ) !== -1;
	}
	throw new Error( 'Unknown action: ' + action );
};

/* Initialization */

ve.ui.actionFactory = new ve.ui.ActionFactory();
