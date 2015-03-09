/*!
 * VisualEditor Node class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
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
 * @returns {string[]|null} List of node types allowed as children or null if any type is allowed
 */
ve.Node.prototype.getChildNodeTypes = function () {
	throw new Error( 've.Node.getChildNodeTypes must be overridden in subclass' );
};

/**
 * Get allowed parent node types.
 *
 * @method
 * @abstract
 * @returns {string[]|null} List of node types allowed as parents or null if any type is allowed
 */
ve.Node.prototype.getParentNodeTypes = function () {
	throw new Error( 've.Node.getParentNodeTypes must be overridden in subclass' );
};

/**
 * Check if the specified type is an allowed child node type
 *
 * @param {string} type Node type
 * @return {boolean} The type is allowed
 */
ve.Node.prototype.isAllowedChildNodeType = function ( type ) {
	var childTypes = this.getChildNodeTypes();
	return childTypes === null || ve.indexOf( type, childTypes ) !== -1;
};

/**
 * Check if the specified type is an allowed child node type
 *
 * @param {string} type Node type
 * @return {boolean} The type is allowed
 */
ve.Node.prototype.isAllowedParentNodeType = function ( type ) {
	var parentTypes = this.getParentNodeTypes();
	return parentTypes === null || ve.indexOf( type, parentTypes ) !== -1;
};

/**
 * Get suggested parent node types.
 *
 * @method
 * @abstract
 * @returns {string[]|null} List of node types suggested as parents or null if any type is suggested
 */
ve.Node.prototype.getSuggestedParentNodeTypes = function () {
	throw new Error( 've.Node.getSuggestedParentNodeTypes must be overridden in subclass' );
};

/**
 * Check if the node can have children.
 *
 * @method
 * @abstract
 * @returns {boolean} Node can have children
 */
ve.Node.prototype.canHaveChildren = function () {
	throw new Error( 've.Node.canHaveChildren must be overridden in subclass' );
};

/**
 * Check if the node can have children but not content nor be content.
 *
 * @method
 * @abstract
 * @returns {boolean} Node can have children but not content nor be content
 */
ve.Node.prototype.canHaveChildrenNotContent = function () {
	throw new Error( 've.Node.canHaveChildrenNotContent must be overridden in subclass' );
};

/**
 * Check if the node can contain content.
 *
 * @method
 * @abstract
 * @returns {boolean} Node can contain content
 */
ve.Node.prototype.canContainContent = function () {
	throw new Error( 've.Node.canContainContent must be overridden in subclass' );
};

/**
 * Check if the node is content.
 *
 * @method
 * @abstract
 * @returns {boolean} Node is content
 */
ve.Node.prototype.isContent = function () {
	throw new Error( 've.Node.isContent must be overridden in subclass' );
};

/**
 * Check if the node has a wrapped element in the document data.
 *
 * @method
 * @abstract
 * @returns {boolean} Node represents a wrapped element
 */
ve.Node.prototype.isWrapped = function () {
	throw new Error( 've.Node.isWrapped must be overridden in subclass' );
};

/**
 * Check if the node is focusable
 *
 * @method
 * @abstract
 * @returns {boolean} Node is focusable
 */
ve.Node.prototype.isFocusable = function () {
	throw new Error( 've.Node.isFocusable must be overridden in subclass' );
};

/**
 * Check if the node has significant whitespace.
 *
 * Can only be true if canContainContent is also true.
 *
 * @method
 * @abstract
 * @returns {boolean} Node has significant whitespace
 */
ve.Node.prototype.hasSignificantWhitespace = function () {
	throw new Error( 've.Node.hasSignificantWhitespace must be overridden in subclass' );
};

/**
 * Check if the node handles its own children
 *
 * @method
 * @abstract
 * @returns {boolean} Node handles its own children
 */
ve.Node.prototype.handlesOwnChildren = function () {
	throw new Error( 've.Node.handlesOwnChildren must be overridden in subclass' );
};

/**
 * Get the length of the node.
 *
 * @method
 * @abstract
 * @returns {number} Node length
 */
ve.Node.prototype.getLength = function () {
	throw new Error( 've.Node.getLength must be overridden in subclass' );
};

/**
 * Get the offset of the node within the document.
 *
 * If the node has no parent than the result will always be 0.
 *
 * @method
 * @abstract
 * @returns {number} Offset of node
 * @throws {Error} Node not found in parent's children array
 */
ve.Node.prototype.getOffset = function () {
	throw new Error( 've.Node.getOffset must be overridden in subclass' );
};

/**
 * Get the range inside the node.
 *
 * @method
 * @param {boolean} backwards Return a backwards range
 * @returns {ve.Range} Inner node range
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
 * @returns {ve.Range} Node outer range
 */
ve.Node.prototype.getOuterRange = function ( backwards ) {
	var range = new ve.Range( this.getOffset(), this.getOffset() + this.getOuterLength() );
	return backwards ? range.flip() : range;
};

/**
 * Get the outer length of the node, which includes wrappers if present.
 *
 * @method
 * @returns {number} Node outer length
 */
ve.Node.prototype.getOuterLength = function () {
	return this.getLength() + ( this.isWrapped() ? 2 : 0 );
};

/* Methods */

/**
 * Get the symbolic node type name.
 *
 * @method
 * @returns {string} Symbolic name of element type
 */
ve.Node.prototype.getType = function () {
	return this.type;
};

/**
 * Get a reference to the node's parent.
 *
 * @method
 * @returns {ve.Node} Reference to the node's parent
 */
ve.Node.prototype.getParent = function () {
	return this.parent;
};

/**
 * Get the root node of the tree the node is currently attached to.
 *
 * @method
 * @returns {ve.Node} Root node
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
 * @returns {ve.Document} Document the node is a part of
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
 */
ve.Node.prototype.traverseUpstream = function ( callback ) {
	var node = this;
	while ( node ) {
		if ( callback( node ) === false ) {
			break;
		}
		node = node.getParent();
	}
};
