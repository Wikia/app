/*!
 * VisualEditor ContentEditable WikiaImageCaptionNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * VisualEditor ContentEditable Wikia media caption item node.
 *
 * @class
 * @extends ve.ce.WikiaMediaCaptionNode
 * @constructor
 * @param {ve.dm.WikiaMediaCaptionNode} model Model to observe
 * @param {Object} [config] Config options
 */
ve.ce.WikiaImageCaptionNode = function VeCeWikiaImageCaptionNode( model, config ) {
	// Parent constructor
	ve.ce.WikiaImageCaptionNode.super.call( this, model, config );
};

/* Inheritance */

OO.inheritClass( ve.ce.WikiaImageCaptionNode, ve.ce.WikiaMediaCaptionNode );

/* Static Properties */

ve.ce.WikiaImageCaptionNode.static.name = 'wikiaImageCaption';

/* Registration */

ve.ce.nodeFactory.register( ve.ce.WikiaImageCaptionNode );
