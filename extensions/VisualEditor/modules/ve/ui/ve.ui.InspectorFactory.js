/*!
 * VisualEditor UserInterface InspectorFactory class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface inspector factory.
 *
 * @class
 * @extends ve.Factory
 * @constructor
 */
ve.ui.InspectorFactory = function VeUiInspectorFactory() {
	// Parent constructor
	ve.Factory.call( this );
};

/* Inheritance */

ve.inheritClass( ve.ui.InspectorFactory, ve.Factory );

/* Initialization */

ve.ui.inspectorFactory = new ve.ui.InspectorFactory();
