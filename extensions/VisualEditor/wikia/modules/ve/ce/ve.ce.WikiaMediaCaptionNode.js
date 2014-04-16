/*!
 * VisualEditor ContentEditable WikiaMediaCaptionNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/* global mw: false */

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

	// Properties
	this.$attribution = null;
	this.$details = null;

	// The minimum allowable width for the attribution to be displayed
	this.minWidth = 102;

	// Parent constructor
	ve.ce.BranchNode.call( this, model, config );
};

/* Inheritance */

OO.inheritClass( ve.ce.WikiaMediaCaptionNode, ve.ce.BranchNode );

/* Static Properties */

ve.ce.WikiaMediaCaptionNode.static.name = 'wikiaMediaCaption';

ve.ce.WikiaMediaCaptionNode.static.tagName = 'figcaption';

/* Methods */

/**
 * Creates and returns a jQuery object for media attribution.
 *
 * @method
 * @returns {jQuery}
 */
ve.ce.WikiaMediaCaptionNode.prototype.createAttribution = function () {
	var $attribution, $link,
		attribution = this.model.parent.getAttribute( 'attribution' ),
		href = new mw.Title( attribution.username, 2 ).getUrl();

	$attribution = this.$( '<p>' )
		.addClass( 'attribution' );

	$link = this.$( '<a>' )
		.attr( 'href', href )
		.text( attribution.username );

	return $attribution
		.append( mw.message( 'oasis-content-picture-added-by', $link[ 0 ].outerHTML ).plain() );
};

/**
 * Builds the file page link element.
 *
 * @method
 * @returns {jQuery} The properly scoped jQuery object
 */
ve.ce.WikiaMediaCaptionNode.prototype.createDetails = function () {
	// It's inside a protected node, so user can't see href/title.
	return this.$( '<a>' ).addClass( 'sprite details ve-no-shield' );
};

/**
 * Handle splices
 * TODO: move attribution somewhere else?
 *
 * @method
 */
ve.ce.WikiaMediaCaptionNode.prototype.onSplice = function () {
	var parentModel = this.model.parent;

	if ( this.$attribution ) {
		this.$attribution.detach();
	} else {
		this.$attribution = this.createAttribution();
	}

	this.$details = this.createDetails();

	// Parent method
	ve.ce.BranchNode.prototype.onSplice.apply( this, arguments );

	// The details link isn't visible until hover on article pages, so in VE it will just be invisible.
	// It will still take up space though, so long titles will wrap around it as they do on article pages.
	this.$details.prependTo( this.$element )
		// add class to caption itself
		.next( 'p' ).addClass( 'caption' );

	// This logic is from the function onThumbnailAfterProduceHTML() in ImageTweaksHooks.class.php
	if (
		parentModel.getAttribute( 'attribution' ) !== undefined &&
		parentModel.getAttribute( 'width' ) >= this.minWidth
	) {
		this.$attribution.appendTo( this.$element );
	}
};

/* Registration */

ve.ce.nodeFactory.register( ve.ce.WikiaMediaCaptionNode );
