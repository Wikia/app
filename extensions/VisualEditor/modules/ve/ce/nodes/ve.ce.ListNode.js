/**
 * VisualEditor content editable ListNode class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable node for a list.
 *
 * @class
 * @constructor
 * @extends {ve.ce.BranchNode}
 * @param {ve.dm.ListNode} model Model to observe
 */
ve.ce.ListNode = function VeCeListNode( model ) {
	// Parent constructor
	ve.ce.BranchNode.call( this, 'list', model, ve.ce.BranchNode.getDomWrapper( model, 'style' ) );

	// Events
	this.model.addListenerMethod( this, 'update', 'onUpdate' );
};

/* Inheritance */

ve.inheritClass( ve.ce.ListNode, ve.ce.BranchNode );

/* Static Members */

/**
 * Node rules.
 *
 * @see ve.ce.NodeFactory
 * @static
 * @member
 */
ve.ce.ListNode.rules = {
	'canBeSplit': false
};

/**
 * Mapping of list style values and DOM wrapper element types.
 *
 * @static
 * @member
 */
ve.ce.ListNode.domWrapperElementTypes = {
	'bullet': 'ul',
	'number': 'ol'
};

/* Methods */

/**
 * Responds to model update events.
 *
 * If the style changed since last update the DOM wrapper will be replaced with an appropriate one.
 *
 * @method
 */
ve.ce.ListNode.prototype.onUpdate = function () {
	this.updateDomWrapper( 'style' );
};

/**
 * Supplement onSplice() to work around a rendering bug in Firefox
 */
ve.ce.ListNode.prototype.onSplice = function () {
	// Call ve.ce.BranchNode's implementation
	var args = Array.prototype.slice.call( arguments, 0 );
	ve.ce.BranchNode.prototype.onSplice.apply( this, args );

	// There's a bug in Firefox where numbered lists aren't renumbered after in/outdenting
	// list items. Force renumbering by requesting the height, which causes a reflow
	this.$.css( 'height' );
};

ve.ce.ListNode.prototype.canHaveSlugAfter = function () {
	if ( this.getParent().getType() === 'listItem' ) {
		// Nested lists should not have slugs after them
		return false;
	} else {
		// Call the parent's implementation
		return ve.ce.BranchNode.prototype.canHaveSlugAfter.call( this );
	}
};

/* Registration */

ve.ce.nodeFactory.register( 'list', ve.ce.ListNode );
