/**
 * VisualEditor content editable AlienNode class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable node for an alien node.
 *
 * @class
 * @constructor
 * @extends {ve.ce.LeafNode}
 * @param {ve.dm.AlienNode} model Model to observe.
 */
ve.ce.AlienNode = function VeCeAlienNode( type, model ) {
	// Parent constructor
	ve.ce.LeafNode.call( this, type, model );

	// DOM Changes
	this.$.addClass( 've-ce-alienNode' );
	this.$.attr( 'contenteditable', false );

	// Events
	this.model.addListenerMethod( this, 'update', 'onUpdate' );

	// Initialization
	this.onUpdate();
};

/* Inheritance */

ve.inheritClass( ve.ce.AlienNode, ve.ce.LeafNode );

/* Static Members */

/**
 * Node rules.
 *
 * @see ve.ce.NodeFactory
 * @static
 * @member
 */
ve.ce.AlienNode.rules = {
	'canBeSplit': false
};

/* Methods */

ve.ce.AlienNode.prototype.onUpdate = function () {
	this.$.html( this.model.getAttribute( 'html' ) );
};

ve.ce.AlienNode.prototype.onSurfaceMouseMove = function( e ) {
	$target = $( e.target );
	if (
		!$target.hasClass( 've-ce-phantom' ) &&
		$target.closest( '.ve-ce-alienNode' ).length === 0
	) {
		var surface = this.root.getSurface();
		surface.$phantoms.empty();
		surface.$.unbind( 'mousemove.phantoms' );
	}
};

/* Registration */

ve.ce.nodeFactory.register( 'alien', ve.ce.AlienNode );
