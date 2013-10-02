/*!
 * VisualEditor ContentEditable MWBlockImageNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable MediaWiki image node.
 *
 * @class
 * @extends ve.ce.BranchNode
 * @mixins ve.ce.ProtectedNode
 * @mixins ve.ce.FocusableNode
 * @mixins ve.ce.RelocatableNode
 * @mixins ve.ce.MWResizableNode
 *
 * @constructor
 * @param {ve.dm.MWBlockImageNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.MWBlockImageNode = function VeCeMWBlockImageNode( model, config ) {
	var captionModel, captionView, type;

	// Parent constructor
	ve.ce.BranchNode.call( this, model, config );

	type = this.model.getAttribute( 'type' );

	if ( this.model.getAttribute( 'align' ) === 'center' ) {
		this.$.addClass( 'center' );
		this.$thumb = this.$$( '<div>' ).appendTo( this.$ );
	} else {
		this.$thumb = this.$;
	}

	this.$thumbInner = this.$$( '<div>' )
		.addClass( 'thumbinner' )
		.css( 'width', parseInt( this.model.getAttribute( 'width' ), 10 ) + 2 );

	this.$a = this.$$( '<a>' )
		.addClass( 'image' )
		.attr( 'src', this.model.getAttribute( 'href' ) );

	this.$image = this.$$( '<img>' )
		.attr( 'src', this.model.getAttribute( 'src' ) )
		.attr( 'width', this.model.getAttribute( 'width' ) )
		.attr( 'height', this.model.getAttribute( 'height' ) )
		.appendTo( this.$a );

	this.$inner = this.$$( '<div>' ).addClass( 've-ce-mwBlockImageNode-inner' );

	if ( type === 'none' || type === 'frameless' ) {
		this.$thumb.addClass(
			this.getCssClass( 'none', this.model.getAttribute( 'align' ) )
		);
		this.$a.appendTo( this.$thumb );

		// For centered images, this.$thumb is full width, so wrap
		// this.$image in another div and use that for selection
		this.$inner
			.append( this.$image )
			.appendTo( this.$a );
	} else {
		// Type "frame", "thumb" and the default
		this.$image.addClass( 'thumbimage' );
		this.$thumb
			.addClass( 'thumb' );
		this.$a.appendTo( this.$thumbInner );
		this.$thumbInner.appendTo( this.$thumb );

		// For centered images, this.$thumb is full width, so wrap
		// this.$thumbInner in another div and use that for selection
		this.$inner
			.append( this.$thumbInner )
			.appendTo( this.$thumb );
	}

	// Mixin constructors
	ve.ce.ProtectedNode.call( this, this.$inner );
	ve.ce.FocusableNode.call( this, this.$inner );
	ve.ce.RelocatableNode.call( this, this.$inner );
	ve.ce.MWResizableNode.call( this, this.$image );

	// I smell a caption!
	if ( type !== 'none' && type !== 'frameless' && this.model.children.length === 1 ) {
		captionModel = this.model.children[0];
		captionView = ve.ce.nodeFactory.create( captionModel.getType(), captionModel );
		captionModel.connect( this, { 'update': 'onModelUpdate' } );
		this.children.push( captionView );
		captionView.attach( this );
		captionView.$.appendTo( this.$thumbInner );
		if ( this.live !== captionView.isLive() ) {
			captionView.setLive( this.live );
		}
	}
};

/* Inheritance */

ve.inheritClass( ve.ce.MWBlockImageNode, ve.ce.BranchNode );

ve.mixinClass( ve.ce.MWBlockImageNode, ve.ce.ProtectedNode );

ve.mixinClass( ve.ce.MWBlockImageNode, ve.ce.FocusableNode );

ve.mixinClass( ve.ce.MWBlockImageNode, ve.ce.RelocatableNode );

// Need to mixin base class as well
ve.mixinClass( ve.ce.MWBlockImageNode, ve.ce.ResizableNode );

ve.mixinClass( ve.ce.MWBlockImageNode, ve.ce.MWResizableNode );

/* Static Properties */

ve.ce.MWBlockImageNode.static.name = 'mwBlockImage';

ve.ce.MWBlockImageNode.static.tagName = 'div';

ve.ce.MWBlockImageNode.static.renderHtmlAttributes = false;

ve.ce.MWBlockImageNode.static.transition = false;

ve.ce.MWBlockImageNode.static.cssClasses = {
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
ve.ce.MWBlockImageNode.prototype.getCssClass = function ( type, alignment ) {
	// TODO use this.model.getAttribute( 'type' ) etc., see bug 52065
	// Default is different between RTL and LTR wikis:
	if ( type === 'default' && alignment === 'default' ) {
		if ( this.$.css( 'direction' ) === 'rtl' ) {
			return 'tleft';
		} else {
			return 'tright';
		}
	} else {
		return this.constructor.static.cssClasses[type][alignment];
	}
};

/**
 * Override the default onSetup to add direction-dependent
 * classes to the image thumbnail.
 *
 * @method
 */
ve.ce.MWBlockImageNode.prototype.onSetup = function ( ) {
	var type = this.model.getAttribute( 'type' );

	ve.ce.BranchNode.prototype.onSetup.call( this );

	if ( type !== 'none' && type !=='frameless' ) {
		this.$thumb.addClass( this.getCssClass( 'default', this.model.getAttribute( 'align' ) ) );
	}

};

/** */
ve.ce.MWBlockImageNode.prototype.onAttributeChange = function ( key, from, to ) {
	var $element, type;

	if ( key === 'height' || key === 'width' ) {
		to = parseInt( to, 10 );
	}

	if ( from !== to ) {
		switch ( key ) {
			case 'align':
				if ( to === 'center' || from === 'center' ) {
					this.emit( 'teardown' );
					if ( to === 'center' ) {
						$element = this.$$( '<div>' ).addClass( 'center' );
						this.$thumb = this.$;
						this.$.replaceWith( $element );
						this.$ = $element;
						this.$.append( this.$thumb );
					} else {
						this.$.replaceWith( this.$thumb );
						this.$ = this.$thumb;
					}
					this.emit( 'setup' );
				}
				type = this.model.getAttribute( 'type' );
				if ( type === 'none' || type === 'frameless' ) {
					this.$thumb.removeClass( this.getCssClass( 'none', from ) );
					this.$thumb.addClass( this.getCssClass( 'none', to ) );
				} else {
					this.$thumb.removeClass( this.getCssClass( 'default', from ) );
					this.$thumb.addClass( this.getCssClass( 'default', to ) );
				}
				break;
			case 'src':
				this.$image.attr( 'src', to );
				break;
			case 'width':
				this.$thumbInner.css( 'width', to + 2 );
				this.$image.css( 'width', to );
				break;
			case 'height':
				this.$image.css( 'height', to );
				break;
		}
	}
};

/** */
ve.ce.MWBlockImageNode.prototype.setupSlugs = function () {
	// Intentionally empty
};

/** */
ve.ce.MWBlockImageNode.prototype.onSplice = function () {
	// Intentionally empty
};

/* Registration */

ve.ce.nodeFactory.register( ve.ce.MWBlockImageNode );
