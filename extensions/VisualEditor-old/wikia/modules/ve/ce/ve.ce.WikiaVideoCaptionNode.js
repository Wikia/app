/*!
 * VisualEditor ContentEditable WikiaVideoCaptionNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/* global mw */

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

	// Properties - needed for onSplice method that is called when parent constructor is called
	this.$title = null;

	// Parent constructor
	ve.ce.WikiaVideoCaptionNode.super.call( this, model, config );
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
	var title = new mw.Title( this.model.getParent().getFilename() );
	// It's inside a protected node, so user can't see href/title.
	return this.$( '<p>' )
		.addClass( 'title ve-no-shield' )
		.text( title.getNameText() );
};

/**
 * Handle splices
 *
 * @method
 */
ve.ce.WikiaVideoCaptionNode.prototype.onSplice = function () {
	// Parent method
	ve.ce.WikiaMediaCaptionNode.prototype.onSplice.apply( this, arguments );

	if ( !this.$title ) {
		this.$title = this.createTitle();
	}
	// insert title before caption
	if ( this.children.length ) {
		this.children[0].$element.before( this.$title );
	}
};

/* Registration */

ve.ce.nodeFactory.register( ve.ce.WikiaVideoCaptionNode );
