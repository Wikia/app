/*!
 * VisualEditor ContentEditable DefinitionListItemNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
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
ve.ce.DefinitionListItemNode = function VeCeDefinitionListItemNode() {
	// Parent constructor
	ve.ce.DefinitionListItemNode.super.apply( this, arguments );

	// Events
	this.model.connect( this, { update: 'onUpdate' } );
};

/* Inheritance */

OO.inheritClass( ve.ce.DefinitionListItemNode, ve.ce.BranchNode );

/* Static Properties */

ve.ce.DefinitionListItemNode.static.name = 'definitionListItem';

ve.ce.DefinitionListItemNode.static.splitOnEnter = true;

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
		types = { definition: 'dd', term: 'dt' };

	if ( !Object.prototype.hasOwnProperty.call( types, style ) ) {
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
