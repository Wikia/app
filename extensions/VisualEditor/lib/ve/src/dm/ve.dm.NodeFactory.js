/*!
 * VisualEditor DataModel NodeFactory class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * DataModel node factory.
 *
 * @class
 * @extends OO.Factory
 * @constructor
 */
ve.dm.NodeFactory = function VeDmNodeFactory() {
	// Parent constructor
	OO.Factory.call( this );
};

/* Inheritance */

OO.inheritClass( ve.dm.NodeFactory, OO.Factory );

/* Methods */

/**
 * Get a document data element.
 *
 * @method
 * @param {string} type Node type
 * @param {Object} attributes Node attributes, defaults will be used where needed
 * @returns {Object} Data element
 * @throws {Error} Unknown node type
 */
ve.dm.NodeFactory.prototype.getDataElement = function ( type, attributes ) {
	var element = { type: type };
	if ( Object.prototype.hasOwnProperty.call( this.registry, type ) ) {
		attributes = ve.extendObject( {}, this.registry[type].static.defaultAttributes, attributes );
		if ( !ve.isEmptyObject( attributes ) ) {
			element.attributes = ve.copy( attributes );
		}
		return element;
	}
	throw new Error( 'Unknown node type: ' + type );
};

/**
 * Get allowed child node types for a node.
 *
 * @method
 * @param {string} type Node type
 * @returns {string[]|null} List of node types allowed as children or null if any type is allowed
 * @throws {Error} Unknown node type
 */
ve.dm.NodeFactory.prototype.getChildNodeTypes = function ( type ) {
	if ( Object.prototype.hasOwnProperty.call( this.registry, type ) ) {
		return this.registry[type].static.childNodeTypes;
	}
	throw new Error( 'Unknown node type: ' + type );
};

/**
 * Get allowed parent node types for a node.
 *
 * @method
 * @param {string} type Node type
 * @returns {string[]|null} List of node types allowed as parents or null if any type is allowed
 * @throws {Error} Unknown node type
 */
ve.dm.NodeFactory.prototype.getParentNodeTypes = function ( type ) {
	if ( Object.prototype.hasOwnProperty.call( this.registry, type ) ) {
		return this.registry[type].static.parentNodeTypes;
	}
	throw new Error( 'Unknown node type: ' + type );
};

/**
 * Get suggested parent node types for a node.
 *
 * @method
 * @param {string} type Node type
 * @returns {string[]|null} List of node types suggested as parents or null if any type is suggested
 * @throws {Error} Unknown node type
 */
ve.dm.NodeFactory.prototype.getSuggestedParentNodeTypes = function ( type ) {
	if ( Object.prototype.hasOwnProperty.call( this.registry, type ) ) {
		return this.registry[type].static.suggestedParentNodeTypes;
	}
	throw new Error( 'Unknown node type: ' + type );
};

/**
 * Check if a node can have children.
 *
 * @method
 * @param {string} type Node type
 * @returns {boolean} The node can have children
 * @throws {Error} Unknown node type
 */
ve.dm.NodeFactory.prototype.canNodeHaveChildren = function ( type ) {
	if ( Object.prototype.hasOwnProperty.call( this.registry, type ) ) {
		// If childNodeTypes is null any child is allowed, if it's an array of at least one element
		// than at least one kind of node is allowed
		var types = this.registry[type].static.childNodeTypes;
		return types === null || ( Array.isArray( types ) && types.length > 0 );
	}
	throw new Error( 'Unknown node type: ' + type );
};

/**
 * Check if a node can have children but not content nor be content.
 *
 * @method
 * @param {string} type Node type
 * @returns {boolean} The node can have children but not content nor be content
 * @throws {Error} Unknown node type
 */
ve.dm.NodeFactory.prototype.canNodeHaveChildrenNotContent = function ( type ) {
	if ( Object.prototype.hasOwnProperty.call( this.registry, type ) ) {
		return this.canNodeHaveChildren( type ) &&
			!this.registry[type].static.canContainContent &&
			!this.registry[type].static.isContent;
	}
	throw new Error( 'Unknown node type: ' + type );
};

/**
 * Check if a node has a wrapped element in the document data.
 *
 * @method
 * @param {string} type Node type
 * @returns {boolean} Whether the node has a wrapping element
 * @throws {Error} Unknown node type
 */
ve.dm.NodeFactory.prototype.isNodeWrapped = function ( type ) {
	if ( Object.prototype.hasOwnProperty.call( this.registry, type ) ) {
		return this.registry[type].static.isWrapped;
	}
	throw new Error( 'Unknown node type: ' + type );
};

/**
 * Check if a node can contain content.
 *
 * @method
 * @param {string} type Node type
 * @returns {boolean} The node contains content
 * @throws {Error} Unknown node type
 */
ve.dm.NodeFactory.prototype.canNodeContainContent = function ( type ) {
	if ( Object.prototype.hasOwnProperty.call( this.registry, type ) ) {
		return this.registry[type].static.canContainContent;
	}
	throw new Error( 'Unknown node type: ' + type );
};

/**
 * Check if node can take annotations of a specific type.
 *
 * @method
 * @param {string} type Node type
 * @param {ve.dm.Annotation} annotation Annotation to test
 * @returns {boolean} Node can take annotations of this type
 * @throws {Error} Unknown node type
 */
ve.dm.NodeFactory.prototype.canNodeTakeAnnotationType = function ( type, annotation ) {
	if ( !Object.prototype.hasOwnProperty.call( this.registry, type ) ) {
		throw new Error( 'Unknown node type: ' + type );
	}
	var i, len,
		blacklist = this.registry[type].static.blacklistedAnnotationTypes;

	for ( i = 0, len = blacklist.length; i < len; i++ ) {
		if ( annotation instanceof ve.dm.annotationFactory.lookup( blacklist[i] ) ) {
			return false;
		}
	}
	return true;
};

/**
 * Check if a node is content.
 *
 * @method
 * @param {string} type Node type
 * @returns {boolean} The node is content
 * @throws {Error} Unknown node type
 */
ve.dm.NodeFactory.prototype.isNodeContent = function ( type ) {
	if ( Object.prototype.hasOwnProperty.call( this.registry, type ) ) {
		return this.registry[type].static.isContent;
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
ve.dm.NodeFactory.prototype.isNodeFocusable = function ( type ) {
	if ( Object.prototype.hasOwnProperty.call( this.registry, type ) ) {
		return this.registry[type].static.isFocusable;
	}
	throw new Error( 'Unknown node type: ' + type );
};

/**
 * Check if the node has significant whitespace.
 *
 * Can only be true if canContainContent is also true.
 *
 * @method
 * @param {string} type Node type
 * @returns {boolean} The node has significant whitespace
 * @throws {Error} Unknown node type
 */
ve.dm.NodeFactory.prototype.doesNodeHaveSignificantWhitespace = function ( type ) {
	if ( Object.prototype.hasOwnProperty.call( this.registry, type ) ) {
		return this.registry[type].static.hasSignificantWhitespace;
	}
	throw new Error( 'Unknown node type: ' + type );
};

/**
 * Check if the node handles its own children.
 *
 * @method
 * @param {string} type Node type
 * @returns {boolean} Whether the node handles its own children
 * @throws {Error} Unknown node type
 */
ve.dm.NodeFactory.prototype.doesNodeHandleOwnChildren = function ( type ) {
	if ( Object.prototype.hasOwnProperty.call( this.registry, type ) ) {
		return this.registry[type].static.handlesOwnChildren;
	}
	throw new Error( 'Unknown node type: ' + type );
};

/**
 * Check if the node is internal.
 *
 * @method
 * @param {string} type Node type
 * @returns {boolean} Whether the node is internal
 * @throws {Error} Unknown node type
 */
ve.dm.NodeFactory.prototype.isNodeInternal = function ( type ) {
	if ( Object.prototype.hasOwnProperty.call( this.registry, type ) ) {
		return this.registry[type].static.isInternal;
	}
	throw new Error( 'Unknown node type: ' + type );
};

/* Initialization */

ve.dm.nodeFactory = new ve.dm.NodeFactory();
