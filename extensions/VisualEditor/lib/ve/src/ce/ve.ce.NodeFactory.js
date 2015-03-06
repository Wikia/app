/*!
 * VisualEditor ContentEditable NodeFactory class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
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
	if ( Object.prototype.hasOwnProperty.call( this.registry, type ) ) {
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
	if ( Object.prototype.hasOwnProperty.call( this.registry, type ) ) {
		return this.registry[type].static.splitOnEnter;
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
	if ( Object.prototype.hasOwnProperty.call( this.registry, type ) ) {
		return this.registry[type].static.primaryCommandName;
	}
	throw new Error( 'Unknown node type: ' + type );
};

/* Initialization */

// TODO: Move instantiation to a different file
ve.ce.nodeFactory = new ve.ce.NodeFactory();
