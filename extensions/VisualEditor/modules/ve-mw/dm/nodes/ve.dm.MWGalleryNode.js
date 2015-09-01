/*!
 * VisualEditor DataModel MWGalleryNode class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel MediaWiki gallery node.
 *
 * @class
 * @extends ve.dm.MWBlockExtensionNode
 *
 * @constructor
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.MWGalleryNode = function VeDmMWGalleryNode() {
	// Parent constructor
	ve.dm.MWBlockExtensionNode.apply( this, arguments );
};

/* Inheritance */

OO.inheritClass( ve.dm.MWGalleryNode, ve.dm.MWBlockExtensionNode );

/* Static members */

ve.dm.MWGalleryNode.static.name = 'mwGallery';

ve.dm.MWGalleryNode.static.extensionName = 'gallery';

ve.dm.MWGalleryNode.static.tagName = 'ul';

/* Registration */

ve.dm.modelRegistry.register( ve.dm.MWGalleryNode );
