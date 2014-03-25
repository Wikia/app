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
 * @extends OO.Factory
 * @constructor
 */
ve.ce.NodeFactory = function VeCeNodeFactory() {
	// Parent constructor
	OO.Factory.call( this );
};

/* Inheritance */

OO.inheritClass( ve.ce.NodeFactory, OO.Factory );

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

/**
 * Check if the node is focusable.
 *
 * @method
 * @param {string} type Node type
 * @returns {boolean} Whether the node is focusable
 * @throws {Error} Unknown node type
 */
ve.ce.NodeFactory.prototype.isNodeFocusable = function ( type ) {
	if ( type in this.registry ) {
		return this.registry[type].static.isFocusable;
	}
	throw new Error( 'Unknown node type: ' + type );
};

/* Initialization */

// TODO: Move instantiation to a different file
ve.ce.nodeFactory = new ve.ce.NodeFactory();
