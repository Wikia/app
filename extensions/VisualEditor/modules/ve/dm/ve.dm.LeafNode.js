/**
 * Creates an ve.dm.LeafNode object.
 * 
 * @class
 * @abstract
 * @constructor
 * @extends {ve.LeafNode}
 * @extends {ve.dm.Node}
 * @param {String} type Symbolic name of node type
 * @param {Object} element Element object in document data
 * @param {Integer} [length] Length of content data in document
 */
ve.dm.LeafNode = function( type, element, length ) {
	// Inheritance
	ve.LeafNode.call( this );
	ve.dm.Node.call( this, type, element, length );

	// Properties
	this.contentLength = length || 0;
};

/* Methods */

/**
 * Gets a plain object representation of the document's data.
 * 
 * @method
 * @see {ve.dm.Node.getPlainObject}
 * @see {ve.dm.DocumentNode.newFromPlainObject}
 * @returns {Object} Plain object representation, 
 */
ve.dm.LeafNode.prototype.getPlainObject = function() {
	var obj = { 'type': this.type };
	if ( this.element && this.element.attributes ) {
		obj.attributes = ve.copyObject( this.element.attributes );
	}
	obj.content = ve.dm.DocumentNode.getExpandedContentData( this.getContentData() );
	return obj;
};

/* Inheritance */

ve.extendClass( ve.dm.LeafNode, ve.LeafNode );
ve.extendClass( ve.dm.LeafNode, ve.dm.Node );
