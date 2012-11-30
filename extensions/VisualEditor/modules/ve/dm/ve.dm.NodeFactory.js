/**
 * VisualEditor data model NodeFactory class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel node factory.
 *
 * @class
 * @extends {ve.Factory}
 * @constructor
 */
ve.dm.NodeFactory = function VeDmNodeFactory() {
	// Parent constructor
	ve.Factory.call( this );
};

/* Inheritance */

ve.inheritClass( ve.dm.NodeFactory, ve.Factory );

/* Methods */

/**
 * Gets a list of allowed child node types for a given node.
 *
 * @method
 * @param {String} type Node type
 * @returns {String[]|null} List of node types allowed as children or null if any type is allowed
 * @throws 'Unknown node type: {type}'
 */
ve.dm.NodeFactory.prototype.getChildNodeTypes = function ( type ) {
	if ( type in this.registry ) {
		return this.registry[type].rules.childNodeTypes;
	}
	throw new Error( 'Unknown node type: ' + type );
};

/**
 * Gets a list of allowed parent node types for a given node.
 *
 * @method
 * @param {String} type Node type
 * @returns {String[]|null} List of node types allowed as parents or null if any type is allowed
 * @throws 'Unknown node type: {type}'
 */
ve.dm.NodeFactory.prototype.getParentNodeTypes = function ( type ) {
	if ( type in this.registry ) {
		return this.registry[type].rules.parentNodeTypes;
	}
	throw new Error( 'Unknown node type: ' + type );
};

/**
 * Checks if a given node type can have child nodes.
 *
 * @method
 * @param {String} type Node type
 * @returns {Boolean} The node can have children
 * @throws 'Unknown node type: {type}'
 */
ve.dm.NodeFactory.prototype.canNodeHaveChildren = function ( type ) {
	if ( type in this.registry ) {
		// If childNodeTypes is null any child is allowed, if it's an array of at least one element
		// than at least one kind of node is allowed
		var types = this.registry[type].rules.childNodeTypes;
		return types === null || ( ve.isArray( types ) && types.length > 0 );
	}
	throw new Error( 'Unknown node type: ' + type );
};

/**
 * Checks if a given node type can have grandchild nodes.
 *
 * @method
 * @param {String} type Node type
 * @returns {Boolean} The node can have grandchildren
 * @throws 'Unknown node type: {type}'
 */
ve.dm.NodeFactory.prototype.canNodeHaveGrandchildren = function ( type ) {
	if ( type in this.registry ) {
		return this.canNodeHaveChildren( type ) &&
			!this.registry[type].rules.canContainContent &&
			!this.registry[type].rules.isContent;
	}
	throw new Error( 'Unknown node type: ' + type );
};

/**
 * Checks if a given node type has a wrapping element.
 *
 * @method
 * @param {String} type Node type
 * @returns {Boolean} Whether the node has a wrapping element
 * @throws 'Unknown node type: {type}'
 */
ve.dm.NodeFactory.prototype.isNodeWrapped = function ( type ) {
	if ( type in this.registry ) {
		return this.registry[type].rules.isWrapped;
	}
	throw new Error( 'Unknown node type: ' + type );
};

/**
 * Checks if a given node contains content.
 *
 * @method
 * @param {String} type Node type
 * @returns {Boolean} The node contains content
 * @throws 'Unknown node type: {type}'
 */
ve.dm.NodeFactory.prototype.canNodeContainContent = function ( type ) {
	if ( type in this.registry ) {
		return this.registry[type].rules.canContainContent;
	}
	throw new Error( 'Unknown node type: ' + type );
};

/**
 * Checks if a given node is content.
 *
 * @method
 * @param {String} type Node type
 * @returns {Boolean} The node is content
 * @throws 'Unknown node type: {type}'
 */
ve.dm.NodeFactory.prototype.isNodeContent = function ( type ) {
	if ( type in this.registry ) {
		return this.registry[type].rules.isContent;
	}
	throw new Error( 'Unknown node type: ' + type );
};

/**
 * Checks if a given node has significant whitespace. Can only be true if canContainContent is
 * also true.
 *
 * @method
 * @param {String} type Node type
 * @returns {Boolean} The node has significant whitespace
 * @throws 'Unknown node type: {type}'
 */
ve.dm.NodeFactory.prototype.doesNodeHaveSignificantWhitespace = function ( type ) {
	if ( type in this.registry ) {
		return this.registry[type].rules.hasSignificantWhitespace;
	}
	throw new Error( 'Unknown node type: ' + type );
};

/* Initialization */

ve.dm.nodeFactory = new ve.dm.NodeFactory();
