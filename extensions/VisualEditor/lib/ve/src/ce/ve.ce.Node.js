/*!
 * VisualEditor ContentEditable Node class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
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
 * Command to execute when Enter is pressed while this node is selected, or when the node is double-clicked.
 *
 * @static
 * @property {string|null}
 * @inheritable
 */
ve.ce.Node.static.primaryCommandName = null;

/* Static Methods */

/**
 * Get a plain text description.
 *
 * @static
 * @inheritable
 * @param {ve.dm.Node} node Node model
 * @return {string} Description of node
 */
ve.ce.Node.static.getDescription = function () {
	return '';
};

/* Methods */

/**
 * @inheritdoc ve.Node
 */
ve.ce.Node.prototype.getChildNodeTypes = function () {
	return this.model.getChildNodeTypes();
};

/**
 * @inheritdoc ve.Node
 */
ve.ce.Node.prototype.getParentNodeTypes = function () {
	return this.model.getParentNodeTypes();
};

/**
 * @inheritdoc ve.Node
 */
ve.ce.Node.prototype.getSuggestedParentNodeTypes = function () {
	return this.model.getSuggestedParentNodeTypes();
};

/**
 * @inheritdoc ve.Node
 */
ve.ce.Node.prototype.canHaveChildren = function () {
	return this.model.canHaveChildren();
};

/**
 * @inheritdoc ve.Node
 */
ve.ce.Node.prototype.canHaveChildrenNotContent = function () {
	return this.model.canHaveChildrenNotContent();
};

/**
 * @inheritdoc ve.Node
 */
ve.ce.Node.prototype.isWrapped = function () {
	return this.model.isWrapped();
};

/**
 * @inheritdoc ve.Node
 */
ve.ce.Node.prototype.canContainContent = function () {
	return this.model.canContainContent();
};

/**
 * @inheritdoc ve.Node
 */
ve.ce.Node.prototype.isContent = function () {
	return this.model.isContent();
};

/**
 * @inheritdoc ve.Node
 *
 * If this is set to true it should implement:
 *
 *     setFocused( boolean val )
 *     boolean isFocused()
 */
ve.ce.Node.prototype.isFocusable = function () {
	return this.model.isFocusable();
};

/**
 * @inheritdoc ve.Node
 */
ve.ce.Node.prototype.isAlignable = function () {
	return this.model.isAlignable();
};

/**
 * @inheritdoc ve.Node
 */
ve.ce.Node.prototype.isCellable = function () {
	return this.model.isCellable();
};

/**
 * @inheritdoc ve.Node
 */
ve.ce.Node.prototype.isCellEditable = function () {
	return this.model.isCellEditable();
};

/**
 * @inheritdoc ve.Node
 */
ve.ce.Node.prototype.hasSignificantWhitespace = function () {
	return this.model.hasSignificantWhitespace();
};

/**
 * @inheritdoc ve.Node
 */
ve.ce.Node.prototype.handlesOwnChildren = function () {
	return this.model.handlesOwnChildren();
};

/**
 * @inheritdoc ve.Node
 */
ve.ce.Node.prototype.shouldIgnoreChildren = function () {
	return this.model.shouldIgnoreChildren();
};

/**
 * @inheritdoc ve.Node
 */
ve.ce.Node.prototype.getLength = function () {
	return this.model.getLength();
};

/**
 * @inheritdoc ve.Node
 */
ve.ce.Node.prototype.getOuterLength = function () {
	return this.model.getOuterLength();
};

/**
 * @inheritdoc ve.Node
 */
ve.ce.Node.prototype.getOffset = function () {
	return this.model.getOffset();
};

/**
 * Check if the node can be split.
 *
 * @return {boolean} Node can be split
 */
ve.ce.Node.prototype.splitOnEnter = function () {
	return this.constructor.static.splitOnEnter;
};

/**
 * Release all memory.
 */
ve.ce.Node.prototype.destroy = function () {
	this.parent = null;
	this.root = null;
	this.doc = null;

	// Parent method
	ve.ce.View.prototype.destroy.call( this );
};

/** */
ve.ce.Node.prototype.getModelHtmlDocument = function () {
	return this.model.getDocument() && this.model.getDocument().getHtmlDocument();
};
