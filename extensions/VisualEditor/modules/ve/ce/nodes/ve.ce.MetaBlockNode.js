/**
 * VisualEditor content editable MetaBlockNode class.
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
 * @param model {ve.dm.MetaBlockNode} Model to observe
 */
ve.ce.MetaBlockNode = function VeCeMetaBlockNode( model ) {
	// Parent constructor
	ve.ce.BranchNode.call( this, 'metaBlock', model );

	// DOM Changes
	this.$.addClass( 've-ce-metaBlockNode' );
	this.$.attr( 'contenteditable', false );

	// Properties
	this.currentKey = null; // Populated by the first onUpdate() call
	this.currentValue = null; // Populated by the first onUpdate() call

	// Events
	this.model.addListenerMethod( this, 'update', 'onUpdate' );

	// Intialization
	this.onUpdate();
};

/* Inheritance */

ve.inheritClass( ve.ce.MetaBlockNode, ve.ce.BranchNode );

/* Static Members */

/**
 * Node rules.
 *
 * @see ve.ce.NodeFactory
 * @static
 * @member
 */
ve.ce.MetaBlockNode.rules = {
	'canBeSplit': false
};

/* Methods */

/**
 * Responds to model update events.
 *
 * @method
 */
ve.ce.MetaBlockNode.prototype.onUpdate = function () {
	var key = this.model.getAttribute( 'key' ),
		value = this.model.getAttribute( 'value' );
	if ( key !== this.currentKey || value !== this.currentValue ) {
		this.currentKey = key;
		this.currentValue = value;
		if ( key !== null && value !== undefined ) {
			this.$.text( key + '=' + value );
		} else if ( key !== null ) {
			this.$.text( key );
		} else {
			// Most likely <meta typeof="mw:Placeholder"> , we don't know what this is
			this.$.text( 'META' );
		}
	}
};

/* Registration */

ve.ce.nodeFactory.register( 'metaBlock', ve.ce.MetaBlockNode );
