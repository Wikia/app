/*!
 * VisualEditor ContentEditable MWGalleryNode class.
 *
 * @copyright 2011–2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable MediaWiki gallery node.
 *
 * @class
 * @extends ve.ce.MWExtensionNode
 *
 * @constructor
 * @param {ve.dm.MWGalleryNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.MWGalleryNode = function VeCeMWGalleryNode( model, config ) {
	// Parent constructor
	ve.ce.MWExtensionNode.call( this, model, config );
};

/* Inheritance */

OO.inheritClass( ve.ce.MWGalleryNode, ve.ce.MWExtensionNode );

/* Static Properties */

ve.ce.MWGalleryNode.static.name = 'mwGallery';

ve.ce.MWGalleryNode.static.tagName = 'div';

ve.ce.MWGalleryNode.static.primaryCommandName = 'gallery';

/* Registration */

ve.ce.nodeFactory.register( ve.ce.MWGalleryNode );
