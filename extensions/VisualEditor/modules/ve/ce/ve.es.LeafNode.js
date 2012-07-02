/**
 * Creates an ve.es.LeafNode object.
 * 
 * @class
 * @abstract
 * @constructor
 * @extends {ve.LeafNode}
 * @extends {ve.es.Node}
 * @param model {ve.ModelNode} Model to observe
 * @param {jQuery} [$element] Element to use as a container
 */
ve.es.LeafNode = function( model, $element ) {
	// Inheritance
	ve.LeafNode.call( this );
	ve.es.Node.call( this, model, $element );

	this.$.data('view', this);
	this.$.addClass('ce-leafNode');

	// Properties
	this.contentView = new ve.es.Content( this.$, model );

	// Events
	this.contentView.on( 'update', this.emitUpdate );
};

/* Methods */

/**
 * Render content.
 * 
 * @method
 */
ve.es.LeafNode.prototype.renderContent = function() {
	this.contentView.render();
};

/* Inheritance */

ve.extendClass( ve.es.LeafNode, ve.LeafNode );
ve.extendClass( ve.es.LeafNode, ve.es.Node );
