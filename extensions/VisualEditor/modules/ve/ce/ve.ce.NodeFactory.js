/**
 * VisualEditor content editable NodeFactory class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable node factory.
 *
 * @class
 * @extends {ve.Factory}
 * @constructor
 */
ve.ce.NodeFactory = function VeCeNodeFactory() {
	// Parent constructor
	ve.Factory.call( this );
};

/* Inheritance */

ve.inheritClass( ve.ce.NodeFactory, ve.Factory );

/* Methods */

/**
 * Checks if a given node type can be split.
 *
 * @param {String} type Node type
 * @returns {Boolean} The node can have grandchildren
 * @throws 'Unknown node type'
 */
ve.ce.NodeFactory.prototype.canNodeBeSplit = function ( type ) {
	if ( type in this.registry ) {
		return this.registry[type].rules.canBeSplit;
	}
	throw new Error( 'Unknown node type: ' + type );
};

/* Initialization */

// TODO: Move instantiation to a different file
ve.ce.nodeFactory = new ve.ce.NodeFactory();
