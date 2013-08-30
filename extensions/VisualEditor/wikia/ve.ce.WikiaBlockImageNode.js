/*!
 * VisualEditor ContentEditable WikiaBlockImageNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable Wikia image node.
 *
 * @class
 * @extends ve.ce.WikiaBlockMediaNode
 *
 * @constructor
 * @param {ve.dm.WikiaBlockImageNode} model Model to observe
 * @param {Object} [config] Config options
 */
ve.ce.WikiaBlockImageNode = function VeCeWikiaBlockImageNode( model, config ) {
	// Parent constructor
	ve.ce.WikiaBlockMediaNode.call( this, model, config );
};

/* Inheritance */

ve.inheritClass( ve.ce.WikiaBlockImageNode, ve.ce.WikiaBlockMediaNode );

/* Static Properties */

ve.ce.WikiaBlockImageNode.static.name = 'mwBlockImage';


/* Registration */

ve.ce.nodeFactory.register( ve.ce.WikiaBlockImageNode );