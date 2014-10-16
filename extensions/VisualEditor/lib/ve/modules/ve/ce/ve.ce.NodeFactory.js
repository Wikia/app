/*!
 * VisualEditor ContentEditable NodeFactory class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
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
 * Get a plain text description of a node model.
 *
 * @param {ve.dm.Node} node Node to describe
 * @returns {string} Description of the node
 * @throws {Error} Unknown node type
 */
ve.ce.NodeFactory.prototype.getDescription = function ( node ) {
	var type = node.constructor.static.name;
	if ( type in this.registry ) {
		return this.registry[type].static.getDescription( node );
	}
	throw new Error( 'Unknown node type: ' + type );
};

/**
 * Check if a node type splits on Enter
 *
 * @param {string} type Node type
 * @returns {boolean} The node can have grandchildren
 * @throws {Error} Unknown node type
 */
ve.ce.NodeFactory.prototype.splitNodeOnEnter = function ( type ) {
	if ( type in this.registry ) {
		return this.registry[type].static.splitOnEnter;
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

/**
 * Get primary command for node type.
 *
 * @method
 * @param {string} type Node type
 * @returns {string|null} Primary command name
 * @throws {Error} Unknown node type
 */
ve.ce.NodeFactory.prototype.getNodePrimaryCommandName = function ( type ) {
	if ( type in this.registry ) {
		return this.registry[type].static.primaryCommandName;
	}
	throw new Error( 'Unknown node type: ' + type );
};

/* Initialization */

// TODO: Move instantiation to a different file
ve.ce.nodeFactory = new ve.ce.NodeFactory();
