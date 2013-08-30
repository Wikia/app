/*!
 * VisualEditor ContentEditable WikiaMediaCaptionNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable Wikia media caption item node.
 *
 * @class
 * @extends ve.ce.BranchNode
 * @constructor
 * @param {ve.dm.WikiaMediaCaptionNode} model Model to observe
 * @param {Object} [config] Config options
 */
ve.ce.WikiaMediaCaptionNode = function VeCeWikiaMediaCaptionNode( model, config ) {
	// Parent constructor
	ve.ce.BranchNode.call( this, model, config );

	// DOM changes
	this.$.addClass( 'thumbcaption' );
};

/* Inheritance */

ve.inheritClass( ve.ce.WikiaMediaCaptionNode, ve.ce.BranchNode );

/* Static Properties */

ve.ce.WikiaMediaCaptionNode.static.name = 'mwImageCaption';

ve.ce.WikiaMediaCaptionNode.static.tagName = 'figcaption';

/* Methods */

ve.ce.MWImageCaptionNode.prototype.onSplice = function () {
	// TODO: clear out attribution here

	// Parent method
	ve.ce.BranchNode.prototype.onSplice.apply( this, arguments );

	// TODO: add attribution here
};

/* Registration */

ve.ce.nodeFactory.register( ve.ce.WikiaMediaCaptionNode );
