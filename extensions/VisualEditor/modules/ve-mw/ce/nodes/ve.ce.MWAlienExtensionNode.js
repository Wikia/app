/*!
 * VisualEditor ContentEditable MWAlienExtensionNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable MediaWiki alien extension node.
 *
 * @class
 * @extends ve.ce.MWExtensionNode
 *
 * @constructor
 * @param {ve.dm.MWAlienExtensionNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.MWAlienExtensionNode = function VeCeMWAlienExtensionNode( model, config ) {
	// Parent constructor
	ve.ce.MWExtensionNode.call( this, model, config );

	// DOM changes
	this.$.addClass( 've-ce-mwAlienExtensionNode' );
};

/* Inheritance */

ve.inheritClass( ve.ce.MWAlienExtensionNode, ve.ce.MWExtensionNode );

/* Static Properties */

ve.ce.MWAlienExtensionNode.static.name = 'mwAlienExtension';

/* Registration */

ve.ce.nodeFactory.register( ve.ce.MWAlienExtensionNode );
