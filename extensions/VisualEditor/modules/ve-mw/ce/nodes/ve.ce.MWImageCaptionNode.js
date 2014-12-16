/*!
 * VisualEditor ContentEditable ListItemNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable image caption item node.
 *
 * @class
 * @extends ve.ce.BranchNode
 * @constructor
 * @param {ve.dm.MWImageCaptionNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.MWImageCaptionNode = function VeCeMWImageCaptionNode( model, config ) {
	// Parent constructor
	ve.ce.BranchNode.call( this, model, config );
};

/* Inheritance */

OO.inheritClass( ve.ce.MWImageCaptionNode, ve.ce.BranchNode );

/* Static Properties */

ve.ce.MWImageCaptionNode.static.name = 'mwImageCaption';

ve.ce.MWImageCaptionNode.static.tagName = 'figcaption';

/* Methods */

/**
 * Reset the magnify button if the structure of the caption changed,
 * so it is always rendered in the right place.
 *
 * The magnify icon will always be attached to the caption; we
 * handle hiding and showing it per block image type in the CSS rules.
 */
ve.ce.MWImageCaptionNode.prototype.onSplice = function () {
	if ( this.$magnify ) {
		this.$magnify.detach();
	} else {
		this.buildMagnify();
	}

	// Parent method
	ve.ce.BranchNode.prototype.onSplice.apply( this, arguments );

	// Reset the magnify icon, prepend it to the caption
	this.$magnify.prependTo( this.$element );
};

/** */
ve.ce.MWImageCaptionNode.prototype.buildMagnify = function () {
	this.$magnify = this.$( '<div>' )
		.addClass( 'magnify' );
	this.$a = this.$( '<a>' )
		.addClass( 'internal' )
		.appendTo( this.$magnify );
};

/* Registration */

ve.ce.nodeFactory.register( ve.ce.MWImageCaptionNode );
