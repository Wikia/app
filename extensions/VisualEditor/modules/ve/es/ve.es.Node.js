/**
 * Creates an ve.es.Node object.
 * 
 * @class
 * @abstract
 * @constructor
 * @extends {ve.Node}
 * @param {ve.dm.Node} model Model to observe
 * @param {jQuery} [$element=$( '<div></div>' )] Element to use as a container
 */
ve.es.Node = function( model, $element ) {
	// Inheritance
	ve.Node.call( this );
	
	// Properties
	this.model = model;
	this.parent = null;
	this.$ = $element || $( '<div/>' );
};

/* Methods */

/**
 * Gets the length of the element in the model.
 * 
 * @method
 * @see {ve.Node.prototype.getElementLength}
 * @returns {Integer} Length of content
 */
ve.es.Node.prototype.getElementLength = function() {
	return this.model.getElementLength();
};

/**
 * Gets the length of the content in the model.
 * 
 * @method
 * @see {ve.Node.prototype.getContentLength}
 * @returns {Integer} Length of content
 */
ve.es.Node.prototype.getContentLength = function() {
	return this.model.getContentLength();
};

/**
 * Attaches node as a child to another node.
 * 
 * @method
 * @param {ve.es.Node} parent Node to attach to
 * @emits attach (parent)
 */
ve.es.Node.prototype.attach = function( parent ) {
	this.parent = parent;
	this.emit( 'attach', parent );
};

/**
 * Detaches node from it's parent.
 * 
 * @method
 * @emits detach (parent)
 */
ve.es.Node.prototype.detach = function() {
	var parent = this.parent;
	this.parent = null;
	this.emit( 'detach', parent );
};

/**
 * Gets a reference to this node's parent.
 * 
 * @method
 * @returns {ve.es.Node} Reference to this node's parent
 */
ve.es.Node.prototype.getParent = function() {
	return this.parent;
};

/**
 * Gets a reference to the model this node observes.
 * 
 * @method
 * @returns {ve.dm.Node} Reference to the model this node observes
 */
ve.es.Node.prototype.getModel = function() {
	return this.model;
};

ve.es.Node.getSplitableNode = function( node ) {
	var splitableNode = null;

	ve.Node.traverseUpstream( node, function( node ) {
		var elementType = node.model.getElementType();
		if ( splitableNode != null && ve.es.DocumentNode.splitRules[ elementType ].children === true ) {
			return false;
		}
		splitableNode = ve.es.DocumentNode.splitRules[ elementType ].self ? node : null
	} );
	return splitableNode;
};

/* Inheritance */

ve.extendClass( ve.es.Node, ve.Node );
