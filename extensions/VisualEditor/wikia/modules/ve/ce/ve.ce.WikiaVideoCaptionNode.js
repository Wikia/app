/*!
 * VisualEditor ContentEditable WikiaVideoCaptionNode class.
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
ve.ce.WikiaVideoCaptionNode = function VeCeWikiaVideoCaptionNode( model, config ) {
	// Parent constructor
	ve.ce.WikiaMediaCaptionNode.call( this, model, config );

	this.$title = null;
};

/* Inheritance */

OO.inheritClass( ve.ce.WikiaVideoCaptionNode, ve.ce.WikiaMediaCaptionNode );

/* Static Properties */

ve.ce.WikiaVideoCaptionNode.static.name = 'wikiaVideoCaption';

/* Methods */

/**
 * Builds the title element.
 *
 * @method
 * @returns {jQuery} The properly scoped jQuery object
 */
ve.ce.WikiaVideoCaptionNode.prototype.createTitle = function () {
	var attribution = this.model.parent.getAttribute( 'attribution' );

	// It's inside a protected node, so user can't see href/title.
	return this.$( '<p>' )
		.addClass( 'title ve-no-shield' )
		.text( attribution.titleText );
};

/**
 * Handle splices
 *
 * @method
 */
ve.ce.WikiaVideoCaptionNode.prototype.onSplice = function () {
	// Parent method
	ve.ce.WikiaMediaCaptionNode.prototype.onSplice.apply( this, arguments );

	this.$title = this.createTitle();
	this.$title.insertAfter( this.$details );
};

/* Registration */

ve.ce.nodeFactory.register( ve.ce.WikiaVideoCaptionNode );
