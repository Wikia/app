/*!
 * VisualEditor Node class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Generic node.
 *
 * @abstract
 * @mixins ve.EventEmitter
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
 * Check if the node can have children.
 *
 * @method
 * @abstract
 * @returns {boolean} Node can have children
 * @throws {Error} if not overridden
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
 * @throws {Error} if not overridden
 */
ve.Node.prototype.canHaveChildrenNotContent = function () {
	throw new Error( 've.Node.canHaveChildrenNotContent must be overridden in subclass' );
};

/**
 * Check if the node has a wrapped element in the document data.
 *
 * @method
 * @abstract
 * @returns {boolean} Node represents a wrapped element
 * @throws {Error} if not overridden
 */
ve.Node.prototype.isWrapped = function () {
	throw new Error( 've.Node.isWrapped must be overridden in subclass' );
};

/**
 * Get the length of the node.
 *
 * @method
 * @abstract
 * @returns {number} Node length
 * @throws {Error} if not overridden
 */
ve.Node.prototype.getLength = function () {
	throw new Error( 've.Node.getLength must be overridden in subclass' );
};

/**
 * Get the outer length of the node, which includes wrappers if present.
 *
 * @method
 * @abstract
 * @returns {number} Node outer length
 * @throws {Error} if not overridden
 */
ve.Node.prototype.getOuterLength = function () {
	throw new Error( 've.Node.getOuterLength must be overridden in subclass' );
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
	if ( backwards ) {
		return range.flip();
	} else {
		return range;
	}
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
 * @emits root
 * @emits unroot
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
 * @emits attach
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
 * @emits detach
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
 * @param {Function} callback Callback method to be called for every traversed node
 * @method
 */
ve.Node.prototype.traverseUpstream = function ( callback ) {
	var node = this;
	while ( node ) {
		if ( callback ( node ) === false ) {
			break;
		}
		node = node.getParent();
	}
};
