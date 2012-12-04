/**
 * VisualEditor data model InspectorFactory class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel Inspector factory.
 *
 * @class
 * @constructor
 * @extends {ve.Factory}
 */
ve.ui.InspectorFactory = function VeDmInspectorFactory() {
	// Parent constructor
	ve.Factory.call( this );
};

/* Inheritance */

ve.inheritClass( ve.ui.InspectorFactory, ve.Factory );

/* Methods */

/**
 * Gets an inspector constructor for a given annotation type.
 *
 * If {static.typePattern} is not defined in an inspector subclass a regular expression that matches
 * nothing will be returned.
 *
 * @method
 * @param {String} name Symbolic name of inspector to get pattern for
 * @returns {RegExp} Regular expression matching annotations relevant to a given inspector
 */
ve.ui.InspectorFactory.prototype.getTypePattern = function ( name ) {
	if ( name in this.registry ) {
		if ( this.registry[name].static && this.registry[name].static.typePattern ) {
			return this.registry[name].static.typePattern;
		}
		return new RegExp();
	}
	throw new Error( 'Unknown inspector: ' + name );
};

/* Initialization */

ve.ui.inspectorFactory = new ve.ui.InspectorFactory();
