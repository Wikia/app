/*!
 * VisualEditor ContentEditable WikiaBlockMediaNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable Wikia media node.
 * This is an abstract class and as such should not be instantiated directly.
 *
 * @abstract
 * @class
 * @extends ve.ce.BranchNode
 * @mixins ve.ce.ProtectedNode
 * @mixins ve.ce.FocusableNode
 * @mixins ve.ce.RelocatableNode
 * @mixins ve.ce.MWResizableNode
 *
 * @constructor
 * @param {ve.dm.WikiaBlockMediaNode} model Model to observe
 * @param {Object} [config] Config options
 */
ve.ce.WikiaBlockMediaNode = function VeCeWikiaBlockMediaNode( model, config ) {

	// Parent constructor
	ve.ce.BranchNode.call( this, model, config );

	// Properties
	this.$anchor = null;
	this.$image = null;
	this.$magnify = null;
	this.$thumb = null;

	// Initialize
	this.update();

	// Mixin constructors
	ve.ce.ProtectedNode.call( this );
	ve.ce.FocusableNode.call( this );
	ve.ce.RelocatableNode.call( this );
	ve.ce.MWResizableNode.call( this );

	this.$resizable = this.$image;
};

/* Inheritance */

ve.inheritClass( ve.ce.WikiaBlockMediaNode, ve.ce.BranchNode );

ve.mixinClass( ve.ce.WikiaBlockMediaNode, ve.ce.ProtectedNode );

ve.mixinClass( ve.ce.WikiaBlockMediaNode, ve.ce.FocusableNode );

ve.mixinClass( ve.ce.WikiaBlockMediaNode, ve.ce.RelocatableNode );

// Need to mixin base class as well
ve.mixinClass( ve.ce.WikiaBlockMediaNode, ve.ce.ResizableNode );

ve.mixinClass( ve.ce.WikiaBlockMediaNode, ve.ce.MWResizableNode );

/* Static Properties */

ve.ce.WikiaBlockMediaNode.static.name = null;

ve.ce.WikiaBlockMediaNode.static.tagName = 'figure';

ve.ce.WikiaBlockMediaNode.static.renderHtmlAttributes = false;

ve.ce.WikiaBlockMediaNode.static.transition = false;

ve.ce.WikiaBlockMediaNode.static.cssClasses = {
	'default': {
		'left': 'tleft',
		'right': 'tright',
		'center' : 'tnone',
		'none' : 'tnone'
	},
	'none': {
		'left': 'floatleft',
		'right': 'floatright',
		'center' : 'floatnone',
		'none' : 'floatnone'
	}
};

/* Methods */

/**
 * Get the right CSS class to use for alignment
 * @param {string} type 'none' or 'default'
 * @param {string} alignment 'left', 'right', 'center', 'none' or 'default'
 */
ve.ce.WikiaBlockMediaNode.prototype.getCssClass = function ( type, alignment ) {
	// TODO use this.model.getAttribute( 'type' ) etc., see bug 52065
	// Default is different between RTL and LTR wikis:
	if ( type === 'default' && alignment === 'default' ) {
		if ( this.$.css( 'direction' ) === 'rtl' ) {
			return 'tleft';
		} else {
			return 'tright';
		}
	} else {
		return this.constructor.static.cssClasses[ type ][ alignment ];
	}
};

/**
 * Update the view on attribute change.
 *
 * @method
 */
ve.ce.WikiaBlockMediaNode.prototype.onAttributeChange = function () {
	this.update( true );
};

/** */
ve.ce.WikiaBlockMediaNode.prototype.setupSlugs = function () {
	// Intentionally empty
};

/** */
ve.ce.WikiaBlockMediaNode.prototype.onSplice = function () {
	// Intentionally empty
};

/**
 * Builds the anchor element.
 *
 * @method
 * @returns {jQuery} The properly scoped jQuery object
 */
ve.ce.WikiaBlockMediaNode.prototype.getAnchorElement = function () {
	return this.$$( '<a>' )
		// Images and videos both have this class
		.addClass( 'image' )
		.attr( 'href', this.model.getAttribute( 'href' ) );
};

/**
 * Builds the image element.
 *
 * @method
 * @returns {jQuery} The properly scoped jQuery object
 */
ve.ce.WikiaBlockMediaNode.prototype.getImageElement = function () {
	return this.$$( '<img>' )
		.attr( 'src', this.model.getAttribute( 'src' ) )
		.attr( 'width', this.model.getAttribute( 'width' ) )
		.attr( 'height', this.model.getAttribute( 'height' ) );
};

/**
 * Builds the magnify element.
 *
 * @method
 * @returns {jQuery} The properly scoped jQuery object
 */
ve.ce.WikiaBlockMediaNode.prototype.getMagnifyElement = function () {
	// It's inside a protected node, so user can't see href/title.
	return this.$$( '<a>' ).addClass( 'internal sprite details magnify no-shield' );
};

/**
 * Builds the thumb element.
 *
 * @method
 * @returns {jQuery} The properly scoped jQuery object
 */
ve.ce.WikiaBlockMediaNode.prototype.getThumbElement = function () {
	var $thumb,
		align = this.model.getAttribute( 'align' ),
		type = this.model.getAttribute( 'type' );

	if ( type === 'none' ) {
		$thumb = this.$$( '<div>' ).addClass( this.getCssClass( type, align ) );

	// Type "frame" or "thumb"
	} else {
		$thumb = this.$$( '<figure>' )
			.addClass( 'thumb thumbinner ' + this.getCssClass( 'default', align ) )
			.css( 'width', parseInt( this.model.getAttribute( 'width' ), 10 ) + 2 );
	}

	return $thumb;
};

/**
 * Builds the wrapper element.
 *
 * @method
 * @returns {jQuery} The properly scoped jQuery object
 */
ve.ce.WikiaBlockMediaNode.prototype.getWrapperElement = function () {
	return this.$$( '<div>' ).addClass( 'center' );
};

/**
 * Builds the view from scratch.
 *
 * @emits setup
 * @emits teardown
 * @method
 */
ve.ce.WikiaBlockMediaNode.prototype.update = function ( replaceRoot ) {
	var $root, captionModel, captionView,
		type = this.model.getAttribute( 'type' );

	this.$thumb = this.getThumbElement();

	if ( this.model.getAttribute( 'align' ) === 'center' ) {
		$root = this.getWrapperElement().append( this.$thumb );
	} else {
		$root = this.$thumb;
	}

	if ( replaceRoot ) {
		this.emit( 'teardown' );
		this.$.replaceWith( $root );
		this.$ = $root;
		this.emit( 'setup' );
	} else {
		this.$ = $root;
	}

	this.$anchor = this.getAnchorElement().appendTo( this.$thumb );
	this.$image = this.getImageElement().appendTo( this.$anchor );

	if ( type !== 'none' ) {
		this.$magnify = this.getMagnifyElement().appendTo( this.$thumb );

		// Caption
		if ( this.model.children.length === 1 ) {
			captionModel = this.model.children[ 0 ];
			captionView = ve.ce.nodeFactory.create( captionModel.getType(), captionModel );
			captionModel.connect( this, { 'update': 'onModelUpdate' } );
			this.children.push( captionView );
			captionView.attach( this );
			captionView.$.appendTo( this.$thumb );
			if ( this.live !== captionView.isLive() ) {
				captionView.setLive( this.live );
			}
		}
	} else {
		this.$magnify = null;
	}
};
