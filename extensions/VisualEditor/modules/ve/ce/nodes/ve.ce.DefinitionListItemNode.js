/*!
 * VisualEditor ContentEditable DefinitionListItemNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable definition list item node.
 *
 * @class
 * @extends ve.ce.BranchNode
 * @constructor
 * @param {ve.dm.DefinitionListItemNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.DefinitionListItemNode = function VeCeDefinitionListItemNode( model, config ) {
	// Parent constructor
	ve.ce.BranchNode.call( this, model, config );

	// Events
	this.model.connect( this, { 'update': 'onUpdate' } );
};

/* Inheritance */

ve.inheritClass( ve.ce.DefinitionListItemNode, ve.ce.BranchNode );

/* Static Properties */

ve.ce.DefinitionListItemNode.static.name = 'definitionListItem';

/* Methods */

/**
 * Get the HTML tag name.
 *
 * Tag name is selected based on the model's style attribute.
 *
 * @returns {string} HTML tag name
 * @throws {Error} If style is invalid
 */
ve.ce.DefinitionListItemNode.prototype.getTagName = function () {
	var style = this.model.getAttribute( 'style' ),
		types = { 'definition': 'dd', 'term': 'dt' };

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
ve.ce.DefinitionListItemNode.prototype.onUpdate = function () {
	this.updateTagName();
};

/* Registration */

ve.ce.nodeFactory.register( ve.ce.DefinitionListItemNode );
