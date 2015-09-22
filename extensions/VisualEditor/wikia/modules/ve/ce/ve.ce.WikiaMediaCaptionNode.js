/*!
 * VisualEditor ContentEditable WikiaMediaCaptionNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * VisualEditor ContentEditable Wikia media caption item node.
 *
 * @class
 * @extends ve.ce.BranchNode
 * @constructor
 * @param {ve.dm.WikiaMediaCaptionNode} model Model to observe
 * @param {Object} [config] Config options
 */
ve.ce.WikiaMediaCaptionNode = function VeCeWikiaMediaCaptionNode( model, config ) {

	// Parent constructor
	ve.ce.WikiaMediaCaptionNode.super.call( this, model, config );
};

/* Inheritance */

OO.inheritClass( ve.ce.WikiaMediaCaptionNode, ve.ce.BranchNode );

/* Static Properties */

ve.ce.WikiaMediaCaptionNode.static.name = 'wikiaMediaCaption';

ve.ce.WikiaMediaCaptionNode.static.tagName = 'figcaption';

/* Methods */

/**
 * Handle splices
 *
 * @method
 */
ve.ce.WikiaMediaCaptionNode.prototype.onSplice = function () {
	// Parent method
	ve.ce.BranchNode.prototype.onSplice.apply( this, arguments );

	// add class to caption itself
	if ( this.children.length ) {
		this.children[0].$element.addClass( 'caption' );
	}
};

/* Registration */

ve.ce.nodeFactory.register( ve.ce.WikiaMediaCaptionNode );
