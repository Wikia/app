/*!
 * VisualEditor ContentEditable HeadingNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable heading node.
 *
 * @class
 * @extends ve.ce.BranchNode
 * @constructor
 * @param {ve.dm.HeadingNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.HeadingNode = function VeCeHeadingNode( model, config ) {
	// Parent constructor
	ve.ce.ContentBranchNode.call( this, model, config );

	// Events
	this.model.connect( this, { 'update': 'onUpdate' } );
};

/* Inheritance */

ve.inheritClass( ve.ce.HeadingNode, ve.ce.ContentBranchNode );

/* Static Properties */

ve.ce.HeadingNode.static.name = 'heading';

/* Static Properties */

ve.ce.HeadingNode.static.canBeSplit = true;

/* Methods */

/**
 * Get the HTML tag name.
 *
 * Tag name is selected based on the model's level attribute.
 *
 * @returns {string} HTML tag name
 * @throws {Error} If level is invalid
 */
ve.ce.HeadingNode.prototype.getTagName = function () {
	var level = this.model.getAttribute( 'level' ),
		types = { '1': 'h1', '2': 'h2', '3': 'h3', '4': 'h4', '5': 'h5', '6': 'h6' };

	if ( !( level in types ) ) {
		throw new Error( 'Invalid level' );
	}
	return types[level];
};

/**
 * Handle model update events.
 *
 * If the level changed since last update the DOM wrapper will be replaced with an appropriate one.
 *
 * @method
 */
ve.ce.HeadingNode.prototype.onUpdate = function () {
	this.updateTagName();
};

/* Registration */

ve.ce.nodeFactory.register( ve.ce.HeadingNode );
