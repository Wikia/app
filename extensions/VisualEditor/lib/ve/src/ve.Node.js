/*!
 * VisualEditor Node class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Generic node.
 *
 * @abstract
 * @mixins OO.EventEmitter
 *
 * @constructor
 */
ve.Node = function VeNode() {
	// Properties
	this.type = this.constructor.static.name;
	this.parent = null;
	this.root = null;
	this.doc = null;
};

/**
 * @event attach
 * @param {ve.Node} parent
 */

/**
 * @event detach
 * @param {ve.Node} parent
 */

/**
 * @event root
 */

/**
 * @event unroot
 */

/* Abstract Methods */

/**
 * Get allowed child node types.
 *
 * @method
 * @abstract
 * @return {string[]|null} List of node types allowed as children or null if any type is allowed
 */
ve.Node.prototype.getChildNodeTypes = null;

/**
 * Get allowed parent node types.
 *
 * @method
 * @abstract
 * @return {string[]|null} List of node types allowed as parents or null if any type is allowed
 */
ve.Node.prototype.getParentNodeTypes = null;

/**
 * Check if the specified type is an allowed child node type
 *
 * @param {string} type Node type
 * @return {boolean} The type is allowed
 */
ve.Node.prototype.isAllowedChildNodeType = function ( type ) {
	var childTypes = this.getChildNodeTypes();
	return childTypes === null || childTypes.indexOf( type ) !== -1;
};

/**
 * Check if the specified type is an allowed child node type
 *
 * @param {string} type Node type
 * @return {boolean} The type is allowed
 */
ve.Node.prototype.isAllowedParentNodeType = function ( type ) {
	var parentTypes = this.getParentNodeTypes();
	return parentTypes === null || parentTypes.indexOf( type ) !== -1;
};

/**
 * Get suggested parent node types.
 *
 * @method
 * @abstract
 * @return {string[]|null} List of node types suggested as parents or null if any type is suggested
 */
ve.Node.prototype.getSuggestedParentNodeTypes = null;

/**
 * Check if the node can have children.
 *
 * @method
 * @abstract
 * @return {boolean} Node can have children
 */
ve.Node.prototype.canHaveChildren = null;

/**
 * Check if the node can have children but not content nor be content.
 *
 * @method
 * @abstract
 * @return {boolean} Node can have children but not content nor be content
 */
ve.Node.prototype.canHaveChildrenNotContent = null;

/**
 * Check if the node can contain content.
 *
 * @method
 * @abstract
 * @return {boolean} Node can contain content
 */
ve.Node.prototype.canContainContent = null;

/**
 * Check if the node is content.
 *
 * @method
 * @abstract
 * @return {boolean} Node is content
 */
ve.Node.prototype.isContent = null;

/**
 * Check if the node has a wrapped element in the document data.
 *
 * @method
 * @abstract
 * @return {boolean} Node represents a wrapped element
 */
ve.Node.prototype.isWrapped = null;

/**
 * Check if the node is focusable
 *
 * @method
 * @abstract
 * @return {boolean} Node is focusable
 */
ve.Node.prototype.isFocusable = null;

/**
 * Check if the node is alignable
 *
 * @method
 * @abstract
 * @return {boolean} Node is alignable
 */
ve.Node.prototype.isAlignable = null;

/**
 * Check if the node can behave as a table cell
 *
 * @method
 * @abstract
 * @return {boolean} Node can behave as a table cell
 */
ve.Node.prototype.isCellable = null;

/**
 * Check the node, behaving as a table cell, can be edited in place
 *
 * @method
 * @abstract
 * @return {boolean} Node can be edited in place
 */
ve.Node.prototype.isCellEditable = null;

/**
 * Check if the node has significant whitespace.
 *
 * Can only be true if canContainContent is also true.
 *
 * @method
 * @abstract
 * @return {boolean} Node has significant whitespace
 */
ve.Node.prototype.hasSignificantWhitespace = null;

/**
 * Check if the node handles its own children
 *
 * @method
 * @abstract
 * @return {boolean} Node handles its own children
 */
ve.Node.prototype.handlesOwnChildren = null;

/**
 * Check if the node's children should be ignored.
 *
 * @method
 * @abstract
 * @return {boolean} Node's children should be ignored
 */
ve.Node.prototype.shouldIgnoreChildren = null;

/**
 * Get the length of the node.
 *
 * @method
 * @abstract
 * @return {number} Node length
 */
ve.Node.prototype.getLength = null;

/**
 * Get the offset of the node within the document.
 *
 * If the node has no parent than the result will always be 0.
 *
 * @method
 * @abstract
 * @return {number} Offset of node
 * @throws {Error} Node not found in parent's children array
 */
ve.Node.prototype.getOffset = null;

/**
 * Get the range inside the node.
 *
 * @method
 * @param {boolean} backwards Return a backwards range
 * @return {ve.Range} Inner node range
 */
ve.Node.prototype.getRange = function ( backwards ) {
	var offset = this.getOffset() + ( this.isWrapped() ? 1 : 0 ),
		range = new ve.Range( offset, offset + this.getLength() );
	return backwards ? range.flip() : range;
};

/**
 * Get the outer range of the node, which includes wrappers if present.
 *
 * @method
 * @param {boolean} backwards Return a backwards range
 * @return {ve.Range} Node outer range
 */
ve.Node.prototype.getOuterRange = function ( backwards ) {
	var range = new ve.Range( this.getOffset(), this.getOffset() + this.getOuterLength() );
	return backwards ? range.flip() : range;
};

/**
 * Get the outer length of the node, which includes wrappers if present.
 *
 * @method
 * @return {number} Node outer length
 */
ve.Node.prototype.getOuterLength = function () {
	return this.getLength() + ( this.isWrapped() ? 2 : 0 );
};

/* Methods */

/**
 * Get the symbolic node type name.
 *
 * @method
 * @return {string} Symbolic name of element type
 */
ve.Node.prototype.getType = function () {
	return this.type;
};

/**
 * Get a reference to the node's parent.
 *
 * @method
 * @return {ve.Node} Reference to the node's parent
 */
ve.Node.prototype.getParent = function () {
	return this.parent;
};

/**
 * Get the root node of the tree the node is currently attached to.
 *
 * @method
 * @return {ve.Node} Root node
 */
ve.Node.prototype.getRoot = function () {
	return this.root;
};

/**
 * Set the root node.
 *
 * This method is overridden by nodes with children.
 *
 * @method
 * @param {ve.Node} root Node to use as root
 * @fires root
 * @fires unroot
 */
ve.Node.prototype.setRoot = function ( root ) {
	if ( root !== this.root ) {
		this.root = root;
		if ( this.getRoot() ) {
			this.emit( 'root' );
		} else {
			this.emit( 'unroot' );
		}
	}
};

/**
 * Get the document the node is a part of.
 *
 * @method
 * @return {ve.Document} Document the node is a part of
 */
ve.Node.prototype.getDocument = function () {
	return this.doc;
};

/**
 * Set the document the node is a part of.
 *
 * This method is overridden by nodes with children.
 *
 * @method
 * @param {ve.Document} doc Document this node is a part of
 */
ve.Node.prototype.setDocument = function ( doc ) {
	this.doc = doc;
};

/**
 * Attach the node to another as a child.
 *
 * @method
 * @param {ve.Node} parent Node to attach to
 * @fires attach
 */
ve.Node.prototype.attach = function ( parent ) {
	this.parent = parent;
	this.setRoot( parent.getRoot() );
	this.setDocument( parent.getDocument() );
	this.emit( 'attach', parent );
};

/**
 * Detach the node from its parent.
 *
 * @method
 * @fires detach
 */
ve.Node.prototype.detach = function () {
	var parent = this.parent;
	this.parent = null;
	this.setRoot( null );
	this.setDocument( null );
	this.emit( 'detach', parent );
};

/**
 * Traverse tree of nodes (model or view) upstream.
 *
 * For each traversed node, the callback function will be passed the traversed node as a parameter.
 *
 * @method
 * @param {Function} callback Callback method to be called for every traversed node. Returning false stops the traversal.
 * @return {ve.Node|null} Node which caused the traversal to stop, or null if it didn't
 */
ve.Node.prototype.traverseUpstream = function ( callback ) {
	var node = this;
	while ( node ) {
		if ( callback( node ) === false ) {
			return node;
		}
		node = node.getParent();
	}
	return null;
};
