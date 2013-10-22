/*!
 * VisualEditor ContentEditable ListNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable list node.
 *
 * @class
 * @extends ve.ce.BranchNode
 * @constructor
 * @param {ve.dm.ListNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.ListNode = function VeCeListNode( model, config ) {
	// Parent constructor
	ve.ce.BranchNode.call( this, model, config );

	// Events
	this.model.connect( this, { 'update': 'onUpdate' } );
};

/* Inheritance */

ve.inheritClass( ve.ce.ListNode, ve.ce.BranchNode );

/* Static Properties */

ve.ce.ListNode.static.name = 'list';

/* Methods */

/**
 * Get the HTML tag name.
 *
 * Tag name is selected based on the model's style attribute.
 *
 * @returns {string} HTML tag name
 * @throws {Error} If style is invalid
 */
ve.ce.ListNode.prototype.getTagName = function () {
	var style = this.model.getAttribute( 'style' ),
		types = { 'bullet': 'ul', 'number': 'ol' };

	if ( !( style in types ) ) {
		throw new Error( 'Invalid style' );
	}
	return types[style];
};

/**
 * Handle model update events.
 *
 * If the style changed since last update the DOM wrapper will be replaced with an appropriate one.
 *
 * @method
 */
ve.ce.ListNode.prototype.onUpdate = function () {
	this.updateTagName();
};

/**
 * Handle splice events.
 *
 * This is used to solve a rendering bug in Firefox.
 * @see ve.ce.BranchNode#onSplice
 *
 * @method
 */
ve.ce.ListNode.prototype.onSplice = function () {
	// Parent method
	ve.ce.BranchNode.prototype.onSplice.apply( this, arguments );

	// There's a bug in Firefox where numbered lists aren't renumbered after in/outdenting
	// list items. Force renumbering by requesting the height, which causes a reflow
	this.$.css( 'height' );
};

/**
 * Check if a slug be placed after the node.
 *
 * @method
 * @returns {boolean} A slug can be placed after the node
 */
ve.ce.ListNode.prototype.canHaveSlugAfter = function () {
	if ( this.getParent().getType() === 'listItem' ) {
		// Nested lists should not have slugs after them
		return false;
	} else {
		// Parent method
		return ve.ce.BranchNode.prototype.canHaveSlugAfter.call( this );
	}
};

/* Registration */

ve.ce.nodeFactory.register( ve.ce.ListNode );
