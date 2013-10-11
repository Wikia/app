/*!
 * VisualEditor ContentEditable ListItemNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/*global mw */

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

	// DOM changes
	this.$.addClass( 'thumbcaption' );
};

/* Inheritance */

ve.inheritClass( ve.ce.MWImageCaptionNode, ve.ce.BranchNode );

/* Static Properties */

ve.ce.MWImageCaptionNode.static.name = 'mwImageCaption';

ve.ce.MWImageCaptionNode.static.tagName = 'div';

/* Methods */

/**
 * TODO: Magnify should appear/disappear based on the changes/updates to the parent (switching to
 * and from thumb or frame).
 */
ve.ce.MWImageCaptionNode.prototype.onSplice = function () {
	var parentType = this.model.getParent().getAttribute( 'type' );

	if ( parentType === 'thumb' ) {
		if ( this.$magnify ) {
			this.$magnify.detach();
		} else {
			this.buildMagnify();
		}
	}

	// Parent method
	ve.ce.BranchNode.prototype.onSplice.apply( this, arguments );

	if ( parentType === 'thumb' ) {
		this.$magnify.prependTo( this.$ );
	}
};

/** */
ve.ce.MWImageCaptionNode.prototype.buildMagnify = function () {
	this.$magnify = $( '<div>' )
		.addClass( 'magnify' );
	this.$a = $( '<a>' )
		.addClass( 'internal' )
		// It's inside a protected node, so user can't see href/title anyways.
		//.attr( 'href', '/wiki/File:Wiki.png' )
		//.attr( 'title', 'Enlarge' )
		.appendTo( this.$magnify );
	this.$img = $( '<img>' )
		.attr( 'src', mw.config.get( 'wgVisualEditor' ).magnifyClipIconURL )
		.attr( 'width', 15 )
		.attr( 'height', 11 )
		//.attr( 'alt', '' )
		.appendTo( this.$a );
};

/* Registration */

ve.ce.nodeFactory.register( ve.ce.MWImageCaptionNode );
