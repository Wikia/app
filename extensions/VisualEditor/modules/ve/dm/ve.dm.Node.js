/*!
 * VisualEditor DataModel Node class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Generic DataModel node.
 *
 * @abstract
 * @extends ve.dm.Model
 * @mixins ve.Node
 *
 * @constructor
 * @param {number} [length] Length of content data in document
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.Node = function VeDmNode( length, element ) {
	// Parent constructor
	ve.dm.Model.call( this, element );
	// Mixin constructor
	ve.Node.call( this );
	ve.EventEmitter.call( this );

	// Properties
	this.length = length || 0;
	this.element = element;
	this.doc = undefined;
};

/**
 * @event lengthChange
 * @param diff
 */

/**
 * @event update
 */

/* Inheritance */

ve.inheritClass( ve.dm.Node, ve.dm.Model );

ve.mixinClass( ve.dm.Node, ve.Node );

ve.mixinClass( ve.dm.Node, ve.EventEmitter );

/* Static Properties */

/**
 * Whether this node handles its own children. After converting a DOM node to a linear model
 * node of this type, the converter checks this property. If it's false, the converter will descend
 * into the DOM node's children, recursively convert them, and attach the resulting nodes as
 * children of the linear model node. If it's true, the converter will not descend, and will
 * expect the node's toDataElement() to have handled the entire DOM subtree.
 *
 * The same is true when converting from linear model data to DOM: if this property is true,
 * toDomElements() will be passed the node's data element and all of its children and will be
 * expected to convert the entire subtree. If it's false, the converter will descend into the
 * child nodes and convert each one individually.
 *
 * If .static.childNodeTypes is set to [], this property is ignored and will be assumed to be true.
 *
 * @static
 * @property {boolean} static.handlesOwnChildren
 * @inheritable
 */
ve.dm.Node.static.handlesOwnChildren = false;

/**
 * Whether this node type is internal. Internal node types are ignored by the converter.
 *
 * @static
 * @property {boolean} static.isInternal
 * @inheritable
 */
ve.dm.Node.static.isInternal = false;

/**
 * Whether this node type has a wrapping element in the linear model. Most node types are wrapped,
 * only special node types are not wrapped.
 *
 * @static
 * @property {boolean} static.isWrapped
 * @inheritable
 */
ve.dm.Node.static.isWrapped = true;

/**
 * Whether this node type is a content node type. This means the node represents content, cannot
 * have children, and can only appear as children of a content container node. Content nodes are
 * also known as inline nodes.
 *
 * @static
 * @property {boolean} static.isContent
 * @inheritable
 */
ve.dm.Node.static.isContent = false;

/**
 * Whether this node type can contain content. The children of content container nodes must be
 * content nodes.
 *
 * @static
 * @property {boolean} static.canContainContent
 * @inheritable
 */
ve.dm.Node.static.canContainContent = false;

/**
 * Whether this node type has significant whitespace. Only applies to content container nodes
 * (i.e. can only be true if canContainContent is also true).
 *
 * If a content node has significant whitespace, the text inside it is not subject to whitespace
 * stripping and preservation.
 *
 * @static
 * @property {boolean} static.hasSignificantWhitespace
 * @inheritable
 */
ve.dm.Node.static.hasSignificantWhitespace = false;

/**
 * Array of allowed child node types for this node type.
 *
 * An empty array means no children are allowed. null means any node type is allowed as a child.
 *
 * @static
 * @property {string[]|null} static.childNodeTypes
 * @inheritable
 */
ve.dm.Node.static.childNodeTypes = null;

/**
 * Array of allowed parent node types for this node type.
 *
 * An empty array means this node type cannot be the child of any node. null means this node type
 * can be the child of any node type.
 *
 * @static
 * @property {string[]|null} static.parentNodeTypes
 * @inheritable
 */
ve.dm.Node.static.parentNodeTypes = null;

/**
 * Array of suggested parent node types for this node type.
 *
 * These parent node types are allowed but the editor will avoid creating them.
 *
 * An empty array means this node type should not be the child of any node. null means this node type
 * can be the child of any node type.
 *
 * @static
 * @property {string[]|null} static.suggestedParentNodeTypes
 * @inheritable
 */
ve.dm.Node.static.suggestedParentNodeTypes = null;

/**
 * Array of annotation types which can't be applied to this node
 *
 * @static
 * @property {string[]} static.blacklistedAnnotationTypes
 * @inheritable
 */
ve.dm.Node.static.blacklistedAnnotationTypes = [];

/**
 * Default attributes to set for newly created linear model elements. These defaults will be used
 * when creating a new element in ve.dm.NodeFactory#getDataElement when there is no DOM node or
 * existing linear model element to base the attributes on.
 *
 * This property is an object with attribute names as keys and attribute values as values.
 * Attributes may be omitted, in which case they'll simply be undefined.
 *
 * @static
 * @property {Object} static.defaultAttributes
 * @inheritable
 */
ve.dm.Node.static.defaultAttributes = {};

/**
 * Remap the store indexes stored in a linear model data element.
 *
 * The default implementation is empty. Nodes should override this if they store store indexes in
.* attributes. To remap, do something like
 * dataElement.attributes.foo = mapping[dataElement.attributes.foo];
 *
 * @static
 * @inheritable
 * @param {Object} dataElement Data element (opening) to remap. Will be modified.
 * @param {Object} mapping Object mapping old store indexes to new store indexes
 */
ve.dm.Node.static.remapStoreIndexes = function ( /*dataElement, mapping*/ ) {
};

/**
 * Remap the internal list indexes stored in a linear model data element.
 *
 * The default implementation is empty. Nodes should override this if they store internal list
 * indexes in attributes. To remap, do something like
 * dataElement.attributes.foo = mapping[dataElement.attributes.foo];
 *
 * @static
 * @inheritable
 * @param {Object} dataElement Data element (opening) to remap. Will be modified.
 * @param {Object} mapping Object mapping old internal list indexes to new internal list indexes
 */
ve.dm.Node.static.remapInternalListIndexes = function ( /*dataElement, mapping*/ ) {
};

/**
 * Determine if a hybrid element is inline and allowed to be inline in this context
 *
 * We generate block elements for block tags and inline elements for inline
 * tags; unless we're in a content location, in which case we have no choice
 * but to generate an inline element.
 *
 * @param {HTMLElement[]} domElements DOM elements being converted
 * @param {ve.dm.Converter} converter Converter object
 * @returns {boolean} The element is inline
 */
ve.dm.Node.static.isHybridInline = function ( domElements, converter ) {
	var i, length, allTagsInline = true;

	for ( i = 0, length = domElements.length; i < length; i++ ) {
		if ( ve.isBlockElement( domElements[i] ) ) {
			allTagsInline = false;
			break;
		}
	}

	// Force inline in content locations (but not wrappers)
	return ( converter.isExpectingContent() && !converter.isInWrapper() ) ||
		// ..also force inline in wrappers that we can't close
		( converter.isInWrapper() && !converter.canCloseWrapper() ) ||
		// ..otherwise just look at the tag names
		allTagsInline;
};

/* Methods */

/**
 * Check whether this node can be inspected by a tool.
 *
 * The default implementation always returns true. If your node type is uninspectable in certain
 * cases, you should override this function.
 *
 * @returns {boolean} Whether this node is inspectable
 */
ve.dm.Node.prototype.isInspectable = function () {
	return true;
};

/**
 * Get a clone of the node's document data element.
 *
 * The attributes object will be deep-copied, and the .htmlAttributes and .internal.generated
 * properties will be removed if present.
 *
 * @returns {Object} Cloned element object
 */
ve.dm.Node.prototype.getClonedElement = function () {
	var clone = ve.copy( this.element );
	if ( clone.internal ) {
		delete clone.internal.generated;
		if ( ve.isEmptyObject( clone.internal ) ) {
			delete clone.internal;
		}
	}
	delete clone.htmlAttributes;
	return clone;
};

/**
 * Get allowed child node types.
 *
 * @method
 * @returns {string[]|null} List of node types allowed as children or null if any type is allowed
 */
ve.dm.Node.prototype.getChildNodeTypes = function () {
	return this.constructor.static.childNodeTypes;
};

/**
 * Get allowed parent node types.
 *
 * @method
 * @returns {string[]|null} List of node types allowed as parents or null if any type is allowed
 */
ve.dm.Node.prototype.getParentNodeTypes = function () {
	return this.constructor.static.parentNodeTypes;
};

/**
 * Get suggested parent node types.
 *
 * @method
 * @returns {string[]|null} List of node types suggested as parents or null if any type is suggested
 */
ve.dm.Node.prototype.getSuggestedParentNodeTypes = function () {
	return this.constructor.static.suggestedParentNodeTypes;
};

/**
 * Check if the node can have children.
 *
 * @method
 * @returns {boolean} Node can have children
 */
ve.dm.Node.prototype.canHaveChildren = function () {
	return ve.dm.nodeFactory.canNodeHaveChildren( this.type );
};

/**
 * Check if the node can have children but not content nor be content.
 *
 * @method
 * @returns {boolean} Node can have children but not content nor be content
 */
ve.dm.Node.prototype.canHaveChildrenNotContent = function () {
	return ve.dm.nodeFactory.canNodeHaveChildrenNotContent( this.type );
};

/**
 * Check if the node has a wrapped element in the document data.
 *
 * @method
 * @returns {boolean} Node represents a wrapped element
 */
ve.dm.Node.prototype.isWrapped = function () {
	return this.constructor.static.isWrapped;
};

/**
 * Check if the node can contain content.
 *
 * @method
 * @returns {boolean} Node can contain content
 */
ve.dm.Node.prototype.canContainContent = function () {
	return this.constructor.static.canContainContent;
};

/**
 * Check if the node is content.
 *
 * @method
 * @returns {boolean} Node is content
 */
ve.dm.Node.prototype.isContent = function () {
	return this.constructor.static.isContent;
};

/**
 * Check if the node has significant whitespace.
 *
 * Can only be true if canContainContent is also true.
 *
 * @method
 * @returns {boolean} Node has significant whitespace
 */
ve.dm.Node.prototype.hasSignificantWhitespace = function () {
	return this.constructor.static.hasSignificantWhitespace;
};

/**
 * Check if the node has an ancestor with matching type and attribute values.
 *
 * @method
 * @returns {boolean} Node is content
 */
ve.dm.Node.prototype.hasMatchingAncestor = function ( type, attributes ) {
	var key,
		node = this;
	// Traverse up to matching node
	while ( node && node.getType() !== type ) {
		node = node.getParent();
		// Stop at root
		if ( node === null ) {
			return false;
		}
	}
	// Check attributes
	if ( attributes ) {
		for ( key in attributes ) {
			if ( node.getAttribute( key ) !== attributes[key] ) {
				return false;
			}
		}
	}
	return true;
};

/**
 * Get the length of the node.
 *
 * @method
 * @returns {number} Length of the node's contents
 */
ve.dm.Node.prototype.getLength = function () {
	return this.length;
};

/**
 * Get the outer length of the node, which includes wrappers if present.
 *
 * @method
 * @returns {number} Length of the entire node
 */
ve.dm.Node.prototype.getOuterLength = function () {
	return this.length + ( this.isWrapped() ? 2 : 0 );
};

/**
 * Get the range inside the node.
 *
 * @method
 * @returns {ve.Range} Inner node range
 */
ve.dm.Node.prototype.getRange = function () {
	var offset = this.getOffset();
	if ( this.isWrapped() ) {
		offset++;
	}
	return new ve.Range( offset, offset + this.length );
};

/**
 * Get the range outside the node.
 *
 * @method
 * @returns {ve.Range} Outer node range
 */
ve.dm.Node.prototype.getOuterRange = function () {
	var offset = this.getOffset();
	return new ve.Range( offset, offset + this.getOuterLength() );
};

/**
 * Set the inner length of the node.
 *
 * This should only be called after a relevant change to the document data. Calling this method will
 * not change the document data.
 *
 * @method
 * @param {number} length Length of content
 * @emits lengthChange
 * @emits update
 * @throws {Error} Invalid content length error if length is less than 0
 */
ve.dm.Node.prototype.setLength = function ( length ) {
	if ( length < 0 ) {
		throw new Error( 'Length cannot be negative' );
	}
	// Compute length adjustment from old length
	var diff = length - this.length;
	// Set new length
	this.length = length;
	// Adjust the parent's length
	if ( this.parent ) {
		this.parent.adjustLength( diff );
	}
	// Emit events
	this.emit( 'lengthChange', diff );
	this.emit( 'update' );
};

/**
 * Adjust the length.
 *
 * This should only be called after a relevant change to the document data. Calling this method will
 * not change the document data.
 *
 * @method
 * @param {number} adjustment Amount to adjust length by
 * @emits lengthChange
 * @emits update
 * @throws {Error} Invalid adjustment error if resulting length is less than 0
 */
ve.dm.Node.prototype.adjustLength = function ( adjustment ) {
	this.setLength( this.length + adjustment );
};

/**
 * Get the offset of the node within the document.
 *
 * If the node has no parent than the result will always be 0.
 *
 * @method
 * @returns {number} Offset of node
 * @throws {Error} Node not found in parent's children array
 */
ve.dm.Node.prototype.getOffset = function () {
	var i, len, siblings, offset;

	if ( !this.parent ) {
		return 0;
	}

	// Find our index in the parent and add up lengths while we do so
	siblings = this.parent.children;
	offset = this.parent.getOffset() + ( this.parent === this.root ? 0 : 1 );
	for ( i = 0, len = siblings.length; i < len; i++ ) {
		if ( siblings[i] === this ) {
			break;
		}
		offset += siblings[i].getOuterLength();
	}
	if ( i === len ) {
		throw new Error( 'Node not found in parent\'s children array' );
	}
	return offset;
};

/**
 * Check if the node can be merged with another.
 *
 * For two nodes to be mergeable, the two nodes must either be the same node or:
 *  - Have the same type
 *  - Have the same depth
 *  - Have similar ancestory (each node upstream must have the same type)
 *
 * @method
 * @param {ve.dm.Node} node Node to consider merging with
 * @returns {boolean} Nodes can be merged
 */
ve.dm.Node.prototype.canBeMergedWith = function ( node ) {
	var n1 = this,
		n2 = node;

	// Content node can be merged with node that can contain content, for instance: TextNode
	// and ParagraphNode. When this method is called for such case (one node is a content node and
	// the other one can contain content) make sure to start traversal from node that can contain
	// content (insteaf of content node itself).
	if ( n1.canContainContent() && n2.isContent() ) {
		n2 = n2.getParent();
	} else if ( n2.canContainContent() && n1.isContent() ) {
		n1 = n1.getParent();
	}
	// Move up from n1 and n2 simultaneously until we find a common ancestor
	while ( n1 !== n2 ) {
		if (
			// Check if we have reached a root (means there's no common ancestor or unequal depth)
			( n1 === null || n2 === null ) ||
			// Ensure that types match
			n1.getType() !== n2.getType()
		) {
			return false;
		}
		// Move up
		n1 = n1.getParent();
		n2 = n2.getParent();
	}
	return true;
};
