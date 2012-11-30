/**
 * VisualEditor Node class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Generic node.
 *
 * @class
 * @abstract
 * @constructor
 * @extends {ve.EventEmitter}
 * @param {String} type Symbolic name of node type
 */
ve.Node = function VeNode( type ) {
	// Parent constructor
	ve.EventEmitter.call( this );

	// Properties
	this.type = type;
	this.parent = null;
	this.root = this;
	this.doc = null;

	// Convenience function for emitting update events - context is bound by enclosing this scope
	// making it easy to pass through other functions as a callback
	var node = this;
	this.emitUpdate = function () {
		node.emit( 'update' );
	};
};

/* Inheritance */

ve.inheritClass( ve.Node, ve.EventEmitter );

/* Abstract Methods */

/**
 * Checks if node can have children.
 *
 * @method
 * @abstract
 * @returns {Boolean} Node can have children
 * @throws {Error} if not overridden
 */
ve.Node.prototype.canHaveChildren = function () {
	throw new Error( 've.Node.canHaveChildren must be overridden in subclass' );
};

/**
 * Checks if node can have grandchildren.
 *
 * @method
 * @abstract
 * @returns {Boolean} Node can have grandchildren
 * @throws {Error} if not overridden
 */
ve.Node.prototype.canHaveGrandchildren = function () {
	throw new Error( 've.Node.canHaveGrandchildren must be overridden in subclass' );
};

/**
 * Checks if node represents a wrapped element.
 *
 * @method
 * @abstract
 * @returns {Boolean} Node represents a wrapped element
 * @throws {Error} if not overridden
 */
ve.Node.prototype.isWrapped = function () {
	throw new Error( 've.Node.isWrapped must be overridden in subclass' );
};

/**
 * Gets node length.
 *
 * @method
 * @abstract
 * @returns {Number} Node length
 * @throws {Error} if not overridden
 */
ve.Node.prototype.getLength = function () {
	throw new Error( 've.Node.getLength must be overridden in subclass' );
};

/**
 * Gets node outer length.
 *
 * @method
 * @abstract
 * @returns {Number} Node outer length
 * @throws {Error} if not overridden
 */
ve.Node.prototype.getOuterLength = function () {
	throw new Error( 've.Node.getOuterLength must be overridden in subclass' );
};

/* Methods */

/**
 * Gets the symbolic node type name.
 *
 * @method
 * @returns {String} Symbolic name of element type
 */
ve.Node.prototype.getType = function () {
	return this.type;
};

/**
 * Gets a reference to this node's parent.
 *
 * @method
 * @returns {ve.Node} Reference to this node's parent
 */
ve.Node.prototype.getParent = function () {
	return this.parent;
};

/**
 * Gets the root node in the tree this node is currently attached to.
 *
 * @method
 * @returns {ve.Node} Root node
 */
ve.Node.prototype.getRoot = function () {
	return this.root;
};

/**
 * Sets the root node this node is a descendent of.
 *
 * This method is overridden by nodes with children.
 *
 * @method
 * @param {ve.Node} root Node to use as root
 */
ve.Node.prototype.setRoot = function ( root ) {
	this.root = root;
};

/**
 * Gets the document this node is a part of.
 *
 * @method
 * @returns {ve.Document} Document this node is a part of
 */
ve.Node.prototype.getDocument = function () {
	return this.doc;
};

/**
 * Sets the document this node is a part of.
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
 * Attaches this node to another as a child.
 *
 * @method
 * @param {ve.Node} parent Node to attach to
 * @emits attach (parent)
 */
ve.Node.prototype.attach = function ( parent ) {
	this.parent = parent;
	this.setRoot( parent.getRoot() );
	this.setDocument( parent.getDocument() );
	this.emit( 'attach', parent );
};

/**
 * Detaches this node from its parent.
 *
 * @method
 * @emits detach
 */
ve.Node.prototype.detach = function () {
	var parent = this.parent;
	this.parent = null;
	this.setRoot( this );
	this.setDocument();
	this.emit( 'detach', parent );
};

/**
 * Traverse tree of nodes (model or view) upstream and for each traversed node call callback function passing traversed node as a parameter.
 * Callback function is called for node passed as node paramter as well.
 *
 * @param {ve.Node} node Node from which to start traversing
 * @param {function} callback Callback method to be called for every traversed node
 * @method
 */
ve.Node.traverseUpstream = function ( node, callback ) {
	while ( node ) {
		if ( callback ( node ) === false ) {
			break;
		}
		node = node.getParent();
	}
};
