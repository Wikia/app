/*!
 * VisualEditor ContentEditable WikiaBlockMediaNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * VisualEditor ContentEditable Wikia media node.
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

	// Mixin constructors
	ve.ce.ProtectedNode.call( this );
	ve.ce.FocusableNode.call( this );
	ve.ce.RelocatableNode.call( this );
	ve.ce.MWResizableNode.call( this );

	// Initialize
	this.update();
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
 * Builds the anchor element.
 *
 * @method
 * @returns {jQuery} The properly scoped jQuery object
 */
ve.ce.WikiaBlockMediaNode.prototype.createAnchor = function () {
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
ve.ce.WikiaBlockMediaNode.prototype.createImage = function () {
	return this.$$( '<img>' )
		.attr( 'src', this.model.getAttribute( 'src' ) )
		.attr( 'height', this.model.getAttribute( 'height' ) )
		.attr( 'width', this.model.getAttribute( 'width' ) );
};

/**
 * Builds the magnify element.
 *
 * @method
 * @returns {jQuery} The properly scoped jQuery object
 */
ve.ce.WikiaBlockMediaNode.prototype.createMagnify = function () {
	// It's inside a protected node, so user can't see href/title.
	return this.$$( '<a>' ).addClass( 'internal sprite details magnify ve-no-shield' );
};

/**
 * Builds the root wrapping element.
 *
 * @method
 * @returns {jQuery} The properly scoped jQuery object
 */
ve.ce.WikiaBlockMediaNode.prototype.createRoot = function () {
	return this.$$( '<div>' ).addClass( 'center' );
};

/**
 * Builds the thumb element.
 *
 * @method
 * @returns {jQuery} The properly scoped jQuery object
 */
ve.ce.WikiaBlockMediaNode.prototype.createThumb = function () {
	var $thumb,
		align = this.model.getAttribute( 'align' ),
		type = this.model.getAttribute( 'type' );

	if ( type === 'frameless' || type === 'none' ) {
		$thumb = this.$$( '<div>' ).addClass( this.getCssClass( 'none', align ) );

	// Type "frame" or "thumb"
	} else {
		$thumb = this.$$( '<figure>' )
			.addClass( 'thumb thumbinner ' + this.getCssClass( 'default', align ) )
			.css( 'width', parseInt( this.model.getAttribute( 'width' ), 10 ) + 2 );
	}

	return $thumb;
};

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
	this.update();
};

/**
 * Intentionally empty
 *
 * @method
 */
ve.ce.WikiaBlockMediaNode.prototype.setupSlugs = function () {};

/**
 * Intentionally empty
 *
 * @method
 */
ve.ce.WikiaBlockMediaNode.prototype.onSplice = function () {};

/**
 * Creates and updates the view.
 *
 * @description
 *
 * Update is called on initialization and any time an attribute changes. If the
 * replaceRoot parameter is provided, the root jQuery object (this.$) will be
 * replaced with an updated version instead of just being a pointer to it.
 * References to the old jQuery objects will need to be updated at this point
 * so as not to break mixins.
 *
 * @emits setup
 * @emits teardown
 *
 * @method
 */
ve.ce.WikiaBlockMediaNode.prototype.update = function () {
	var $anchor, $image, $root, $thumb, captionModel, captionView,
		type = this.model.getAttribute( 'type' );

	$thumb = this.createThumb();
	if ( this.model.getAttribute( 'align' ) === 'center' ) {
		$root = this.createRoot().append( $thumb );
	} else {
		$root = $thumb;
	}
	this.emit( 'teardown' );
	this.$.replaceWith( $root );
	this.$ = $root;

	$anchor = this.createAnchor().appendTo( $thumb );
	$image = this.createImage().appendTo( $anchor );

	// Magnifying glass icon
	if ( type !== 'frameless' && type !== 'none' ) {
		$thumb.append( this.createMagnify() );
	}

	// Caption
	if ( this.model.children.length === 1 ) {
		captionModel = this.model.children[ 0 ];
		captionView = ve.ce.nodeFactory.create( captionModel.getType(), captionModel );
		captionModel.connect( this, { 'update': 'onModelUpdate' } );
		this.children.push( captionView );
		captionView.attach( this );
		captionView.$.appendTo( $thumb );

		if ( this.live !== captionView.isLive() ) {
			captionView.setLive( this.live );
		}
	}

	// Update references for mixins
	this.$focusable = this.$;
	this.$phantomable = this.$;
	this.$relocatable = this.$;
	this.$image = $image;
	this.$resizable = $image;

	// This should be called last so the listeners will get the same DOM
	// structure and jQuery object references they do on initialization.
	this.emit( 'setup' );
};
