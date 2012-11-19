/**
 * VisualEditor ActionFactory class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Action factory.
 *
 * @class
 * @constructor
 * @extends {ve.Factory}
 */
ve.ActionFactory = function VeActionFactory() {
	// Parent constructor
	ve.Factory.call( this );
};

/* Inheritance */

ve.inheritClass( ve.ActionFactory, ve.Factory );

/* Methods */

/**
 * Checks if a given action supports a given method.
 *
 * @method
 * @param {String} action Name of action
 * @param {String} method Name of method
 * @returns {Boolean} The action supports the method
 */
ve.ActionFactory.prototype.doesActionSupportMethod = function ( action, method ) {
	if ( action in this.registry ) {
		return this.registry[action].static.methods.indexOf( method ) !== -1;
	}
	throw new Error( 'Unknown action: ' + action );
};

/* Initialization */

ve.actionFactory = new ve.ActionFactory();
