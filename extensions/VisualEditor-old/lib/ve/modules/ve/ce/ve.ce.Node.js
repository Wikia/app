/*!
 * VisualEditor ContentEditable Node class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Generic ContentEditable node.
 *
 * @abstract
 * @extends ve.ce.View
 * @mixins ve.Node
 *
 * @constructor
 * @param {ve.dm.Node} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.Node = function VeCeNode( model, config ) {
	// Parent constructor
	ve.ce.View.call( this, model, config );

	// Mixin constructor
	ve.Node.call( this );

	// Properties
	this.parent = null;
};

/* Inheritance */

OO.inheritClass( ve.ce.Node, ve.ce.View );

OO.mixinClass( ve.ce.Node, ve.Node );

/* Static Members */

/**
 * Whether Enter splits this node type.
 *
 * When the user presses Enter, we split the node they're in (if splittable), then split its parent
 * if splittable, and continue traversing up the tree and stop at the first non-splittable node.
 *
 * @static
 * @property
 * @inheritable
 */
ve.ce.Node.static.splitOnEnter = false;

/**
 * Whether this node type can be focused.
 *
 * If this is set to true on a node, it should implement:
 *
 *     setFocused( boolean val )
 *     boolean isFocused()
 *
 * @static
 * @property
 * @inheritable
 */
ve.ce.Node.static.isFocusable = false;

/**
 * Command to execute when Enter is pressed while this node is selected, or when the node is double-clicked.
 *
 * @static
 * @property {string|null}
 * @inheritable
 */
ve.ce.Node.static.primaryCommandName = null;

/**
 * Whether this node handles its own rendering
 *
 * If false, ve.ce.Branchnode onSplice method will append this node's child elements to its element.
 * If true, this node must handle rendering its children.
 *
 * @static
 * @property {boolean}
 * @inheritable
 */
 ve.ce.Node.static.handlesOwnRendering = false;

/* Static Methods */

/**
 * Get a plain text description.
 *
 * @static
 * @inheritable
 * @param {ve.dm.Node} node Node model
 * @returns {string} Description of node
 */
ve.ce.Node.static.getDescription = function () {
	return '';
};

/* Methods */

/**
 * Get allowed child node types.
 *
 * This method passes through to the model.
 *
 * @returns {string[]|null} List of node types allowed as children or null if any type is allowed
 */
ve.ce.Node.prototype.getChildNodeTypes = function () {
	return this.model.getChildNodeTypes();
};

/**
 * Get allowed parent node types.
 *
 * This method passes through to the model.
 *
 * @returns {string[]|null} List of node types allowed as parents or null if any type is allowed
 */
ve.ce.Node.prototype.getParentNodeTypes = function () {
	return this.model.getParentNodeTypes();
};

/**
 * Check if the node can have children.
 *
 * This method passes through to the model.
 *
 * @returns {boolean} Model node can have children
 */
ve.ce.Node.prototype.canHaveChildren = function () {
	return this.model.canHaveChildren();
};

/**
 * Check if the node can have children but not content nor be content.
 *
 * This method passes through to the model.
 *
 * @returns {boolean} Model node can have children but not content nor be content
 */
ve.ce.Node.prototype.canHaveChildrenNotContent = function () {
	return this.model.canHaveChildrenNotContent();
};

/**
 * Check if the node has a wrapped element in the document data.
 *
 * This method passes through to the model.
 *
 * @returns {boolean} Model node is a wrapped element
 */
ve.ce.Node.prototype.isWrapped = function () {
	return this.model.isWrapped();
};

/**
 * Check if the node can contain content.
 *
 * This method passes through to the model.
 *
 * @returns {boolean} Node can contain content
 */
ve.ce.Node.prototype.canContainContent = function () {
	return this.model.canContainContent();
};

/**
 * Check if the node is content.
 *
 * This method passes through to the model.
 *
 * @returns {boolean} Node is content
 */
ve.ce.Node.prototype.isContent = function () {
	return this.model.isContent();
};

/**
 * Check if the node handles its own children
 *
 * This method passes through to the model.
 *
 * @returns {boolean} Node handles its own children
 */
ve.ce.Node.prototype.handlesOwnChildren = function () {
	return this.model.handlesOwnChildren();
};

/**
 * Check if the node is focusable
 *
 * @see #static-isFocusable
 * @returns {boolean} Node is focusable
 */
ve.ce.Node.prototype.isFocusable = function () {
	return this.constructor.static.isFocusable;
};

/**
 * Check if the node renders its own children
 *
 * @returns {boolean} Node renders its own children
 */
ve.ce.Node.prototype.handlesOwnRendering = function () {
	return this.constructor.static.handlesOwnRendering;
};

/**
 * Check if the node can have a slug before it.
 *
 * TODO: Figure out a way to remove the hard-coding for text nodes here.
 *
 * @method
 * @returns {boolean} Whether the node can have a slug before it
 */
ve.ce.Node.prototype.canHaveSlugBefore = function () {
	return !this.canContainContent() &&
		this.getParentNodeTypes() === null &&
		this.type !== 'text' &&
		this.type !== 'list';
};

/**
 * Check if the node can have a slug after it.
 *
 * @method
 * @returns {boolean} Whether the node can have a slug after it
 */
ve.ce.Node.prototype.canHaveSlugAfter = ve.ce.Node.prototype.canHaveSlugBefore;

/**
 * Get the length of the node.
 *
 * This method passes through to the model.
 *
 * @returns {number} Model length
 */
ve.ce.Node.prototype.getLength = function () {
	return this.model.getLength();
};

/**
 * Get the outer length of the node, which includes wrappers if present.
 *
 * This method passes through to the model.
 *
 * @returns {number} Model outer length
 */
ve.ce.Node.prototype.getOuterLength = function () {
	return this.model.getOuterLength();
};

/**
 * Get the offset of the node.
 *
 * @see ve.dm.Node#getOffset
 * @returns {number} Offset
 */
ve.ce.Node.prototype.getOffset = function () {
	return this.model.getOffset();
};

/**
 * Check if the node can be split.
 *
 * @returns {boolean} Node can be split
 */
ve.ce.Node.prototype.splitOnEnter = function () {
	return this.constructor.static.splitOnEnter;
};

/**
 * Release all memory.
 */
ve.ce.Node.prototype.destroy = function () {
	this.parent = null;
	this.model.disconnect( this );
};

/** */
ve.ce.Node.prototype.getModelHtmlDocument = function () {
	return this.model.getDocument() && this.model.getDocument().getHtmlDocument();
};
