/*!
 * VisualEditor ContentEditable WikiaBlockImageNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * VisualEditor ContentEditable Wikia image node.
 *
 * @class
 * @extends ve.ce.WikiaBlockMediaNode
 *
 * @constructor
 */
ve.ce.WikiaBlockImageNode = function VeCeWikiaBlockImageNode() {
};

/* Inheritance */

OO.inheritClass( ve.ce.WikiaBlockImageNode, ve.ce.WikiaBlockMediaNode );

/* Static Properties */

ve.ce.WikiaBlockImageNode.static.name = 'wikiaBlockImage';

/* Registration */

ve.ce.nodeFactory.register( ve.ce.WikiaBlockImageNode );
