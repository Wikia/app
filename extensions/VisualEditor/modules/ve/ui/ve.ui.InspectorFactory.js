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
 * @extends ve.NamedClassFactory
 * @constructor
 */
ve.ui.InspectorFactory = function VeUiInspectorFactory() {
	// Parent constructor
	ve.NamedClassFactory.call( this );
};

/* Inheritance */

ve.inheritClass( ve.ui.InspectorFactory, ve.NamedClassFactory );

/* Initialization */

ve.ui.inspectorFactory = new ve.ui.InspectorFactory();
