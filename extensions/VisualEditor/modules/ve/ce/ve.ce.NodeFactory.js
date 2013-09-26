/*!
 * VisualEditor ContentEditable NodeFactory class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable node factory.
 *
 * @class
 * @extends ve.NamedClassFactory
 * @constructor
 */
ve.ce.NodeFactory = function VeCeNodeFactory() {
	// Parent constructor
	ve.NamedClassFactory.call( this );
};

/* Inheritance */

ve.inheritClass( ve.ce.NodeFactory, ve.NamedClassFactory );

/* Methods */

/**
 * Check if a node type can be split.
 *
 * @param {string} type Node type
 * @returns {boolean} The node can have grandchildren
 * @throws {Error} Unknown node type
 */
ve.ce.NodeFactory.prototype.canNodeBeSplit = function ( type ) {
	if ( type in this.registry ) {
		return this.registry[type].static.canBeSplit;
	}
	throw new Error( 'Unknown node type: ' + type );
};

/* Initialization */

// TODO: Move instantiation to a different file
ve.ce.nodeFactory = new ve.ce.NodeFactory();
