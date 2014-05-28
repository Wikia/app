/*!
 * VisualEditor DataModel MWGalleryNode class.
 *
 * @copyright 2011–2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel MediaWiki gallery node.
 *
 * @class
 * @extends ve.dm.MWExtensionNode
 *
 * @constructor
 */
ve.dm.MWGalleryNode = function VeDmMWGalleryNode( length, element ) {
	// Parent constructor
	ve.dm.MWExtensionNode.call( this, 0, element );
};

/* Inheritance */

OO.inheritClass( ve.dm.MWGalleryNode, ve.dm.MWExtensionNode );

/* Static members */

ve.dm.MWGalleryNode.static.name = 'mwGallery';

ve.dm.MWGalleryNode.static.extensionName = 'gallery';

ve.dm.MWGalleryNode.static.tagName = 'ul';

/* Registration */

ve.dm.modelRegistry.register( ve.dm.MWGalleryNode );
