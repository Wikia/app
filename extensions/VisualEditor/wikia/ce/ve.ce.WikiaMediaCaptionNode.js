/*!
 * VisualEditor ContentEditable WikiaMediaCaptionNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/* global mw: false */

/**
 * ContentEditable Wikia media caption item node.
 *
 * @class
 * @extends ve.ce.BranchNode
 * @constructor
 * @param {ve.ce.WikiaMediaCaptionNode} model Model to observe
 * @param {Object} [config] Config options
 */
ve.ce.WikiaMediaCaptionNode = function VeCeWikiaMediaCaptionNode( model, config ) {
	// Parent constructor
	ve.ce.BranchNode.call( this, model, config );

	// Properties
	this.$attribution = null;

	// DOM changes
	this.$.addClass( 'thumbcaption' );
};

/* Inheritance */

ve.inheritClass( ve.ce.WikiaMediaCaptionNode, ve.ce.BranchNode );

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
	var $attribution, $image, $link,
		attribution = this.model.parent.getAttribute( 'attribution' ),
		href = new mw.Title( attribution.username, 2 ).getUrl();

	$attribution = this.$$( '<div>' )
		.addClass( 'picture-attribution' );

	$image = this.$$( '<img>' )
		.addClass( 'avatar' )
		.attr({
			alt: attribution.username,
			height: 16,
			src: attribution.avatar,
			width: 16
		});

	$link = this.$$( '<a>' )
		.attr( 'href', href )
		.text( attribution.username );

	return $attribution
		.append( $image )
		.append( $.msg( 'oasis-content-picture-added-by', $link[ 0 ].outerHTML ) );
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
		this.$attribution.remove();
		this.$attribution = null;
	}

	// Parent method
	ve.ce.BranchNode.prototype.onSplice.apply( this, arguments );

	// This logic is from the function onThumbnailAfterProduceHTML() in ImageTweaksHooks.class.php
	if (
		parentModel.getAttribute( 'attribution' ) !== undefined &&
		parentModel.getAttribute( 'width' ) >= 102
	) {
		this.$attribution = this.createAttribution().appendTo( this.$ );
	}
};

/* Registration */

ve.ce.nodeFactory.register( ve.ce.WikiaMediaCaptionNode );
